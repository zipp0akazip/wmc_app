<?php

namespace App\Repositories;

use App\Helpers\Alias;
use AwesIO\Repository\Eloquent\BaseRepository;
use App\Models\StyleModel;
use Illuminate\Database\Eloquent\Collection;

class StyleRepository extends BaseRepository
{
    /**
     * The attributes that can be searched by.
     *
     * @var array
     */
    protected $searchable = [];

    public function entity()
    {
        return StyleModel::class;
    }

    public function isExists(string $name): bool
    {
        return $this->entity()::where('name', $name)
            ->orWhereRaw('\'' . Alias::make($name) . '\'' . ' = ANY(aliases)')
            ->exists();
    }

    public function getList(): Collection
    {
        return $this->entity()::all()->toTree();
    }

    public function appendNew(int $parentId, string $name): StyleModel
    {
        $parent = $this->entity()::find($parentId);

        $node = new $this->entity();
        $node->name = $name;
        $node->aliases = Alias::make($name);
        $node->appendToNode($parent)->save();

        return $node;
    }

    public function addAlias(int $styleId, string $alias): StyleModel
    {
        $style = $this->entity()::find($styleId);
        $style->aliases->add(Alias::make($alias));
        $style->save();

        return $style;
    }
}

