<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\Style\DeleteRequest;
use App\Http\Requests\Style\EditAliasesRequest;
use App\Http\Requests\Style\CreateRequest;
use App\Http\Requests\Style\ListRequest;
use App\Models\StyleModel;
use App\Repositories\StyleRepository;
use Illuminate\Database\Eloquent\Collection;
use Sajya\Server\Procedure;

class StyleProcedure extends Procedure
{
    public static string $name = 'style';

    protected StyleRepository $styleRepository;

    public function __construct(StyleRepository $stylesRepository)
    {
        $this->styleRepository = $stylesRepository;
    }

    public function list(ListRequest $request): Collection
    {
        return $this->styleRepository->getList();
    }

    public function create(CreateRequest $request): StyleModel
    {
        return $this->styleRepository->appendNew(
            $request->get('parent_id'),
            $request->get('name'),
        );
    }

    public function delete(DeleteRequest $request): bool
    {
        return $this->styleRepository->delete($request->get('style_id'));
    }

    public function editAliases(EditAliasesRequest $request): StyleModel
    {
        return $this->styleRepository->editAliases(
            $request->get('style_id'),
            $request->get('aliases'),
        );
    }
}
