@extends('layouts.app')

@if(isset($seo_page) && $seo_page->meta_title)
    @section('meta_title', $seo_page->meta_title)
@else
    @section('meta_title', 'Koleksi Destinasi Premium | Sentra Hotels')
@endif

@if(isset($seo_page) && $seo_page->meta_description)
    @section('meta_description', $seo_page->meta_description)
@else
    @section('meta_description', 'Temukan berbagai pilihan destinasi wisata premium di seluruh penjuru kota terbaik domestik dan internasional dari Sentra Hotels.')
@endif

@if(isset($seo_page) && $seo_page->meta_keywords)
    @section('meta_keywords', $seo_page->meta_keywords)
@endif

@if(isset($seo_page) && $seo_page->og_image)
    @section('og_image', asset('storage/' . $seo_page->og_image))
@endif

@section('content')
<main class="bg-slate-50 min-h-screen pt-24 pb-20">
  <!-- Header Section -->
  <section class="py-12 bg-white border-b border-slate-200 mb-12">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <span class="text-blue-600 font-semibold tracking-widest uppercase text-xs mb-3 block">Destinasi</span>
      <h1 class="text-3xl md:text-5xl font-serif text-slate-900 mb-6">Koleksi Destinasi Premium</h1>
      <p class="text-slate-600 text-lg leading-relaxed max-w-2xl mx-auto">
        Temukan pilihan hotel dan resort terbaik di berbagai kota tujuan terfavorit Anda, dikurasi secara eksklusif dengan penawaran harga offline terbaik.
      </p>
    </div>
  </section>

  <!-- Grid Section -->
  <section class="max-w-6xl mx-auto px-4 md:px-8">
    @if($destinations->count() > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($destinations as $dest)
          <a href="{{ route('destination.show', $dest->slug) }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-slate-200 overflow-hidden group block">
            <div class="w-full aspect-[4/3] overflow-hidden relative">
              <img src="{{ $dest->thumbnail ? (\Illuminate\Support\Str::startsWith($dest->thumbnail, ['http://', 'https://']) ? $dest->thumbnail : asset('storage/' . $dest->thumbnail)) : 'https://images.unsplash.com/photo-1551882547-ff40c0d5b9af?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $dest->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            </div>
            <div class="p-5 text-center bg-white">
              <h3 class="font-serif text-xl font-medium text-black">{{ $dest->name }}</h3>
            </div>
          </a>
        @endforeach
      </div>

      <!-- Pagination -->
      @if($destinations->hasPages())
        <div class="mt-16 flex justify-center w-full overflow-hidden">
          <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200">
            {{ $destinations->links() }}
          </div>
        </div>
      @endif
    @else
      <div class="flex flex-col items-center justify-center p-16 bg-white rounded-xl border border-slate-200 border-dashed text-center">
        <p class="text-slate-500 font-medium text-lg">Belum ada destinasi premium yang didaftarkan saat ini.</p>
      </div>
    @endif
  </section>
</main>
@endsection
