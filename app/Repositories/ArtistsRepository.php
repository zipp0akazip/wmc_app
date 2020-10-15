<?php

namespace App\Repositories;

use App\Helpers\Alias;
use App\Models\ArtistsModel;
use AwesIO\Repository\Eloquent\BaseRepository;

class ArtistsRepository extends BaseRepository
{
    /**
     * The attributes that can be searched by.
     *
     * @var array
     */
    protected $searchable = [];

    public function entity()
    {
        return ArtistsModel::class;
    }

    public function isExists(string $name): bool
    {
        return $this->entity()::where('name', $name)
            ->orWhereRaw('\'' . Alias::make($name) . '\'' . ' = ANY(aliases)')
            ->exists();
    }
}
