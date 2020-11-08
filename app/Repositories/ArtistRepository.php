<?php

namespace App\Repositories;

use App\Helpers\Alias;
use App\Http\Requests\Artist\AddAliasRequest;
use App\Models\ArtistModel;
use AwesIO\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

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

    public function getList(): Collection
    {
        return $this->entity()::all();
    }

    public function create(array $request): ArtistModel
    {
        $label = new $this->entity();
        $label->name = $request['name'];
        $label->aliases = Alias::make($request['name']);
        $label->save();

        return $label;
    }

    public function addAlias(AddAliasRequest $request): ArtistModel
    {
        $label = $this->entity()::find($request->get('artist_id'));
        $label->aliases->add(Alias::make($request->get('alias')));
        $label->save();

        return $label;
    }
}
