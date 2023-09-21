<?php

namespace App\Policies;

use App\Enums\Article\ArticleStatus;
use App\Events\UserVisitedArticle;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Article $article): bool
    {
        // Check if user who published the article
        if ($user?->is($article->user)) return true;


        if ($isPublished = $article->status === ArticleStatus::published) {
            event(new UserVisitedArticle(
                user: $user,
                article: $article,
            ));
        }

        return $isPublished;
    }

    /**
     * Authorize a user to view an article's comments.
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function viewComments(User $user, Article $article): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return !!$user;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Article $article): bool
    {
        return $user?->is($article->user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Article $article): bool
    {
        return $user?->is($article->user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?User $user, Article $article): bool
    {
        return $user?->is($article->user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?User $user, Article $article): bool
    {
        return $user?->is($article->user);
    }
}
