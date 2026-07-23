<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_dynamic_pricing')->default(false)->after('price');
            $table->json('dynamic_pricing_rules')->nullable()->after('is_dynamic_pricing');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['is_dynamic_pricing', 'dynamic_pricing_rules']);
        });
    }
};
