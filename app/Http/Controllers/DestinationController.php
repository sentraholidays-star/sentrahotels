<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        // Ambil destinasi aktif diurutkan berdasarkan sort_order, dipaginasi 12 per halaman
        $destinations = Destination::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->paginate(12);

        $seo_page = \App\Models\StaticPageSeo::where('page_identifier', 'destinations')->first();

        return view('destination.index', compact('destinations', 'seo_page'));
    }
}
