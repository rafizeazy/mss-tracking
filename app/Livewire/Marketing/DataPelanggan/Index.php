<?php

namespace App\Livewire\Marketing\DataPelanggan;

use App\Enums\Role;
use App\Events\CustomerUpdated;
use App\Models\ActivityLog;
use App\Models\CustomerService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Marketing - Data Pelanggan Aktif')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithFileUploads, WithPagination;

    public $search = '';

    public $showModal = false;

    public $selectedService = null;

    public $isEditingCustomer = false;

    public $editData = [];

    public $editingCustomerId = null;

    public $new_ktp_path;

    public $new_npwp_path;

    public $new_nib_path;

    public $new_certificate_path;

    public $showArsipModal = false;

    public $serviceForArsip = null;

    public $showBerhentiOnly = false;

    public bool $showDeletedOnly = false;

    public $stoppingServiceId = null;

    public string $stopReason = '';

    public ?int $deletingServiceId = null;

    public string $deleteReason = '';

    public array $collapsedCustomerIds = [];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[On('trigger-search')]
    public function updateSearch($query)
    {
        $this->search = $query;
        $this->resetPage();
    }

    public function viewDetail($id)
    {
        $this->selectedService = CustomerService::with(['customer.user', 'spk', 'baa', 'invoiceRegistrasi'])->find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedService = null;
    }

    public function toggleDeletedOnly(): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $this->showDeletedOnly = ! $this->showDeletedOnly;
        $this->showBerhentiOnly = false;
        $this->resetPage();
    }

    public function toggleCustomerGroup(int $customerId): void
    {
        if (in_array($customerId, $this->collapsedCustomerIds, true)) {
            $this->collapsedCustomerIds = array_values(array_diff($this->collapsedCustomerIds, [$customerId]));

            return;
        }

        $this->collapsedCustomerIds[] = $customerId;
    }

    public function openArsip($id)
    {
        $this->serviceForArsip = CustomerService::with(['customer', 'spk', 'baa', 'invoiceRegistrasi'])->find($id);
        $this->showArsipModal = true;
    }

    public function closeArsip()
    {
        $this->showArsipModal = false;
        $this->serviceForArsip = null;
    }

    public function editCustomer($id)
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $serviceToEdit = CustomerService::with(['customer.user', 'spk', 'baa', 'invoiceRegistrasi'])->findOrFail($id);
        $customerToEdit = $serviceToEdit->customer;

        $this->selectedService = $serviceToEdit;

        $this->editData = [
            'user_name' => $customerToEdit->user->name ?? '',
            'user_email' => $customerToEdit->user->email ?? '',
            'phone' => $customerToEdit->phone,
            'ktp_number' => $customerToEdit->ktp_number,
            'gender' => $customerToEdit->gender,
            'position' => $customerToEdit->position,

            'bandwidth' => $serviceToEdit->bandwidth ?? '',
            'term_of_service' => $serviceToEdit->term_of_service ?? '',
            'service_type' => $serviceToEdit->service_type ?? '',
            'installation_address' => $serviceToEdit->installation_address ?? $customerToEdit->installation_address,
            'customer_type' => $serviceToEdit->spk->customer_type ?? '',
            'activation_date' => $serviceToEdit->baa && $serviceToEdit->baa->activation_date ? $serviceToEdit->baa->activation_date->format('Y-m-d') : null,
            'metro_link' => $serviceToEdit->metro_link ?? '',
            'sla' => $serviceToEdit->sla ?? '',
            'registration_fee' => (int) ($serviceToEdit->registration_fee ?? 0),
            'monthly_fee' => (int) ($serviceToEdit->monthly_fee ?? 0),

            'company_name' => $customerToEdit->company_name,
            'business_type' => $customerToEdit->business_type,
            'npwp_number' => $customerToEdit->npwp_number,
            'company_phone' => $customerToEdit->company_phone,
            'company_address' => $customerToEdit->company_address,
            'city' => $customerToEdit->city,
            'province' => $customerToEdit->province,
            'postal_code' => $customerToEdit->postal_code,
            'customer_number' => $customerToEdit->customer_number ?? '',
            'invoice_number' => $serviceToEdit->invoiceRegistrasi->invoice_number ?? '',
            'spk_number' => $serviceToEdit->spk->spk_number ?? '',
            'baa_number' => $serviceToEdit->baa->baa_number ?? '',

            'finance_name' => $customerToEdit->finance_name,
            'finance_email' => $customerToEdit->finance_email,
            'finance_phone' => $customerToEdit->finance_phone,
            'billing_address' => $customerToEdit->billing_address,

            'technical_name' => $customerToEdit->technical_name,
            'technical_email' => $customerToEdit->technical_email,
            'technical_phone' => $customerToEdit->technical_phone,

            'marketing_name' => $serviceToEdit->marketing_name ?? '',
            'marketing_phone' => $serviceToEdit->marketing_phone ?? '',
        ];

        $this->editingCustomerId = $customerToEdit->id;
        $this->isEditingCustomer = true;
    }

    public function updateCustomer()
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        if (! $this->selectedService && ! $this->isEditingCustomer) {
            return;
        }

        $serviceToUpdate = CustomerService::with(['customer.user', 'spk', 'baa', 'invoiceRegistrasi'])->find($this->selectedService->id);
        $customerToUpdate = $serviceToUpdate->customer;
        $userToUpdate = $customerToUpdate->user;

        $this->validate([
            'editData.user_name' => 'required|string|max:255',
            'editData.user_email' => 'required|email|max:255',
            'editData.phone' => 'required|string|max:20',
            'editData.ktp_number' => 'nullable|string',
            'editData.gender' => 'nullable|in:L,P',
            'editData.position' => 'nullable|string',

            'editData.bandwidth' => 'required|string',
            'editData.term_of_service' => 'nullable|numeric',
            'editData.service_type' => 'required|string',
            'editData.installation_address' => 'nullable|string',
            'editData.customer_type' => 'nullable|string',
            'editData.activation_date' => 'nullable|date',
            'editData.metro_link' => 'nullable|string',
            'editData.sla' => 'nullable|string',
            'editData.registration_fee' => 'nullable|numeric',
            'editData.monthly_fee' => 'nullable|numeric',

            'editData.company_name' => 'required|string|max:255',
            'editData.business_type' => 'nullable|string',
            'editData.npwp_number' => 'nullable|string',
            'editData.company_phone' => 'nullable|string|max:20',
            'editData.company_address' => 'required|string',
            'editData.city' => 'nullable|string',
            'editData.province' => 'nullable|string',
            'editData.postal_code' => 'nullable|string',
            'editData.customer_number' => 'nullable|string',
            'editData.invoice_number' => 'nullable|string',

            'editData.finance_name' => 'nullable|string|max:255',
            'editData.finance_email' => 'nullable|email|max:255',
            'editData.finance_phone' => 'nullable|string|max:20',
            'editData.billing_address' => 'nullable|string',

            'editData.technical_name' => 'nullable|string|max:255',
            'editData.technical_email' => 'nullable|email|max:255',
            'editData.technical_phone' => 'nullable|string|max:20',

            'editData.marketing_name' => 'nullable|string|max:255',
            'editData.marketing_phone' => 'nullable|string|max:20',

            'new_ktp_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'new_npwp_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'new_nib_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'new_certificate_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($userToUpdate) {
            $userToUpdate->update([
                'name' => $this->editData['user_name'],
                'email' => $this->editData['user_email'],
            ]);
        }

        $customerUpdateData = [
            'phone' => $this->editData['phone'],
            'ktp_number' => $this->editData['ktp_number'],
            'gender' => $this->editData['gender'],
            'position' => $this->editData['position'],
            'company_name' => $this->editData['company_name'],
            'business_type' => $this->editData['business_type'],
            'npwp_number' => $this->editData['npwp_number'],
            'company_phone' => $this->editData['company_phone'],
            'company_address' => $this->editData['company_address'],
            'city' => $this->editData['city'],
            'province' => $this->editData['province'],
            'postal_code' => $this->editData['postal_code'],
            'customer_number' => $this->editData['customer_number'],
            'finance_name' => $this->editData['finance_name'],
            'finance_email' => $this->editData['finance_email'],
            'finance_phone' => $this->editData['finance_phone'],
            'billing_address' => $this->editData['billing_address'],
            'technical_name' => $this->editData['technical_name'],
            'technical_email' => $this->editData['technical_email'],
            'technical_phone' => $this->editData['technical_phone'],
        ];

        if ($this->new_ktp_path) {
            $customerUpdateData['ktp_file_path'] = $this->new_ktp_path->store('documents/ktp', 'public');
        }
        if ($this->new_npwp_path) {
            $customerUpdateData['npwp_file_path'] = $this->new_npwp_path->store('documents/npwp', 'public');
        }
        if ($this->new_nib_path) {
            $customerUpdateData['nib_file_path'] = $this->new_nib_path->store('documents/nib', 'public');
        }
        if ($this->new_certificate_path) {
            $customerUpdateData['certificate_file_path'] = $this->new_certificate_path->store('documents/certificate', 'public');
        }

        $customerToUpdate->update($customerUpdateData);

        $serviceData = [
            'bandwidth' => $this->editData['bandwidth'],
            'term_of_service' => empty($this->editData['term_of_service']) ? null : $this->editData['term_of_service'],
            'service_type' => $this->editData['service_type'],
            'installation_address' => $this->editData['installation_address'],
            'metro_link' => $this->editData['metro_link'],
            'sla' => $this->editData['sla'],
            'registration_fee' => empty($this->editData['registration_fee']) ? 0 : $this->editData['registration_fee'],
            'monthly_fee' => empty($this->editData['monthly_fee']) ? 0 : $this->editData['monthly_fee'],
            'marketing_name' => $this->editData['marketing_name'],
            'marketing_phone' => $this->editData['marketing_phone'],
        ];

        $serviceToUpdate->update($serviceData);

        if ($serviceToUpdate->spk) {
            $serviceToUpdate->spk->update([
                'customer_type' => $this->editData['customer_type'],
            ]);
        }

        if ($serviceToUpdate->baa && ! empty($this->editData['activation_date'])) {
            $serviceToUpdate->baa->update([
                'activation_date' => $this->editData['activation_date'],
            ]);
        }

        if ($serviceToUpdate->invoiceRegistrasi) {
            $serviceToUpdate->invoiceRegistrasi->update([
                'invoice_number' => $this->editData['invoice_number'],
            ]);
        }

        if (class_exists(CustomerUpdated::class)) {
            broadcast(new CustomerUpdated);
        }

        ActivityLog::record('customer.updated', 'Data pelanggan dan layanan diperbarui.', $customerToUpdate, null, [
            'service_id' => $serviceToUpdate->id,
            'bandwidth' => $serviceToUpdate->bandwidth,
        ]);

        $this->selectedService->refresh();

        $this->isEditingCustomer = false;
        $this->editingCustomerId = null;
        $this->dispatch('notify', type: 'success', message: 'Arsip data pelanggan berhasil diperbarui!');
    }

    public function cancelEdit()
    {
        $this->isEditingCustomer = false;
        $this->reset(['new_ktp_path', 'new_npwp_path', 'new_nib_path', 'new_certificate_path']);
    }

    public function confirmBerhentikanPelanggan(int $id): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $this->stoppingServiceId = $id;
        $this->stopReason = '';
    }

    public function cancelBerhenti(): void
    {
        $this->stoppingServiceId = null;
        $this->stopReason = '';
    }

    public function berhentikanPelanggan(): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $this->validate([
            'stopReason' => 'required|string|min:5',
        ], [
            'stopReason.required' => 'Alasan berhenti wajib diisi.',
            'stopReason.min' => 'Alasan berhenti minimal 5 karakter.',
        ]);

        $service = CustomerService::with('customer')->findOrFail($this->stoppingServiceId);
        $service->moveToStatus('berhenti', $this->stopReason);

        ActivityLog::record('customer.stopped', 'Layanan pelanggan diberhentikan.', $service->customer, $this->stopReason, [
            'service_id' => $service->id,
            'bandwidth' => $service->bandwidth,
        ]);

        if (class_exists(CustomerUpdated::class)) {
            broadcast(new CustomerUpdated);
        }

        $this->cancelBerhenti();
        $this->dispatch('notify', type: 'success', message: 'Status pelanggan berhasil diubah menjadi Berhenti.');
    }

    public function aktifkanKembaliPelanggan(int $id): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $service = CustomerService::with('customer')->findOrFail($id);

        if ($service->status !== 'berhenti') {
            return;
        }

        $service->moveToStatus('selesai');

        ActivityLog::record('customer.reactivated', 'Layanan pelanggan diaktifkan kembali.', $service->customer, null, [
            'service_id' => $service->id,
            'bandwidth' => $service->bandwidth,
        ]);

        if (class_exists(CustomerUpdated::class)) {
            broadcast(new CustomerUpdated);
        }

        $this->dispatch('notify', type: 'success', message: 'Pelanggan berhasil diaktifkan kembali.');
    }

    public function confirmDeleteService(int $id): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $this->deletingServiceId = $id;
        $this->deleteReason = '';
    }

    public function cancelDeleteService(): void
    {
        $this->deletingServiceId = null;
        $this->deleteReason = '';
    }

    public function hapusPelangganBerhenti(int $id): void
    {
        $this->confirmDeleteService($id);
    }

    public function deleteService(): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $this->validate([
            'deleteReason' => 'required|string|min:5',
        ], [
            'deleteReason.required' => 'Alasan hapus wajib diisi.',
            'deleteReason.min' => 'Alasan hapus minimal 5 karakter.',
        ]);

        $service = CustomerService::with('customer')->findOrFail($this->deletingServiceId);

        ActivityLog::record('service.soft_deleted', 'Layanan pelanggan dihapus sementara.', $service->customer, $this->deleteReason, [
            'service_id' => $service->id,
            'bandwidth' => $service->bandwidth,
            'status' => $service->status,
        ]);

        $service->delete();

        if (class_exists(CustomerUpdated::class)) {
            broadcast(new CustomerUpdated);
        }

        $this->cancelDeleteService();
        $this->dispatch('notify', type: 'success', message: 'Layanan pelanggan berhasil dihapus sementara.');
    }

    public function restoreService(int $id): void
    {
        if (! $this->isSuperAdmin()) {
            abort(403);
        }

        $service = CustomerService::onlyTrashed()
            ->with('customer')
            ->findOrFail($id);

        $service->restore();

        ActivityLog::record('service.restored', 'Layanan pelanggan dipulihkan dari arsip hapus.', $service->customer, null, [
            'service_id' => $service->id,
            'bandwidth' => $service->bandwidth,
            'status' => $service->status,
        ]);

        if (class_exists(CustomerUpdated::class)) {
            broadcast(new CustomerUpdated);
        }

        $this->dispatch('notify', type: 'success', message: 'Layanan pelanggan berhasil dipulihkan.');
    }

    public function render()
    {
        $statusToFetch = $this->showBerhentiOnly ? 'berhenti' : 'selesai';

        $services = CustomerService::query()
            ->with(['customer.user', 'spk', 'baa', 'invoiceRegistrasi'])
            ->when($this->showDeletedOnly, fn ($query) => $query->onlyTrashed())
            ->when(! $this->showDeletedOnly, fn ($query) => $query->where('customer_services.status', $statusToFetch))
            ->when($this->search, function ($query): void {
                $query->where(function ($query): void {
                    $query->where('customer_services.bandwidth', 'like', '%'.$this->search.'%')
                        ->orWhere('customer_services.service_type', 'like', '%'.$this->search.'%')
                        ->orWhere('customer_services.marketing_name', 'like', '%'.$this->search.'%')
                        ->orWhere('customer_services.marketing_phone', 'like', '%'.$this->search.'%')
                        ->orWhereHas('customer', function ($query): void {
                            $query->where('company_name', 'like', '%'.$this->search.'%')
                                ->orWhere('customer_number', 'like', '%'.$this->search.'%')
                                ->orWhere('phone', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->whereHas('customer')
            ->join('customers', 'customers.id', '=', 'customer_services.customer_id')
            ->orderBy('customers.company_name')
            ->orderByDesc('customer_services.created_at')
            ->select('customer_services.*')
            ->paginate(10);

        return view('livewire.marketing.datapelanggan.index', [
            'services' => $services,
        ]);
    }

    private function isSuperAdmin(): bool
    {
        return auth()->user()?->role === Role::SuperAdmin;
    }
}
