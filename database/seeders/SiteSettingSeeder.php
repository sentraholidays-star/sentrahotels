<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = \App\Models\SiteSetting::first();
        
        if ($setting) {
            $setting->update([
                'footer_address' => 'Ruko Cikawao Permai, Jl. Cikawao Permai No.10 Kav B, Bandung',
                'is_destination_active' => true,
                'is_news_active' => true,
            ]);
        } else {
            \App\Models\SiteSetting::create([
                'footer_address' => 'Ruko Cikawao Permai, Jl. Cikawao Permai No.10 Kav B, Bandung',
                'is_destination_active' => true,
                'is_news_active' => true,
            ]);
        }
    }
}
