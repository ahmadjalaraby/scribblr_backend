<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSearchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'search_word',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
