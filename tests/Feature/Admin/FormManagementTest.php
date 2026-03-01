<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Form;

class FormManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_admin_can_list_forms(): void
    {
        Form::factory()->count(2)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.forms.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn($page) => $page->component('Admin/Forms/Index'));
    }

    public function test_admin_can_store_form(): void
    {
        $data = [
            'name' => 'Contact Us',
            'content' => [['type' => 'text', 'label' => 'Name']],
            'settings' => ['submit_text' => 'Send'],
            'is_published' => true,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.forms.store'), $data);

        $response->assertRedirect(route('admin.forms.index'));
        $this->assertDatabaseHas('forms', ['name' => 'Contact Us']);
    }

    public function test_admin_can_update_form(): void
    {
        $form = Form::factory()->create();

        $data = [
            'name' => 'Updated Form',
            'content' => $form->content,
            'settings' => $form->settings,
            'is_published' => false,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.forms.update', $form), $data);

        $response->assertRedirect(route('admin.forms.index'));
        $this->assertDatabaseHas('forms', ['id' => $form->id, 'name' => 'Updated Form']);
    }

    public function test_admin_can_delete_form(): void
    {
        $form = Form::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.forms.destroy', $form));

        $response->assertRedirect();
        $this->assertDatabaseMissing('forms', ['id' => $form->id]);
    }
}
