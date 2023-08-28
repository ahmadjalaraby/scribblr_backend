<?php

namespace App\ValueObjects;

use App\Constants\Pagination\PaginationConstants;

final class PaginateOptions {
    /** @var bool|null $paginate This variable for turning on/off pagination for model
     *  If value is null then Default value is True
     */
    public readonly ?bool $paginate;

    /** @var int|null $itemsPerPage This variable for the count of items of model in single page, if value is null then
     * DEFAULT_PER_PAGE constant is provided
     */
    public readonly ?int $itemsPerPage;


    public function __construct(?bool $paginate = true, ?int $itemsPerPage = PaginationConstants::DEFAULT_PER_PAGE)
    {
        $this->paginate = $paginate;
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * This function will return instance of PaginateOptions
     * @param bool $paginate
     * @param null|int $itemsPerPage
     * @return self
     */
    public static function from(bool $paginate, ?int $itemsPerPage = PaginationConstants::DEFAULT_PER_PAGE): self
    {
        return new self($paginate, $itemsPerPage);
    }
}
