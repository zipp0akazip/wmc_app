<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\LabelAddAliasRequest;
use App\Http\Requests\LabelCreateRequest;
use App\Models\Enums\PermissionEnum;
use App\Models\LabelModel;
use App\Repositories\LabelRepository;
use App\Traits\ProcedurePermissionControl;
use Illuminate\Database\Eloquent\Collection;
use Sajya\Server\Procedure;

class LabelProcedure extends Procedure
{
    use ProcedurePermissionControl;

    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'label';

    protected static array $permissions = [
        'list' => PermissionEnum::LabelsList,
        'create' => PermissionEnum::LabelsCreate,
        'addAlias' => PermissionEnum::LabelsAddAlias,
    ];

    protected LabelRepository $labelRepository;

    public function __construct(LabelRepository $labelsRepository)
    {
        $this->labelRepository = $labelsRepository;
    }

    public function list(): Collection
    {
        return $this->labelRepository->getList();
    }

    public function create(LabelCreateRequest $request): LabelModel
    {
        return $this->labelRepository->create($request->toArray());
    }

    public function addAlias(LabelAddAliasRequest $request): LabelModel
    {
        return $this->labelRepository->addAlias($request);
    }
}
