<?php

namespace App\Actions\User;

use App\Actions\Gallery\DeleteGalleryAction;
use App\DataTransferObjects\UserData;
use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class UpsertUserAction
{

    public static function execute(UserData $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::updateOrCreate(
                [
                    'id' => $data->id,
                ],
                $data->all(),
            );

            $user->load('image');

            // update the image relation if exists
            if ($user->image && $data->image) {
                DeleteGalleryAction::execute($user->image);
            }

            // create an image if image file exists
            if ($data->image) {
                $user->image()->create($data->image->all());
            }

            if (!$data->id) event(new UserRegistered(user: $user));

            return $user;
        });
    }
}
