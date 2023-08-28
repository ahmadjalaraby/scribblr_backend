<?php

namespace App\ValueObjects;


use App\Enums\Image\SizeFormat;

final class FileSize
{
    /** @var float $bytes */
    public readonly float $bytes;

    public function __construct(float $bytes)
    {
        $this->bytes = $bytes;
    }

    /**
     * This function will return an instance from class FileSize
     * @param float $bytes
     * @return self
     */
    public static function from(float $bytes): self
    {
        return new self($bytes);
    }

    /**
     * This function needs to pass the format of the size you want, and then will return it in float|int.
     * @param SizeFormat $format
     * @return float|int
     */
    public function toFormat(SizeFormat $format): float|int
    {
        return $this->bytes / SizeFormat::getValue($format);
    }
}
