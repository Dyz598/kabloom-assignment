<?php

namespace App\Models;

use App\Models\Traits\HasUuidTrait;
use App\Relations\Profile\HasOneProfileTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string     $name
 * @property string     $email
 * @property Collection $profileFollows
 * @property string     $googleId
 */
class User extends AbstractModel implements AuthenticatableContract
{
    use HasUuidTrait,
        Authenticatable;

    use HasOneProfileTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function profileFollows(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class,
            'profile_followers',
            'user_id',
            'profile_id'
        )
            ->withPivot(['followed', 'subscription_paid', 'payment_id'])
            ->withTimestamps();
    }
}
