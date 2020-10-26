<?php

namespace App\Models\Enums;

final class PermissionEnum extends BaseEnum
{
    const RawReleaseList = 'raw-release:list';

    const UnapprovedStylesList = 'unapproved-styles:list';

    const UnapprovedLabelsList = 'unapproved-labels:list';

    const UnapprovedArtistsList = 'unapproved-artists:list';

    const StylesList = 'styles:list';
    const StylesCreate = 'styles:create';

    const LabelsList = 'labels:list';
    const LabelsCreate = 'labels:create';

    const TracksView = 'tracks:view';
    const TracksAdd = 'tracks:add';

    const AdminMenuView = 'admin-menu:view';

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
