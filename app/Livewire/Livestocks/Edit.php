<?php

namespace App\Livewire\Livestocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Livestock;
use App\Models\Farm;

use Livewire\Component;

class Edit extends Component
{
    //definimos unas variables
    public $type_livestock, $state_productive, $fast_notes, $farms_id, $livestock_id;
    public $search;
    public $page;
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

    public function update()
    {
        // para que funcionen las validaciones
        $validatedData = $this->validate();
        try {
            $livestock = Livestock::find($this->livestock_id);
            $livestock->update([
                'type_livestock' => strtoupper($this->type_livestock),
                'state_productive' => strtoupper($this->state_productive),
                'fast_notes' => strtoupper($this->fast_notes),
                'farms_id' => $this->farms_id,
            ]);
            session()->flash('actualizar', '¡Actualización exitosa!');
            $encodedSearch = http_build_query(['search' => $this->search, 'page' => $this->page,]);
            $this->redirect('/ganaderia?' . $encodedSearch, navigate: true);
        } catch (\Throwable $th) {
            $this->dispatch('MatchErrorData');
        }
    }

    public function mount($id, Request $request)
    {
        $this->search = $request->query('search');
        $this->page = $request->query('page', 1);
        $livestock = Livestock::where('id', $id)->first();

        $this->livestock_id = $id;
        $this->type_livestock = $livestock->type_livestock;
        $this->state_productive = $livestock->state_productive;
        $this->fast_notes = $livestock->fast_notes;
        $this->farms_id = $livestock->farms_id;
    }

    public function render()
    {
        abort_if(Gate::denies('ganado_admin'), 403);
        $farms = Farm::get();
        return view('livewire.livestocks.edit', compact('farms'))->extends('components.layouts.app')->section('content');
    }
}
