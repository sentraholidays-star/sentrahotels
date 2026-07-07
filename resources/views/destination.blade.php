@extends('layouts.app')

@section('meta_title', $destination->meta_title ?: ($destination->seo_title ?: ($destination->name . ' | Sentra Hotels')))
@section('meta_description', $destination->meta_description ?: ($destination->seo_description ?: $destination->tagline))
@if($destination->meta_keywords)
  @section('meta_keywords', $destination->meta_keywords)
@endif
@if($destination->og_image)
  @section('og_image', \Illuminate\Support\Str::startsWith($destination->og_image, ['http://', 'https://']) ? $destination->og_image : asset('storage/' . $destination->og_image))
@elseif($destination->thumbnail)
  @section('og_image', asset('storage/' . $destination->thumbnail))
@endif

@section('content')

    <main class="bg-slate-50 min-h-screen">
      <!-- Hero Banner Slider -->
      <section class="relative w-full h-[50vh] min-h-[400px] overflow-hidden bg-slate-900">
        <div class="absolute inset-0 z-0">
          @if(is_array($destination->hero_image) && count($destination->hero_image) > 0)
            @foreach(array_slice($destination->hero_image, 0, 1) as $index => $img)
              <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ \Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : asset('storage/' . $img) }}');"></div>
            @endforeach
          @else
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=2200&q=86');"></div>
          @endif
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-slate-900/20"></div>
        </div>
        
        <div class="relative z-10 flex flex-col items-center justify-center w-full h-full text-center px-4">
          <span class="text-amber-500 font-bold tracking-widest uppercase text-sm mb-4 drop-shadow-md">{{ $destination->tagline }}</span>
          <h1 class="text-5xl md:text-7xl font-serif text-white mb-6 drop-shadow-lg">{{ $destination->name }}</h1>
          <p class="text-lg md:text-xl text-slate-200 max-w-2xl drop-shadow-md">Discover the finest collection of luxury hotels in {{ $destination->name }}, carefully selected by Sentra Hotels.</p>
        </div>
      </section>

      <!-- Description Block -->
      @if($destination->description)
      <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 md:px-8 text-center">
          <div class="prose prose-lg prose-slate mx-auto prose-p:leading-relaxed prose-p:text-slate-600">
            {!! $destination->description !!}
          </div>
        </div>
      </section>
      @endif

      <!-- Grid Content Section -->
      <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 md:px-8 flex flex-col lg:flex-row gap-8">
          
          <!-- Filter Sidebar -->
          <aside class="w-full lg:w-1/4">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-24">
              <h3 class="text-xl font-serif text-slate-900 mb-6 border-b border-slate-100 pb-4">Filter Akomodasi</h3>
              <form method="GET" action="{{ url()->current() }}" id="filterForm" class="space-y-5">
                
                <!-- Destination / City Switcher -->
                <div>
                  <label for="citySelect" class="block text-sm font-semibold text-slate-700 mb-2">Kota / Destinasi</label>
                  <select id="citySelect" onchange="window.location.href = '/destination/' + this.value" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 transition-colors cursor-pointer">
                    @foreach($allDestinations as $d)
                      <option value="{{ $d->slug }}" {{ $d->slug === $destination->slug ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Stars Rating -->
                <div>
                  <label for="starsSelect" class="block text-sm font-semibold text-slate-700 mb-2">Peringkat Bintang</label>
                  <select name="stars" id="starsSelect" onchange="this.form.submit()" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 transition-colors cursor-pointer">
                    <option value="">Semua Bintang</option>
                    <option value="5" {{ request('stars') == '5' ? 'selected' : '' }}>5 Bintang (⭐⭐⭐⭐⭐)</option>
                    <option value="4" {{ request('stars') == '4' ? 'selected' : '' }}>4 Bintang (⭐⭐⭐⭐)</option>
                    <option value="3" {{ request('stars') == '3' ? 'selected' : '' }}>3 Bintang (⭐⭐⭐)</option>
                  </select>
                </div>

                <!-- Hotel Type -->
                <div>
                  <label for="typeSelect" class="block text-sm font-semibold text-slate-700 mb-2">Tipe Akomodasi</label>
                  <select name="type" id="typeSelect" onchange="this.form.submit()" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 transition-colors cursor-pointer">
                    <option value="">Semua Tipe</option>
                    <option value="Resort" {{ request('type') == 'Resort' ? 'selected' : '' }}>Resort</option>
                    <option value="City Hotel" {{ request('type') == 'City Hotel' ? 'selected' : '' }}>City Hotel</option>
                  </select>
                </div>

                <!-- Kategori / Tema -->
                <div>
                  <label for="themeSelect" class="block text-sm font-semibold text-slate-700 mb-2">Kategori Tema</label>
                  <select name="theme" id="themeSelect" onchange="this.form.submit()" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 transition-colors cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option value="family" {{ request('theme') == 'family' ? 'selected' : '' }}>Family Friendly</option>
                    <option value="business" {{ request('theme') == 'business' ? 'selected' : '' }}>Business Suitable</option>
                    <option value="beach" {{ request('theme') == 'beach' ? 'selected' : '' }}>Beach Resort</option>
                    <option value="luxury" {{ request('theme') == 'luxury' ? 'selected' : '' }}>Luxury Collection</option>
                  </select>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-100">
                  <a href="{{ route('destination.show', $destination->slug) }}" class="block w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-2.5 rounded-lg transition-colors text-sm">Reset Filter</a>
                </div>
              </form>
            </div>
          </aside>

          <!-- Listing Grid -->
          <div class="w-full lg:w-3/4">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-5">
              @forelse($hotels as $hotel)
                <article class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group relative">
                  <div class="relative aspect-[4/3] w-full overflow-hidden">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="{{ $hotel->thumbnailImage ? asset('storage/' . $hotel->thumbnailImage->path) : ($hotel->thumbnail ? (\Illuminate\Support\Str::startsWith($hotel->thumbnail, ['http://', 'https://']) ? $hotel->thumbnail : asset('storage/' . $hotel->thumbnail)) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80') }}" alt="{{ $hotel->name }}">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-300"></div>
                    <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                      @if($hotel->featured)
                        <span class="bg-blue-600 text-white text-[8px] font-normal uppercase tracking-wider py-1 px-2.5 rounded-full shadow-md backdrop-blur-sm bg-opacity-90">Best Deal</span>
                      @endif
                      @if($hotel->promotion)
                        <span class="bg-amber-500 text-white text-[8px] font-normal uppercase tracking-wider py-1 px-2.5 rounded-full shadow-md backdrop-blur-sm bg-opacity-90">Promo</span>
                      @endif
                    </div>
                  </div>
                  <div class="p-4 flex flex-col flex-1 bg-white text-left">
                    <h3 class="font-serif text-[14px] font-bold text-black leading-tight">
                      <a href="{{ route('hotel.show', $hotel->slug) }}" class="focus:outline-none after:absolute after:inset-0 after:z-0">
                        {{ $hotel->name }}
                      </a>
                    </h3>
                  </div>
                </article>
              @empty
                <div class="col-span-full flex flex-col items-center justify-center p-12 bg-white rounded-xl border border-slate-200 border-dashed text-center">
                  <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                  <p class="text-slate-600 font-medium mb-4">Tidak ada hotel mewah yang cocok dengan kriteria filter saat ini.</p>
                  <a href="{{ route('destination.show', $destination->slug) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-lg transition-colors">Reset Semua Filter</a>
                </div>
              @endforelse
            </div>

            <!-- Laravel Pagination Links -->
            @if($hotels->hasPages())
              <div class="mt-12 flex justify-center w-full overflow-hidden">
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200">
                  {{ $hotels->links() }}
                </div>
              </div>
            @endif
          </div>

        </div>
      </section>
    </main>

@endsection
