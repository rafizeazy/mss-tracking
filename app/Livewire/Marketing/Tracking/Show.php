<?php

namespace App\Livewire\Marketing\Tracking;

use App\Events\CustomerUpdated;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Tracking Registrasi')]
#[Layout('layouts.app')]
class Show extends Component
{
    public Customer $customer;

    public $service_type;
    public $monthly_fee;
    public $registration_fee;
    public $sla = '99.5%';
    public $marketing_name;
    public $marketing_phone;

    public $job_type = 'Aktivasi Baru';
    public $customer_type = '';
    public $due_date;
    public $spk_notes = 'Tim NOC diminta untuk melakukan proses provisioning layanan sesuai detail di atas, termasuk konfigurasi perangkat jaringan, aktivasi layanan, serta memastikan konektivitas layanan berjalan dengan baik sebelum dilakukan serah terima kepada pelanggan.';

    public function mount($id)
    {
        $this->customer = Customer::with(['user', 'spk'])->findOrFail($id);
        
        $this->service_type = $this->customer->service_type;
        $this->marketing_name = auth()->user()->name;

        if ($this->customer->spk) {
            $this->job_type = $this->customer->spk->job_type;
            $this->customer_type = $this->customer->spk->customer_type;
            $this->due_date = $this->customer->spk->due_date;
            $this->spk_notes = $this->customer->spk->notes;
        }
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        $this->customer->refresh();
    }

    public function approve()
    {
        $this->validate([
            'service_type' => 'required|string|max:255',
            'monthly_fee' => 'required|numeric|min:0',
            'registration_fee' => 'required|numeric|min:0',
            'sla' => 'required|string|max:50',
            'marketing_name' => 'required|string|max:255',
            'marketing_phone' => 'required|string|max:20',
        ]);

        $this->customer->update([
            'service_type' => $this->service_type,
            'monthly_fee' => $this->monthly_fee,
            'registration_fee' => $this->registration_fee,
            'sla' => $this->sla,
            'marketing_name' => $this->marketing_name,
            'marketing_phone' => $this->marketing_phone,
            'status' => 'menunggu_invoice'
        ]);

        broadcast(new CustomerUpdated());

        session()->flash('success', 'Data registrasi disetujui. Tagihan otomatis diteruskan ke Finance.');
    }

    public function reject()
    {
        $this->customer->update([
            'status' => 'ditolak'
        ]);

        broadcast(new CustomerUpdated());

        session()->flash('error', 'Data registrasi pendaftar telah ditolak.');
    }

    public function saveSpkData()
    {
        $this->validate([
            'job_type' => 'required|string',
            'customer_type' => 'required|in:Government,Corporate',
            'due_date' => 'required|date',
            'spk_notes' => 'required|string',
        ]);

        $spkNumber = 'SPK-' . $this->customer->id . '/' . date('m/Y');

        $this->customer->spk()->updateOrCreate(
            ['customer_id' => $this->customer->id],
            [
                'spk_number' => $spkNumber,
                'job_type' => $this->job_type,
                'customer_type' => $this->customer_type,
                'due_date' => $this->due_date,
                'notes' => $this->spk_notes,
            ]
        );

        $this->customer->refresh();

        broadcast(new CustomerUpdated());

        session()->flash('success', 'Data SPK berhasil disimpan. Anda dapat mengecek PDF SPK sekarang.');
    }

    public function sendToNoc()
    {
        if (!$this->customer->spk) {
            session()->flash('error', 'Harap simpan data SPK terlebih dahulu sebelum mengirim ke NOC.');
            return;
        }

        $this->customer->update([
            'status' => 'proses_instalasi'
        ]);

        broadcast(new CustomerUpdated());

        session()->flash('success', 'SPK berhasil dikirim! Status layanan kini berada di tangan tim NOC.');
    }

    public function approveBaa()
    {
        $this->customer->update(['status' => 'selesai']);

        broadcast(new CustomerUpdated());

        session()->flash('success', 'BAA disetujui! Layanan pelanggan telah resmi selesai dan aktif sepenuhnya.');
    }

    public function rejectBaa()
    {
        $this->customer->baa->update(['signed_baa_path' => null]);
        $this->customer->update(['status' => 'menunggu_baa']);

        broadcast(new CustomerUpdated());

        session()->flash('error', 'BAA ditolak. Pelanggan telah diminta untuk menandatangani ulang.');
    }

    public function render()
    {
        return view('livewire.marketing.tracking.show');
    }
}