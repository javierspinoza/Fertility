<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // spatie documentation
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'permission_admin',
            'role_admin',
            'user_admin',
            'user_show',
            'user_create',

            // de aqui para abajo van todos los de mi aplicacion
            'fincas_admin',
            'fincas_show',
            'ganado_admin',
            'ganado_show',
            'trabajo_admin',
            'trabajo_show',
            'pagos_admin',
            'pagos_show',
            'auth_two_factory',
            'notificacion_admin',

        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
