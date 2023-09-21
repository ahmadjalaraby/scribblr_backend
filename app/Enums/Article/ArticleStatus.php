<?php

declare(strict_types=1);

namespace App\Enums\Article;

use App\Traits\IsEnumValues;

enum ArticleStatus: string
{
    use IsEnumValues;

    case published = 'published';

    case draft = 'draft';

}
