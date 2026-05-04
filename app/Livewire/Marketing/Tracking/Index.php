<?php

namespace App\Livewire\Marketing\Tracking;

use App\Events\CustomerUpdated;
use App\Models\ActivityLog;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Tracking Registrasi Pelanggan')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $showCancelled = false;

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

    public function toggleCancelled()
    {
        $this->showCancelled = ! $this->showCancelled;
        $this->resetPage();
    }

    #[On('echo-private:mss-updates,CustomerUpdated')]
    public function refreshData() {}

    public function deleteCancelledRegistration(int $id): void
    {
        $customer = Customer::whereIn('status', ['dibatalkan', 'ditolak'])->findOrFail($id);

        ActivityLog::record('registration.soft_deleted', 'Data registrasi batal atau ditolak dihapus sementara.', $customer, $customer->status_reason);
        $customer->delete();

        if (class_exists(CustomerUpdated::class)) {
            broadcast(new CustomerUpdated);
        }

        $this->dispatch('notify', type: 'success', message: 'Data registrasi batal berhasil dihapus.');
    }

    public function render()
    {
        $query = Customer::with(['user', 'service', 'invoiceRegistrasi', 'baa'])
            ->whereHas('service');

        if ($this->showCancelled) {
            $query->whereIn('status', ['dibatalkan', 'ditolak']);
        } else {
            $query->whereNotIn('status', ['selesai', 'berhenti', 'dibatalkan', 'ditolak']);
        }

        $customers = $query->when($this->search, function ($q) {
            $q->where(function ($sub) {
                $sub->where('company_name', 'like', '%'.$this->search.'%')
                    ->orWhere('phone', 'like', '%'.$this->search.'%');
            });
        })
            ->latest()
            ->paginate(10);

        return view('livewire.marketing.tracking.index', [
            'customers' => $customers,
        ]);
    }
}
