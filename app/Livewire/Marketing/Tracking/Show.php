<?php

namespace App\Livewire\Marketing\Tracking;

use App\Models\Customer;
use Livewire\Attributes\Layout;
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

    public function mount($id)
    {
        $this->customer = Customer::with('user')->findOrFail($id);

        $this->service_type = $this->customer->service_type;
        $this->marketing_name = auth()->user()->name;
    }

    protected function rules()
    {
        return [
            'service_type' => 'required|string|max:255',
            'monthly_fee' => 'required|numeric|min:0',
            'registration_fee' => 'required|numeric|min:0',
            'sla' => 'required|string|max:50',
            'marketing_name' => 'required|string|max:255',
            'marketing_phone' => 'required|string|max:20',
        ];
    }

    public function approve()
    {
        $this->validate();

        $this->customer->update([
            'service_type' => $this->service_type,
            'monthly_fee' => $this->monthly_fee,
            'registration_fee' => $this->registration_fee,
            'sla' => $this->sla,
            'marketing_name' => $this->marketing_name,
            'marketing_phone' => $this->marketing_phone,
            'status' => 'menunggu_pembayaran',
        ]);

        $this->dispatch('toast', type: 'success', title: 'Registrasi Disetujui', message: 'Data komersial disimpan. Antrean tagihan diteruskan ke Finance.');
    }

    public function reject()
    {
        $this->customer->update([
            'status' => 'ditolak',
        ]);

        $this->dispatch('toast', type: 'error', title: 'Pendaftaran Ditolak', message: 'Data registrasi pendaftar telah ditolak.');
    }

    public function render()
    {
        return view('livewire.marketing.tracking.show');
    }
}
