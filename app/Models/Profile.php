<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasUuidTrait;
use App\Relations\User\BelongsToUserTrait;

/**
 * @property string $contentGenre
 * @property string $about
 * @property int    $subscriptionPrice
 *
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class Profile extends AbstractModel
{
    use HasUuidTrait;

    use BelongsToUserTrait;

    protected $fillable = [
        'content_genre',
        'about',
        'subscription_price',
    ];
}