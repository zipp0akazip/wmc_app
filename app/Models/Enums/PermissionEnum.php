<?php

namespace App\Models\Enums;

final class PermissionEnum extends BaseEnum
{
    const AdminMenuView = 'admin-menu:view';

    const ArtistList = 'artist:list';
    const ArtistCreate = 'artist:create';
    const ArtistAddAlias = 'artist:add-alias';

    const LabelList = 'label:list';
    const LabelCreate = 'label:create';
    const LabelAddAlias  = 'label:add-alias';

    const RawReleaseList = 'raw-release:list';

    const StyleList = 'style:list';
    const StyleCreate = 'style:create';
    const StyleDelete = 'style:delete';
    const StyleAddAlias = 'style:add-alias';
    const StyleEditAliases = 'style:edit-aliases';

    const UnapprovedArtistList = 'unapproved-artist:list';
    const UnapprovedLabelList = 'unapproved-label:list';
    const UnapprovedStyleList = 'unapproved-style:list';

    const TrackView = 'track:view';
    const TrackAdd = 'track:add';

    private static array $rolePermissionMapping = [
        RoleEnum::User => [
            self::TrackView
        ]
    ];

    public static function getRolePermissionMapping() : array
    {
        self::$rolePermissionMapping[RoleEnum::Root] = self::asArray();

        return self::$rolePermissionMapping;
    }
}
