<?php

namespace App\Models;

use App\DataTransferObjects\GalleryData;
use App\Enums\Gallery\GalleryLoadableType;
use App\Traits\HasSerializeDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\LaravelData\WithData;

class Gallery extends Model
{
    use HasFactory;
    use withData;
    use HasSerializeDate;


    protected string $dataClass = GalleryData::class;

    protected $fillable = [
        'id',
        'title',
        'path',
        'mime',
        'size',
        'width',
        'height',
        'aspect_ratio',
    ];

    protected $casts = [
        'loadable_type' => GalleryLoadableType::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function loadable(): MorphTo
    {
        return $this->morphTo();
    }
}
