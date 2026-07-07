<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HowWeWork;
use App\Models\StaticPageSeo;

class HowWeWorkController extends Controller
{
    public function index()
    {
        $content = HowWeWork::latest()->first();
        $seo_page = StaticPageSeo::where('page_identifier', 'how-we-work')->first();
        
        return view('how-we-work.index', compact('content', 'seo_page'));
    }
}
