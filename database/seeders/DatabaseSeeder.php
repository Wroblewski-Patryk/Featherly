<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        User::firstOrCreate(
        ['email' => 'admin@admin.com'],
        [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]
        );

        // 2. Create Default Home Page
        $homePage = Page::create(
        [
            'slug' => ['en' => 'home', 'pl' => 'home'],
            'title' => ['en' => 'Home', 'pl' => 'Strona Główna'],
            'is_published' => true,
            'content' => [
                [
                    'id' => 'block_' . Str::random(9),
                    'type' => 'hero',
                    'content' => [
                        'headline' => 'Welcome to our New Website',
                        'subheadline' => 'This page is powered by our pure Vue 3 Block Builder',
                    ],
                    'appearance' => [
                        'backgroundColor' => 'transparent',
                        'textColor' => 'inherit',
                        'paddingTop' => '4rem',
                        'paddingBottom' => '4rem',
                    ]
                ],
                [
                    'id' => 'block_' . Str::random(9),
                    'type' => 'text',
                    'content' => [
                        'text' => '<h2>Start building your amazing site</h2><p>Go to the admin panel to edit this page and add more blocks.</p>',
                    ],
                    'appearance' => [
                        'backgroundColor' => 'transparent',
                        'textColor' => 'inherit',
                        'paddingTop' => '2rem',
                        'paddingBottom' => '2rem',
                    ]
                ]
            ]
        ]
        );

        // 3. Create Default Settings
        $settings = Setting::create(
        [
            'key' => 'general',
            'value' => [
                'home_page_id' => $homePage->id,
                'blog_page_id' => null,
                'default_header_id' => null,
                'default_footer_id' => null,
                'brand_colors' => [
                    'primary' => '#4f46e5',
                    'secondary' => '#10b981',
                    'accent' => '#f59e0b',
                ],
                'brand_fonts' => [
                    'heading' => 'Titillium Web',
                    'body' => 'sans-serif',
                ]
            ]
        ]
        );
    }
}
