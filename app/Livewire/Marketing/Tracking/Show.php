<?php

namespace App\Livewire\Marketing\Tracking;

use App\Events\CustomerUpdated;
use App\Mail\StatusPelangganBerubah;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Services\DocumentNumberService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

#[Title('Detail Tracking Registrasi')]
#[Layout('layouts.app')]
class Show extends Component
{
    use WithFileUploads;

    public CustomerService $service;

    public Customer $customer;

    public $service_type;

    public $bandwidth;

    public $monthly_fee;

    public $registration_fee;

    public $sla = '99.5%';

    public $metro_link;

    public $marketing_name;

    public $marketing_phone;

    public $job_type = 'Aktivasi Baru';

    public $customer_type = '';

    public $due_date;

    public $spk_notes = 'Tim NOC diminta untuk melakukan proses provisioning layanan sesuai detail di atas, termasuk konfigurasi perangkat jaringan, aktivasi layanan, serta memastikan konektivitas layanan berjalan dengan baik sebelum dilakukan serah terima kepada pelanggan.';

    public $isEditingCustomer = false;

    public $editData = [];

    public $new_ktp_path;

    public $new_npwp_path;

    public $new_nib_path;

    public $new_certificate_path;

    public string $rejectionReason = '';

    public string $cancellationReason = '';

    public bool $showCancellationModal = false;

    public bool $showSendToNocModal = false;

    public bool $showApproveBaaModal = false;

    public function mount($id): void
    {
        $this->service = CustomerService::with(['customer.user', 'spk'])->findOrFail($id);
        $this->customer = $this->service->customer;

        $this->service_type = $this->service->service_type ?? '';
        $this->bandwidth = $this->service->bandwidth ?? '';
        $this->metro_link = $this->service->metro_link ?? '';
        $this->marketing_name = auth()->user()->name;

        if ($this->service->spk) {
            $this->job_type = $this->service->spk->job_type;
            $this->customer_type = $this->service->spk->customer_type;
            $this->due_date = $this->service->spk->due_date;
            $this->spk_notes = $this->service->spk->notes;
        }
    }

    #[On('echo-private:mss-updates,CustomerUpdated')]
    public function refreshData(): void
    {
        $this->service->refresh();
        $this->customer->refresh();
    }

    public function editCustomer(): void
    {
        // Pastikan kita me-load seluruh relasi agar tidak null
        $this->service->loadMissing(['customer.user', 'customer.spk', 'customer.baa', 'customer.invoiceRegistrasi']);

        $this->editData = [
            'user_name' => $this->customer->user?->name ?? '',
            'user_email' => $this->customer->user?->email ?? '',

            'ktp_number' => $this->customer->ktp_number ?? '',
            'gender' => $this->customer->gender ?? '',
            'position' => $this->customer->position ?? '',
            'phone' => $this->customer->phone ?? '',

            'company_name' => $this->customer->company_name ?? '',
            'business_type' => $this->customer->business_type ?? '',
            'npwp_number' => $this->customer->npwp_number ?? '',
            'company_phone' => $this->customer->company_phone ?? '',
            'company_address' => $this->customer->company_address ?? '',
            'city' => $this->customer->city ?? '',
            'province' => $this->customer->province ?? '',
            'postal_code' => $this->customer->postal_code ?? '',

            'customer_number' => $this->customer->customer_number ?? '',
            'invoice_number' => $this->customer->invoiceRegistrasi?->invoice_number ?? '',
            'spk_number' => $this->customer->spk?->spk_number ?? '',
            'baa_number' => $this->customer->baa?->baa_number ?? '',

            'finance_name' => $this->customer->finance_name ?? '',
            'finance_email' => $this->customer->finance_email ?? '',
            'finance_phone' => $this->customer->finance_phone ?? '',
            'billing_address' => $this->customer->billing_address ?? '',

            'technical_name' => $this->customer->technical_name ?? '',
            'technical_email' => $this->customer->technical_email ?? '',
            'technical_phone' => $this->customer->technical_phone ?? '',

            'installation_address' => $this->service->installation_address ?? $this->customer->installation_address ?? '',
            'service_type' => $this->service->service_type ?? '',
            'bandwidth' => $this->service->bandwidth ?? '',
            'term_of_service' => $this->service->term_of_service ?? '',
            'metro_link' => $this->service->metro_link ?? '',

            'sla' => $this->service->sla ?? '',

            'registration_fee' => (int) ($this->service->registration_fee ?? 0),
            'monthly_fee' => (int) ($this->service->monthly_fee ?? 0),

            'customer_type' => $this->customer->spk?->customer_type ?? '',
            'activation_date' => $this->customer->baa?->activation_date ? $this->customer->baa->activation_date->format('Y-m-d') : null,

            'marketing_name' => $this->service->marketing_name ?? '',
            'marketing_phone' => $this->service->marketing_phone ?? '',
        ];

        $this->reset(['new_ktp_path', 'new_npwp_path', 'new_nib_path', 'new_certificate_path']);
        $this->isEditingCustomer = true;
    }

