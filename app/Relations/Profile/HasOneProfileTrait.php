<?php

declare(strict_types=1);

namespace App\Relations\Profile;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin HasRelationships
 * @property Profile $profile
 *
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
trait HasOneProfileTrait
{
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
}