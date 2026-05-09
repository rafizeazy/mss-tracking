<?php

namespace App\Livewire\AuditLog;

use App\Enums\Role;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Audit Log Aktivitas')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $action = '';

    public string $role = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public int|string $userId = '';

    public int|string $customerId = '';

    public int $perPage = 15;

    public function updating(string $property): void
    {
        if (in_array($property, ['search', 'action', 'role', 'dateFrom', 'dateTo', 'userId', 'customerId', 'perPage'], true)) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'action', 'role', 'dateFrom', 'dateTo', 'userId', 'customerId']);
        $this->perPage = 15;
        $this->resetPage();
    }

    public function getLogsProperty(): LengthAwarePaginator
    {
        return ActivityLog::query()
            ->with(['user', 'customer'])
            ->when($this->search !== '', function (Builder $query): void {
                $query->where(function (Builder $query): void {
                    $query->where('description', 'like', '%'.$this->search.'%')
                        ->orWhere('reason', 'like', '%'.$this->search.'%')
                        ->orWhere('action', 'like', '%'.$this->search.'%')
                        ->orWhereHas('customer', function (Builder $query): void {
                            $query->where('company_name', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('user', function (Builder $query): void {
                            $query->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->when($this->action !== '', fn (Builder $query): Builder => $query->where('action', $this->action))
            ->when($this->role !== '', function (Builder $query): void {
                $query->whereHas('user', fn (Builder $query): Builder => $query->where('role', $this->role));
            })
            ->when($this->userId !== '', fn (Builder $query): Builder => $query->where('user_id', $this->userId))
            ->when($this->customerId !== '', fn (Builder $query): Builder => $query->where('customer_id', $this->customerId))
            ->when($this->dateFrom !== '', fn (Builder $query): Builder => $query->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo !== '', fn (Builder $query): Builder => $query->whereDate('created_at', '<=', $this->dateTo))
            ->latest()
            ->paginate($this->perPage);
    }

    public function getActionsProperty()
    {
        return ActivityLog::query()
            ->select('action')
            ->whereNotNull('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');
    }

    public function getActionLabelsProperty(): array
    {
        return [
            'baa.approved' => 'Menyetujui BAA',
            'baa.generated' => 'Membuat BAA',
            'baa.rejected' => 'Menolak BAA',
            'baa.sent_to_customer' => 'BAA dikirim ke pelanggan',
            'baa_signed.uploaded' => 'BAA bertanda tangan diupload',
            'customer.reactivated' => 'Pelanggan diaktifkan kembali',
            'customer.stopped' => 'Pelanggan Diberhentikan',
            'customer.updated' => 'Data Pelanggan Diperbarui',
            'installation.finished' => 'Instalasi Selesai',
            'invoice.preview_generated' => 'Membuat Invoice',
            'invoice.sent' => 'Invoice Dikirim',
            'payment.approved' => 'Pembayaran Disetujui',
            'payment_proof.uploaded' => 'Mengirim Bukti Pembayaran',
            'registration.approved' => 'Registrasi Disetujui',
            'registration.cancelled' => 'Registrasi Dibatalkan',
            'registration.created' => 'Registrasi Dibuat',
            'registration.rejected' => 'Registrasi Ditolak',
            'registration.sent_to_noc' => 'SPK dikirim ke NOC',
            'registration.soft_deleted' => 'Registrasi Dihapus Sementara',
            'service.restored' => 'Layanan Dipulihkan',
            'service.soft_deleted' => 'Layanan Dihapus Sementara',
        ];
    }

    public function actionLabel(?string $action): string
    {
        if (! $action) {
            return '-';
        }

        return $this->actionLabels[$action] ?? str($action)->replace(['.', '_'], ' ')->title()->toString();
    }

    public function getUsersProperty()
    {
        $userIds = ActivityLog::query()
            ->whereNotNull('user_id')
            ->distinct()
            ->pluck('user_id');

        return User::query()
            ->whereIn('id', $userIds)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }

    public function getCustomersProperty()
    {
        $customerIds = ActivityLog::query()
            ->whereNotNull('customer_id')
            ->distinct()
            ->pluck('customer_id');

        return Customer::withTrashed()
            ->whereIn('id', $customerIds)
            ->orderBy('company_name')
            ->get(['id', 'company_name']);
    }

    public function getRolesProperty(): array
    {
        return Role::cases();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.audit-log.index', [
            'logs' => $this->logs,
            'actions' => $this->actions,
            'actionLabels' => $this->actionLabels,
            'users' => $this->users,
            'customers' => $this->customers,
            'roles' => $this->roles,
        ]);
    }
}
