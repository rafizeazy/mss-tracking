<?php

namespace App\Livewire\Marketing\Request;

use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Marketing - Tracking Pengajuan')]
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

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        
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

    public function approveRequest()
    {
        if (!$this->selectedRequest) return;

        $this->selectedRequest->update([
            'status' => 'disetujui',
        ]);

        $this->closeModal();
        $this->dispatch('notify', type: 'success', message: 'Pengajuan berhasil disetujui! Sistem siap mencetak PDF.');
    }

    public function rejectRequest()
    {
        if (!$this->selectedRequest) return;

        $this->selectedRequest->update([
            'status' => 'ditolak',
        ]);

        $this->closeModal();
        $this->dispatch('notify', type: 'error', message: 'Pengajuan telah ditolak.');
    }

    public function render()
    {
        $requests = ServiceRequest::with('customer')
            ->where('status', '!=', 'selesai')
            ->where(function($query) {
                if ($this->search) {
                    $query->where('request_number', 'like', '%' . $this->search . '%')
                          ->orWhereHas('customer', function($q) {
                              $q->where('company_name', 'like', '%' . $this->search . '%');
                          });
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.marketing.request.index', [
            'requests' => $requests
        ]);
    }
}