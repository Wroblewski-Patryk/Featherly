<?php

namespace Tests\Feature\Admin;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
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

    public function test_admin_media_index_supports_cursor_pagination_for_json_requests(): void
    {
        Media::unguarded(function () {
            for ($i = 0; $i < 6; $i++) {
                Media::create([
                    'path' => "media/cursor-{$i}.jpg",
                    'mime' => 'image/jpeg',
                    'size' => 3000 + $i,
                    'alt_text' => "cursor-{$i}",
                    'folder_id' => null,
                    'created_at' => now()->subSeconds($i),
                    'updated_at' => now()->subSeconds($i),
                ]);
            }
        });

        $firstPageResponse = $this->actingAs($this->admin)->getJson(route('admin.media.index', [
            'pagination' => 'cursor',
            'per_page' => 2,
            'sort' => 'created_at',
            'direction' => 'desc',
        ]));

        $firstPageResponse
            ->assertOk()
            ->assertJsonPath('media.per_page', 2)
            ->assertJsonCount(2, 'media.data');

        $nextCursor = $firstPageResponse->json('media.next_cursor');
        $this->assertNotNull($nextCursor);

        $secondPageResponse = $this->actingAs($this->admin)->getJson(route('admin.media.index', [
            'pagination' => 'cursor',
            'per_page' => 2,
            'sort' => 'created_at',
            'direction' => 'desc',
            'cursor' => $nextCursor,
        ]));

        $secondPageResponse
            ->assertOk()
            ->assertJsonPath('media.per_page', 2)
            ->assertJsonCount(2, 'media.data');

        $this->assertNotEquals(
            $firstPageResponse->json('media.data.0.id'),
            $secondPageResponse->json('media.data.0.id')
        );
    }

    public function test_upload_marks_duplicate_media_by_checksum_without_deleting_assets(): void
    {
        Storage::fake('public');

        $firstFile = UploadedFile::fake()->createWithContent('duplicate-1.jpg', 'same-binary-content');
        $secondFile = UploadedFile::fake()->createWithContent('duplicate-2.jpg', 'same-binary-content');

        $this->actingAs($this->admin)->post(route('admin.media.store'), [
            'files' => [$firstFile],
        ])->assertRedirect();

        $this->actingAs($this->admin)->post(route('admin.media.store'), [
            'files' => [$secondFile],
        ])->assertRedirect();

        $media = Media::orderBy('id')->get();

        $this->assertCount(2, $media);
        $this->assertNotNull($media[0]->checksum);
        $this->assertSame($media[0]->checksum, $media[1]->checksum);
        $this->assertSame($media[0]->id, $media[1]->duplicate_of_id);
    }
}
