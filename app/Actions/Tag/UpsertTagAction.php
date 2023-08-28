<?php

namespace App\Actions\Tag;


use App\Actions\Gallery\DeleteGalleryAction;
use App\DataTransferObjects\TagData;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

final class UpsertTagAction
{
    public static function execute(TagData $data): Tag
    {
        return DB::transaction(function () use ($data) {
            $tag = Tag::updateOrCreate(
                [
                    'id' => $data->id,
                ],
                $data->all(),
            );

            $tag->load('image');

            // update the image relation if exist
            if ($tag->image && $data->image) {
                DeleteGalleryAction::execute($tag->image);
            }

            // create an image if exist
            if ($data->image) {
                $tag->image()->create($data->image->all());
            }

            return $tag;
        });
    }
}
