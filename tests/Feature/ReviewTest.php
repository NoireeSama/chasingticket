<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_submit_a_review()
    {
        $category = Category::create([
            'name' => 'Concert Test',
            'slug' => 'concert-test',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Coldplay Live Test',
            'description' => 'Coldplay Concert Test',
            'date' => now()->subDays(2),
            'location' => 'Jakarta',
            'price' => 1500000,
            'stock' => 100,
        ]);

        $response = $this->post(route('reviews.store', $event), [
            'rating' => 5,
            'review' => 'Awesome event!',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_only_customers_can_submit_a_review()
    {
        $category = Category::create([
            'name' => 'Concert Test',
            'slug' => 'concert-test',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Coldplay Live Test',
            'description' => 'Coldplay Concert Test',
            'date' => now()->subDays(2),
            'location' => 'Jakarta',
            'price' => 1500000,
            'stock' => 100,
        ]);

        $admin = User::create([
            'name' => 'Admin User Test',
            'email' => 'admin_test@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
                         ->post(route('reviews.store', $event), [
                             'rating' => 5,
                             'review' => 'Great!',
                         ]);

        $response->assertSessionHas('error', 'Hanya customer yang dapat memberikan rating dan ulasan.');
    }

    public function test_customers_can_submit_a_review_and_rating()
    {
        $category = Category::create([
            'name' => 'Concert Test',
            'slug' => 'concert-test',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Coldplay Live Test',
            'description' => 'Coldplay Concert Test',
            'date' => now()->subDays(2),
            'location' => 'Jakarta',
            'price' => 1500000,
            'stock' => 100,
        ]);

        $customer = User::create([
            'name' => 'Customer User Test',
            'email' => 'customer_test@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        \App\Models\Transaction::create([
            'event_id' => $event->id,
            'order_id' => 'TRX-' . uniqid(),
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => '081234567890',
            'total_price' => $event->price,
            'status' => 'success',
            'quantity' => 1,
        ]);

        $response = $this->actingAs($customer)
                         ->post(route('reviews.store', $event), [
                             'rating' => 5,
                             'review' => 'Awesome concert, best night ever!',
                         ]);

        $response->assertSessionHas('success', 'Ulasan dan rating Anda berhasil disimpan!');

        $this->assertDatabaseHas('reviews', [
            'event_id' => $event->id,
            'user_id' => $customer->id,
            'rating' => 5,
            'review' => 'Awesome concert, best night ever!',
        ]);

        $event->load('reviews');
        $this->assertEquals(5.0, $event->average_rating);
    }

    public function test_a_customer_cannot_review_the_same_event_twice()
    {
        $category = Category::create([
            'name' => 'Concert Test',
            'slug' => 'concert-test',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Coldplay Live Test',
            'description' => 'Coldplay Concert Test',
            'date' => now()->subDays(2),
            'location' => 'Jakarta',
            'price' => 1500000,
            'stock' => 100,
        ]);

        $customer = User::create([
            'name' => 'Customer User Test',
            'email' => 'customer_test@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        \App\Models\Transaction::create([
            'event_id' => $event->id,
            'order_id' => 'TRX-' . uniqid(),
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => '081234567890',
            'total_price' => $event->price,
            'status' => 'success',
            'quantity' => 1,
        ]);

        Review::create([
            'event_id' => $event->id,
            'user_id' => $customer->id,
            'rating' => 4,
            'review' => 'Good concert',
        ]);

        $response = $this->actingAs($customer)
                         ->post(route('reviews.store', $event), [
                             'rating' => 5,
                             'review' => 'Better than before',
                         ]);

        $response->assertSessionHas('error', 'Anda sudah memberikan rating dan ulasan untuk event ini.');

        $this->assertEquals(1, Review::where('event_id', $event->id)->where('user_id', $customer->id)->count());
    }

    public function test_review_content_is_limited_to_280_characters()
    {
        $category = Category::create([
            'name' => 'Concert Test',
            'slug' => 'concert-test',
        ]);

        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Coldplay Live Test',
            'description' => 'Coldplay Concert Test',
            'date' => now()->subDays(2),
            'location' => 'Jakarta',
            'price' => 1500000,
            'stock' => 100,
        ]);

        $customer = User::create([
            'name' => 'Customer User Test',
            'email' => 'customer_test@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        \App\Models\Transaction::create([
            'event_id' => $event->id,
            'order_id' => 'TRX-' . uniqid(),
            'customer_name' => $customer->name,
            'customer_email' => $customer->email,
            'customer_phone' => '081234567890',
            'total_price' => $event->price,
            'status' => 'success',
            'quantity' => 1,
        ]);

        $longReview = str_repeat('a', 281);

        $response = $this->actingAs($customer)
                         ->post(route('reviews.store', $event), [
                             'rating' => 5,
                             'review' => $longReview,
                         ]);

        $response->assertSessionHasErrors('review');
    }
}
