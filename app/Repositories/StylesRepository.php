<?php

namespace App\Repositories;

use App\Helpers\Alias;
use AwesIO\Repository\Eloquent\BaseRepository;
use App\Models\StylesModel;
use Illuminate\Database\Eloquent\Collection;

class StylesRepository extends BaseRepository
{
    /**
     * The attributes that can be searched by.
     *
     * @var array
     */
    protected $searchable = [];

    public function entity()
    {
        return StylesModel::class;
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

    public function create(array $request): StylesModel
    {
        $style = new $this->entity();
        $style->name = $request['name'];
        $style->alias = Alias::make($request['name']);
        $style->save();

        return $style;
    }
}
