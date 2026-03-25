<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentExportEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_export_endpoint_returns_paginated_localized_content(): void
    {
        Page::factory()->create([
            'title' => ['pl' => 'Tytul A', 'en' => 'Title A'],
            'slug' => ['pl' => 'tytul-a', 'en' => 'title-a'],
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        Page::factory()->create([
            'title' => ['pl' => 'Tytul B', 'en' => 'Title B'],
            'slug' => ['pl' => 'tytul-b', 'en' => 'title-b'],
            'status' => 'published',
            'published_at' => now()->subHours(2),
        ]);

        Page::factory()->create([
            'title' => ['pl' => 'Szkic', 'en' => 'Draft'],
            'slug' => ['pl' => 'szkic', 'en' => 'draft'],
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)->getJson(route('admin.content-export', [
            'type' => 'page',
            'status' => 'published',
            'locale' => 'en',
            'per_page' => 2,
        ]));

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('export.type', 'page')
            ->assertJsonPath('export.status', 'published')
            ->assertJsonPath('export.locale', 'en')
            ->assertJsonPath('export.meta.total', 2)
            ->assertJsonPath('export.meta.per_page', 2)
            ->assertJsonCount(2, 'export.items')
            ->assertJsonPath('export.items.0.title', 'Title B')
            ->assertJsonPath('export.items.1.title', 'Title A');
    }

    public function test_export_endpoint_requires_valid_type_parameter(): void
    {
        $response = $this->actingAs($this->admin)->getJson(route('admin.content-export', [
            'type' => 'unknown',
        ]));

        $response->assertStatus(422);
    }
}
