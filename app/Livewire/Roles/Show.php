<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Show extends Component
{
    //definimos unas variables
    public $name, $selectedPermissions = [], $role_id;
    public $viewCreateEdit = 0;
    public $search;
    public $page;

    public function mount(Request $request, $role_id)
    {
        $this->search = $request->query('search');
        $role = Role::findOrFail($role_id);
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function render()
    {
        abort_if(Gate::denies('role_admin'), 403);
        return view('livewire.roles.show', [
            'selectedPermissions' => $this->selectedPermissions,
        ])->extends('components.layouts.app')->section('content');
    }
}
