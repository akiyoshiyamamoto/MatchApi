<?php

namespace App\Clients;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageStorageClient
{
    private const DISK = 'local';
    private const DIRECTORY = 'profile_images';

    public function store(UploadedFile $file, string $filename): string
    {
        return Storage::disk(self::DISK)->putFileAs(self::DIRECTORY, $file, $filename);
    }

    public function delete(string $path): void
    {
        Storage::disk(self::DISK)->delete($path);
    }
}
