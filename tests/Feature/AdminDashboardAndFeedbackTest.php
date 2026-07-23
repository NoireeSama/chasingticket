<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Review;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardAndFeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_new_features()
    {

        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));

        $this->get(route('admin.users.create'))->assertRedirect(route('login'));

        $this->get(route('admin.feedbacks.index'))->assertRedirect(route('login'));
    }

    public function test_merchants_can_access_dashboard_and_events_but_blocked_from_admin_menus()
    {
        $merchant = User::create([
            'name' => 'Merchant User',
            'email' => 'merchant@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $this->actingAs($merchant)->get(route('admin.dashboard'))->assertStatus(200);

        $this->actingAs($merchant)->get(route('admin.events.index'))->assertStatus(200);

        $responseCat = $this->actingAs($merchant)->get(route('admin.categories.index'));
        $responseCat->assertRedirect(route('admin.dashboard'));
        $responseCat->assertSessionHas('error', 'Akses ditolak. Merchant tidak dapat mengakses halaman ini.');

        $responseUser = $this->actingAs($merchant)->get(route('admin.users.index'));
        $responseUser->assertRedirect(route('admin.dashboard'));

        $responseFeedback = $this->actingAs($merchant)->get(route('admin.feedbacks.index'));
        $responseFeedback->assertStatus(200);
    }

    public function test_admin_can_access_user_creation_and_store()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@chaser.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin)->get(route('admin.users.create'))->assertStatus(200);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'New Customer',
            'username' => 'newcustomer',
            'email' => 'newcustomer@test.com',
            'password' => 'password123',
            'role' => 'customer',
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'name' => 'New Customer',
            'username' => 'newcustomer',
            'email' => 'newcustomer@test.com',
            'role' => 'customer',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $admin->id,
            'activity' => 'Admin Admin User membuat akun customer baru: New Customer (@newcustomer)',
        ]);
    }

    public function test_admin_can_view_and_delete_feedbacks()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@chaser.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $category = Category::create([
            'name' => 'Concert Test',
            'slug' => 'concert-test',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Event Test',
            'description' => 'Description Test',
            'date' => now()->addDays(2),
            'location' => 'Location Test',
            'price' => 10000,
            'stock' => 10,
        ]);

        $review = Review::create([
            'event_id' => $event->id,
            'user_id' => $customer->id,
            'rating' => 5,
            'review' => 'Inappropriate content',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.feedbacks.index'));
        $response->assertStatus(200);
        $response->assertSee('Inappropriate content');

        $deleteResponse = $this->actingAs($admin)->delete(route('admin.feedbacks.destroy', $review->id));
        $deleteResponse->assertRedirect(route('admin.feedbacks.index'));

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);
    }
}
