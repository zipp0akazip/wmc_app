<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Enums\RawReleasesStatusEnum;
use App\Models\RawReleases;
use Illuminate\Http\Request;
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

    public function list()
    {
        $releases = RawReleases::where('status', RawReleasesStatusEnum::NEW)->get();

        foreach ($releases as $release) {
            var_dump(unserialize(base64_decode($release->data)));exit;
        }
    }
}
