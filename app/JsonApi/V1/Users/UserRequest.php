<?php

namespace App\JsonApi\V1\Users;

use App\Enums\User\UserGender;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class UserRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'username' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
                Rule::unique('users', 'email')->ignoreModel($this->model()),
            ],
            'phoneNumber' => [
                'nullable',
            ],
            'gender' => [
                Rule::enum(UserGender::class),
            ],
            'dateOfBirth' => [
                'nullable',
                JsonApiRule::dateTime(),
            ],
            'password' => [
                'required',
            ],
        ];
    }

}
