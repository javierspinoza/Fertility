<?php

namespace App\Livewire\PaymentHistorys;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\PaymentHistory;

use Livewire\Component;

class Index extends Component
{
    use WithPagination;
    //definimos unas variables
    public $paymentHistory_id;
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
    public function render()
    {
        abort_if(Gate::denies('pagos_show'), 403);

        // Obtener los registros de historial de pagos según el usuario actualmente autenticado
        $paymentHistorys = $this->getPaymentHistorysByUserRole();

        return view('livewire.payment-historys.index', compact('paymentHistorys'))->extends('components.layouts.app')->section('content');
    }

    private function getPaymentHistorysByUserRole()
    {
        // Obtener el usuario actualmente autenticado
        $user = Auth::user();

        // Verificar el rol del usuario y obtener los registros de historial de pagos correspondientes
        if ($user->hasRole(['SuperAdmin', 'Administrador_Personal'])) {
            // Si es SuperAdmin o Administrador_Personal, no hay restricciones
            return PaymentHistory::where(function ($query) {
                $query->orWhere('payment_receipt_date', 'like', '%' . $this->search . '%')
                    // para buscar por el nombre de la finca
                    ->orWhereHas('farms', function ($query) {
                        return $query->where('name', 'LIKE', "%{$this->search}%");
                    })
                    // fin para buscar por el nombre de la finca
                    // para buscar por el numero de trabajo
                    ->orWhereHas('works', function ($query) {
                        return $query->where('work_number', 'LIKE', "%{$this->search}%");
                    });
                    // fin para buscar por el numero de trabajo
            })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($user->hasRole('Dueño_Finca')) {
            // Si es Dueño_Finca, filtrar por la finca del usuario
            return PaymentHistory::whereHas('farms', function ($query) use ($user) {
                $query->where('user_owner_id', $user->id);
            })
                ->where(function ($query) {
                    $query->orWhere('payment_receipt_date', 'like', '%' . $this->search . '%')
                        // para buscar por el nombre de la finca
                        ->orWhereHas('farms', function ($query) {
                            return $query->where('name', 'LIKE', "%{$this->search}%");
                        })
                        // fin para buscar por el nombre de la finca
                        // para buscar por el numero de trabajo
                        ->orWhereHas('works', function ($query) {
                            return $query->where('work_number', 'LIKE', "%{$this->search}%");
                        });
                        // fin para buscar por el numero de trabajo
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } elseif ($user->hasRole('Veterinario')) {
            // Si es Veterinario, filtrar por el veterinario asignado al pago
            return PaymentHistory::where('user_veterinarian_charge_id', $user->id)
                ->where(function ($query) {
                    $query->orWhere('payment_receipt_date', 'like', '%' . $this->search . '%')
                        // para buscar por el nombre de la finca
                        ->orWhereHas('farms', function ($query) {
                            return $query->where('name', 'LIKE', "%{$this->search}%");
                        })
                        // fin para buscar por el nombre de la finca
                        // para buscar por el numero de trabajo
                        ->orWhereHas('works', function ($query) {
                            return $query->where('work_number', 'LIKE', "%{$this->search}%");
                        });
                        // fin para buscar por el numero de trabajo
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } else {
            // Otros roles no tienen acceso
            abort(403, 'No tiene permisos para acceder a esta página.');
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
}
