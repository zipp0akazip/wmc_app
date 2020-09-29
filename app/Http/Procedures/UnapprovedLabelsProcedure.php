<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Enums\PermissionEnum;
use App\Repositories\RawReleasesRepository;
use App\Traits\ProcedurePermissionControl;
use Sajya\Server\Procedure;

class UnapprovedLabelsProcedure extends Procedure
{
    use ProcedurePermissionControl;

    public static string $name = 'unapproved-labels';

    protected static array $permissions = [
        'list' => PermissionEnum::UnapprovedLabelsList,
    ];

    protected RawReleasesRepository $rawReleasesRepository;

    public function __construct(RawReleasesRepository $rawReleasesRepository)
    {
        $this->rawReleasesRepository = $rawReleasesRepository;
    }

    public function list(): array
    {
        return $this->rawReleasesRepository->getUnapprovedLabels();
    }
}
