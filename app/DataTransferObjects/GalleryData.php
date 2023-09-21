<?php

namespace App\DataTransferObjects;

use App\Constants\Image\ImageDirectoryConstants;
use App\Enums\Gallery\GalleryLoadableType;
use App\Enums\Image\SizeFormat;
use App\Models\Gallery;
use App\Services\UploadFileService;
use App\ValueObjects\FileSize;
use App\ValueObjects\ImageDimension;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;

final class GalleryData extends Data
{
    public function __construct(
        public readonly ?int                 $id,
        public readonly ?int                 $loadableId,
        #[WithCast(EnumCast::class)]
        public readonly ?GalleryLoadableType $loadableType,
        public readonly ?string              $path,
        public readonly ?string              $mime,
        public readonly ?string              $size,
        public readonly float                $width,
        public readonly float                $height,
        public readonly float                $aspect_ratio,
    )
    {
    }


    public static function fromModel(Gallery $gallery): self
    {
        return self::from(
            [
                ...$gallery->toArray(),
            ],
        );
    }

    public static function fromFile(UploadedFile $file, string $imageDir = ''): self
    {
        $mime = $file->getClientMimeType();

        // get the file size and return it in kilobytes
        $size = FileSize::from($file->getSize())->toFormat(SizeFormat::kilobytes);

        // get image dimension
        $imageSize = getimagesize($file);


        // upload the image
        $uploadedFilePath = UploadFileService::upload($file, $imageDir);

        if ($uploadedFilePath) {
            $uploadedFilePath = str_replace(Str::addSlash(ImageDirectoryConstants::PUBLIC), '', $uploadedFilePath);
        }

        $imageDimension = ImageDimension::from($imageSize[0], $imageSize[1]);

        return self::from(
            [
                'mime' => $mime,
                'size' => $size,
                'path' => $uploadedFilePath,
                'width' => $imageDimension->width,
                'height' => $imageDimension->height,
                'aspect_ratio' => $imageDimension->aspectRatio,
            ],
        );
    }

    public static function fromBase64(string $base64Image, string $imageDir = ''): self
    {
        // Convert base64 string to a temporary UploadedFile instance
        $tempFile = tempnam(sys_get_temp_dir(), 'base64' . '/' . $imageDir);
        file_put_contents($tempFile, base64_decode($base64Image));

        $mime = mime_content_type($tempFile);

        // Calculate the size of the decoded base64 data
        $size = FileSize::from(strlen(base64_decode($base64Image)))->toFormat(SizeFormat::kilobytes);

        // get image dimension
        $imageSize = getimagesize($tempFile);

        // upload the image
        $uploadedFile = new UploadedFile(
            $tempFile,
            Str::random() . '.png',
            $mime,
            0,
            true
        );
        $uploadedFilePath = UploadFileService::upload($uploadedFile, $imageDir);

        if ($uploadedFilePath) {
            $uploadedFilePath = str_replace(Str::addSlash(ImageDirectoryConstants::PUBLIC), '', $uploadedFilePath);
        }

        $imageDimension = ImageDimension::from($imageSize[0], $imageSize[1]);

        // Clean up the temporary file
        unlink($tempFile);

        return self::from([
            'mime' => $mime,
            'size' => $size,
            'path' => $uploadedFilePath,
            'width' => $imageDimension->width,
            'height' => $imageDimension->height,
            'aspect_ratio' => $imageDimension->aspectRatio,
        ]);
    }


    public static function fromModels(Collection $galleries): LazyCollection
    {
        return LazyCollection::make(function () use ($galleries) {
            foreach ($galleries as $gallery) {
                yield self::fromModel($gallery);
            }
        });
    }

    public function toArray(): array
    {
        return self::all();
    }

    public static function withValidator(Validator $validator): void
    {
        $validator->setRules(self::rules());
    }

    public static function rules(): array
    {
        return [
            'image' => 'required',
        ];
    }
}
