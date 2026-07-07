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
        Schema::table('hotels', function (Blueprint $table) {
            $table->unsignedBigInteger('thumbnail_id')->nullable()->after('thumbnail');
        });

        Schema::table('hotel_galleries', function (Blueprint $table) {
            $table->unsignedBigInteger('media_id')->nullable()->after('image');
        });

        Schema::table('hotel_rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('media_id')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('thumbnail_id');
        });
        Schema::table('hotel_galleries', function (Blueprint $table) {
            $table->dropColumn('media_id');
        });
        Schema::table('hotel_rooms', function (Blueprint $table) {
            $table->dropColumn('media_id');
        });
    }
};
