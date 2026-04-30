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

    <!-- BUTTON NOTIF -->
    <button 
        @click="openNotif = !openNotif" 
        @click.away="openNotif = false" 
        class="boron-topbar-btn relative p-2 sm:p-2.5"
    >
        <i class="ti ti-bell text-lg {{ $unreadCount > 0 ? 'animate-ring-bell text-[#60addf]' : 'text-[#a1a9b1]' }}"></i>
        
        @if($unreadCount > 0)
            <span class="absolute -right-0.5 -top-0.5 flex size-4 items-center justify-center rounded-full bg-[#ed6060] text-[9px] font-bold text-white shadow-sm ring-2 ring-white dark:ring-[#1e1f27]">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- DROPDOWN NOTIF -->
    <div 
        x-show="openNotif"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-transition.origin.top.right
        x-cloak
        class="
        absolute right-0 sm:right-0 left-1/2 sm:left-auto
        -translate-x-1/2 sm:translate-x-0
        mt-2
        w-[92vw] sm:w-80
        max-w-sm
        origin-top
        rounded-xl
        border border-[#e7e9eb]
        bg-white
        shadow-2xl
        dark:border-[#37394d]
        dark:bg-[#1e1f27]
        z-[100]
        overflow-hidden
        "
    >

        <!-- HEADER -->
        <div class="border-b border-[#e7e9eb] dark:border-[#37394d] 
        px-3 sm:px-4 py-3 
        bg-[#f8f9fa] dark:bg-[#15151b] 
        flex justify-between items-center gap-2">

            <h6 class="text-[13px] sm:text-sm font-bold text-[#313a46] dark:text-white truncate">
                Notifikasi
            </h6>

            @if($unreadCount > 0)
                <span class="rounded bg-[#ed6060]/10 px-2 py-0.5 text-[10px] font-bold text-[#ed6060]">
                    {{ $unreadCount }}
                </span>
            @endif
        </div>

        <!-- LIST NOTIF -->
        <div class="max-h-[65vh] sm:max-h-[350px] overflow-y-auto boron-scrollbar divide-y divide-[#e7e9eb] dark:divide-[#37394d]">

            @forelse($notifications as $notif)
                <a 
                    href="{{ $notif['url'] }}" 
                    wire:navigate 
                    class="flex items-start gap-3 px-3 sm:px-4 py-3 sm:py-3.5 
                    hover:bg-[#f6f7fb] dark:hover:bg-white/5 
                    transition-colors"
                >
                    <!-- ICON -->
                    <div class="flex size-8 sm:size-9 shrink-0 items-center justify-center rounded-full {{ $notif['bg'] }} {{ $notif['color'] }}">
                        <i class="ti {{ $notif['icon'] }} text-sm sm:text-base"></i>
                    </div>

                    <!-- TEXT -->
                    <div class="flex-1 min-w-0">
                        <p class="text-[12px] sm:text-sm font-bold text-[#313a46] dark:text-white truncate">
                            {{ $notif['title'] }}
                        </p>
                        <p class="text-[11px] sm:text-xs text-[#8a969c] mt-0.5 leading-snug line-clamp-2">
                            {{ $notif['desc'] }}
                        </p>
                    </div>
                </a>

            @empty
                <!-- EMPTY STATE -->
                <div class="px-4 py-8 sm:py-10 text-center flex flex-col items-center justify-center">
                    
                    <div class="flex size-12 sm:size-14 items-center justify-center rounded-full 
                    bg-[#f8f9fa] text-[#a1a9b1] dark:bg-[#15151b] mb-3">
                        <i class="ti ti-bell-z text-xl sm:text-2xl"></i>
                    </div>

                    <p class="text-[13px] sm:text-sm font-bold text-[#313a46] dark:text-white">
                        Tidak ada tugas
                    </p>

                    <p class="text-[11px] text-[#8a969c] mt-1">
                        Semua sudah selesai
                    </p>
                </div>
            @endforelse

        </div>
    </div>
</div>