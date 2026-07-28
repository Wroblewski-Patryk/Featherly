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
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique(['slug']);
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "projects" ALTER COLUMN "slug" DROP NOT NULL');
            DB::statement('ALTER TABLE "projects" ALTER COLUMN "slug" TYPE JSON USING CASE WHEN "slug" IS NULL THEN NULL ELSE json_build_object(\'pl\', "slug") END');
        } else {
            Schema::table('projects', function (Blueprint $table) {
                $table->json('slug')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE "projects" ALTER COLUMN "slug" TYPE VARCHAR(255) USING COALESCE("slug"->>\'pl\', "slug"::text)');

            Schema::table('projects', function (Blueprint $table) {
                $table->unique('slug');
            });
        } else {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('slug')->unique()->change();
            });
        }
    }
};
