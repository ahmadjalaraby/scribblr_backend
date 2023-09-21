<?php

declare(strict_types=1);

namespace App\Actions\Api\User\Token;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\NewAccessToken;

final class CreateUserTokenAction
{
    /**
     * Create a Sanctum Token for User.
     * @param int $id
     * @param string $name
     * @param array $abilities
     * @return NewAccessToken
     */
    public static function execute(int $id, string $name, array $abilities = ['*']): NewAccessToken
    {
        return DB::transaction(
            callback: fn() => User::find(id: $id)
                ->createToken(
                    name: $name,
                    abilities: $abilities,
                ),
            attempts: 2
        );
    }
}
