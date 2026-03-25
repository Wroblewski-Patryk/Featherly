<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PublicationCalendarTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_publication_calendar_lists_only_planned_content_items(): void
    {
        Page::factory()->create([
            'title' => ['pl' => 'Page Planned', 'en' => 'Page Planned'],
            'status' => 'planned',
            'published_at' => now()->addDay(),
        ]);

        Post::factory()->create([
            'title' => ['pl' => 'Post Planned', 'en' => 'Post Planned'],
            'status' => 'planned',
            'published_at' => now()->addDays(2),
        ]);

        Project::factory()->create([
            'title' => ['pl' => 'Project Planned', 'en' => 'Project Planned'],
            'status' => 'planned',
            'published_at' => now()->addDays(2)->addHour(),
        ]);

        Page::factory()->create([
            'title' => ['pl' => 'Page Draft', 'en' => 'Page Draft'],
            'status' => 'draft',
            'published_at' => now()->addDays(3),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.publication-calendar'));

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/PublicationCalendar')
            ->where('totals.items', 3)
            ->where('totals.days', 2)
            ->where('totals.types.page', 1)
            ->where('totals.types.post', 1)
            ->where('totals.types.project', 1)
        );
    }
}
