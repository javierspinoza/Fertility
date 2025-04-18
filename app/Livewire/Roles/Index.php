<?php

namespace App\Livewire\Roles;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Spatie\Permission\Models\Role;

use Livewire\Component;

class Index extends Component
{
    use WithPagination;
    public $role_id;
    #[Url]
    public $search;
    // PARA MOSTRAR LA CANTIDAD DE REGISTREOS POR PAGUINA
    public $cant = 5;
    // dos siguientes lineas para ordenar columnas
    public $sort = 'id';
    public $direction = 'desc';
    // para que use la paguinacion de bootstrap
    protected $paginationTheme = 'bootstrap';
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

    public function render()
    {
        abort_if(Gate::denies('role_admin'), 403);

        $roles = Role::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('name', 'like', '%' .$this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        return view('livewire.roles.index', compact('roles'))->extends('components.layouts.app')->section('content');
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
    // esto es para que me funcione el buscador en cualquier pag, no solo en la primera
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmRemoved($id)
    {
        $this->role_id = $id;
        $this->dispatch('confirmDeletion');
    }

    public function deleteRole()
    {
        $role = Role::find($this->role_id);

        try {
            $role->delete();
            $this->dispatch('deleted');
        } catch (\Throwable $th) {
            $this->dispatch('MatchErrorData');
        }
    }
}
