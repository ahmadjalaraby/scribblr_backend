<?php

namespace App\Models;

use App\Builders\ArticleBuilder;
use App\Constants\DateTime\DateTimeFormat;
use App\DataTransferObjects\ArticleData;
use App\Enums\Article\ArticleStatus;
use App\Traits\HasImage;
use App\Traits\HasSerializeDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\LaravelData\WithData;

class Article extends Model
{
    use HasFactory;
    use HasImage;
    use SoftDeletes;
    use WithData;
    use HasSerializeDate;

    protected string $dataClass = ArticleData::class;

    protected $fillable = [
        'id',
        'user_id',
        'tag_id',
        'title',
        'content',
        'status',
        'allow_comments',
        'publish_time',
    ];

    protected $casts = [
        'status' => ArticleStatus::class,
        'publish_at' => 'datetime:' . DateTimeFormat::PUBLISH_AT,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function newEloquentBuilder($query): ArticleBuilder
    {
        return new ArticleBuilder($query);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(ArticleVisit::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
