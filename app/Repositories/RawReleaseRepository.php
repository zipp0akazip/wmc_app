<?php

namespace App\Repositories;

use App\Models\Enums\RawReleaseStatusEnum;
use App\Models\RawReleaseModel;
use AwesIO\Repository\Eloquent\BaseRepository;

class RawReleaseRepository extends BaseRepository
{
    /**
     * The attributes that can be searched by.
     *
     * @var array
     */
    protected $searchable = [];

    public function entity()
    {
        return RawReleaseModel::class;
    }

    public function getNewReleases(): array
    {
        $result = [];
        $releases = $this->entity()::where('status', RawReleaseStatusEnum::NEW)->get();

        foreach ($releases as $release) {
            $result[] = $release->data->toArray();
        }

        return $result;
    }

    public function getUnapprovedStyles(): array
    {
        $result = [];
        $releases = $this->entity()::where('status', RawReleaseStatusEnum::NEW)->get();

        foreach ($releases as $release) {
            foreach ($release->data->getCover()->getStylesCollection()->getStyles() as $style) {
                if (!$style->isExists() && !isset($result[$style->getName()])) {
                    $result[$style->getName()] = [
                        'name' => $style->getName(),
                        'release' => $release->data->toArray(),
                    ];
                }
            }
        }

        return array_values($result);
    }

    public function getUnapprovedLabels(): array
    {
        $result = [];
        $labelRepository = resolve(LabelRepository::class);
        $releases = $this->entity()::where('status', RawReleaseStatusEnum::NEW)->get();

        foreach ($releases as $release) {
            $labelName = $release->data->getCover()->getLabel();

            if ($labelName !== null && !$labelRepository->isExists($labelName) && !isset($result[$labelName])) {
                $result[$labelName] = [
                    'name' => $labelName,
                    'release' => $release->data->toArray(),
                ];
            }

        }

        return array_values($result);
    }

    public function getUnapprovedArtists(): array
    {
        $result = [];
        $artistsRepository = resolve(ArtistRepository::class);
        $releases = $this->entity()::where('status', RawReleaseStatusEnum::NEW)->get();

        foreach ($releases as $release) {
            foreach ($release->data->getCover()->getArtistsCollection()->getArtists() as $artist) {
                $artist = $artist->getName();

                if (!$artistsRepository->isExists($artist) && !isset($result[$artist])) {
                    $result[$artist] = [
                        'name' => $artist,
                        'release' => $release->data->toArray(),
                    ];
                }
            }

            foreach ($release->data->getTracksCollection()->getTracks() as $track) {
                foreach ($track->getArtistsCollection()->getArtists() as $artist) {
                    $artist = $artist->getName();

                    if (!$artistsRepository->isExists($artist) && !isset($result[$artist])) {
                        $result[$artist] = [
                            'name' => $artist,
                            'release' => $release->data->toArray(),
                        ];
                    }
                }
            }
        }

        return array_values($result);
    }
}
