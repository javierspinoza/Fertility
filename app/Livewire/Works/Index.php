<?php

namespace App\Livewire\Works;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\Work;
use App\Models\PaymentHistory;
use App\Models\Farm;

use Livewire\Component;

class Index extends Component
{
    use WithPagination;
    //definimos unas variables
    public $work_id;
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
        abort_if(Gate::denies('trabajo_show'), 403);

        // Obtener los trabajos según el rol del usuario
        $works = $this->getWorksByUserRole();

        return view('livewire.works.index', compact('works'))->extends('components.layouts.app')->section('content');
    }

    private function getWorksByUserRole()
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Verificar el rol del usuario y obtener los trabajos correspondientes
        if ($user->hasRole('SuperAdmin') || $user->hasRole('Administrador_Personal')) {
            // Si es SuperAdmin o Administrador_Personal, no hay restricciones
            return Work::where(function ($query) {
                $query->orWhere('work_number', 'like', '%' . $this->search . '%')
                    ->orWhere('date_work', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    // para buscar por el nombre de la finca
                    ->orWhereHas('farms', function ($query) {
                        return $query->where('name', 'LIKE', "%{$this->search}%");
                    });
                    // fin para buscar por el nombre de la finca
            })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($user->hasRole('Dueño_Finca')) {
            // Si es Dueño_Finca, obtener los trabajos de las fincas asociadas a él
            return Work::whereHas('farms', function ($query) use ($user) {
                $query->where('user_owner_id', $user->id);
            })
                ->where(function ($query) {
                    $query->orWhere('work_number', 'like', '%' . $this->search . '%')
                        ->orWhere('date_work', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%')
                        // para buscar por el nombre de la finca
                        ->orWhereHas('farms', function ($query) {
                            return $query->where('name', 'LIKE', "%{$this->search}%");
                        });
                        // fin para buscar por el nombre de la finca
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($user->hasRole('Veterinario')) {
            // Si es Veterinario, obtener los trabajos asignados a él
            return Work::where('user_veterinarian_charge_id', $user->id)
                ->where(function ($query) {
                    $query->orWhere('work_number', 'like', '%' . $this->search . '%')
                        ->orWhere('date_work', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%')
                        // para buscar por el nombre de la finca
                        ->orWhereHas('farms', function ($query) {
                            return $query->where('name', 'LIKE', "%{$this->search}%");
                        });
                        // fin para buscar por el nombre de la finca
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
        $this->work_id = $id;
        $this->dispatch('confirmDeletion');
    }

    public function deleteWork()
    {
        $work = Work::find($this->work_id);

        try {
            DB::beginTransaction();

            // Busca y obtén el historial de pagos relacionado al trabajo
            $paymentHistory = PaymentHistory::where('work_id', $work->id)->first();

            if ($paymentHistory) {
                // Resta el monto del pago eliminado al total_debt de la finca correspondiente
                $farm = Farm::find($work->farms_id);
                $new_total_balance = (int)$paymentHistory->total_work_balance - (int)$paymentHistory->outstanding_balance;
                $newTotalDebt = (int)$farm->total_debt - (int)$paymentHistory->total_work_balance;
                $endtotal = $newTotalDebt + $new_total_balance;
                $farm->update([
                    'total_debt' => $endtotal,
                ]);

                // Elimina el historial de pagos
                $paymentHistory->delete();
            }

            // Elimina el trabajo
            $work->delete();

            DB::commit();
            $this->dispatch('deleted');
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th);
            $this->dispatch('MatchErrorData');
        }
    }
}
