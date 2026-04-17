<?php

namespace App\Livewire\Noc\Request;

use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('NOC - Tracking Pengajuan')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $selectedRequest = null;

    #[On('trigger-search')]
    public function updateSearch($query)
    {
        $this->search = $query;
        $this->resetPage();
    }

    public function viewRequest($id)
    {
        $this->selectedRequest = ServiceRequest::with('customer.user')->find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedRequest = null;
    }

    public function render()
    {
        $requests = ServiceRequest::with(['customer.user'])
            ->whereIn('status', [
                'proses_upgrade',
                'pembuatan_bau',
                'menunggu_ttd_bau',
                'verifikasi_ttd_bau'
            ])
            ->where(function($query) {
                if ($this->search) {
                    $query->where('request_number', 'like', '%' . $this->search . '%')
                          ->orWhereHas('customer', function($q) {
                              $q->where('company_name', 'like', '%' . $this->search . '%');
                          });
                }
            })
            ->orderByRaw("FIELD(status, 'proses_upgrade', 'pembuatan_bau', 'menunggu_ttd_bau', 'verifikasi_ttd_bau')")
            ->latest()
            ->paginate(10);

        return view('livewire.noc.request.index', [
            'requests' => $requests
        ]);
    }
}