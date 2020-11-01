<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Enums\PermissionEnum;
use App\Repositories\RawReleaseRepository;
use App\Traits\ProcedurePermissionControl;
use Sajya\Server\Procedure;

class UnapprovedStyleProcedure extends Procedure
{
    use ProcedurePermissionControl;

    public static string $name = 'unapproved-style';

    protected static array $permissions = [
        'list' => PermissionEnum::UnapprovedStylesList,
    ];

    protected RawReleaseRepository $rawReleaseRepository;

    public function __construct(RawReleaseRepository $rawReleasesRepository)
    {
        $this->rawReleaseRepository = $rawReleasesRepository;
    }

    public function list(): array
    {
        return $this->rawReleaseRepository->getUnapprovedStyles();
    }
}
