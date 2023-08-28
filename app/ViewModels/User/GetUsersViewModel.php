<?php

namespace App\ViewModels\User;

use App\Models\User;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\ViewModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class GetUsersViewModel extends ViewModel
{
    public function __construct(PaginateOptions $paginateOptions = null)
    {
        parent::__construct($paginateOptions);
    }

    /**
     *  This will return a tags models
     * @return Collection|LengthAwarePaginator
     */
    public function users(): Collection|LengthAwarePaginator
    {
        if ($this->paginateOptions->paginate) {
            return User::query()
                ->with([
                    'image',
                    'profile',
                    'country'
                ])
                ->paginate($this->paginateOptions->itemsPerPage);
        }
        return User::query()
            ->with([
                'image',
                'profile',
            ])->get();
    }

    /**
     * This will return the number of all tags models
     * @return int
     */
    public function total(): int
    {
        return User::count();
    }
}
