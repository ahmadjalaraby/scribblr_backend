<?php

namespace App\ViewModels\User;

use App\Constants\Pagination\PaginationConstants;
use App\Models\Country;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\ViewModel;
use Illuminate\Database\Eloquent\Collection;

final class CreateUserViewModel extends ViewModel
{
    public function __construct(?PaginateOptions $paginateOptions = null)
    {
        parent::__construct($paginateOptions);
    }

    public function countries(): Collection
    {
        return Country::all();
    }
}
