<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotificationSetting extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'new_recommendation',
        'new_follow',
        'new_comment',
        'new_mention',
        'new_comment_like',
        'new_article',
        'app_system',
        'guidance_and_tips',
        'surveys',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
