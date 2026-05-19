<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create the managing administrator actor
        $this->superAdmin = User::factory()->create([
            'is_admin' => true,
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);

        // Mock the 'can:manage-admins' Gate so the middleware group allows entry
        Gate::define('manage-admins', function (User $user) {
            return $user->is_admin === true;
        });
    }

    /**
     * Test provisioning a new administrator account and verifying the log entries.
     */
    public function test_authorized_administrators_can_provision_new_admin_accounts()
    {
        $payload = [
            'name' => 'Jane Staff Admin',
            'email' => 'jane.admin@example.com',
            'password' => 'SecurePassword123!',
        ];

        $response = $this->actingAs($this->superAdmin)
            ->from(route('admin.settings'))
            ->post(route('admin.users.store'), $payload);

        $response->assertRedirect(route('admin.settings'));
        $response->assertSessionHas('success', 'Administrator account provisioned.');

        // 1. Assert the new admin user exists in the database
        $this->assertDatabaseHas('users', [
            'name' => 'Jane Staff Admin',
            'email' => 'jane.admin@example.com',
            'is_admin' => true,
        ]);

        // 2. Assert that this explicit creation recorded an entry to the logs
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->superAdmin->id,
            'user_name' => 'Super Admin',
            'action' => 'Manage Admin',
            'description' => 'Provisioned a new administrator account for Jane Staff Admin (jane.admin@example.com).',
        ]);
    }

    /**
     * Test verification that missing parameter inputs trigger appropriate session errors.
     */
    public function test_admin_provisioning_fails_validation_if_inputs_are_missing()
    {
        $response = $this->actingAs($this->superAdmin)
            ->post(route('admin.users.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);

        // Assert that a validation failure does NOT write a record to the logs
        $this->assertDatabaseMissing('activity_logs', [
            'action' => 'Manage Admin',
        ]);
    }

    /**
     * Test removing another administrator's system access.
     */
    public function test_administrators_can_revoke_access_and_delete_other_admin_accounts()
    {
        $targetAdmin = User::factory()->create([
            'name' => 'Old Admin Instance',
            'email' => 'oldadmin@example.com',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($this->superAdmin)
            ->from(route('admin.settings'))
            ->delete(route('admin.users.destroy', ['user' => $targetAdmin->id]));

        $response->assertRedirect(route('admin.settings'));
        $response->assertSessionHas('success', 'Access revoked.');

        // 1. Confirm model removal
        $this->assertNull($targetAdmin->fresh());

        // 2. Assert that this explicit destruction recorded an entry to the logs
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->superAdmin->id,
            'user_name' => 'Super Admin',
            'action' => 'Manage Admin',
            'description' => 'Revoked administrative access and deleted account for Old Admin Instance (oldadmin@example.com).',
        ]);
    }

    /**
     * Test safeguard logic that blocks authenticated administrators from self-deletion.
     */
    public function test_administrators_are_prohibited_from_self_deletion()
    {
        $response = $this->actingAs($this->superAdmin)
            ->from(route('admin.settings'))
            ->delete(route('admin.users.destroy', ['user' => $this->superAdmin->id]));

        $response->assertRedirect(route('admin.settings'));
        $response->assertSessionHasErrors(['error']);

        // 1. Ensure the active admin record was kept safe in the database layer
        $this->assertNotNull($this->superAdmin->fresh());

        // 2. Assert that a rejected self-deletion action does NOT log a success entry
        $this->assertDatabaseMissing('activity_logs', [
            'description' => 'Revoked administrative access and deleted account for Super Admin (superadmin@example.com).',
        ]);
    }
}
