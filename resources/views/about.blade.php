@extends('layouts.app')

@section('meta_title', $profile->meta_title ?: ($profile->title . ' | Sentra Hotels'))
@section('meta_description', $profile->meta_description ?: Str::limit(strip_tags($profile->content), 150))
@if($profile->meta_keywords)
  @section('meta_keywords', $profile->meta_keywords)
@endif
@if($profile->og_image)
  @section('og_image', \Illuminate\Support\Str::startsWith($profile->og_image, ['http://', 'https://']) ? $profile->og_image : asset('storage/' . $profile->og_image))
@elseif($profile->hero_images && count($profile->hero_images) > 0)
  @section('og_image', \Illuminate\Support\Str::startsWith($profile->hero_images[0], ['http://', 'https://']) ? $profile->hero_images[0] : asset('storage/' . $profile->hero_images[0]))
@endif

@section('content')
<main class="bg-slate-50 min-h-screen">
  <!-- About Hero Swiper Banner -->
  @if($profile->hero_images && count($profile->hero_images) > 0)
    <section class="relative w-full h-[60vh] min-h-[400px] max-h-[600px] bg-slate-900 overflow-hidden swiper aboutHeroSwiper">
      <div class="swiper-wrapper w-full h-full">
        @foreach($profile->hero_images as $image)
          <div class="swiper-slide w-full h-full">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ \Illuminate\Support\Str::startsWith($image, ['http://', 'https://']) ? $image : asset('storage/' . $image) }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/20 to-slate-900/60"></div>
          </div>
        @endforeach
      </div>
      @if(count($profile->hero_images) > 1)
        <div class="swiper-button-next !text-white opacity-70 hover:opacity-100 transition-opacity drop-shadow-md"></div>
        <div class="swiper-button-prev !text-white opacity-70 hover:opacity-100 transition-opacity drop-shadow-md"></div>
        <div class="swiper-pagination"></div>
      @endif
    </section>
  @else
    <!-- Fallback Banner -->
    <section class="relative w-full h-[60vh] min-h-[400px] max-h-[600px] bg-slate-900 overflow-hidden">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1920')"></div>
      <div class="absolute inset-0 bg-gradient-to-b from-slate-900/20 to-slate-900/60"></div>
    </section>
  @endif

  <!-- About Content Section -->
  <section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 md:px-8">
      <h1 class="font-serif text-3xl md:text-5xl text-center text-slate-900 mb-12 leading-tight">{{ $profile->title }}</h1>
      
      <!-- Konten artikel dinamis dirapikan otomatis menggunakan 'prose' Tailwind -->
      <div class="prose prose-lg md:prose-xl prose-slate max-w-none mx-auto
                  prose-headings:font-serif prose-headings:font-medium prose-headings:text-slate-900 
                  prose-p:text-slate-600 prose-p:leading-relaxed 
                  prose-a:text-blue-600 hover:prose-a:text-blue-700 
                  prose-img:rounded-xl prose-img:shadow-md prose-img:mx-auto
                  prose-blockquote:border-l-4 prose-blockquote:border-amber-500 prose-blockquote:bg-slate-50 prose-blockquote:py-4 prose-blockquote:px-6 prose-blockquote:italic prose-blockquote:rounded-r-lg">
        {!! $profile->content !!}
      </div>
    </div>
  </section>
</main>
@endsection

@section('scripts')
@if($profile->hero_images && count($profile->hero_images) > 1)
<script>
  document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.aboutHeroSwiper', {
      loop: true,
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      speed: 1000,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  });
</script>
@endif
@endsection
