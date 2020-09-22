<?php

namespace App\Repositories;

use App\Models\StylesModel;

class StyleRepository
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
}
