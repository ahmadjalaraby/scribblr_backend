<?php

namespace App\DataTransferObjects;


use App\Constants\DateTime\DateTimeFormat;
use App\Constants\Image\ImageDirectoryConstants;
use App\Enums\User\UserGender;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class UserData extends Data
{
    public function __construct(
        public readonly ?int                  $id,
        public readonly string                $firstname,
        public readonly string                $lastname,
        public readonly string                $username,
        public readonly string                $email,
        public readonly ?string               $phone_number,
        public readonly ?int                  $country_id,
        #[WithCast(EnumCast::class)]
        public readonly UserGender            $gender,
        #[WithCast(DateTimeInterfaceCast::class, format: DateTimeFormat::DATE_OF_BIRTH)]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public readonly ?DateTime             $date_of_birth,
        public readonly null|Lazy|GalleryData $image,
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        $imageFile = $request->file('image');

        $image = $imageFile ? GalleryData::fromFile($imageFile, ImageDirectoryConstants::USER)
            : null;

        return self::from([
            ...$request->all(),
            'image' => $image,
        ]);
    }

    public static function fromModel(User $user): self
    {
        return self::from([
            ...$user->toArray(),
            'image' => Lazy::whenLoaded('image', $user, fn() => GalleryData::from($user->image)),
        ]);
    }

    public static function withValidator(Validator $validator): void
    {
        $validator->setRules(self::rules());
    }

    public static function rules(): array
    {
        return [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username')
                    ->ignoreModel(request()->user())
                    ->ignore(request()->input('id')),
            ],
            'email' => [
                'required',
                'string',
                Rule::unique('users', 'email')
                    ->ignoreModel(request()->user())
                    ->ignore(request()->input('id')),
            ],
//            'password' => [
//                'nullable',
//                'sometimes',
//                'string',
//                'confirmed',
//            ],
            'gender' => [
                'required',
                'string',
                Rule::in(UserGender::values()),
            ],
            'date_of_birth' => [
                'nullable',
                'sometimes',
            ],
            'country_id' => [
                'required'
            ],
            'image' => ['nullable', 'sometimes', 'image'],
        ];
    }
}
