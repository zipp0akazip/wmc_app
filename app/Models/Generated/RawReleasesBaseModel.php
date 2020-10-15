<?php

namespace App\Models\Generated;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $data
 * @property string $status
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 */
class RawReleasesBaseModel extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'raw_releases';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['data', 'status', 'message', 'created_at', 'updated_at'];

}
