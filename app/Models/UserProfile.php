<?php

namespace App\Models;

use App\DataTransferObjects\ProfileData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\WithData;

class UserProfile extends Model
{
    use HasFactory;
    use withData;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
