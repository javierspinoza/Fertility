<?php

namespace App\Livewire\Works;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Notifications\worksNotification;
use Illuminate\Support\Facades\DB;
use App\Models\Work;
use App\Models\Farm;
use App\Models\User;
use App\Models\PaymentHistory;

use Livewire\Component;

class Edit extends Component
{
    //definimos unas variables
    public $date_work, $cows_seeded, $cows_palpated, $cows_calved, $status, $price_overall,
    $fast_notes, $farms_id, $paymentHistory_id, $user_veterinarian_charge_id, $work_id;
    public $search;
    public $page;
    // para las validaciones de campos unicos y en tiempo real
    protected function rules()
    {
        return [
            'date_work' => 'required',
            'price_overall' => 'required',
            'fast_notes' => 'max:1300',
            'farms_id' => 'required',
            'status' => 'required',
            'user_veterinarian_charge_id' => 'required',
        ];
    }
    protected $messages = [
        'date_work.required' => 'La fecha del trabajo realizado es requerida.',
        'price_overall.required' => 'El precio total es requerido.',
        'fast_notes.max' => 'No puedes poner mas de 1300 caracteres.',
        'farms_id.required' => 'Seleccione la finca a la cual pertenece este trabajo.',
        'status.required' => 'Seleccione si el trabajo fue completado o esta pendiente.',
        'user_veterinarian_charge_id.required' => 'El veterinario asignado es requerido.',
    ];

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();
        try {
            DB::beginTransaction();
            $work = Work::find($this->work_id);
            // Obtenemos el trabajo actual para comparar valores después de la actualización
            $oldPriceOverall = $work->price_overall;
            // obtenemos la fecha del trabajo actual para saber si se modifica y enviar la notificacion
            $oldDateWork = $work->date_work;
            $work->update([
                'date_work' => $this->date_work,
                'cows_seeded' => $this->cows_seeded,
                'cows_palpated' => $this->cows_palpated,
                'cows_calved' => $this->cows_calved,
                'price_overall' => $this->price_overall,
                'status' => strtoupper($this->status),
                'fast_notes' => strtoupper($this->fast_notes),
                // 'farms_id' => $this->farms_id,
            ]);
            // Verificamos si el campo date_work ha sido modificado
            if ($oldDateWork != $this->date_work) {
                // enviar notificacion
                $userVeterinianOwner = User::find($this->user_veterinarian_charge_id);
                if ($userVeterinianOwner) {
                    $userVeterinianOwner->notify(new worksNotification($work));
                }
            }
            // Actualizar el historial de pagos relacionado, si se cambia el valor price_overall
            $paymentHistory = PaymentHistory::where('work_id', $this->work_id)->first();
            if ($paymentHistory) {
                $oldTotalBalance = $paymentHistory->total_work_balance;
                $newTotalBalance = $this->price_overall;
                if ($oldTotalBalance !== $newTotalBalance) {
                    $outstandingBalanceDifference = (int)$newTotalBalance - (int)$oldTotalBalance;
                    $newOutstandingBalance = (int)$paymentHistory->outstanding_balance + (int)$outstandingBalanceDifference;
                    $paymentHistory->update([
                        'total_work_balance' => $newTotalBalance,
                        'outstanding_balance' => $newOutstandingBalance,
                        'farms_id' => $this->farms_id,
                    ]);
                } else {
                    $paymentHistory->update([
                        'farms_id' => $this->farms_id,
                    ]);
                }
            }
            // Verificamos si el price_overall ha cambiado para modicar el total en la tabla farms
            if ($oldPriceOverall != $this->price_overall) {
                // Calculamos la diferencia entre el nuevo y el antiguo price_overall
                $priceOverallDifference = (int)$this->price_overall - (int)$oldPriceOverall;
                // Obtenemos la granja relacionada
                $farm = Farm::find($this->farms_id);
                // Actualizamos el total_debt de la granja
                $newTotalDebt = (int)$farm->total_debt + (int)$priceOverallDifference;
                $farm->update([
                    'total_debt' => $newTotalDebt,
                ]);
            }
            DB::commit();
            session()->flash('actualizar', '¡Actualización exitosa!');
            $encodedSearch = http_build_query(['search' => $this->search, 'page' => $this->page,]);
            $this->redirect('/trabajos?' . $encodedSearch, navigate: true);
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th);
            $this->dispatch('MatchErrorData');
        }
    }

    public function mount($id, Request $request)
    {
        $this->search = $request->query('search');
        $this->page = $request->query('page', 1);
        $work = Work::where('id', $id)->first();

        $this->work_id = $id;
        $this->date_work = $work->date_work;
        $this->cows_seeded = $work->cows_seeded;
        $this->cows_palpated = $work->cows_palpated;
        $this->cows_calved = $work->cows_calved;
        $this->price_overall = $work->price_overall;
        $this->status = $work->status;
        $this->fast_notes = $work->fast_notes;
        $this->farms_id = $work->farms_id;
        $this->user_veterinarian_charge_id = $work->user_veterinarian_charge_id;
    }

    public function render()
    {
        abort_if(Gate::denies('trabajo_admin'), 403);
        // Obtener todas las fincas y veterinarios
        $farms = Farm::get();
        $userVeterinarians = User::role(['Veterinario'])->get();
        return view('livewire.works.edit', compact('farms', 'userVeterinarians'))->extends('components.layouts.app')->section('content');
    }
}
