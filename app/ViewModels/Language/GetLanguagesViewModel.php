<?php

namespace App\ViewModels\Language;


use App\Models\Language;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\ViewModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetLanguagesViewModel extends ViewModel
{
    public function __construct(PaginateOptions $paginateOptions)
    {
        parent::__construct($paginateOptions);
    }


    /**
     * This function will return the languages models in the view
     * @return  Collection|LengthAwarePaginator
     */
    public function languages(): Collection|LengthAwarePaginator
    {
        if($this->paginateOptions->paginate){
            return Language::query()
                ->paginate($this->paginateOptions->itemsPerPage);
        }

        return Language::all();
    }

    /**
     * This function will return the count of all language models
     * @return int
     */
    public function count(): int
    {
        return Language::count();
    }
}
