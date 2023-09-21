<?php

namespace App\Models;

use App\DataTransferObjects\ProfileData;
use App\Traits\HasSerializeDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\WithData;

class UserProfile extends Model
{
    use HasFactory;
    use withData;
    use HasSerializeDate;

    protected string $dataClass = ProfileData::class;


    protected $fillable = [
        'id',
        'user_id',
        'description',
        'whatsapp',
        'facebook',
        'twitter',
        'instagram',
        'website',
        'location',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
