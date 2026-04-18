<?php

namespace App\Livewire\Finance\Request;

use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Finance - Data Pengajuan Layanan')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

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

    public function render()
    {
        $requests = ServiceRequest::with('customer')
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

        return view('livewire.finance.request.index', [
            'requests' => $requests
        ]);
    }
}