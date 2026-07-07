<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StaticPageSeo;
use App\Models\SiteSetting;

// 1. Inject SEO
$seo = StaticPageSeo::firstOrCreate(
    ['page_identifier' => 'how-we-work'],
    [
        'page_name' => 'How We Work',
        'meta_title' => 'How We Work | Sentra Hotels',
        'meta_description' => 'Pelajari cara kerja Sentra Hotels dalam memberikan layanan pemesanan kamar B2B terbaik.',
    ]
);
echo "SEO injected.\n";

// 2. Inject Sub Menu under B2B Online Booking
$settings = SiteSetting::first();
if ($settings && $settings->navbar_menus) {
    $menus = $settings->navbar_menus;
    foreach ($menus as &$menu) {
        if ($menu['label'] === 'B2B Online Booking') {
            if (!isset($menu['sub_menus'])) {
                $menu['sub_menus'] = [];
            }
            
            // Cek apakah sudah ada How We Work
            $exists = false;
            foreach ($menu['sub_menus'] as $sub) {
                if ($sub['label'] === 'How We Work') {
                    $exists = true;
                    break;
                }
            }
            
            if (!$exists) {
                $menu['sub_menus'][] = [
                    'label' => 'How We Work',
                    'url' => '/how-we-work'
                ];
                $settings->navbar_menus = $menus;
                $settings->save();
                echo "Sub-menu 'How We Work' added successfully.\n";
            } else {
                echo "Sub-menu 'How We Work' already exists.\n";
            }
            break;
        }
    }
}
