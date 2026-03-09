<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        return [
            'title' => ['pl' => $title, 'en' => $title],
            'slug' => \Illuminate\Support\Str::slug($title),
            'content' => ['pl' => fake()->paragraphs(3, true), 'en' => fake()->paragraphs(3, true)],
            'excerpt' => ['pl' => fake()->sentence(), 'en' => fake()->sentence()],
            'status' => 'published',
            'published_at' => now(),
        ];
    }
}
