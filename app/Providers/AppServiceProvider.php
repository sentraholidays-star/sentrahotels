<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('site_settings')) {
                $settings = \Illuminate\Support\Facades\Cache::remember('global_site_settings', 60 * 24, function () {
                    $setting = SiteSetting::first();
                    if (!$setting) {
                        $setting = SiteSetting::create([
                            'logo_image' => null,
                            'navbar_menus' => [
                                ['label' => 'Koleksi', 'url' => '#collection', 'is_external' => false],
                                ['label' => 'Layanan', 'url' => '#service', 'is_external' => false],
                                ['label' => 'B2B', 'url' => '#b2b', 'is_external' => false],
                                ['label' => 'Request', 'url' => '#request', 'is_external' => false],
                                ['label' => 'News', 'url' => '/news', 'is_external' => false],
                                ['label' => 'About', 'url' => '/about', 'is_external' => false],
                            ],
                            'footer_description' => 'Sentra Hotels adalah Luxury Hotel Desk untuk pemesanan kamar hotel bintang 4 & 5 terbaik di seluruh destinasi impian Anda.',
                            'footer_address' => "Ruko Cikawao Permai, Jl. Cikawao Permai No.10 Kav B,\nLengkong, Bandung, Jawa Barat 40261",
                            'footer_email' => 'reservation@sentrahotels.com',
                            'whatsapp_number' => '6287722389541',
                        ]);
                    }
                    return $setting;
                });
                \Illuminate\Support\Facades\View::share('global_settings', $settings);
            }

            if (Schema::hasTable('notices')) {
                $notices = \Illuminate\Support\Facades\Cache::remember('global_notices', 60 * 24, function () {
                    return \App\Models\Notice::where('is_active', true)->orderBy('sort_order', 'asc')->get();
                });
                \Illuminate\Support\Facades\View::share('global_notices', $notices);
            }
        } catch (\Throwable $e) {
            // Silently catch database connection/migration time exceptions
        }
    }
}