    public function updateCustomer(): void
    {
        $this->validate([
            // Tambahkan validasi untuk field yang baru agar bisa disimpan
            'editData.user_name' => 'required|string|max:255',
            'editData.ktp_number' => 'nullable|string',
            'editData.gender' => 'nullable|in:L,P',
            'editData.position' => 'nullable|string',
            'editData.phone' => 'required|string|max:20',

            'editData.company_name' => 'required|string|max:255',
            'editData.business_type' => 'nullable|string',
            'editData.npwp_number' => 'nullable|string',
            'editData.company_phone' => 'nullable|string|max:20',
            'editData.company_address' => 'required|string',
            'editData.city' => 'nullable|string',
            'editData.province' => 'nullable|string',
            'editData.postal_code' => 'nullable|string',

            'editData.customer_number' => 'nullable|string',
            'editData.customer_type' => 'nullable|string',
            'editData.activation_date' => 'nullable|date',

            'editData.finance_name' => 'nullable|string|max:255',
            'editData.finance_email' => 'nullable|email|max:255',
            'editData.finance_phone' => 'nullable|string|max:20',
            'editData.billing_address' => 'nullable|string',

            'editData.technical_name' => 'nullable|string|max:255',
            'editData.technical_email' => 'nullable|email|max:255',
            'editData.technical_phone' => 'nullable|string|max:20',

            'editData.installation_address' => 'nullable|string',

            'editData.service_type' => 'required|string',
            'editData.bandwidth' => 'required|string',
            'editData.term_of_service' => 'nullable|numeric',
            'editData.metro_link' => 'nullable|string',
            'editData.sla' => 'nullable|string', // Validasi SLA

            'editData.registration_fee' => 'nullable|numeric',
            'editData.monthly_fee' => 'nullable|numeric',
            'editData.marketing_name' => 'nullable|string|max:255',
            'editData.marketing_phone' => 'nullable|string|max:20',
            'new_ktp_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'new_npwp_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'new_nib_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'new_certificate_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // 1. Simpan Pembaruan Nama User (Tabel Users)
        if (isset($this->editData['user_name']) && $this->customer->user) {
            $this->customer->user->update(['name' => $this->editData['user_name']]);
        }

        // 2. Simpan Pembaruan Tipe Pelanggan (Tabel SPK)
        if (isset($this->editData['customer_type']) && $this->customer->spk) {
            $this->customer->spk->update(['customer_type' => $this->editData['customer_type']]);
        }

        // 3. Simpan Pembaruan Tanggal Aktivasi (Tabel BAA)
        if (! empty($this->editData['activation_date']) && $this->customer->baa) {
            $this->customer->baa->update(['activation_date' => $this->editData['activation_date']]);
        }

        // 4. Pisahkan Data Khusus Tabel Customer Services (SLA ditambahkan ke sini)
        $serviceData = Arr::only($this->editData, [
            'service_type', 'bandwidth', 'term_of_service', 'metro_link', 'sla',
            'registration_fee', 'monthly_fee', 'marketing_name', 'marketing_phone', 'installation_address',
        ]);

        $serviceData['registration_fee'] = empty($serviceData['registration_fee']) ? 0 : $serviceData['registration_fee'];
        $serviceData['monthly_fee'] = empty($serviceData['monthly_fee']) ? 0 : $serviceData['monthly_fee'];
        $serviceData['term_of_service'] = empty($serviceData['term_of_service']) ? null : $serviceData['term_of_service'];

        $this->service->update($serviceData);
        $this->forgetSpkPdfCache();
        $this->forgetBaaPdfCache();

        // 5. Pisahkan Data Tabel Customers, cegah error relasi ter-copy
        $updateData = Arr::except($this->editData, [
            'user_name', 'user_email', 'invoice_number', 'spk_number', 'baa_number',
            'service_type', 'bandwidth', 'term_of_service', 'metro_link', 'sla',
            'registration_fee', 'monthly_fee', 'marketing_name', 'marketing_phone', 'installation_address',
            'customer_type', 'activation_date',
        ]);

        // Proses Pembaruan Dokumen Pendukung
        if ($this->new_ktp_path) {
            if ($this->customer->ktp_file_path) {
                Storage::disk('public')->delete($this->customer->ktp_file_path);
            }
            $updateData['ktp_file_path'] = $this->new_ktp_path->store('customer_documents', 'public');
        }
        if ($this->new_npwp_path) {
            if ($this->customer->npwp_file_path) {
                Storage::disk('public')->delete($this->customer->npwp_file_path);
            }
            $updateData['npwp_file_path'] = $this->new_npwp_path->store('customer_documents', 'public');
        }
        if ($this->new_nib_path) {
            if ($this->customer->nib_file_path) {
                Storage::disk('public')->delete($this->customer->nib_file_path);
            }
            $updateData['nib_file_path'] = $this->new_nib_path->store('customer_documents', 'public');
        }
        if ($this->new_certificate_path) {
            if ($this->customer->certificate_file_path) {
                Storage::disk('public')->delete($this->customer->certificate_file_path);
            }
            $updateData['certificate_file_path'] = $this->new_certificate_path->store('customer_documents', 'public');
        }

        $this->customer->update($updateData);
        $this->forgetBaaPdfCache();

        $this->broadcastCustomerUpdatedSafely();
        $this->customer->refresh();
        $this->service->refresh();

        $this->isEditingCustomer = false;
        $this->reset(['new_ktp_path', 'new_npwp_path', 'new_nib_path', 'new_certificate_path']);
        $this->dispatch('notify', type: 'success', message: 'Seluruh data profil & lampiran pelanggan berhasil diperbarui!');
    }

    public function cancelEdit(): void
    {
        $this->isEditingCustomer = false;
        $this->reset(['new_ktp_path', 'new_npwp_path', 'new_nib_path', 'new_certificate_path']);
    }

    public function openCancellationModal(): void
    {
        $this->resetValidation('cancellationReason');
        $this->showCancellationModal = true;
    }

    public function closeCancellationModal(): void
    {
        $this->resetValidation('cancellationReason');
        $this->cancellationReason = '';
        $this->showCancellationModal = false;
    }

    public function openSendToNocModal(): void
    {
        $this->showSendToNocModal = true;
    }

    public function closeSendToNocModal(): void
    {
        $this->showSendToNocModal = false;
    }

    public function openApproveBaaModal(): void
    {
        $this->showApproveBaaModal = true;
    }

    public function closeApproveBaaModal(): void
    {
        $this->showApproveBaaModal = false;
    }

    public function approve(): void
    {
        $this->validate([
            'service_type' => 'required|string|max:255',
            'bandwidth' => 'required|string|max:255',
            'monthly_fee' => 'required|numeric|min:0',
            'registration_fee' => 'required|numeric|min:0',
            'sla' => 'required|string|max:50',
            'metro_link' => 'required|string|max:255',
            'marketing_name' => 'required|string|max:255',
            'marketing_phone' => 'required|string|max:20',
        ]);

        $this->service->update([
            'service_type' => $this->service_type,
            'bandwidth' => $this->bandwidth,
            'monthly_fee' => $this->monthly_fee,
            'registration_fee' => $this->registration_fee,
            'sla' => $this->sla,
            'metro_link' => $this->metro_link,
            'marketing_name' => $this->marketing_name,
            'marketing_phone' => $this->marketing_phone,
        ]);

        $this->service->moveToStatus('menunggu_invoice');

        $this->recordActivitySafely('registration.approved', 'Registrasi disetujui oleh Marketing.');

        $this->broadcastCustomerUpdatedSafely();

        Mail::to($this->customer->user->email)
            ->queue(new StatusPelangganBerubah($this->customer, 'menunggu_invoice'));

        $this->dispatch('notify', type: 'success', message: 'Data registrasi disetujui. Tagihan otomatis diteruskan ke Finance.');
    }

    public function reject(): void
    {
        $this->validate([
            'rejectionReason' => 'required|string|min:5',
        ], [
            'rejectionReason.required' => 'Alasan penolakan wajib diisi.',
            'rejectionReason.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $this->service->moveToStatus('ditolak', $this->rejectionReason);

        $this->recordActivitySafely('registration.rejected', 'Registrasi ditolak oleh Marketing.', $this->rejectionReason);

        $this->broadcastCustomerUpdatedSafely();
        $this->rejectionReason = '';
        $this->dispatch('notify', type: 'error', message: 'Data registrasi pendaftar telah ditolak.');
    }

    public function saveSpkData(): void
    {
        $this->validate([
            'job_type' => 'required|string',
            'customer_type' => 'required|in:Government,Corporate',
            'due_date' => 'required|date',
            'spk_notes' => 'required|string',
        ]);

        $this->withUniqueDocumentRetry(function (): void {
            DB::transaction(function (): void {
                $this->service->load('spk');

                $spkNumber = $this->service->spk->spk_number ?? DocumentNumberService::generateSpkNumber();

                $this->service->spk()->updateOrCreate(
                    ['service_id' => $this->service->id],
                    [
                        'spk_number' => $spkNumber,
                        'job_type' => $this->job_type,
                        'customer_type' => $this->customer_type,
                        'due_date' => $this->due_date,
                        'notes' => $this->spk_notes,
                    ]
                );
            });
        });

        $this->forgetSpkPdfCache();
        $this->service->refresh();
        $this->service->load('spk');

        $this->broadcastCustomerUpdatedSafely();
        $this->dispatch('notify', type: 'success', message: 'Data SPK berhasil disimpan. Anda dapat mengecek PDF SPK sekarang.');
    }

    public function sendToNoc(): void
    {
        if (! $this->service->spk) {
            $this->dispatch('notify', type: 'error', message: 'Harap simpan data SPK terlebih dahulu sebelum mengirim ke NOC.');

            return;
        }

        $this->service->moveToStatus('proses_instalasi');

        $this->recordActivitySafely('registration.sent_to_noc', 'SPK dikirim ke tim NOC.');

        $this->broadcastCustomerUpdatedSafely();
        $this->showSendToNocModal = false;

        Mail::to($this->customer->user->email)
            ->queue(new StatusPelangganBerubah($this->customer, 'proses_instalasi'));

        $this->dispatch('notify', type: 'success', message: 'SPK berhasil dikirim! Status layanan kini berada di tangan tim NOC.');
    }

    public function approveBaa(): void
    {
        $this->service->moveToStatus('selesai');

        $this->recordActivitySafely('baa.approved', 'BAA disetujui dan layanan dinyatakan aktif.');

        $this->broadcastCustomerUpdatedSafely();

        $this->showApproveBaaModal = false;

        Mail::to($this->customer->user->email)
            ->queue(new StatusPelangganBerubah($this->customer, 'selesai'));

        $this->dispatch('notify', type: 'success', message: 'BAA disetujui! Layanan pelanggan telah resmi selesai dan aktif sepenuhnya.');
    }

    public function rejectBaa(): void
    {
        if ($this->service->baa) {
            $this->service->baa->update(['signed_baa_path' => null]);
        }

        $this->service->moveToStatus('menunggu_baa');

        $this->recordActivitySafely('baa.rejected', 'BAA ditolak dan pelanggan diminta upload ulang.');

        $this->broadcastCustomerUpdatedSafely();
        $this->dispatch('notify', type: 'error', message: 'BAA ditolak. Pelanggan telah diminta untuk menandatangani ulang.');
    }

    public function cancelRegistration(): mixed
    {
        $this->validate([
            'cancellationReason' => 'required|string|min:5',
        ], [
            'cancellationReason.required' => 'Alasan pembatalan wajib diisi.',
            'cancellationReason.min' => 'Alasan pembatalan minimal 5 karakter.',
        ]);

        $this->service->moveToStatus('dibatalkan', $this->cancellationReason);

        $this->recordActivitySafely('registration.cancelled', 'Registrasi dibatalkan oleh Marketing.', $this->cancellationReason);

        $this->broadcastCustomerUpdatedSafely();
        $this->showCancellationModal = false;
        session()->flash('success', 'Pengajuan berhasil dibatalkan dan dihapus dari antrean.');

        return $this->redirect(route('marketing.tracking.index'), navigate: true);
    }

    public function render(): mixed
    {
        return view('livewire.marketing.tracking.show');
    }

    private function forgetSpkPdfCache(): void
    {
        Storage::disk('local')->delete([
            "generated/spk/spk-{$this->service->id}.pdf",
            "generated/spk/v2/spk-{$this->service->id}.pdf",
        ]);
    }

    private function forgetBaaPdfCache(): void
    {
        Storage::disk('local')->delete([
            "generated/baa/baa-{$this->service->id}.pdf",
            "generated/baa/v2/baa-{$this->service->id}.pdf",
        ]);
    }

    private function withUniqueDocumentRetry(callable $callback): void
    {
        for ($attempt = 1; $attempt <= 3; $attempt++) {
            try {
                $callback();

                return;
            } catch (QueryException $exception) {
                if ($attempt === 3 || ! $this->isUniqueConstraintViolation($exception)) {
                    throw $exception;
                }

                $this->service->refresh();
            }
        }
    }

    private function isUniqueConstraintViolation(QueryException $exception): bool
    {
        return in_array((string) $exception->getCode(), ['23000', '23505'], true);
    }

    private function recordActivitySafely(string $action, string $description, ?string $reason = null): void
    {
        try {
            ActivityLog::record($action, $description, $this->customer, $reason);
        } catch (Throwable $exception) {
            Log::warning('Activity log failed during marketing tracking action.', [
                'action' => $action,
                'customer_id' => $this->customer->id,
                'exception' => $exception->getMessage(),
            ]);
        }
    }

    private function broadcastCustomerUpdatedSafely(): void
    {
        try {
            broadcast(new CustomerUpdated);
        } catch (Throwable $exception) {
            Log::warning('Customer update broadcast failed during marketing tracking action.', [
                'customer_id' => $this->customer->id,
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
