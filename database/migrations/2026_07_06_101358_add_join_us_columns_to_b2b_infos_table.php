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
        Schema::table('b2b_infos', function (Blueprint $table) {
            $table->string('join_us_hero_image')->nullable();
            $table->string('join_us_title')->nullable();
            $table->text('join_us_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('b2b_infos', function (Blueprint $table) {
            $table->dropColumn(['join_us_hero_image', 'join_us_title', 'join_us_description']);
        });
    }
};
