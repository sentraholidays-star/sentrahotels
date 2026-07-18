@extends('layouts.app')

@section('title', 'Best Hotels - Sentra Hotels')
@section('meta_description', 'Temukan penawaran eksklusif terbaik dari Sentra Hotels.')

@php
    $banners = $settings->best_hotel_banners ?? [];
    $hasBanners = is_array($banners) && count($banners) > 0;
    if ($hasBanners) {
        $firstMedia = \Awcodes\Curator\Models\Media::find($banners[0]);
    }
@endphp

@if($hasBanners && isset($firstMedia) && $firstMedia)
    @section('og_image', $firstMedia->url)
@endif

@section('content')

<!-- HERO BANNER SECTION -->
<section class="relative bg-slate-900 w-full h-[60vh] min-h-[400px]">
    @php
        $banners = $settings->best_hotel_banners ?? [];
        $hasBanners = is_array($banners) && count($banners) > 0;
    @endphp

    @if($hasBanners)
        <div class="swiper exclusiveHeroSwiper w-full h-full absolute inset-0">
            <div class="swiper-wrapper">
                @foreach($banners as $mediaId)
                    @php
                        $media = \Awcodes\Curator\Models\Media::find($mediaId);
                    @endphp
                    @if($media)
                    <div class="swiper-slide w-full h-full relative">
                        <img src="{{ $media->url }}" class="w-full h-full object-cover object-center" alt="Banner Best Hotels">
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>
                    @endif
                @endforeach
            </div>
            <!-- Pagination (Jika banner lebih dari 1) -->
            @if(count($banners) > 1)
                <div class="swiper-pagination !bottom-8"></div>
            @endif
        </div>
    @else
        <div class="w-full h-full flex items-center justify-center bg-slate-800">
            <!-- Fallback solid color if no banner -->
        </div>
    @endif

    <!-- Overlay Text (Static) -->
    <div class="absolute inset-0 z-10 flex items-center justify-center text-center px-4">
        <div>
            <h1 class="text-4xl md:text-6xl font-serif text-white mb-4 drop-shadow-lg">
                {{ $settings->hotel_promo_title ?? 'Exclusive Inventory & Best Price Guarantee' }}
            </h1>
            <p class="text-lg md:text-2xl text-slate-200 drop-shadow-md">
                {{ $settings->hotel_promo_subtitle ?? 'Penawaran spesial khusus untuk Anda' }}
            </p>
        </div>
    </div>
</section>

<!-- MAIN CONTENT (FILTER & GRID) -->
<section class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- WIDGET FILTER -->
        <div class="bg-white p-6 rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 mb-10">
            <form action="{{ route('exclusive-rates') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end" id="filterForm">
                
                <!-- Country Dropdown -->
                <div class="w-full md:w-1/3">
                    <label for="country" class="block text-sm font-semibold text-slate-700 mb-2">Country</label>
                    <select name="country" id="country" class="w-full rounded-lg border-slate-300 focus:border-amber-500 focus:ring-amber-500 shadow-sm" onchange="document.getElementById('filterForm').submit();">
                        <option value="">Semua Negara</option>
                        @foreach($countries as $country)
                            <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- City Dropdown -->
                <div class="w-full md:w-1/3">
                    <label for="city" class="block text-sm font-semibold text-slate-700 mb-2">City</label>
                    <select name="city" id="city" class="w-full rounded-lg border-slate-300 focus:border-amber-500 focus:ring-amber-500 shadow-sm" onchange="document.getElementById('filterForm').submit();">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Button -->
                <div class="w-full md:w-auto mt-4 md:mt-0">
                    <a href="{{ route('exclusive-rates') }}" class="inline-flex items-center justify-center w-full md:w-auto px-6 py-2.5 border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium transition-colors focus:ring-2 focus:ring-slate-200">
                        <i class="fa-solid fa-rotate-right mr-2"></i> Reset Filter
                    </a>
                </div>
            </form>
        </div>

        <!-- HOTEL CARDS GRID -->
        @if($hotels->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($hotels as $rate)
                    <!-- Card (Tanpa hover lift-up, cursor default) -->
                    <div class="bg-white rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
                        
                        <!-- Gambar (Object Cover) -->
                        <div class="w-full aspect-[4/3] bg-slate-200 relative overflow-hidden group">
                            @php
                                $imgUrl = $rate->image ? $rate->image->url : 'https://images.unsplash.com/photo-1551882547-ff40c0d5b9af?auto=format&fit=crop&w=600&q=80';
                            @endphp
                            <!-- Efek Zoom-in di gambar masih ada supaya tidak terlalu kaku, namun jika ingin benar-benar diam hapus class group-hover:scale-105 -->
                            <img src="{{ $imgUrl }}" alt="{{ $rate->hotel_name }}" class="w-full h-full object-cover transition-transform duration-700">
                        </div>

                        <!-- Info Teks -->
                        <div class="p-5">
                            <!-- Star Rating -->
                            <div class="flex items-center gap-1 mb-2 text-amber-500 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rate->star_rating)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star text-slate-300"></i>
                                    @endif
                                @endfor
                            </div>
                            
                            <!-- Nama Hotel -->
                            <h3 class="text-lg font-bold text-slate-900 mb-1 line-clamp-1" title="{{ $rate->hotel_name }}">{{ $rate->hotel_name }}</h3>
                            
                            <!-- Alamat -->
                            <p class="text-sm text-slate-500 line-clamp-2 mt-2 flex items-start gap-1">
                                <i class="fa-solid fa-location-dot mt-1 text-slate-400"></i>
                                <span>
                                    {{ $rate->address }}<br>
                                    <span class="font-medium">{{ $rate->city }}, {{ $rate->country }}</span>
                                </span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-slate-100">
                <i class="fa-solid fa-hotel text-4xl text-slate-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-slate-700">Tidak ada penawaran saat ini</h3>
                <p class="text-slate-500 mt-2">Silakan periksa kembali nanti atau coba ubah kriteria pencarian Anda.</p>
            </div>
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('.exclusiveHeroSwiper')) {
            const exclusiveHeroSwiper = new Swiper('.exclusiveHeroSwiper', {
                loop: true,
                speed: 1000,
                effect: 'fade',
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                }
            });
        }
    });
</script>
@endpush
