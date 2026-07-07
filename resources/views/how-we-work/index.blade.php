@extends('layouts.app')

@if(isset($seo_page) && $seo_page->meta_title)
    @section('meta_title', $seo_page->meta_title)
@else
    @section('meta_title', 'How We Work | Sentra Hotels')
@endif

@if(isset($seo_page) && $seo_page->meta_description)
    @section('meta_description', $seo_page->meta_description)
@else
    @section('meta_description', 'Pelajari bagaimana Sentra Hotels bekerja untuk memberikan layanan pemesanan hotel terbaik bagi agen B2B.')
@endif

@if(isset($seo_page) && $seo_page->meta_keywords)
    @section('meta_keywords', $seo_page->meta_keywords)
@endif

@if(isset($seo_page) && $seo_page->og_image)
    @section('og_image', asset('storage/' . $seo_page->og_image))
@endif

@section('content')
<main class="bg-slate-50 min-h-screen pb-20">

    <!-- SECTION 1: HERO BANNER (H-Auto / Menyesuaikan Gambar) -->
    <section class="relative w-full bg-slate-900">
        @if(isset($content) && $content->hero_image)
            <div class="w-full z-0 relative">
                <img src="{{ \Illuminate\Support\Str::startsWith($content->hero_image, ['http://', 'https://']) ? $content->hero_image : asset('storage/' . $content->hero_image) }}" 
                     alt="How We Work Hero" 
                     class="w-full h-auto block">
            </div>
        @else
            <!-- Fallback jika gambar belum diupload -->
            <div class="w-full h-[50vh] min-h-[400px] z-0 relative bg-slate-800 flex items-center justify-center">
                <span class="text-slate-500 font-medium">Hero Image belum diupload</span>
            </div>
        @endif
    </section>

    <!-- SECTION 2: KONTEN DESKRIPSI -->
    <section class="max-w-4xl mx-auto px-4 md:px-8 mt-8 md:mt-12 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8 md:p-14 pb-12 md:pb-20">
            
            <!-- Tiptap Content untuk Title -->
            <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed mb-10 pb-8 border-b border-slate-100 text-center">
                @if(isset($content) && $content->title_content)
                    {!! $content->title_content !!}
                @else
                    <h1 class="text-4xl font-serif font-bold">How We Work</h1>
                @endif
            </div>

            <!-- Tiptap content untuk Deskripsi Utama -->
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4">
                @if(isset($content) && $content->description)
                    {!! $content->description !!}
                @else
                    <p class="text-center text-slate-400 italic">Konten How We Work belum diisi dari dashboard admin.</p>
                @endif
            </div>
            
        </div>
    </section>

    <!-- SECTION 3: FAQ / ACCORDION -->
    @if(isset($content) && is_array($content->faqs) && count($content->faqs) > 0)
    <section class="max-w-3xl mx-auto px-4 md:px-8 mt-12 mb-20 relative z-20">
        <div class="space-y-4">
            @foreach($content->faqs as $faq)
            <div class="border border-slate-200 rounded-xl bg-slate-50 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex justify-between items-center p-6 text-left focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <span class="font-semibold text-slate-800 text-lg pr-8">{{ $faq['question'] ?? '' }}</span>
                    <span class="flex-shrink-0 text-blue-600 transition-transform duration-300" :class="{'rotate-180': open}">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </span>
                </button>
                <div x-show="open" x-collapse class="bg-white border-t border-slate-200" style="display: none;" x-cloak>
                    <div class="p-6 prose prose-slate max-w-none text-slate-600">
                        {!! $faq['answer'] ?? '' !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Menggunakan Alpine.js untuk fitur buka-tutup FAQ -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </section>
    @endif

</main>
@endsection
