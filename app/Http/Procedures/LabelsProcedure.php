<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\LabelCreateRequest;
use App\Http\Requests\StyleCreateRequest;
use App\Models\Enums\PermissionEnum;
use App\Models\LabelsModel;
use App\Models\StylesModel;
use App\Repositories\LabelsRepository;
use App\Traits\ProcedurePermissionControl;
use Illuminate\Database\Eloquent\Collection;
use Sajya\Server\Procedure;

class LabelsProcedure extends Procedure
{
    use ProcedurePermissionControl;

    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'labels';

    protected static array $permissions = [
        'list' => PermissionEnum::LabelsList,
        'create' => PermissionEnum::LabelsCreate,
    ];

    protected LabelsRepository $labelsRepository;

    public function __construct(LabelsRepository $labelsRepository)
    {
        $this->labelsRepository = $labelsRepository;
    }

    public function list(): Collection
    {
        return $this->labelsRepository->getList();
    }

    public function create(LabelCreateRequest $request): LabelsModel
    {
        return $this->labelsRepository->create($request->toArray());
    }
}

