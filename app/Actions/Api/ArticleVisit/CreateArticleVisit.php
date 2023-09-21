<?php

namespace App\Actions\Api\ArticleVisit;

use App\DataTransferObjects\ArticleVisitData;
use App\Models\ArticleVisit;

final class CreateArticleVisit
{
    public static function execute(ArticleVisitData $data)
    {
        return ArticleVisit::create(
            $data->all(),
        );
    }
}
