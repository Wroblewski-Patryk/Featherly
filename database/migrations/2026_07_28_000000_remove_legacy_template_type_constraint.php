<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "templates" DROP CONSTRAINT IF EXISTS "templates_type_check"');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE \"templates\" ADD CONSTRAINT \"templates_type_check\" CHECK (\"type\" IN ('header', 'footer'))");
        }
    }
};
