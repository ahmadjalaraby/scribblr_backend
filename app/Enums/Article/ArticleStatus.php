<?php

namespace App\Enums\Article;

use Webfox\LaravelBackedEnums\BackedEnum;
use Webfox\LaravelBackedEnums\IsBackedEnum;

enum ArticleStatus: string implements BackedEnum
{
    use IsBackedEnum;

    case published = 'published';

    case draft = 'draft';

}
