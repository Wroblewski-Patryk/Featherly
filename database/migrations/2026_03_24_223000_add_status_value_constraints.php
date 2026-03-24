<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['pages', 'posts', 'projects', 'forms'];
    private array $allowed = ['draft', 'planned', 'published', 'archived'];

    public function up(): void
    {
        $driver = DB::getDriverName();

        foreach ($this->tables as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'status')) {
                continue;
            }

            if ($driver === 'sqlite') {
                $this->createSqliteTriggers($table);
                continue;
            }

            $constraint = "{$table}_status_chk";
            $allowed = "'" . implode("','", $this->allowed) . "'";
            $tableExpr = $driver === 'pgsql' ? "\"{$table}\"" : "`{$table}`";

            try {
                DB::statement("ALTER TABLE {$tableExpr} ADD CONSTRAINT {$constraint} CHECK (status IN ({$allowed}))");
            } catch (\Throwable) {
                // Constraint may already exist or be unsupported by the target engine.
            }
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        foreach ($this->tables as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'status')) {
                continue;
            }

            if ($driver === 'sqlite') {
                DB::statement("DROP TRIGGER IF EXISTS {$table}_status_insert_chk");
                DB::statement("DROP TRIGGER IF EXISTS {$table}_status_update_chk");
                continue;
            }

            $constraint = "{$table}_status_chk";
            $tableExpr = $driver === 'pgsql' ? "\"{$table}\"" : "`{$table}`";

            try {
                if ($driver === 'pgsql') {
                    DB::statement("ALTER TABLE {$tableExpr} DROP CONSTRAINT IF EXISTS {$constraint}");
                } else {
                    DB::statement("ALTER TABLE {$tableExpr} DROP CHECK {$constraint}");
                }
            } catch (\Throwable) {
                // No-op if missing or unsupported.
            }
        }
    }

    private function createSqliteTriggers(string $table): void
    {
        $allowed = "'" . implode("','", $this->allowed) . "'";

        DB::statement("DROP TRIGGER IF EXISTS {$table}_status_insert_chk");
        DB::statement("DROP TRIGGER IF EXISTS {$table}_status_update_chk");

        DB::statement("
            CREATE TRIGGER {$table}_status_insert_chk
            BEFORE INSERT ON {$table}
            FOR EACH ROW
            WHEN NEW.status IS NOT NULL AND NEW.status NOT IN ({$allowed})
            BEGIN
                SELECT RAISE(ABORT, 'Invalid status value');
            END
        ");

        DB::statement("
            CREATE TRIGGER {$table}_status_update_chk
            BEFORE UPDATE OF status ON {$table}
            FOR EACH ROW
            WHEN NEW.status IS NOT NULL AND NEW.status NOT IN ({$allowed})
            BEGIN
                SELECT RAISE(ABORT, 'Invalid status value');
            END
        ");
    }
};
