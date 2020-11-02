<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\ArtistAddAliasRequest;
use App\Http\Requests\ArtistCreateRequest;
use App\Models\ArtistModel;
use App\Models\Enums\PermissionEnum;
use App\Repositories\ArtistRepository;
use App\Traits\ProcedurePermissionControl;
use Sajya\Server\Procedure;
use Illuminate\Database\Eloquent\Collection;

class ArtistProcedure extends Procedure
{
    use ProcedurePermissionControl;

    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'artist';

    protected static array $permissions = [
        'list' => PermissionEnum::ArtistList,
        'create' => PermissionEnum::ArtistCreate,
        'addAlias' => PermissionEnum::ArtisAddAlias,
    ];

    protected ArtistRepository $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    public function list(): Collection
    {
        return $this->artistRepository->getList();
    }

    public function create(ArtistCreateRequest $request): ArtistModel
    {
        return $this->artistRepository->create($request->toArray());
    }

    public function addAlias(ArtistAddAliasRequest $request): ArtistModel
    {
        return $this->artistRepository->addAlias($request);
    }
}
