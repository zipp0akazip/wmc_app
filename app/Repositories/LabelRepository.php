<?php

namespace App\Repositories;

use App\Helpers\Alias;
use App\Http\Requests\LabelAddAliasRequest;
use App\Models\LabelModel;
use AwesIO\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class LabelRepository extends BaseRepository
{
    /**
     * The attributes that can be searched by.
     *
     * @var array
     */
    protected $searchable = [];

    public function entity()
    {
        return LabelModel::class;
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

    public function create(array $request): LabelModel
    {
        $label = new $this->entity();
        $label->name = $request['name'];
        $label->aliases = Alias::make($request['name']);
        $label->save();

        return $label;
    }

    public function addAlias(LabelAddAliasRequest $request): LabelModel
    {
        $label = $this->entity()::find($request->get('label_id'));
        $label->aliases->add(Alias::make($request->get('alias')));
        $label->save();

        return $label;
    }
}
