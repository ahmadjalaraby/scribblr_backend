<?php

namespace App\JsonApi\V1\Bookmarks;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class BookmarkRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user' => JsonApiRule::toOne(),
            'article' => JsonApiRule::toOne(),

            'user_id' => [
                'required',
                'sometimes',
                'nullable',
                Rule::in(Auth::id()),
            ],
            'article_id' => [
                'required',
                'sometimes',
                'nullable',
            ],
        ];
    }

}
