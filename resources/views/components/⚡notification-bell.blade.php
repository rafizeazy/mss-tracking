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
?>

<div class="relative ml-1" x-data="{ openNotif: false }">
    <button @click="openNotif = !openNotif" @click.away="openNotif = false" class="boron-topbar-btn relative">
        <i class="ti ti-bell text-lg {{ $unreadCount > 0 ? 'animate-ring-bell text-[#60addf]' : 'text-[#a1a9b1]' }}"></i>
        
        @if($unreadCount > 0)
            <span class="absolute -right-0.5 -top-0.5 flex size-4 items-center justify-center rounded-full bg-[#ed6060] text-[9px] font-bold text-white shadow-sm ring-2 ring-white dark:ring-[#1e1f27]">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="openNotif" 
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
        class="absolute right-0 mt-2 w-72 sm:w-80 origin-top-right rounded-[0.5rem] border border-[#e7e9eb] bg-white shadow-xl dark:border-[#37394d] dark:bg-[#1e1f27] z-50 overflow-hidden"
    >
        <div class="border-b border-[#e7e9eb] px-4 py-3 dark:border-[#37394d] bg-[#f8f9fa] dark:bg-[#15151b] flex justify-between items-center">
            <h6 class="text-sm font-bold text-[#313a46] dark:text-white">Daftar Tugas (Notifikasi)</h6>
            @if($unreadCount > 0)
                <span class="rounded bg-[#ed6060]/10 px-2 py-0.5 text-[10px] font-bold text-[#ed6060]">{{ $unreadCount }} Antrean</span>
            @endif
        </div>

        <div class="max-h-[350px] overflow-y-auto boron-scrollbar divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
            @forelse($notifications as $notif)
                <a href="{{ $notif['url'] }}" wire:navigate class="flex items-start gap-3 px-4 py-3 hover:bg-[#f6f7fb] dark:hover:bg-white/5 transition-colors group">
                    <div class="flex size-9 shrink-0 items-center justify-center rounded-full {{ $notif['bg'] }} {{ $notif['color'] }} mt-0.5">
                        <i class="ti {{ $notif['icon'] }} text-lg group-hover:scale-110 transition-transform"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#313a46] dark:text-white">{{ $notif['title'] }}</p>
                        <p class="text-[11px] text-[#8a969c] mt-0.5 leading-relaxed">{{ $notif['desc'] }}</p>
                    </div>
                </a>
            @empty
                <div class="px-4 py-8 text-center">
                    <div class="inline-flex size-12 items-center justify-center rounded-full bg-[#f8f9fa] text-[#a1a9b1] dark:bg-[#15151b] mb-2">
                        <i class="ti ti-bell-z text-2xl"></i>
                    </div>
                    <p class="text-sm font-semibold text-[#313a46] dark:text-white">Tidak ada tugas baru</p>
                    <p class="text-xs text-[#8a969c] mt-1">Anda sudah menyelesaikan semuanya!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>