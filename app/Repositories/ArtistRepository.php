<?php

namespace App\Repositories;

use App\Helpers\Alias;
use App\Models\ArtistModel;
use AwesIO\Repository\Eloquent\BaseRepository;

class ArtistRepository extends BaseRepository
{
    /**
     * The attributes that can be searched by.
     *
     * @var array
     */
    protected $searchable = [];

    public function entity()
    {
        return ArtistModel::class;
    }

    public function isExists(string $name): bool
    {
        return $this->entity()::where('name', $name)
            ->orWhereRaw('\'' . Alias::make($name) . '\'' . ' = ANY(aliases)')
            ->exists();
    }
}
