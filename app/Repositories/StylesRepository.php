<?php

namespace App\Repositories;

use App\Http\Requests\StyleCreateRequest;
use App\Models\StylesModel;

class StylesRepository
{
    public function isExists(string $name): bool
    {
       return StylesModel::where('name', $name)
           ->orWhere('alias', $this->nameToAlias($name))
           ->exists();
    }

    public function nameToAlias(string $name): string
    {
        return strtolower($name);
    }

    public function getList(): array
    {
        return StylesModel::all()->toArray();
    }

    public function create(StyleCreateRequest $request): array
    {
        $style = new StylesModel([
            'name' => $request->get('name'),
            'alias' => $this->nameToAlias($request->get('name')),
        ]);

        $style->save();

        return $style->toArray();
    }
}
