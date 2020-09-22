<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Enums\RawReleasesStatusEnum;
use App\Models\RawReleasesModel;
use Sajya\Server\Procedure;

class RawReleasesProcedure extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'raw-releases';

    public function list(): array
    {
        $result = [];
        $releases = RawReleasesModel::where('status', RawReleasesStatusEnum::NEW)->get();

        foreach ($releases as $release) {
            $result[] = $release->data->toArray();
        }

        return $result;
    }
}
