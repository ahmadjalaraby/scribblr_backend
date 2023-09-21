<?php

namespace App\Actions\Web\Gallery;

use App\DataTransferObjects\GalleryData;
use App\Models\Gallery;

class UpsertGalleryAction {

    public static function execute(GalleryData $data): Gallery
    {
        return Gallery::updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->all()
        );
    }
}
