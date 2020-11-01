<?php

namespace App\Models;

use App\Casts\PgArray;
use App\Models\Generated;
use Illuminate\Support\Collection;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property Collection $aliases
 */
class StyleModel extends Generated\StyleBaseModel
{
    use NodeTrait;

    protected $casts = [
        'aliases' => PgArray::class
    ];

    protected $hidden = ['_lft', '_rgt', 'parent_id', 'created_at', 'updated_at', 'depth'];
}
