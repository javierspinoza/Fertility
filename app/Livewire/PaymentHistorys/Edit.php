<?php

namespace App\Livewire\PaymentHistorys;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Models\Work;
use App\Models\Farm;
use App\Models\User;

use Livewire\Component;

class Edit extends Component
{
    //definimos unas variables
    #[Validate]
    public $payment_receipt_date, $amount_received, $outstanding_balance, $total_work_balance,
    $fast_notes, $work_id, $farms_id, $user_veterinarian_charge_id, $paymentHistory_id;
    public $search;
    public $page;
    protected function rules()
    {
        return [
            'payment_receipt_date' => 'required',
            'amount_received' => 'required|numeric|min:1|max:' . $this->outstanding_balance,
            'fast_notes' => 'max:1300',
            'work_id' => 'required',
            'farms_id' => 'required',
            'user_veterinarian_charge_id' => 'required',
        ];
    }
    protected $messages = [
        'payment_receipt_date.required' => 'La fecha del pago recivido es requerida.',
        'amount_received.required' => 'El valor recivido es requerido.',
        'amount_received.numeric' => 'El valor recivido debe ser númerico.',
        'amount_received.min' => 'El valor recivido debe ser mayor o igual a 1.',
        'amount_received.max' => 'El valor recivido debe ser menor o igual al saldo pendiente.',
        'fast_notes.max' => 'No puedes poner mas de 1300 caracteres.',
        'work_id.required' => 'Seleccione el trabajo al cual pertenece el pago.',
        'farms_id.required' => 'Seleccione la finca a la cual pertenece el pago.',
        'user_veterinarian_charge_id.required' => 'El veterinario asignado es requerido.',
    ];

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();
        try {
            DB::beginTransaction();
            // Actualizar el saldo pendiente automáticamente
            $this->outstanding_balance = (int)$this->outstanding_balance  - (int)$this->amount_received;
            // Construir el mensaje de notas
            $notes = "El dia " . date("d-m-Y", strtotime($this->payment_receipt_date)) . " se recibio $" . $this->amount_received;
            $notes .= " de un total de $" . $this->total_work_balance . " con un saldo pendiente de $" . $this->outstanding_balance;
            
            $paymentHistory = PaymentHistory::find($this->paymentHistory_id);
            $paymentHistory->update([
                'payment_receipt_date' => $this->payment_receipt_date,
                'amount_received' => $this->amount_received,
                'outstanding_balance' => $this->outstanding_balance,
                'total_work_balance' => $this->total_work_balance,
                'fast_notes' => strtoupper($paymentHistory->fast_notes . "\n" . $notes), // Asignar el nuevo valor concatenando el mensaje anterior con el nuevo
                // 'work_id' => $this->work_id,
                // 'farms_id' => $this->farms_id,
                // 'user_veterinarian_charge_id' => $this->user_veterinarian_charge_id,
            ]);
            // Obtener el registro de la granja relacionada
            $farm = Farm::find($this->farms_id);
            // Actualizar el campo total_debt de la granja
            $farm->total_debt -= (int)$this->amount_received;
            $farm->save();

            DB::commit();

            session()->flash('actualizar', '¡Actualización exitosa!');
            $encodedSearch = http_build_query(['search' => $this->search, 'page' => $this->page,]);
            $this->redirect('/pagos?' . $encodedSearch, navigate: true);
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
        $paymentHistory = PaymentHistory::where('id', $id)->first();

        $this->paymentHistory_id = $id;
        // $this->payment_receipt_date = $paymentHistory->payment_receipt_date;
        // $this->amount_received = $paymentHistory->amount_received;
        $this->outstanding_balance = $paymentHistory->outstanding_balance;
        $this->total_work_balance = $paymentHistory->total_work_balance;
        $this->fast_notes = $paymentHistory->fast_notes;
        $this->work_id = $paymentHistory->work_id;
        $this->farms_id = $paymentHistory->farms_id;
        $this->user_veterinarian_charge_id = $paymentHistory->user_veterinarian_charge_id;
    }

    public function render()
    {
        abort_if(Gate::denies('pagos_admin'), 403);
        $works = Work::get();
        $farms = Farm::get();
        $userVeterinarians = User::role(['Veterinario'])->get();
        return view('livewire.payment-historys.edit', compact('works', 'farms', 'userVeterinarians'))->extends('components.layouts.app')->section('content');
    }
}
