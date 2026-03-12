<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Project::create([
            'title' => [
                'pl' => 'Portal E-commerce',
                'en' => 'E-commerce Portal'
            ],
            'slug' => [
                'pl' => 'portal-ecommerce',
                'en' => 'ecommerce-portal'
            ],
            'description' => [
                'pl' => 'Nowoczesny portal sprzedażowy dla branży modowej.',
                'en' => 'Modern sales portal for the fashion industry.'
            ],
            'status' => 'published',
            'content' => [
                [
                    'id' => 'block_' . \Illuminate\Support\Str::random(9),
                    'type' => 'text',
                    'content' => [
                        'text' => '<h2>Szczegóły projektu</h2><p>To jest opis po polsku.</p>',
                    ],
                    'appearance' => [
                        'paddingTop' => '2rem',
                        'paddingBottom' => '2rem',
                    ]
                ]
            ]
        ]);

        \App\Models\Project::create([
            'title' => [
                'pl' => 'Aplikacja Mobilna Fitness',
                'en' => 'Fitness Mobile App'
            ],
            'slug' => [
                'pl' => 'aplikacja-fitness',
                'en' => 'fitness-app'
            ],
            'description' => [
                'pl' => 'Aplikacja do śledzenia treningów i diety.',
                'en' => 'App for tracking workouts and diet.'
            ],
            'status' => 'published',
            'content' => [
                [
                    'id' => 'block_' . \Illuminate\Support\Str::random(9),
                    'type' => 'hero',
                    'content' => [
                        'headline' => 'Trenuj mądrzej',
                        'subheadline' => 'Wszystko w Twoim telefonie.',
                    ],
                    'appearance' => [
                        'paddingTop' => '4rem',
                        'paddingBottom' => '4rem',
                    ]
                ]
            ]
        ]);
    }
}
