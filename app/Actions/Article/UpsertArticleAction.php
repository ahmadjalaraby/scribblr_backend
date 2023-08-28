<?php

namespace App\Actions\Article;

use App\Actions\Gallery\DeleteGalleryAction;
use App\DataTransferObjects\ArticleData;
use Illuminate\Support\Facades\DB;

final class UpsertArticleAction
{
    public static function execute(ArticleData $data)
    {
        return DB::transaction(function () use ($data) {
            $article = request()->user()->articles()->updateOrCreate(
                [
                    'id' => $data->id,
                ],
                $data->all(),
            );

            $article->load('image');

            // update the image relation if exists
            if ($article->image && $data->image) {
                DeleteGalleryAction::execute($article->image);
            }

            // create an image if image file exists
            if ($data->image) {
                $article->image()->create($data->image->all());
            }

            return $article;
        });
    }
}
