<?php

namespace App\DataTransferObjects;

use App\Constants\Image\ImageDirectoryConstants;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

final class TagData extends Data
{
    public function __construct(
        public readonly ?int                  $id,
        public readonly string                $title,
        public readonly bool                  $active,
        public readonly null|Lazy|GalleryData $image,
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        $imageFile = $request->file('image');

        $image = $imageFile ? GalleryData::fromFile($imageFile, ImageDirectoryConstants::TAG)
            : null;

        return self::from([
            ...$request->all(),
            'image' => $image,
        ]);
    }

    public static function fromModel(Tag $tag): self
    {
        return self::from([
            ...$tag->toArray(),
            'image' => Lazy::whenLoaded('image', $tag, fn() => GalleryData::from($tag->image)),
        ]);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'active' => $this->active,
            'image' => $this->image?->toArray()
        ];
    }

    public static function withValidator(Validator $validator): void
    {
        $validator->setRules(self::rules());
    }

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'image' => ['required', 'image'],
        ];
    }
}
