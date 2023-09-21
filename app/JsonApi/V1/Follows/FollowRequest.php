<?php

namespace App\JsonApi\V1\Follows;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class FollowRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'follower' => JsonApiRule::toOne(),
            'followed' => JsonApiRule::toOne(),

            'follower_id' => [
                'required',
                Rule::in(Auth::id()),
            ],
            'followed_id' => [
                'required',
            ],
        ];
    }

}
