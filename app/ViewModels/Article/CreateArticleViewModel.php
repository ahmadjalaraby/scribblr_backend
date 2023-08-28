<?php

namespace App\ViewModels\Article;

use App\Enums\Article\ArticleStatus;
use App\Models\Tag;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\ViewModel;
use Illuminate\Database\Eloquent\Collection;

final class CreateArticleViewModel extends ViewModel
{
    public function __construct(?PaginateOptions $paginateOptions = null)
    {
        parent::__construct($paginateOptions);
    }


    public function tags(): Collection
    {
        return Tag::all();
    }

    public function status(): array
    {
        return ArticleStatus::values();
    }
}
