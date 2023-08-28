<?php

namespace App\Actions\Gallery;


use App\Constants\Image\ImageDirectoryConstants;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class DeleteGalleryAction {

    public static function execute(Gallery $gallery): void
    {
        // delete image
        Storage::disk(ImageDirectoryConstants::PUBLIC)->delete($gallery->path);

        $gallery->delete();
    }
}
