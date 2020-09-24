<?php

namespace App\Models\Generated;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelsBaseModel extends Model
{
    use HasFactory;

    protected $table = 'labels';

    protected $fillable = [
        'name', 'alias'
    ];
}
