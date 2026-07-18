@extends('layouts.app')

@if(isset($seo_page) && $seo_page->meta_title)
    @section('meta_title', $seo_page->meta_title)
@else
    @section('meta_title', 'B2B Online Booking | Sentra Hotels')
@endif

@if(isset($seo_page) && $seo_page->meta_description)
    @section('meta_description', $seo_page->meta_description)
@endif

@if(isset($seo_page) && $seo_page->meta_keywords)
    @section('meta_keywords', is_array($seo_page->meta_keywords) ? implode(', ', $seo_page->meta_keywords) : $seo_page->meta_keywords)
@endif

@if(isset($seo_page) && $seo_page->og_image)
    @section('og_image', asset('storage/' . $seo_page->og_image))
@elseif(isset($b2bInfo) && is_array($b2bInfo->images) && count($b2bInfo->images) > 0)
    @section('og_image', asset('storage/' . $b2bInfo->images[0]))
@endif

@section('content')
<main class="min-h-screen bg-slate-50 pb-24">
    
    <!-- SECTION 1: HERO BANNER CAROUSEL -->
    <section class="relative w-full h-[50vh] md:h-[60vh] min-h-[400px] max-h-[600px] bg-slate-900">
        <div class="swiper b2bSwiper w-full h-full absolute inset-0 z-0">
            <div class="swiper-wrapper">
                @if(isset($b2bInfo) && !empty($b2bInfo->images) && is_array($b2bInfo->images))
                    @foreach($b2bInfo->images as $image)
                        <div class="swiper-slide relative overflow-hidden">
                            <img src="{{ asset('storage/' . $image) }}" alt="B2B Sentra Hotels" class="w-full h-full object-cover object-center">
                            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 to-slate-900/80"></div>
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551882547-ff40c6d5a2f6?auto=format&fit=crop&w=1920&q=80" alt="B2B Placeholder" class="w-full h-full object-cover object-center">
                        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 to-slate-900/80"></div>
                    </div>
                @endif
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next !text-white opacity-60 hover:opacity-100 transition-opacity drop-shadow-md"></div>
            <div class="swiper-button-prev !text-white opacity-60 hover:opacity-100 transition-opacity drop-shadow-md"></div>
        </div>
        
        <div class="absolute inset-0 z-10 flex flex-col items-center justify-center pointer-events-none">
            <h1 class="text-4xl md:text-6xl font-serif font-bold text-white mb-4 drop-shadow-lg text-center px-4">
                {{ $b2bInfo->hero_title ?? 'B2B Corporate & Agent' }}
            </h1>
        </div>
    </section>

    <!-- SECTION 2: KONTEN DESKRIPSI -->
    <section class="max-w-4xl mx-auto px-4 md:px-8 -mt-10 md:-mt-16 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8 md:p-14 pb-12 md:pb-20">
            
            <div class="flex flex-col items-center text-center mb-10 md:mb-14">
                <h2 class="text-3xl md:text-5xl font-serif text-slate-900 mb-6 leading-tight">
                    {{ $b2bInfo->title ?? 'Mitra Strategis Bisnis Anda' }}
                </h2>
                <div class="w-20 h-1.5 bg-blue-600 rounded-full"></div>
            </div>

            <!-- Tiptap content diformat dengan Tailwind Prose -->
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4">
                @if(isset($b2bInfo) && $b2bInfo->description)
                    {!! $b2bInfo->description !!}
                @else
                    <p class="text-center text-slate-400 italic">Konten belum diisi dari dashboard admin.</p>
                @endif
            </div>
            
        </div>
    </section>

</main>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if(typeof Swiper !== 'undefined') {
            const b2bSwiper = new Swiper('.b2bSwiper', {
                loop: true,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                speed: 1200, 
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            });
        }
    });
</script>
@endsection