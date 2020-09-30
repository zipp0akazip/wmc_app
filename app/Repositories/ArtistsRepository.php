<?php

namespace App\Repositories;

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
            ->orWhere('alias', $this->nameToAlias($name))
            ->exists();
    }

    public function nameToAlias(string $name): string
    {
        return strtolower($name);
    }
}
