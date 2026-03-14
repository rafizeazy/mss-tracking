<div class="py-6" wire:poll.10s="loadCustomer">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Dashboard Pelanggan') }}</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">
                {{ __('Selamat datang, :name.', ['name' => auth()->user()->name]) }}
            </p>
        </div>
        <div class="flex items-center gap-2 text-sm text-[#8a969c]">
            <i class="ti ti-home text-base"></i>
            <span>/</span>
            <span class="font-medium text-[#313a46] dark:text-white">{{ __('Dashboard') }}</span>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 rounded-[0.3rem] border border-[#70bb63]/30 bg-[#70bb63]/10 p-3 text-sm text-[#70bb63]">
            <i class="ti ti-check mr-1"></i> {{ session('success') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div class="mb-6 rounded-[0.3rem] border border-[#60addf]/30 bg-[#60addf]/10 p-3 text-sm text-[#60addf]">
            <i class="ti ti-info-circle mr-1"></i> {{ session('info') }}
        </div>
    @endif

    @if($customer->status === 'selesai')
        
        <div class="boron-card bg-gradient-to-r from-[#1e5d87] to-[#60addf] border-0 mb-6 text-white overflow-hidden relative">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 size-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute bottom-0 right-20 -mb-10 size-32 rounded-full bg-black/10 blur-xl"></div>
            
            <div class="boron-card-body p-8 relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h2 class="text-2xl text-black/80 font-bold mb-2">Selamat Bergabung Bersama Kami! 🎉</h2>
                    <p class="text-black/80 max-w-2xl">Layanan internet Anda telah aktif sepenuhnya. Terima kasih telah mempercayakan kebutuhan konektivitas perusahaan Anda kepada PT Media Solusi Sukses. Kami berkomitmen memberikan layanan terbaik untuk Anda.</p>
                </div>
                <div class="shrink-0 text-center md:text-right bg-white/10 p-4 rounded-xl backdrop-blur-sm border border-white/20">
                    <p class="text-xs uppercase tracking-wider text-black/80 font-semibold mb-1">ID Pelanggan Anda</p>
                    <p class="text-3xl font-black text-[#ebb751]">{{ $customer->customer_number }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                
                <div class="boron-card border-t-4 border-t-[#669776]">
                    <div class="boron-card-body p-6 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex size-14 items-center justify-center rounded-full bg-[#669776]/10 text-[#669776]">
                                <i class="ti ti-network text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase text-[#8a969c]">Paket Layanan Aktif</p>
                                <h6 class="text-xl font-bold text-[#313a46] dark:text-white">{{ $customer->service_type }}</h6>
                                <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mt-0.5">Aktif sejak: {{ $customer->baa->activation_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="hidden sm:block text-right">
                            <a href="{{ route('noc.baa', $customer->id) }}" target="_blank" class="btn-boron btn-boron-outline-primary !py-1.5 !px-3 text-xs shadow-sm">
                                <i class="ti ti-file-certificate"></i> Lihat BAA
                            </a>
                        </div>
                    </div>
                </div>

                <div class="boron-card bg-[#f8f9fa] dark:bg-[#15151b] border border-[#e7e9eb] dark:border-[#37394d]">
                    <div class="boron-card-header pb-2 border-b-0 pt-5 px-6">
                        <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf] text-center text-lg">Keuntungan Berlangganan di Perusahaan Kami:</h5>
                    </div>
                    <div class="boron-card-body p-6">
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1">
                                <div class="bg-[#eef2f6] dark:bg-white/5 p-2 rounded-lg text-[#1e5d87] dark:text-[#60addf] shrink-0"><i class="ti ti-headset text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">NOC 24/7</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Layanan support profesional siap bantu kapan saja.</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1">
                                <div class="bg-[#fff4e5] dark:bg-white/5 p-2 rounded-lg text-[#ebb751] shrink-0"><i class="ti ti-map-pin text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">IP Publik</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Akses langsung, mudah untuk server & kebutuhan bisnis.</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1">
                                <div class="bg-[#eefcf2] dark:bg-white/5 p-2 rounded-lg text-[#70bb63] shrink-0"><i class="ti ti-file-certificate text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">PKS Terjamin</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Legalitas jelas, layanan internet lebih terjamin & aman.</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1">
                                <div class="bg-[#fceeee] dark:bg-white/5 p-2 rounded-lg text-[#ed6060] shrink-0"><i class="ti ti-shirt text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">Seragam Resmi</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Mendapatkan seragam resmi perusahaan kami.</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1 sm:col-span-2 md:col-span-1">
                                <div class="bg-[#eef2f6] dark:bg-white/5 p-2 rounded-lg text-[#60addf] shrink-0"><i class="ti ti-device-desktop-analytics text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">MRTG Monitoring</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Pantau trafik dan kualitas jaringan secara real-time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="boron-card border-2 border-[#60addf] shadow-lg overflow-hidden">
                    <div class="bg-[#60addf] text-white p-4 flex items-center gap-3">
                        <i class="ti ti-headset text-3xl"></i>
                        <div>
                            <h5 class="font-bold text-lg">Butuh Bantuan?</h5>
                            <p class="text-xs text-white/80">Hubungi tim kami kapan saja.</p>
                        </div>
                    </div>
                    <div class="boron-card-body p-0 divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        <a href="https://wa.me/62812xxxxxx" target="_blank" class="flex items-center justify-between p-4 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-[#f8f9fa] border border-[#dee2e6] flex items-center justify-center text-[#8a969c] group-hover:bg-white group-hover:text-[#60addf] dark:bg-[#15151b] dark:border-[#37394d]"><i class="ti ti-messages text-xl"></i></div>
                                <div>
                                    <p class="font-bold text-[#313a46] dark:text-white text-sm">Customer Service</p>
                                    <p class="text-xs text-[#8a969c]">Pertanyaan Umum / Info</p>
                                </div>
                            </div>
                            <i class="ti ti-chevron-right text-[#a1a9b1]"></i>
                        </a>
                        
                        <a href="https://wa.me/62812xxxxxx" target="_blank" class="flex items-center justify-between p-4 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-[#f8f9fa] border border-[#dee2e6] flex items-center justify-center text-[#8a969c] group-hover:bg-white group-hover:text-[#ebb751] dark:bg-[#15151b] dark:border-[#37394d]"><i class="ti ti-receipt-2 text-xl"></i></div>
                                <div>
                                    <p class="font-bold text-[#313a46] dark:text-white text-sm">Tim Finance</p>
                                    <p class="text-xs text-[#8a969c]">Tagihan & Pembayaran</p>
                                </div>
                            </div>
                            <i class="ti ti-chevron-right text-[#a1a9b1]"></i>
                        </a>

                        <a href="https://wa.me/62812xxxxxx" target="_blank" class="flex items-center justify-between p-4 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-[#f8f9fa] border border-[#dee2e6] flex items-center justify-center text-[#8a969c] group-hover:bg-white group-hover:text-[#ed6060] dark:bg-[#15151b] dark:border-[#37394d]"><i class="ti ti-router text-xl"></i></div>
                                <div>
                                    <p class="font-bold text-[#313a46] dark:text-white text-sm">Tim NOC (Teknis 24/7)</p>
                                    <p class="text-xs text-[#8a969c]">Komplain Gangguan Jaringan</p>
                                </div>
                            </div>
                            <i class="ti ti-chevron-right text-[#a1a9b1]"></i>
                        </a>
                    </div>
                </div>

                <div class="boron-card">
                    <div class="boron-card-body p-5">
                        <ul class="space-y-4 text-sm">
                            <li class="flex items-center gap-3 text-[#4c4c5c] dark:text-[#aab8c5]"><i class="ti ti-phone text-lg text-[#8a969c]"></i> 021-397 00 444</li>
                            <li class="flex items-center gap-3 text-[#4c4c5c] dark:text-[#aab8c5]"><i class="ti ti-mail text-lg text-[#8a969c]"></i> admin.office@mediasolusisukses.co.id</li>
                            <li class="flex items-center gap-3 text-[#4c4c5c] dark:text-[#aab8c5]"><i class="ti ti-world text-lg text-[#8a969c]"></i> www.mediasolusisukses.co.id</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    @else

        @if($customer->status === 'menunggu_verifikasi')
            <div class="mb-6 rounded-[0.3rem] border border-[#60addf]/30 bg-[#60addf]/10 p-4">
                <div class="flex items-start gap-3">
                    <i class="ti ti-info-circle text-xl text-[#60addf]"></i>
                    <div>
                        <h5 class="text-sm font-semibold text-[#1e5d87] dark:text-[#60addf]">Status: Menunggu Verifikasi Dokumen</h5>
                        <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">Terima kasih telah mendaftar layanan PT Media Solusi Sukses. Saat ini, tim kami sedang memeriksa kelengkapan data dan dokumen Anda.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'menunggu_invoice')
            <div class="mb-6 rounded-[0.3rem] border border-[#ebb751]/30 bg-[#ebb751]/10 p-4">
                <div class="flex items-start gap-3">
                    <i class="ti ti-file-invoice text-xl text-[#ebb751]"></i>
                    <div>
                        <h5 class="text-sm font-semibold text-[#b58c3d] dark:text-[#ebb751]">Status: Pembuatan Invoice</h5>
                        <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">Data Anda telah diverifikasi! Saat ini tim Finance kami sedang menerbitkan tagihan (Invoice).</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'menunggu_pembayaran')
            <div class="mb-6 rounded-[0.3rem] border border-[#ebb751]/30 bg-[#ebb751]/10 p-4">
                <div class="flex items-start gap-3">
                    <i class="ti ti-receipt text-xl text-[#ebb751]"></i>
                    <div>
                        <h5 class="text-sm font-semibold text-[#b58c3d] dark:text-[#ebb751]">Status: Menunggu Pembayaran Registrasi</h5>
                        <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">Tagihan awal telah diterbitkan. Silakan cek detail di bawah, lakukan pembayaran, dan unggah bukti transfer.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'verifikasi_pembayaran')
            <div class="mb-6 rounded-[0.3rem] border border-[#60addf]/30 bg-[#60addf]/10 p-4">
                <div class="flex items-start gap-3">
                    <i class="ti ti-search text-xl text-[#60addf]"></i>
                    <div>
                        <h5 class="text-sm font-semibold text-[#1e5d87] dark:text-[#60addf]">Status: Verifikasi Pembayaran</h5>
                        <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">Bukti pembayaran Anda telah kami terima. Tim Finance kami sedang melakukan pengecekan.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'menunggu_baa')
            <div class="mb-6 rounded-[0.3rem] border border-[#60addf]/30 bg-[#60addf]/10 p-4">
                <div class="flex items-start gap-3">
                    <i class="ti ti-signature text-xl text-[#60addf]"></i>
                    <div>
                        <h5 class="text-sm font-semibold text-[#1e5d87] dark:text-[#60addf]">Status: Menunggu Tanda Tangan BAA</h5>
                        <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">Layanan internet Anda telah aktif! Silakan download dokumen BAA di bawah, tandatangani, lalu upload kembali file tersebut.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'verifikasi_baa')
            <div class="mb-6 rounded-[0.3rem] border border-[#ebb751]/30 bg-[#ebb751]/10 p-4">
                <div class="flex items-start gap-3">
                    <i class="ti ti-file-check text-xl text-[#ebb751]"></i>
                    <div>
                        <h5 class="text-sm font-semibold text-[#b58c3d] dark:text-[#ebb751]">Status: Verifikasi BAA Akhir</h5>
                        <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">BAA Anda sedang diverifikasi. Mohon tunggu sesaat hingga layanan dinyatakan selesai sepenuhnya.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'ditolak')
            <div class="mb-6 rounded-[0.3rem] border border-[#ed6060]/30 bg-[#ed6060]/10 p-4">
                <div class="flex items-start gap-3">
                    <i class="ti ti-x text-xl text-[#ed6060]"></i>
                    <div>
                        <h5 class="text-sm font-semibold text-[#a84444] dark:text-[#ed6060]">Status: Pendaftaran Ditolak</h5>
                        <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">Mohon maaf, pendaftaran Anda tidak dapat dilanjutkan. Silakan hubungi dukungan kami.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6 rounded-[0.3rem] border border-[#70bb63]/30 bg-[#70bb63]/10 p-4">
                <div class="flex items-start gap-3">
                    <i class="ti ti-settings text-xl text-[#70bb63] animate-spin-slow"></i>
                    <div>
                        <h5 class="text-sm font-semibold text-[#4a8a3f] dark:text-[#70bb63]">Status: Layanan Diproses NOC</h5>
                        <p class="mt-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">Pembayaran telah dikonfirmasi. Saat ini tim lapangan kami sedang memproses instalasi fisik Anda.</p>
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
                            'menunggu_verifikasi', 'menunggu_invoice', 'menunggu_pembayaran', 'verifikasi_pembayaran', 'pembayaran_disetujui', 
                            'proses_instalasi', 'proses_aktivasi', 'review_baa', 'menunggu_baa', 'verifikasi_baa', 'selesai'
                        ];
                        
                        $currentIndex = array_search($customer->status, $statusOrder);
                        
                        $workflows = [
                            ['id' => 'menunggu_verifikasi', 'title' => 'Menunggu Verifikasi', 'desc' => 'Tim kami sedang memverifikasi data KTP/NPWP dan layanan Anda.', 'icon' => 'ti-shield-check'],
                            ['id' => 'menunggu_invoice', 'title' => 'Menunggu Invoice', 'desc' => 'Tim Finance sedang menghitung biaya dan menyusun Invoice Anda.', 'icon' => 'ti-file-invoice'],
                            ['id' => 'menunggu_pembayaran', 'title' => 'Menunggu Pembayaran', 'desc' => 'Penerbitan tagihan awal (Invoice) untuk biaya langganan/instalasi.', 'icon' => 'ti-receipt'],
                            ['id' => 'verifikasi_pembayaran', 'title' => 'Cek Bukti Transfer', 'desc' => 'Tim Finance sedang memverifikasi keabsahan bukti pembayaran Anda.', 'icon' => 'ti-search'],
                            ['id' => 'pembayaran_disetujui', 'title' => 'Pembayaran Disetujui', 'desc' => 'Verifikasi pembayaran oleh departemen Finance selesai.', 'icon' => 'ti-cash'],
                            ['id' => 'proses_instalasi', 'title' => 'Proses Instalasi', 'desc' => 'Penjadwalan dan pemasangan perangkat fisik oleh tim NOC.', 'icon' => 'ti-router'],
                            ['id' => 'proses_aktivasi', 'title' => 'Proses Aktivasi & Setting', 'desc' => 'Konfigurasi jaringan dan aktivasi bandwidth internet.', 'icon' => 'ti-wifi'],
                            ['id' => 'review_baa', 'title' => 'Pembuatan Dokumen BAA', 'desc' => 'Tim kami sedang menyusun dan mengecek Berita Acara Aktivasi.', 'icon' => 'ti-file-description'],
                            ['id' => 'menunggu_baa', 'title' => 'Tanda Tangan BAA', 'desc' => 'Download, tandatangani, dan upload dokumen BAA Anda.', 'icon' => 'ti-signature'],
                            ['id' => 'verifikasi_baa', 'title' => 'Verifikasi BAA', 'desc' => 'Tim kami sedang memverifikasi dokumen BAA Anda secara final.', 'icon' => 'ti-file-check'],
                            ['id' => 'selesai', 'title' => 'Selesai & Aktif', 'desc' => 'Layanan internet aktif dan siap digunakan secara penuh.', 'icon' => 'ti-circle-check'],
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
                                    <div class="w-full">
                                        <h5 class="text-base font-semibold {{ $state === 'active' ? 'text-[#60addf]' : ($state === 'completed' ? 'text-[#313a46] dark:text-white' : 'text-[#8a969c]') }}">
                                            {{ $step['title'] }}
                                        </h5>
                                        <p class="mt-1 text-sm {{ $state === 'pending' ? 'text-[#a1a9b1]' : 'text-[#4c4c5c] dark:text-[#aab8c5]' }}">
                                            {{ $step['desc'] }}
                                        </p>
                                        
                                        {{-- FORM UPLOAD INVOICE --}}
                                        @if($state === 'active' && $step['id'] === 'menunggu_pembayaran')
                                            <div class="mt-4 flex flex-wrap gap-2 items-center">
                                                <a href="{{ route('customer.invoice', $customer->id) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 px-3 py-1.5 text-xs font-semibold text-[#60addf] border border-[#60addf]/30 hover:bg-[#60addf] hover:text-white transition-colors">
                                                    <i class="ti ti-file-invoice text-sm"></i> Lihat Invoice
                                                </a>

                                                <div class="relative">
                                                    <input type="file" wire:model.live="payment_proof" id="upload-proof" class="hidden" accept="image/*">
                                                    <label for="upload-proof" class="inline-flex items-center gap-1.5 rounded bg-[#669776] px-3 py-1.5 text-xs font-semibold text-white shadow-md shadow-[#669776]/30 hover:bg-[#527a5f] transition-colors cursor-pointer" wire:loading.class="opacity-50" wire:target="payment_proof">
                                                        <i class="ti ti-upload text-sm"></i> 
                                                        <span wire:loading.remove wire:target="payment_proof">Pilih Bukti Transfer</span>
                                                        <span wire:loading wire:target="payment_proof">Memproses...</span>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            @error('payment_proof') <span class="text-[10px] text-[#ed6060] block mt-1">{{ $message }}</span> @enderror
                                            
                                            @if($payment_proof)
                                                <div class="mt-3 p-3 rounded border border-[#e7e9eb] bg-[#f8f9fa] dark:border-[#37394d] dark:bg-white/5 flex flex-wrap items-center justify-between gap-3">
                                                    <div class="flex items-center gap-2 text-sm text-[#313a46] dark:text-white overflow-hidden">
                                                        <i class="ti ti-photo text-[#669776] shrink-0"></i> 
                                                        <span class="truncate max-w-[200px]">{{ $payment_proof->getClientOriginalName() }}</span>
                                                    </div>
                                                    <button wire:click="uploadPayment" wire:loading.attr="disabled" class="btn-boron btn-boron-primary !px-3 !py-1 text-xs shadow-md shadow-[#669776]/30 shrink-0">
                                                        <i class="ti ti-send"></i> Kirim Bukti
                                                    </button>
                                                </div>
                                            @endif
                                        @endif

                                        {{-- FORM UPLOAD BAA --}}
                                        @if($state === 'active' && $step['id'] === 'menunggu_baa')
                                            <div class="mt-4 flex flex-wrap gap-2 items-center">
                                                <a href="{{ route('noc.baa', $customer->id) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 px-3 py-1.5 text-xs font-semibold text-[#60addf] border border-[#60addf]/30 hover:bg-[#60addf] hover:text-white transition-colors">
                                                    <i class="ti ti-download text-sm"></i> 1. Download BAA
                                                </a>

                                                <div class="relative">
                                                    <input type="file" wire:model.live="signed_baa" id="upload-baa" class="hidden" accept=".pdf,image/*">
                                                    <label for="upload-baa" class="inline-flex items-center gap-1.5 rounded bg-[#669776] px-3 py-1.5 text-xs font-semibold text-white shadow-md shadow-[#669776]/30 hover:bg-[#527a5f] transition-colors cursor-pointer" wire:loading.class="opacity-50" wire:target="signed_baa">
                                                        <i class="ti ti-upload text-sm"></i> 
                                                        <span wire:loading.remove wire:target="signed_baa">2. Upload BAA yg di TTD</span>
                                                        <span wire:loading wire:target="signed_baa">Memproses...</span>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            @error('signed_baa') <span class="text-[10px] text-[#ed6060] block mt-1">{{ $message }}</span> @enderror
                                            
                                            @if($signed_baa)
                                                <div class="mt-3 p-3 rounded border border-[#e7e9eb] bg-[#f8f9fa] dark:border-[#37394d] flex items-center justify-between gap-3">
                                                    <div class="flex items-center gap-2 text-sm truncate max-w-[200px] text-[#313a46] dark:text-white"><i class="ti ti-file text-[#669776]"></i> {{ $signed_baa->getClientOriginalName() }}</div>
                                                    <button wire:click="uploadSignedBaa" wire:loading.attr="disabled" class="btn-boron btn-boron-primary !px-3 !py-1 text-xs shrink-0"><i class="ti ti-send"></i> Kirim</button>
                                                </div>
                                            @endif
                                        @endif

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
                                {{ $customer->customer_number ?? 'Menunggu BAA NOC' }}
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
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>