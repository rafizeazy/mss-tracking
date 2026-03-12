<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Dashboard Pelanggan') }}</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">
                {{ __('Selamat datang, :name. Berikut adalah status layanan Anda saat ini.', ['name' => auth()->user()->name]) }}
            </p>
        </div>
        <div class="flex items-center gap-2 text-sm text-[#8a969c]">
            <i class="ti ti-home text-base"></i>
            <span>/</span>
            <span class="font-medium text-[#313a46] dark:text-white">{{ __('Dashboard') }}</span>
        </div>
    </div>

    @if($customer->status === 'menunggu_verifikasi')
        <div class="mb-6 rounded-[0.3rem] border border-[#60addf]/30 bg-[#60addf]/10 p-4">
            <div class="flex items-start gap-3">
                <i class="ti ti-info-circle text-xl text-[#60addf]"></i>
                <div>
                    <h5 class="text-sm font-semibold text-[#1e5d87] dark:text-[#60addf]">Status: Menunggu Verifikasi Dokumen</h5>
                    <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                        Terima kasih telah mendaftar layanan PT Media Solusi Sukses. Saat ini, tim kami sedang memeriksa kelengkapan data dan dokumen Anda. Proses ini biasanya memakan waktu 1x24 jam kerja.
                    </p>
                </div>
            </div>
        </div>
    @elseif($customer->status === 'ditolak')
        <div class="mb-6 rounded-[0.3rem] border border-[#ed6060]/30 bg-[#ed6060]/10 p-4">
            <div class="flex items-start gap-3">
                <i class="ti ti-x text-xl text-[#ed6060]"></i>
                <div>
                    <h5 class="text-sm font-semibold text-[#a84444] dark:text-[#ed6060]">Status: Pendaftaran Ditolak</h5>
                    <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                        Mohon maaf, pendaftaran Anda tidak dapat dilanjutkan saat ini. Silakan hubungi dukungan kami untuk informasi lebih lanjut.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="mb-6 rounded-[0.3rem] border border-[#70bb63]/30 bg-[#70bb63]/10 p-4">
            <div class="flex items-start gap-3">
                <i class="ti ti-check text-xl text-[#70bb63]"></i>
                <div>
                    <h5 class="text-sm font-semibold text-[#4a8a3f] dark:text-[#70bb63]">Status: Data Telah Diverifikasi</h5>
                    <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                        Data Anda telah disetujui oleh tim kami. Silakan pantau tahapan proses layanan Anda selanjutnya pada tabel di bawah ini.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        
        <div class="boron-card lg:col-span-2">
            <div class="boron-card-header border-b border-[#e7e9eb] pb-4 dark:border-[#37394d]">
                <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Tracking Aktivasi Layanan') }}</h5>
            </div>
            <div class="boron-card-body p-6">
                @php
                    $statusOrder = [
                        'menunggu_verifikasi', 'menunggu_pembayaran', 'pembayaran_disetujui', 
                        'proses_instalasi', 'proses_aktivasi', 'menunggu_baa', 'baa_terbit', 'selesai'
                    ];
                    
                    $currentIndex = array_search($customer->status, $statusOrder);
                    
                    $workflows = [
                        ['id' => 'menunggu_verifikasi', 'title' => 'Menunggu Verifikasi', 'desc' => 'Tim kami sedang memverifikasi data KTP/NPWP dan layanan Anda.', 'icon' => 'ti-shield-check'],
                        ['id' => 'menunggu_pembayaran', 'title' => 'Menunggu Pembayaran', 'desc' => 'Penerbitan tagihan awal (Invoice) untuk biaya langganan/instalasi.', 'icon' => 'ti-receipt'],
                        ['id' => 'pembayaran_disetujui', 'title' => 'Pembayaran Disetujui', 'desc' => 'Verifikasi pembayaran oleh departemen Finance.', 'icon' => 'ti-cash'],
                        ['id' => 'proses_instalasi', 'title' => 'Proses Instalasi', 'desc' => 'Penjadwalan dan pemasangan perangkat fisik oleh tim NOC.', 'icon' => 'ti-router'],
                        ['id' => 'proses_aktivasi', 'title' => 'Proses Aktivasi', 'desc' => 'Konfigurasi jaringan dan aktivasi bandwidth internet.', 'icon' => 'ti-wifi'],
                        ['id' => 'menunggu_baa', 'title' => 'Menunggu BAA', 'desc' => 'Penyusunan dokumen Berita Acara Aktivasi (BAA).', 'icon' => 'ti-file-description'],
                        ['id' => 'baa_terbit', 'title' => 'BAA Terbit', 'desc' => 'Penandatanganan dokumen BAA oleh kedua belah pihak.', 'icon' => 'ti-signature'],
                        ['id' => 'selesai', 'title' => 'Selesai', 'desc' => 'Layanan internet aktif dan siap digunakan secara penuh.', 'icon' => 'ti-circle-check'],
                    ];
                @endphp

                <div class="relative ml-3 border-l-2 border-[#e7e9eb] dark:border-[#37394d]">
                    <div class="mb-8 ml-8 relative">
                        <span class="absolute -left-[2.85rem] flex size-10 items-center justify-center rounded-full bg-[#669776] text-white ring-4 ring-white dark:ring-[#15151b]">
                            <i class="ti ti-file-check text-xl"></i>
                        </span>
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                            <div>
                                <h5 class="text-base font-semibold text-[#313a46] dark:text-white">Form Submit</h5>
                                <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">Formulir registrasi dan dokumen berhasil dikirim.</p>
                            </div>
                            <span class="shrink-0 text-xs font-medium text-[#8a969c]">
                                {{ $customer->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>

                    @foreach($workflows as $index => $step)
                        @php
                            $stepIndex = array_search($step['id'], $statusOrder);
                            if ($customer->status === 'ditolak') {
                                $state = 'pending';
                            } elseif ($stepIndex < $currentIndex) {
                                $state = 'completed';
                            } elseif ($stepIndex === $currentIndex) {
                                $state = 'active';
                            } else {
                                $state = 'pending';
                            }
                        @endphp

                        <div class="mb-8 ml-8 relative last:mb-0">
                            @if($state === 'completed')
                                <span class="absolute -left-[2.85rem] flex size-10 items-center justify-center rounded-full bg-[#669776] text-white ring-4 ring-white dark:ring-[#15151b]">
                                    <i class="ti ti-check text-xl"></i>
                                </span>
                            @elseif($state === 'active')
                                <span class="absolute -left-[2.85rem] flex size-10 items-center justify-center rounded-full bg-[#60addf] text-white ring-4 ring-white dark:ring-[#15151b] shadow-[0_0_15px_rgba(96,173,223,0.5)]">
                                    <i class="ti {{ $step['icon'] }} text-xl animate-pulse"></i>
                                </span>
                            @else
                                <span class="absolute -left-[2.85rem] flex size-10 items-center justify-center rounded-full bg-[#f8f9fa] border-2 border-[#dee2e6] text-[#a1a9b1] ring-4 ring-white dark:bg-[#1e1f27] dark:border-[#37394d] dark:ring-[#15151b]">
                                    <i class="ti {{ $step['icon'] }} text-xl"></i>
                                </span>
                            @endif

                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                <div>
                                    <h5 class="text-base font-semibold {{ $state === 'active' ? 'text-[#60addf]' : ($state === 'completed' ? 'text-[#313a46] dark:text-white' : 'text-[#8a969c]') }}">
                                        {{ $step['title'] }}
                                    </h5>
                                    <p class="mt-1 text-sm {{ $state === 'pending' ? 'text-[#a1a9b1]' : 'text-[#4c4c5c] dark:text-[#aab8c5]' }}">
                                        {{ $step['desc'] }}
                                    </p>
                                </div>
                                @if($state === 'active')
                                    <span class="shrink-0 text-xs font-medium text-[#60addf] bg-[#60addf]/10 px-2 py-1 rounded">
                                        Sedang diproses
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Ringkasan Layanan') }}</h5>
                </div>
                <div class="boron-card-body p-5">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex size-12 shrink-0 items-center justify-center rounded-[0.3rem] bg-[#669776]/10 text-[#669776]">
                            <i class="ti ti-network text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-[#8a969c]">Paket Pilihan</p>
                            <h6 class="text-base font-bold text-[#313a46] dark:text-white">{{ $customer->service_type ?? '-' }}</h6>
                        </div>
                    </div>
                    
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between border-b border-dashed border-[#e7e9eb] pb-2 dark:border-[#37394d]">
                            <span class="text-[#8a969c]">Kontrak</span>
                            <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->term_of_service ?? '-' }} Tahun</span>
                        </li>
                        <li class="flex justify-between border-b border-dashed border-[#e7e9eb] pb-2 dark:border-[#37394d]">
                            <span class="text-[#8a969c]">ID Pelanggan</span>
                            <span class="font-medium text-[#ebb751]">
                                {{ $customer->status === 'menunggu_verifikasi' ? 'Menunggu Verifikasi' : 'MSS-CUST-'.str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Data Registrasi') }}</h5>
                </div>
                <div class="boron-card-body p-5">
                    <ul class="space-y-4 text-sm">
                        <li>
                            <p class="text-xs text-[#8a969c]">Nama Perusahaan / Instansi</p>
                            <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->company_name ?? '-' }}</p>
                        </li>
                        <li>
                            <p class="text-xs text-[#8a969c]">Alamat Instalasi</p>
                            <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->installation_address ?? $customer->company_address ?? '-' }}</p>
                        </li>
                        <li>
                            <p class="text-xs text-[#8a969c]">Kontak PIC (Teknis)</p>
                            <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->technical_name ?? '-' }} - {{ $customer->technical_phone ?? '-' }}</p>
                        </li>
                    </ul>

                    <div class="mt-5 pt-5 border-t border-[#e7e9eb] dark:border-[#37394d]">
                        <button class="w-full btn-boron btn-boron-outline-secondary flex items-center justify-center gap-2 !py-2 text-sm">
                            <i class="ti ti-headphones text-base"></i> Hubungi Dukungan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>