<?php

namespace Tests\Feature;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_role_has_all_permissions_assigned_by_gate()
    {
        $admin = User::factory()->create();
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->assertTrue($admin->can('some-random-permission-that-does-not-exist'));
    }

    public function test_editor_role_has_specific_permissions()
    {
        Permission::firstOrCreate(['name' => 'view-admin']);
        Permission::firstOrCreate(['name' => 'manage-content']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorRole->givePermissionTo(['view-admin', 'manage-content']);

        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $this->assertTrue($editor->can('view-admin'));
        $this->assertTrue($editor->can('manage-content'));
        $this->assertFalse($editor->can('manage-users'));
    }
}
