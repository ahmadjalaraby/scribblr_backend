<?php

namespace App\Enums\Image;


use App\Constants\FileSize\FileSizeConstants;

enum SizeFormat: string
{
    case bytes = 'bytes';
    case kilobytes = 'kilobytes';

    case megabytes = 'megabytes';

    case gigabytes = 'gigabytes';

    /**
     * This function will get format as parameter and then return the value of it in bytes
     * @param SizeFormat|null $format
     * @return float
     */
    public static function getValue(?SizeFormat $format): float
    {
        return match ($format) {
            self::bytes => FileSizeConstants::BYTES,
            self::megabytes => FileSizeConstants::MEGABYTES,
            self::gigabytes => FileSizeConstants::GIGABYTES,
            default => FileSizeConstants::KILOBYTES,
        };
    }

}
