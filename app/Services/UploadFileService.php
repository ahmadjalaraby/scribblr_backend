<?php

namespace App\Services;

use App\Constants\Image\ImageDirectoryConstants;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadFileService
{
    /**
     * This function will upload a file to public storage
     * @param UploadedFile $file
     * @param string|null $path
     * @return string|null
     */
    public static function upload(UploadedFile $file, ?string $path = ''): string|null
    {
        if(empty($path)) return null;

        // This will return "galleries/"
        $mainDirectory = Str::addSlash(ImageDirectoryConstants::GALLERY);
        $publicDirectory = Str::addSlash(ImageDirectoryConstants::PUBLIC);

        return $file->store($publicDirectory . $mainDirectory . $path);
    }
}
