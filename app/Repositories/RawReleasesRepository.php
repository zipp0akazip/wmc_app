<?php

namespace App\Repositories;

use App\Models\Enums\RawReleasesStatusEnum;
use App\Models\RawReleasesModel;
use AwesIO\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class RawReleasesRepository extends BaseRepository
{
    /**
     * The attributes that can be searched by.
     *
     * @var array
     */
    protected $searchable = [];

    public function entity()
    {
        return RawReleasesModel::class;
    }

    public function getNewReleases(): array
    {
        $result = [];
        $releases = $this->entity()::where('status', RawReleasesStatusEnum::NEW)->get();

        foreach ($releases as $release) {
            $result[] = $release->data->toArray();
        }

        return $result;
    }

    public function getUnapprovedStyles(): array
    {
        $result = [];
        $releases = $this->entity()::where('status', RawReleasesStatusEnum::NEW)->get();

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
