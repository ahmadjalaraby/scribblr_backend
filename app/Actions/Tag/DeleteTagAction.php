<?php

namespace App\Actions\Tag;

use App\Actions\Gallery\DeleteGalleryAction;
use App\Models\Tag;

final class DeleteTagAction
{
    /**
     * This action will delete the tag model
     * @param Tag $tag
     * @return void
     */
    public static function execute(Tag $tag): void
    {
        // get the image relation for tag
        $tag = $tag->load('image');
        if ($tag->image) {
            // delete the image gallery model
            DeleteGalleryAction::execute($tag->image);
        }

        $tag->delete();
    }
}
