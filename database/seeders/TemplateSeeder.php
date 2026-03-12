<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Template::create([
            'title' => [
                'pl' => 'Główny Nagłówek',
                'en' => 'Main Header'
            ],
            'type' => 'header',
            'is_active' => true,
            'is_default' => true,
            'content' => [
                [
                    'id' => 'block_' . \Illuminate\Support\Str::random(9),
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

        \App\Models\Template::create([
            'title' => [
                'pl' => 'Główna Stopka',
                'en' => 'Main Footer'
            ],
            'type' => 'footer',
            'is_active' => true,
            'is_default' => true,
            'content' => [
                [
                    'id' => 'block_' . \Illuminate\Support\Str::random(9),
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
    }
}
