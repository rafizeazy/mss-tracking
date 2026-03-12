<?php

namespace App\Livewire\Customer;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard Pelanggan')]
#[Layout('layouts.app')] 
class Dashboard extends Component
{
    public $customer;

    public function mount()
    {
        $this->customer = auth()->user()->customer;
    }

    public function render()
    {
        return view('livewire.customer.dashboard');
    }
}