<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $publishableTables = ['pages', 'posts', 'projects', 'forms'];

        foreach ($publishableTables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                $blueprint->index(['status', 'published_at'], "{$table}_status_published_at_idx");
            });
        }

        Schema::table('form_submissions', function (Blueprint $table) {
            $table->index(['form_id', 'created_at'], 'form_submissions_form_id_created_at_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $publishableTables = ['pages', 'posts', 'projects', 'forms'];

        foreach ($publishableTables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                $blueprint->dropIndex("{$table}_status_published_at_idx");
            });
        }

        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropIndex('form_submissions_form_id_created_at_idx');
        });
    }
};
