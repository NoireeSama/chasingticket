<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_user_management()
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_admins_cannot_access_user_management()
    {
        $customer = User::create([
            'name' => 'Regular User',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)->get(route('admin.users.index'));

        $this->assertNotEquals(200, $response->getStatusCode());
    }

    public function test_admin_can_view_user_management_index_and_search()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@chaser.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $customer1 = User::create([
            'name' => 'Budi Santoso',
            'username' => 'budi_s',
            'email' => 'budi@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $merchant1 = User::create([
            'name' => 'Toko Sepatu',
            'username' => 'tokosepatu',
            'email' => 'sepatu@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertSee('Toko Sepatu');

        $responseSearch = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'Budi']));
        $responseSearch->assertStatus(200);
        $responseSearch->assertSee('Budi Santoso');
        $responseSearch->assertDontSee('Toko Sepatu');

        $responseRole = $this->actingAs($admin)->get(route('admin.users.index', ['role' => 'merchant']));
        $responseRole->assertStatus(200);
        $responseRole->assertDontSee('Budi Santoso');
        $responseRole->assertSee('Toko Sepatu');
    }

    public function test_admin_can_edit_user_details()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@chaser.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $customer = User::create([
            'name' => 'Andi Wijaya',
            'username' => 'andiw',
            'email' => 'andi@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        Storage::fake('public');
        $avatar = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($admin)->put(route('admin.users.update', $customer->id), [
            'name' => 'Andi Wijaya Perkasa',
            'username' => 'andiw_p',
            'email' => 'andi_new@test.com',
            'role' => 'merchant',
            'password' => 'newpassword123',
            'avatar' => $avatar,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Rincian data user berhasil diperbarui.');

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'Andi Wijaya Perkasa',
            'username' => 'andiw_p',
            'email' => 'andi_new@test.com',
            'role' => 'merchant',
        ]);

        $customer->refresh();
        $this->assertNotNull($customer->avatar_path);
        Storage::disk('public')->assertExists($customer->avatar_path);
    }

    public function test_admin_cannot_edit_google_user_email()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@chaser.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $googleUser = User::create([
            'name' => 'Google User',
            'username' => 'guser',
            'email' => 'google@gmail.com',
            'google_id' => '1234567890',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.users.update', $googleUser->id), [
            'name' => 'Google User Edited',
            'username' => 'guser_edited',
            'email' => 'google_edited@gmail.com',
            'role' => 'merchant',
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'id' => $googleUser->id,
            'name' => 'Google User Edited',
            'username' => 'guser_edited',
            'email' => 'google@gmail.com',
            'role' => 'merchant',
        ]);
    }

    public function test_admin_cannot_delete_themselves()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@chaser.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri.');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }

    public function test_admin_can_delete_other_users()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@chaser.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $customer = User::create([
            'name' => 'Delete Me',
            'username' => 'deleteme',
            'email' => 'deleteme@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $customer->id));
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success', 'Akun user berhasil dihapus secara permanen.');

        $this->assertDatabaseMissing('users', [
            'id' => $customer->id,
        ]);
    }
}
