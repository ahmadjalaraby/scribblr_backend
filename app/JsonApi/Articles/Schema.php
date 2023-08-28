<?php

namespace App\JsonApi\Articles;

use App\Models\Article;
use CloudCreativity\LaravelJsonApi\Schema\SchemaProvider;
use Spatie\LaravelData\Lazy;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected string $resourceType = 'articles';

    /**
     * @param Article $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource): string
    {
        return (string)$resource->getRouteKey();
    }

    /**
     * @param Article $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [
            'title' => $resource->title,
            'content' => $resource->content,
            'status' => $resource->status->value,
            'allowComments' => $resource->allow_comments,
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
        ];
    }

    public function getRelationships(object $resource, bool $isPrimary, array $includedRelationships): array
    {
        return [
            'user' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ],
            'tag' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ],
            'image' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => true,
            ],
        ];
    }
}
