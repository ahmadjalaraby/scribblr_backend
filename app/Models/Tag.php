<?php

namespace App\Models;

use App\Builders\TagBuilder;
use App\DataTransferObjects\TagData;
use App\Traits\HasImage;
use App\Traits\HasSerializeDate;
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
    use HasSerializeDate;

    protected string $dataClass = TagData::class;


    protected $fillable = [
        'id',
        'title',
        'active'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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
