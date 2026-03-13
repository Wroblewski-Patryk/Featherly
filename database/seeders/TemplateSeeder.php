<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Header Template
        \App\Models\Template::create([
            'title' => [
                'pl' => 'Główny Nagłówek',
                'en' => 'Main Header'
            ],
            'type' => 'header',
            'is_active' => true,
            'is_default' => true,
            'is_system' => true,
            'content' => [
                [
                    'id' => 'block_' . Str::random(9),
                    'type' => 'navbar',
                    'content' => [
                        'logo' => null,
                        'menu_id' => null,
                    ],
                    'appearance' => [
                        'backgroundColor' => '#ffffff',
                        'sticky' => true,
                    ]
                ]
            ]
        ]);

        // 2. Footer Template
        \App\Models\Template::create([
            'title' => [
                'pl' => 'Główna Stopka',
                'en' => 'Main Footer'
            ],
            'type' => 'footer',
            'is_active' => true,
            'is_default' => true,
            'is_system' => true,
            'content' => [
                [
                    'id' => 'block_' . Str::random(9),
                    'type' => 'footer_standard',
                    'content' => [
                        'copyright' => '© 2024 Featherly CMS',
                    ],
                    'appearance' => [
                        'backgroundColor' => '#1f2937',
                        'textColor' => '#ffffff',
                    ]
                ]
            ]
        ]);

        // 3. Default Page Template (The "Master" Page Layout)
        \App\Models\Template::create([
            'title' => [
                'pl' => 'Główny Szablon Strony',
                'en' => 'Main Page Template'
            ],
            'type' => 'page',
            'is_active' => true,
            'is_default' => true,
            'is_system' => true,
            'content' => [
                [
                    'id' => 'slot_header_' . Str::random(9),
                    'type' => 'header_slot',
                    'content' => [],
                    'appearance' => []
                ],
                [
                    'id' => 'slot_content_' . Str::random(9),
                    'type' => 'content_slot',
                    'content' => [],
                    'appearance' => [
                        'paddingTop' => '2rem',
                        'paddingBottom' => '2rem',
                        'container' => true
                    ]
                ],
                [
                    'id' => 'slot_footer_' . Str::random(9),
                    'type' => 'footer_slot',
                    'content' => [],
                    'appearance' => []
                ]
            ]
        ]);
    }
}
