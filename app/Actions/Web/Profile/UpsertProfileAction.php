<?php

namespace App\Actions\Web\Profile;

use App\DataTransferObjects\ProfileData;
use App\Models\User;

class UpsertProfileAction
{
    public static function execute(ProfileData $data, User $user): void
    {
        $user->profile()->updateOrCreate(
            [],
            $data->all(),
        );
    }
}
