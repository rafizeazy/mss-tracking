<?php

namespace App\Livewire\Customer;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Data Pelanggan')]
#[Layout('layouts.app')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.customer.index');
    }
}