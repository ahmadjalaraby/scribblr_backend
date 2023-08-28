<?php

namespace App\DataTransferObjects;

use App\Constants\DateTime\DateTimeFormat;
use App\Constants\Image\ImageDirectoryConstants;
use App\Enums\Article\ArticleStatus;
use Carbon\Carbon;
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

final class ArticleData extends Data
{
    public function __construct(
        public readonly ?int                  $id,
        public readonly string                $title,
        public readonly ?string               $content,
        #[WithCast(EnumCast::class)]
        public readonly ArticleStatus         $status,
        public readonly bool                  $allow_comments,
        #[WithCast(DateTimeInterfaceCast::class, format: DateTimeFormat::PUBLISH_AT)]
        #[WithTransformer(DateTimeInterfaceTransformer::class)]
        public readonly ?Carbon               $publish_time,
        public readonly int                   $tag_id,
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

    public static function withValidator(Validator $validator): void
    {
        $validator->setRules(self::rules());
    }

    public static function rules(): array
    {
        return [
            'title' => [
                'required',
                'string'
            ],
            'content' => [
                'nullable',
                'sometimes',
                'string'
            ],
            'status' => [
                'required',
                'string',
                Rule::in(ArticleStatus::values()),
            ],
            'publish_time' => [
                'nullable',
                'sometimes',
            ],
            'tag_id' => [
                'required'
            ],
            'image' => ['nullable', 'sometimes', 'image'],
        ];
    }
}
