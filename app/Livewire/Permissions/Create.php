<?php

namespace App\Livewire\Permissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

use Livewire\Component;

class Create extends Component
{
    //definimos unas variables
    public $name, $guard_name, $permission_id;
    public $search;
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

    public function store()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();

        try{
            $permission = Permission::create([
                'name' => $this->name,
            ]);
            session()->flash('crearRegistro', '¡Registro exitoso!');
            $encodedSearch = http_build_query(['search' => $this->search]);
            $this->redirect('/permissions?' . $encodedSearch , navigate: true);
            
        }catch(\Exception $e){
            // Set Flash Message
            $this->dispatch('MatchErrorData');
        }
    }

    public function mount( Request $request)
    {
        $this->search = $request->query('search');
    }

    public function render()
    {
        abort_if(Gate::denies('permission_admin'), 403);
        return view('livewire.permissions.create')->extends('components.layouts.app')->section('content');
    }
}
