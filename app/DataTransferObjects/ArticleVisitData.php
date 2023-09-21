<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

final class ArticleVisitData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly int  $user_id,
        public readonly int  $article_id,
    )
    {
    }
}
