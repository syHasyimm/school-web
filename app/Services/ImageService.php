<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class ImageService
{
    protected int $maxWidth = 1920;
    protected int $quality = 80;
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(Driver::class);
    }

    public function upload(UploadedFile $file, string $directory, ?int $maxWidth = null, ?int $quality = null): string
    {
        $maxWidth = $maxWidth ?? $this->maxWidth;
        $quality = $quality ?? $this->quality;

        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = "{$directory}/{$filename}";

        // Process image: resize if needed and compress
        if (in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'webp'])) {
            $image = $this->manager->decodePath($file->getPathname());

            // Only resize if wider than max
            if ($image->width() > $maxWidth) {
                $image->scaleDown(width: $maxWidth);
            }

            // Encode to JPEG and store
            $encoded = $image->encode(new JpegEncoder(quality: $quality));
            Storage::disk('public')->put($path, (string) $encoded);
        } else {
            // Non-image files (e.g., PDF), just store directly
            Storage::disk('public')->putFileAs($directory, $file, $filename);
        }

        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function getUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return asset('storage/' . $path);
    }

    public function exists(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->exists($path);
    }
}
