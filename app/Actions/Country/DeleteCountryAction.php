<?php

namespace App\Actions\Country;

use App\Models\Country;

class DeleteCountryAction
{
    /**
     * This action will delete the country model
     * @param Country $country
     * @return void
     */
    public static function execute(Country $country)
    {
        $country->delete();
    }
}
