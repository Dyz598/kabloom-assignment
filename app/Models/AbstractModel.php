<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
abstract class AbstractModel extends Model
{
    public function setAttribute($key, $value): ?static
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    public function getAttribute($key): mixed
    {
        return parent::getAttribute(Str::snake($key));
    }

    public function getRelationshipFromMethod($key): mixed
    {
        return parent::getRelationshipFromMethod(Str::camel($key));
    }

    public function isRelation($key): bool
    {
        if ($this->hasAttributeMutator($key)) {
            return false;
        }

        $key = Str::camel($key);

        return method_exists($this, $key) ||
            (static::$relationResolvers[get_class($this)][$key] ?? null);
    }
}