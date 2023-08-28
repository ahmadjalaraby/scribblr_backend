<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class ProfileData extends Data
{
    public function __construct(
        public readonly ?int    $id,
        public readonly ?string $description,
        public readonly ?string $whatsapp,
        public readonly ?string $facebook,
        public readonly ?string $twitter,
        public readonly ?string $instagram,
        public readonly ?string $website,
        public readonly ?string $location,
    )
    {
    }

    public static function dummy(): self
    {
        return self::from(
            [
                'description' => null,
                'whatsapp' => null,
                'facebook' => null,
                'twitter' => null,
                'instagram' => null,
                'website' => null,
                'location' => null,
            ],
        );
    }
}
