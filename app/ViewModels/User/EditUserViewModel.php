<?php


namespace App\ViewModels\User;


use App\Models\Country;
use App\Models\User;
use App\ViewModels\ViewModel;
use Illuminate\Database\Eloquent\Collection;

final class EditUserViewModel extends ViewModel
{

    public function __construct(private readonly User $user)
    {
        parent::__construct(null);
    }

    /**
     * This function will return the Tag model with image relation
     * @return User
     */
    public function user(): User
    {
        return $this->user->load('image');
    }

    /**
     * This function will return the total Countries in DB
     * @return Collection
     */
    public function countries(): Collection
    {
        return Country::all();
    }
}
