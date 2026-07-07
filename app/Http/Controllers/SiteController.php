<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    // Halaman utama
    public function home()
    {
        // Ambil maksimal 21 destinasi aktif terpopuler
        $destinations = Destination::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->take(21)
            ->get();

        // Ambil semua data FAQ
        $faqs = \App\Models\Faq::all();

        // Ambil data Hero Content pertama
        $hero = \App\Models\HeroContent::first();

        // Ambil data logo jaringan hotel pilihan (maks 12)
        $preferredHotels = \App\Models\HotelChainImage::limit(12)->get();

        // Ambil SEO spesifik untuk Beranda (Halaman Statis)
        $seo_page = \App\Models\StaticPageSeo::where('page_identifier', 'home')->first();

        return view('home', compact('destinations', 'faqs', 'hero', 'preferredHotels', 'seo_page'));
    }

    // Halaman list hotel di destinasi tertentu
    public function destination(Request $request, $slug)
    {
        if (strtolower($slug) === 'b2bhotel') {
            return redirect()->route('b2bhotel.index');
        }

        $destination = Destination::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Query hotels milik destinasi ini
        $query = Hotel::where('destination_id', $destination->id)
            ->where('status', true);

        // Filter: Bintang
        if ($request->filled('stars')) {
            $query->where('stars', $request->stars);
        }

        // Filter: Resort / City Hotel
        if ($request->filled('type')) {
            $query->where('hotel_type', $request->type);
        }

        // Filter: Tema (Family, Business, Beach, Luxury)
        if ($request->filled('theme')) {
            $theme = $request->theme;
            if (in_array($theme, ['family', 'business', 'beach', 'luxury'])) {
                $query->where('is_' . $theme, true);
            }
        }

        // Pagination 9 hotel per halaman
        $hotels = $query->orderBy('featured', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(9)
            ->withQueryString();

        // Ambil semua destinasi untuk filter pemindah kota
        $allDestinations = Destination::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('destination', compact('destination', 'hotels', 'allDestinations'));
    }

    // Halaman detail hotel
    public function hotel($slug)
    {
        $hotel = Hotel::with(['destination', 'galleries', 'facilities', 'rooms', 'nearbyPlaces'])
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        // Hotel sejenis (di destinasi yang sama)
        $relatedHotels = Hotel::where('destination_id', $hotel->destination_id)
            ->where('id', '!=', $hotel->id)
            ->where('status', true)
            ->take(3)
            ->get();

        return view('hotel', compact('hotel', 'relatedHotels'));
    }
}
