@extends('layouts.app')

@if(isset($seo_page) && $seo_page->meta_title)
    @section('meta_title', 'Join Us - ' . $seo_page->meta_title)
@else
    @section('meta_title', 'Join Us | Sentra Hotels')
@endif

@if(isset($seo_page) && $seo_page->meta_description)
    @section('meta_description', $seo_page->meta_description)
@endif

@section('content')
<main class="min-h-screen bg-slate-50 pb-24">
    
    <!-- SECTION 1: HERO BANNER -->
    <section class="relative w-full bg-slate-900">
        <div class="w-full z-0 relative">
            @if(isset($b2bInfo) && $b2bInfo->join_us_hero_image)
                <img src="{{ asset('storage/' . $b2bInfo->join_us_hero_image) }}" alt="Join Us Sentra Hotels" class="w-full h-auto block">
            @else
                <img src="https://images.unsplash.com/photo-1560264280-08c914282851?auto=format&fit=crop&w=1920&q=80" alt="Join Us Placeholder" class="w-full h-auto block">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 to-slate-900/80"></div>
        </div>
        
    </section>

    <!-- SECTION 2: KONTEN DESKRIPSI -->
    <section class="max-w-4xl mx-auto px-4 md:px-8 mt-8 md:mt-12 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8 md:p-14 pb-12 md:pb-20">
            
            <div class="flex flex-col items-center text-center mb-10 md:mb-14">
                <h2 class="text-3xl md:text-5xl font-serif text-slate-900 mb-6 leading-tight">
                    {{ $b2bInfo->join_us_title ?? 'Join Our Exclusive Network' }}
                </h2>
                <div class="w-20 h-1.5 bg-blue-600 rounded-full"></div>
            </div>

            <!-- Tiptap content diformat dengan Tailwind Prose (Sama seperti halaman News & B2B) -->
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-4">
                @if(isset($b2bInfo) && $b2bInfo->join_us_description)
                    {!! $b2bInfo->join_us_description !!}
                @else
                    <p class="text-center text-slate-400 italic">Konten Join Us belum diisi dari dashboard admin.</p>
                @endif
            </div>
            
        </div>
    </section>

    <!-- SECTION 3: FAQ PERSYARATAN -->
    @if(isset($b2bInfo) && is_array($b2bInfo->join_us_requirements) && count($b2bInfo->join_us_requirements) > 0)
    <section class="max-w-3xl mx-auto px-4 md:px-8 mt-16 relative z-20">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-4xl font-serif text-slate-900 mb-4">Persyaratan Sub Agen Sentra Hotels</h2>
            <div class="w-16 h-1 bg-blue-600 rounded-full mx-auto"></div>
        </div>

        <div class="space-y-4">
            @foreach($b2bInfo->join_us_requirements as $req)
            <div x-data="{ open: false }" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md">
                <button @click="open = !open" class="w-full text-left px-6 py-5 flex items-center justify-between focus:outline-none cursor-pointer">
                    <span class="font-semibold text-slate-800 text-lg pr-8">{{ $req['question'] ?? '' }}</span>
                    <span class="text-blue-600 flex-shrink-0 transition-transform duration-300" :class="{'rotate-180': open}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </button>
                <div x-show="open" 
                     x-collapse 
                     x-cloak
                     class="px-6 pb-6 text-slate-600 prose prose-slate max-w-none text-sm md:text-base border-t border-slate-100 pt-4">
                    {!! $req['answer'] ?? '' !!}
                </div>
            </div>
            @endforeach
        </div>

        <!-- Plugin Collapse untuk animasi smooth -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
        <!-- Menggunakan Alpine.js untuk fitur buka-tutup FAQ -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </section>
    @endif

</main>
@endsection
