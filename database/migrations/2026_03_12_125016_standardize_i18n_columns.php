<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "templates" ALTER COLUMN "title" TYPE JSON USING json_build_object(\'pl\', "title")');
            DB::statement('ALTER TABLE "forms" ALTER COLUMN "title" TYPE JSON USING json_build_object(\'pl\', "title")');
        } else {
            Schema::table('templates', function (Blueprint $table) {
                $table->json('title')->change();
            });

            Schema::table('forms', function (Blueprint $table) {
                $table->json('title')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "forms" ALTER COLUMN "title" TYPE VARCHAR(255) USING COALESCE("title"->>\'pl\', "title"::text)');
            DB::statement('ALTER TABLE "templates" ALTER COLUMN "title" TYPE VARCHAR(255) USING COALESCE("title"->>\'pl\', "title"::text)');
        } else {
            Schema::table('forms', function (Blueprint $table) {
                $table->string('title')->change();
            });

            Schema::table('templates', function (Blueprint $table) {
                $table->string('title')->change();
            });
        }

        Schema::table('templates', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
        });
    }
};
