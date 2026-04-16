<div class="py-6" wire:poll.10s="loadCustomer">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div>
            <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">{{ __('Dashboard Pelanggan') }}</h4>
            <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">
                {{ __('Selamat datang, :name.', ['name' => auth()->user()->name]) }}
            </p>
        </div>
        <div class="hidden md:flex items-center gap-2 text-sm text-[#8a969c]">
            <i class="ti ti-home text-base"></i>
            <span>/</span>
            <span class="font-medium text-[#313a46] dark:text-white">{{ __('Dashboard') }}</span>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 rounded-lg md:rounded-[0.3rem] border border-[#70bb63]/30 bg-[#70bb63]/10 p-4 md:p-3 text-sm text-[#70bb63] flex items-start gap-2">
            <i class="ti ti-check text-lg mt-0.5"></i> 
            <span class="flex-1">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('info'))
        <div class="mb-6 rounded-lg md:rounded-[0.3rem] border border-[#60addf]/30 bg-[#60addf]/10 p-4 md:p-3 text-sm text-[#60addf] flex items-start gap-2">
            <i class="ti ti-info-circle text-lg mt-0.5"></i> 
            <span class="flex-1">{{ session('info') }}</span>
        </div>
    @endif

    @if($customer->status === 'selesai')
        
        <div class="boron-card rounded-2xl bg-gradient-to-r from-[#1e5d87] to-[#60addf] border-0 mb-6 md:mb-8 text-white overflow-hidden relative shadow-lg shadow-[#60addf]/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 size-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute bottom-0 right-20 -mb-10 size-32 rounded-full bg-black/10 blur-xl"></div>
            
            <div class="boron-card-body p-6 md:p-8 relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <h2 class="text-xl md:text-2xl text-black/80 font-bold mb-3 md:mb-2">Selamat Bergabung Bersama Kami! 🎉</h2>
                    <p class="text-black/80 text-sm md:text-base max-w-2xl leading-relaxed">Layanan internet Anda telah aktif sepenuhnya. Terima kasih telah mempercayakan kebutuhan konektivitas perusahaan Anda kepada PT Media Solusi Sukses. Kami berkomitmen memberikan layanan terbaik untuk Anda.</p>
                </div>
                <div class="w-full md:w-auto shrink-0 text-center md:text-right bg-white/10 p-4 rounded-xl backdrop-blur-sm border border-white/20">
                    <p class="text-[11px] md:text-xs uppercase tracking-wider text-black/80 font-semibold mb-1">ID Pelanggan Anda</p>
                    <p class="text-2xl md:text-3xl font-black text-[#ebb751]">{{ $customer->customer_number }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6 md:space-y-8">
                
                <div class="boron-card border-t-4 border-t-[#669776] shadow-sm rounded-2xl">
                    <div class="boron-card-body p-5 md:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 sm:gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex size-12 md:size-14 items-center justify-center rounded-full bg-[#669776]/10 text-[#669776] shrink-0">
                                <i class="ti ti-network text-2xl md:text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-[11px] md:text-xs font-semibold uppercase text-[#8a969c]">Paket Layanan Aktif</p>
                                <h6 class="text-lg md:text-xl font-bold text-[#313a46] dark:text-white">{{ $customer->bandwidth }}</h6>
                                <p class="text-xs md:text-sm text-[#4c4c5c] dark:text-[#aab8c5] mt-0.5">{{ $customer->service_type }}</p>
                            </div>
                        </div>
                        <div class="w-full sm:w-auto mt-2 sm:mt-0 text-left sm:text-right border-t border-[#e7e9eb] sm:border-0 pt-4 sm:pt-0 dark:border-[#37394d]">
                            <a href="{{ route('noc.baa', $customer->id) }}" target="_blank" class="w-full sm:w-auto flex justify-center items-center btn-boron btn-boron-outline-primary !py-2.5 sm:!py-2 !px-5 sm:!px-4 text-sm shadow-sm rounded-full">
                                <i class="ti ti-file-certificate mr-1.5 sm:mr-1 text-lg"></i> Lihat Dokumen BAA
                            </a>
                        </div>
                    </div>
                </div>

                <div class="boron-card bg-[#f8f9fa] dark:bg-[#15151b] border border-[#e7e9eb] dark:border-[#37394d] shadow-sm rounded-2xl">
                    <div class="boron-card-header pb-2 border-b-0 pt-6 px-5 md:px-6">
                        <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf] text-center text-base md:text-lg">Keuntungan Berlangganan Bersama Kami:</h5>
                    </div>
                    <div class="boron-card-body p-5 md:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-2xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1">
                                <div class="bg-[#eef2f6] dark:bg-white/5 p-2 rounded-xl text-[#1e5d87] dark:text-[#60addf] shrink-0"><i class="ti ti-headset text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">NOC 24/7</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Layanan support siap bantu kapan saja.</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-2xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1">
                                <div class="bg-[#fff4e5] dark:bg-white/5 p-2 rounded-xl text-[#ebb751] shrink-0"><i class="ti ti-map-pin text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">IP Publik</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Akses mudah untuk server bisnis Anda.</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-2xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1">
                                <div class="bg-[#eefcf2] dark:bg-white/5 p-2 rounded-xl text-[#70bb63] shrink-0"><i class="ti ti-file-certificate text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">PKS Terjamin</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Legalitas resmi, layanan lebih aman.</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-2xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1">
                                <div class="bg-[#fceeee] dark:bg-white/5 p-2 rounded-xl text-[#ed6060] shrink-0"><i class="ti ti-shirt text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">Seragam Klien</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Mendapat merchandise/seragam eksklusif.</p>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1e1f27] p-4 rounded-2xl shadow-sm border border-[#e7e9eb] dark:border-[#37394d] flex items-start gap-3 transform transition hover:-translate-y-1 sm:col-span-2 lg:col-span-1">
                                <div class="bg-[#eef2f6] dark:bg-white/5 p-2 rounded-xl text-[#60addf] shrink-0"><i class="ti ti-device-desktop-analytics text-2xl"></i></div>
                                <div>
                                    <h6 class="font-bold text-[#313a46] dark:text-white text-sm mb-1">MRTG Pantau</h6>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Pantau grafik jaringan Anda real-time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6 md:space-y-8 mt-2 lg:mt-0">
                <div class="boron-card shadow-sm rounded-2xl overflow-hidden border-0">
                    <div class="bg-[#60addf] text-white p-5 flex items-center gap-4">
                        <i class="ti ti-headset text-3xl"></i>
                        <div>
                            <h5 class="font-bold text-lg">Butuh Bantuan?</h5>
                            <p class="text-xs text-white/80 mt-0.5">Hubungi tim kami kapan saja.</p>
                        </div>
                    </div>
                    <div class="boron-card-body p-0 divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        <a href="https://wa.me/62812xxxxxx" target="_blank" class="flex items-center justify-between p-4 md:p-5 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="size-11 rounded-full bg-[#f8f9fa] border border-[#dee2e6] flex items-center justify-center text-[#8a969c] group-hover:bg-[#60addf]/10 group-hover:text-[#60addf] group-hover:border-[#60addf]/30 transition-all dark:bg-[#15151b] dark:border-[#37394d]"><i class="ti ti-messages text-xl"></i></div>
                                <div>
                                    <p class="font-bold text-[#313a46] dark:text-white text-sm">Customer Service</p>
                                    <p class="text-[11px] text-[#8a969c] mt-0.5">Pertanyaan Umum / Info</p>
                                </div>
                            </div>
                            <i class="ti ti-chevron-right text-[#a1a9b1] group-hover:text-[#60addf] group-hover:translate-x-1 transition-all"></i>
                        </a>
                        
                        <a href="https://wa.me/62812xxxxxx" target="_blank" class="flex items-center justify-between p-4 md:p-5 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="size-11 rounded-full bg-[#f8f9fa] border border-[#dee2e6] flex items-center justify-center text-[#8a969c] group-hover:bg-[#ebb751]/10 group-hover:text-[#ebb751] group-hover:border-[#ebb751]/30 transition-all dark:bg-[#15151b] dark:border-[#37394d]"><i class="ti ti-receipt-2 text-xl"></i></div>
                                <div>
                                    <p class="font-bold text-[#313a46] dark:text-white text-sm">Tim Finance</p>
                                    <p class="text-[11px] text-[#8a969c] mt-0.5">Tagihan & Pembayaran</p>
                                </div>
                            </div>
                            <i class="ti ti-chevron-right text-[#a1a9b1] group-hover:text-[#ebb751] group-hover:translate-x-1 transition-all"></i>
                        </a>

                        <a href="https://wa.me/62812xxxxxx" target="_blank" class="flex items-center justify-between p-4 md:p-5 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="size-11 rounded-full bg-[#f8f9fa] border border-[#dee2e6] flex items-center justify-center text-[#8a969c] group-hover:bg-[#ed6060]/10 group-hover:text-[#ed6060] group-hover:border-[#ed6060]/30 transition-all dark:bg-[#15151b] dark:border-[#37394d]"><i class="ti ti-router text-xl"></i></div>
                                <div>
                                    <p class="font-bold text-[#313a46] dark:text-white text-sm">Tim NOC (Teknis 24/7)</p>
                                    <p class="text-[11px] text-[#8a969c] mt-0.5">Komplain / Gangguan</p>
                                </div>
                            </div>
                            <i class="ti ti-chevron-right text-[#a1a9b1] group-hover:text-[#ed6060] group-hover:translate-x-1 transition-all"></i>
                        </a>
                    </div>
                </div>

                <div class="boron-card shadow-sm rounded-2xl">
                    <div class="boron-card-body p-5">
                        <ul class="space-y-4 text-xs md:text-sm">
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
            <div class="mb-6 rounded-2xl border border-[#60addf]/30 bg-[#60addf]/10 p-4 md:p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                    <div class="bg-white/50 dark:bg-black/20 p-3 rounded-full shrink-0 self-start sm:self-center"><i class="ti ti-info-circle text-2xl md:text-3xl text-[#60addf]"></i></div>
                    <div>
                        <h5 class="text-sm md:text-base font-bold text-[#1e5d87] dark:text-[#60addf]">Menunggu Verifikasi Dokumen</h5>
                        <p class="mt-1 text-[13px] md:text-sm text-[#4c4c5c] dark:text-[#aab8c5] leading-relaxed">Terima kasih telah mendaftar layanan PT Media Solusi Sukses. Saat ini, tim kami sedang memeriksa kelengkapan data dan dokumen Anda.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'menunggu_invoice')
            <div class="mb-6 rounded-2xl border border-[#ebb751]/30 bg-[#ebb751]/10 p-4 md:p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                    <div class="bg-white/50 dark:bg-black/20 p-3 rounded-full shrink-0 self-start sm:self-center"><i class="ti ti-file-invoice text-2xl md:text-3xl text-[#ebb751]"></i></div>
                    <div>
                        <h5 class="text-sm md:text-base font-bold text-[#b58c3d] dark:text-[#ebb751]">Proses Pembuatan Invoice</h5>
                        <p class="mt-1 text-[13px] md:text-sm text-[#4c4c5c] dark:text-[#aab8c5] leading-relaxed">Data Anda telah diverifikasi! Saat ini tim Finance kami sedang menerbitkan tagihan (Invoice).</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'menunggu_pembayaran')
            <div class="mb-6 rounded-2xl border border-[#ebb751]/30 bg-[#ebb751]/10 p-4 md:p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                    <div class="bg-white/50 dark:bg-black/20 p-3 rounded-full shrink-0 self-start sm:self-center animate-bounce"><i class="ti ti-receipt text-2xl md:text-3xl text-[#ebb751]"></i></div>
                    <div>
                        <h5 class="text-sm md:text-base font-bold text-[#b58c3d] dark:text-[#ebb751]">Menunggu Pembayaran Registrasi</h5>
                        <p class="mt-1 text-[13px] md:text-sm text-[#4c4c5c] dark:text-[#aab8c5] leading-relaxed">Tagihan awal telah diterbitkan. Silakan cek detail di bawah, lakukan pembayaran, dan unggah bukti transfer.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'verifikasi_pembayaran')
            <div class="mb-6 rounded-2xl border border-[#60addf]/30 bg-[#60addf]/10 p-4 md:p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                    <div class="bg-white/50 dark:bg-black/20 p-3 rounded-full shrink-0 self-start sm:self-center"><i class="ti ti-search text-2xl md:text-3xl text-[#60addf] animate-pulse"></i></div>
                    <div>
                        <h5 class="text-sm md:text-base font-bold text-[#1e5d87] dark:text-[#60addf]">Verifikasi Pembayaran</h5>
                        <p class="mt-1 text-[13px] md:text-sm text-[#4c4c5c] dark:text-[#aab8c5] leading-relaxed">Bukti pembayaran Anda telah kami terima. Tim Finance kami sedang melakukan pengecekan ke Mutasi Rekening Perusahaan.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'menunggu_baa')
            <div class="mb-6 rounded-2xl border border-[#60addf]/30 bg-[#60addf]/10 p-4 md:p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                    <div class="bg-white/50 dark:bg-black/20 p-3 rounded-full shrink-0 self-start sm:self-center animate-bounce"><i class="ti ti-signature text-2xl md:text-3xl text-[#60addf]"></i></div>
                    <div>
                        <h5 class="text-sm md:text-base font-bold text-[#1e5d87] dark:text-[#60addf]">Menunggu Tanda Tangan BAA</h5>
                        <p class="mt-1 text-[13px] md:text-sm text-[#4c4c5c] dark:text-[#aab8c5] leading-relaxed">Layanan internet Anda telah aktif! Silakan scroll ke bawah, download dokumen BAA, tandatangani, lalu upload kembali file tersebut ke sistem.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'verifikasi_baa')
            <div class="mb-6 rounded-2xl border border-[#ebb751]/30 bg-[#ebb751]/10 p-4 md:p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                    <div class="bg-white/50 dark:bg-black/20 p-3 rounded-full shrink-0 self-start sm:self-center"><i class="ti ti-file-check text-2xl md:text-3xl text-[#ebb751] animate-pulse"></i></div>
                    <div>
                        <h5 class="text-sm md:text-base font-bold text-[#b58c3d] dark:text-[#ebb751]">Verifikasi BAA Akhir</h5>
                        <p class="mt-1 text-[13px] md:text-sm text-[#4c4c5c] dark:text-[#aab8c5] leading-relaxed">Dokumen BAA Anda sedang diverifikasi. Mohon tunggu sesaat hingga layanan dinyatakan selesai sepenuhnya oleh tim kami.</p>
                    </div>
                </div>
            </div>
        @elseif($customer->status === 'ditolak')
            <div class="mb-6 rounded-2xl border border-[#ed6060]/30 bg-[#ed6060]/10 p-4 md:p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                    <div class="bg-white/50 dark:bg-black/20 p-3 rounded-full shrink-0 self-start sm:self-center"><i class="ti ti-x text-2xl md:text-3xl text-[#ed6060]"></i></div>
                    <div>
                        <h5 class="text-sm md:text-base font-bold text-[#a84444] dark:text-[#ed6060]">Pendaftaran Ditolak</h5>
                        <p class="mt-1 text-[13px] md:text-sm text-[#4c4c5c] dark:text-[#aab8c5] leading-relaxed">Mohon maaf, pendaftaran Anda tidak dapat dilanjutkan saat ini. Silakan hubungi dukungan kami untuk informasi lebih lanjut.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6 rounded-2xl border border-[#70bb63]/30 bg-[#70bb63]/10 p-4 md:p-5 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                    <div class="bg-white/50 dark:bg-black/20 p-3 rounded-full shrink-0 self-start sm:self-center"><i class="ti ti-settings text-2xl md:text-3xl text-[#70bb63] animate-spin-slow"></i></div>
                    <div>
                        <h5 class="text-sm md:text-base font-bold text-[#4a8a3f] dark:text-[#70bb63]">Layanan Sedang Diproses NOC</h5>
                        <p class="mt-1 text-[13px] md:text-sm text-[#4c4c5c] dark:text-[#aab8c5] leading-relaxed">
                            @if($customer->registration_fee == 0)
                                Pendaftaran Anda mendapatkan promo Gratis Biaya Registrasi. Saat ini tim NOC (Teknis) kami sedang menyusun jadwal dan memproses instalasi fisik di lokasi Anda.
                            @else
                                Pembayaran Anda telah sukses dikonfirmasi. Saat ini tim NOC (Teknis) kami sedang menyusun jadwal dan memproses instalasi fisik di lokasi Anda.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid gap-6 md:gap-8 lg:grid-cols-3">
            
            <div class="bg-white dark:bg-[#1e1f27] lg:col-span-2 shadow-sm rounded-3xl border border-[#e7e9eb] dark:border-[#37394d] overflow-hidden">
                <div class="p-6 md:p-8">
                    @php
                        $statusOrder = [
                            'menunggu_verifikasi', 'menunggu_invoice', 'menunggu_pembayaran', 'verifikasi_pembayaran', 'pembayaran_disetujui', 
                            'proses_instalasi', 'proses_aktivasi', 'review_baa', 'menunggu_baa', 'verifikasi_baa', 'selesai'
                        ];
                        
                        $currentIndex = array_search($customer->status, $statusOrder);
                        if ($currentIndex === false) $currentIndex = 0;
                        $totalSteps = count($statusOrder);
                        $percentage = round(($currentIndex / ($totalSteps - 1)) * 100);
                        
                        $workflows = [
                            ['id' => 'menunggu_verifikasi', 'title' => 'Menunggu Verifikasi', 'desc' => 'Tim kami sedang memverifikasi data dan layanan Anda.', 'icon' => 'ti-shield-check'],
                            ['id' => 'menunggu_invoice', 'title' => 'Pembuatan Invoice', 'desc' => 'Pembuatan invoice registrasi/instalasi oleh tim Finance.', 'icon' => 'ti-file-invoice'],
                            ['id' => 'menunggu_pembayaran', 'title' => 'Menunggu Pembayaran', 'desc' => $customer->registration_fee == 0 ? 'Biaya instalasi/registrasi digratiskan (Free). Tahap pembayaran dilewati.' : 'Penerbitan tagihan awal dan menunggu pembayaran Anda.', 'icon' => 'ti-receipt'],
                            ['id' => 'verifikasi_pembayaran', 'title' => 'Cek Bukti Transfer', 'desc' => $customer->registration_fee == 0 ? 'Otomatis terverifikasi karena program registrasi gratis.' : 'Tim Finance memverifikasi keabsahan pembayaran Anda.', 'icon' => 'ti-search'],
                            ['id' => 'pembayaran_disetujui', 'title' => 'Pembayaran Disetujui', 'desc' => $customer->registration_fee == 0 ? 'Layanan langsung diteruskan ke tim Instalasi NOC.' : 'Verifikasi pembayaran oleh departemen Finance selesai.', 'icon' => 'ti-cash'],
                            ['id' => 'proses_instalasi', 'title' => 'Proses Instalasi', 'desc' => 'Pemasangan perangkat fisik di lokasi Anda oleh tim NOC.', 'icon' => 'ti-router'],
                            ['id' => 'proses_aktivasi', 'title' => 'Proses Aktivasi & Setting', 'desc' => 'Konfigurasi jaringan dan aktivasi bandwidth internet Anda.', 'icon' => 'ti-wifi'],
                            ['id' => 'review_baa', 'title' => 'Pembuatan Dokumen', 'desc' => 'Pembuatan Berita Acara Aktivasi (BAA) oleh tim kami.', 'icon' => 'ti-file-description'],
                            ['id' => 'menunggu_baa', 'title' => 'Tanda Tangan BAA', 'desc' => 'Mohon download, tandatangani, dan upload dokumen BAA.', 'icon' => 'ti-signature'],
                            ['id' => 'verifikasi_baa', 'title' => 'Verifikasi BAA', 'desc' => 'Tim kami memverifikasi dokumen BAA Anda secara final.', 'icon' => 'ti-file-check'],
                            ['id' => 'selesai', 'title' => 'Selesai & Aktif', 'desc' => 'Layanan internet Anda sudah aktif dan siap digunakan.', 'icon' => 'ti-circle-check'],
                        ];
                    @endphp

                    <div class="flex items-center justify-between mb-8 md:mb-10">
                        <div class="border border-[#e7e9eb] rounded-full px-4 md:px-5 py-1.5 md:py-2 text-sm font-bold text-[#313a46] dark:text-white dark:border-[#37394d] bg-white dark:bg-[#15151b] shadow-sm z-10">
                            Timeline
                        </div>
                        <div class="flex-1 border-t-2 border-dashed border-[#e7e9eb] dark:border-[#37394d] mx-2 md:mx-4 -mt-1 relative z-0"></div>
                        <div class="bg-[#60addf]/10 text-[#60addf] rounded-full px-3 md:px-5 py-1.5 md:py-2 text-xs md:text-sm font-bold flex items-center gap-1.5 md:gap-2 z-10 whitespace-nowrap">
                            <i class="ti ti-check bg-[#60addf] text-white rounded-full p-0.5 text-[10px] md:text-xs"></i> In Progress
                        </div>
                    </div>

                    <div class="mb-10 md:mb-12">
                        <div class="flex items-center justify-between text-sm md:text-base font-bold text-[#313a46] dark:text-white mb-3">
                            <span>Progres: {{ $percentage }}%</span>
                            @if($customer->status !== 'selesai' && $customer->status !== 'ditolak')
                                <span class="text-xs md:text-sm text-[#8a969c] font-medium hidden sm:inline-block">Estimasi Selesai: Segera</span>
                            @endif
                        </div>
                        <div class="w-full bg-[#f8f9fa] dark:bg-[#15151b] rounded-full h-3 md:h-4 border border-[#e7e9eb] dark:border-[#37394d] overflow-hidden">
                            <div class="bg-[#60addf] h-full rounded-full transition-all duration-1000 ease-out relative" style="width: {{ $percentage }}%">
                                <div class="absolute inset-0 bg-white/20 overflow-hidden">
                                    <div class="h-full w-full bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-0 pl-1 md:pl-2">
                        
                        <div class="flex gap-4 md:gap-6 group">
                            <div class="flex flex-col items-center">
                                <div class="size-12 md:size-14 rounded-full border border-[#70bb63] flex items-center justify-center bg-[#70bb63]/10 text-[#70bb63] z-10 shrink-0">
                                    <i class="ti ti-file-check text-xl md:text-2xl"></i>
                                </div>
                                <div class="w-[2px] bg-[#70bb63] h-full my-2 group-last:hidden"></div>
                            </div>
                            <div class="flex-1 pb-8 md:pb-10 flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                                <div>
                                    <h5 class="text-base md:text-lg font-bold text-[#313a46] dark:text-white">Form Submit</h5>
                                    <p class="text-[13px] md:text-sm text-[#8a969c] mt-0.5 md:mt-1">Formulir registrasi dan dokumen diserahkan</p>
                                </div>
                                <div class="text-[11px] md:text-[13px] text-[#8a969c] sm:text-right shrink-0 mt-1 sm:mt-0 font-medium">
                                    {{ $customer->created_at->format('d M Y, H:i') }}
                                </div>
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

                                $iconClass = $state === 'completed' ? 'border-[#70bb63] bg-[#70bb63]/10 text-[#70bb63]' : ($state === 'active' ? 'border-[#60addf] bg-[#60addf]/10 text-[#60addf] ring-[6px] ring-[#60addf]/20' : 'border-[#e7e9eb] bg-white text-[#a1a9b1] dark:bg-[#1e1f27] dark:border-[#37394d]');
                                $lineClass = $state === 'completed' ? 'bg-[#70bb63]' : 'bg-[#e7e9eb] dark:bg-[#37394d]';
                            @endphp

                            <div class="flex gap-4 md:gap-6 group">
                                <div class="flex flex-col items-center">
                                    <div class="size-12 md:size-14 rounded-full border flex items-center justify-center z-10 shrink-0 transition-all duration-500 {{ $iconClass }}">
                                        @if($state === 'completed')
                                            <div class="relative">
                                                <i class="ti {{ $step['icon'] }} text-xl md:text-2xl"></i>
                                                <div class="absolute -bottom-1 -right-1 bg-[#70bb63] text-white rounded-full size-4 flex items-center justify-center border-2 border-white dark:border-[#1e1f27]">
                                                    <i class="ti ti-check text-[10px]"></i>
                                                </div>
                                            </div>
                                        @else
                                            <i class="ti {{ $step['icon'] }} text-xl md:text-2xl {{ $state === 'active' ? 'animate-pulse' : '' }}"></i>
                                        @endif
                                    </div>
                                    <div class="w-[2px] h-full my-2 group-last:hidden transition-all duration-500 {{ $lineClass }}"></div>
                                </div>
                                <div class="flex-1 pb-8 md:pb-10 flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1">
                                    <div class="w-full">
                                        <h5 class="text-base md:text-lg font-bold {{ $state === 'active' ? 'text-[#313a46] dark:text-white' : ($state === 'completed' ? 'text-[#313a46] dark:text-white' : 'text-[#a1a9b1] dark:text-[#6c757d]') }}">
                                            {{ $step['title'] }}
                                            @if($step['id'] === 'menunggu_pembayaran' && $customer->registration_fee == 0)
                                                <span class="ml-2 inline-block shrink-0 text-[10px] font-bold text-[#70bb63] bg-[#70bb63]/10 border border-[#70bb63]/30 px-2 py-0.5 rounded-full align-middle uppercase tracking-wider">Registrasi Gratis</span>
                                            @endif
                                        </h5>
                                        <p class="text-[13px] md:text-sm mt-0.5 md:mt-1 {{ $state === 'active' ? 'text-[#313a46] dark:text-white font-medium' : ($state === 'completed' ? 'text-[#8a969c]' : 'text-[#a1a9b1]/70 dark:text-[#6c757d]/70') }}">{{ $step['desc'] }}</p>

                                        @if($state === 'active' && $step['id'] === 'menunggu_pembayaran' && $customer->registration_fee != 0)
                                            <div class="mt-5 w-full">
                                                <a href="{{ route('customer.invoice', $customer->id) }}" target="_blank" class="w-full flex justify-center items-center gap-2 bg-[#60addf]/10 text-[#60addf] border border-[#60addf]/30 px-4 py-3 rounded-full text-sm font-bold hover:bg-[#60addf] hover:text-white transition-all shadow-sm">
                                                    <i class="ti ti-file-invoice text-lg"></i> Lihat Tagihan Invoice
                                                </a>
                                                <div class="relative mt-2.5">
                                                    <input type="file" wire:model.live="payment_proof" id="upload-proof" class="hidden" accept="image/*">
                                                    <label for="upload-proof" class="w-full flex justify-center items-center gap-2 bg-[#669776] text-white px-4 py-3 rounded-full text-sm font-bold shadow-md shadow-[#669776]/20 hover:bg-[#527a5f] hover:shadow-lg transition-all cursor-pointer" wire:loading.class="opacity-70" wire:target="payment_proof">
                                                        <i class="ti ti-upload text-lg"></i>
                                                        <span wire:loading.remove wire:target="payment_proof">Upload Bukti Transfer</span>
                                                        <span wire:loading wire:target="payment_proof">Memproses File...</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @error('payment_proof')
                                                <div class="mt-3 bg-[#ed6060]/10 border border-[#ed6060]/20 p-2.5 rounded-lg text-xs text-[#ed6060] font-medium flex items-center gap-2">
                                                    <i class="ti ti-alert-circle text-base"></i> {{ $message }}
                                                </div>
                                            @enderror
                                            @if($payment_proof)
                                                <div class="mt-4 p-4 rounded-2xl border border-[#669776]/30 bg-[#f8f9fa] dark:bg-[#15151b] flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                                                    <div class="flex items-center gap-3 overflow-hidden">
                                                        <div class="bg-[#669776]/10 p-2.5 rounded-xl shrink-0"><i class="ti ti-photo text-[#669776] text-xl"></i></div>
                                                        <div class="truncate">
                                                            <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-0.5">File Bukti:</p>
                                                            <p class="text-sm font-bold text-[#313a46] dark:text-white truncate">{{ $payment_proof->getClientOriginalName() }}</p>
                                                        </div>
                                                    </div>
                                                    <button wire:click="uploadPayment" wire:loading.attr="disabled" class="btn-boron btn-boron-primary !px-6 !py-3 text-sm rounded-full w-full sm:w-auto shadow-md shrink-0">
                                                        <i class="ti ti-send text-lg mr-1.5"></i> Kirim
                                                    </button>
                                                </div>
                                            @endif
                                        @endif

                                        @if($state === 'active' && $step['id'] === 'menunggu_baa')
                                            <div class="mt-5 w-full">
                                                <a href="{{ route('noc.baa', $customer->id) }}" target="_blank" class="w-full flex justify-center items-center gap-2 bg-[#60addf]/10 text-[#60addf] border border-[#60addf]/30 px-4 py-3 rounded-full text-sm font-bold hover:bg-[#60addf] hover:text-white transition-all shadow-sm">
                                                    <i class="ti ti-download text-lg"></i> 1. Download BAA
                                                </a>
                                                <div class="relative mt-2.5">
                                                    <input type="file" wire:model.live="signed_baa" id="upload-baa" class="hidden" accept=".pdf,image/*">
                                                    <label for="upload-baa" class="w-full flex justify-center items-center gap-2 bg-[#669776] text-white px-4 py-3 rounded-full text-sm font-bold shadow-md shadow-[#669776]/20 hover:bg-[#527a5f] hover:shadow-lg transition-all cursor-pointer" wire:loading.class="opacity-70" wire:target="signed_baa">
                                                        <i class="ti ti-upload text-lg"></i>
                                                        <span wire:loading.remove wire:target="signed_baa">2. Upload BAA (TTD)</span>
                                                        <span wire:loading wire:target="signed_baa">Memproses File...</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @error('signed_baa')
                                                <div class="mt-3 bg-[#ed6060]/10 border border-[#ed6060]/20 p-2.5 rounded-lg text-xs text-[#ed6060] font-medium flex items-center gap-2">
                                                    <i class="ti ti-alert-circle text-base"></i> {{ $message }}
                                                </div>
                                            @enderror
                                            @if($signed_baa)
                                                <div class="mt-4 p-4 rounded-2xl border border-[#669776]/30 bg-[#f8f9fa] dark:bg-[#15151b] flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                                                    <div class="flex items-center gap-3 overflow-hidden">
                                                        <div class="bg-[#669776]/10 p-2.5 rounded-xl shrink-0"><i class="ti ti-file text-[#669776] text-xl"></i></div>
                                                        <div class="truncate">
                                                            <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-0.5">File Dokumen:</p>
                                                            <p class="text-sm font-bold text-[#313a46] dark:text-white truncate">{{ $signed_baa->getClientOriginalName() }}</p>
                                                        </div>
                                                    </div>
                                                    <button wire:click="uploadSignedBaa" wire:loading.attr="disabled" class="btn-boron btn-boron-primary !px-6 !py-3 text-sm rounded-full w-full sm:w-auto shadow-md shrink-0">
                                                        <i class="ti ti-send text-lg mr-1.5"></i> Kirim
                                                    </button>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="text-[11px] md:text-[13px] text-[#8a969c] sm:text-right shrink-0 mt-1 sm:mt-0 font-medium">
                                        @if($state === 'completed' || $state === 'active')
                                            {{ $customer->updated_at->format('d M Y, H:i') }}
                                        @else
                                            TBA
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6 md:space-y-8 mt-2 lg:mt-0">
                
                <div class="boron-card shadow-sm rounded-2xl">
                    <div class="boron-card-header border-b border-[#e7e9eb] pb-3 pt-4 px-5 dark:border-[#37394d]">
                        <h5 class="font-semibold text-lg md:text-base text-[#313a46] dark:text-white">{{ __('Ringkasan Layanan') }}</h5>
                    </div>
                    <div class="boron-card-body p-5">
                        <div class="flex items-center gap-4 mb-5">
                            <div class="flex size-14 md:size-12 shrink-0 items-center justify-center rounded-xl md:rounded-[0.3rem] bg-[#669776]/10 text-[#669776]">
                                <i class="ti ti-network text-3xl md:text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold uppercase text-[#8a969c]">Paket Pilihan</p>
                                <h6 class="text-lg md:text-base font-bold text-[#313a46] dark:text-white leading-tight">{{ $customer->bandwidth }}</h6>
                                <p class="text-xs text-[#8a969c] mt-0.5">{{ $customer->service_type ?? '-' }}</p>
                            </div>
                        </div>
                        
                        <ul class="space-y-3.5 text-sm md:text-[13px]">
                            <li class="flex justify-between items-center border-b border-dashed border-[#e7e9eb] pb-2.5 dark:border-[#37394d]">
                                <span class="text-[#8a969c]">Masa Kontrak</span>
                                <span class="font-bold md:font-medium text-[#313a46] dark:text-white">{{ $customer->term_of_service ?? '-' }} Tahun</span>
                            </li>
                            <li class="flex justify-between items-center border-b border-dashed border-[#e7e9eb] pb-2.5 dark:border-[#37394d]">
                                <span class="text-[#8a969c]">ID Pelanggan</span>
                                <span class="font-bold text-[#ebb751]">
                                    {{ $customer->customer_number ?? 'Menunggu BAA' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="boron-card shadow-sm rounded-2xl">
                    <div class="boron-card-header border-b border-[#e7e9eb] pb-3 pt-4 px-5 dark:border-[#37394d]">
                        <h5 class="font-semibold text-lg md:text-base text-[#313a46] dark:text-white">{{ __('Data Registrasi') }}</h5>
                    </div>
                    <div class="boron-card-body p-5">
                        <ul class="space-y-4 md:space-y-5 text-sm md:text-[13px]">
                            <li>
                                <p class="text-[11px] font-semibold uppercase text-[#8a969c] mb-1">PT / Instansi</p>
                                <p class="font-bold md:font-medium text-[#313a46] dark:text-white">{{ $customer->company_name ?? '-' }}</p>
                            </li>
                            <li>
                                <p class="text-[11px] font-semibold uppercase text-[#8a969c] mb-1">Alamat Instalasi</p>
                                <p class="font-medium text-[#313a46] dark:text-white leading-relaxed">{{ $customer->installation_address ?? $customer->company_address ?? '-' }}</p>
                            </li>
                            <li>
                                <p class="text-[11px] font-semibold uppercase text-[#8a969c] mb-1">PIC Teknis/Kontak</p>
                                <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->technical_name ?? '-' }} - {{ $customer->technical_phone ?? '-' }}</p>
                                <p class="text-xs text-[#8a969c] mt-0.5 break-words">{{ $customer->technical_email ?? '-' }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    @endif
    <style>
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
    </style>
</div>