<?php

namespace App\JsonApi\V1\Comments;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class CommentRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'comment' => [
                'required',
                'string',
            ],
            'article' => JsonApiRule::toOne(),
            'user' => JsonApiRule::toOne(),
            'article_id' => [
                'required',
                'sometimes',
                'nullable',
            ],
            'user_id' => [
                'required',
                'sometimes',
                'nullable',
                Rule::in(Auth::id()),
            ],
        ];
    }

}
