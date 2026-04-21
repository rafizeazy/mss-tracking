<div class="py-6">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('noc.request.index') }}" wire:navigate class="size-10 flex items-center justify-center rounded-full bg-white border border-[#dee2e6] text-[#8a969c] hover:text-[#1e5d87] transition-all shadow-sm">
            <i class="ti ti-arrow-left text-xl"></i>
        </a>
        <div>
            <h4 class="text-xl font-bold text-[#313a46] dark:text-white">
                Eksekusi SPK: {{ \App\Services\PerubahanLayananNumberService::generateSpk($request) }}
            </h4>
            <p class="text-sm text-[#8a969c]">Detail instruksi teknis jaringan dan penerbitan Berita Acara.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">

            <div class="boron-card rounded-2xl border border-[#dee2e6] shadow-sm dark:border-[#37394d]">
                <div class="boron-card-header border-b border-[#e7e9eb] p-5 dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                    <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf] flex items-center gap-2">
                        <i class="ti ti-file-info text-lg"></i> Detail Instruksi Kerja (SPK)
                    </h5>
                    <span class="px-3 py-1 bg-[#1e5d87]/10 text-[#1e5d87] font-bold text-xs rounded-lg border border-[#1e5d87]/20">
                        {{ strtoupper($request->request_type) }} LAYANAN
                    </span>
                </div>
                <div class="boron-card-body p-6">
                    <div class="grid sm:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-1">Perusahaan & PIC</p>
                            <p class="text-sm font-bold text-[#313a46] dark:text-white">{{ $request->customer->company_name }}</p>
                            <p class="text-xs text-[#8a969c] mt-0.5">{{ $request->customer->technical_name ?? $request->customer->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-1">Alamat Instalasi</p>
                            <p class="text-sm font-medium text-[#313a46] dark:text-[#aab8c5] leading-relaxed">
                                {{ $request->customer->installation_address ?? $request->customer->company_address }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                            <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-1">Metro / Vendor</p>
                            <p class="text-sm font-bold text-[#ebb751] bg-[#ebb751]/10 inline-block px-2.5 py-1 rounded-md border border-[#ebb751]/20">
                                {{ $request->metro_vendor ?? 'Tidak Ada Data' }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                            <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-1">
                                {{ $request->request_type === 'Terminate' ? 'Tanggal Pemutusan' : 'Deadline Pengerjaan' }}
                            </p>
                            <p class="text-sm font-bold {{ $request->deadline_date && \Carbon\Carbon::parse($request->deadline_date)->isPast() && $request->status == 'proses_upgrade' ? 'text-[#ed6060] animate-pulse' : 'text-[#313a46] dark:text-white' }}">
                                <i class="ti ti-calendar-due"></i> {{ $request->deadline_date ? \Carbon\Carbon::parse($request->deadline_date)->format('d F Y') : '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-[#f8f9fa] dark:bg-[#15151b] rounded-xl border border-[#dee2e6] dark:border-[#37394d] flex items-center justify-between">
                        @if($request->request_type === 'Terminate')
                            <div>
                                <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-1">Kapasitas Yang Diputus</p>
                                <span class="text-sm font-bold text-[#ed6060]">{{ $request->old_bandwidth }}</span>
                            </div>
                        @else
                            <div>
                                <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-1">Perubahan Kapasitas Bandwidth</p>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-bold text-[#ed6060] line-through decoration-[#ed6060]/50">{{ $request->old_bandwidth }}</span>
                                    <i class="ti ti-arrow-right text-[#8a969c]"></i>
                                    <span class="text-base font-black text-[#70bb63]">{{ $request->new_bandwidth }}</span>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('marketing.request.spk.pdf', $request->id) }}" target="_blank" class="btn-boron bg-white border border-[#1e5d87] text-[#1e5d87] px-4 py-2 rounded-lg text-xs font-bold hover:bg-[#1e5d87] hover:text-white transition-all flex items-center gap-1.5 shadow-sm">
                            <i class="ti ti-file-download text-base"></i> Buka PDF SPK
                        </a>
                    </div>
                </div>
            </div>

            {{-- PANEL AKSI NOC --}}
            @if($request->status === 'proses_upgrade')
                <div class="boron-card border-2 border-dashed {{ $request->request_type === 'Terminate' ? 'border-[#ed6060] bg-[#ed6060]/5' : 'border-[#1e5d87] bg-[#1e5d87]/5' }} rounded-2xl p-8 text-center shadow-sm">
                    <div class="size-16 {{ $request->request_type === 'Terminate' ? 'bg-[#ed6060] shadow-[#ed6060]/30' : 'bg-[#1e5d87] shadow-[#1e5d87]/30' }} text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="ti {{ $request->request_type === 'Terminate' ? 'ti-power' : 'ti-router' }} text-3xl"></i>
                    </div>
                    <h5 class="text-lg font-bold {{ $request->request_type === 'Terminate' ? 'text-[#ed6060]' : 'text-[#1e5d87]' }}">
                        {{ $request->request_type === 'Terminate' ? 'Eksekusi Pembongkaran / Pemutusan' : 'Eksekusi Jaringan' }}
                    </h5>
                    <p class="text-sm text-[#8a969c] max-w-md mx-auto mt-2">
                        {{ $request->request_type === 'Terminate' ? 'Silakan lakukan pembongkaran perangkat fisik dan pemutusan layanan di sistem. Klik tombol di bawah jika telah selesai.' : 'Silakan lakukan konfigurasi pada perangkat jaringan fisik maupun di sistem. Klik tombol di bawah jika seluruh konfigurasi telah selesai dan stabil.' }}
                    </p>
                    <div class="mt-6 flex justify-center">
                        <button wire:click="markAsDone" class="btn-boron {{ $request->request_type === 'Terminate' ? 'bg-[#ed6060] hover:bg-[#d95454] shadow-[#ed6060]/30' : 'bg-[#1e5d87] hover:bg-[#154666] shadow-[#1e5d87]/30' }} text-white px-8 py-3 rounded-xl font-bold shadow-lg transition-all flex items-center gap-2">
                            <i class="ti ti-check"></i> Pekerjaan Selesai (Lanjut Buat Berita Acara)
                        </button>
                    </div>
                </div>
            @endif

            @if($request->status === 'pembuatan_bau')
                <div class="boron-card rounded-2xl border-2 border-[#70bb63] shadow-lg overflow-hidden">
                    <div class="bg-[#70bb63] p-4 text-white">
                        <h5 class="font-bold flex items-center gap-2 text-lg"><i class="ti ti-file-description text-xl"></i> Form Pembuatan Berita Acara</h5>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid sm:grid-cols-2 gap-5 p-4 bg-[#f8f9fa] dark:bg-[#15151b] rounded-xl border border-[#dee2e6] dark:border-[#37394d]">
                            <div>
                                <label class="block text-[11px] font-bold text-[#8a969c] uppercase mb-1">Nama Perusahaan / Instansi</label>
                                <p class="text-sm font-bold text-[#313a46] dark:text-white">{{ $request->customer->company_name }}</p>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-[#8a969c] uppercase mb-1">ID Pelanggan</label>
                                <p class="text-sm font-bold text-[#1e5d87]">{{ $request->customer->customer_number }}</p>
                            </div>
                            <div class="sm:col-span-2 pt-2 border-t border-dashed border-[#dee2e6] dark:border-[#37394d]">
                                <label class="block text-[11px] font-bold text-[#8a969c] uppercase mb-1">Alamat Instalasi</label>
                                <p class="text-sm font-medium text-[#313a46] dark:text-[#aab8c5]">{{ $request->customer->installation_address ?? $request->customer->company_address }}</p>
                            </div>
                        </div>

                        <form wire:submit.prevent="submitBauForm" class="space-y-5">
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold text-[#8a969c] uppercase mb-2">Tanggal Eksekusi Selesai <span class="text-[#ed6060]">*</span></label>
                                    <input type="date" wire:model="upgrade_date" class="w-full rounded-xl border-[#dee2e6] py-2.5 text-sm focus:ring-[#70bb63] dark:bg-[#1e1f27] dark:border-[#37394d] dark:text-white">
                                    @error('upgrade_date') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#8a969c] uppercase mb-2">Nama Teknisi NOC <span class="text-[#ed6060]">*</span></label>
                                    <input type="text" wire:model="noc_pic_name" class="w-full rounded-xl border-[#dee2e6] py-2.5 text-sm focus:ring-[#70bb63] dark:bg-[#1e1f27] dark:border-[#37394d] dark:text-white">
                                    @error('noc_pic_name') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-5">
                                <div class="border border-[#dee2e6] rounded-xl p-4 dark:border-[#37394d]">
                                    <label class="block text-xs font-bold text-[#8a969c] uppercase mb-2">Upload TTD NOC <span class="text-[#ed6060]">*</span></label>
                                    <input type="file" wire:model="noc_signature" accept="image/*" class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#70bb63]/10 file:text-[#70bb63] hover:file:bg-[#70bb63]/20">
                                    <div wire:loading wire:target="noc_signature" class="text-xs text-[#ebb751] mt-2">Mengunggah...</div>
                                    @error('noc_signature') <span class="block text-[10px] text-[#ed6060] mt-1">{{ $message }}</span> @enderror
                                    
                                    @if ($noc_signature)
                                        <img src="{{ $noc_signature->temporaryUrl() }}" class="mt-3 max-h-16 rounded border">
                                    @elseif($request->bau?->noc_signature_path)
                                        <img src="{{ Storage::url($request->bau->noc_signature_path) }}" class="mt-3 max-h-16 rounded border">
                                    @endif
                                </div>
                                
                                <div class="border border-[#dee2e6] rounded-xl p-4 dark:border-[#37394d]">
                                    <label class="block text-xs font-bold text-[#8a969c] uppercase mb-2">Upload Foto Speedtest / Dokumentasi <span class="text-[#ed6060]">*</span></label>
                                    <input type="file" wire:model="speedtest_image" accept="image/*" class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#70bb63]/10 file:text-[#70bb63] hover:file:bg-[#70bb63]/20">
                                    <div wire:loading wire:target="speedtest_image" class="text-xs text-[#ebb751] mt-2">Mengunggah...</div>
                                    @error('speedtest_image') <span class="block text-[10px] text-[#ed6060] mt-1">{{ $message }}</span> @enderror

                                    @if ($speedtest_image)
                                        <img src="{{ $speedtest_image->temporaryUrl() }}" class="mt-3 max-h-20 rounded border">
                                    @elseif($request->bau?->speedtest_image_path)
                                        <img src="{{ Storage::url($request->bau->speedtest_image_path) }}" class="mt-3 max-h-20 rounded border">
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-dashed border-[#dee2e6] dark:border-[#37394d]">
                                <button type="submit" class="btn-boron bg-[#f8f9fa] border border-[#dee2e6] text-[#313a46] px-6 py-2.5 rounded-xl font-bold hover:bg-[#e7e9eb] transition-all flex items-center justify-center gap-2 dark:bg-[#1e1f27] dark:border-[#37394d] dark:text-white">
                                    <i class="ti ti-device-floppy"></i> Simpan Draft
                                </button>
                                
                                @if($request->bau?->noc_signature_path && $request->bau?->speedtest_image_path)
                                    <a href="{{ route('noc.request.bau.pdf', $request->id) }}" target="_blank" class="btn-boron border border-[#70bb63] text-[#70bb63] px-6 py-2.5 rounded-xl font-bold hover:bg-[#70bb63] hover:text-white transition-all flex items-center justify-center gap-2">
                                        <i class="ti ti-eye"></i> Review PDF Berita Acara
                                    </a>
                                    <button type="button" wire:click="sendBauToCustomer" class="btn-boron bg-[#70bb63] text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-[#70bb63]/30 hover:bg-[#5da352] transition-all flex items-center justify-center gap-2">
                                        <i class="ti ti-send"></i> Kirim ke Pelanggan
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if($request->status === 'menunggu_ttd_bau')
                <div class="boron-card border-2 border-dashed border-[#ebb751] bg-[#ebb751]/5 rounded-2xl p-8 text-center shadow-sm">
                    <i class="ti ti-clock-hour-4 text-5xl text-[#ebb751] mb-4"></i>
                    <h5 class="text-lg font-bold text-[#b58c3d]">Menunggu Tanda Tangan Pelanggan</h5>
                    <p class="text-sm text-[#8a969c] max-w-md mx-auto mt-2">Draf Berita Acara telah dikirim. Menunggu pelanggan untuk mengunduh, menandatangani, dan mengunggah kembali dokumen tersebut.</p>
                </div>
            @endif

            @if($request->status === 'verifikasi_ttd_bau')
                <div class="boron-card border-2 border-dashed border-[#ebb751] bg-[#ebb751]/5 rounded-2xl p-8 text-center shadow-sm">
                    <i class="ti ti-file-search text-5xl text-[#ebb751] mb-4"></i>
                    <h5 class="text-lg font-bold text-[#b58c3d]">Menunggu Review Marketing</h5>
                    <p class="text-sm text-[#8a969c] max-w-md mx-auto mt-2">Pelanggan telah menandatangani Berita Acara. Saat ini menunggu tim Marketing untuk melakukan verifikasi akhir.</p>
                </div>
            @endif

            @if($request->status === 'selesai')
                <div class="boron-card border-2 border-dashed border-[#70bb63] bg-[#70bb63]/5 rounded-2xl p-8 text-center">
                    <i class="ti ti-circle-check text-5xl text-[#70bb63] mb-4"></i>
                    <h5 class="text-lg font-bold text-[#4a8a3f]">Seluruh Proses Selesai!</h5>
                    <p class="text-sm text-[#8a969c] max-w-md mx-auto mt-2 mb-5">Tim Marketing telah memverifikasi Berita Acara. Perubahan layanan telah resmi ditutup.</p>
                    
                    <a href="{{ Storage::url($request->bau?->signed_bau_path) }}" target="_blank" class="btn-boron bg-[#70bb63] text-white px-6 py-2 rounded-xl font-bold shadow-md hover:bg-[#5da352] transition-all inline-flex items-center gap-2">
                        <i class="ti ti-file-download"></i> Download Berita Acara Final
                    </a>
                </div>
            @endif
        </div>

        {{-- TIMELINE KANAN --}}
        <div class="space-y-6">
            <div class="boron-card rounded-2xl shadow-sm">
                <div class="boron-card-header p-5 border-b border-[#e7e9eb] dark:border-[#37394d] bg-[#f8f9fa] dark:bg-[#15151b]">
                    <h5 class="font-bold text-sm text-[#313a46] dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="ti ti-map-2 text-[#8a969c]"></i> Status Tracking
                    </h5>
                </div>
                <div class="boron-card-body p-6">
                    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-[15px] before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-[#e7e9eb] before:to-transparent dark:before:via-[#37394d]">
                        @php
                            $steps = [
                                'proses_upgrade' => ['title' => 'Eksekusi Jaringan (NOC)', 'icon' => 'ti-router'],
                                'pembuatan_bau' => ['title' => 'Pembuatan Berita Acara', 'icon' => 'ti-file-description'],
                                'menunggu_ttd_bau' => ['title' => 'Menunggu TTD Pelanggan', 'icon' => 'ti-certificate'],
                                'verifikasi_ttd_bau' => ['title' => 'Review Marketing', 'icon' => 'ti-file-search'],
                                'selesai' => ['title' => 'Layanan Selesai', 'icon' => 'ti-circle-check'],
                            ];
                            
                            $allStatuses = ['menunggu_pelanggan', 'menunggu_approval', 'form_disetujui', 'menunggu_ttd_pelanggan', 'verifikasi_ttd_pelanggan', 'proses_upgrade', 'pembuatan_bau', 'menunggu_ttd_bau', 'verifikasi_ttd_bau', 'selesai'];
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