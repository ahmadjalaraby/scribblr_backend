<?php

namespace App\Actions\Web\Article;

use App\Actions\Web\Gallery\DeleteGalleryAction;
use App\Models\Article;

final class DeleteArticleAction
{
    public static function execute(Article $article): void
    {
        // get the image relation for article
        $article->load('image');

        if ($article->image) {
            // delete the image gallery model
            DeleteGalleryAction::execute($article->image);
        }

        $article->delete();
    }
}
