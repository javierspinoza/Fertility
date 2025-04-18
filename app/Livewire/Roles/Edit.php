<?php

namespace App\Livewire\Roles;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Livewire\Component;

class Edit extends Component
{
    //definimos unas variables
    public $name, $selectedPermissions = [], $role_id;
    public $viewCreateEdit = 0;
    public $search;
    public $page;
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

    public function mount($id, Request $request)
    {
        $this->search = $request->query('search');
        $this->page = $request->query('page', 1);
        $role = Role::where('id', $id)->first();

        $this->role_id = $id;
        $this->name = $role->name;
        // Obtener los permisos asociados con el rol y almacenar sus IDs en $selectedPermissions
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    public function update()
    {
        // // para que funcionen las validaciones
        $validatedData = $this->validate();

        try {
            // Obtener el rol por su ID
            $role = Role::findOrFail($this->role_id);
    
            // Actualizar el nombre del rol
            $role->name = $this->name;
            $role->save();
    
            // Sincronizar los permisos seleccionados con el rol
            $role->permissions()->sync($this->selectedPermissions);
    
            // Mensaje de éxito
            session()->flash('actualizar', '¡Actualización exitosa!');
            $encodedSearch = http_build_query(['search' => $this->search, 'page' => $this->page,]);
            $this->redirect('/roles?' . $encodedSearch, navigate: true);
        } catch (\Exception $e) {
            // Mensaje de error
            $this->dispatch('MatchErrorData');
        }
    }

    public function render()
    {
        abort_if(Gate::denies('role_admin'), 403);
        $permissions = Permission::get()->sortBy('name');
        return view('livewire.roles.edit', compact('permissions'))->extends('components.layouts.app')->section('content');
    }
}
