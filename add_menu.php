<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SiteSetting;

$settings = SiteSetting::first();
if ($settings && $settings->navbar_menus) {
    $menus = $settings->navbar_menus;
    
    // Check if "Login B2B" already exists
    $exists = false;
    foreach ($menus as $menu) {
        if ($menu['label'] === 'Login B2B') {
            $exists = true;
            break;
        }
    }
    
    if (!$exists) {
        $menus[] = [
            'label' => 'Login B2B',
            'url' => 'https://sentra.hotelxml.com'
        ];
        $settings->navbar_menus = $menus;
        $settings->save();
        echo "Menu 'Login B2B' added successfully.\n";
    } else {
        echo "Menu 'Login B2B' already exists.\n";
    }
} else {
    echo "Site settings not found or navbar menus empty.\n";
}
