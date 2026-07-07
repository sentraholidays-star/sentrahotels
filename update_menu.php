<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$setting = App\Models\SiteSetting::first();
if ($setting && $setting->navbar_menus) {
    $menus = $setting->navbar_menus;
    foreach ($menus as &$menu) {
        if (strtolower($menu['label']) === 'b2b' || str_contains(strtolower($menu['url']), 'b2b')) {
            $menu['sub_menus'] = [
                ['label' => 'Join us', 'url' => '/join-us', 'is_external' => false]
            ];
        }
    }
    $setting->navbar_menus = $menus;
    $setting->save();
    echo "Navbar updated\n";
} else {
    echo "No settings found\n";
}
