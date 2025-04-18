<?php

namespace App\Livewire\Farms;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\Farm;
use App\Models\User;

use Livewire\Component;

class Index extends Component
{
    use WithPagination;
    public $farm_id;
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
        abort_if(Gate::denies('fincas_show'), 403);
        
        // Obtener las fincas según el usuario actualmente autenticado
        $farms = $this->getFarmsByUserRole();

        $userFarms = User::role(['Dueño_Finca'])->get();
        $userVeterinarians = User::role(['Veterinario'])->get();

        return view('livewire.farms.index', compact('farms', 'userFarms', 'userVeterinarians'))->extends('components.layouts.app')->section('content');
    }

    private function getFarmsByUserRole()
    {
        // Obtener el usuario actualmente autenticado
        $user = auth()->user();

        // Verificar el rol del usuario y obtener las fincas correspondientes
        if ($user->hasRole(['SuperAdmin', 'Administrador_Personal'])) {
            // Si es SuperAdmin o Administrador_Personal, obtener todas las fincas sin restricciones
            return Farm::where(function ($query) {
                $query->orWhere('name', 'like', '%' . $this->search . '%')
                    // para buscar por el usuario también
                    ->orWhereHas('users', function ($query) {
                        return $query->where('name', 'LIKE', "%{$this->search}%");
                    });
                    // fin para buscar por el usuario
            })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($user->hasRole('Dueño_Finca')) {
            // Si es Dueño_Finca, obtener las fincas que le pertenecen
            return $user->farms()
                ->where(function ($query) {
                    $query->orWhere('name', 'like', '%' . $this->search . '%')
                        // para buscar por el usuario también
                        ->orWhereHas('users', function ($query) {
                            return $query->where('name', 'LIKE', "%{$this->search}%");
                        });
                        // fin para buscar por el usuario
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($user->hasRole('Veterinario')) {
            // Si es Veterinario, obtener las fincas donde es el veterinario asignado
            return Farm::where('user_veterinarian_charge_id', $user->id)
                ->where(function ($query) {
                    $query->orWhere('name', 'like', '%' . $this->search . '%')
                        // para buscar por el usuario también
                        ->orWhereHas('users', function ($query) {
                            return $query->where('name', 'LIKE', "%{$this->search}%");
                        });
                        // fin para buscar por el usuario
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        }
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
        $this->farm_id = $id;
        $this->dispatch('confirmDeletion');
    }

    public function deleteFarm()
    {
        $farm = Farm::find($this->farm_id);

        try {
            // Verificar si el finca tiene alguna relación con las tablas
            if ($farm->livestocks()->exists() ||
            $farm->works()->exists() ||
            $farm->paymentHistorys()->exists()) {
                $this->dispatch('errordeleted');
            }
            // Eliminar finca si no tiene relaciones con las tablas
            elseif ($farm->delete()) {
                $this->dispatch('deleted');
            }
        } catch (\Throwable $th) {
            // dd($th);
            $this->dispatch('MatchErrorData');
        }
    }
}
