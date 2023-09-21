<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Api\User\Token\CreateUserTokenAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use LaravelJsonApi\Core\Responses\DataResponse;

final class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return DataResponse
     * @throws ValidationException
     */
    public function __invoke(LoginRequest $request): DataResponse
    {
        $request->authenticate();

        $user = $request->user();

        // create a token
        $token = CreateUserTokenAction::execute(
            id: (int)Auth::id(),
            name: $request->userAgent(),
        );

        return DataResponse::make(value: $user)
            ->withServer(name: 'v1')
            ->withMeta(
                meta: [
                    'token' => $token,
                ],
            );
    }
}
