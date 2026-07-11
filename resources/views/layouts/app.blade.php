<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('meta_title', $global_settings->seo_meta_title ?? 'Sentra Hotels | Luxury Hotels 4 & 5 Star')</title>
    <meta name="description" content="@yield('meta_description', $global_settings->seo_meta_description ?? 'Sentra Hotels membantu tamu B2B dan B2C mendapatkan hotel bintang 4 dan 5 secara offline dengan kurasi, negosiasi, dan layanan personal.')">
    <meta name="keywords" content="@yield('meta_keywords', $global_settings->seo_meta_keywords ?? 'hotel bintang 4, hotel bintang 5, luxury hotel, reservasi hotel, offline hotel desk, corporate rates, Sentra Hotels')">
    
    <!-- Open Graph Tags -->
    <meta property="og:site_name" content="Sentra Hotels">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="@yield('meta_title', $global_settings->seo_meta_title ?? 'Sentra Hotels | Luxury Hotels 4 & 5 Star')">
    <meta property="og:description" content="@yield('meta_description', $global_settings->seo_meta_description ?? 'Sentra Hotels membantu tamu B2B dan B2C mendapatkan hotel bintang 4 dan 5 secara offline dengan kurasi, negosiasi, dan layanan personal.')">
    <meta property="og:image" content="@yield('og_image', (isset($global_settings) && $global_settings->seo_og_image) ? asset('storage/' . $global_settings->seo_og_image) : asset('assets/images/default-og.jpg'))">

    @if(isset($global_settings) && $global_settings->favicon_image)
      <link rel="icon" href="{{ asset('storage/' . $global_settings->favicon_image) }}">
    @else
      <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    <!-- Google Fonts: Inter (Mengikuti Sentra Holidays) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- VITE & FONTAWESOME -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    

    <style>
      body { font-family: 'Inter', sans-serif; }
      /* Bridge untuk JS Toggle */
      #mobileNavMenu.active { transform: translateX(0); }
      

    </style>
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FNX07466NK"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-FNX07466NK');
    </script>
    
    @yield('styles')
  </head>
  <!-- Beralih dari bg-gray-50 ke bg-slate-50 (Estetika Sentra Holidays) -->
  <body class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden flex flex-col min-h-screen">
    
    <!-- HEADER (Kloning Sentra Holidays Navbar) -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm" data-scrolled="false">
      <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
          
          <!-- Logo -->
          <a class="flex items-center gap-3 cursor-pointer transition-opacity" href="{{ request()->routeIs('home') ? '#top' : route('home') }}" aria-label="Sentra Hotels">
            @if(isset($global_settings) && $global_settings->logo_image)
              <img src="{{ asset('storage/' . $global_settings->logo_image) }}" alt="Sentra Hotels" class="h-10 w-auto object-contain">
            @else
              <span class="text-xl font-bold tracking-wide text-slate-900">SENTRA HOTELS</span>
            @endif
          </a>

          <!-- Desktop Navigation -->
          <nav class="hidden md:flex items-center gap-2 text-sm font-medium" aria-label="Navigasi utama">
            @if(isset($global_settings) && $global_settings->navbar_menus)
              @foreach($global_settings->navbar_menus as $menu)
                @if((!$global_settings->is_destination_active && (str_contains(strtolower($menu['url']), 'destination') || str_contains(strtolower($menu['url']), '#collection'))) || (!$global_settings->is_news_active && str_contains(strtolower($menu['url']), 'news')))
                    @continue
                @endif
                @if(isset($menu['sub_menus']) && count($menu['sub_menus']) > 0)
                  <div class="relative group">
                    <a href="{{ Str::startsWith($menu['url'], '#') ? (request()->routeIs('home') ? $menu['url'] : route('home') . $menu['url']) : (Str::startsWith($menu['url'], ['http://', 'https://']) ? $menu['url'] : url($menu['url'])) }}" 
                       @if($menu['is_external'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                       class="text-slate-600 hover:text-blue-600 px-3 py-2 rounded-full transition-colors flex items-center gap-1">
                      {{ $menu['label'] }}
                      <i class="fa-solid fa-chevron-down text-[10px] opacity-70"></i>
                    </a>
                    <div class="absolute left-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform translate-y-2 group-hover:translate-y-0">
                      @foreach($menu['sub_menus'] as $subMenu)
                        <a href="{{ Str::startsWith($subMenu['url'], '#') ? (request()->routeIs('home') ? $subMenu['url'] : route('home') . $subMenu['url']) : (Str::startsWith($subMenu['url'], ['http://', 'https://']) ? $subMenu['url'] : url($subMenu['url'])) }}" 
                           @if($subMenu['is_external'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                           class="block px-4 py-2 text-sm text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition-colors">
                          {{ $subMenu['label'] }}
                        </a>
                      @endforeach
                    </div>
                  </div>
                @else
                  <a href="{{ Str::startsWith($menu['url'], '#') ? (request()->routeIs('home') ? $menu['url'] : route('home') . $menu['url']) : (Str::startsWith($menu['url'], ['http://', 'https://']) ? $menu['url'] : url($menu['url'])) }}" 
                     @if($menu['is_external'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                     class="text-slate-600 hover:text-blue-600 px-3 py-2 rounded-full transition-colors">
                    {{ $menu['label'] }}
                  </a>
                @endif
              @endforeach
            @else
              <a href="{{ route('destination.index') }}" class="text-slate-600 hover:text-blue-600 px-3 py-2 rounded-full transition-colors">Destinasi</a>
              <a href="{{ request()->routeIs('home') ? '#service' : route('home') . '#service' }}" class="text-slate-600 hover:text-blue-600 px-3 py-2 rounded-full transition-colors">Layanan</a>
              <a href="{{ request()->routeIs('home') ? '#b2b' : route('home') . '#b2b' }}" class="text-slate-600 hover:text-blue-600 px-3 py-2 rounded-full transition-colors">B2B</a>
              <a href="{{ request()->routeIs('home') ? '#request' : route('home') . '#request' }}" class="text-slate-600 hover:text-blue-600 px-3 py-2 rounded-full transition-colors">Request</a>
              <a href="{{ route('news.index') }}" class="text-slate-600 hover:text-blue-600 px-3 py-2 rounded-full transition-colors">News</a>
            @endif
          </nav>

          <!-- Mobile Toggle Button (Kloning Sentra Holidays) -->
          <button id="navbar-toggle" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500" aria-expanded="false" aria-controls="navbar-menu">
            <span class="sr-only">Buka menu</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- TAMPILAN MENU MOBILE (HP) -->
      <div id="navbar-menu" class="hidden md:hidden bg-slate-50 border-t border-slate-200">
          <div class="max-w-6xl mx-auto px-4 py-4">
              <div class="flex items-center justify-between mb-3">
                  <span class="text-sm font-semibold text-slate-700">Menu Navigasi</span>
                  <button id="navbar-close" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                      <span class="sr-only">Tutup menu</span>
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                  </button>
              </div>
              <div class="grid gap-2 text-sm font-medium">
                  @if(isset($global_settings) && $global_settings->navbar_menus)
                    @foreach($global_settings->navbar_menus as $menu)
                      @if((!$global_settings->is_destination_active && (str_contains(strtolower($menu['url']), 'destination') || str_contains(strtolower($menu['url']), '#collection'))) || (!$global_settings->is_news_active && str_contains(strtolower($menu['url']), 'news')))
                          @continue
                      @endif
                      @if(isset($menu['sub_menus']) && count($menu['sub_menus']) > 0)
                        <div class="rounded-2xl bg-white border border-slate-200 overflow-hidden mb-2">
                          <a href="{{ Str::startsWith($menu['url'], '#') ? (request()->routeIs('home') ? $menu['url'] : route('home') . $menu['url']) : (Str::startsWith($menu['url'], ['http://', 'https://']) ? $menu['url'] : url($menu['url'])) }}" 
                             @if($menu['is_external'] ?? false) target="_blank" rel="noopener noreferrer" @endif 
                             class="block px-4 py-3 text-slate-700 bg-slate-50 font-bold border-b border-slate-100">
                            {{ $menu['label'] }}
                          </a>
                          <div class="flex flex-col bg-white">
                            @foreach($menu['sub_menus'] as $subMenu)
                               <a href="{{ Str::startsWith($subMenu['url'], '#') ? (request()->routeIs('home') ? $subMenu['url'] : route('home') . $subMenu['url']) : (Str::startsWith($subMenu['url'], ['http://', 'https://']) ? $subMenu['url'] : url($subMenu['url'])) }}" 
                                 @if($subMenu['is_external'] ?? false) target="_blank" rel="noopener noreferrer" @endif 
                                 class="block px-8 py-3 text-sm text-slate-600 hover:text-blue-600 border-b border-slate-50 last:border-0 transition-colors">
                                <i class="fa-solid fa-arrow-turn-up fa-rotate-90 text-[10px] opacity-40 mr-1"></i> {{ $subMenu['label'] }}
                              </a>
                            @endforeach
                          </div>
                        </div>
                      @else
                        <a href="{{ Str::startsWith($menu['url'], '#') ? (request()->routeIs('home') ? $menu['url'] : route('home') . $menu['url']) : (Str::startsWith($menu['url'], ['http://', 'https://']) ? $menu['url'] : url($menu['url'])) }}" 
                           @if($menu['is_external'] ?? false) target="_blank" rel="noopener noreferrer" @endif 
                           class="block rounded-2xl px-4 py-3 text-slate-700 bg-white border border-slate-200 hover:shadow-sm transition mb-2">
                          {{ $menu['label'] }}
                        </a>
                      @endif
                    @endforeach
                  @else
                    <a href="{{ route('destination.index') }}" class="block rounded-2xl px-4 py-3 text-slate-700 bg-white border border-slate-200 hover:shadow-sm transition">Destinasi</a>
                    <a href="{{ request()->routeIs('home') ? '#service' : route('home') . '#service' }}" class="block rounded-2xl px-4 py-3 text-slate-700 bg-white border border-slate-200 hover:shadow-sm transition">Layanan</a>
                    <a href="{{ request()->routeIs('home') ? '#b2b' : route('home') . '#b2b' }}" class="block rounded-2xl px-4 py-3 text-slate-700 bg-white border border-slate-200 hover:shadow-sm transition">B2B</a>
                    <a href="{{ request()->routeIs('home') ? '#request' : route('home') . '#request' }}" class="block rounded-2xl px-4 py-3 text-slate-700 bg-white border border-slate-200 hover:shadow-sm transition">Request</a>
                    <a href="{{ route('news.index') }}" class="block rounded-2xl px-4 py-3 text-slate-700 bg-white border border-slate-200 hover:shadow-sm transition">News</a>
                  @endif
              </div>
          </div>
      </div>

      <script>
          document.addEventListener('DOMContentLoaded', function() {
              const toggle = document.getElementById('navbar-toggle');
              const closeBtn = document.getElementById('navbar-close');
              const menu = document.getElementById('navbar-menu');

              if (!toggle || !menu) return;

              const toggleMenu = (show) => {
                  const visible = typeof show === 'boolean' ? show : menu.classList.contains('hidden');
                  menu.classList.toggle('hidden', !visible);
                  toggle.setAttribute('aria-expanded', String(visible));
              };

              toggle.addEventListener('click', function() {
                  toggleMenu();
              });

              if (closeBtn) {
                  closeBtn.addEventListener('click', function() {
                      toggleMenu(false);
                  });
              }
          });
      </script>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-grow min-h-[60vh]">
      @yield('content')
    </main>

    <!-- FOOTER NOTICE (VERTICAL TICKER) -->
    @if(isset($global_notices) && $global_notices->count() > 0)
    <div class="w-full bg-slate-900 border-t border-slate-800 font-sans h-10 overflow-hidden flex items-start justify-center">
        <div id="notice-ticker" class="w-full max-w-7xl mx-auto px-4 flex flex-col transition-transform duration-500 ease-in-out" style="transform: translateY(0);">
            @foreach($global_notices as $notice)
            <div class="h-10 flex items-center justify-center w-full shrink-0">
                <p class="text-white text-xs md:text-sm text-center truncate">
                    <i class="{{ $notice->icon }} text-amber-400 mr-2"></i> {!! $notice->message !!}
                </p>
            </div>
            @endforeach
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ticker = document.getElementById('notice-ticker');
            const itemCount = {{ $global_notices->count() }};
            if (!ticker || itemCount <= 1) return; // Tidak perlu rotasi jika hanya 1
            
            let currentIndex = 0;
            
            setInterval(() => {
                // Kalkulasi tinggi dinamis agar tidak meleset
                const itemElement = ticker.firstElementChild;
                const itemHeight = itemElement ? itemElement.offsetHeight : 40;
                
                currentIndex++;
                if (currentIndex >= itemCount) {
                    currentIndex = 0;
                }
                ticker.style.transform = `translateY(-${currentIndex * itemHeight}px)`;
            }, 3000); // Rotasi setiap 3 detik
        });
    </script>
    @endif

    <!-- FOOTER (Kloning Sentra Holidays Footer) -->
    <footer style="background-color: #1e3a8a;" class="text-white py-10 mt-auto border-t-4 border-blue-500">
        <div class="max-w-6xl mx-auto px-4">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <!-- Kolom 1: Company Info -->
                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-white tracking-wide">
                        Sentra Hotels
                    </h3>
                    <p class="text-sm opacity-80 leading-relaxed text-slate-300">
                        {{ $global_settings->footer_description ?? 'Empowering global citizens to explore with confidence, providing premium travel experiences through curated luxury offline booking.' }}
                    </p>
                    
                    <div class="flex gap-3 pt-2">
                        @if(isset($global_settings) && is_array($global_settings->social_media_links) && count($global_settings->social_media_links) > 0)
                            @foreach($global_settings->social_media_links as $social)
                                <a href="{{ $social['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-lg flex items-center justify-center transition hover:opacity-70 bg-white/10 text-white">
                                    @php
                                        $iconClass = $social['icon'] ?? 'fa-solid fa-link';
                                        if (strtolower($iconClass) === 'instagram') $iconClass = 'fa-brands fa-instagram';
                                        elseif (strtolower($iconClass) === 'facebook') $iconClass = 'fa-brands fa-facebook-f';
                                        elseif (strtolower($iconClass) === 'twitter' || strtolower($iconClass) === 'x') $iconClass = 'fa-brands fa-x-twitter';
                                        elseif (strtolower($iconClass) === 'youtube') $iconClass = 'fa-brands fa-youtube';
                                        elseif (strtolower($iconClass) === 'tiktok') $iconClass = 'fa-brands fa-tiktok';
                                        elseif (strtolower($iconClass) === 'linkedin') $iconClass = 'fa-brands fa-linkedin-in';
                                    @endphp
                                    <i class="{{ $iconClass }} text-white"></i>
                                </a>
                            @endforeach
                        @else
                            <a href="#" class="w-9 h-9 rounded-lg flex items-center justify-center transition hover:opacity-70 bg-white/10 text-white"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="w-9 h-9 rounded-lg flex items-center justify-center transition hover:opacity-70 bg-white/10 text-white"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="w-9 h-9 rounded-lg flex items-center justify-center transition hover:opacity-70 bg-white/10 text-white"><i class="fa-brands fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Kolom 2: Contact Info -->
                <div class="space-y-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-widest opacity-90">Hubungi Kami</h4>
                    <div class="space-y-2 text-sm opacity-80 text-slate-300">
                        <div class="flex items-start gap-2">
                            <i class="fa-solid fa-phone text-orange-400 mt-1 text-xs"></i>
                            <a href="tel:{{ $global_settings->whatsapp_number ?? '6287722389541' }}" class="hover:text-white transition">
                                +{{ $global_settings->whatsapp_number ?? '62 877 2238 9541' }}
                            </a>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-solid fa-envelope text-blue-400 mt-1 text-xs"></i>
                            <a href="mailto:{{ $global_settings->footer_email ?? 'reservation@sentrahotels.com' }}" class="hover:text-white transition break-all">
                                {{ $global_settings->footer_email ?? 'reservation@sentrahotels.com' }}
                            </a>
                        </div>
                        <div class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-red-400 mt-1 text-xs"></i>
                            <span class="leading-relaxed">{!! nl2br(e($global_settings->footer_address ?? "Ruko Cikawao Permai, Jl. Cikawao Permai No.10 Kav B,\nBandung")) !!}</span>
                        </div>
                    </div>
                </div>

                <!-- Kolom 3: Quick Links -->
                <div class="space-y-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-widest opacity-90">Navigasi Utama</h4>
                    <ul class="space-y-2 text-sm opacity-80 text-slate-300">
                        <li>
                            <a href="/" class="hover:text-white transition flex items-center gap-1">
                                <i class="fa-solid fa-arrow-right text-xs opacity-60"></i> Beranda
                            </a>
                        </li>

                        <li>
                            <a href="/b2bhotel" class="hover:text-white transition flex items-center gap-1">
                                <i class="fa-solid fa-arrow-right text-xs opacity-60"></i> B2B Corporate
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 4: Informasi Lain -->
                <div class="space-y-3">
                    <h4 class="text-sm font-bold text-white uppercase tracking-widest opacity-90">Informasi</h4>
                    <ul class="space-y-2 text-sm opacity-80 text-slate-300">
                        <li>
                            <a href="/about" class="hover:text-white transition flex items-center gap-1">
                                <i class="fa-solid fa-arrow-right text-xs opacity-60"></i> Tentang Kami
                            </a>
                        </li>
                        <li>
                            <a href="/news" class="hover:text-white transition flex items-center gap-1">
                                <i class="fa-solid fa-arrow-right text-xs opacity-60"></i> Berita & Artikel
                            </a>
                        </li>
                        <li>
                            <a href="/admin" class="hover:text-blue-400 transition flex items-center gap-1 font-bold">
                                <i class="fa-solid fa-shield-halved text-xs opacity-60"></i> Admin Panel
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-white border-opacity-10 pt-6 mt-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs opacity-70 text-slate-400">
                    <p>© {{ date('Y') }} Sentra Hotels. All Rights Reserved.</p>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-white transition">Privacy Policy</a>
                        <span>•</span>
                        <a href="#" class="hover:text-white transition">Terms & Conditions</a>
                    </div>
                </div>
            </div>

        </div>
    </footer>

    <!-- WIDGET WHATSAPP MULTI-OPSI (KLONING SENTRA HOLIDAYS) -->
    <div style="position: fixed !important; bottom: 70px !important; right: 24px !important; z-index: 2147483647 !important; display: block !important;" class="font-sans">
        
        <!-- Panel Pilihan -->
        <div id="wa-panel" class="hidden absolute bottom-20 right-0 w-72 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden transition-all duration-300 transform origin-bottom-right">
            
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-4 text-white relative">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="fa-solid fa-headset text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm tracking-wide">Sentra Hotels</h4>
                        <p class="text-[10px] text-emerald-50 uppercase tracking-wider">Pilih Layanan Kami</p>
                    </div>
                </div>
                <button onclick="toggleWaPanel()" class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-3 bg-slate-50">
                <div class="flex flex-col gap-2">
                    
                    <a href="https://wa.me/{{ $global_settings->whatsapp_number ?? '6287722389541' }}?text=Halo%20Sentra%20Hotels,%20saya%20butuh%20bantuan%20Personal%20Travel%20Assistant." target="_blank" rel="noopener noreferrer" 
                       class="flex items-center gap-3 p-3 bg-white rounded-xl hover:bg-blue-50 hover:border-blue-200 border border-transparent shadow-sm transition-all group">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-suitcase-rolling text-sm"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-700 group-hover:text-blue-700 transition-colors">Personal Assistant</h5>
                            <p class="text-[10px] text-slate-500">Liburan & Honeymoon</p>
                        </div>
                    </a>

                    <a href="https://wa.me/{{ $global_settings->whatsapp_number ?? '6287722389541' }}?text=Halo%20Sentra%20Hotels,%20saya%20ingin%20mengetahui%20layanan%20B2B%20Corporate." target="_blank" rel="noopener noreferrer" 
                       class="flex items-center gap-3 p-3 bg-white rounded-xl hover:bg-orange-50 hover:border-orange-200 border border-transparent shadow-sm transition-all group">
                        <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-briefcase text-sm"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-700 group-hover:text-orange-700 transition-colors">B2B & Corporate</h5>
                            <p class="text-[10px] text-slate-500">Travel Agent / Corporate</p>
                        </div>
                    </a>

                    <a href="https://wa.me/{{ $global_settings->whatsapp_number ?? '6287722389541' }}?text=Halo%20Finance,%20saya%20ingin%20melakukan%20Konfirmasi%20Pembayaran." target="_blank" rel="noopener noreferrer" 
                       class="flex items-center gap-3 p-3 bg-white rounded-xl hover:bg-emerald-50 hover:border-emerald-200 border border-transparent shadow-sm transition-all group">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-file-invoice-dollar text-sm"></i>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-700 group-hover:text-emerald-700 transition-colors">Finance</h5>
                            <p class="text-[10px] text-slate-500">Konfirmasi Pembayaran</p>
                        </div>
                    </a>

                </div>
            </div>
        </div>

        <button onclick="toggleWaPanel()" id="wa-main-btn" class="flex items-center justify-center w-14 h-14 bg-[#25D366] text-white rounded-full shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 focus:outline-none cursor-pointer">
            <i id="wa-main-icon" class="fa-brands fa-whatsapp text-3xl transition-transform duration-300"></i>
        </button>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}?v=1.12"></script>
    
    <script>
        function toggleWaPanel() {
            const panel = document.getElementById('wa-panel');
            const icon = document.getElementById('wa-main-icon');
            
            if (panel.classList.contains('hidden')) {
                panel.classList.remove('hidden');
                icon.classList.remove('fa-brands', 'fa-whatsapp');
                icon.classList.add('fa-solid', 'fa-xmark', 'rotate-90');
            } else {
                panel.classList.add('hidden');
                icon.classList.remove('fa-solid', 'fa-xmark', 'rotate-90');
                icon.classList.add('fa-brands', 'fa-whatsapp');
            }
        }
    </script>
    @yield('scripts')
  </body>
</html>