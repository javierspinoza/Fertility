<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'SuperAdmin Javier',
            'email' => 'javerespinoxzapiko@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12345678Sk8')
        ]);
        $user->assignRole('SuperAdmin');

        $userUsuario = User::create([
            'name' => 'Fredy Vega',
            'email' => 'fredyvega@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('luis378473')
        ]);
        $userUsuario->assignRole('Administrador_Personal');

        $userUsuario = User::create([
            'name' => 'Andrea Joya',
            'email' => 'andreajoyavega@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('andrea2323')
        ]);
        $userUsuario->assignRole('Administrador_Personal');

        $userUsuario = User::create([
            'name' => 'Maria Paula',
            'email' => 'mariapaula@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('luis3781473')
        ]);
        $userUsuario->assignRole('Veterinario');

        $userUsuario = User::create([
            'name' => 'Luis Silva',
            'email' => 'luissilva@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('luis()...')
        ]);
        $userUsuario->assignRole('Veterinario');

        $userUsuario = User::create([
            'name' => 'Javier Spinoza',
            'email' => 'javierspinoza@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('luis378473')
        ]);
        $userUsuario->assignRole('Dueño_Finca');

        $userUsuario = User::create([
            'name' => 'Matheo Hernandez',
            'email' => 'mateohernandez@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('luis3,.ñ78473')
        ]);
        $userUsuario->assignRole('Dueño_Finca');

        $userUsuario = User::create([
            'name' => 'Isabela Medina',
            'email' => 'isabelamedina@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('luis378473')
        ]);
        $userUsuario->assignRole('Dueño_Finca');
    }
}
