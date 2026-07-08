<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('hotel_promo_title')->nullable();
            $table->string('hotel_promo_subtitle')->nullable();
            $table->json('hotel_promo_banners')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hotel_promo_title',
                'hotel_promo_subtitle',
                'hotel_promo_banners'
            ]);
        });
    }
};
