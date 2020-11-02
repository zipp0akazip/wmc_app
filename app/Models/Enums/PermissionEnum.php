<?php

namespace App\Models\Enums;

final class PermissionEnum extends BaseEnum
{
    const RawReleaseList = 'raw-release:list';

    const UnapprovedStylesList = 'unapproved-style:list';
    const UnapprovedLabelsList = 'unapproved-label:list';
    const UnapprovedArtistsList = 'unapproved-artist:list';

    const ArtistList = 'artist:list';
    const ArtistCreate = 'artist:create';
    const ArtisAddAlias = 'artist:add-alias';

    const StylesList = 'style:list';
    const StylesCreate = 'style:create';

    const LabelsList = 'label:list';
    const LabelsCreate = 'label:create';
    const LabelsAddAlias  = 'label:add-alias';

    const TracksView = 'track:view';
    const TracksAdd = 'track:add';

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
