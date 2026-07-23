<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;

class FixDatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $targetUser = User::where('username', 'Chaseradmin')->first();
        if (!$targetUser) {
            $targetUser = User::where('name', 'ChaserTickerID')->first();
        }

        if ($targetUser) {

            Event::query()->update(['user_id' => $targetUser->id]);
            $this->command->info("Events successfully reassigned to User: {$targetUser->name} (ID: {$targetUser->id})");

            $dupUser = User::where('username', 'ChaserTickerID')->first();
            if ($dupUser && $dupUser->id !== $targetUser->id) {
                $dupUser->delete();
                $this->command->info("Deleted duplicate user (ID: {$dupUser->id})");
            }
        } else {
            $this->command->error("Target merchant user not found.");
        }
    }
}
