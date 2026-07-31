<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ThemeManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_saved_theme_config_is_shared_with_public_pages(): void
    {
        $config = [
            'globals' => [
                'colors' => ['primary' => '#112233', 'base-100' => '#fefefe'],
                'fonts' => ['sans' => 'Manrope', 'serif' => 'Lora', 'mono' => 'JetBrains Mono'],
            ],
            'block_defaults' => ['heading' => ['fontWeight' => '700']],
        ];

        Setting::create(['key' => 'theme_config', 'value' => $config]);
        $homePage = Page::factory()->create();
        Setting::create(['key' => 'home_page_id', 'value' => $homePage->id]);

        $response = $this->get(route('home', ['locale' => 'en']));

        $response->assertOk();
        $response->assertInertia(fn (Assert $page) => $page
            ->where('theme_config.globals.colors.primary', '#112233')
            ->where('theme_config.globals.fonts.sans', 'Manrope')
            ->where('theme_config.block_defaults.heading.fontWeight', '700')
        );
    }

    public function test_admin_can_save_and_reload_theme_config(): void
    {
        $admin = User::factory()->admin()->create();
        $config = [
            'globals' => [
                'colors' => ['primary' => '#0a0b0c'],
                'fonts' => ['sans' => 'Manrope'],
            ],
            'block_defaults' => [],
        ];

        $this->actingAs($admin)
            ->post(route('admin.theme.store'), $config)
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertSame(
            '#0a0b0c',
            Setting::query()->where('key', 'theme_config')->firstOrFail()->value['globals']['colors']['primary']
        );

        $this->actingAs($admin)
            ->get(route('admin.theme.colors'))
            ->assertInertia(fn (Assert $page) => $page
                ->where('themeConfig.globals.colors.primary', '#0a0b0c')
                ->where('themeConfig.globals.fonts.sans', 'Manrope')
            );
    }
}
