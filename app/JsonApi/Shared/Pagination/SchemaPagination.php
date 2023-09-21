<?php

namespace App\JsonApi\Shared\Pagination;

/**
 * Abstract class for Schema Default Pagination
 */
class SchemaPagination
{

    /** @var int[] Default pagination for json api schema */
    const DEFAULT_PAGINATION = [
        'page' => 1,
        'size' => 8,
    ];
}
