<?php

namespace App\ValueObjects;


final class ImageDimension
{
    /** @var float $width The width of the image */
    public readonly float $width;
    /** @var float $height The height of the image */
    public readonly float $height;
    /** @var float $aspectRatio The aspect ratio of the image */
    public readonly float $aspectRatio;

    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;

//        calculate the aspect ratio
        $this->aspectRatio = $this->width / $this->height;
    }

    /**
     * A static function that takes width and height, to convert them to ImageDimension object
     * @param float $width The width of the image
     * @param float $height The height of the image
     * @return self
     */
    public static function from(float $width, float $height): self
    {
        return new self($width, $height);
    }

}
