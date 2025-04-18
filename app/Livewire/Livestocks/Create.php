<?php

namespace App\Livewire\Livestocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Livestock;
use App\Models\Farm;

use Livewire\Component;

class Create extends Component
{
    //definimos unas variables
    public $type_livestock, $state_productive, $fast_notes, $farms_id, $livestock_id;
    public $search;
    // para las validaciones de campos unicos y en tiempo real
    protected function rules()
    {
        return [
            'type_livestock' => 'required',
            'state_productive' => 'required',
            'fast_notes' => 'max:1300',
            'farms_id' => 'required',
        ];
    }
    protected $messages = [
        'type_livestock.required' => 'El tipo de ganado es requerido.',
        'state_productive.required' => 'El estado productivo es requerido.',
        'fast_notes.max' => 'No puedes poner mas de 1300 caracteres.',
        'farms_id.required' => 'Por favor selecciona la finca a la que pertenece.',
    ];

    public function store()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();
        try {
            $livestock = Livestock::create([
                'type_livestock' => strtoupper($this->type_livestock),
                'state_productive' => strtoupper($this->state_productive),
                'fast_notes' => strtoupper($this->fast_notes),
                'farms_id' => $this->farms_id,
            ]);

            // Set Flash Message
            // $this->dispatch('crearRegistro');
            session()->flash('crearRegistro', '¡Registro exitoso!');
            $encodedSearch = http_build_query(['search' => $this->search]);
            $this->redirect('/ganaderia?'. $encodedSearch , navigate: true);
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
        abort_if(Gate::denies('ganado_admin'), 403);
        $farms = Farm::get();
        return view('livewire.livestocks.create', compact('farms'))->extends('components.layouts.app')->section('content');
    }
}
