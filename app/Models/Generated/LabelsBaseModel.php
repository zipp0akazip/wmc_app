<?php

namespace App\Models\Generated;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $aliases
 * @property string $created_at
 * @property string $updated_at
 * @property Track[] $tracks
 */
class LabelsBaseModel extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'labels';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name', 'aliases', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tracks()
    {
        return $this->belongsToMany('App\Models\Generated\Track', 'track_has_labels');
    }
}
