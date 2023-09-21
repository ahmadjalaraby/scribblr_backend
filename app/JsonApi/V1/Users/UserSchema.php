<?php

namespace App\JsonApi\V1\Users;

use App\JsonApi\Shared\Pagination\SchemaPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class UserSchema extends Schema
{
    protected ?array $defaultPagination = SchemaPagination::DEFAULT_PAGINATION;


    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = User::class;


    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            Str::make('firstname'),
            Str::make('lastname'),
            Str::make('username'),
            Str::make('email'),
            Str::make('phoneNumber', 'phone_number'),
            Str::make('gender'),
            Str::make('password')->deserializeUsing(
                deserializer: static fn($value) => Hash::make($value),
            ),
            Str::make('avatar', 'path')->on('image'),
            DateTime::make('dateOfBirth', 'date_of_birth'),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),

            // Relationships
            HasOne::make('image')->type('galleries'),
            BelongsTo::make('country')->type('countries'),

            HasMany::make('followers')->type('follows')->canCount(),
            HasMany::make('followedUsers')->type('follows')->canCount(),
            HasOne::make('profile'),

            HasMany::make('articles')
                ->type('articles')
                ->canCount(),

            HasMany::make('visits', 'articleVisits')
                ->type('article-visits')
                ->canCount(),

            HasMany::make('likes')->type('likes')->canCount(),
            HasMany::make('comments')->type('comments')->canCount(),
            HasMany::make('bookmarks')->type('bookmarks')->canCount(),
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
