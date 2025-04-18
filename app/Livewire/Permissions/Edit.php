<?php

namespace App\Livewire\Permissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

use Livewire\Component;

class Edit extends Component
{
    //definimos unas variables
    public $name, $guard_name, $permission_id;
    public $search;
    public $page;
    // para las validaciones de campos unicos y en tiempo real
    protected function rules()
    {
        return [
            'name' => 'required|min:4|max:255|unique:permissions,name,' . $this->permission_id,
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 4 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'name.unique' => 'Este permiso ya se encuentra registrado',
    ];

    public function mount($id, Request $request)
    {
        $this->search = $request->query('search');
        $this->page = $request->query('page', 1);
        $permission = Permission::where('id', $id)->first();

        $this->permission_id = $id;
        $this->name = $permission->name;
    }

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        $permission = Permission::find($this->permission_id);
        $permission->name = $this->name;
        $permission->save();
        session()->flash('actualizar', '¡Actualización exitosa!');
        $encodedSearch = http_build_query(['search' => $this->search, 'page' => $this->page]);
        $this->redirect('/permissions?' . $encodedSearch, navigate: true);
    }

    public function render()
    {
        abort_if(Gate::denies('permission_admin'), 403);
        return view('livewire.permissions.edit')->extends('components.layouts.app')->section('content');
    }
}
