@extends('layouts.app')

@section('meta_title', $article->meta_title ?: ($article->title . ' | Sentra Hotels News'))
@section('meta_description', $article->meta_description ?: Str::limit(strip_tags($article->content), 150))
@if($article->meta_keywords)
  @section('meta_keywords', $article->meta_keywords)
@endif
@if($article->cover_image)
  @section('og_image', \Illuminate\Support\Str::startsWith($article->cover_image, ['http://', 'https://']) ? $article->cover_image : asset('storage/' . $article->cover_image))
@endif

@section('content')
    <main class="flex-grow max-w-4xl mx-auto px-4 py-10 w-full">
        <a href="{{ route('news.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm inline-flex items-center gap-2 mb-6 transition duration-200">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Berita
        </a>
        
        <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 p-6 md:p-10 mb-10">
            <header class="mb-6">
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">{{ $article->title }}</h1>
                <p class="text-xs text-slate-400 mt-3">
                    Diposting pada {{ $article->created_at->translatedFormat('d F Y H:i') }}
                    @if($article->author)
                        &bull; Oleh {{ $article->author }}
                    @endif
                </p>
            </header>

            @if($article->cover_image)
                <div class="w-full bg-slate-50 overflow-hidden flex items-center justify-center rounded-xl mb-6 shadow-sm border border-slate-100">
                    <img src="{{ \Illuminate\Support\Str::startsWith($article->cover_image, ['http://', 'https://']) ? $article->cover_image : asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}" class="w-full max-h-[460px] object-contain rounded-xl">
                </div>
            @endif

            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4">
                {!! $article->content !!}
            </div>
        </article>

        @if(isset($relatedArticles) && $relatedArticles->count() > 0)
            <section class="mt-10 border-t border-slate-200 pt-10">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Artikel Lainnya</h2>
                <div class="swiper relatedSwiper">
                    <div class="swiper-wrapper">
                        @foreach($relatedArticles as $item)
                            <div class="swiper-slide px-1">
                                <a href="{{ route('news.show', $item->slug) }}" class="block rounded-2xl overflow-hidden shadow-sm bg-white border border-slate-100 transition duration-300 ease-out hover:-translate-y-1 hover:border-slate-300 hover:shadow-md h-full flex flex-col">
                                    <div class="h-36 bg-slate-100 overflow-hidden">
                                        @if($item->cover_image)
                                            <img src="{{ \Illuminate\Support\Str::startsWith($item->cover_image, ['http://', 'https://']) ? $item->cover_image : asset('storage/' . $item->cover_image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-200">No Image</div>
                                        @endif
                                    </div>
                                    <div class="p-4 flex flex-col flex-grow">
                                        <h3 class="text-sm font-semibold text-slate-900 line-clamp-2 mb-1 flex-grow">{{ $item->title }}</h3>
                                        <p class="text-[11px] text-slate-400 mt-2">{{ $item->created_at->translatedFormat('d F Y') }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination mt-6"></div>
                </div>
            </section>
        @endif
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swiper !== 'undefined' && document.querySelector('.relatedSwiper')) {
                new Swiper('.relatedSwiper', {
                    slidesPerView: 1.2,
                    spaceBetween: 16,
                    breakpoints: { 
                        640: { slidesPerView: 2 },
                        768: { slidesPerView: 3 } 
                    },
                    loop: true,
                    autoplay: { delay: 3500, disableOnInteraction: false },
                    pagination: { el: '.swiper-pagination', clickable: true }
                });
            }
        });
    </script>
@endsection
