<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        \App\Models\User::firstOrCreate(
            ['email' => 'admin@chaser.ac.id'],
            [
                'id' => 1,
                'name' => 'Admin Chaser',
                'password' => bcrypt('deradero123'),
                'role' => 'admin',
            ]
        );

        $merchant = \App\Models\User::where('name', 'ChasingTicketID')
            ->orWhere('username', 'Chaseradmin')
            ->first();

        if (!$merchant) {
            $merchant = new \App\Models\User([
                'name' => 'ChaserTicketID',
                'username' => 'Chaseradmin',
                'email' => 'chasingticket@chaser.ac.id',
                'password' => bcrypt('deradero123'),
                'role' => 'merchant',
            ]);
            $merchant->id = 2;
            $merchant->save();
        } else {
            if ($merchant->id !== 2) {
                $merchant->delete();
                $merchant = new \App\Models\User([
                    'name' => 'ChasingTicketID',
                    'username' => 'Chaseradmin',
                    'email' => 'chasingticket@chaser.ac.id',
                    'password' => bcrypt('deradero123'),
                    'role' => 'merchant',
                ]);
                $merchant->id = 2;
                $merchant->save();
            }
        }

        $category = \App\Models\Category::firstOrCreate(
            ['slug' => 'seminar-it'],
            ['name' => 'Seminar IT']
        );

        $category2 = \App\Models\Category::firstOrCreate(
            ['slug' => 'entertaiment'],
            ['name' => 'Entertaiment']
        );

        \App\Models\Event::firstOrCreate(
            ['title' => 'Jazz Night 2025'],
            [
                'category_id' => $category2->id,
                'user_id' => $merchant->id,
                'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
                'date' => '2026-05-10 19:00:00',
                'location' => 'Amikom Baru',
                'price' => 50000,
                'stock' => 100,
                'poster_path' => 'posters/event-1.png',
            ]
        );

        \App\Models\Event::firstOrCreate(
            ['title' => 'Hackaton - Unleash Your Inner Developer'],
            [
                'category_id' => $category->id,
                'user_id' => $merchant->id,
                'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif untuk tantangan masa depan!',
                'date' => '2026-05-05 10:00:00',
                'location' => 'Inkubator Amikom',
                'price' => 50000,
                'stock' => 100,
                'poster_path' => 'posters/event-2.png',
            ]
        );

        \App\Models\Event::firstOrCreate(
            ['title' => 'AI & FUTURE TECH SUMMIT 2026'],
            [
                'category_id' => $category->id,
                'user_id' => $merchant->id,
                'description' => 'Jelajahi tren terkini dalam kecerdasan buatan dan teknologi masa depan bersama para ahli di bidangnya.',
                'date' => '2026-05-01 13:00:00',
                'location' => 'Cinema Unit 6',
                'price' => 50000,
                'stock' => 100,
                'poster_path' => 'posters/event-3.png',
            ]
        );

        \App\Models\Coupon::updateOrCreate(
            ['code' => 'ASIKNGEVENT'],
            [
                'user_id' => $merchant->id,
                'type' => 'percent',
                'value' => 5,
                'is_limited' => false,
                'expires_at' => now()->addYear(),
            ]
        );

        \App\Models\Coupon::updateOrCreate(
            ['code' => 'NGIVENT TERUS'],
            [
                'user_id' => $merchant->id,
                'type' => 'percent',
                'value' => 2,
                'is_limited' => false,
                'expires_at' => now()->addYear(),
            ]
        );
    }
}
