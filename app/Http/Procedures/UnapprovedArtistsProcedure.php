<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Enums\PermissionEnum;
use App\Repositories\RawReleasesRepository;
use App\Traits\ProcedurePermissionControl;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class UnapprovedArtistsProcedure extends Procedure
{
    use ProcedurePermissionControl;

    public static string $name = 'unapproved-artists';

    protected static array $permissions = [
        'list' => PermissionEnum::UnapprovedArtistsList,
    ];

    protected RawReleasesRepository $rawReleasesRepository;

    public function __construct(RawReleasesRepository $rawReleasesRepository)
    {
        $this->rawReleasesRepository = $rawReleasesRepository;
    }

    public function list(): array
    {
        return [123];
    }
}
