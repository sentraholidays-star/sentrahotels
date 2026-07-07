<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\StaticPageSeo;

$seo = StaticPageSeo::firstOrCreate(
    ['page_identifier' => 'join-us'],
    [
        'page_name' => 'Join Us',
        'meta_title' => 'Join Our Network',
        'meta_description' => 'Bergabunglah dengan jaringan Sentra Hotels untuk pengalaman B2B terbaik.',
    ]
);

echo "SEO injected successfully.";
