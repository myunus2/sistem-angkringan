<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\On;

class AdminNotifications extends Component
{
    public $pendingCount = 0;

    public function mount()
    {
        $this->loadData();
    }

    #[On('echo:orders,OrderCreated')]
    public function handleOrderCreated($event)
    {
        $this->loadData();
        $this->dispatch('play-notification-sound');
    }

    public function loadData()
    {
        $this->pendingCount = Order::where('status', 'pending')->count();
    }

    public function render()
    {
        return view('livewire.admin-notifications');
    }
}
