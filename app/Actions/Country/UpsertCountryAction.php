<?php

namespace App\Actions\Country;

use App\Actions\Gallery\DeleteGalleryAction;
use App\DataTransferObjects\CountryData;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class UpsertCountryAction
{
    /**
     *
     * @param CountryData $data
     * @return Country
     */
    public static function execute(CountryData $data): Country
    {
        return DB::transaction(function () use ($data) {
            return Country::updateOrCreate(
                [
                    'id' => $data->id,
                ],
                $data->all(),
            );
        });
    }
}
