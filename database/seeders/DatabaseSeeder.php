<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\HotelGallery;
use App\Models\HotelFacility;
use App\Models\HotelRoom;
use App\Models\NearbyPlace;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Bersihkan Data Lama
        \App\Models\HotelChainImage::query()->delete();
        \App\Models\HeroContent::query()->delete();
        \App\Models\Faq::query()->delete();
        NearbyPlace::query()->delete();
        HotelRoom::query()->delete();
        HotelFacility::query()->delete();
        HotelGallery::query()->delete();
        Hotel::query()->delete();
        Destination::query()->delete();
        User::query()->delete();

        // 2. Buat Admin User
        User::create([
            'name' => 'Admin Sentra',
            'email' => 'admin@sentrahotels.com',
            'password' => bcrypt('password'),
        ]);

        // 3. Buat Destinasi
        $bali = Destination::create([
            'name' => 'Bali',
            'slug' => 'bali',
            'tagline' => 'Tropical Island Paradise',
            'description' => '<p>Discover the finest collection of luxury hotels in Bali, carefully selected by Sentra Hotels. From exotic beachside resorts to tranquil rainforest hideaways.</p>',
            'thumbnail' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=600&q=80',
            'hero_image' => [
                'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=80'
            ],
            'seo_title' => 'Luxury Hotels & Resorts in Bali | Sentra Hotels',
            'seo_description' => 'Book curated 4 and 5 star hotels in Bali offline with negotiation support.',
            'is_featured' => true,
            'status' => true,
            'sort_order' => 1,
        ]);

        $jakarta = Destination::create([
            'name' => 'Jakarta',
            'slug' => 'jakarta',
            'tagline' => 'Metropolitan Business Hub',
            'description' => '<p>Explore premium business hotels and luxury city retreats in Indonesia\'s bustling capital city. Selected for ultimate comfort and corporate facilities.</p>',
            'thumbnail' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?auto=format&fit=crop&w=600&q=80',
            'hero_image' => [
                'https://images.unsplash.com/photo-1555881400-74d7acaacd8b?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1601621915196-2621bfb0cd6e?auto=format&fit=crop&w=1200&q=80'
            ],
            'seo_title' => 'Luxury Business & City Hotels in Jakarta | Sentra Hotels',
            'seo_description' => 'Find the best premium hotels in Jakarta for business travelers and corporate events.',
            'is_featured' => true,
            'status' => true,
            'sort_order' => 2,
        ]);

        $singapore = Destination::create([
            'name' => 'Singapore',
            'slug' => 'singapore',
            'tagline' => 'Futuristic Garden City',
            'description' => '<p>Experience world-class luxury hotel suites, infinity pools, and pristine services in the vibrant green metropolis of Singapore.</p>',
            'thumbnail' => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?auto=format&fit=crop&w=600&q=80',
            'hero_image' => [
                'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1504214208698-ea1916a2195a?auto=format&fit=crop&w=1200&q=80'
            ],
            'seo_title' => 'World-Class Premium Hotels in Singapore | Sentra Hotels',
            'seo_description' => 'Discover luxury hotels in Singapore with top-notch sky lounges and services.',
            'is_featured' => true,
            'status' => true,
            'sort_order' => 3,
        ]);

        $bandung = Destination::create([
            'name' => 'Bandung',
            'slug' => 'bandung',
            'tagline' => 'Cool Mountain Breeze',
            'description' => '<p>Escape to the cool highland air of Bandung. Discover selected boutique hotels and luxury hillside resorts for your holiday stay.</p>',
            'thumbnail' => 'https://images.unsplash.com/photo-1549473889-14f410d83298?auto=format&fit=crop&w=600&q=80',
            'hero_image' => [
                'https://images.unsplash.com/photo-1549473889-14f410d83298?auto=format&fit=crop&w=1200&q=80'
            ],
            'seo_title' => 'Boutique & Hillside Resorts in Bandung | Sentra Hotels',
            'seo_description' => 'Unwind in the fresh air of Bandung. Curated luxury accommodation by Sentra Hotels.',
            'is_featured' => true,
            'status' => true,
            'sort_order' => 4,
        ]);


        // 4. Buat Hotels
        // Hotel 1 (Bali)
        $kempinski = Hotel::create([
            'destination_id' => $bali->id,
            'name' => 'The Apurva Kempinski Bali',
            'slug' => 'the-apurva-kempinski-bali',
            'thumbnail' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=80',
            'short_description' => 'Standing atop the majestic cliff of Nusa Dua, with breathtaking views of the Indian Ocean.',
            'description' => '<p>The Apurva Kempinski Bali presents itself as a majestic open-air theater, an embodiment of Indonesian elegance. A collection of 475 iconic guestrooms, suites, and villas are offering a spacious living with a selection of private plunge pools.</p><p>With award-winning dining options including the undersea Koral Restaurant, an infinity pool overlooking the ocean, and a cliffside luxury spa, it stands as one of Bali\'s premier luxury retreats.</p>',
            'stars' => 5,
            'address' => 'Jalan Raya Nusa Dua Selatan, Sawangan, Nusa Dua, Bali',
            'latitude' => '-8.8290',
            'longitude' => '115.2166',
            'featured' => true,
            'promotion' => true,
            'status' => true,
            'hotel_type' => 'Resort',
            'is_family' => true,
            'is_business' => false,
            'is_beach' => true,
            'is_luxury' => true,
            'why_choose_us' => [
                ['point' => 'Pemandangan tebing langsung menghadap Samudra Hindia'],
                ['point' => 'Arsitektur megah perpaduan budaya Indonesia kuno'],
                ['point' => 'Kolam renang infinity outdoor sepanjang 60 meter'],
                ['point' => 'Restoran bawah laut (undersea restaurant) Koral yang ikonik']
            ],
        ]);

        HotelGallery::create(['hotel_id' => $kempinski->id, 'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=80', 'sort_order' => 1]);
        HotelGallery::create(['hotel_id' => $kempinski->id, 'image' => 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=1200&q=80', 'sort_order' => 2]);
        HotelGallery::create(['hotel_id' => $kempinski->id, 'image' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=80', 'sort_order' => 3]);

        HotelFacility::create(['hotel_id' => $kempinski->id, 'facility_name' => 'Free High-Speed WiFi', 'icon' => 'wifi']);
        HotelFacility::create(['hotel_id' => $kempinski->id, 'facility_name' => 'Infinity Pool', 'icon' => 'swimming-pool']);
        HotelFacility::create(['hotel_id' => $kempinski->id, 'facility_name' => 'Luxury Cliff Spa', 'icon' => 'spa']);
        HotelFacility::create(['hotel_id' => $kempinski->id, 'facility_name' => 'Modern Gym Center', 'icon' => 'gym']);
        HotelFacility::create(['hotel_id' => $kempinski->id, 'facility_name' => 'Award Restaurants', 'icon' => 'restaurant']);
        HotelFacility::create(['hotel_id' => $kempinski->id, 'facility_name' => 'Executive Meeting Room', 'icon' => 'meeting-room']);

        HotelRoom::create([
            'hotel_id' => $kempinski->id,
            'room_name' => 'Grand Deluxe Ocean Court Room',
            'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80',
            'description' => 'Featuring spacious living space of 65 sqm, filled with custom Indonesian furnishings and a private balcony overlooking the ocean court.'
        ]);
        HotelRoom::create([
            'hotel_id' => $kempinski->id,
            'room_name' => 'Cliff Private Pool Junior Suite',
            'image' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=600&q=80',
            'description' => 'A 100 sqm lavish junior suite perched high on the cliffside, equipped with a private plunge pool and access to exclusive lounge benefits.'
        ]);

        NearbyPlace::create(['hotel_id' => $kempinski->id, 'place_name' => 'Nusa Dua Beach', 'distance' => '1.2 km']);
        NearbyPlace::create(['hotel_id' => $kempinski->id, 'place_name' => 'Bali National Golf Club', 'distance' => '3.5 km']);
        NearbyPlace::create(['hotel_id' => $kempinski->id, 'place_name' => 'Pandawa Beach', 'distance' => '5.2 km']);


        // Hotel 2 (Bali)
        $ayana = Hotel::create([
            'destination_id' => $bali->id,
            'name' => 'AYANA Resort Bali',
            'slug' => 'ayana-resort-bali',
            'thumbnail' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=600&q=80',
            'short_description' => 'World-class integrated resort perched on cliffs above Jimbaran Bay.',
            'description' => '<p>AYANA Resort Bali offers a truly luxurious getaway with 19 primary dining destinations including the famous Rock Bar. The resort features spacious guest rooms, private villas, and clifftop infinity pools.</p><p>Surrounded by lush tropical gardens and overlooking the wild sea, AYANA offers top-tier spa treatments and a private sandy beach.</p>',
            'stars' => 5,
            'address' => 'Karang Mas Estate, Jalan Karang Mas Sejahtera, Jimbaran, Bali',
            'latitude' => '-8.7667',
            'longitude' => '115.1485',
            'featured' => true,
            'promotion' => false,
            'status' => true,
            'hotel_type' => 'Resort',
            'is_family' => true,
            'is_business' => false,
            'is_beach' => true,
            'is_luxury' => true,
            'why_choose_us' => [
                ['point' => 'Akses eksklusif ke Rock Bar Bali yang ikonik di pinggir tebing'],
                ['point' => 'Pantai privat Kubu Beach dengan pasir putih bersih'],
                ['point' => 'Pilihan 14 kolam renang outdoor di seluruh area resort']
            ],
        ]);

        HotelGallery::create(['hotel_id' => $ayana->id, 'image' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=80', 'sort_order' => 1]);
        HotelGallery::create(['hotel_id' => $ayana->id, 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80', 'sort_order' => 2]);

        HotelFacility::create(['hotel_id' => $ayana->id, 'facility_name' => 'Private Sandy Beach', 'icon' => 'swimming-pool']);
        HotelFacility::create(['hotel_id' => $ayana->id, 'facility_name' => '14 Outdoor Pools', 'icon' => 'swimming-pool']);
        HotelFacility::create(['hotel_id' => $ayana->id, 'facility_name' => 'Thalassotherapy Spa', 'icon' => 'spa']);
        HotelFacility::create(['hotel_id' => $ayana->id, 'facility_name' => 'Iconic Rock Bar', 'icon' => 'restaurant']);
        HotelFacility::create(['hotel_id' => $ayana->id, 'facility_name' => 'Free WiFi', 'icon' => 'wifi']);

        HotelRoom::create([
            'hotel_id' => $ayana->id,
            'room_name' => 'Resort View Room',
            'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80',
            'description' => 'Spacious room showing beautiful tropical resort views, featuring elegant timber furnishings.'
        ]);

        NearbyPlace::create(['hotel_id' => $ayana->id, 'place_name' => 'Jimbaran Seafood Cafes', 'distance' => '2.8 km']);
        NearbyPlace::create(['hotel_id' => $ayana->id, 'place_name' => 'New Kuta Golf', 'distance' => '4.0 km']);


        // Hotel 3 (Jakarta)
        $ritz = Hotel::create([
            'destination_id' => $jakarta->id,
            'name' => 'The Ritz-Carlton Jakarta, Mega Kuningan',
            'slug' => 'the-ritz-carlton-jakarta-mega-kuningan',
            'thumbnail' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=600&q=80',
            'short_description' => 'Premium business and leisure sanctuary nestled in the prestigious Mega Kuningan commercial district.',
            'description' => '<p>Indulge in a premium urban oasis. Featuring the city\'s largest guest rooms, award-winning dining outlets, and a tranquil spa garden, The Ritz-Carlton Mega Kuningan offers unparalleled service.</p>',
            'stars' => 5,
            'address' => 'Jalan DR. Ide Anak Agung Gde Agung Kav. E.1.1 no. 1, Mega Kuningan, Jakarta',
            'latitude' => '-6.2289',
            'longitude' => '106.8272',
            'featured' => true,
            'promotion' => false,
            'status' => true,
            'hotel_type' => 'City Hotel',
            'is_family' => false,
            'is_business' => true,
            'is_beach' => false,
            'is_luxury' => true,
            'why_choose_us' => [
                ['point' => 'Kamar hotel terluas di kelasnya di seluruh Jakarta (mulai dari 63 sqm)'],
                ['point' => 'Terletak strategis di kawasan perkantoran elit Mega Kuningan'],
                ['point' => 'Layanan butler personal Ritz-Carlton Club yang berkelas dunia']
            ],
        ]);

        HotelGallery::create(['hotel_id' => $ritz->id, 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80', 'sort_order' => 1]);

        HotelFacility::create(['hotel_id' => $ritz->id, 'facility_name' => 'Business Center', 'icon' => 'meeting-room']);
        HotelFacility::create(['hotel_id' => $ritz->id, 'facility_name' => 'Spa Garden Retreat', 'icon' => 'spa']);
        HotelFacility::create(['hotel_id' => $ritz->id, 'facility_name' => 'Lobby Lounge Bar', 'icon' => 'restaurant']);
        HotelFacility::create(['hotel_id' => $ritz->id, 'facility_name' => 'Free WiFi', 'icon' => 'wifi']);

        HotelRoom::create([
            'hotel_id' => $ritz->id,
            'room_name' => 'Grand Room City View',
            'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80',
            'description' => 'A large 63 sqm room with floor-to-ceiling windows showing beautiful Jakarta skyscrapers view.'
        ]);

        NearbyPlace::create(['hotel_id' => $ritz->id, 'place_name' => 'Kuningan City Mall', 'distance' => '500 m']);
        NearbyPlace::create(['hotel_id' => $ritz->id, 'place_name' => 'Sudirman Business District', 'distance' => '3.0 km']);

        // 5. Buat FAQ
        \App\Models\Faq::create([
            'question' => 'Bagaimana cara melakukan reservasi hotel di Sentra Hotels?',
            'answer' => '<p>Semua reservasi kami tangani secara offline untuk memastikan Anda mendapatkan rate terbaik dan penanganan yang personal. Anda cukup mengisi formulir "Request Hotel" di halaman utama, lalu klik tombol "Kirim via WhatsApp" untuk melanjutkan komunikasi langsung dengan konsultan perjalanan kami.</p>'
        ]);
        \App\Models\Faq::create([
            'question' => 'Apakah Sentra Hotels melayani pemesanan untuk grup atau kebutuhan MICE?',
            'answer' => '<p>Ya, kami memiliki layanan B2B khusus yang menangani pemesanan grup besar, kebutuhan akomodasi korporat (*Corporate Rates*), perjalanan eksekutif, serta MICE (*Meeting, Incentive, Convention, Exhibition*).</p>'
        ]);
        \App\Models\Faq::create([
            'question' => 'Hotel bintang berapa saja yang dikurasi oleh Sentra Hotels?',
            'answer' => '<p>Kami secara eksklusif hanya mengurasi dan menawarkan pilihan properti bintang 4 dan bintang 5 terbaik yang telah memenuhi kriteria ketat kami dalam hal lokasi, kualitas pelayanan, dan kenyamanan menginap.</p>'
        ]);
        \App\Models\Faq::create([
            'question' => 'Apakah ada biaya tambahan untuk konsultasi pemilihan hotel?',
            'answer' => '<p>Tidak. Layanan konsultasi dan pencarian hotel oleh tim kurator kami sepenuhnya gratis. Kami mendapatkan kompensasi langsung dari pihak hotel mitra kami.</p>'
        ]);

        // 6. Buat Hero Content
        \App\Models\HeroContent::create([
            'title' => 'Sentra Hotels',
            'introduction' => 'Luxury hotels, handled offline',
            'description' => 'Kurasi dan reservasi hotel bintang 4 dan 5 untuk perjalanan bisnis, liburan premium, grup, corporate rate, dan kebutuhan MICE.',
            'images' => [
                'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=1200&q=80',
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1200&q=80',
            ],
            'alignment' => 'center'
        ]);

        // 7. Buat Hotel Chain Images
        \App\Models\HotelChainImage::create(['name' => 'Marriott International', 'image' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=400&q=80']);
        \App\Models\HotelChainImage::create(['name' => 'Hilton Hotels', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=400&q=80']);
        \App\Models\HotelChainImage::create(['name' => 'Accor Live Limitless', 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=400&q=80']);
        \App\Models\HotelChainImage::create(['name' => 'Hyatt Hotels', 'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=400&q=80']);
        \App\Models\HotelChainImage::create(['name' => 'InterContinental Hotels Group', 'image' => 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=400&q=80']);
        \App\Models\HotelChainImage::create(['name' => 'Kempinski Hotels', 'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=400&q=80']);
    }
}
