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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained('destinations')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->integer('stars')->default(5);
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('promotion')->default(false);
            $table->boolean('status')->default(true);
            
            // Custom fields for filters & content
            $table->string('hotel_type')->default('Resort'); // Resort or City Hotel
            $table->boolean('is_family')->default(false);
            $table->boolean('is_business')->default(false);
            $table->boolean('is_beach')->default(false);
            $table->boolean('is_luxury')->default(false);
            $table->text('why_choose_us')->nullable(); // Keunggulan hotel
            
            $table->timestamps();
        });

        Schema::create('hotel_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->string('image');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('hotel_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->string('facility_name');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->string('room_name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('nearby_places', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->string('place_name');
            $table->string('distance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nearby_places');
        Schema::dropIfExists('hotel_rooms');
        Schema::dropIfExists('hotel_facilities');
        Schema::dropIfExists('hotel_galleries');
        Schema::dropIfExists('hotels');
    }
};
