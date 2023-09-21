<?php

namespace App\Listeners;

use App\Actions\Api\ArticleVisit\CreateArticleVisit;
use App\DataTransferObjects\ArticleVisitData;
use App\Events\UserVisitedArticle;

final class CreateVisitArticle
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserVisitedArticle $event): void
    {
        CreateArticleVisit::execute(
            new ArticleVisitData(
                id: null,
                user_id: $event->user->id,
                article_id: $event->article->id,
            ),
        );
    }
}
