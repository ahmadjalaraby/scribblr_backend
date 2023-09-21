<?php

namespace App\JsonApi\V1\Likes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class LikeRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'sometimes',
                'nullable',
                Rule::in(Auth::id()),
            ],
            'comment_id' => [
                'required',
                'sometimes',
                'nullable',
            ],
            'user' => JsonApiRule::toOne(),
            'comment' => JsonApiRule::toOne(),
        ];
    }

}
