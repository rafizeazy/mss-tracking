<?php

namespace App\Livewire\Finance\Request;

use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Finansial Pengajuan')]
#[Layout('layouts.app')]
class Show extends Component
{
    public ServiceRequest $request;

    public function mount($id)
    {
        $this->request = ServiceRequest::with(['customer.user', 'bau'])->findOrFail($id);
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        $this->request->refresh();
    }

    public function render()
    {
        return view('livewire.finance.request.show');
    }
}