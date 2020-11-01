<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\StyleCreateRequest;
use App\Models\Enums\PermissionEnum;
use App\Models\StyleModel;
use App\Repositories\StyleRepository;
use App\Traits\ProcedurePermissionControl;
use Illuminate\Database\Eloquent\Collection;
use Sajya\Server\Procedure;

class StyleProcedure extends Procedure
{
    use ProcedurePermissionControl;

    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'style';

    protected static array $permissions = [
        'list' => PermissionEnum::StylesList,
        'create' => PermissionEnum::StylesCreate,
    ];

    protected StyleRepository $styleRepository;

    public function __construct(StyleRepository $stylesRepository)
    {
        $this->styleRepository = $stylesRepository;
    }

    public function list(): Collection
    {
        return $this->styleRepository->getList();
    }

    public function create(StyleCreateRequest $request): StyleModel
    {
//        return $this->stylesRepository->create($request->toArray());
    }
}
