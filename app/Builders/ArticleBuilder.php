<?php

namespace App\Builders;

use App\Enums\Article\ArticleStatus;
use Illuminate\Database\Eloquent\Builder;

class ArticleBuilder extends Builder
{
    /**
     * To get the published articles only
     * @return self
     */
    public function wherePublished(): self
    {
        return $this->where('status', ArticleStatus::published->value);
    }

    /**
     * Mark the article as [published]
     * @return void
     */
    public function markAsPublished(): void
    {
        $this->model->status = ArticleStatus::published->value;
        $this->model->publish_time = now();
        $this->model->save();
    }
}
