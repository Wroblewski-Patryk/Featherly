<?php

namespace Tests\Feature;

use App\Models\ApiToken;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeadlessContentExportTokenScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_headless_export_requires_scoped_bearer_token(): void
    {
        $response = $this->getJson(route('headless.content-export', [
            'type' => 'page',
        ]));

        $response
            ->assertStatus(401)
            ->assertJsonPath('success', false);
    }

    public function test_headless_export_accepts_token_with_headless_read_scope(): void
    {
        Page::factory()->create([
            'title' => ['pl' => 'Tytul', 'en' => 'Title'],
            'slug' => ['pl' => 'tytul', 'en' => 'title'],
            'status' => 'published',
            'published_at' => now()->subMinute(),
        ]);

        $plainToken = 'headless-read-token';
        ApiToken::create([
            'name' => 'Headless Read',
            'token_hash' => hash('sha256', $plainToken),
            'scopes' => ['headless:read'],
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $plainToken,
        ])->getJson(route('headless.content-export', [
            'type' => 'page',
            'status' => 'published',
            'locale' => 'en',
        ]));

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('export.type', 'page')
            ->assertJsonPath('export.items.0.title', 'Title');

        $this->assertDatabaseHas('api_tokens', [
            'name' => 'Headless Read',
        ]);
    }

    public function test_headless_export_rejects_token_without_required_scope(): void
    {
        $plainToken = 'wrong-scope-token';
        ApiToken::create([
            'name' => 'Wrong Scope',
            'token_hash' => hash('sha256', $plainToken),
            'scopes' => ['other:scope'],
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $plainToken,
        ])->getJson(route('headless.content-export', [
            'type' => 'page',
        ]));

        $response
            ->assertStatus(403)
            ->assertJsonPath('success', false);
    }
}
