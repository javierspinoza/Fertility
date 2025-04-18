<?php

namespace App\Livewire\Farms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Farm;
use App\Models\User;

use Livewire\Component;

class Create extends Component
{
    //definimos unas variables
    public $name, $total_debt, $fast_notes, $user_owner_id,
    $user_veterinarian_charge_id, $farm_id;
    public $search;
    // para las validaciones de campos unicos y en tiempo real
    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'fast_notes' => 'max:1300',
            'user_owner_id' => 'required',
            'user_veterinarian_charge_id' => 'required',
        ];
    }
    protected $messages = [
        'name.required' => 'El nombre es requerido.',
        'name.min' => 'Pon almenos 3 caracteres',
        'name.max' => 'máximo 255 caracteres',
        'fast_notes.max' => 'No puedes poner mas de 1300 caracteres.',
        'user_owner_id.required' => 'El dueño de la ganaderia es requerido.',
        'user_veterinarian_charge_id.required' => 'El veterinario asignado es requerido.',
    ];

    public function store()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();
        try {
            $farm = Farm::create([
                'name' => strtoupper($this->name),
                'fast_notes' => strtoupper($this->fast_notes),
                'user_owner_id' => $this->user_owner_id,
                'user_veterinarian_charge_id' => $this->user_veterinarian_charge_id,
            ]);

            // Set Flash Message
            // $this->dispatch('crearRegistro');
            session()->flash('crearRegistro', '¡Registro exitoso!');
            $encodedSearch = http_build_query(['search' => $this->search]);
            $this->redirect('/fincas?'. $encodedSearch , navigate: true);
        } catch (\Throwable $th) {
            // Set Flash Message
            $this->dispatch('MatchErrorData');
        }
    }

    public function mount( Request $request)
    {
        $this->search = $request->query('search');
    }

    public function render()
    {
        abort_if(Gate::denies('fincas_admin'), 403);
        $userFarms = User::role(['Dueño_Finca'])->get();
        $userVeterinarians = User::role(['Veterinario'])->get();
        return view('livewire.farms.create', compact('userFarms', 'userVeterinarians'))->extends('components.layouts.app')->section('content');
    }
}
