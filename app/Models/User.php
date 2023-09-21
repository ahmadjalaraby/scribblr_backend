<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\DataTransferObjects\UserData;
use App\Enums\User\UserGender;
use App\Traits\HasImage;
use App\Traits\HasSerializeDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\LaravelData\WithData;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasImage;
    use WithData;
    use HasSerializeDate;

    protected string $dataClass = UserData::class;


    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'phone_number',
        'gender',
        'country_id',
        'date_of_birth',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'gender' => UserGender::class,
//        'created_at' => 'datetime',
//        'updated_at' => 'datetime',
    ];


    protected $attributes = [
        'gender' => UserGender::other,
    ];


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'followed_id');
    }

    public function followedUsers(): HasMany
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class)->withDefault();
    }

    public function searchHistory(): HasMany
    {
        return $this->hasMany(UserSearchHistory::class);
    }

    public function notificationSetting(): HasOne
    {
        return $this->hasOne(UserNotificationSetting::class);
    }

    public function articleVisits(): HasMany
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

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

//    public function dateOfBirth(): Attribute
//    {
//        return new Attribute(
//            set: function ($value) {
//                return $value;
//            },
//        );
//    }
}
