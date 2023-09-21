<?php

namespace App\JsonApi\V1\Articles;

use App\JsonApi\Shared\Pagination\ArticlePagination;
use App\JsonApi\Shared\Pagination\SchemaPagination;
use App\Models\Article;
use LaravelJsonApi\Core\Pagination\Page;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Has;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Sorting\SortColumn;
use LaravelJsonApi\Eloquent\Sorting\SortWithCount;

class ArticleSchema extends Schema
{

    protected ?array $defaultPagination = SchemaPagination::DEFAULT_PAGINATION;

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Article::class;


    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Str::make('title'),
            Str::make('content'),
            Str::make('imagePath', 'path')->on('image'),
            Boolean::make('allow_comments'),
            DateTime::make('publish_time')->sortable(),
            Str::make('status'),
            Number::make('user_id')
                ->hidden()
                ->readOnlyOnUpdate(),
            Number::make('tag_id')
                ->hidden(),

            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),

            BelongsTo::make('user')
                ->type('users')
                ->readOnlyOnUpdate(),
            BelongsTo::make('tag')->type('tags'),
            HasOne::make('image')->type('galleries'),

            HasMany::make('comments')->type('comments'),
            HasMany::make('visits')->type('article-visits')->canCount(),
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
            Where::make('status'),
            Where::make('tag', 'tag_id'),
            Where::make('user', 'user_id'),
            Has::make($this, 'comments'),
            Has::make($this, 'visits'),
//            Where::make(),
        ];
    }

    /**
     * Get the resource sortables.
     * @return iterable
     */
    public function sortables(): iterable
    {
        return [
            SortColumn::make('publishTime', 'publish_time'),
            SortWithCount::make('comments'),
            SortWithCount::make('visits'),
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
