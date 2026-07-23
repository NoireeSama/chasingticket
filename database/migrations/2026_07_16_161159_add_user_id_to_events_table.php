<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
        });

        $merchant = \App\Models\User::where('username', 'Chaseradmin')
            ->orWhere('name', 'ChaserTickerID')
            ->first();

        if (!$merchant) {
            $merchant = new \App\Models\User([
                'name' => 'ChaserTickerID',
                'username' => 'Chaseradmin',
                'email' => 'chaserticker@test.com',
                'password' => bcrypt('password'),
                'role' => 'merchant',
            ]);
            $merchant->id = 2;
            $merchant->save();
        }

        \Illuminate\Support\Facades\DB::table('events')
            ->whereNull('user_id')
            ->update(['user_id' => $merchant->id]);
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
