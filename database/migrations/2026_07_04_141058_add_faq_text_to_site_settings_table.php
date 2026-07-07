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
            $table->string('faq_kicker')->nullable()->after('is_news_active');
            $table->string('faq_title')->nullable()->after('faq_kicker');
            $table->text('faq_subtitle')->nullable()->after('faq_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['faq_kicker', 'faq_title', 'faq_subtitle']);
        });
    }
};
