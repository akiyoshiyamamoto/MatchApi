<?php


namespace App\Domain\ProfileImage\Services;

use App\Clients\ImageStorageClient;
use Illuminate\Http\UploadedFile;

class ProfileImageService
{
    const PATH = 'profile_images/';

    private ImageStorageClient $imageStorageClient;

    public function __construct(ImageStorageClient $imageStorageClient)
    {
        $this->imageStorageClient = $imageStorageClient;
    }

    public function upload(UploadedFile $file): string
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = self::PATH . $filename;

        $this->imageStorageClient->store($file, $path);

        return $path;
    }

    public function delete(string $path): void
    {
        $this->imageStorageClient->delete($path);
    }
}
