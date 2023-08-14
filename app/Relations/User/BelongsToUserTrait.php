<?php

declare(strict_types=1);

namespace App\Relations\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin HasRelationships
 * @property User   $user
 * @property string $userId
 *
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
trait BelongsToUserTrait
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}