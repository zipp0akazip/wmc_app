<?php

namespace App\Repositories;

use App\Models\LabelsModel;
use AwesIO\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class LabelsRepository extends BaseRepository
{
    /**
     * The attributes that can be searched by.
     *
     * @var array
     */
    protected $searchable = [];

    public function entity()
    {
        return LabelsModel::class;
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

    public function getList(): Collection
    {
        return $this->entity()::all();
    }

    public function create(array $request): LabelsModel
    {
        $style = new $this->entity();
        $style->name = $request['name'];
        $style->alias = $this->nameToAlias($request['name']);
        $style->save();

        return $style;
    }
}
