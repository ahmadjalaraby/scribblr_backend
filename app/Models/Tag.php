<?php

namespace App\Models;

use App\Builders\TagBuilder;
use App\DataTransferObjects\TagData;
use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\LaravelData\WithData;

class Tag extends Model
{
    use HasFactory;
    use withData;
    use HasImage;

    protected $fillable = [
        'id',
        'title',
        'active'
    ];

    protected string $dataClass = TagData::class;

    public function newEloquentBuilder($query): TagBuilder
    {
        return new TagBuilder($query);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
