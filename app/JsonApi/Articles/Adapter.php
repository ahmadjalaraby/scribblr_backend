<?php

namespace App\JsonApi\Articles;

use App\Models\Article;
use App\Models\Gallery;
use App\Models\Tag;
use App\Models\User;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use CloudCreativity\LaravelJsonApi\Eloquent\HasOne;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Adapter extends AbstractAdapter
{

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Mapping of JSON API filter names to model scopes.
     *
     * @var array
     */
    protected $filterScopes = [];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Article(), $paging);
    }

    /**
     * @param Builder $query
     * @param Collection $filters
     * @return void
     */
    protected function filter($query, Collection $filters): void
    {
        $this->filterWithScopes($query, $filters);
    }

    protected function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function image(): HasOne
    {
        return $this->hasOne(Gallery::class);
    }
}
