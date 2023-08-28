<?php

namespace App\ViewModels\Country;

use App\Models\Country;
use App\ViewModels\ViewModel;

class EditCountryViewModel extends ViewModel
{
    public function __construct(private readonly Country $country)
    {
        parent::__construct(null);
    }

    /**
     * This function will return the country model which will be updated
     * @return Country
     */
    public function country(): Country
    {
        return $this->country;
    }
}
