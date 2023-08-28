<?php

namespace App\Listeners;

use App\Actions\Profile\UpsertProfileAction;
use App\DataTransferObjects\ProfileData;
use App\Events\UserRegistered;

class MakeUserProfile
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        UpsertProfileAction::execute(ProfileData::dummy(), $event->user);
    }
}
