<?php

namespace App\Livewire\Finance;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Provisioning Tracking')]
#[Layout('layouts.app')]
class Tracking extends Component
{
    public function render()
    {
        return view('livewire.finance.tracking');
    }
}