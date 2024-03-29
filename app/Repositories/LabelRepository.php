<?php

namespace App\Repositories;

use App\Helpers\Alias;
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

    public function createNew(string $name): LabelModel
    {
        $label = new $this->entity();
        $label->name = $name;
        $label->aliases = Alias::make($name);
        $label->save();

        return $label;
    }

    public function addAlias(int $labelId, string $alias): LabelModel
    {
        $label = $this->entity()::find($labelId);
        $label->aliases->add(Alias::make($alias));
        $label->save();

        return $label;
    }
}
