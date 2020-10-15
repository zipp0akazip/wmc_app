<?php

namespace App\Models;

use App\Casts\PgArray;
use App\Models\Generated\LabelsBaseModel;

class LabelsModel extends LabelsBaseModel
{
    protected $casts = [
        'aliases' => PgArray::class
    ];
}
