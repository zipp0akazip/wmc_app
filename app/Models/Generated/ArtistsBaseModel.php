<?php

namespace App\Models\Generated;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistsBaseModel extends Model
{
    use HasFactory;

    protected $table = 'artists';

    protected $fillable = [
        'name', 'alias'
    ];
}
