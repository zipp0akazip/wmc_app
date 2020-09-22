<?php

namespace App\Models\Generated;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawReleasesBaseModel extends Model
{
    use HasFactory;

    protected $table = 'raw_releases';

    protected $fillable = [
        'data', 'status', 'message',
    ];
}
