<?php

namespace App\Actions\Web\User;

use App\Actions\Web\Gallery\DeleteGalleryAction;
use App\Models\User;

final class DeleteUserAction
{
    public static function execute(User $user): void
    {
        // get the image relation for tag
        $user = $user->load('image');
        if ($user->image) {
            // delete the image gallery model
            DeleteGalleryAction::execute($user->image);
        }

        $user->delete();
    }
}
