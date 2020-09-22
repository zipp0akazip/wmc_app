<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sajya\Server\Guide;
use Sajya\Server\Procedure;

class StylesProcedure extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'styles';

    public function list(): array
    {
        var_dump(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));exit;
        var_dump('list');exit;
    }

    public function create(): array
    {
        var_dump('create');exit;
    }
}
