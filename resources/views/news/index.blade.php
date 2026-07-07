@extends('layouts.app')

@if(isset($seo_page) && $seo_page->meta_title)
    @section('meta_title', $seo_page->meta_title)
@else
    @section('meta_title', 'News | Sentra Hotels')
@endif

@if(isset($seo_page) && $seo_page->meta_description)
    @section('meta_description', $seo_page->meta_description)
@else
    @section('meta_description', 'Baca berita perjalanan, informasi destinasi luxury, dan penawaran hotel bintang 4 & 5 terbaru dari Sentra Hotels.')
@endif

@if(isset($seo_page) && $seo_page->meta_keywords)
    @section('meta_keywords', $seo_page->meta_keywords)
@endif

@if(isset($seo_page) && $seo_page->og_image)
    @section('og_image', asset('storage/' . $seo_page->og_image))
@endif

@section('content')
<main class="bg-slate-50 min-h-screen">
  @if($featured->count() > 0)
    <!-- News Hero Carousel -->
    <section class="relative w-full h-[50vh] min-h-[400px] overflow-hidden bg-slate-900 swiper newsHeroSwiper" aria-labelledby="news-hero-title">
      <div class="swiper-wrapper w-full h-full">
        @foreach($featured as $article)
          <div class="swiper-slide w-full h-full relative">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ \Illuminate\Support\Str::startsWith($article->cover_image, ['http://', 'https://']) ? $article->cover_image : asset('storage/' . $article->cover_image) }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16 z-10 text-center md:text-left">
              <div class="max-w-4xl mx-auto md:mx-0">
                <span class="inline-block bg-blue-600 text-white text-xs font-bold uppercase tracking-wider py-1.5 px-3 rounded-full mb-4 shadow-md">Featured Article</span>
                <h2 id="news-hero-title" class="text-3xl md:text-5xl font-serif text-white mb-4 leading-tight drop-shadow-lg">{{ $article->title }}</h2>
                <p class="text-slate-200 text-lg md:text-xl mb-6 drop-shadow-md hidden md:block">{{ Str::limit(strip_tags($article->content), 140) }}</p>
                <a href="{{ route('news.show', $article->slug) }}" class="inline-block bg-white hover:bg-slate-100 text-slate-900 font-semibold py-3 px-8 rounded-lg transition-colors shadow-md">Baca Selengkapnya</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="swiper-pagination !bottom-6"></div>
    </section>
  @endif

  <!-- News Grid Section -->
  <section class="py-20">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
      <div class="text-center mb-16 max-w-3xl mx-auto">
        <span class="text-blue-600 font-semibold tracking-widest uppercase text-xs mb-3 block">Berita & Artikel</span>
        <h2 class="text-4xl md:text-5xl font-serif text-slate-900 mb-6">News</h2>
        <p class="text-slate-600 text-lg">Temukan inspirasi destinasi, tips liburan mewah, dan info seputar hotel</p>
      </div>

      @if($articles->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          @foreach($articles as $article)
            <article class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col group">
              <a href="{{ route('news.show', $article->slug) }}" class="relative h-56 w-full overflow-hidden block">
                <img src="{{ \Illuminate\Support\Str::startsWith($article->cover_image, ['http://', 'https://']) ? $article->cover_image : asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-300"></div>
              </a>
              <div class="p-6">
                <h3 class="font-serif text-sm md:text-[15px] font-normal text-slate-900 leading-snug group-hover:text-blue-600 transition-colors text-left">
                  <a href="{{ route('news.show', $article->slug) }}">{{ $article->title }}</a>
                </h3>
              </div>
            </article>
          @endforeach
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
          <div class="mt-16 flex justify-center w-full overflow-hidden">
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200">
              {{ $articles->links() }}
            </div>
          </div>
        @endif
      @else
        <div class="flex flex-col items-center justify-center p-16 bg-white rounded-xl border border-slate-200 border-dashed text-center">
          <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
          <p class="text-slate-500 font-medium text-lg">Belum ada artikel yang diterbitkan saat ini.</p>
        </div>
      @endif
    </div>
  </section>
</main>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (typeof Swiper !== 'undefined' && document.querySelector('.newsHeroSwiper')) {
      new Swiper('.newsHeroSwiper', {
        loop: true,
        effect: 'fade',
        fadeEffect: {
          crossFade: true
        },
        speed: 800,
        autoplay: {
          delay: 6000,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
      });
    }
  });
</script>
@endsection
