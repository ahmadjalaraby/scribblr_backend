<?php

namespace App\Models;

use App\DataTransferObjects\CountryData;
use App\Traits\HasSerializeDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\LaravelData\WithData;

class Country extends Model
{
    use HasFactory;
    use withData;
    use HasSerializeDate;

    protected string $dataClass = CountryData::class;

    protected $fillable = [
        'id',
        'name',
        'code',
        'start',
        'active'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
