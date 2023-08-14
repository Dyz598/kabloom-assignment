<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @mixin Model
 *
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
trait HasUuidTrait
{
    public static function bootHasUuidTrait(): void
    {
        static::creating(function (Model $model) {
            $key = $model->getKeyName();

            $model->mergeCasts([$key => 'string']);

            if (!empty($model->getAttribute($key))) {
                return;
            }

            $model->setAttribute($key, Str::uuid()->toString());
        });
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    public function getIncrementing(): bool
    {
        return false;
    }
}