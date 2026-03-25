<?php

namespace Tests\Feature;

use App\Models\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleRoutingEdgeCasesTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_default_locale_path(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/en');
    }

    public function test_invalid_locale_switch_request_returns_bad_request(): void
    {
        Language::create([
            'name' => 'English',
            'code' => 'en',
            'is_active' => true,
            'is_default' => true,
        ]);

        $response = $this->withHeader('referer', '/')->get(route('locale.switch', ['lang' => 'xx']));

        $response->assertStatus(400);
    }

    public function test_valid_locale_switch_sets_session_and_redirects_back(): void
    {
        Language::create([
            'name' => 'English',
            'code' => 'en',
            'is_active' => true,
            'is_default' => true,
        ]);
        Language::create([
            'name' => 'Polish',
            'code' => 'pl',
            'is_active' => true,
            'is_default' => false,
        ]);

        $response = $this->withHeader('referer', '/en')->get(route('locale.switch', ['lang' => 'pl']));

        $response->assertStatus(302);
        $response->assertRedirect('/en');
        $this->assertSame('pl', session('locale'));
    }

    public function test_admin_fallback_ignores_inactive_locale_from_session(): void
    {
        Language::create([
            'name' => 'English',
            'code' => 'en',
            'is_active' => true,
            'is_default' => true,
        ]);
        Language::create([
            'name' => 'Polish',
            'code' => 'pl',
            'is_active' => false,
            'is_default' => false,
        ]);

        $response = $this->withSession(['locale' => 'pl'])->get('/admin');

        $response->assertStatus(302);
        $response->assertRedirect('/en/admin');
    }

    public function test_dashboard_fallback_preserves_subpath_with_active_locale(): void
    {
        Language::create([
            'name' => 'English',
            'code' => 'en',
            'is_active' => true,
            'is_default' => true,
        ]);

        $response = $this->get('/dashboard/settings/profile');

        $response->assertStatus(302);
        $response->assertRedirect('/en/admin/settings/profile');
    }
}
