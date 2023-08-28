<?php

namespace App\JsonApi\Tags;

use App\Models\Tag;
use CloudCreativity\LaravelJsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected string $resourceType = 'tags';

    /**
     * @param Tag $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource): string
    {
        return (string)$resource->getRouteKey();
    }

    /**
     * @param Tag $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [
            'title' => $resource->title,
            'active' => $resource->active,
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
        ];
    }

    public function getRelationships(object $resource, bool $isPrimary, array $includedRelationships): array
    {
        return [
            'articles' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ],
            'users' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ],
        ];
    }
}
