<?php

namespace App\Livewire\Users;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Models\User;

use Livewire\Component;

class Edit extends Component
{
    public $name, $email, $password, $user_id, $user;
    public $assignRol=[];
    public $search;
    public $page;

    // para las validaciones de campos unicos y en tiempo real
    protected function rules()
    {
        return [
            'name' => 'required|min:4|max:255',
            'email' => 'required|min:8|max:255|email|unique:users,email,' . $this->user_id,
            'password' => 'max:255',
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 4 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'email.required' => 'Por favor escribe un email.',
        'email.min' => 'Pon almenos 8 caracteres',
        'email.max' => 'máximo 255 caracteres',
        'email.email' => 'Escribe un email permitido',
        'email.unique' => 'Este email ya se encuentra registrado.',
        'password.max' => 'Este campo debe tener máximo 255 caracteres',
    ];

    public function mount($id, Request $request)
    {
        $this->search = $request->query('search');
        $this->page = $request->query('page', 1);
        $user = User::where('id', $id)->first();

        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->assignRol = [];
        $this->user = $user;
        // para marcar como seleccionados loos roles que ya pertenecen a un usuario
        foreach ($this->user->roles->pluck('id')->toArray() as  $rol) {
            array_push($this->assignRol, "$rol");
        }
    }

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        // para asignar el rol al usuario
        $this->user->roles()->sync($this->assignRol);

        $user = User::find($this->user_id);

        $user->name = $this->name;
        $user->email= $this->email;
        if($this->password)
            $user['password'] = bcrypt($this->password);
        $user->save();
        session()->flash('actualizar', '¡Actualización exitosa!');
        $encodedSearch = http_build_query(['search' => $this->search, 'page' => $this->page]);
        $this->redirect('/users?' . $encodedSearch, navigate: true);
    }

    public function render()
    {
        abort_if(Gate::denies('user_admin'), 403);
        $roles = Role::where('id', '>', 1)->get();
        return view('livewire.users.edit', compact('roles'))->extends('components.layouts.app')->section('content');
    }
}
