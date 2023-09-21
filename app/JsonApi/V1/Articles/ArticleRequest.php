<?php

namespace App\JsonApi\V1\Articles;

use App\Enums\Article\ArticleStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class ArticleRequest extends ResourceRequest
{
    protected function isSupportedMediaType(): bool
    {
        return true;
    }


    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
            ],
            'content' => [
                'required',
                'string',
            ],
            'allow_comments' => [
                'nullable',
                JsonApiRule::boolean(),
            ],
            'publish_time' => [
                'nullable',
                JsonApiRule::dateTime(),
            ],
            'status' => [
                'required',
                Rule::enum(ArticleStatus::class),
            ],
            'tag' => JsonApiRule::toOne(),
            'user' => JsonApiRule::toOne(),
            'user_id' => [
                'required',
                'sometimes',
                'nullable',
                Rule::in(Auth::id()),
            ],
            'tag_id' => [
                'required',
                'sometimes',
                'nullable',
            ],
        ];
    }

}
