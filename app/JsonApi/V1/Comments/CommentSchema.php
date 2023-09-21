<?php

namespace App\JsonApi\V1\Comments;

use App\JsonApi\Shared\Pagination\SchemaPagination;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Has;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Sorting\SortWithCount;

class CommentSchema extends Schema
{
    protected ?array $defaultPagination = SchemaPagination::DEFAULT_PAGINATION;


    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Comment::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Str::make('comment'),
            Number::make('article_id')
                ->hidden()
                ->readOnlyOnUpdate(),
            Number::make('user_id')
                ->hidden()
                ->readOnlyOnUpdate(),
            Number::make('user_id'),
            Boolean::make('isLikedByAuthUser')
                ->unguarded()
                ->extractUsing(
                    static fn($model, $column, $value) => Auth::user() &&
                        $model->likes()->where('user_id', Auth::user()->id)->exists()
                )->readOnly(),

            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),

            BelongsTo::make('user')
                ->type('users')
                ->readOnlyOnUpdate(),
            BelongsTo::make('article')
                ->type('articles'),
            HasMany::make('likes')
                ->type('likes')
                ->canCount(),
        ];
    }


    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
            Where::make('article', 'article_id'),
            Has::make($this, 'likes'),
        ];
    }

    /**
     * Get the resource sortables
     * @return iterable
     */
    public function sortables(): iterable
    {
        return [
            SortWithCount::make('likes'),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make();
    }

}
