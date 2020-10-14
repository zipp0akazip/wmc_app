<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use Illuminate\Http\Request;
use Sajya\Server\Procedure;

class UserProcedure extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'user';

    public function get(Request $request)
    {
        $user = $request->user();
        $result = $user->toArray();

        foreach ($user->getAllPermissions() as $permission) {
            $result['permissions'][] = $permission->name;
        }

        return $result;
    }
}
