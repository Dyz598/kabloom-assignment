<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasUuidTrait;
use App\Relations\Profile\BelongsToProfileTrait;
use Carbon\Carbon;

/**
 * @property string $title
 * @property string $content
 * @property bool   $public
 * @property Carbon $createdAt
 *
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class Post extends AbstractModel
{
    use HasUuidTrait;

    use BelongsToProfileTrait;

    protected $fillable = [
        'title',
        'content',
        'public',
    ];
}