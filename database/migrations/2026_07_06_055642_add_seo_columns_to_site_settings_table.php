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
            $table->string('seo_meta_title')->nullable()->after('whatsapp_number');
            $table->text('seo_meta_description')->nullable()->after('seo_meta_title');
            $table->string('seo_meta_keywords')->nullable()->after('seo_meta_description');
            $table->string('seo_og_image')->nullable()->after('seo_meta_keywords');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['seo_meta_title', 'seo_meta_description', 'seo_meta_keywords', 'seo_og_image']);
        });
    }
};
