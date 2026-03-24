<?php

namespace Tests\Feature\Admin;

use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_media_index_uses_default_per_page_for_json_requests(): void
    {
        Media::unguarded(function () {
            for ($i = 0; $i < 45; $i++) {
                Media::create([
                    'path' => "media/test-{$i}.jpg",
                    'mime' => 'image/jpeg',
                    'size' => 1024 + $i,
                    'alt_text' => "image-{$i}",
                    'folder_id' => null,
                ]);
            }
        });

        $response = $this->actingAs($this->admin)->getJson(route('admin.media.index'));

        $response
            ->assertOk()
            ->assertJsonPath('media.per_page', 40)
            ->assertJsonPath('media.total', 45)
            ->assertJsonCount(40, 'media.data');
    }

    public function test_admin_media_index_caps_per_page_value(): void
    {
        Media::unguarded(function () {
            for ($i = 0; $i < 150; $i++) {
                Media::create([
                    'path' => "media/capped-{$i}.jpg",
                    'mime' => 'image/jpeg',
                    'size' => 2048 + $i,
                    'alt_text' => "cap-{$i}",
                    'folder_id' => null,
                ]);
            }
        });

        $response = $this->actingAs($this->admin)->getJson(route('admin.media.index', ['per_page' => 999]));

        $response
            ->assertOk()
            ->assertJsonPath('media.per_page', 120)
            ->assertJsonPath('media.total', 150)
            ->assertJsonCount(120, 'media.data');
    }
}
