<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Models\Enums\PermissionEnum;
use App\Repositories\RawReleaseRepository;
use App\Traits\ProcedurePermissionControl;
use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class UnapprovedArtistProcedure extends Procedure
{
    use ProcedurePermissionControl;

    public static string $name = 'unapproved-artist';

    protected static array $permissions = [
        'list' => PermissionEnum::UnapprovedArtistsList,
    ];

    protected RawReleaseRepository $rawReleaseRepository;

    public function __construct(RawReleaseRepository $rawReleasesRepository)
    {
        $this->rawReleaseRepository = $rawReleasesRepository;
    }

    public function list(): array
    {
        return $this->rawReleaseRepository->getUnapprovedArtists();
    }
}
