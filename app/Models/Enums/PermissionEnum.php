<?php

namespace App\Models\Enums;

final class PermissionEnum extends BaseEnum
{
    const RawReleaseList = 'raw_release:view';

    const TracksView = 'tracks:view';
    const TracksAdd = 'tracks:add';

    private static array $rolePermissionMapping = [
        RoleEnum::User => [
            self::TracksView
        ]
    ];

    public static function getRolePermissionMapping() : array
    {
        self::$rolePermissionMapping[RoleEnum::Root] = self::asArray();

        return self::$rolePermissionMapping;
    }
}
