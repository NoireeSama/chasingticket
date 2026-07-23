<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_checkout_page_renders_empty_inputs()
    {
        $category = Category::create(['name' => 'IT Seminar', 'slug' => 'it-seminar']);
        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Code Meetup',
            'description' => 'A great meetup',
            'date' => now()->addDays(5),
            'location' => 'Amikom',
            'price' => 50000,
            'stock' => 10,
        ]);

        $response = $this->get(route('checkout.create', $event->id));
        $response->assertStatus(200);

        $response->assertSee('value=""', false);
    }

    public function test_authenticated_user_checkout_autofills_information()
    {
        $user = User::create([
            'name' => 'Ahmad Zaenuri',
            'email' => 'ahmad@test.com',
            'phone' => '08987654321',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $category = Category::create(['name' => 'IT Seminar', 'slug' => 'it-seminar']);
        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Code Meetup',
            'description' => 'A great meetup',
            'date' => now()->addDays(5),
            'location' => 'Amikom',
            'price' => 50000,
            'stock' => 10,
        ]);

        $response = $this->actingAs($user)->get(route('checkout.create', $event->id));
        $response->assertStatus(200);

        $response->assertSee('Ahmad Zaenuri');
        $response->assertSee('ahmad@test.com');
        $response->assertSee('08987654321');
    }

    public function test_checkout_store_updates_user_profile_phone()
    {
        $user = User::create([
            'name' => 'Ahmad Zaenuri',
            'email' => 'ahmad@test.com',
            'phone' => null,
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $category = Category::create(['name' => 'IT Seminar', 'slug' => 'it-seminar']);
        $event = Event::create([
            'category_id' => $category->id,
            'title' => 'Code Meetup',
            'description' => 'A great meetup',
            'date' => now()->addDays(5),
            'location' => 'Amikom',
            'price' => 50000,
            'stock' => 10,
        ]);

        $response = $this->actingAs($user)->post(route('checkout.store', $event->id), [
            'customer_name' => 'Ahmad Zaenuri Edited',
            'customer_email' => 'ahmad_new@test.com',
            'customer_phone' => '08123456789',
            'qty' => 1,
        ]);

        $response->assertStatus(302);

        $user->refresh();

        $this->assertEquals('08123456789', $user->phone);
    }

    public function test_wishlist_page_renders_successfully_for_authenticated_users()
    {
        $user = User::create([
            'name' => 'Ahmad Zaenuri',
            'email' => 'ahmad@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $response = $this->actingAs($user)->get(route('wishlist.index'));
        $response->assertStatus(200);
        $response->assertSee('Wishlist Saya');
    }

    public function test_wishlist_dropdown_item_exists_on_landing_page()
    {
        $user = User::create([
            'name' => 'Ahmad Zaenuri',
            'email' => 'ahmad@test.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        $response->assertSee(route('wishlist.index'));
    }
}
