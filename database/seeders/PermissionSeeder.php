<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // spatie documentation
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'permission_admin',

            'role_admin',
            // 'role_create',
            // 'role_show',
            // 'role_edit',
            // 'role_destroy',

            'user_admin',

            // de aqui para abajo van todos los de mi aplicacion
            'materia_admin'

        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
