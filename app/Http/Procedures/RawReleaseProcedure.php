<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\RawRelease\ListRequest;
use App\Repositories\RawReleaseRepository;
use Sajya\Server\Procedure;

class RawReleaseProcedure extends Procedure
{
    public static string $name = 'raw-release';

    protected RawReleaseRepository $rawReleaseRepository;

    public function __construct(RawReleaseRepository $rawReleasesRepository)
    {
        $this->rawReleaseRepository = $rawReleasesRepository;
    }

    public function list(ListRequest $request): array
    {
        return $this->rawReleaseRepository->getNewReleases();
    }
}
