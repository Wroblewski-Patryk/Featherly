<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
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
            'slug' => ['pl' => \Illuminate\Support\Str::slug($title), 'en' => \Illuminate\Support\Str::slug($title)],
            'content' => [
                [
                    'id' => \Illuminate\Support\Str::uuid()->toString(),
                    'type' => 'heading',
                    'content' => ['text' => $title, 'level' => 1]
                ],
                [
                    'id' => \Illuminate\Support\Str::uuid()->toString(),
                    'type' => 'paragraph',
                    'content' => ['text' => fake()->paragraph()]
                ]
            ],
            'is_published' => true,
            'settings' => [],
        ];
    }
}
