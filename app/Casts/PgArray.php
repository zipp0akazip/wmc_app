<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;

class PgArray implements CastsAttributes
{

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $value = mb_substr($value, 1);
        $value = mb_substr($value, 0, mb_strlen($value) - 1);
        $value = explode(',', $value);

        if (empty($value) || $value[0] === '') {
            $value = [];
        }

        return collect($value);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Collection) {
            $value = collect(array($value));
        }

        return '{' . $value->implode(',') . '}';
    }
}
