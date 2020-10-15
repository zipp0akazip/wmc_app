<?php

namespace App\Repositories;

use App\Helpers\Alias;
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
            ->orWhereRaw('\'' . Alias::make($name) . '\'' . ' = ANY(aliases)')
            ->exists();
    }

    public function getList(): Collection
    {
        return $this->entity()::all();
    }

    public function create(array $request): LabelsModel
    {
        $style = new $this->entity();
        $style->name = $request['name'];
        $style->aliases = Alias::make($request['name']);
        $style->save();

        return $style;
    }
}
