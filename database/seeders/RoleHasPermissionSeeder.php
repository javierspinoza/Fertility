<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // SuperAdmin--- para asignarle todos los permisos al SuperAdmin
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        // asignando permisos a rol Administrador_Personal excepto los que comienzan con user_, role_ y permission_ ...
        $user_admin_personal_permissions = $admin_permissions->filter(function($permission) {
            return substr($permission->name, 0, 11) != 'permission_' &&
            substr($permission->name, 0, 5) != 'role_' &&
            substr($permission->name, 0, 16) != 'auth_two_factory';
        });
        Role::findOrFail(2)->permissions()->sync($user_admin_personal_permissions);

        // asignando permisos a rol Veterinario excepto los que comienzan con user_, role_ y permission_ ...
        $user_veterinario_permissions = $admin_permissions->filter(function($permission) {
            return substr($permission->name, 0, 11) != 'permission_' &&
            substr($permission->name, 0, 5) != 'role_' &&
            substr($permission->name, 0, 10) != 'user_admin' &&
            substr($permission->name, 0, 16) != 'auth_two_factory';
        });
        Role::findOrFail(3)->permissions()->sync($user_veterinario_permissions);

        // asignando permisos a rol Dueño_Finca excepto los que comienzan con user_, role_ y permission_ ...
        $user_dueno_finca_permissions = $admin_permissions->filter(function($permission) {
            return substr($permission->name, 0, 11) != 'permission_' &&
            substr($permission->name, 0, 5) != 'role_' &&
                substr($permission->name, 0, 10) != 'user_admin' &&
                substr($permission->name, 0, 11) != 'user_create' &&
                substr($permission->name, 0, 12) != 'fincas_admin' &&
                substr($permission->name, 0, 12) != 'ganado_admin' &&
                substr($permission->name, 0, 13) != 'trabajo_admin' &&
                substr($permission->name, 0, 11) != 'pagos_admin' &&
                substr($permission->name, 0, 13) != 'notificacion_' &&
                substr($permission->name, 0, 16) != 'auth_two_factory';
        });
        Role::findOrFail(4)->permissions()->sync($user_dueno_finca_permissions);
    }
}
