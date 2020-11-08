<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\Label\ListRequest;
use App\Http\Requests\Label\AddAliasRequest;
use App\Http\Requests\Label\CreateRequest;
use App\Models\LabelModel;
use App\Repositories\LabelRepository;
use Illuminate\Database\Eloquent\Collection;
use Sajya\Server\Procedure;

class LabelProcedure extends Procedure
{
    public static string $name = 'label';

    protected LabelRepository $labelRepository;

    public function __construct(LabelRepository $labelsRepository)
    {
        $this->labelRepository = $labelsRepository;
    }

    public function list(ListRequest $request): Collection
    {
        return $this->labelRepository->getList();
    }

    public function create(CreateRequest $request): LabelModel
    {
        return $this->labelRepository->create($request->toArray());
    }

    public function addAlias(AddAliasRequest $request): LabelModel
    {
        return $this->labelRepository->addAlias($request);
    }
}
