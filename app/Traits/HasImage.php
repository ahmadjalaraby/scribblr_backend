<?php

namespace App\Traits;


use App\Models\Gallery;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;

trait HasImage
{
    /**
     * Get the gallery for the loadable model.
     *
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Gallery::class, 'loadable');
    }

    /**
     * Get the URL of the image for the loadable model.
     *
     * @return null|string
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image->path) : null;
    }

    /**
     * Get the directory where images should be stored for the loadable model.
     * This method should be implemented in the model using the trait.
     *
     * @return string
     */
    public function getImageDirectory(): string
    {
        return strtolower(class_basename($this)) . 's';
    }
}
