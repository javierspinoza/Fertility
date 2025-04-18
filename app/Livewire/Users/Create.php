<?php

namespace App\Livewire\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use App\Models\User;

use Livewire\Component;

class Create extends Component
{
    public $name, $email, $password, $user_id, $user;
    public $assignRol = [];
    public $search;

    public function store()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate([
            'name' => 'required|min:4|max:255',
            'email' => 'required|min:8|max:255|email|unique:users,email,' . $this->user_id,
            'password' => 'required|min:6|max:255',
        ],
        [
            'name.required' => 'El nombre es requerido.',
            'name.min' => 'Pon almenos 4 caracteres',
            'name.max' => 'máximo 255 caracteres',
            'email.required' => 'Por favor escribe un email.',
            'email.min' => 'Pon almenos 8 caracteres',
            'email.max' => 'máximo 255 caracteres',
            'email.email' => 'Escribe un email permitido',
            'email.unique' => 'Este email ya se encuentra registrado.',
            'password.required' => 'Este campo es obligatorio',
            'password.min' => 'Este campo debe tener almenos 6 caracteres',
            'password.max' => 'Este campo debe tener máximo 255 caracteres',
        ]);

        $user = User::create($this->usersData());
        foreach ($this->assignRol as $roleId => $isChecked) {
            // Itera a través de $assignRol, donde $roleId es la clave (ID del rol) y $isChecked es el valor (true/false).
            if ($isChecked) {
                // Verifica si el checkbox está marcado (true).
                $role = Role::find($roleId);
                // Busca el objeto de modelo Role en la base de datos utilizando el ID del rol.
                if ($role) {
                    // Verifica si se encontró un objeto Role con el ID proporcionado.
                    $user->assignRole($role);
                    // Asigna el rol al usuario utilizando el método assignRole proporcionado por Spatie\Permission.
                    // Esto añadirá una nueva entrada en la tabla pivot que relaciona usuarios y roles.
                }
            }
        }
        // enviar email de verificacion
        // event(new Registered($user));
        $user->save();
        session()->flash('crearRegistro', '¡Registro exitoso!');
        $this->redirect('/users' , navigate: true);
    }

    public function usersData()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt($this->password),
            'last_seen' => Carbon::now(),
        ];
    }

    public function mount( Request $request)
    {
        $this->search = $request->query('search');
    }

    public function render()
    {
        abort_if(Gate::denies('user_admin'), 403);
        $roles = Role::where('id', '>', 1)->get();
        return view('livewire.users.create', compact('roles'))->extends('components.layouts.app')->section('content');
    }
}
