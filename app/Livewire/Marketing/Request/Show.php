<?php

namespace App\Livewire\Marketing\Request;

use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Review Pengajuan Layanan')]
#[Layout('layouts.app')]
class Show extends Component
{
    public ServiceRequest $request;
    
    // Properti untuk Upgrade / Downgrade
    public $edit_bandwidth;
    public $edit_monthly_fee;
    
    // Properti khusus untuk Terminate
    public $terminate_date;
    
    public $metro_vendor;
    public $deadline_date;

    public function mount($id)
    {
        $this->request = ServiceRequest::with(['customer.user', 'bau'])->findOrFail($id);
        if ($this->request->request_type === 'Terminate') {
            $this->terminate_date = $this->request->deadline_date ? $this->request->deadline_date->format('Y-m-d') : now()->addDays(7)->format('Y-m-d');
        } else {
            $this->edit_bandwidth = $this->request->new_bandwidth;
            $this->edit_monthly_fee = $this->request->new_monthly_fee;
        }
        
        $this->metro_vendor = $this->request->metro_vendor ?? $this->request->customer->jalur_metro;
        if ($this->request->deadline_date) {
            $this->deadline_date = $this->request->deadline_date->format('Y-m-d');
        }
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        $this->request->refresh();
    }

    public function saveSpkDraft()
    {
        $this->request->update([
            'deadline_date' => $this->deadline_date,
            'metro_vendor'  => $this->metro_vendor,
        ]);
    }

    public function approve()
    {
        if ($this->request->request_type === 'Terminate') {
            $this->validate([
                'terminate_date' => 'required|date',
            ]);

            $this->request->update([
                'deadline_date' => $this->terminate_date,
                'status'        => 'form_disetujui',
            ]);
        } else {
            $this->validate([
                'edit_monthly_fee' => 'required|numeric|min:1000',
                'edit_bandwidth'   => 'required|string',
            ]);

            $this->request->update([
                'new_bandwidth'   => $this->edit_bandwidth,
                'new_monthly_fee' => $this->edit_monthly_fee,
                'status'          => 'form_disetujui',
            ]);
        }

        $this->request->refresh();
        $this->dispatch('notify', type: 'success', message: 'Pengajuan disetujui. Silakan review PDF sebelum dikirim.');
    }

    public function sendToCustomer()
    {
        $this->request->update(['status' => 'menunggu_ttd_pelanggan']);
        $this->dispatch('notify', type: 'success', message: 'Form berhasil dikirim ke dashboard pelanggan untuk ditandatangani.');
    }

    public function rejectSignature()
    {
        $this->request->update([
            'signed_pdf_path' => null,
            'status' => 'menunggu_ttd_pelanggan',
        ]);
        $this->dispatch('notify', type: 'error', message: 'Tanda tangan ditolak. Menunggu pelanggan mengunggah ulang.');
    }

    public function sendToNoc()
    {
        $this->validate([
            'deadline_date' => 'required|date',
            'metro_vendor'  => 'required|string',
        ], [
            'deadline_date.required' => 'Deadline pengerjaan wajib diisi sebelum dikirim ke NOC.',
        ]);

        $this->request->update([
            'metro_vendor'  => $this->metro_vendor,
            'deadline_date' => $this->deadline_date,
            'status'        => 'proses_upgrade',
        ]);
        $this->dispatch('notify', type: 'success', message: 'TTD disetujui & SPK berhasil diterbitkan ke tim NOC!');
    }

    public function approveBauSignature()
    {
        $this->request->update(['status' => 'selesai']);
        if ($this->request->request_type === 'Upgrade' || $this->request->request_type === 'Downgrade') {
            $this->request->customer->update([
                'bandwidth'   => $this->request->new_bandwidth,
                'monthly_fee' => $this->request->new_monthly_fee,
            ]);
        } elseif ($this->request->request_type === 'Terminate') {
            $this->request->customer->update([
                'status' => 'berhenti', 
            ]);
        }

        $this->dispatch('notify', type: 'success', message: 'Berita Acara disetujui! Proses telah selesai dan status pelanggan diperbarui otomatis.');
    }

    public function rejectBauSignature()
    {
        if ($this->request->bau) {
            $this->request->bau->update(['signed_bau_path' => null]);
        }
        $this->request->update(['status' => 'menunggu_ttd_bau']);
        $this->dispatch('notify', type: 'error', message: 'Tanda tangan Berita Acara ditolak. Pelanggan telah diminta untuk mengunggah ulang.');
    }

    public function render()
    {
        return view('livewire.marketing.request.show');
    }
}