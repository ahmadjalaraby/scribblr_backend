<?php

namespace App\Constants\Pagination;

final class PaginationConstants {
    /** @var int This constant variable for items per page  */
    const DEFAULT_PER_PAGE = 10;

    /**
     * This function is a getter for the DEFAULT_PER_PAGE constant
     * @return int
     */
    public static function getDefaultPerPage(): int
    {
        return self::DEFAULT_PER_PAGE;
    }

}

