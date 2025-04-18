<?php

namespace App\Livewire\Permissions;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

use Livewire\Component;

class Index extends Component
{
    use WithPagination;
    public $permission_id;
    #[Url] 
    public $search = '';
    // PARA MOSTRAR LA CANTIDAD DE REGISTREOS POR PAGUINA
    public $cant = 5;
    // dos siguientes lineas para ordenar columnas
    public $sort = 'id';
    public $direction = 'desc';
    // para que use la paguinacion de bootstrap
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        abort_if(Gate::denies('permission_admin'), 403);

        $permissions = Permission::where('id', 'like', '%' .$this->search.'%')
        ->orWhere('name', 'like', '%' .$this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        return view('livewire.permissions.index', compact('permissions'))->extends('components.layouts.app')->section('content');
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
        $this->permission_id = $id;
        $this->dispatch('confirmDeletion');
    }

    public function deletePermission()
    {
        $permission = Permission::find($this->permission_id);

        try {
            $permission->delete();
            $this->dispatch('deleted');
        } catch (\Throwable $th) {
            $this->dispatch('deletedMatchError');
        }
    }
}
