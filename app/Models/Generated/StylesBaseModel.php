<?php

namespace App\Models\Generated;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StylesBaseModel extends Model
{
    use HasFactory;

    protected $table = 'styles';

    protected $fillable = [
        'name', 'alias',
    ];
}
