<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">
                Verifikasi Data: {{ $customer->company_name }}
            </h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">ID: <span class="font-medium text-[#ebb751]">{{ $customer->customer_number ?? 'Belum Diterbitkan (Menunggu BAA)' }}</span> | Tgl Daftar: {{ $customer->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">

            <button wire:click="editCustomer" class="btn-boron btn-boron-secondary !py-1.5 flex items-center gap-1 bg-[#f8f9fa] text-[#4c4c5c] hover:bg-[#e7e9eb] border border-[#dee2e6] dark:bg-[#1e1f27] dark:text-white dark:border-[#37394d] dark:hover:bg-[#252630]">
                <i class="ti ti-edit"></i> Edit Data
            </button>
            <a href="{{ route('form.formulir', $service->id) }}" target="_blank" class="btn-boron !py-1.5 flex items-center gap-1 bg-[#1e5d87]/10 text-[#1e5d87] hover:bg-[#1e5d87]/20 border border-[#1e5d87]/20 transition-colors font-medium dark:bg-[#60addf]/10 dark:text-[#60addf] dark:border-[#60addf]/20">
                <i class="ti ti-file-text"></i> Cetak Formulir
            </a>

            @if(!in_array($service->status, ['selesai', 'dibatalkan', 'ditolak']))
                <button type="button" wire:click="openCancellationModal" class="btn-boron !py-1.5 flex items-center justify-center gap-1 bg-transparent text-[#ed6060] hover:bg-[#ed6060]/10 border border-[#ed6060] transition-colors font-medium">
                    <i class="ti ti-ban"></i> Batalkan Pengajuan
                </button>
            @endif
            
            <a href="{{ route('marketing.tracking.index') }}" wire:navigate class="btn-boron btn-boron-outline-secondary !py-1.5">
                <i class="ti ti-arrow-left"></i> Kembali ke Antrean
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-[0.3rem] border border-[#70bb63]/30 bg-[#70bb63]/10 p-3 text-sm text-[#70bb63]">
            <i class="ti ti-check mr-1"></i> {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 rounded-[0.3rem] border border-[#ed6060]/30 bg-[#ed6060]/10 p-3 text-sm text-[#ed6060]">
            <i class="ti ti-x mr-1"></i> {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-3">
        
        <div class="space-y-6 xl:col-span-2">
            
            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d] flex justify-between items-center">
                    <h5 class="font-semibold text-[#313a46] dark:text-white"><i class="ti ti-user mr-1 text-[#669776]"></i> 1. Informasi Pendaftar (Yang Diberi Wewenang)</h5>
                </div>
                <div class="boron-card-body p-5 grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-6 text-sm">
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Nama Lengkap</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Nomor KTP</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->ktp_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Jenis Kelamin</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->gender === 'L' ? 'Laki-laki' : ($customer->gender === 'P' ? 'Perempuan' : '-') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Jabatan</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->position ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Email Login</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">No. Handphone</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white"><i class="ti ti-building mr-1 text-[#669776]"></i> 2. Informasi Perusahaan / Institusi</h5>
                </div>
                <div class="boron-card-body p-5 grid grid-cols-2 sm:grid-cols-3 gap-y-4 gap-x-6 text-sm">
                    <div class="col-span-2 sm:col-span-3">
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Nama Perusahaan</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->company_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Bidang Usaha</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->business_type ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">NPWP Perusahaan</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->npwp_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Telepon Perusahaan</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->company_phone ?? '-' }}</p>
                    </div>
                    <div class="col-span-2 sm:col-span-3">
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Alamat Lengkap Perusahaan</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->company_address ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Kota</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->city ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Provinsi</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->province ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Kode Pos</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->postal_code ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="boron-card">
                    <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d] bg-[#f8f9fa] dark:bg-white/5">
                        <h5 class="font-semibold text-[#313a46] dark:text-white text-sm">PIC Keuangan / Penagihan</h5>
                    </div>
                    <div class="boron-card-body p-4 space-y-3 text-sm">
                        <div>
                            <p class="text-xs text-[#8a969c] uppercase">Nama PIC Finance</p>
                            <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->finance_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#8a969c] uppercase">Kontak & Email</p>
                            <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->finance_phone ?? '-' }} <br> {{ $customer->finance_email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#8a969c] uppercase">Alamat Penagihan (Invoice)</p>
                            <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->billing_address ?? 'Sama dengan alamat perusahaan' }}</p>
                        </div>
                    </div>
                </div>

                <div class="boron-card">
                    <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d] bg-[#f8f9fa] dark:bg-white/5">
                        <h5 class="font-semibold text-[#313a46] dark:text-white text-sm">PIC Teknis / Instalasi</h5>
                    </div>
                    <div class="boron-card-body p-4 space-y-3 text-sm">
                        <div>
                            <p class="text-xs text-[#8a969c] uppercase">Nama PIC Teknis</p>
                            <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->technical_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-[#8a969c] uppercase">Kontak & Email</p>
                            <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->technical_phone ?? '-' }} <br> {{ $customer->technical_email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white"><i class="ti ti-wifi mr-1 text-[#669776]"></i> 3. Layanan & Dokumen Terlampir</h5>
                </div>
                <div class="boron-card-body p-5">
                    <div class="flex items-center gap-6 mb-6">
                        <div class="flex-1 rounded-[0.3rem] border border-[#60addf]/30 bg-[#60addf]/5 p-4">
                            <p class="text-xs text-[#60addf] uppercase font-semibold mb-1">Paket Layanan Dipilih</p>
                            <p class="text-lg font-bold text-[#1e5d87] dark:text-[#60addf]">{{ $service->bandwidth ?? '-' }}</p>
                            <p class="text-xs text-[#1e5d87]/70 dark:text-[#60addf]/70">{{ $service->service_type ?? '-' }}</p>
                        </div>
                        <div class="flex-1 rounded-[0.3rem] border border-[#ebb751]/30 bg-[#ebb751]/5 p-4">
                            <p class="text-xs text-[#ebb751] uppercase font-semibold mb-1">Durasi Kontrak</p>
                            <p class="text-lg font-bold text-[#b58c3d] dark:text-[#ebb751]">{{ $service->term_of_service ?? '-' }} Tahun ({{ ($service->term_of_service ?? 0) * 12 }} Bulan)</p>
                        </div>
                    </div>
            
                    <div class="mb-6 p-4 rounded bg-[#f8f9fa] border border-[#dee2e6] dark:bg-[#1e1f27] dark:border-[#37394d]">
                        <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-1">Alamat Instalasi Layanan</p>
                        <p class="text-sm font-medium text-[#313a46] dark:text-white">{{ $service->installation_address ?? $customer->installation_address ?? 'Sama dengan alamat perusahaan' }}</p>
                    </div>
            
                    <p class="text-xs text-[#8a969c] uppercase mb-3 font-semibold border-b border-dashed border-[#e7e9eb] pb-2 dark:border-[#37394d]">Pemeriksaan Dokumen Legal</p>
                    <div class="grid sm:grid-cols-2 gap-4">
                        @php
                            $documents = [
                                ['label' => 'Scan KTP', 'path' => $customer->ktp_file_path],
                                ['label' => 'Scan NPWP', 'path' => $customer->npwp_file_path],
                                ['label' => 'Scan NIB', 'path' => $customer->nib_file_path],
                                ['label' => 'Sertifikat Standar', 'path' => $customer->certificate_file_path],
                            ];
                        @endphp
            
                        @foreach($documents as $doc)
                            <div class="flex items-center justify-between rounded bg-[#f8f9fa] px-4 py-3 border border-[#dee2e6] dark:bg-[#1e1f27] dark:border-[#37394d]">
                                <div class="flex items-center gap-3">
                                    <i class="ti {{ $doc['path'] ? 'ti-file-check text-[#669776]' : 'ti-file-x text-[#ed6060]' }} text-xl"></i>
                                    <span class="text-sm font-medium {{ $doc['path'] ? 'text-[#313a46] dark:text-white' : 'text-[#8a969c]' }}">{{ $doc['label'] }}</span>
                                </div>
                                @if($doc['path'])
                                    <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="text-xs font-semibold text-[#60addf] hover:underline">Lihat File</a>
                                @else
                                    <span class="text-xs text-[#ed6060]">Tidak dilampirkan</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="space-y-6">
            
            @if($service->status === 'menunggu_verifikasi')
                <div class="boron-card border-2 border-[#ebb751] shadow-lg">
                    <div class="boron-card-header bg-[#ebb751]/10 border-b border-[#ebb751]/20 pb-3">
                        <h5 class="font-bold text-[#b58c3d] dark:text-[#ebb751]"><i class="ti ti-shield-check"></i> Form Verifikasi & Komersial</h5>
                    </div>
                    <div class="boron-card-body p-5">
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mb-4 pb-4 border-b border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                            Lengkapi detail komersial berikut sebelum menyetujui. Data ini akan menjadi acuan dasar pembuatan Invoice oleh tim Finance.
                        </p>
                        
                        <form wire:submit.prevent="approve" class="space-y-4">
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div class="col-span-1">
                                    <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Jenis Layanan</label>
                                    <input type="text" wire:model="service_type" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-[#f8f9fa] px-3 py-1.5 text-sm text-[#8a969c] cursor-not-allowed dark:border-[#37394d] dark:bg-[#15151b]" readonly>
                                    @error('service_type') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-1">
                                    <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Kapasitas Final</label>
                                    <input type="text" wire:model="bandwidth" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#15151b]">
                                    @error('bandwidth') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-2" x-data="{
                                    isCustom: false,
                                    init() {
                                        const predefined = ['Lokal Link', 'Telkom', 'Lintas Arta', 'Indosat', 'MV. Net Telkom', 'Fiber Star', 'Iforte'];
                                        const current = @js($metro_link);
                                        this.isCustom = current !== '' && current !== null && !predefined.includes(current);
                                    }
                                }">
                                    <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Vendor Jalur Metro</label>
                                    <select 
                                        wire:model="metro_link" 
                                        x-show="!isCustom" 
                                        @change="$event.target.value === 'Lainnya' ? (isCustom = true, $wire.set('metro_link', '')) : isCustom = false"
                                        class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#15151b]"
                                    >
                                        <option value="">Pilih Jalur Metro...</option>
                                        <option value="Lokal Link">Lokal Link</option>
                                        <option value="Telkom">Telkom</option>
                                        <option value="Lintas Arta">Lintas Arta</option>
                                        <option value="Indosat">Indosat</option>
                                        <option value="MV. Net Telkom">MV. Net Telkom</option>
                                        <option value="Fiber Star">Fiber Star</option>
                                        <option value="Iforte">Iforte</option>
                                        <option value="Lainnya">Lainnya...</option>
                                    </select>
                                    
                                    <div x-show="isCustom" style="display: none;" class="flex gap-2">
                                        <input type="text" wire:model="metro_link" placeholder="Ketik nama vendor jalur metro..." class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#15151b]">
                                        <button type="button" @click="isCustom = false; $wire.set('metro_link', '')" class="px-2 text-[#ed6060] hover:bg-[#ed6060]/10 rounded" title="Batal isi manual">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                    @error('metro_link') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="col-span-2" x-data="{
                                    raw: @entangle('registration_fee'),
                                    formatRupiah(val) {
                                        if (!val) return '';
                                        return parseInt(String(val).replace(/[^0-9]/g, '')).toLocaleString('id-ID');
                                    },
                                    onInput(e) {
                                        let val = e.target.value.replace(/[^0-9]/g, '');
                                        this.raw = val ? parseInt(val) : null;
                                        e.target.value = this.formatRupiah(val);
                                    }
                                }">
                                    <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Biaya Registrasi / Instalasi (Rp)</label>
                                    <input type="text" :value="formatRupiah(raw)" @input="onInput" placeholder="0" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#15151b]">
                                    @error('registration_fee') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="col-span-2" x-data="{
                                    raw: @entangle('monthly_fee'),
                                    formatRupiah(val) {
                                        if (!val) return '';
                                        return parseInt(String(val).replace(/[^0-9]/g, '')).toLocaleString('id-ID');
                                    },
                                    onInput(e) {
                                        let val = e.target.value.replace(/[^0-9]/g, '');
                                        this.raw = val ? parseInt(val) : null;
                                        e.target.value = this.formatRupiah(val);
                                    }
                                }">
                                    <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Biaya Bulanan (Rp)</label>
                                    <input type="text" :value="formatRupiah(raw)" @input="onInput" placeholder="0" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#15151b]">
                                    <p class="mt-1 text-[10px] italic text-[#ed6060]">*Harga di atas belum termasuk PPN 11%</p>
                                    @error('monthly_fee') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 rounded bg-[#f8f9fa] p-3 border border-[#dee2e6] dark:bg-white/5 dark:border-[#37394d] mt-2">
                                <div class="col-span-2">
                                    <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Nama Sales / Marketing</label>
                                    <input type="text" wire:model="marketing_name" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#15151b]">
                                    @error('marketing_name') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-span-2">
                                    <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">No. Handphone Marketing</label>
                                    <input type="text" wire:model="marketing_phone" placeholder="Contoh: 0812..." class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#15151b]">
                                    @error('marketing_phone') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <button type="submit" wire:target="approve" wire:loading.attr="disabled" class="mt-4 w-full btn-boron btn-boron-primary flex justify-center gap-2 !py-2.5 shadow-lg shadow-[#669776]/30">
                                <i class="ti ti-check text-lg"></i> Setujui
                            </button>
                        </form>
                        
                        <div class="mt-3 border-t border-dashed border-[#e7e9eb] pt-3 dark:border-[#37394d]">
                            <textarea wire:model="rejectionReason" rows="2" placeholder="Alasan penolakan..." class="mb-2 w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#ed6060] focus:ring-1 focus:ring-[#ed6060] dark:border-[#37394d] dark:bg-[#15151b]"></textarea>
                            @error('rejectionReason') <span class="mb-2 block text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                            <button type="button" wire:click="reject" wire:confirm="Yakin ingin menolak pendaftaran ini? Aksi ini tidak dapat dibatalkan." class="w-full btn-boron !bg-transparent !text-[#ed6060] hover:!bg-[#ed6060]/10 flex justify-center gap-2 !py-2 transition-colors">
                                <i class="ti ti-x text-lg"></i> Tolak (Reject)
                            </button>
                        </div>

                    </div>
                </div>
            @endif

            @if($service->status === 'pembayaran_disetujui')
                <div class="boron-card border-2 border-[#60addf] shadow-lg">
                    <div class="boron-card-header bg-[#60addf]/10 border-b border-[#60addf]/20 pb-3">
                        <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf]"><i class="ti ti-file-description"></i> Form Penerbitan SPK NOC</h5>
                    </div>
                    <div class="boron-card-body p-5">
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mb-4 pb-4 border-b border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                            Lengkapi data di bawah ini untuk men-generate Surat Perintah Kerja (SPK) untuk tim NOC.
                        </p>
                        
                        <form wire:submit.prevent="saveSpkData" class="space-y-4">
                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Jenis Pekerjaan</label>
                                <select wire:model="job_type" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#60addf] focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#15151b]">
                                    <option value="Aktivasi Baru">Aktivasi Baru</option>
                                </select>
                                @error('job_type') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Tipe Pelanggan</label>
                                <select wire:model="customer_type" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#60addf] focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#15151b]">
                                    <option value="">Pilih Tipe...</option>
                                    <option value="Government">Government</option>
                                    <option value="Corporate">Corporate</option>
                                </select>
                                @error('customer_type') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Due Date (Target Selesai)</label>
                                <input type="date" wire:model="due_date" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#60addf] focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#15151b]">
                                @error('due_date') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-semibold uppercase text-[#8a969c]">Instruksi Pekerjaan (NOC)</label>
                                <textarea wire:model="spk_notes" rows="4" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#60addf] focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#15151b]"></textarea>
                                @error('spk_notes') <span class="text-[10px] text-[#ed6060]">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full btn-boron btn-boron-outline-primary flex justify-center gap-2 !py-2 text-sm">
                                <i class="ti ti-device-floppy"></i> Simpan Data SPK
                            </button>
                        </form>

                        @if($service->spk)
                            <div class="mt-5 pt-5 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d] space-y-3">
                                <a href="{{ route('marketing.spk', $service->id) }}" target="_blank" class="w-full btn-boron bg-[#f8f9fa] text-[#313a46] border border-[#dee2e6] hover:bg-[#e7e9eb] flex justify-center gap-2 !py-2 text-sm dark:bg-[#1e1f27] dark:text-white dark:border-[#37394d] dark:hover:bg-[#252630]">
                                    <i class="ti ti-file-pdf text-[#ed6060]"></i> Lihat / Cetak PDF SPK
                                </a>
                                <button type="button" wire:click="openSendToNocModal" class="w-full btn-boron btn-boron-primary flex justify-center gap-2 !py-2.5 shadow-lg shadow-[#669776]/30">
                                    <i class="ti ti-send text-lg"></i> Kirim SPK ke NOC
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($service->status === 'verifikasi_baa')
                <div class="boron-card border-2 border-[#70bb63] shadow-lg">
                    <div class="boron-card-header bg-[#70bb63]/10 border-b border-[#70bb63]/20 pb-3">
                        <h5 class="font-bold text-[#4a8a3f] dark:text-[#70bb63]"><i class="ti ti-file-check"></i> Verifikasi Final BAA</h5>
                    </div>
                    <div class="boron-card-body p-5">
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mb-4">
                            Pelanggan telah mengunggah BAA yang ditandatangani. Silakan cek keabsahan tanda tangannya.
                        </p>
                        
                        <a href="{{ asset('storage/' . $service->baa->signed_baa_path) }}" target="_blank" class="w-full btn-boron bg-[#f8f9fa] text-[#313a46] border border-[#dee2e6] hover:bg-[#e7e9eb] flex justify-center gap-2 !py-2 mb-4 dark:bg-[#1e1f27] dark:text-white">
                            <i class="ti ti-eye text-[#1e5d87]"></i> Cek File TTD Pelanggan
                        </a>

                        <div class="flex gap-2">
                            <button type="button" wire:click="openApproveBaaModal" class="w-full btn-boron btn-boron-primary flex justify-center gap-2 !py-2.5">
                                <i class="ti ti-check text-lg"></i> Setujui
                            </button>
                            <button wire:click="rejectBaa" wire:confirm="Tolak BAA ini? Pelanggan harus upload ulang." class="btn-boron bg-transparent text-[#ed6060] border border-[#ed6060] hover:bg-[#ed6060]/10 flex justify-center !py-2.5 !px-3">
                                <i class="ti ti-x text-lg"></i> Tolak
                            </button>
                        </div>
                    </div>
                </div>
            @endif

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
                    $currentIndex = array_search($service->status, $statusOrder);
                    
                    $workflows = [
                        ['id' => 'menunggu_verifikasi', 'title' => 'Menunggu Verifikasi', 'icon' => 'ti-shield-check'],
                        ['id' => 'menunggu_invoice', 'title' => 'Menunggu Invoice', 'icon' => 'ti-file-invoice'],
                        ['id' => 'menunggu_pembayaran', 'title' => 'Menunggu Pembayaran', 'icon' => 'ti-receipt'],
                        ['id' => 'verifikasi_pembayaran', 'title' => 'Verifikasi Pembayaran', 'icon' => 'ti-search'],
                        ['id' => 'pembayaran_disetujui', 'title' => 'Pembayaran Disetujui', 'icon' => 'ti-cash'],
                        ['id' => 'proses_instalasi', 'title' => 'Proses Instalasi', 'icon' => 'ti-router'],
                        ['id' => 'proses_aktivasi', 'title' => 'Proses Aktivasi', 'icon' => 'ti-wifi'],
                        ['id' => 'review_baa', 'title' => 'Review BAA (NOC)', 'icon' => 'ti-eye'],
                        ['id' => 'menunggu_baa', 'title' => 'Tunggu TTD Pelanggan', 'icon' => 'ti-signature'],
                        ['id' => 'verifikasi_baa', 'title' => 'Verifikasi Akhir BAA', 'icon' => 'ti-file-check'],
                        ['id' => 'selesai', 'title' => 'Selesai & Aktif', 'icon' => 'ti-circle-check'],
                    ];
                @endphp

                    <div class="relative ml-3 border-l-2 border-[#e7e9eb] dark:border-[#37394d]">
                        @foreach($workflows as $index => $step)
                            @php
                                $stepIndex = array_search($step['id'], $statusOrder);
                                if ($service->status === 'ditolak') {
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

                    @if($service->status === 'ditolak')
                        <div class="mt-4 rounded bg-[#ed6060]/10 p-3 text-center text-sm font-semibold text-[#ed6060]">
                            <i class="ti ti-x"></i> Registrasi Ditolak oleh Marketing
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @if($showCancellationModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
            <div class="w-full max-w-lg overflow-hidden rounded-xl border border-[#e7e9eb] bg-white shadow-2xl dark:border-[#37394d] dark:bg-[#1e1f27]">
                <div class="flex items-start justify-between gap-4 border-b border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5">
                    <div>
                        <h3 class="text-base font-bold text-[#313a46] dark:text-white">Batalkan Pengajuan</h3>
                        <p class="mt-1 text-sm text-[#8a969c]">Isi alasan pembatalan untuk catatan audit dan informasi pelanggan.</p>
                    </div>
                    <button type="button" wire:click="closeCancellationModal" class="rounded-full p-2 text-[#8a969c] hover:bg-[#ed6060]/10 hover:text-[#ed6060]">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                <div class="space-y-3 px-5 py-5">
                    <label class="block text-xs font-bold uppercase tracking-wide text-[#8a969c]">Alasan Pembatalan</label>
                    <textarea wire:model="cancellationReason" rows="4" placeholder="Contoh: pelanggan meminta pembatalan karena jadwal instalasi berubah..." class="w-full rounded-[0.45rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm text-[#313a46] focus:border-[#ed6060] focus:outline-none focus:ring-1 focus:ring-[#ed6060] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white"></textarea>
                    @error('cancellationReason') <p class="text-xs font-medium text-[#ed6060]">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5 sm:flex-row sm:justify-end">
                    <button type="button" wire:click="closeCancellationModal" class="btn-boron border border-[#dee2e6] px-4 py-2 text-sm text-[#313a46] hover:bg-zinc-100 dark:border-[#37394d] dark:text-white dark:hover:bg-white/5">
                        Batal
                    </button>
                    <button type="button" wire:click="cancelRegistration" wire:loading.attr="disabled" wire:target="cancelRegistration" class="btn-boron flex items-center justify-center gap-2 bg-[#ed6060] px-5 py-2 text-sm font-semibold text-white hover:bg-[#d94f4f] disabled:cursor-not-allowed disabled:opacity-60">
                        <i class="ti ti-device-floppy"></i> Simpan Pembatalan
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showSendToNocModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
            <div class="w-full max-w-lg overflow-hidden rounded-xl border border-[#e7e9eb] bg-white shadow-2xl dark:border-[#37394d] dark:bg-[#1e1f27]">
                <div class="flex items-start justify-between gap-4 border-b border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5">
                    <div>
                        <h3 class="text-base font-bold text-[#313a46] dark:text-white">Kirim SPK ke NOC</h3>
                        <p class="mt-1 text-sm text-[#8a969c]">Pastikan PDF SPK sudah sesuai sebelum dikirim ke Dashboard NOC.</p>
                    </div>
                    <button type="button" wire:click="closeSendToNocModal" class="rounded-full p-2 text-[#8a969c] hover:bg-[#ed6060]/10 hover:text-[#ed6060]">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                <div class="px-5 py-5">
                    <div class="rounded-lg border border-[#60addf]/25 bg-[#60addf]/10 p-4 text-sm leading-relaxed text-[#1e5d87] dark:text-[#60addf]">
                        SPK akan diteruskan ke antrean NOC dan status pelanggan berubah menjadi proses instalasi.
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5 sm:flex-row sm:justify-end">
                    <button type="button" wire:click="closeSendToNocModal" class="btn-boron border border-[#dee2e6] px-4 py-2 text-sm text-[#313a46] hover:bg-zinc-100 dark:border-[#37394d] dark:text-white dark:hover:bg-white/5">
                        Periksa Lagi
                    </button>
                    <button type="button" wire:click="sendToNoc" wire:loading.attr="disabled" wire:target="sendToNoc" class="btn-boron btn-boron-primary flex items-center justify-center gap-2 px-5 py-2 text-sm shadow-md shadow-[#669776]/30 disabled:cursor-not-allowed disabled:opacity-60">
                        <i class="ti ti-send"></i> Kirim ke NOC
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showApproveBaaModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
            <div class="w-full max-w-lg overflow-hidden rounded-xl border border-[#e7e9eb] bg-white shadow-2xl dark:border-[#37394d] dark:bg-[#1e1f27]">
                <div class="flex items-start justify-between gap-4 border-b border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5">
                    <div>
                        <h3 class="text-base font-bold text-[#313a46] dark:text-white">Setujui BAA</h3>
                        <p class="mt-1 text-sm text-[#8a969c]">Pastikan BAA yang ditandatangani pelanggan sudah valid.</p>
                    </div>
                    <button type="button" wire:click="closeApproveBaaModal" class="rounded-full p-2 text-[#8a969c] hover:bg-[#ed6060]/10 hover:text-[#ed6060]">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                <div class="px-5 py-5">
                    <div class="rounded-lg border border-[#70bb63]/30 bg-[#70bb63]/10 p-4 text-sm leading-relaxed text-[#4a8a3f] dark:text-[#70bb63]">
                        Status layanan akan berubah menjadi selesai dan pelanggan dinyatakan aktif sepenuhnya.
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-[#e7e9eb] bg-[#f8f9fa] px-5 py-4 dark:border-[#37394d] dark:bg-white/5 sm:flex-row sm:justify-end">
                    <button type="button" wire:click="closeApproveBaaModal" class="btn-boron border border-[#dee2e6] px-4 py-2 text-sm text-[#313a46] hover:bg-zinc-100 dark:border-[#37394d] dark:text-white dark:hover:bg-white/5">
                        Periksa Lagi
                    </button>
                    <button type="button" wire:click="approveBaa" wire:loading.attr="disabled" wire:target="approveBaa" class="btn-boron btn-boron-primary flex items-center justify-center gap-2 px-5 py-2 text-sm shadow-md shadow-[#669776]/30 disabled:cursor-not-allowed disabled:opacity-60">
                        <i class="ti ti-check"></i> Setujui
                    </button>
                </div>
            </div>
        </div>
    @endif
    
    @include('livewire.marketing.tracking.modalEdit')
</div>
