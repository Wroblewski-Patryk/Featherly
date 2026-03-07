<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        $tables = ['pages', 'posts', 'projects', 'forms'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $tableGroup) use ($table) {
                if (!Schema::hasColumn($table, 'status')) {
                    $tableGroup->string('status')->default('draft')->after('id');
                }
                if (!Schema::hasColumn($table, 'published_at')) {
                    $tableGroup->timestamp('published_at')->nullable()->after('updated_at');
                }
                if (!Schema::hasColumn($table, 'archived_at')) {
                    $tableGroup->timestamp('archived_at')->nullable()->after('published_at');
                }
                if ($table === 'projects' && !Schema::hasColumn($table, 'is_published')) {
                    $tableGroup->boolean('is_published')->default(false)->after('status');
                }
            });
        }
    }

    public function down(): void
    {
        $tables = ['pages', 'posts', 'projects', 'forms'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $tableGroup) use ($table) {
                $columns = ['status', 'published_at', 'archived_at'];
                if ($table === 'projects') {
                    $columns[] = 'is_published';
                }

                // Drop columns if they were added by this migration
                // Note: Better to drop them safely
                foreach ($columns as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        $tableGroup->dropColumn($column);
                    }
                }
            });
        }
    }
};
