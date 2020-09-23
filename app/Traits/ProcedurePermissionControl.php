<?php

namespace App\Traits;

trait ProcedurePermissionControl
{
    public static function getPermissions(): array
    {
        return self::$permissions;
    }

    public static function getPermissionsForMethod(string $method): string
    {
        return self::$permissions[$method] ?? false;
    }
}