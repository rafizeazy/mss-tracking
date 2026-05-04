<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">Eksekusi SPK: {{ $customer->company_name }}</h4>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('noc.tracking.index') }}" wire:navigate class="btn-boron btn-boron-outline-secondary !py-1.5">
                <i class="ti ti-arrow-left"></i> Kembali ke Antrean
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-[0.3rem] border border-[#70bb63]/30 bg-[#70bb63]/10 p-3 text-sm text-[#70bb63]">
            <i class="ti ti-check mr-1"></i> {{ session('success') }}
        </div>
    @endif
    <div class="grid gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            
            <div class="boron-card">
                <div class="boron-card-header bg-[#f8f9fa] border-b border-[#e7e9eb] pb-3 dark:bg-[#1e1f27] dark:border-[#37394d] flex justify-between items-center">
                    <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf]"><i class="ti ti-file-description mr-1"></i> Detail Surat Perintah Kerja (SPK)</h5>
                    <a href="{{ route('marketing.spk', $service->id) }}" target="_blank" class="btn-boron btn-boron-primary !py-1 !px-3 text-xs shadow-md">
                        <i class="ti ti-download mr-1"></i> Unduh PDF SPK
                    </a>
                </div>
                <div class="boron-card-body p-5">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5 border-b border-dashed border-[#e7e9eb] pb-5 dark:border-[#37394d]">
                        <div><p class="text-xs text-[#8a969c] uppercase mb-1">Nomor SPK</p><p class="font-bold text-[#313a46] dark:text-white">{{ $service->spk->spk_number ?? '-' }}</p></div>
                        <div><p class="text-xs text-[#8a969c] uppercase mb-1">Jenis Pekerjaan</p><p class="font-bold text-[#313a46] dark:text-white">{{ $service->spk->job_type ?? '-' }}</p></div>
                        <div>
                            <p class="text-xs text-[#8a969c] uppercase mb-1">Kapasitas & Layanan</p>
                            <p class="font-bold text-[#1e5d87] dark:text-[#60addf]">{{ $service->bandwidth ?? '-' }}</p>
                            <p class="text-[10px] text-[#8a969c] leading-tight mt-0.5">{{ $service->service_type ?? '-' }}</p>
                        </div>
                        <div><p class="text-xs text-[#8a969c] uppercase mb-1">Tenggat (Due)</p><p class="font-bold text-[#ed6060]">{{ $service->spk?->due_date ? \Carbon\Carbon::parse($service->spk->due_date)->format('d M Y') : '-' }}</p></div>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-2 font-semibold">Instruksi Pekerjaan:</p>
                        <div class="rounded bg-[#f8f9fa] p-4 text-sm text-[#4c4c5c] border border-[#dee2e6] dark:bg-[#15151b] dark:border-[#37394d] dark:text-[#aab8c5] italic">
                            "{{ $service->spk->notes ?? 'Tidak ada instruksi khusus.' }}"
                        </div>
                    </div>
                </div>
            </div>

            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">Lokasi & Kontak Teknis</h5>
                </div>
                <div class="boron-card-body p-5 grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                    <div class="col-span-2">
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Alamat Instalasi</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $service->installation_address ?? $customer->installation_address ?? $customer->company_address }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Nama PIC Teknis</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->technical_name ?? $customer->user?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Kontak & Email</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->technical_phone ?? $customer->phone ?? '-' }}</p>
                        <p class="text-xs text-[#8a969c] mt-0.5">{{ $customer->technical_email ?? '-' }}</p>
                    </div>
                    <div class="col-span-2 sm:col-span-1 border-t border-dashed border-[#e7e9eb] pt-4 mt-2 dark:border-[#37394d]">
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Marketing / Sales</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $service->marketing_name ?? '-' }}</p>
                    </div>
                    <div class="col-span-2 sm:col-span-1 border-t border-dashed border-[#e7e9eb] pt-4 mt-2 dark:border-[#37394d]">
                        <p class="text-xs text-[#8a969c] uppercase mb-1">No. Handphone Sales</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $service->marketing_phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            @if($customer->status === 'proses_aktivasi' || $isEditingBaa)
                <div class="boron-card border-2 border-[#ebb751] shadow-lg">
                    <div class="boron-card-header bg-[#ebb751]/10 border-b border-[#ebb751]/20 pb-3">
                        <h5 class="font-bold text-[#b58c3d] dark:text-[#ebb751]"><i class="ti ti-file-certificate"></i> Formulir Pembuatan Berita Acara Aktivasi (BAA)</h5>
                    </div>
                    <div class="boron-card-body p-5">
                        <form wire:submit.prevent="finishActivation" class="space-y-6">
                            
                            <div class="grid grid-cols-2 gap-4 border-b border-dashed border-[#e7e9eb] pb-6 dark:border-[#37394d]">
                                <div class="col-span-2 sm:col-span-1">
                                    <label class="mb-1 block text-xs font-bold uppercase text-[#1e5d87] dark:text-[#60addf]">ID Pelanggan (Baru)</label>
                                    <input type="text" wire:model="customer_number" placeholder="Contoh: G013" class="w-full rounded-[0.3rem] border border-[#60addf] bg-white px-3 py-2 text-sm focus:ring-2 focus:ring-[#60addf]/30 dark:bg-[#15151b] font-semibold text-[#313a46] dark:text-white">
                                    @error('customer_number') <span class="text-[10px] text-[#ed6060] font-semibold">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label class="mb-1 block text-xs font-bold uppercase text-[#8a969c]">Tanggal Aktif Internet</label>
                                    <input type="date" wire:model="activation_date" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#15151b]">
                                    @error('activation_date') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <h6 class="text-sm font-semibold text-[#313a46] dark:text-white mb-3">Data PIC NOC (Pembuat BAA)</h6>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-1 block text-xs text-[#8a969c]">Nama NOC</label>
                                        <input type="text" wire:model="noc_name" class="w-full rounded border border-[#dee2e6] px-3 py-1.5 text-sm dark:border-[#37394d] dark:bg-[#15151b]">
                                        @error('noc_name') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-xs text-[#8a969c]">Jabatan</label>
                                        <input type="text" wire:model="noc_position" class="w-full rounded border border-[#dee2e6] px-3 py-1.5 text-sm dark:border-[#37394d] dark:bg-[#15151b]">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-xs text-[#8a969c]">Departemen</label>
                                        <input type="text" wire:model="noc_department" class="w-full rounded border border-[#dee2e6] px-3 py-1.5 text-sm dark:border-[#37394d] dark:bg-[#15151b]">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-xs text-[#8a969c]">Lokasi Kerja</label>
                                        <input type="text" wire:model="noc_location" class="w-full rounded border border-[#dee2e6] px-3 py-1.5 text-sm dark:border-[#37394d] dark:bg-[#15151b]">
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-dashed border-[#e7e9eb] pt-6 dark:border-[#37394d]">
                                <div class="flex justify-between items-center mb-3">
                                    <h6 class="text-sm font-semibold text-[#313a46] dark:text-white">Perangkat yang Dipasang</h6>
                                    <button type="button" wire:click="addDevice" class="btn-boron bg-[#60addf]/10 text-[#60addf] hover:bg-[#60addf] hover:text-white !py-1 !px-2 text-xs">
                                        <i class="ti ti-plus"></i> Tambah Perangkat
                                    </button>
                                </div>

                                <div class="space-y-3">
                                    @foreach($devices as $index => $device)
                                        <div class="flex items-start gap-2 bg-[#f8f9fa] p-3 rounded border border-[#dee2e6] dark:bg-white/5 dark:border-[#37394d]">
                                            <div class="flex-1 grid grid-cols-12 gap-2">
                                                <div class="col-span-5">
                                                    <input type="text" wire:model="devices.{{ $index }}.name" placeholder="Nama Perangkat (ex: Router Ruijie)" class="w-full rounded border border-[#dee2e6] px-3 py-1.5 text-sm dark:border-[#37394d] dark:bg-[#15151b]">
                                                    @error('devices.'.$index.'.name') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="col-span-2">
                                                    <input type="number" wire:model="devices.{{ $index }}.qty" placeholder="Qty" min="1" class="w-full rounded border border-[#dee2e6] px-3 py-1.5 text-sm dark:border-[#37394d] dark:bg-[#15151b]">
                                                </div>
                                                <div class="col-span-5">
                                                    <input type="text" wire:model="devices.{{ $index }}.sn" placeholder="Serial Number (SN)" class="w-full rounded border border-[#dee2e6] px-3 py-1.5 text-sm dark:border-[#37394d] dark:bg-[#15151b]">
                                                    @error('devices.'.$index.'.sn') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            @if(count($devices) > 1)
                                                <button type="button" wire:click="removeDevice({{ $index }})" class="btn-boron bg-transparent text-[#ed6060] hover:bg-[#ed6060]/10 !p-1.5 shrink-0 mt-0.5">
                                                    <i class="ti ti-trash text-lg"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="border-t border-dashed border-[#e7e9eb] pt-6 dark:border-[#37394d] grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="mb-1 block text-xs font-semibold text-[#8a969c]">Upload TTD NOC (PNG Transparan)</label>
                                    <input type="file" wire:model="noc_signature" accept="image/png,image/jpeg" class="w-full text-sm text-[#4c4c5c] file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-[#60addf]/10 file:text-[#60addf] hover:file:bg-[#60addf]/20">
                                    @error('noc_signature') <span class="text-[10px] text-[#ed6060] block mt-1">{{ $message }}</span> @enderror
                                    @if($noc_signature) <p class="text-xs text-[#70bb63] mt-1"><i class="ti ti-check"></i> File dipilih</p> @endif
                                </div>
                                <div>
                                    <label class="mb-1 block text-xs font-semibold text-[#8a969c]">Upload Bukti Speedtest (Lampiran)</label>
                                    <input type="file" wire:model="speedtest_image" accept="image/*" class="w-full text-sm text-[#4c4c5c] file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-[#ebb751]/10 file:text-[#ebb751] hover:file:bg-[#ebb751]/20">
                                    @error('speedtest_image') <span class="text-[10px] text-[#ed6060] block mt-1">{{ $message }}</span> @enderror
                                    @if($speedtest_image) <p class="text-xs text-[#70bb63] mt-1"><i class="ti ti-check"></i> File dipilih</p> @endif
                                </div>
                            </div>

                            <button type="submit" wire:loading.attr="disabled" class="mt-6 w-full btn-boron btn-boron-primary shadow-lg !py-3 font-bold text-base flex justify-center gap-2">
                                <span wire:loading.remove><i class="ti ti-device-floppy"></i> Simpan & Terbitkan BAA</span>
                                <span wire:loading>Memproses Data & Upload...</span>
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($customer->status === 'review_baa' && !$isEditingBaa)
                <div class="boron-card border-2 border-[#60addf] shadow-lg">
                    <div class="boron-card-header bg-[#60addf]/10 border-b border-[#60addf]/20 pb-3">
                        <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf]"><i class="ti ti-eye"></i> Review & Kirim BAA</h5>
                    </div>
                    <div class="boron-card-body p-5">
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mb-5">
                            BAA berhasil dibuat. Silakan klik tombol <strong>"Lihat PDF"</strong> untuk mengecek apakah data sudah benar. Jika ada yang salah, klik <strong>"Edit BAA"</strong>. Jika sudah sempurna, klik <strong>"Kirim ke Pelanggan"</strong>.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('noc.baa', $service->id) }}" target="_blank" class="w-full btn-boron bg-[#f8f9fa] text-[#313a46] border border-[#dee2e6] hover:bg-[#e7e9eb] flex justify-center gap-2 !py-2.5 dark:bg-[#1e1f27] dark:text-white dark:border-[#37394d]">
                                <i class="ti ti-file-pdf text-[#ed6060] text-lg"></i> 1. Lihat PDF BAA
                            </a>
                            <button wire:click="editBaa" class="w-full btn-boron btn-boron-outline-secondary flex justify-center gap-2 !py-2.5">
                                <i class="ti ti-edit text-lg"></i> 2. Edit BAA
                            </button>
                        </div>
                        
                        <div class="mt-4 border-t border-dashed border-[#e7e9eb] pt-4 dark:border-[#37394d]">
                            <button type="button" wire:click="openSendBaaModal" class="w-full btn-boron btn-boron-primary shadow-lg flex justify-center gap-2 !py-3 font-bold">
                                <i class="ti ti-send text-lg"></i> 3. BAA Benar, Kirim ke Pelanggan
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <div class="space-y-6">
            
            <div class="boron-card border-2 shadow-lg overflow-hidden {{ $customer->status === 'proses_instalasi' ? 'border-[#ed6060]' : ($customer->status === 'proses_aktivasi' || $customer->status === 'review_baa' ? 'border-[#ebb751]' : 'border-[#70bb63]') }}">
                <div class="boron-card-header pb-3 {{ $customer->status === 'proses_instalasi' ? 'bg-[#ed6060]/10 border-[#ed6060]/20' : ($customer->status === 'proses_aktivasi' || $customer->status === 'review_baa' ? 'bg-[#ebb751]/10 border-[#ebb751]/20' : 'bg-[#70bb63]/10 border-[#70bb63]/20') }}">
                    <h5 class="font-bold {{ $customer->status === 'proses_instalasi' ? 'text-[#ed6060]' : ($customer->status === 'proses_aktivasi' || $customer->status === 'review_baa' ? 'text-[#ebb751]' : 'text-[#70bb63]') }}"><i class="ti ti-tool"></i> Tugas NOC</h5>
                </div>
                <div class="boron-card-body p-5 text-center">
                    
                    @if($customer->status === 'proses_instalasi')
                        <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-[#ed6060]/10 text-[#ed6060] mb-3"><i class="ti ti-router text-2xl"></i></div>
                        <h6 class="font-bold text-[#313a46] dark:text-white mb-2">Tahap 1: Instalasi Fisik</h6>
                        <p class="text-sm text-[#8a969c] mb-5">Lakukan penarikan kabel, splicing, dan pemasangan perangkat di lokasi pelanggan.</p>
                        <button type="button" wire:click="openFinishInstallationModal" class="w-full btn-boron bg-[#ed6060] text-white hover:bg-[#d95454] shadow-lg !py-2.5">
                            Instalasi Selesai <i class="ti ti-arrow-right ml-1"></i>
                        </button>
                        
                    @elseif($customer->status === 'proses_aktivasi' || $customer->status === 'review_baa')
                        <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-[#ebb751]/10 text-[#ebb751] mb-3"><i class="ti ti-wifi text-2xl animate-pulse"></i></div>
                        <h6 class="font-bold text-[#313a46] dark:text-white mb-2">Tahap 2: Konfigurasi & Aktivasi</h6>
                        <p class="text-sm text-[#8a969c]">Lakukan konfigurasi sistem. Silakan isi Formulir BAA di sebelah kiri untuk menyelesaikan proses ini.</p>

                    @else
                        <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-[#70bb63] text-white shadow-lg shadow-[#70bb63]/30 mb-3"><i class="ti ti-check text-2xl"></i></div>
                        <h6 class="font-bold text-[#4a8a3f] dark:text-[#70bb63] mb-1">Internet UP & BAA Terbit</h6>
                        <p class="text-sm text-[#8a969c] mb-5">ID Pelanggan: <strong class="text-[#313a46] dark:text-white">{{ $customer->customer_number }}</strong></p>
                        
                        @if($service->baa)
                            <a href="{{ route('noc.baa', $service->id) }}" target="_blank" class="w-full btn-boron btn-boron-outline-primary flex justify-center gap-2 !py-2.5">
                                <i class="ti ti-file-pdf text-lg text-[#ed6060]"></i> Lihat / Cetak BAA
                            </a>
                        @endif
                    @endif
                    
                </div>
            </div>

            <div class="boron-card h-fit">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">Progres Layanan</h5>
                </div>
                <div class="boron-card-body p-6">
                    @php
                            $statusOrder = [
                                'menunggu_verifikasi', 'menunggu_invoice', 'menunggu_pembayaran', 
                                'verifikasi_pembayaran', 'pembayaran_disetujui', 'proses_instalasi', 
                                'proses_aktivasi', 'review_baa', 'menunggu_baa', 'verifikasi_baa', 'selesai'
                            ];
                        $currentIndex = array_search($customer->status, $statusOrder);
                        
                        $workflows = [
                            ['id' => 'pembayaran_disetujui', 'title' => 'Pembayaran Disetujui', 'icon' => 'ti-cash'],
                            ['id' => 'proses_instalasi', 'title' => 'Proses Instalasi (NOC)', 'icon' => 'ti-router'],
                            ['id' => 'proses_aktivasi', 'title' => 'Proses Aktivasi & BAA', 'icon' => 'ti-wifi'],
                            ['id' => 'review_baa', 'title' => 'Review BAA', 'icon' => 'ti-eye'],
                            ['id' => 'menunggu_baa', 'title' => 'Tunggu TTD Pelanggan', 'icon' => 'ti-file-description'],
                            ['id' => 'verifikasi_baa', 'title' => 'Verifikasi TTD BAA', 'icon' => 'ti-file-check'],
                            ['id' => 'selesai', 'title' => 'Selesai & Aktif', 'icon' => 'ti-circle-check'],
                        ];
                    @endphp

                    <div class="relative ml-3 border-l-2 border-[#e7e9eb] dark:border-[#37394d]">
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

                            <div class="mb-6 ml-8 relative last:mb-0">
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

                                <div>
                                    <h5 class="text-sm font-semibold pt-2 {{ $state === 'active' ? 'text-[#60addf]' : ($state === 'completed' ? 'text-[#313a46] dark:text-white' : 'text-[#8a969c]') }}">
                                        {{ $step['title'] }}
                                    </h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($showFinishInstallationModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
            <div class="w-full max-w-lg overflow-hidden rounded-xl border border-[#e7e9eb] bg-white shadow-2xl dark:border-[#37394d] dark:bg-[#1e1f27]">
                <div class="flex items-start justify-between gap-4 border-b border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5">
                    <div>
                        <h3 class="text-base font-bold text-[#313a46] dark:text-white">Instalasi Selesai</h3>
                        <p class="mt-1 text-sm text-[#8a969c]">Pastikan perangkat fisik sudah terpasang sebelum lanjut ke proses aktivasi.</p>
                    </div>
                    <button type="button" wire:click="closeFinishInstallationModal" class="rounded-full p-2 text-[#8a969c] hover:bg-[#ed6060]/10 hover:text-[#ed6060]">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                <div class="px-5 py-5">
                    <div class="rounded-lg border border-[#ebb751]/30 bg-[#ebb751]/10 p-4 text-sm leading-relaxed text-[#b58c3d] dark:text-[#ebb751]">
                        Status pelanggan akan berubah menjadi proses aktivasi, lalu tim NOC dapat melengkapi dan menerbitkan BAA.
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5 sm:flex-row sm:justify-end">
                    <button type="button" wire:click="closeFinishInstallationModal" class="btn-boron border border-[#dee2e6] px-4 py-2 text-sm text-[#313a46] hover:bg-zinc-100 dark:border-[#37394d] dark:text-white dark:hover:bg-white/5">
                        Periksa Lagi
                    </button>
                    <button type="button" wire:click="finishInstallation" wire:loading.attr="disabled" wire:target="finishInstallation" class="btn-boron bg-[#ed6060] px-5 py-2 text-sm font-semibold text-white hover:bg-[#d95454] disabled:cursor-not-allowed disabled:opacity-60">
                        Lanjut Aktivasi
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showSendBaaModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
            <div class="w-full max-w-lg overflow-hidden rounded-xl border border-[#e7e9eb] bg-white shadow-2xl dark:border-[#37394d] dark:bg-[#1e1f27]">
                <div class="flex items-start justify-between gap-4 border-b border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5">
                    <div>
                        <h3 class="text-base font-bold text-[#313a46] dark:text-white">Kirim BAA ke Pelanggan</h3>
                        <p class="mt-1 text-sm text-[#8a969c]">Pastikan PDF BAA sudah benar sebelum dikirim ke Dashboard Pelanggan.</p>
                    </div>
                    <button type="button" wire:click="closeSendBaaModal" class="rounded-full p-2 text-[#8a969c] hover:bg-[#ed6060]/10 hover:text-[#ed6060]">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                <div class="px-5 py-5">
                    <div class="rounded-lg border border-[#60addf]/25 bg-[#60addf]/10 p-4 text-sm leading-relaxed text-[#1e5d87] dark:text-[#60addf]">
                        BAA akan muncul di dashboard pelanggan untuk diunduh, ditandatangani, lalu diunggah kembali.
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5 sm:flex-row sm:justify-end">
                    <button type="button" wire:click="closeSendBaaModal" class="btn-boron border border-[#dee2e6] px-4 py-2 text-sm text-[#313a46] hover:bg-zinc-100 dark:border-[#37394d] dark:text-white dark:hover:bg-white/5">
                        Periksa Lagi
                    </button>
                    <button type="button" wire:click="sendBaaToCustomer" wire:loading.attr="disabled" wire:target="sendBaaToCustomer" class="btn-boron btn-boron-primary flex items-center justify-center gap-2 px-5 py-2 text-sm shadow-md shadow-[#669776]/30 disabled:cursor-not-allowed disabled:opacity-60">
                        <i class="ti ti-send"></i> Kirim ke Pelanggan
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
