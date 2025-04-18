<?php

namespace App\Livewire\Users;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Models\User;

use Livewire\Component;

class Show extends Component
{
    public $name, $email, $created_at, $user_id, $user, $distribution_id;
    public $assignRol=[];
    public $search;

    public function mount($id, Request $request) {
        $this->search = $request->query('search');
        $user = User::where('id', $id)->first();
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->created_at = $user->created_at;
        $this->assignRol = [];
    }

    public function render()
    {
        abort_if(Gate::denies('user_show'), 403);
        $roles = Role::where('id', '>', 1)->get();
        $user = User::find($this->user_id);
        // Obtener los nombres de los roles asignados al usuario
        $assignedRoles = $user->roles->pluck('name')->toArray();
        return view('livewire.users.show', compact('roles', 'user', 'assignedRoles'))->extends('components.layouts.app')->section('content');
    }
}
