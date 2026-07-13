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
        $setting = \App\Models\SiteSetting::first();
        if ($setting && is_array($setting->navbar_menus)) {
            $menus = $setting->navbar_menus;
            $exists = false;
            foreach ($menus as $menu) {
                if (($menu['label'] ?? '') === 'Terms & Conditions') {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $newMenus = [];
                foreach ($menus as $m) {
                    $newMenus[] = $m;
                    // Sisipkan setelah 'About us'
                    if (($m['label'] ?? '') === 'About us') {
                        $newMenus[] = [
                            'label' => 'Terms & Conditions',
                            'url' => '/terms-and-conditions',
                            'is_external' => false,
                            'sub_menus' => []
                        ];
                    }
                }
                
                // Jika 'About us' tidak ditemukan, tambahkan di akhir
                if (count($newMenus) === count($menus)) {
                    $newMenus[] = [
                        'label' => 'Terms & Conditions',
                        'url' => '/terms-and-conditions',
                        'is_external' => false,
                        'sub_menus' => []
                    ];
                }

                $setting->navbar_menus = $newMenus;
                $setting->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $setting = \App\Models\SiteSetting::first();
        if ($setting && is_array($setting->navbar_menus)) {
            $menus = array_filter($setting->navbar_menus, function($m) {
                return ($m['label'] ?? '') !== 'Terms & Conditions';
            });
            $setting->navbar_menus = array_values($menus);
            $setting->save();
        }
    }
};
