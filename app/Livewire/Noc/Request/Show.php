<?php

namespace App\Livewire\Noc\Request;

use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

#[Title('Eksekusi Tugas Jaringan (SPK)')]
#[Layout('layouts.app')]
class Show extends Component
{
    use WithFileUploads;

    public ServiceRequest $request;

    public $upgrade_date;
    public $noc_pic_name;
    public $noc_signature;
    public $speedtest_image;

    public function mount($id)
    {
        $this->request = ServiceRequest::with(['customer.user', 'bau'])->findOrFail($id);
        
        $this->upgrade_date = $this->request->bau?->upgrade_date ? $this->request->bau->upgrade_date->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $this->noc_pic_name = $this->request->bau?->noc_pic_name ?? auth()->user()->name;
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        $this->request->refresh();
        
        if ($this->request->bau) {
            $this->upgrade_date = $this->request->bau->upgrade_date ? $this->request->bau->upgrade_date->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        }
    }

    public function markAsDone()
    {
        $this->request->update(['status' => 'pembuatan_bau']);
        $this->dispatch('notify', type: 'success', message: 'Pekerjaan jaringan selesai! Silakan isi form Berita Acara.');
    }

    public function submitBauForm()
    {
        $this->validate([
            'upgrade_date'    => 'required|date',
            'noc_pic_name'    => 'required|string|max:255',
            'noc_signature'   => $this->request->bau?->noc_signature_path ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'speedtest_image' => $this->request->bau?->speedtest_image_path ? 'nullable|image|max:5120' : 'required|image|max:5120',
        ]);

        $bauData = [
            'upgrade_date' => $this->upgrade_date,
            'noc_pic_name' => $this->noc_pic_name,
        ];

        if ($this->noc_signature) {
            $bauData['noc_signature_path'] = $this->noc_signature->store('noc/signatures', 'public');
        }

        if ($this->speedtest_image) {
            $bauData['speedtest_image_path'] = $this->speedtest_image->store('noc/speedtests', 'public');
        }

        if ($this->request->bau) {
            $this->request->bau->update($bauData);
        } else {
            $this->request->bau()->create($bauData);
        }

        $this->request->load('bau'); 

        $this->dispatch('notify', type: 'success', message: 'Data Berita Acara berhasil disimpan. Silakan review PDF sebelum dikirim.');
    }

    public function sendBauToCustomer()
    {
        if ($this->request->bau) {
            $this->request->bau->update([
                'unsigned_bau_path' => 'api/bau/' . $this->request->id . '/pdf', 
            ]);
        }
        
        $this->request->update([
            'status' => 'menunggu_ttd_bau',
        ]);

        $this->dispatch('notify', type: 'success', message: 'Draf Berita Acara berhasil dikirim ke dashboard pelanggan untuk ditandatangani.');
    }

    public function render()
    {
        return view('livewire.noc.request.show');
    }
}