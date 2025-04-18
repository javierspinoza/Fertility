<?php

namespace App\Livewire\Notifications;
use Illuminate\Support\Facades\Gate;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

use Livewire\Component;

class Index extends Component
{
    public $notifications;

    public function mount()
    {
        $this->notifications = auth()->user()->unreadNotifications;
    }

    public function markAsReadOne($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $this->notifications = auth()->user()->unreadNotifications;

        // Set Flash Message
        session()->flash('readok', 'Notificación marcada como leída correctamente!!');
        return $this->redirect('/notifys', navigate: true);
    }

    public function markAllAsRead()
    {
        foreach ($this->notifications as $notification) {
            $notification->markAsRead();
        }

        $this->notifications = auth()->user()->unreadNotifications;

        // Set Flash Message
        // $this->dispatchBrowserEvent('alert',[
        //     'type'=>'success',
        //     'message'=>"Notificaciones marcadas como leídas correctamente!!"
        // ]);
    }

    public function render()
    {
        abort_if(Gate::denies('notificacion_admin'), 403);
        $now = Carbon::now();
        $startRange = $now->copy()->subHours(11);
        $endRange = $now->copy()->addHours(36);

        $unreadNotifications = $this->notifications->filter(function ($notification) use ($startRange, $endRange) {
            $notificationDate = Carbon::parse($notification->data['date_work']);
            return $notificationDate->between($startRange, $endRange) && !$notification->read_at;
        });

        return view('livewire.notifications.index', compact('unreadNotifications'))->extends('components.layouts.app')->section('content');
    }
}
