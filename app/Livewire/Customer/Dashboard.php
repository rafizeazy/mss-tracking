<?php

namespace App\Livewire\Customer;

use App\Events\CustomerUpdated;
use App\Models\Customer;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Dashboard Pelanggan')]
#[Layout('layouts.app')]
class Dashboard extends Component
{
    use WithFileUploads;

    public $signed_baa;
    public ?Customer $customer = null;
    public $payment_proof;

    public $pendingRequest = null;
    public $showRequestModal = false;
    public $requestForm = [
        'new_bandwidth' => '',
        'stop_date' => '',
        'reason' => ''
    ];

    public $activeRequest = null;
    public $signed_request_doc;
    public $signed_bau_doc;

    public function mount()
    {
        $this->loadCustomer();
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function loadCustomer()
    {
        $this->customer = Customer::where('user_id', auth()->id())->latest()->first();
        
        if ($this->customer) {
            $this->pendingRequest = ServiceRequest::where('customer_id', $this->customer->id)
                ->where('status', 'menunggu_pelanggan')
                ->first();

            $this->activeRequest = ServiceRequest::with('bau')
                ->where('customer_id', $this->customer->id)
                ->where('status', '!=', 'menunggu_pelanggan')
                ->where('status', '!=', 'selesai')
                ->latest()
                ->first();
        } else {
            $this->pendingRequest = null;
            $this->activeRequest = null;
        }
    }

    public function openRequestModal()
    {
        $this->showRequestModal = true;
    }

    public function closeRequestModal()
    {
        $this->showRequestModal = false;
        $this->reset('requestForm');
    }

    public function submitRequestForm()
    {
        if (!$this->pendingRequest) return;

        if ($this->pendingRequest->request_type === 'Terminate') {
            $this->validate([
                'requestForm.stop_date' => 'required|date',
                'requestForm.reason' => 'required|string|min:5',
            ]);
        } else {
            $this->validate([
                'requestForm.new_bandwidth' => 'required|string',
                'requestForm.reason' => 'nullable|string',
            ]);
        }

        $this->pendingRequest->update([
            'old_bandwidth' => $this->customer->bandwidth,
            'new_bandwidth' => !empty($this->requestForm['new_bandwidth']) ? $this->requestForm['new_bandwidth'] : null,
            'stop_date'     => !empty($this->requestForm['stop_date']) ? $this->requestForm['stop_date'] : null,
            'reason'        => !empty($this->requestForm['reason']) ? $this->requestForm['reason'] : null,
            'status'        => 'menunggu_approval',
        ]);

        $this->closeRequestModal();
        $this->loadCustomer();

        $this->dispatch('toast', type: 'success', title: 'Terkirim!', message: 'Form pengajuan berhasil dikirim ke tim kami untuk diproses.');
    }

    public function viewInvoice(): void
    {
        $this->dispatch('toast', type: 'info', title: 'Info', message: 'Fitur cetak Invoice akan segera tersedia.');
    }

    public function uploadPayment()
    {
        $this->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);
        
        $path = $this->payment_proof->store('payment_proofs', 'public');
        
        $this->customer->update([
            'payment_proof_file_path' => $path,
            'status' => 'verifikasi_pembayaran',
        ]);

        broadcast(new CustomerUpdated());

        $this->dispatch('toast', type: 'success', title: 'Bukti Terkirim!', message: 'Bukti transfer berhasil dikirim. Menunggu verifikasi.');
        
        $this->payment_proof = null;
        $this->loadCustomer(); 
    }

    public function uploadSignedBaa()
    {
        $this->validate([
            'signed_baa' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $path = $this->signed_baa->store('baa/signed', 'public');
        
        $this->customer->baa->update(['signed_baa_path' => $path]);
        $this->customer->update(['status' => 'verifikasi_baa']);

        broadcast(new CustomerUpdated());

        $this->signed_baa = null;
        $this->loadCustomer();
        $this->dispatch('toast', type: 'success', title: 'Upload Berhasil!', message: 'BAA telah dikirim ke tim Marketing untuk diverifikasi akhir.');
    }

    public function uploadSignedRequest()
    {
        $this->validate([
            'signed_request_doc' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $path = $this->signed_request_doc->store('requests/signed', 'public');
        
        $this->activeRequest->update([
            'signed_pdf_path' => $path,
            'status' => 'verifikasi_ttd_pelanggan', 
        ]);

        $this->signed_request_doc = null;
        $this->dispatch('toast', type: 'success', title: 'Terkirim!', message: 'Dokumen berhasil diunggah. Menunggu verifikasi dari tim Marketing.');
        $this->loadCustomer();
    }

    public function uploadSignedBau()
    {
        $this->validate([
            'signed_bau_doc' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $path = $this->signed_bau_doc->store('requests/bau_signed', 'public');
        
        if ($this->activeRequest->bau) {
            $this->activeRequest->bau->update([
                'signed_bau_path' => $path,
            ]);
        }

        $this->activeRequest->update([
            'status' => 'verifikasi_ttd_bau',
        ]);

        $this->signed_bau_doc = null;
        $this->dispatch('toast', type: 'success', title: 'Terkirim!', message: 'Berita Acara berhasil diunggah. Menunggu verifikasi akhir dari tim Marketing.');
        $this->loadCustomer();
    }

    public function render()
    {
        return view('livewire.customer.dashboard');
    }
}