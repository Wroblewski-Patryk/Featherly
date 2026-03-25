<?php

namespace Tests\Unit;

use App\Models\Language;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Setting;
use App\Services\SeoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoServiceHreflangTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_builds_post_hreflang_urls_with_localized_archive_prefixes(): void
    {
        Language::query()->create(['code' => 'en', 'name' => 'English', 'is_default' => false, 'is_active' => true]);
        Language::query()->create(['code' => 'pl', 'name' => 'Polski', 'is_default' => true, 'is_active' => true]);

        $blogPage = Page::factory()->create([
            'slug' => ['en' => 'blog', 'pl' => 'aktualnosci'],
        ]);

        Setting::query()->create(['key' => 'blog_page_id', 'value' => $blogPage->id]);

        $post = Post::factory()->create([
            'slug' => ['en' => 'launch-notes', 'pl' => 'premiera-notatki'],
        ]);

        $alternates = app(SeoService::class)->getMetaData($post)['alternate_locales'];

        $this->assertSame(url('/en/blog/launch-notes'), $alternates['en']);
        $this->assertSame(url('/pl/aktualnosci/premiera-notatki'), $alternates['pl']);
        $this->assertSame(url('/pl/aktualnosci/premiera-notatki'), $alternates['x-default']);
    }

    public function test_it_builds_project_hreflang_urls_with_nested_archive_segments(): void
    {
        Language::query()->create(['code' => 'en', 'name' => 'English', 'is_default' => true, 'is_active' => true]);
        Language::query()->create(['code' => 'de', 'name' => 'Deutsch', 'is_default' => false, 'is_active' => true]);

        $projectsPage = Page::factory()->create([
            'slug' => ['en' => 'work/projects', 'de' => 'arbeiten/projekte'],
        ]);

        Setting::query()->create(['key' => 'projects_page_id', 'value' => $projectsPage->id]);

        $project = Project::factory()->create([
            'slug' => ['en' => 'platform-redesign', 'de' => 'plattform-redesign'],
        ]);

        $alternates = app(SeoService::class)->getMetaData($project)['alternate_locales'];

        $this->assertSame(url('/en/work/projects/platform-redesign'), $alternates['en']);
        $this->assertSame(url('/de/arbeiten/projekte/plattform-redesign'), $alternates['de']);
        $this->assertSame(url('/en/work/projects/platform-redesign'), $alternates['x-default']);
    }

    public function test_it_keeps_nested_page_slug_shape_in_hreflang_urls(): void
    {
        Language::query()->create(['code' => 'en', 'name' => 'English', 'is_default' => true, 'is_active' => true]);
        Language::query()->create(['code' => 'pl', 'name' => 'Polski', 'is_default' => false, 'is_active' => true]);

        $page = Page::factory()->create([
            'slug' => ['en' => 'company/about/team', 'pl' => 'firma/o-nas/zespol'],
        ]);

        $alternates = app(SeoService::class)->getMetaData($page)['alternate_locales'];

        $this->assertSame(url('/en/company/about/team'), $alternates['en']);
        $this->assertSame(url('/pl/firma/o-nas/zespol'), $alternates['pl']);
        $this->assertSame(url('/en/company/about/team'), $alternates['x-default']);
    }
}
