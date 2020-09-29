<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Enums\PermissionEnum;
use App\Repositories\RawReleasesRepository;
use App\Traits\ProcedurePermissionControl;
use Sajya\Server\Procedure;

class UnapprovedStylesProcedure extends Procedure
{
    use ProcedurePermissionControl;

    public static string $name = 'unapproved-styles';

    protected static array $permissions = [
        'list' => PermissionEnum::UnapprovedStylesList,
    ];

    protected RawReleasesRepository $rawReleasesRepository;

    public function __construct(RawReleasesRepository $rawReleasesRepository)
    {
        $this->rawReleasesRepository = $rawReleasesRepository;
    }

    public function list(): array
    {
        return $this->rawReleasesRepository->getUnapprovedStyles();
    }
}
