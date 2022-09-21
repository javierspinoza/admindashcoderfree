<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Admin--- para asignarle todos los permisos al admin
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        // asignando permisos a rol User excepto los que comienzan con user_, role_ y permission_
        $user_permissions = $admin_permissions->filter(function($permission) {
            return substr($permission->name, 0, 5) != 'user_' &&
                substr($permission->name, 0, 5) != 'role_' &&
                substr($permission->name, 0, 11) != 'permission_';
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);
    }
}
