<div class="py-6">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('finance.request.index') }}" wire:navigate class="size-10 flex items-center justify-center rounded-full bg-white border border-[#dee2e6] text-[#8a969c] hover:text-[#1e5d87] transition-all shadow-sm">
            <i class="ti ti-arrow-left text-xl"></i>
        </a>
        <div>
            <h4 class="text-xl font-bold text-[#313a46] dark:text-white">Monitoring Finansial: {{ $request->request_number }}</h4>
            <p class="text-sm text-[#8a969c]">Pantau perubahan harga berlangganan dan keabsahan dokumen legal.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="boron-card rounded-2xl border border-[#dee2e6] shadow-sm dark:border-[#37394d]">
                <div class="boron-card-header border-b border-[#e7e9eb] p-5 dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                    <h5 class="font-bold text-[#1e5d87] flex items-center gap-2">
                        <i class="ti ti-building"></i> Data Pelanggan
                    </h5>
                    <span class="px-3 py-1 {{ $request->request_type === 'Terminate' ? 'bg-[#ed6060]/10 text-[#ed6060] border-[#ed6060]/20' : 'bg-[#1e5d87]/10 text-[#1e5d87] border-[#1e5d87]/20' }} font-bold text-xs rounded-lg border uppercase">
                        {{ $request->request_type }}
                    </span>
                </div>
                <div class="boron-card-body p-6">
                    <div class="grid sm:grid-cols-2 gap-y-4 gap-x-8">
                        <div>
                            <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-1">Perusahaan / Instansi</p>
                            <p class="text-sm font-bold text-[#313a46] dark:text-white">{{ $request->customer->company_name }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-1">ID Pelanggan</p>
                            <p class="text-sm font-bold text-[#313a46] dark:text-white">{{ $request->customer->customer_number }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($request->request_type === 'Terminate')
                {{-- TAMPILAN KHUSUS TERMINATE --}}
                <div class="boron-card rounded-2xl border-2 border-[#ed6060] shadow-sm overflow-hidden">
                    <div class="bg-[#ed6060]/10 p-5 border-b border-[#ed6060]/20">
                        <h5 class="font-bold text-[#ed6060] flex items-center gap-2">
                            <i class="ti ti-power text-xl"></i> Informasi Pemutusan Layanan (Terminate)
                        </h5>
                    </div>
                    <div class="p-6 bg-white dark:bg-[#1e1f27]">
                        <div class="p-4 rounded-xl border border-[#dee2e6] bg-[#f8f9fa] dark:bg-[#15151b] dark:border-[#37394d] text-center mb-5">
                            <p class="text-xs font-bold text-[#8a969c] uppercase mb-3 border-b border-[#e7e9eb] pb-2 dark:border-[#37394d]">Tagihan Yang Dihentikan</p>
                            <p class="text-lg font-bold text-[#ed6060] line-through decoration-[#ed6060]/50 mb-1">Rp {{ number_format($request->customer->monthly_fee ?? 0, 0, ',', '.') }}</p>
                            <p class="text-xs text-[#8a969c]">Kapasitas: <span class="line-through">{{ $request->old_bandwidth }}</span></p>
                        </div>

                        @if($request->status === 'selesai' && $request->bau)
                            <div class="p-4 bg-[#ebb751]/10 border border-[#ebb751]/30 rounded-xl flex items-start gap-3">
                                <i class="ti ti-info-circle text-[#ebb751] text-lg mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-bold text-[#b58c3d] mb-1">Tindakan Penagihan Finance</p>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Pekerjaan pembongkaran/pemutusan telah diselesaikan dan ditandatangani pada tanggal <strong>{{ \Carbon\Carbon::parse($request->bau->upgrade_date)->format('d F Y') }}</strong>. Harap <strong>HENTIKAN PENGIRIMAN INVOICE</strong> pada siklus tagihan bulan berikutnya untuk pelanggan ini.</p>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-[#1e5d87]/10 border border-[#1e5d87]/30 rounded-xl flex items-start gap-3 text-center justify-center">
                                <p class="text-xs font-bold text-[#1e5d87]">Proses Pemutusan Masih Berjalan. Tagihan belum dihentikan secara resmi.</p>
                            </div>
                        @endif
                    </div>
                </div>

            @else
                {{-- TAMPILAN KHUSUS UPGRADE / DOWNGRADE --}}
                <div class="boron-card rounded-2xl border-2 border-[#70bb63] shadow-sm overflow-hidden">
                    <div class="bg-[#70bb63]/10 p-5 border-b border-[#70bb63]/20">
                        <h5 class="font-bold text-[#4a8a3f] flex items-center gap-2">
                            <i class="ti ti-receipt-2 text-xl"></i> Rincian Perubahan Tagihan (Monthly Fee)
                        </h5>
                    </div>
                    <div class="p-6 bg-white dark:bg-[#1e1f27]">
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div class="p-4 rounded-xl border border-[#dee2e6] bg-[#f8f9fa] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-xs font-bold text-[#8a969c] uppercase mb-3 text-center border-b border-[#e7e9eb] pb-2 dark:border-[#37394d]">Tagihan Lama</p>
                                <div class="text-center">
                                    <p class="text-lg font-bold text-[#ed6060] line-through decoration-[#ed6060]/50 mb-1">Rp {{ number_format($request->customer->monthly_fee ?? 0, 0, ',', '.') }}</p>
                                    <p class="text-xs text-[#8a969c]">Kapasitas: <span class="line-through">{{ $request->old_bandwidth }}</span></p>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl border border-[#70bb63]/30 bg-[#70bb63]/5">
                                <p class="text-xs font-bold text-[#70bb63] uppercase mb-3 text-center border-b border-[#70bb63]/20 pb-2">Tagihan Baru</p>
                                <div class="text-center">
                                    <p class="text-xl font-black text-[#70bb63] mb-1">
                                        {{ $request->new_monthly_fee ? 'Rp ' . number_format($request->new_monthly_fee, 0, ',', '.') : 'Menunggu Review' }}
                                    </p>
                                    <p class="text-xs text-[#4a8a3f] font-medium">Kapasitas: {{ $request->new_bandwidth ?? 'Menunggu Review' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($request->status === 'selesai' && $request->bau)
                            <div class="mt-5 p-4 bg-[#ebb751]/10 border border-[#ebb751]/30 rounded-xl flex items-start gap-3">
                                <i class="ti ti-info-circle text-[#ebb751] text-lg mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-bold text-[#b58c3d] mb-1">Informasi Penyesuaian Tagihan</p>
                                    <p class="text-xs text-[#8a969c] leading-relaxed">Pekerjaan {{ strtolower($request->request_type) }} telah diselesaikan pada tanggal <strong>{{ \Carbon\Carbon::parse($request->bau->upgrade_date)->format('d F Y') }}</strong>. Silakan sesuaikan <i>invoice</i> pada siklus penagihan berikutnya sesuai dengan nominal tagihan baru di atas.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="boron-card rounded-2xl border border-[#dee2e6] shadow-sm dark:border-[#37394d]">
                <div class="boron-card-header border-b border-[#e7e9eb] p-5 dark:border-[#37394d]">
                    <h5 class="font-bold text-[#313a46] dark:text-white flex items-center gap-2">
                        <i class="ti ti-files"></i> Arsip Dokumen Pengajuan
                    </h5>
                </div>
                <div class="boron-card-body p-6">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="p-4 border border-[#dee2e6] rounded-xl flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b] dark:border-[#37394d]">
                            <div class="flex items-center gap-3">
                                <i class="ti ti-file-text text-2xl text-[#1e5d87]"></i>
                                <div>
                                    <p class="text-sm font-bold text-[#313a46] dark:text-white">Form Pengajuan</p>
                                    <p class="text-[10px] text-[#8a969c]">Ditandatangani Pelanggan</p>
                                </div>
                            </div>
                            @if($request->signed_pdf_path)
                                <a href="{{ Storage::url($request->signed_pdf_path) }}" target="_blank" class="size-8 rounded-full bg-white border border-[#dee2e6] flex items-center justify-center text-[#1e5d87] hover:bg-[#1e5d87] hover:text-white transition-all shadow-sm">
                                    <i class="ti ti-download"></i>
                                </a>
                            @else
                                <span class="text-[10px] bg-gray-200 text-gray-500 px-2 py-1 rounded">Belum Ada</span>
                            @endif
                        </div>

                        <div class="p-4 border border-[#dee2e6] rounded-xl flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b] dark:border-[#37394d]">
                            <div class="flex items-center gap-3">
                                <i class="ti ti-file-certificate text-2xl text-[#70bb63]"></i>
                                <div>
                                    <p class="text-sm font-bold text-[#313a46] dark:text-white">Berita Acara</p>
                                    <p class="text-[10px] text-[#8a969c]">Dokumen Final Selesai</p>
                                </div>
                            </div>
                            @if($request->bau && $request->bau->signed_bau_path)
                                <a href="{{ Storage::url($request->bau->signed_bau_path) }}" target="_blank" class="size-8 rounded-full bg-white border border-[#dee2e6] flex items-center justify-center text-[#70bb63] hover:bg-[#70bb63] hover:text-white transition-all shadow-sm">
                                    <i class="ti ti-download"></i>
                                </a>
                            @else
                                <span class="text-[10px] bg-gray-200 text-gray-500 px-2 py-1 rounded">Belum Selesai</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="space-y-6">
            <div class="boron-card rounded-2xl shadow-sm">
                <div class="boron-card-header p-5 border-b border-[#e7e9eb] dark:border-[#37394d]">
                    <h5 class="font-bold text-sm text-[#313a46] dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="ti ti-map-2 text-[#8a969c]"></i> Status Saat Ini
                    </h5>
                </div>
                <div class="boron-card-body p-6">
                    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-[15px] before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-[#e7e9eb] before:to-transparent dark:before:via-[#37394d]">
                        @php
                            $steps = [
                                'menunggu_pelanggan' => ['title' => 'Pengiriman Form', 'icon' => 'ti-send'],
                                'menunggu_approval' => ['title' => 'Review Marketing', 'icon' => 'ti-search'],
                                'form_disetujui' => ['title' => 'Form Disetujui', 'icon' => 'ti-check'],
                                'menunggu_ttd_pelanggan' => ['title' => 'TTD Form Pelanggan', 'icon' => 'ti-signature'],
                                'verifikasi_ttd_pelanggan' => ['title' => 'Verifikasi TTD Form', 'icon' => 'ti-file-search'],
                                'proses_upgrade' => ['title' => 'Proses Jaringan (NOC)', 'icon' => 'ti-router'],
                                'pembuatan_bau' => ['title' => 'Pembuatan Berita Acara', 'icon' => 'ti-file-description'],
                                'menunggu_ttd_bau' => ['title' => 'TTD Berita Acara', 'icon' => 'ti-certificate'],
                                'verifikasi_ttd_bau' => ['title' => 'Review Akhir Marketing', 'icon' => 'ti-file-search'],
                                'selesai' => ['title' => 'Selesai / Aktif', 'icon' => 'ti-circle-check'],
                            ];
                            
                            $allStatuses = array_keys($steps);
                            $currentIndex = array_search($request->status, $allStatuses);
                        @endphp

                        @foreach($steps as $key => $step)
                            @php
                                $stepIndex = array_search($key, $allStatuses);
                                $isCompleted = $currentIndex > $stepIndex;
                                $isActive = $currentIndex === $stepIndex;
                                
                                $iconBg = $isCompleted ? 'bg-[#70bb63] text-white' : ($isActive ? 'bg-[#1e5d87] text-white ring-4 ring-[#1e5d87]/20 animate-pulse' : 'bg-white border-2 border-[#dee2e6] text-[#8a969c] dark:bg-[#1e1f27] dark:border-[#37394d]');
                                $textColor = $isCompleted || $isActive ? 'text-[#313a46] dark:text-white' : 'text-[#8a969c]';
                            @endphp
                            
                            <div class="relative flex items-center gap-4 group">
                                <div class="size-8 rounded-full flex items-center justify-center text-sm z-10 shrink-0 transition-all {{ $iconBg }}">
                                    @if($isCompleted)
                                        <i class="ti ti-check"></i>
                                    @else
                                        <i class="ti {{ $step['icon'] }}"></i>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-sm font-bold block {{ $textColor }}">{{ $step['title'] }}</span>
                                    @if($isActive)
                                        <span class="text-[10px] font-bold text-[#1e5d87] uppercase tracking-wider mt-0.5 block">Tahap Saat Ini</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>