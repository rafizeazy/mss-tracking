<?php

namespace App\Livewire\Noc\Tracking;

use App\Models\CustomerService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('NOC - Tracking SPK Instalasi')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[On('trigger-search')]
    public function updateSearch($query): void
    {
        $this->search = $query;
        $this->resetPage();
    }

    #[On('echo-private:mss-updates,CustomerUpdated')]
    public function refreshTabel(): void {}

    public function render()
    {
        $services = CustomerService::with(['customer.user', 'spk', 'baa'])
            ->whereIn('status', [
                'proses_instalasi',
                'proses_aktivasi',
                'review_baa',
                'menunggu_baa',
                'verifikasi_baa',
            ])
            ->whereHas('customer', function ($query) {
                if ($this->search) {
                    $query->where(function ($q) {
                        $q->where('company_name', 'like', '%'.$this->search.'%')
                            ->orWhere('phone', 'like', '%'.$this->search.'%');
                    });
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.noc.tracking.index', [
            'services' => $services,
        ]);
    }
}
