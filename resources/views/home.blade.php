@extends('layouts.app')

@if(isset($seo_page))
    @if($seo_page->meta_title) @section('meta_title', $seo_page->meta_title) @endif
    @if($seo_page->meta_description) @section('meta_description', $seo_page->meta_description) @endif
    @if($seo_page->meta_keywords) @section('meta_keywords', $seo_page->meta_keywords) @endif
    @if($seo_page->og_image) @section('og_image', asset('storage/' . $seo_page->og_image)) @endif
@endif

@section('content')

    <main id="top" class="bg-slate-50 min-h-screen">
      <!-- Hero Section -->
      <section class="relative w-full overflow-hidden bg-slate-900" style="height: 80vh; min-height: 500px;" aria-labelledby="hero-title">
        <!-- Swiper -->
        <div class="swiper heroSwiper w-full h-full absolute inset-0 z-0">
          <div class="swiper-wrapper">
            @if(isset($hero) && $hero->images && count($hero->images) > 0)
              @foreach($hero->images as $img)
                <div class="swiper-slide w-full h-full">
                  <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : asset('storage/' . $img) }}')"></div>
                  <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/40 to-slate-900/80"></div>
                </div>
              @endforeach
            @else
              <div class="swiper-slide w-full h-full">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/40 to-slate-900/80"></div>
              </div>
            @endif
          </div>
          <div class="swiper-pagination"></div>
        </div>

        <div class="absolute inset-0 z-10 flex flex-col items-center justify-center w-full h-full px-4 pointer-events-none">
          <div class="w-full max-w-4xl mx-auto flex flex-col items-center pointer-events-auto">
            <p class="text-amber-500 font-bold tracking-[0.2em] uppercase text-sm md:text-base mb-4 drop-shadow-md text-center">{{ $hero->introduction ?? 'Luxury hotels, handled offline' }}</p>
            <h1 id="hero-title" class="text-white font-serif text-5xl md:text-7xl font-medium drop-shadow-lg leading-tight text-center mb-6">{{ $hero->title ?? 'Sentra Hotels' }}</h1>
            
            <div class="text-white text-lg md:text-xl drop-shadow-md prose prose-invert prose-p:text-white prose-p:leading-relaxed w-full">
              {!! $hero->description ?? '<p class="text-center">Kurasi dan reservasi hotel bintang 4 dan 5 untuk perjalanan bisnis, liburan premium, grup, corporate rate, dan kebutuhan MICE.</p>' !!}
            </div>
          </div>
        </div>
      </section>

      <!-- Start Preferred Hotels Section -->
      @if(isset($preferredHotels) && $preferredHotels->count() > 0)
        <section class="py-16 bg-white border-b border-slate-200" aria-labelledby="preferred-title">
          <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-10">
              <h2 id="preferred-title" class="text-2xl md:text-3xl font-serif text-slate-800">Preferred Hotels</h2>
            </div>
            
            <div class="swiper preferredSwiper">
              <div class="swiper-wrapper items-center">
                @foreach($preferredHotels as $chain)
                  <div class="swiper-slide flex justify-center p-4">
                    <img class="h-[90px] md:h-[120px] object-contain transition duration-300 border-[0.5px] border-[#D4AF37] p-3 rounded-lg" src="{{ \Illuminate\Support\Str::startsWith($chain->image, ['http://', 'https://']) ? $chain->image : asset('storage/' . $chain->image) }}" alt="{{ $chain->name }} Logo" title="{{ $chain->name }}">
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </section>
      @endif
      <!-- End Preferred Hotels Section -->

      @if($global_settings->is_destination_active)
      <section class="py-20 bg-slate-50" id="collection" aria-labelledby="collection-title">
        <div class="max-w-7xl mx-auto px-4">
          <div class="mb-12 md:text-center max-w-3xl mx-auto">
            <p class="text-blue-600 font-semibold tracking-widest uppercase text-xs mb-3">Destinasi</p>
            <h2 id="collection-title" class="text-3xl md:text-5xl font-serif text-slate-900 mb-6">Pilihan Destinasi Premium</h2>
            <p class="text-slate-600 text-lg">Kami menawarkan Hotel dan Resort premium domestik dan internasional, dengan harga terbaik.</p>
          </div>

          <div class="swiper destinationSwiper !pb-8">
            <div class="swiper-wrapper">
              @foreach($destinations as $dest)
                <div class="swiper-slide !w-[85%] md:!w-[350px]">
                  <a href="{{ route('destination.show', $dest->slug) }}" class="block aspect-square relative group overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 bg-slate-200">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="{{ $dest->thumbnail ? (\Illuminate\Support\Str::startsWith($dest->thumbnail, ['http://', 'https://']) ? $dest->thumbnail : asset('storage/' . $dest->thumbnail)) : 'https://images.unsplash.com/photo-1551882547-ff40c0d5b9af?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $dest->name }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-6 left-6 right-6 z-10">
                      <p class="text-amber-400 font-bold uppercase tracking-widest text-[10px] mb-2">{{ $dest->tagline ?? 'Destinasi Premium' }}</p>
                      <h3 class="text-2xl font-serif text-white">{{ $dest->name }}</h3>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </section>
      @endif

      @if(isset($faqs) && $faqs->count() > 0)
        <section class="py-24 bg-white" id="faq" aria-labelledby="faq-title">
          <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-16">
              <p class="text-blue-600 font-semibold tracking-widest uppercase text-xs mb-3">{{ $global_settings->faq_kicker ?? 'PERTANYAAN UMUM' }}</p>
              <h2 id="faq-title" class="text-3xl md:text-5xl font-serif text-slate-900 mb-6">{{ $global_settings->faq_title ?? 'Frequently Asked Questions' }}</h2>
              <p class="text-slate-600 text-lg">{{ $global_settings->faq_subtitle ?? 'Temukan jawaban untuk berbagai pertanyaan umum mengenai kurasi, negosiasi, dan proses pemesanan hotel premium di Sentra Hotels.' }}</p>
            </div>
            
            <div class="space-y-4">
              @foreach($faqs as $faq)
                <div class="border border-slate-200 rounded-xl bg-slate-50 overflow-hidden" x-data="{ open: false }">
                  <button @click="open = !open" class="w-full flex justify-between items-center p-6 text-left focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <span class="font-semibold text-slate-800 text-lg pr-8">{{ $faq->question }}</span>
                    <span class="flex-shrink-0 text-blue-600 transition-transform duration-300" :class="{'rotate-180': open}">
                      <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                      </svg>
                    </span>
                  </button>
                  <div x-show="open" x-collapse class="bg-white border-t border-slate-200" style="display: none;">
                    <div class="p-6 prose prose-slate max-w-none text-slate-600">
                      {!! $faq->answer !!}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            
            <!-- Menggunakan Alpine.js untuk fitur buka-tutup FAQ -->
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
          </div>
        </section>
      @endif

    </main>

@endsection