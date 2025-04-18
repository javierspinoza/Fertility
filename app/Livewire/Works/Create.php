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

class Create extends Component
{
    //definimos unas variables
    public $date_work, $cows_seeded, $cows_palpated, $cows_calved, $status, $price_overall,
    $fast_notes, $farms_id, $paymentHistory_id, $user_veterinarian_charge_id, $work_id;
    public $search;
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

    public function store()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();
        try {
            DB::beginTransaction();

            $work = Work::create([
                'date_work' => $this->date_work,
                'cows_seeded' => $this->cows_seeded,
                'cows_palpated' => $this->cows_palpated,
                'cows_calved' => $this->cows_calved,
                'price_overall' => $this->price_overall,
                'status' => strtoupper($this->status),
                'fast_notes' => strtoupper($this->fast_notes),
                'farms_id' => $this->farms_id,
                'user_veterinarian_charge_id' => $this->user_veterinarian_charge_id,
            ]);
            // Obtener el ID del registro creado
            $workId = $work->id;
            // Construir el número de trabajo con el ID del registro
            $workNumber = "TRABAJO N° " . $workId;
            // Actualizar el campo 'work_number' con el número de trabajo construido
            $work->update(['work_number' => $workNumber]);

            // enviar notificacion
            $userVeterinianOwner = User::find($this->user_veterinarian_charge_id);
            if ($userVeterinianOwner) {
                $userVeterinianOwner->notify(new worksNotification($work));
            }

            // Crear el pago correspondiente al trabajo
            $paymentHistory = new PaymentHistory();
            $paymentHistory->total_work_balance = $this->price_overall; // Total del trabajo
            $paymentHistory->outstanding_balance = $this->price_overall; // El saldo pendiente es igual al total del trabajo
            $paymentHistory->work_id = $work->id;
            $paymentHistory->farms_id = $work->farms_id;
            $paymentHistory->user_veterinarian_charge_id = $work->user_veterinarian_charge_id;
            $paymentHistory->save();

            // Guardar el total que debe esa finca por los trabajos
            $farm = Farm::findOrFail($work->farms_id);
            $farm->total_debt += (int)$this->price_overall;
            $farm->save();

            DB::commit();

            // Set Flash Message
            // $this->dispatch('crearRegistro');
            session()->flash('crearRegistro', '¡Registro exitoso!');
            $encodedSearch = http_build_query(['search' => $this->search]);
            $this->redirect('/trabajos?'. $encodedSearch , navigate: true);
        } catch (\Throwable $th) {
            DB::rollBack();
            // Set Flash Message
            $this->dispatch('MatchErrorData');
        }
    }

    public function mount(Request $request)
    {
        $this->search = $request->query('search');
    }

    public function render()
    {
        abort_if(Gate::denies('trabajo_admin'), 403);
        // Obtener todas las fincas y veterinarios
        $farms = Farm::get();
        $userVeterinarians = User::role(['Veterinario'])->get();
        return view('livewire.works.create', compact('farms', 'userVeterinarians'))->extends('components.layouts.app')->section('content');
    }
}
