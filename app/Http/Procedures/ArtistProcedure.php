<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\Artist\AddAliasRequest;
use App\Http\Requests\Artist\CreateRequest;
use App\Http\Requests\Artist\ListRequest;
use App\Models\ArtistModel;
use App\Repositories\ArtistRepository;
use Sajya\Server\Procedure;
use Illuminate\Database\Eloquent\Collection;

class ArtistProcedure extends Procedure
{
    public static string $name = 'artist';

    protected ArtistRepository $artistRepository;

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    public function list(ListRequest $request): Collection
    {
        return $this->artistRepository->getList();
    }

    public function create(CreateRequest $request): ArtistModel
    {
        return $this->artistRepository->create($request->toArray());
    }

    public function addAlias(AddAliasRequest $request): ArtistModel
    {
        return $this->artistRepository->addAlias($request);
    }
}
