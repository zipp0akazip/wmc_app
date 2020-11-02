<?php

namespace App\Models;

use App\Casts\PgArray;
use App\Models\Generated\ArtistBaseModel;

class ArtistModel extends ArtistBaseModel
{
    protected $casts = [
        'aliases' => PgArray::class
    ];
}
