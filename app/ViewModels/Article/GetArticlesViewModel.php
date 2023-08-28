<?php

namespace App\ViewModels\Article;


use App\Models\Article;
use App\ValueObjects\PaginateOptions;
use App\ViewModels\ViewModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class GetArticlesViewModel extends ViewModel
{
    public function __construct(PaginateOptions $paginateOptions = null)
    {
        parent::__construct($paginateOptions);
    }

    /**
     *  This will return a tags models
     * @return Collection|LengthAwarePaginator
     */
    public function articles(): Collection|LengthAwarePaginator
    {
        if ($this->paginateOptions->paginate) {
            return Article::query()
                ->with([
                    'image',
                    'tag',
                ])->paginate($this->paginateOptions->itemsPerPage);
        }
        return Article::query()
            ->with([
                'image',
                'tag',
            ])->get();
    }

    /**
     * This will return the number of all tags models
     * @return int
     */
    public function total(): int
    {
        return Article::count();
    }
}
