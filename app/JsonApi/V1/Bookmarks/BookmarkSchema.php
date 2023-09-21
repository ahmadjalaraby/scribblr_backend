<?php

namespace App\JsonApi\V1\Bookmarks;

use App\JsonApi\Shared\Pagination\SchemaPagination;
use App\Models\Bookmark;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class BookmarkSchema extends Schema
{

    protected ?array $defaultPagination = SchemaPagination::DEFAULT_PAGINATION;

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Bookmark::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Number::make('user_id')
                ->hidden()
                ->readOnlyOnUpdate(),
            Number::make('article_id')
                ->hidden()
                ->readOnlyOnUpdate(),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),

            BelongsTo::make('user')->type('users')->readOnly(),
            BelongsTo::make('article')->type('articles'),
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
            Where::make('user', 'user_id'),
            Where::make('article', 'article_id'),
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
