<?php

namespace App\Models;

use App\Casts\PgArray;
use App\Models\Generated;
use Illuminate\Support\Collection;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property Collection $aliases
 */
class StylesModel extends Generated\StylesBaseModel
{
    use NodeTrait;

    protected $casts = [
        'aliases' => PgArray::class
    ];
}
