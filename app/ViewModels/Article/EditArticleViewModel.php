<?php

namespace App\ViewModels\Article;

use App\Enums\Article\ArticleStatus;
use App\Models\Article;
use App\Models\Tag;
use App\ViewModels\ViewModel;
use Illuminate\Database\Eloquent\Collection;

final class EditArticleViewModel extends ViewModel
{
    public function __construct(private readonly Article $article)
    {
        parent::__construct(null);
    }

    public function article(): Article
    {
        return $this->article->load(['image', 'tag']);
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
