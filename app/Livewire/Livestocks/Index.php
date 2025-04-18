<?php

namespace App\Livewire\Livestocks;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\Livestock;

use Livewire\Component;

class Index extends Component
{
    use WithPagination;
    //definimos unas variables
    public $livestock_id;
    #[Url]
    public $search;
    // PARA MOSTRAR LA CANTIDAD DE REGISTREOS POR PAGUINA
    public $cant = 5;
    // dos siguientes lineas para ordenar columnas
    public $sort = 'id';
    public $direction = 'desc';
    // para que use la paguinacion de bootstrap
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        abort_if(Gate::denies('ganado_show'), 403);
        $livestocks = Livestock::where(function($query) {
            $query->orWhere('type_livestock', 'like', '%' .$this->search.'%')
            ->orWhere('state_productive', 'like', '%' .$this->search.'%')
            // para buscar por el nombre de la finca
            ->orWhereHas('farms', function($query) {
                return $query->where('name', 'LIKE', "%{$this->search}%");
            });
            // fin para buscar por el nombre de la finca
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate($this->cant);
        return view('livewire.livestocks.index', compact('livestocks'))->extends('components.layouts.app')->section('content');
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
        $this->livestock_id = $id;
        $this->dispatch('confirmDeletion');
    }

    public function deleteLivestock()
    {
        $livestock = Livestock::find($this->livestock_id);

        try {
            $livestock->delete();
            $this->dispatch('deleted');
        } catch (\Throwable $th) {
            // dd($th);
            $this->dispatch('MatchErrorData');
        }
    }
}
