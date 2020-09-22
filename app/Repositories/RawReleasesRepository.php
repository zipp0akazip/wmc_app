<?php

namespace App\Repositories;

use App\Models\Enums\RawReleasesStatusEnum;
use App\Models\RawReleasesModel;

class RawReleasesRepository
{
    public function getUnapprovedStyles(): array
    {
        $result = [];
        $releases = RawReleasesModel::where('status', RawReleasesStatusEnum::NEW)->get();

        foreach ($releases as $release) {
            foreach ($release->data->getCover()->getStylesCollection()->getStyles() as $style) {
                if (!$style->isExists()) {
                    $result[] = $style->getName();
                }
            }
        }

        return array_values(array_unique($result));
    }
}
