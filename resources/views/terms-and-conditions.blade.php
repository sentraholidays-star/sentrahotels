@extends('layouts.app')

@if(isset($seo_page) && $seo_page)
    @section('meta_title', $seo_page->meta_title ?: $term->title)
    @section('meta_description', $seo_page->meta_description)
    @section('meta_keywords', is_array($seo_page->meta_keywords) ? implode(', ', $seo_page->meta_keywords) : $seo_page->meta_keywords)
    @if($seo_page->og_image)
        @section('og_image', asset('storage/' . $seo_page->og_image))
    @endif
@else
    @section('meta_title', $term->title)
@endif

@section('content')
<!-- Spacing for fixed navbar -->
<div class="pt-24 pb-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Carousel Section -->
        @if(count($images) > 0)
        <div class="mb-12 rounded-2xl overflow-hidden shadow-xl relative">
            <div class="swiper termSwiper">
                <div class="swiper-wrapper">
                    @foreach($images as $image)
                        <div class="swiper-slide">
                            <img src="{{ Storage::url($image->path) }}" alt="{{ $image->alt ?? $term->title }}" class="w-full h-[300px] md:h-[450px] object-cover">
                        </div>
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="swiper-pagination"></div>
                <!-- Navigation -->
                <div class="swiper-button-next !text-white drop-shadow-md after:!text-2xl"></div>
                <div class="swiper-button-prev !text-white drop-shadow-md after:!text-2xl"></div>
            </div>
        </div>
        @endif

        <!-- Title Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-serif text-slate-900 mb-4">{{ $term->title }}</h1>
            <div class="w-24 h-1 bg-amber-500 mx-auto rounded-full"></div>
        </div>

        <!-- Content Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 md:p-12 prose prose-lg prose-slate max-w-none prose-a:text-amber-600 hover:prose-a:text-amber-700">
            {!! $term->content !!}
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('.termSwiper')) {
            new Swiper('.termSwiper', {
                loop: true,
                speed: 800,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.termSwiper .swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.termSwiper .swiper-button-next',
                    prevEl: '.termSwiper .swiper-button-prev',
                },
            });
        }
    });
</script>
@endsection
