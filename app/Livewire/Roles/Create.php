<?php

namespace App\Livewire\Roles;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Livewire\Component;

class Create extends Component
{
    //definimos unas variables
    public $name, $selectedPermissions = [], $role_id;
    public $viewCreateEdit = 0;
    public $search;
    // para las validaciones de campos unicos y en tiempo real
    protected function rules()
    {
        return [
            'name' => 'required|min:4|max:255|unique:roles,name,' . $this->role_id,
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 4 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'name.unique' => 'Este rol ya se encuentra registrado',
    ];

    public function store()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        $role = Role::create($this->rolesData());
        // Asignar permisos al rol
        $role->permissions()->attach($this->selectedPermissions);
        $role->save();

        session()->flash('crearRegistro', '¡Registro exitoso!');
        $encodedSearch = http_build_query(['search' => $this->search]);
        $this->redirect('/roles?' . $encodedSearch , navigate: true);
    }

    public function rolesData()
    {
        return [
            'name' => $this->name
        ];
    }

    public function mount( Request $request)
    {
        $this->search = $request->query('search');
    }

    public function render()
    {
        abort_if(Gate::denies('role_admin'), 403);
        $permissions = Permission::get()->sortBy('name');
        return view('livewire.roles.create', compact('permissions'))->extends('components.layouts.app')->section('content');
    }
}
