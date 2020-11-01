<?php

namespace App\Models;

use App\Casts\PgArray;
use App\Models\Generated\LabelBaseModel;

class LabelModel extends LabelBaseModel
{
    protected $casts = [
        'aliases' => PgArray::class
    ];
}
