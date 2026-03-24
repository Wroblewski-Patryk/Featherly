<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionMiddlewareJsonEnvelopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_permission_middleware_returns_standardized_json_envelope_for_forbidden_requests(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->getJson(route('admin.dashboard.index', ['locale' => 'en']));

        $response
            ->assertForbidden()
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorized.',
                'errors' => [],
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'errors',
            ]);
    }
}
