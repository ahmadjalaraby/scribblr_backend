<?php

namespace App\ViewModels\Country;

use App\Constants\Pagination\PaginationConstants;
use App\Models\Country;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\ViewModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetCountriesViewModel extends ViewModel
{
    public function __construct(?PaginateOptions $paginateOptions = new PaginateOptions(true, PaginationConstants::DEFAULT_PER_PAGE))
    {
        parent::__construct($paginateOptions);
    }

    /**
     * This will return countries models
     * @return Collection|LengthAwarePaginator
     */
    public function countries(): Collection|LengthAwarePaginator
    {
        if ($this->paginateOptions->paginate) {
            return Country::query()
                ->paginate($this->paginateOptions->itemsPerPage);
        }
        return Country::all();
    }


    /**
     * This function will return the count of all countries
     * @return int
     */
    public function total(): int
    {
        return Country::count();
    }
}
