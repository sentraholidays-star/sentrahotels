<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Halaman daftar artikel (News Index)
    public function index()
    {
        // 5 artikel unggulan (featured) terbaru untuk Swiper.js Slider
        $featured = Article::where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ambil ID artikel unggulan agar tidak ganda di grid bawah
        $featuredIds = $featured->pluck('id');

        // Sisa artikel di luar artikel unggulan, dipaginasi 9 per halaman
        $articles = Article::whereNotIn('id', $featuredIds)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $seo_page = \App\Models\StaticPageSeo::where('page_identifier', 'news')->first();

        return view('news.index', compact('featured', 'articles', 'seo_page'));
    }

    // Halaman detail artikel (News Detail)
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        // 3 artikel terkait (artikel terbaru lainnya)
        $relatedArticles = Article::where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('news.show', compact('article', 'relatedArticles'));
    }
}
