<?php
//
//namespace App\Traits;
//
//use App\Models\Gallery;
//use App\ValueObjects\ImageDimension;
//use Illuminate\Http\UploadedFile;
//use Illuminate\Support\Facades\Storage;
//
//trait Loadable
//{
//    /**
//     * Get the gallery for the loadable model.
//     */
//    public function gallery()
//    {
//        return $this->morphOne(Gallery::class, 'loadable');
//    }
//
//    /**
//     * Get the URL of the image for the loadable model.
//     */
//    public function getImageUrlAttribute(): ?string
//    {
//        return $this->gallery ? Storage::url($this->gallery->path) : null;
//    }
//
//    /**
//     * Upload an image for the loadable model.
//     */
//    public function uploadImage(UploadedFile $image): void
//    {
//        // Delete any existing gallery and image for the model
//        if ($this->gallery) {
//            Storage::delete($this->gallery->path);
//            $this->gallery->delete();
//        }
//
//        // Store the image in the appropriate directory
//        $path = Storage::putFile($this->getImageDirectory(), $image);
//
//        // Get the image size of the photo
//        $imageSize = getimagesize($path);
//
//        // Get the image aspect ratio using the ImageDimension value object
//        $imageDimension = ImageDimension::from($imageSize[0], $imageSize[1]);
//
//        // Create a new gallery record for the model with image metadata
//        $gallery = new Gallery([
//            'path' => $path,
//            'mime' => $image->getClientMimeType(),
//            'size' => $image->getSize(),
//            'width' => $imageDimension->width,
//            'height' => $imageDimension->height,
//            'aspect_ratio' => $imageDimension->aspectRatio,
//        ]);
//
//        $this->gallery()->save($gallery);
//    }
//
//    /**
//     * Get the directory where images should be stored for the loadable model.
//     * This method should be implemented in the model using the trait.
//     */
//    abstract public function getImageDirectory(): string;
//}
