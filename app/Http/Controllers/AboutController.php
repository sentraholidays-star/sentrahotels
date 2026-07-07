<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $profile = CompanyProfile::first();

        if (!$profile) {
            $profile = CompanyProfile::create([
                'hero_images' => [],
                'title' => 'Tentang Sentra Hotels',
                'content' => '<p>Sentra Hotels adalah Luxury Hotel Desk yang berdedikasi menyediakan layanan reservasi hotel bintang 4 &amp; 5 terbaik secara personal dan korporasi. Kami membantu merancang rencana perjalanan eksklusif Anda dengan pilihan destinasi impian di seluruh Indonesia dan mancanegara.</p>',
            ]);
        }

        $seo_page = \App\Models\StaticPageSeo::where('page_identifier', 'about')->first();

        return view('about', compact('profile', 'seo_page'));
    }
}
