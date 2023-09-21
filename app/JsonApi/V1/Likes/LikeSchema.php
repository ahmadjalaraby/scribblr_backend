<?php

namespace App\JsonApi\V1\Likes;

use App\JsonApi\Shared\Pagination\SchemaPagination;
use App\Models\Like;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class LikeSchema extends Schema
{
    protected ?array $defaultPagination = SchemaPagination::DEFAULT_PAGINATION;


    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Like::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Number::make('user_id')->hidden()->readOnlyOnUpdate(),
            Number::make('comment_id')->hidden()->readOnlyOnUpdate(),

            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),

            BelongsTo::make('user')->type('users')->readOnly(),
            BelongsTo::make('comment')->type('comments')->readOnly(),
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
            Where::make('comment', 'comment_id'),
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
