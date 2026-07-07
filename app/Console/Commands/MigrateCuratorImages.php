<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateCuratorImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curator:migrate-images';
    protected $description = 'Migrate existing string image paths to Curator Media IDs';

    public function handle()
    {
        $this->info('Starting migration...');

        // 1. Hotels
        $hotels = \App\Models\Hotel::whereNotNull('thumbnail')->get();
        foreach ($hotels as $hotel) {
            if ($hotel->thumbnail && !$hotel->thumbnail_id) {
                $hotel->thumbnail_id = $this->createMediaFromPath($hotel->thumbnail);
                $hotel->save();
            }
        }
        $this->info('Hotels migrated.');

        // 2. Hotel Galleries
        $galleries = \App\Models\HotelGallery::whereNotNull('image')->get();
        foreach ($galleries as $gallery) {
            if ($gallery->image && !$gallery->media_id) {
                $gallery->media_id = $this->createMediaFromPath($gallery->image);
                $gallery->save();
            }
        }
        $this->info('Hotel Galleries migrated.');

        // 3. Hotel Rooms
        $rooms = \App\Models\HotelRoom::whereNotNull('image')->get();
        foreach ($rooms as $room) {
            if ($room->image && !$room->media_id) {
                $room->media_id = $this->createMediaFromPath($room->image);
                $room->save();
            }
        }
        $this->info('Hotel Rooms migrated.');

        $this->info('Migration complete!');
    }

    private function createMediaFromPath($path)
    {
        $disk = 'public';
        if (!\Illuminate\Support\Facades\Storage::disk($disk)->exists($path)) {
            return null; // File doesn't exist anymore
        }

        $fullPath = \Illuminate\Support\Facades\Storage::disk($disk)->path($path);
        
        // Check if it already exists in media table
        $existing = \Awcodes\Curator\Models\Media::where('path', $path)->first();
        if ($existing) {
            return $existing->id;
        }

        $info = pathinfo($fullPath);
        $size = filesize($fullPath);
        $mime = mime_content_type($fullPath);
        $dimensions = @getimagesize($fullPath);

        $media = \Awcodes\Curator\Models\Media::create([
            'disk' => $disk,
            'directory' => $info['dirname'] === '.' ? 'media' : $info['dirname'],
            'visibility' => 'public',
            'name' => $info['filename'],
            'path' => $path,
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
            'size' => $size,
            'type' => $mime,
            'ext' => $info['extension'] ?? '',
            'alt' => \Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', $info['filename'])),
            'title' => \Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', $info['filename'])),
        ]);

        return $media->id;
    }
}
