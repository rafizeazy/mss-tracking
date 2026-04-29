<?php

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshNotif()
    {
        $this->dispatch('$refresh');
    }

    public function with(): array
    {
        $notifications = collect();
        $user = auth()->user();
        $role = $user->role;
        
        // NOTIFIKASI MARKETING & SUPER ADMIN
        if ($role === \App\Enums\Role::Marketing || $user->isSuperAdmin()) {
            
            $verifikasi = Customer::where('status', 'menunggu_verifikasi')->latest()->get();
            foreach($verifikasi as $c) {
                $notifications->push([
                    'title' => 'Persetujuan Form Registrasi', 
                    'desc' => "Perusahaan: {$c->company_name} menunggu verifikasi data.", 
                    'url' => route('marketing.tracking.show', $c->id), 
                    'icon' => 'ti-shield-check', 'color' => 'text-[#ebb751]', 'bg' => 'bg-[#ebb751]/10'
                ]);
            }
            
            $spk = Customer::where('status', 'pembayaran_disetujui')->latest()->get();
            foreach($spk as $c) {
                $notifications->push([
                    'title' => 'Kirim SPK Baru', 
                    'desc' => "Perusahaan: {$c->company_name} menunggu penerbitan SPK.", 
                    'url' => route('marketing.tracking.show', $c->id), 
                    'icon' => 'ti-file-description', 'color' => 'text-[#60addf]', 'bg' => 'bg-[#60addf]/10'
                ]);
            }
            
            $baa = Customer::where('status', 'verifikasi_baa')->latest()->get();
            foreach($baa as $c) {
                $notifications->push([
                    'title' => 'Verifikasi BAA Final', 
                    'desc' => "Perusahaan: {$c->company_name} telah mengunggah BAA final.", 
                    'url' => route('marketing.tracking.show', $c->id), 
                    'icon' => 'ti-file-check', 'color' => 'text-[#70bb63]', 'bg' => 'bg-[#70bb63]/10'
                ]);
            }
        }

        // NOTIFIKASI FINANCE & SUPER ADMIN
        if ($role === \App\Enums\Role::Finance || $user->isSuperAdmin()) {
            
            $invoice = Customer::where('status', 'menunggu_invoice')->latest()->get();
            foreach($invoice as $c) {
                $notifications->push([
                    'title' => 'Pengiriman Invoice Baru', 
                    'desc' => "Perusahaan: {$c->company_name} menunggu penerbitan Invoice.", 
                    'url' => route('finance.tracking.show', $c->id), 
                    'icon' => 'ti-file-invoice', 'color' => 'text-[#ebb751]', 'bg' => 'bg-[#ebb751]/10'
                ]);
            }
            
            $payment = Customer::where('status', 'verifikasi_pembayaran')->latest()->get();
            foreach($payment as $c) {
                $notifications->push([
                    'title' => 'Cek Bukti Pembayaran', 
                    'desc' => "Perusahaan: {$c->company_name} telah melakukan transfer.", 
                    'url' => route('finance.tracking.show', $c->id), 
                    'icon' => 'ti-cash', 'color' => 'text-[#60addf]', 'bg' => 'bg-[#60addf]/10'
                ]);
            }
        }

        // NOTIFIKASI NOC & SUPER ADMIN
        if ($role === \App\Enums\Role::Noc || $user->isSuperAdmin()) {
            
            // Tugas Aktivasi Baru
            $instalasi = Customer::where('status', 'proses_instalasi')->latest()->get();
            foreach($instalasi as $c) {
                $notifications->push([
                    'title' => 'Tugas SPK Instalasi', 
                    'desc' => "Instalasi untuk: {$c->company_name} siap dikerjakan.", 
                    'url' => route('noc.tracking.show', $c->id), 
                    'icon' => 'ti-router', 'color' => 'text-[#ed6060]', 'bg' => 'bg-[#ed6060]/10'
                ]);
            }
            
            $reviewBaa = Customer::where('status', 'review_baa')->latest()->get();
            foreach($reviewBaa as $c) {
                $notifications->push([
                    'title' => 'Review BAA Internal', 
                    'desc' => "Form BAA: {$c->company_name} menunggu di-review.", 
                    'url' => route('noc.tracking.show', $c->id), 
                    'icon' => 'ti-file-certificate', 'color' => 'text-[#ebb751]', 'bg' => 'bg-[#ebb751]/10'
                ]);
            }
        }

        // NOTIFIKASI CUSTOMER / PELANGGAN
        if ($role === \App\Enums\Role::Customer) {
            $customer = Customer::where('user_id', $user->id)->first();
            
            if ($customer) {
                if ($customer->status === 'menunggu_pembayaran') {
                    $notifications->push([
                        'title' => 'Tagihan Menunggu', 
                        'desc' => "{$customer->company_name}: Silakan bayar & unggah bukti transfer.", 
                        'url' => route('customer.dashboard'), 
                        'icon' => 'ti-receipt', 'color' => 'text-[#ebb751]', 'bg' => 'bg-[#ebb751]/10'
                    ]);
                }
                if ($customer->status === 'menunggu_baa') {
                    $notifications->push([
                        'title' => 'Tanda Tangan BAA', 
                        'desc' => "{$customer->company_name}: Layanan aktif! Unggah dokumen BAA.", 
                        'url' => route('customer.dashboard'), 
                        'icon' => 'ti-signature', 'color' => 'text-[#60addf]', 'bg' => 'bg-[#60addf]/10'
                    ]);
                }
            }
        }
        return [
            'notifications' => $notifications,
            'unreadCount' => $notifications->count()
        ];
    }
};
