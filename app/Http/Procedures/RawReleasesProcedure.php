<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Enums\PermissionEnum;
use App\Repositories\RawReleasesRepository;
use App\Traits\ProcedurePermissionControl;
use Sajya\Server\Procedure;

class RawReleasesProcedure extends Procedure
{
    use ProcedurePermissionControl;

    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'raw-releases';

    protected static array $permissions = [
        'list' => PermissionEnum::RawReleaseList,
    ];

    protected RawReleasesRepository $rawReleasesRepository;

    public function __construct(RawReleasesRepository $rawReleasesRepository)
    {
        $this->rawReleasesRepository = $rawReleasesRepository;
    }

    public function list(): array
    {
        return $this->rawReleasesRepository->getNewReleases();
    }
}
