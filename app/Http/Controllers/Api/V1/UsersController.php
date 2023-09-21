<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\JsonApi\V1\Users\UserQuery;
use App\JsonApi\V1\Users\UserSchema;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class UsersController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    /**
     * Laravel Controller Traits
     */
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Fetch the auth user by JSON API resource response.
     *
     * @param UserSchema $schema
     * @param UserQuery $request
     * @return Responsable|Response
     */
    public function auth(UserSchema $schema, UserQuery $request): Responsable|Response
    {
        $user = Auth::user();

        $model = $schema
            ->repository()
            ->queryOne($user)
            ->withRequest($request)
            ->first();


        return new DataResponse($model);
    }
}
