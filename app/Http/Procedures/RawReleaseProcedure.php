<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Enums\PermissionEnum;
use App\Repositories\RawReleaseRepository;
use App\Traits\ProcedurePermissionControl;
use Sajya\Server\Procedure;

class RawReleaseProcedure extends Procedure
{
    use ProcedurePermissionControl;

    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'raw-release';

    protected static array $permissions = [
        'list' => PermissionEnum::RawReleaseList,
    ];

    protected RawReleaseRepository $rawReleaseRepository;

    public function __construct(RawReleaseRepository $rawReleasesRepository)
    {
        $this->rawReleaseRepository = $rawReleasesRepository;
    }

    public function list(): array
    {
        return $this->rawReleaseRepository->getNewReleases();
    }
}
