<?php

namespace App\Models;

use App\Models\Generated;

class RawReleasesModel extends Generated\RawReleasesBaseModel
{
    public function getDataAttribute($value)
    {
        return unserialize(base64_decode($value));
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = base64_encode(serialize($value));
    }
}

