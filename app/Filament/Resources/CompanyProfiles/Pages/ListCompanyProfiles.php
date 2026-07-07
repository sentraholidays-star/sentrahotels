<?php

namespace App\Filament\Resources\CompanyProfiles\Pages;

use App\Filament\Resources\CompanyProfiles\CompanyProfileResource;
use App\Models\CompanyProfile;
use Filament\Resources\Pages\ListRecords;

class ListCompanyProfiles extends ListRecords
{
    protected static string $resource = CompanyProfileResource::class;

    public function mount(): void
    {
        $profile = CompanyProfile::first();

        if (!$profile) {
            $profile = CompanyProfile::create([
                'hero_images' => [],
                'title' => 'Tentang Sentra Hotels',
                'content' => '<p>Sentra Hotels adalah Luxury Hotel Desk yang berdedikasi menyediakan layanan reservasi hotel bintang 4 &amp; 5 terbaik secara personal dan korporasi. Kami membantu merancang rencana perjalanan eksklusif Anda dengan pilihan destinasi impian di seluruh Indonesia dan mancanegara.</p>',
            ]);
        }

        redirect()->to(CompanyProfileResource::getUrl('edit', ['record' => $profile->id]));
    }
}
