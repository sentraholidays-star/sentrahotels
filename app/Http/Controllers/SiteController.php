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

        // Ambil data Exclusive Rates
        $exclusiveRates = \App\Models\ExclusiveRate::with('image')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // Ambil SEO spesifik untuk Beranda (Halaman Statis)
        $seo_page = \App\Models\StaticPageSeo::where('page_identifier', 'home')->first();

        return view('home', compact('destinations', 'faqs', 'hero', 'preferredHotels', 'exclusiveRates', 'seo_page'));
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

    // Halaman baca artikel
    public function article($slug)
    {
        $article = \App\Models\Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Ambil artikel lain untuk rekomendasi (3 terbaru)
        $relatedArticles = \App\Models\Article::where('id', '!=', $article->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('article', compact('article', 'relatedArticles'));
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

    public function exclusiveRates(Request $request)
    {
        $settings = \App\Models\SiteSetting::first();
        
        $query = \App\Models\HotelPromo::with('image')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_date')
                  ->orWhere('expired_date', '>=', now()->toDateString());
            });

        // Dapatkan list negara & kota unik untuk filter dropdown
        $countries = (clone $query)->distinct()->pluck('country')->filter()->values();
        
        // Filter by Country (jika dipilih)
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Ambil daftar kota berdasarkan query sejauh ini (agar bergantung pada negara jika dipilih)
        $cities = (clone $query)->distinct()->pluck('city')->filter()->values();

        // Filter by City (jika dipilih)
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $hotelPromos = $query->orderBy('sort_order', 'asc')->get();

        return view('exclusive-rates', compact('settings', 'hotelPromos', 'countries', 'cities'));
    }

    public function hotelBrands(Request $request)
    {
        $settings = \App\Models\SiteSetting::first();
        
        $query = \App\Models\HotelBrandPromo::with('image')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_date')
                  ->orWhere('expired_date', '>=', now()->toDateString());
            });

        // Dapatkan list negara & kota unik untuk filter dropdown
        $countries = (clone $query)->distinct()->pluck('country')->filter()->values();
        
        // Filter by Country (jika dipilih)
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Ambil daftar kota berdasarkan query sejauh ini (agar bergantung pada negara jika dipilih)
        $cities = (clone $query)->distinct()->pluck('city')->filter()->values();

        // Filter by City (jika dipilih)
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $hotelBrands = $query->orderBy('sort_order', 'asc')->get();

        return view('hotel-brands', compact('settings', 'hotelBrands', 'countries', 'cities'));
    }

    public function recommendedHotels(Request $request)
    {
        $settings = \App\Models\SiteSetting::first();
        
        $query = \App\Models\RecommendedHotel::with('image')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_date')
                  ->orWhere('expired_date', '>=', now()->toDateString());
            });

        // Dapatkan list negara & kota unik untuk filter dropdown
        $countries = (clone $query)->distinct()->pluck('country')->filter()->values();
        
        // Filter by Country (jika dipilih)
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Ambil daftar kota berdasarkan query sejauh ini (agar bergantung pada negara jika dipilih)
        $cities = (clone $query)->distinct()->pluck('city')->filter()->values();

        // Filter by City (jika dipilih)
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $hotels = $query->orderBy('sort_order', 'asc')->get();

        return view('recommended-hotels', compact('settings', 'hotels', 'countries', 'cities'));
    }

    public function bestHotels(Request $request)
    {
        $settings = \App\Models\SiteSetting::first();
        
        $query = \App\Models\BestHotel::with('image')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expired_date')
                  ->orWhere('expired_date', '>=', now()->toDateString());
            });

        // Dapatkan list negara & kota unik untuk filter dropdown
        $countries = (clone $query)->distinct()->pluck('country')->filter()->values();
        
        // Filter by Country (jika dipilih)
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Ambil daftar kota berdasarkan query sejauh ini (agar bergantung pada negara jika dipilih)
        $cities = (clone $query)->distinct()->pluck('city')->filter()->values();

        // Filter by City (jika dipilih)
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $hotels = $query->orderBy('sort_order', 'asc')->get();

        return view('best-hotels', compact('settings', 'hotels', 'countries', 'cities'));
    }

    public function termsAndConditions()
    {
        $term = \App\Models\TermAndCondition::first();
        
        // If not found, create a dummy or handle 404. For now, abort 404 if no terms exist.
        if (!$term) {
            abort(404, 'Terms and Conditions not found.');
        }

        $images = [];
        if (!empty($term->images)) {
            $images = \Awcodes\Curator\Models\Media::whereIn('id', $term->images)->get();
        }

        return view('terms-and-conditions', compact('term', 'images'));
    }
}
