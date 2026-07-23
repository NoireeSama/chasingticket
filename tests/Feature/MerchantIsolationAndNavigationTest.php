<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MerchantIsolationAndNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_migration_seeds_chasertickerid_and_assigns_existing_events()
    {

        $category = Category::create(['name' => 'Music', 'slug' => 'music']);
        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Old Event',
            'description' => 'Test',
            'date' => now()->addDays(5),
            'location' => 'Test',
            'price' => 50000,
            'stock' => 100,
        ]);

        $this->assertNull($event->user_id);

        $merchant = User::firstOrCreate(
            ['username' => 'ChaserTickerID'],
            [
                'name' => 'ChaserTickerID Merchant',
                'email' => 'chaserticker_test@test.com',
                'password' => bcrypt('password'),
                'role' => 'merchant',
            ]
        );

        \Illuminate\Support\Facades\DB::table('events')
            ->whereNull('user_id')
            ->update(['user_id' => $merchant->id]);

        $event->refresh();
        $this->assertEquals($merchant->id, $event->user_id);
    }

    public function test_merchant_event_isolation()
    {
        $merchant1 = User::create([
            'name' => 'Merchant One',
            'username' => 'merchant1',
            'email' => 'm1@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $merchant2 = User::create([
            'name' => 'Merchant Two',
            'username' => 'merchant2',
            'email' => 'm2@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $category = Category::create(['name' => 'Tech', 'slug' => 'tech']);

        $event1 = Event::create([
            'category_id' => $category->id,
            'user_id' => $merchant1->id,
            'title' => 'Merchant 1 Event',
            'description' => 'Test',
            'date' => now()->addDays(5),
            'location' => 'Test',
            'price' => 50000,
            'stock' => 100,
        ]);

        $event2 = Event::create([
            'category_id' => $category->id,
            'user_id' => $merchant2->id,
            'title' => 'Merchant 2 Event',
            'description' => 'Test',
            'date' => now()->addDays(5),
            'location' => 'Test',
            'price' => 50000,
            'stock' => 100,
        ]);

        $response1 = $this->actingAs($merchant1)->get(route('admin.events.index'));
        $response1->assertStatus(200);
        $response1->assertSee('Merchant 1 Event');
        $response1->assertDontSee('Merchant 2 Event');

        $this->actingAs($merchant1)->get(route('admin.events.edit', $event2->id))->assertStatus(403);

        $this->actingAs($merchant1)->delete(route('admin.events.destroy', $event2->id))->assertStatus(403);
    }

    public function test_merchant_transaction_isolation()
    {
        $merchant = User::create([
            'name' => 'Merchant',
            'username' => 'merchant',
            'email' => 'merchant@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $otherUser = User::create([
            'name' => 'Other',
            'username' => 'other',
            'email' => 'other@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $category = Category::create(['name' => 'Expo', 'slug' => 'expo']);

        $myEvent = Event::create([
            'category_id' => $category->id,
            'user_id' => $merchant->id,
            'title' => 'My Event',
            'description' => 'Test',
            'date' => now()->addDays(5),
            'location' => 'Test',
            'price' => 10000,
            'stock' => 100,
        ]);

        $otherEvent = Event::create([
            'category_id' => $category->id,
            'user_id' => $otherUser->id,
            'title' => 'Other Event',
            'description' => 'Test',
            'date' => now()->addDays(5),
            'location' => 'Test',
            'price' => 10000,
            'stock' => 100,
        ]);

        Transaction::create([
            'event_id' => $myEvent->id,
            'order_id' => 'TRX-MY',
            'customer_name' => 'Customer A',
            'customer_email' => 'a@test.com',
            'customer_phone' => '08123456789',
            'total_price' => 10000,
            'status' => 'success',
        ]);

        Transaction::create([
            'event_id' => $otherEvent->id,
            'order_id' => 'TRX-OTHER',
            'customer_name' => 'Customer B',
            'customer_email' => 'b@test.com',
            'customer_phone' => '08123456780',
            'total_price' => 10000,
            'status' => 'success',
        ]);

        $response = $this->actingAs($merchant)->get(route('admin.transactions.index'));
        $response->assertStatus(200);
        $response->assertSee('TRX-MY');
        $response->assertDontSee('TRX-OTHER');
    }

    public function test_merchant_feedback_isolation()
    {
        $merchant = User::create([
            'name' => 'Merchant',
            'username' => 'merchant',
            'email' => 'merchant@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $customer = User::create([
            'name' => 'Customer',
            'username' => 'customer',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $category = Category::create(['name' => 'Expo', 'slug' => 'expo']);

        $myEvent = Event::create([
            'category_id' => $category->id,
            'user_id' => $merchant->id,
            'title' => 'My Event',
            'description' => 'Test',
            'date' => now()->addDays(5),
            'location' => 'Test',
            'price' => 10000,
            'stock' => 100,
        ]);

        $otherEvent = Event::create([
            'category_id' => $category->id,
            'user_id' => null,
            'title' => 'Other Event',
            'description' => 'Test',
            'date' => now()->addDays(5),
            'location' => 'Test',
            'price' => 10000,
            'stock' => 100,
        ]);

        $review1 = Review::create([
            'event_id' => $myEvent->id,
            'user_id' => $customer->id,
            'rating' => 5,
            'review' => 'Great merchant event!',
        ]);

        $review2 = Review::create([
            'event_id' => $otherEvent->id,
            'user_id' => $customer->id,
            'rating' => 4,
            'review' => 'Other event review',
        ]);

        $response = $this->actingAs($merchant)->get(route('admin.feedbacks.index'));
        $response->assertStatus(200);
        $response->assertSee('Great merchant event!');
        $response->assertDontSee('Other event review');

        $deleteResponse = $this->actingAs($merchant)->delete(route('admin.feedbacks.destroy', $review1->id));
        $deleteResponse->assertRedirect(route('admin.feedbacks.index'));
        $deleteResponse->assertSessionHas('error', 'Akses ditolak. Hanya admin utama yang dapat menghapus ulasan.');

        $this->assertDatabaseHas('reviews', ['id' => $review1->id]);
    }

    public function test_navigation_back_to_landing_page_exists()
    {
        $merchant = User::create([
            'name' => 'Merchant',
            'username' => 'merchant',
            'email' => 'merchant@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $response = $this->actingAs($merchant)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Kembali ke Beranda');
    }

    public function test_event_detail_page_shows_dynamic_organizer()
    {
        $merchant = User::create([
            'name' => 'Fantastic Organizer',
            'username' => 'fantastic_org',
            'email' => 'fantastic@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $category = Category::create(['name' => 'Comedy', 'slug' => 'comedy']);

        $event = Event::create([
            'category_id' => $category->id,
            'user_id' => $merchant->id,
            'title' => 'Comedy Gala 2026',
            'description' => 'Hilarious comedy show',
            'date' => now()->addDays(5),
            'location' => 'Theater A',
            'price' => 20000,
            'stock' => 50,
        ]);

        $response = $this->get('/event/' . $event->id);
        $response->assertStatus(200);
        $response->assertSee('Fantastic Organizer');
        $response->assertSee('ulasan');
    }

    public function test_merchant_profile_dropdown_shows_dashboard_link()
    {
        $merchant = User::create([
            'name' => 'Merchant User',
            'username' => 'merchant_user',
            'email' => 'merchant_user@test.com',
            'password' => bcrypt('password'),
            'role' => 'merchant',
        ]);

        $response = $this->actingAs($merchant)->get('/');
        $response->assertStatus(200);

        $response->assertSee(route('admin.dashboard'));
    }
}
