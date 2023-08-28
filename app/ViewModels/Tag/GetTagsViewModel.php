<?php

namespace App\ViewModels\Tag;


use App\Constants\Pagination\PaginationConstants;
use App\Models\Tag;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\ViewModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetTagsViewModel extends ViewModel
{
    public function __construct(?PaginateOptions $paginateOptions = new PaginateOptions(paginate: true, itemsPerPage: PaginationConstants::DEFAULT_PER_PAGE))
    {
        parent::__construct($paginateOptions);
    }

    /**
     *  This will return a tags models
     * @return Collection|LengthAwarePaginator
     */
    public function tags(): Collection|LengthAwarePaginator
    {
        if ($this->paginateOptions->paginate) {
            return Tag::query()
                ->with('image')
                ->paginate($this->paginateOptions->itemsPerPage);
        }
        return Tag::all();
    }

    /**
     * This will return the number of all tags models
     * @return int
     */
    public function total(): int
    {
        return Tag::count();
    }
}
