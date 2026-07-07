@extends('layouts.app')

@section('meta_title', $hotel->meta_title ?: ($hotel->name . ' | Sentra Hotels'))
@section('meta_description', $hotel->meta_description ?: $hotel->short_description)
@if($hotel->meta_keywords)
  @section('meta_keywords', $hotel->meta_keywords)
@endif
@if($hotel->og_image)
  @section('og_image', \Illuminate\Support\Str::startsWith($hotel->og_image, ['http://', 'https://']) ? $hotel->og_image : asset('storage/' . $hotel->og_image))
@elseif($hotel->thumbnail || $hotel->thumbnail_id)
  @section('og_image', $hotel->thumbnailImage ? asset('storage/' . $hotel->thumbnailImage->path) : asset('storage/' . $hotel->thumbnail))
@endif

@section('content')
<!-- Memuat aset khusus untuk halaman ini (Swiper Slider & FontAwesome) seperti di Sentra Holidays -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .swiper-button-next:after, .swiper-button-prev:after { font-size: 20px; font-weight: bold; }
</style>

<main class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen pb-20">
    <div class="max-w-6xl mx-auto px-4 py-8">
        
        <!-- Breadcrumbs & Navigasi -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-2 text-xs text-slate-400">
                <a href="/" class="hover:text-blue-600">Home</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <a href="/" class="hover:text-blue-600">Hotel</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-600 font-medium line-clamp-1">{{ $hotel->name }}</span>
            </div>
            <a href="/" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-2">
                <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Daftar Hotel
            </a>
        </div>

        <!-- Judul & Badge Kategori -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-2">
                <span class="bg-blue-50 text-blue-600 text-xs font-bold px-3 py-1 rounded-md uppercase tracking-wider">
                    <i class="fa-solid fa-map-location-dot mr-1"></i> {{ $hotel->destination->name ?? 'Destinasi' }}
                </span>
                <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1 rounded-md uppercase tracking-wider flex items-center gap-1">
                    <i class="fa-solid fa-star text-yellow-500"></i> {{ $hotel->stars }} Bintang
                </span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight">
                {{ $hotel->name }}
            </h1>
            <p class="text-sm text-slate-500 mt-2 flex items-start gap-1.5">
                <i class="fa-solid fa-location-dot mt-0.5 text-slate-400"></i> {{ $hotel->address }}
            </p>
        </div>

        <!-- GRID 3 KOLOM UTAMA -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- KOLOM KIRI (2 Kolom - Konten Utama) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Hero Banner Swiper (Seperti Sentra Holidays) -->
                <div class="relative bg-slate-200 rounded-2xl overflow-hidden aspect-video shadow-sm border border-slate-100">
                    <div class="swiper w-full h-full" id="hotelGallery">
                        <div class="swiper-wrapper">
                            @if($hotel->galleries->count() > 0)
                                @foreach($hotel->galleries as $gallery)
                                    <div class="swiper-slide w-full h-full">
                                        <img src="{{ $gallery->media ? asset('storage/' . $gallery->media->path) : (\Illuminate\Support\Str::startsWith($gallery->image, ['http://', 'https://']) ? $gallery->image : asset('storage/' . $gallery->image)) }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            @else
                                <div class="swiper-slide w-full h-full">
                                    <img src="{{ $hotel->thumbnailImage ? asset('storage/' . $hotel->thumbnailImage->path) : ($hotel->thumbnail ? (\Illuminate\Support\Str::startsWith($hotel->thumbnail, ['http://', 'https://']) ? $hotel->thumbnail : asset('storage/' . $hotel->thumbnail)) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80') }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                        </div>
                        @if($hotel->galleries->count() > 1)
                            <div class="swiper-button-prev !text-white !bg-black/20 hover:!bg-black/50 p-6 rounded-lg transition"></div>
                            <div class="swiper-button-next !text-white !bg-black/20 hover:!bg-black/50 p-6 rounded-lg transition"></div>
                        @endif
                    </div>
                </div>

                <!-- Fasilitas Hotel Khusus (Widget Sentra Holidays Style) -->
                @if($hotel->facilities->count() > 0)
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                    @foreach($hotel->facilities->take(4) as $fac)
                        <div class="p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors">
                            <i class="fa-solid fa-check-circle text-emerald-500 text-xl mb-1"></i>
                            <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Fasilitas</p>
                            <p class="text-xs font-bold text-slate-700 mt-0.5">{{ $fac->facility_name }}</p>
                        </div>
                    @endforeach
                </div>
                @endif

                <!-- Deskripsi Hotel -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-building text-blue-600"></i> Tentang Akomodasi Ini
                    </h2>
                    <div class="prose max-w-none text-xs sm:text-sm text-slate-600 leading-relaxed editor-content">
                        {!! $hotel->description !!}
                    </div>
                </div>

                <!-- Pilihan Kamar Hotel -->
                @if($hotel->rooms->count() > 0)
                <div class="mb-6">
                    <h4 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-bed text-blue-600"></i> Pilihan Kamar Tersedia:
                    </h4>
                    <div class="space-y-4">
                        @foreach($hotel->rooms as $room)
                            <div class="shadow-sm">
                                <div class="bg-blue-50 border border-blue-100 text-blue-700 text-[11px] font-bold px-4 py-2.5 rounded-t-xl flex items-center justify-between uppercase tracking-wider">
                                    <span class="flex items-center gap-2"><i class="fa-solid fa-door-open"></i> {{ $room->room_name }}</span>
                                    <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); document.querySelector('input[name=room_type]').value = '{{ $room->room_name }}';" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-[10px] transition-colors cursor-pointer shadow-sm">
                                        Pilih Kamar
                                    </button>
                                </div>
                                <div class="border border-t-0 border-slate-100 rounded-b-xl overflow-hidden bg-white p-4 flex flex-col md:flex-row gap-4">
                                    @if($room->image || $room->media_id)
                                        <div class="w-full md:w-48 h-32 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="{{ $room->media ? asset('storage/' . $room->media->path) : asset('storage/' . $room->image) }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-xs text-slate-600 leading-relaxed">{{ $room->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
            </div>

            <!-- KOLOM KANAN (Sidebar Widget & Sticky Form) -->
            <div class="space-y-6 lg:sticky lg:top-24">
                
                <!-- Kotak Harga Mulai Dari / Call to Action -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-md p-6 overflow-hidden relative">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mb-1 mt-2">Dapatkan Penawaran Corporate</p>
                    <div class="flex items-baseline gap-1.5 mb-6">
                        <span class="text-2xl font-black text-slate-900">Reservasi B2B Offline</span>
                    </div>
                    
                    <p class="text-xs text-slate-500 mb-6 leading-relaxed">
                        Dapatkan corporate rate, negosiasi, dan handling personal dari tim konsultan kami.
                    </p>

                    <button type="button" onclick="bukaSentraModal()" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-xl shadow-sm text-center block transition flex items-center justify-center gap-2 text-sm cursor-pointer">
                        <i class="fa-solid fa-file-signature text-lg"></i> Form Reservasi Hotel
                    </button>
                    
                    <p class="text-[10px] text-center text-red-500 font-medium mt-4">
                        <i class="fa-regular fa-clock text-[9px] mr-0.5"></i> Harga & ketersediaan dapat berubah sewaktu-waktu.
                    </p>
                </div>

                <!-- KOTAK WIDGET: Keunggulan Hotel -->
                @if($hotel->why_choose_us && is_array($hotel->why_choose_us) && count($hotel->why_choose_us) > 0)
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                        <h3 class="font-bold text-slate-900 mb-3 flex items-center gap-2 text-sm uppercase tracking-wide">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i> Keunggulan Hotel
                        </h3>
                        <ul class="text-xs text-slate-600 space-y-2.5">
                            @foreach($hotel->why_choose_us as $item)
                                @if(isset($item['point']))
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-emerald-500 mt-0.5"></i> {{ $item['point'] }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- KOTAK WIDGET: Peta Lokasi -->
                @if($hotel->latitude && $hotel->longitude)
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                        <h3 class="font-bold text-slate-900 mb-3 flex items-center gap-2 text-sm uppercase tracking-wide">
                            <i class="fa-solid fa-map-location-dot text-blue-500 text-base"></i> Peta Lokasi
                        </h3>
                        <div class="rounded-xl overflow-hidden border border-slate-200 h-40">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}&z=15&output=embed"></iframe>
                        </div>
                    </div>
                @endif
                
                <!-- Share Button -->
                <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm text-center">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wide mb-3">Bagikan Halaman Hotel Ini:</p>
                    <div class="flex justify-center gap-3">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($hotel->name . ' - Info lengkap klik: ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition shadow-sm">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="w-10 h-10 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition shadow-sm">
                            <i class="fa-brands fa-facebook-f text-base"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
        
        <!-- SECTION BAWAH: Rekomendasi Hotel -->
        @if(isset($relatedHotels) && $relatedHotels->count() > 0)
        <div class="mt-20 pt-10 border-t border-slate-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Rekomendasi Akomodasi Lainnya</h2>
            <p class="text-sm text-slate-500 mb-8">Eksplorasi pilihan hotel menarik lainnya di area ini.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedHotels as $rel)
                    <a href="{{ route('hotel.show', $rel->slug) }}" class="block rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden transition duration-300 ease-out hover:-translate-y-1 hover:border-slate-300 hover:shadow-xl h-full flex flex-col">
                        <div class="h-48 bg-slate-200 overflow-hidden relative">
                            <img src="{{ $rel->thumbnailImage ? asset('storage/' . $rel->thumbnailImage->path) : ($rel->thumbnail ? (\Illuminate\Support\Str::startsWith($rel->thumbnail, ['http://', 'https://']) ? $rel->thumbnail : asset('storage/' . $rel->thumbnail)) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80') }}" alt="{{ $rel->name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-md flex items-center gap-1 shadow-sm">
                                <span class="text-yellow-500 text-xs">★</span>
                                <span class="text-xs font-bold text-slate-900">{{ $rel->stars }}</span>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex justify-between items-center text-[10px] font-semibold mb-2 uppercase tracking-wider">
                                <span class="text-blue-600"><i class="fa-solid fa-map-location-dot"></i> {{ $rel->destination->name ?? 'Destinasi' }}</span>
                            </div>
                            <h3 class="font-extrabold text-lg leading-tight text-slate-900 mb-2 line-clamp-2">{{ $rel->name }}</h3>
                            <p class="text-xs text-slate-500 mb-4 line-clamp-2">{{ $rel->short_description }}</p>
                            <div class="flex-grow"></div>
                            <div class="mt-4 pt-4 border-t border-slate-100 text-center font-bold text-blue-600 text-xs uppercase tracking-wider group-hover:text-blue-800">
                                Lihat Detail Hotel &rarr;
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <!-- MODAL RESERVASI B2B (KLONING SENTRA HOLIDAYS) -->
    <div id="bookingModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl relative">
            
            @if(session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-4 mt-4 mx-4 rounded-xl shadow-sm">
                    <p class="font-bold text-sm"><i class="fa-solid fa-circle-check"></i> Berhasil!</p>
                    <p class="text-xs">{{ session('success') }}</p>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('bookingModal').classList.remove('hidden');
                    });
                </script>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 mt-4 mx-4 rounded-xl shadow-sm">
                    <p class="font-bold text-sm"><i class="fa-solid fa-triangle-exclamation"></i> Gagal!</p>
                    <p class="text-xs">{{ session('error') }}</p>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('bookingModal').classList.remove('hidden');
                    });
                </script>
            @endif
            
            <div class="bg-blue-600 p-5 rounded-t-2xl flex justify-between items-start sticky top-0 z-10">
                <div>
                    <span class="bg-blue-800 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Booking Form Hotel</span>
                    <h2 class="text-white text-lg font-bold mt-1 leading-snug">{{ $hotel->name }}</h2>
                </div>
                <button type="button" onclick="tutupSentraModal()" class="text-blue-100 hover:text-white bg-blue-700 hover:bg-blue-800 w-8 h-8 rounded-full flex items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ route('booking.request') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="hotel_name" value="{{ $hotel->name }}">
                
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Pemesan</label>
                        <input type="text" name="customer_name" required placeholder="Nama Lengkap sesuai KTP/Paspor" class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white outline-none transition-colors">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Email Corporate</label>
                            <input type="email" name="email" required placeholder="email@perusahaan.com" class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Mobile Phone (WhatsApp)</label>
                            <input type="tel" name="phone" required placeholder="0812xxxxxx" class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white outline-none transition-colors">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tgl Check In</label>
                            <input type="date" name="check_in" id="sentra_check_in" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tgl Check Out</label>
                            <input type="date" name="check_out" id="sentra_check_out" required class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white outline-none transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Jml Kamar</label>
                            <select name="room_count" required class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white outline-none transition-colors">
                                <option value="" disabled selected>Pilih...</option>
                                @for($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}">{{ $i }} Kamar</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Opsi Meals</label>
                            <select name="meals" required class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white outline-none transition-colors">
                                <option value="" disabled selected>Pilih...</option>
                                <option value="Room Only">Room Only</option>
                                <option value="Breakfast">Termasuk Breakfast</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tipe Kamar Pilihan</label>
                        <input type="text" name="room_type" placeholder="Contoh: Deluxe Room" class="w-full border border-slate-200 bg-slate-50 rounded-lg px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white outline-none transition-colors">
                    </div>
                </div>

                <!-- ATURAN MAIN (STRICT INLINE STYLES ANTI-GRID) -->
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 0.75rem; padding: 1.25rem; margin-top: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #991b1b; font-weight: 700; font-size: 0.875rem; margin-bottom: 1rem;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span style="text-transform: uppercase; letter-spacing: 0.05em;">PERHATIAN:</span>
                    </div>
                    <ul style="list-style-type: disc; padding-left: 1.25rem; font-size: 0.75rem; color: #7f1d1d; line-height: 1.6; margin: 0; display: block !important;">
                        <li style="margin-bottom: 0.5rem; display: list-item !important; text-align: left !important; border: none !important;">Kami akan berikan penawaran terbaik secepatnya melalui email dan whatsapp.</li>
                        <li style="margin-bottom: 0.5rem; display: list-item !important; text-align: left !important; border: none !important;">Penawaran harga akan kami berikan berikut dengan terms & conditions reservasi.</li>
                        <li style="margin-bottom: 0.5rem; display: list-item !important; text-align: left !important; border: none !important;">Kami hanya akan melakukan reservasi setelah anda setuju akan harga dan terms conditions yang kami berikan.</li>
                        <li style="margin-bottom: 0.5rem; display: list-item !important; text-align: left !important; border: none !important;">Anda tidak diperbolehkan melakukan pembayaran apapun <strong style="color: #991b1b; font-weight: 900;">TANPA MENERIMA INVOICE</strong> terlebih dahulu.</li>
                        <li style="margin-bottom: 0.5rem; display: list-item !important; text-align: left !important; border: none !important;"><strong style="color: #991b1b; font-weight: 900;">INVOICE</strong> akan kami kirimkan berikut dengan keterangan <strong style="color: #991b1b; font-weight: 900;">TIME LIMIT PEMBAYARAN</strong>.</li>
                        <li style="margin-bottom: 0.5rem; display: list-item !important; text-align: left !important; border: none !important;">Kami hanya menerima pembayaran melalui rekening atas nama <strong style="color: #991b1b; font-weight: 900;">SENTRA MULIA PANCA MAKMUR PT</strong>:
                            <div style="margin-top: 0.25rem; color: #991b1b; font-weight: 700;">
                                - BANK BCA: 438-8883331<br>
                                - BANK MANDIRI: 1300022834231
                            </div>
                        </li>
                        <li style="margin-bottom: 0.5rem; display: list-item !important; text-align: left !important; border: none !important;">Call center kami hanya menggunakan nomor <strong style="color: #991b1b; font-weight: 900;">0877 2238 9541</strong>.</li>
                        <li style="display: list-item !important; text-align: left !important; border: none !important;">Setelah melakukan pembayaran dan dinyatakan CONFIRM, Anda akan menerima Voucher Hotel sesuai dengan detail booking.</li>
                    </ul>
                    <p style="text-align: center; font-weight: 700; color: #991b1b; margin-top: 1.5rem; font-size: 0.6875rem; letter-spacing: 0.05em;">
                        *** TERIMA KASIH ATAS KEPERCAYAAN ANDA ***
                    </p>
                </div>

                <div class="border-t border-slate-100 pt-5 flex justify-end gap-3">
                    <button type="button" onclick="tutupSentraModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs uppercase tracking-wider transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-md flex items-center gap-2 text-xs uppercase tracking-wider transition-colors cursor-pointer">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Request
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Swiper (Hero Banner)
        if (document.getElementById('hotelGallery')) {
            new Swiper('#hotelGallery', {
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            });
        }

        // Logic Check Out Date (H+1)
        const checkInEl = document.getElementById('sentra_check_in');
        const checkOutEl = document.getElementById('sentra_check_out');
        
        if(checkInEl && checkOutEl) {
            checkInEl.addEventListener('change', function() {
                let checkInDate = new Date(this.value);
                checkInDate.setDate(checkInDate.getDate() + 1);
                let minCheckOut = checkInDate.toISOString().split('T')[0];
                checkOutEl.min = minCheckOut;
                if(checkOutEl.value && checkOutEl.value < minCheckOut) {
                    checkOutEl.value = minCheckOut;
                }
            });
        }
    });

    // Buka Tutup Modal 
    const bookingModal = document.getElementById('bookingModal');

    function bukaSentraModal() {
        if(bookingModal) bookingModal.classList.remove('hidden');
    }

    function tutupSentraModal() {
        if(bookingModal) bookingModal.classList.add('hidden');
    }

    if(bookingModal) {
        bookingModal.addEventListener('click', function(e) {
            if (e.target === bookingModal) {
                tutupSentraModal();
            }
        });
    }
</script>
@endsection