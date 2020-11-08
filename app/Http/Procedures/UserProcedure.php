<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Requests\User\GetRequest;
use Sajya\Server\Procedure;

class UserProcedure extends Procedure
{
    public static string $name = 'user';

    public function get(GetRequest $request)
    {
        $user = $request->user();
        $result = $user->toArray();

        foreach ($user->getAllPermissions() as $permission) {
            $result['permissions'][] = $permission->name;
        }

        return $result;
    }
}
