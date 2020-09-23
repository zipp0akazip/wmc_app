<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\StyleCreateRequest;
use App\Models\Enums\PermissionEnum;
use App\Models\StylesModel;
use App\Repositories\StylesRepository;
use App\Traits\ProcedurePermissionControl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Guide;
use Sajya\Server\Procedure;

class StylesProcedure extends Procedure
{
    use ProcedurePermissionControl;

    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'styles';

    protected static array $permissions = [
        'list' => PermissionEnum::StylesList,
        'create' => PermissionEnum::StylesCreate,
    ];

    protected StylesRepository $stylesRepository;

    public function __construct(StylesRepository $stylesRepository)
    {
        $this->stylesRepository = $stylesRepository;
    }

    public function list(): array
    {
        return $this->stylesRepository->getList();
    }

    public function create(StyleCreateRequest $request): array
    {
        return $this->stylesRepository->create($request);
    }
}
