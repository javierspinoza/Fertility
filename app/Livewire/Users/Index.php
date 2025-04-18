<?php

namespace App\Livewire\Users;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Spatie\Permission\Models\Role;
use App\Models\User;

use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $user_id;
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
        abort_if(Gate::denies('user_show'), 403);
        $roles = Role::where('id', '>', 1)->get();
        $users = User::where('id', '>', 1)
        ->where(function($query) {
            $query->orWhere('name', 'like', '%' .$this->search.'%')
            ->orWhere('email', 'like', '%' .$this->search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        return view('livewire.users.index', compact('users', 'roles'))->extends('components.layouts.app')->section('content');
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
        $this->user_id = $id;
        $this->dispatch('confirmDeletion');
    }

    public function deleteUser()
    {
        $user = User::find($this->user_id);

        try {
            // Verificar si el usuario tiene alguna relación con las tablas
            if ($user->farms()->exists() ||
            $user->works()->exists() ||
            $user->payments()->exists() ||
            $user->farmsVeterinian()->exists()) {
                $this->dispatch('errordeleted');
            }
            // Para que el usuario que esté logeado no pueda eliminarse a sí mismo
            elseif (auth()->user()->id == $user->id) {
                $this->dispatch('errorDeletedYo');
            }
            // Eliminar usuario si no tiene relaciones con las tablas
            elseif ($user->delete()) {
                $this->dispatch('deleted');
            }
        } catch (\Throwable $th) {
            dd($th);
            $this->dispatch('MatchErrorData');
        }
    }
}
