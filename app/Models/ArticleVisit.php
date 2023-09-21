<?php

namespace App\Models;

use App\DataTransferObjects\ArticleData;
use App\DataTransferObjects\ArticleVisitData;
use App\Traits\HasSerializeDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\WithData;

class ArticleVisit extends Model
{
    use HasFactory;
    use HasSerializeDate;
    use WithData;

    protected string $dataClass = ArticleVisitData::class;


    protected $fillable = [
        'id',
        'user_id',
        'article_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
