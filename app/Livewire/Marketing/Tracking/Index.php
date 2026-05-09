<?php

namespace App\Livewire\Marketing\Tracking;

use App\Enums\Role;
use App\Events\CustomerUpdated;
use App\Models\ActivityLog;
use App\Models\CustomerService;
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

    public ?int $deletingCancelledServiceId = null;

    public string $deleteReason = '';

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

    public function confirmDeleteCancelledRegistration(int $id): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $this->deletingCancelledServiceId = $id;
        $this->deleteReason = '';
    }

    public function cancelDeleteCancelledRegistration(): void
    {
        $this->deletingCancelledServiceId = null;
        $this->deleteReason = '';
    }

    public function deleteCancelledRegistration(?int $id = null): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $this->deletingCancelledServiceId = $id ?? $this->deletingCancelledServiceId;

        $this->validate([
            'deleteReason' => 'required|string|min:5',
        ], [
            'deleteReason.required' => 'Alasan hapus wajib diisi.',
            'deleteReason.min' => 'Alasan hapus minimal 5 karakter.',
        ]);

        $service = CustomerService::with('customer')
            ->whereIn('status', ['dibatalkan', 'ditolak'])
            ->findOrFail($this->deletingCancelledServiceId);

        ActivityLog::record('registration.soft_deleted', 'Data registrasi batal atau ditolak dihapus sementara.', $service->customer, $this->deleteReason, [
            'service_id' => $service->id,
            'bandwidth' => $service->bandwidth,
            'status' => $service->status,
            'status_reason' => $service->status_reason,
        ]);

        $service->delete();

        if (class_exists(CustomerUpdated::class)) {
            broadcast(new CustomerUpdated);
        }

        $this->cancelDeleteCancelledRegistration();
        $this->dispatch('notify', type: 'success', message: 'Data registrasi batal berhasil dihapus.');
    }

    public function render()
    {
        $query = CustomerService::with(['customer.user', 'invoiceRegistrasi', 'baa']);

        if ($this->showCancelled) {
            $query->whereIn('status', ['dibatalkan', 'ditolak']);
        } else {
            $query->whereNotIn('status', ['selesai', 'berhenti', 'dibatalkan', 'ditolak']);
        }

        $customers = $query->when($this->search, function ($q) {
            $q->whereHas('customer', function ($sub) {
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

    private function isSuperAdmin(): bool
    {
        return auth()->user()?->role === Role::SuperAdmin;
    }
}
