<div class="py-6">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('marketing.request.index') }}" wire:navigate class="size-10 flex items-center justify-center rounded-full bg-white border border-[#dee2e6] text-[#8a969c] hover:text-[#1e5d87] transition-all">
            <i class="ti ti-arrow-left text-xl"></i>
        </a>
        <div>
            <h4 class="text-xl font-bold text-[#313a46] dark:text-white">Review Pengajuan: {{ $request->request_number }}</h4>
            <p class="text-sm text-[#8a969c]">Kelola detail kapasitas, harga, dan alur dokumen pelanggan.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            
            @if($request->status === 'menunggu_approval')
                <div class="boron-card rounded-2xl border-2 border-[#1e5d87] bg-white shadow-sm dark:bg-[#1e1f27] dark:border-[#60addf]">
                    <div class="boron-card-header bg-[#1e5d87]/10 p-5 border-b border-[#1e5d87]/20 dark:bg-[#60addf]/10 dark:border-[#60addf]/20">
                        <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf] flex items-center gap-2">
                            <i class="ti ti-edit-circle text-xl"></i> Review & Tetapkan Data
                        </h5>
                    </div>
                    <div class="p-6">
                        @if($request->request_type === 'Terminate')
                            <div class="mb-5 p-4 rounded-xl border border-[#ed6060]/30 bg-[#ed6060]/5">
                                <p class="text-sm font-bold text-[#ed6060] mb-2"><i class="ti ti-power"></i> Pengajuan Berhenti Berlangganan</p>
                                <p class="text-xs text-[#8a969c]">Tentukan tanggal efektif penghentian layanan. Sistem akan men-generate form pemutusan setelah Anda menyetujui tanggal ini.</p>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-5 mb-5">
                                <div class="flex items-center justify-between bg-[#f8f9fa] dark:bg-[#15151b] p-3.5 rounded-xl border border-[#dee2e6] dark:border-[#37394d]">
                                    <span class="text-[11px] font-bold text-[#8a969c] uppercase">Kapasitas Berjalan</span>
                                    <span class="text-sm font-bold text-[#ed6060]">{{ $request->old_bandwidth }}</span>
                                </div>
                                <div class="flex items-center justify-between bg-[#f8f9fa] dark:bg-[#15151b] p-3.5 rounded-xl border border-[#dee2e6] dark:border-[#37394d]">
                                    <span class="text-[11px] font-bold text-[#8a969c] uppercase">Tagihan Berjalan</span>
                                    <span class="text-sm font-bold text-[#ed6060]">Rp {{ number_format($request->customer->monthly_fee ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#8a969c] uppercase mb-2">Tanggal Terminate / Pemutusan <span class="text-[#ed6060]">*</span></label>
                                <input type="date" wire:model="terminate_date" class="w-full rounded-lg border border-[#dee2e6] bg-[#f8f9fa] px-4 py-2.5 text-sm focus:border-[#1e5d87] focus:ring-1 focus:ring-[#1e5d87] dark:bg-[#15151b] dark:border-[#37394d] dark:text-white">
                                @error('terminate_date') <span class="text-xs text-[#ed6060] mt-1">{{ $message }}</span> @enderror
                            </div>

                        @else
                            
                            {{-- FORM KHUSUS UPGRADE / DOWNGRADE --}}
                            <div class="grid sm:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between bg-[#f8f9fa] dark:bg-[#15151b] p-3.5 rounded-xl border border-[#dee2e6] dark:border-[#37394d]">
                                        <span class="text-[11px] font-bold text-[#8a969c] uppercase">Kapasitas Saat Ini</span>
                                        <span class="text-sm font-bold text-[#ed6060] line-through decoration-[#ed6060]/50">{{ $request->old_bandwidth }}</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#1e5d87] dark:text-[#60addf] uppercase mb-2">Pilih Kapasitas Baru <span class="text-[#ed6060]">*</span></label>
                                        <select wire:model="edit_bandwidth" class="w-full rounded-lg border-[#dee2e6] bg-white py-3 text-sm font-bold text-[#313a46] focus:border-[#ebb751] focus:ring-[#ebb751]/20 dark:bg-[#1e1f27] dark:border-[#37394d] dark:text-white transition-all shadow-sm">
                                            <option value="100 Mbps">100 Mbps</option>
                                            <option value="200 Mbps">200 Mbps</option>
                                            <option value="300 Mbps">300 Mbps</option>
                                            <option value="400 Mbps">400 Mbps</option>
                                            <option value="500 Mbps">500 Mbps</option>
                                            <option value="600 Mbps">600 Mbps</option>
                                            <option value="700 Mbps">700 Mbps</option>
                                            <option value="800 Mbps">800 Mbps</option>
                                            <option value="900 Mbps">900 Mbps</option>
                                            <option value="1000 Mbps">1000 Mbps</option>
                                            <option value="1500 Mbps">1500 Mbps</option>
                                            <option value="2000 Mbps">2000 Mbps</option>
                                        </select>
                                        @error('edit_bandwidth') <span class="text-xs text-[#ed6060] mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between bg-[#f8f9fa] dark:bg-[#15151b] p-3.5 rounded-xl border border-[#dee2e6] dark:border-[#37394d]">
                                        <span class="text-[11px] font-bold text-[#8a969c] uppercase">Biaya Saat Ini</span>
                                        <span class="text-sm font-bold text-[#ed6060] line-through decoration-[#ed6060]/50">Rp {{ number_format($request->customer->monthly_fee ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#1e5d87] dark:text-[#60addf] uppercase mb-2">Input Biaya Baru (Rp) <span class="text-[#ed6060]">*</span></label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold text-[#8a969c]">Rp</span>
                                            <input type="number" wire:model="edit_monthly_fee" class="w-full rounded-lg border-[#dee2e6] bg-white pl-11 pr-4 py-3 text-sm font-bold text-[#313a46] focus:border-[#ebb751] focus:ring-[#ebb751]/20 dark:bg-[#1e1f27] dark:border-[#37394d] dark:text-white transition-all shadow-sm">
                                        </div>
                                        @error('edit_monthly_fee') <span class="text-xs text-[#ed6060] mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                        @endif

                        <div class="mt-8 flex justify-end pt-5 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                            <button wire:click="approve" wire:loading.attr="disabled" class="btn-boron bg-[#1e5d87] text-white font-bold py-2.5 px-6 rounded-lg shadow-md hover:bg-[#164a6d] transition-colors flex items-center gap-2 w-full sm:w-auto justify-center">
                                <span wire:loading.remove wire:target="approve"><i class="ti ti-check text-xl"></i> Setujui & Generate Form</span>
                                <span wire:loading wire:target="approve"><i class="ti ti-loader animate-spin"></i> Memproses...</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- KARTU VIEW KONFIGURASI LAYANAN TERBARU (READ-ONLY) --}}
            @if($request->status !== 'menunggu_approval')
                <div class="boron-card rounded-2xl">
                    <div class="boron-card-header border-b border-[#e7e9eb] p-5 dark:border-[#37394d]">
                        <h5 class="font-bold text-[#313a46] dark:text-white flex items-center gap-2">
                            <i class="ti ti-list-details text-[#ebb751]"></i> Detail Pengajuan Layanan
                        </h5>
                    </div>
                    <div class="boron-card-body p-6 space-y-6">
                        @if($request->request_type === 'Terminate')
                            <div class="p-4 rounded-xl border border-[#ed6060]/30 bg-[#ed6060]/5 text-center">
                                <p class="text-xs font-bold text-[#8a969c] uppercase mb-1">Tanggal Terminate (Pemutusan)</p>
                                <p class="text-xl font-black text-[#ed6060]">{{ \Carbon\Carbon::parse($request->deadline_date)->format('d F Y') }}</p>
                            </div>
                        @else
                            <div class="grid sm:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <label class="block text-xs font-bold text-[#8a969c] uppercase border-b border-[#e7e9eb] pb-2 dark:border-[#37394d]">Kapasitas (Bandwidth)</label>
                                    <div class="flex items-center justify-between bg-[#f8f9fa] dark:bg-[#15151b] p-3.5 rounded-xl border border-[#dee2e6] dark:border-[#37394d]">
                                        <span class="text-[11px] font-bold text-[#8a969c] uppercase">Saat Ini</span>
                                        <span class="text-sm font-bold text-[#ed6060] line-through decoration-[#ed6060]/50">{{ $request->old_bandwidth }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[11px] font-bold text-[#1e5d87] dark:text-[#60addf] uppercase mb-1.5 block">Kapasitas Baru (Disetujui)</span>
                                        <div class="p-3.5 bg-white rounded-xl border border-[#70bb63]/30 dark:bg-[#1e1f27] font-black text-[#70bb63] shadow-sm">
                                            {{ $request->new_bandwidth }}
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <label class="block text-xs font-bold text-[#8a969c] uppercase border-b border-[#e7e9eb] pb-2 dark:border-[#37394d]">Harga Bulanan (Monthly Fee)</label>
                                    <div class="flex items-center justify-between bg-[#f8f9fa] dark:bg-[#15151b] p-3.5 rounded-xl border border-[#dee2e6] dark:border-[#37394d]">
                                        <span class="text-[11px] font-bold text-[#8a969c] uppercase">Saat Ini</span>
                                        <span class="text-sm font-bold text-[#ed6060] line-through decoration-[#ed6060]/50">Rp {{ number_format($request->customer->monthly_fee ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[11px] font-bold text-[#1e5d87] dark:text-[#60addf] uppercase mb-1.5 block">Harga Baru (Disetujui)</span>
                                        <div class="p-3.5 bg-white rounded-xl border border-[#70bb63]/30 dark:bg-[#1e1f27] font-black text-[#70bb63] shadow-sm">
                                            Rp {{ number_format($request->new_monthly_fee, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($request->status === 'form_disetujui')
                <div class="boron-card border-2 border-dashed border-[#60addf] bg-[#60addf]/5 rounded-2xl p-8 text-center">
                    <i class="ti ti-file-text text-5xl text-[#60addf] mb-4"></i>
                    <h5 class="text-lg font-bold text-[#1e5d87]">Form Siap Dikirim</h5>
                    <p class="text-sm text-[#8a969c] max-w-md mx-auto mt-2">Data pengajuan sudah valid. Silakan review file PDF (opsional) atau langsung kirim ke pelanggan untuk proses tanda tangan.</p>
                    <div class="mt-6 flex flex-col sm:flex-row justify-center gap-3 flex-wrap">
                        <a href="{{ route('marketing.request.pdf', $request->id) }}" target="_blank" class="btn-boron border border-[#60addf] text-[#60addf] px-6 py-2.5 rounded-xl font-bold hover:bg-[#60addf] hover:text-white transition-all flex items-center justify-center gap-2">
                            <i class="ti ti-eye"></i> Review PDF
                        </a>
                        <button wire:click="sendToCustomer" class="btn-boron bg-[#60addf] text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-[#60addf]/30 hover:bg-[#1e5d87] transition-all flex items-center justify-center gap-2">
                            <i class="ti ti-send"></i> Kirim ke Pelanggan
                        </button>

                        {{-- TOMBOL BYPASS UNTUK TERMINATE --}}
                        @if($request->request_type === 'Terminate')
                            <button wire:click="forceTerminate" wire:confirm="Anda yakin ingin langsung memutus layanan ini tanpa menunggu TTD pelanggan?" class="btn-boron bg-[#ed6060] text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-[#ed6060]/30 hover:bg-[#c84d4d] transition-all flex items-center justify-center gap-2">
                                <i class="ti ti-power"></i> Putus Langsung (Bypass TTD)
                            </button>
                        @endif
                    </div>
                </div>
            @endif

            @if($request->status === 'verifikasi_ttd_pelanggan')
                <div class="boron-card rounded-2xl border-2 border-[#ebb751] overflow-hidden shadow-sm">
                    <div class="bg-[#ebb751]/10 p-5 border-b border-[#ebb751]/20">
                        <h5 class="font-bold text-[#b58c3d] flex items-center gap-2"><i class="ti ti-signature"></i> Verifikasi TTD & Terbitkan SPK NOC</h5>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 border-b border-dashed border-[#dee2e6] pb-6 dark:border-[#37394d]">
                            <div>
                                <p class="text-sm font-bold text-[#313a46] dark:text-white">1. Cek Keabsahan Dokumen</p>
                                <p class="text-xs text-[#8a969c] mt-1">Pastikan form sudah ditandatangani dan distempel oleh pelanggan.</p>
                            </div>
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <a href="{{ Storage::url($request->signed_pdf_path) }}" target="_blank" class="w-full sm:w-auto justify-center btn-boron bg-white border border-[#ebb751] text-[#ebb751] px-5 py-2 rounded-xl font-bold hover:bg-[#ebb751] hover:text-white transition-all flex items-center gap-2 shadow-sm">
                                    <i class="ti ti-eye"></i> Lihat TTD
                                </a>
                                <button wire:click="rejectSignature" class="w-full sm:w-auto justify-center btn-boron bg-[#ed6060]/10 text-[#ed6060] px-4 py-2 rounded-xl font-bold hover:bg-[#ed6060] hover:text-white transition-all">
                                    Tolak TTD
                                </button>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <p class="text-sm font-bold text-[#313a46] dark:text-white mb-4">2. Lengkapi Data SPK</p>
                                <div class="grid sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-[#8a969c] uppercase mb-2">Metro / Vendor</label>
                                        <input type="text" wire:model="metro_vendor" readonly class="w-full rounded-xl border-[#dee2e6] bg-[#eef2f6] py-2.5 text-sm cursor-not-allowed text-[#8a969c] dark:bg-[#15151b] dark:border-[#37394d]">
                                        <p class="text-[10px] text-[#8a969c] mt-1.5"><i class="ti ti-info-circle"></i> Diambil otomatis dari kolom <i>jalur_metro</i></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#8a969c] uppercase mb-2">Deadline Pengerjaan <span class="text-[#ed6060]">*</span></label>
                                        <input type="date" wire:model="deadline_date" wire:change="saveSpkDraft" class="w-full rounded-xl border-[#dee2e6] py-2.5 text-sm focus:ring-[#1e5d87] dark:bg-[#15151b] dark:border-[#37394d] dark:text-white">
                                        @error('deadline_date') <span class="text-[10px] text-[#ed6060] mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-between items-center pt-5 border-t border-dashed border-[#dee2e6] dark:border-[#37394d] gap-3">
                                <a href="{{ route('marketing.request.spk.pdf', $request->id) }}" target="_blank" class="btn-boron border border-[#1e5d87] text-[#1e5d87] px-6 py-2.5 rounded-xl font-bold hover:bg-[#1e5d87] hover:text-white transition-all flex items-center gap-2 w-full sm:w-auto justify-center">
                                    <i class="ti ti-file-text"></i> Review PDF SPK
                                </a>
                                
                                <button wire:click="sendToNoc" class="btn-boron bg-[#70bb63] text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-[#70bb63]/30 hover:bg-[#5da352] transition-all flex items-center gap-2 w-full sm:w-auto justify-center">
                                    <i class="ti ti-send"></i> Setujui TTD & Kirim ke NOC
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($request->status === 'verifikasi_ttd_bau')
                <div class="boron-card border-2 border-[#70bb63] rounded-2xl overflow-hidden shadow-lg">
                    <div class="bg-[#70bb63] p-5 border-b border-[#70bb63]/20">
                        <h5 class="font-bold text-white flex items-center gap-2"><i class="ti ti-file-certificate text-xl"></i> Verifikasi Akhir Berita Acara</h5>
                    </div>
                    <div class="p-8 text-center bg-white dark:bg-[#1e1f27]">
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] max-w-md mx-auto mb-6">Pelanggan telah mengunggah Dokumen Berita Acara yang ditandatangani. Silakan cek keabsahan tanda tangan tersebut untuk menutup proses ini.</p>
                        
                        <div class="flex flex-col sm:flex-row justify-center gap-3">
                            <a href="{{ Storage::url($request->bau?->signed_bau_path) }}" target="_blank" class="btn-boron border border-[#1e5d87] text-[#1e5d87] px-6 py-2.5 rounded-xl font-bold hover:bg-[#1e5d87] hover:text-white transition-all flex justify-center items-center gap-2 shadow-sm">
                                <i class="ti ti-eye"></i> Lihat Dokumen
                            </a>
                            <button wire:click="rejectBauSignature" class="btn-boron bg-[#ed6060]/10 text-[#ed6060] px-6 py-2.5 rounded-xl font-bold hover:bg-[#ed6060] hover:text-white transition-all">
                                Tolak TTD
                            </button>
                            <button wire:click="approveBauSignature" class="btn-boron bg-[#70bb63] text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-[#70bb63]/30 hover:bg-[#5da352] transition-all flex justify-center items-center gap-2">
                                <i class="ti ti-check"></i> Setujui & Selesaikan
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if(in_array($request->status, ['menunggu_ttd_pelanggan', 'menunggu_ttd_bau']))
                <div class="boron-card border-2 border-dashed border-[#ebb751] bg-[#ebb751]/5 rounded-2xl p-8 text-center">
                    <i class="ti ti-clock-hour-4 text-5xl text-[#ebb751] mb-4"></i>
                    <h5 class="text-lg font-bold text-[#b58c3d]">Menunggu Pelanggan</h5>
                    <p class="text-sm text-[#8a969c] max-w-md mx-auto mt-2">Menunggu pelanggan untuk mengunduh, menandatangani, dan mengunggah kembali dokumen.</p>

                    {{-- TOMBOL BYPASS UNTUK TERMINATE --}}
                    @if($request->request_type === 'Terminate')
                        <div class="mt-6 border-t border-dashed border-[#ebb751]/30 pt-6">
                            <p class="text-xs text-[#b58c3d] mb-3">Pelanggan tidak merespon? Anda dapat memutus layanan secara paksa.</p>
                            <button wire:click="forceTerminate" wire:confirm="Anda yakin ingin menyelesaikan pemutusan tanpa menunggu TTD pelanggan?" class="btn-boron bg-[#ed6060] text-white px-6 py-2.5 rounded-xl font-bold shadow-md shadow-[#ed6060]/30 hover:bg-[#c84d4d] transition-all inline-flex items-center justify-center gap-2">
                                <i class="ti ti-power"></i> Putus Langsung (Bypass TTD)
                            </button>
                        </div>
                    @endif
                </div>
            @endif

            @if($request->status === 'proses_upgrade')
                <div class="boron-card border-2 border-dashed border-[#70bb63] bg-[#70bb63]/5 rounded-2xl p-8 text-center">
                    <i class="ti ti-router text-5xl text-[#70bb63] mb-4"></i>
                    <h5 class="text-lg font-bold text-[#4a8a3f]">Proses Eksekusi (NOC)</h5>
                    <p class="text-sm text-[#8a969c] max-w-md mx-auto mt-2">Tanda tangan telah diverifikasi. Tim NOC saat ini sedang melakukan proses eksekusi/pembongkaran jaringan.</p>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="boron-card rounded-2xl">
                <div class="boron-card-header p-5 border-b border-[#e7e9eb] dark:border-[#37394d]">
                    <h5 class="font-bold text-sm text-[#313a46] dark:text-white uppercase tracking-wider">Status Tracking</h5>
                </div>
                <div class="boron-card-body p-5">
                    <div class="space-y-6">
                        @php
                            $steps = [
                                'menunggu_pelanggan' => ['title' => 'Pengiriman Form', 'icon' => 'ti-send'],
                                'menunggu_approval' => ['title' => 'Menunggu Review Marketing', 'icon' => 'ti-search'],
                                'form_disetujui' => ['title' => 'Form Disetujui', 'icon' => 'ti-check'],
                                'menunggu_ttd_pelanggan' => ['title' => 'Menunggu TTD Pelanggan', 'icon' => 'ti-signature'],
                                'verifikasi_ttd_pelanggan' => ['title' => 'Verifikasi TTD Form', 'icon' => 'ti-file-search'],
                                'proses_upgrade' => ['title' => 'Proses Eksekusi (NOC)', 'icon' => 'ti-router'],
                                'pembuatan_bau' => ['title' => 'Pembuatan Berita Acara', 'icon' => 'ti-file-description'],
                                'menunggu_ttd_bau' => ['title' => 'Menunggu TTD Pelanggan', 'icon' => 'ti-certificate'],
                                'verifikasi_ttd_bau' => ['title' => 'Verifikasi Berita Acara', 'icon' => 'ti-file-search'],
                                'selesai' => ['title' => 'Selesai', 'icon' => 'ti-circle-check'],
                            ];
                            $allStatuses = array_keys($steps);
                            $currentIndex = array_search($request->status, $allStatuses);
                        @endphp

                        @foreach($steps as $key => $step)
                            @php
                                $stepIndex = array_search($key, $allStatuses);
                                $isCompleted = $currentIndex > $stepIndex;
                                $isActive = $currentIndex === $stepIndex;
                            @endphp
                            <div class="flex items-center gap-4">
                                <div class="size-8 rounded-full flex items-center justify-center text-xs {{ $isCompleted ? 'bg-[#70bb63] text-white' : ($isActive ? 'bg-[#1e5d87] text-white animate-pulse' : 'bg-gray-100 text-gray-400 dark:bg-white/5') }}">
                                    <i class="ti {{ $step['icon'] }}"></i>
                                </div>
                                <span class="text-sm font-bold {{ $isActive ? 'text-[#313a46] dark:text-white' : ($isCompleted ? 'text-[#8a969c]' : 'text-gray-400') }}">{{ $step['title'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>