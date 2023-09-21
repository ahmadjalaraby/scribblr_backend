<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Tag;
use App\Models\User;
use App\Policies\ArticlePolicy;
use App\Policies\BookmarkPolicy;
use App\Policies\CommentPolicy;
use App\Policies\FollowPolicy;
use App\Policies\LikePolicy;
use App\Policies\TagPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Article::class => ArticlePolicy::class,
        Tag::class => TagPolicy::class,
        Comment::class => CommentPolicy::class,
        Like::class => LikePolicy::class,
        Follow::class => FollowPolicy::class,
        Bookmark::class => BookmarkPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

    }
}
