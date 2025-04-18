<?php

namespace App\Livewire\Farms;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Farm;
use App\Models\User;

use Livewire\Component;

class Edit extends Component
{
    //definimos unas variables
    public $name, $total_debt, $fast_notes, $user_owner_id,
    $user_veterinarian_charge_id, $farm_id;
    public $search;
    public $page;
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

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();
        try {
            $farm = Farm::find($this->farm_id);
            $farm->update([
                'name' => strtoupper($this->name),
                'fast_notes' => strtoupper($this->fast_notes),
                'user_owner_id' => $this->user_owner_id,
                'user_veterinarian_charge_id' => $this->user_veterinarian_charge_id,
            ]);
            session()->flash('actualizar', '¡Actualización exitosa!');
            $encodedSearch = http_build_query(['search' => $this->search, 'page' => $this->page,]);
            $this->redirect('/fincas?' . $encodedSearch, navigate: true);
        } catch (\Throwable $th) {
            $this->dispatch('MatchErrorData');
        }
    }

    public function mount($id, Request $request)
    {
        $this->search = $request->query('search');
        $this->page = $request->query('page', 1);
        $farm = Farm::where('id', $id)->first();

        $this->farm_id = $id;
        $this->name = $farm->name;
        $this->fast_notes = $farm->fast_notes;
        $this->user_owner_id = $farm->user_owner_id;
        $this->user_veterinarian_charge_id = $farm->user_veterinarian_charge_id;
    }

    public function render()
    {
        abort_if(Gate::denies('fincas_admin'), 403);
        $userFarms = User::role(['Dueño_Finca'])->get();
        $userVeterinarians = User::role(['Veterinario'])->get();
        return view('livewire.farms.edit', compact('userFarms', 'userVeterinarians'))->extends('components.layouts.app')->section('content');
    }
}
