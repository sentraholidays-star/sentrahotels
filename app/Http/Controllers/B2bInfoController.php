<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\B2bInfo;

class B2bInfoController extends Controller
{
    public function index()
    {
        $b2bInfo = B2bInfo::latest()->first();
        $seo_page = \App\Models\StaticPageSeo::where('page_identifier', 'b2b')->first();
        return view('b2b.index', compact('b2bInfo', 'seo_page'));
    }

    public function joinUs()
    {
        $b2bInfo = B2bInfo::latest()->first();
        // Load Join Us specific SEO
        $seo_page = \App\Models\StaticPageSeo::where('page_identifier', 'join-us')->first();
        return view('b2b.join-us', compact('b2bInfo', 'seo_page'));
    }
}
