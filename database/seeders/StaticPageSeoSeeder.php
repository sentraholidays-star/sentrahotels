<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaticPageSeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            ['identifier' => 'home', 'name' => 'Beranda Utama'],
            ['identifier' => 'destinations', 'name' => 'Daftar Destinasi'],
            ['identifier' => 'b2b', 'name' => 'B2B Online Booking'],
            ['identifier' => 'news', 'name' => 'Berita & Artikel'],
            ['identifier' => 'about', 'name' => 'Tentang Kami'],
        ];

        foreach ($pages as $page) {
            \App\Models\StaticPageSeo::firstOrCreate(
                ['page_identifier' => $page['identifier']],
                ['page_name' => $page['name']]
            );
        }
    }
}
