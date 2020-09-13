<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Enums\PermissionEnum;

class CreateRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rootUser = new User();
        $rootUser->name = 'Root admin';
        $rootUser->email = 'root@admin.loc';
        $rootUser->password = Hash::make('qweasdzxc');
        $rootUser->save();

        $simpleUser = new User();
        $simpleUser->name = 'Simple user';
        $simpleUser->email = 'simple@user.loc';
        $simpleUser->password = Hash::make('qweasdzxc');
        $simpleUser->save();

        $roles = PermissionEnum::getRolePermissionMapping();

        foreach ($roles as $roleName => $permissions) {
            $role = Role::findOrCreate($roleName);

            foreach ($permissions as $permissionName) {
                $permission = Permission::findOrCreate($permissionName);
                $role->givePermissionTo($permission);
            }

            if ($roleName === 'root') {
                $rootUser->assignRole($role);
            }

            if ($roleName === 'user') {
                $simpleUser->assignRole($role);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
