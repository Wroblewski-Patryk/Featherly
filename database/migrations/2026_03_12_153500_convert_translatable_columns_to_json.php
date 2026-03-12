<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $configs = [
            'pages' => ['title', 'slug', 'meta_title', 'meta_description', 'og_image'],
            'posts' => ['title', 'slug', 'excerpt', 'meta_title', 'meta_description', 'og_image'],
            'projects' => ['title', 'slug', 'description', 'meta_title', 'meta_description', 'og_image'],
            'forms' => ['title'],
            'templates' => ['title', 'meta_title', 'meta_description', 'og_image'],
        ];

        foreach ($configs as $table => $columns) {
            if (!DB::getSchemaBuilder()->hasTable($table)) {
                continue;
            }

            DB::table($table)->orderBy('id')->chunk(100, function ($rows) use ($table, $columns) {
                foreach ($rows as $row) {
                    $updates = [];
                    foreach ($columns as $column) {
                        if (!isset($row->$column) || empty($row->$column)) {
                            continue;
                        }

                        $value = $row->$column;
                        
                        // Check if it's already a localized JSON object
                        $decoded = json_decode($value, true);
                        
                        // If it's not an array, or it's an array but doesn't look like Spatie Translatable format (keys aren't language codes)
                        // Actually, the simplest check: if it doesn't decode to an array, it's definitely a raw string.
                        // If it decodes to an array, we assume it's already in the correct format (or at least partially).
                        if (!is_array($decoded)) {
                            $updates[$column] = json_encode(['pl' => $value]);
                        }
                    }

                    if (!empty($updates)) {
                        DB::table($table)->where('id', $row->id)->update($updates);
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No simple way to reverse this without potential data loss for non-PL languages.
    }
};
