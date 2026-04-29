<div class="py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
         <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">
          {{ $showBerhentiOnly ? 'Arsip Data Pelanggan Berhenti' : 'Arsip Data Pelanggan Aktif' }}
                        </h4>
         <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">
                            {{ $showBerhentiOnly ? 'Basis data pelanggan yang layanannya telah dihentikan.' : 'Basis data pelanggan yang layanannya telah beroperasi (100% Selesai).' }}
                        </p>
         </div>
        <div class="flex gap-2">
            <button wire:click="$toggle('showBerhentiOnly')" class="btn-boron {{ $showBerhentiOnly ? 'bg-[#ed6060] text-white border-transparent' : '!bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]' }} !py-2 !px-4 text-sm font-semibold shadow-sm transition-colors">
                <i class="ti ti-hand-stop mr-1.5 text-lg"></i> {{ $showBerhentiOnly ? 'Kembali ke Aktif' : 'Lihat Pelanggan Berhenti' }}
            </button>
        </div>
    </div>

    <div class="boron-card">
        <div class="boron-card-body p-0">
            <div class="w-full">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5] block md:table">
                    
                    <thead class="hidden md:table-header-group bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">ID / PERUSAHAAN</th>
                            <th class="px-6 py-4 font-semibold">LAYANAN</th>
                            <th class="px-6 py-4 font-semibold">TGL AKTIF</th>
                            <th class="px-6 py-4 text-center font-semibold">AKSI CEPAT</th>
                        </tr>
                    </thead>
                    
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($customers as $cust)
                            <tr class="flex flex-col md:table-row border-b border-[#e7e9eb] md:border-none dark:border-[#37394d] p-5 md:p-0 gap-3 md:gap-0 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">ID / Perusahaan</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold text-[#ebb751] text-xs mb-0.5">{{ $cust->customer_number ?? '-' }}</p>
                                        <p class="font-bold md:font-medium text-[#313a46] dark:text-white">{{ $cust->company_name }}</p>
                                    </div>
                                </td>
                                
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Layanan</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold md:font-medium text-[#1e5d87] dark:text-[#60addf] md:text-[#313a46] md:dark:text-white">{{ $cust->service?->bandwidth ?? '-' }}</p>
                                        <p class="text-[11px] md:text-xs text-[#8a969c]">{{ $cust->service?->service_type ?? '-' }}</p>
                                    </div>
                                </td>
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 pb-1 md:pb-0 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Tgl Aktif</span>
                                    <span class="font-medium md:font-normal text-[#313a46] dark:text-white md:text-inherit">{{ $cust->baa && $cust->baa->activation_date ? $cust->baa->activation_date->format('d M Y') : '-' }}</span>
                                </td>
                                
                                <td class="md:px-6 md:py-4 md:text-center mt-3 md:mt-0 block md:table-cell">
                                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2 flex-wrap">
                                        <button wire:click="viewDetail({{ $cust->id }})" class="w-full sm:w-auto btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-1.5 !px-3 text-xs shadow-sm flex justify-center items-center gap-1.5 dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">
                                            <i class="ti ti-list-details text-base text-[#60addf]"></i> Detail
                                        </button>
                                        <button wire:click="editCustomer({{ $cust->id }})" class="w-full sm:w-auto btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-1.5 !px-3 text-xs shadow-sm flex justify-center items-center gap-1.5 dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">
                                            <i class="ti ti-edit text-base text-[#ebb751]"></i> Edit Data
                                        </button>
                                        <button wire:click="openArsip({{ $cust->id }})" class="w-full sm:w-auto btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-1.5 !px-3 text-xs shadow-sm flex justify-center items-center gap-1.5 dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">
                                            <i class="ti ti-folder text-base text-[#1e5d87]"></i> Arsip Dok.
                                        </button>
                                        @if($cust->status !== 'berhenti')
                                            <button wire:click="berhentikanPelanggan({{ $cust->id }})" wire:confirm="Anda yakin ingin memberhentikan layanan untuk pelanggan ini?" class="w-full sm:w-auto btn-boron !bg-[#ed6060]/10 !text-[#ed6060] hover:!bg-[#ed6060] hover:!text-white !py-1.5 !px-3 text-xs shadow-sm flex justify-center items-center gap-1.5 transition-colors">
                                                <i class="ti ti-hand-stop text-base"></i> Berhenti
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row">
                                <td colspan="4" class="block md:table-cell px-6 py-12 text-center text-[#8a969c]">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="ti ti-inbox text-4xl mb-2 opacity-50"></i>
                                        <p>Belum ada arsip pelanggan aktif.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($customers->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d] flex justify-center md:justify-start">
                    <div class="w-full overflow-x-auto md:overflow-visible">
                        {{ $customers->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($showModal && $selectedCustomer)
        <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/50 backdrop-blur-sm p-0 md:p-4" wire:transition.opacity>
            <div class="bg-[#f6f7fb] dark:bg-[#15151b] rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-7xl h-[90vh] md:h-auto md:max-h-[95vh] flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
                
                <div class="flex-none flex items-center justify-between border-b border-[#e7e9eb] bg-white px-6 py-5 dark:border-[#37394d] dark:bg-[#1e1e2a]">
                    <div class="flex items-center gap-4">
                        <div class="flex size-10 items-center justify-center rounded-full bg-[#60addf]/10 text-[#60addf]">
                            <i class="ti ti-list-details text-xl"></i>
                        </div>
                        <div>
                            <h5 class="text-lg font-extrabold text-[#313a46] dark:text-white line-clamp-1">Detail Data: {{ $selectedCustomer->company_name }}</h5>
                            <p class="text-xs font-medium text-[#8a969c] mt-0.5">ID Pelanggan: <span class="font-bold text-[#ebb751]">{{ $selectedCustomer->customer_number ?? 'N/A' }}</span></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('form.formulir', $selectedCustomer->id) }}" target="_blank" class="hidden sm:flex btn-boron !py-1.5 items-center gap-1.5 bg-[#1e5d87]/10 text-[#1e5d87] hover:bg-[#1e5d87]/20 border border-[#1e5d87]/20 transition-colors font-medium text-xs rounded-lg">
                            <i class="ti ti-file-text text-base"></i> Cetak Formulir
                        </a>
                        <button wire:click="closeModal" class="text-[#a1a9b1] hover:text-[#ed6060] transition-colors bg-[#f8f9fa] hover:bg-[#ed6060]/10 dark:bg-[#15151b] rounded-full p-2.5">
                            <i class="ti ti-x text-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-6 boron-scrollbar">
                    <div class="grid gap-6 lg:grid-cols-3">
                        
                        <div class="space-y-6">
                            <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                                <h6 class="font-bold text-[#669776] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                                    <i class="ti ti-user text-lg"></i> Data Pendaftar
                                </h6>
                                <div class="space-y-4">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Pendaftar</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->user->name }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Direktur (Login)</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#1e5d87] dark:border-[#37394d] dark:bg-[#15151b] dark:text-[#60addf]">{{ $selectedCustomer->user->email }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Pendaftar</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->phone ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. KTP</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->ktp_number ?? '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Gender</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->gender === 'L' ? 'Laki-laki' : ($selectedCustomer->gender === 'P' ? 'Perempuan' : '-') }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jabatan</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->position ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                                <h6 class="font-bold text-[#1e5d87] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                                    <i class="ti ti-wifi text-lg"></i> Informasi Layanan
                                </h6>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kapasitas</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#60addf]/30 bg-[#60addf]/5 px-3 py-2 text-sm font-bold text-[#1e5d87] dark:text-[#60addf]">{{ $selectedCustomer->service?->bandwidth ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kontrak</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->service?->term_of_service ?? '-' }} Tahun</div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Layanan</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->service?->service_type ?? '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Pelanggan</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->spk->customer_type ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tgl Aktivasi</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#70bb63] dark:border-[#37394d] dark:bg-[#15151b]">{{ $selectedCustomer->baa && $selectedCustomer->baa->activation_date ? $selectedCustomer->baa->activation_date->format('d M Y') : '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jalur Metro</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->service?->jalur_metro ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">SLA</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->service?->sla ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="border-t border-[#e7e9eb] pt-3 mt-1 dark:border-[#37394d]">
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Registrasi (Rp)</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ number_format($selectedCustomer->service?->registration_fee ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Bulanan (Rp)</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#ebb751]/30 bg-[#ebb751]/5 px-3 py-2 text-sm font-bold text-[#b58c3d] dark:text-[#ebb751]">{{ number_format($selectedCustomer->service?->monthly_fee ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                            <h6 class="font-bold text-[#60addf] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                                <i class="ti ti-building-skyscraper text-lg"></i> Instansi / Perusahaan
                            </h6>
                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Perusahaan</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-bold text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->company_name }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Bidang Usaha</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->business_type ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. NPWP</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->npwp_number ?? '-' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Telepon Kantor</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->company_phone ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Lengkap Perusahaan</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] min-h-[80px] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->company_address ?? '-' }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kota/Kabupaten</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->city ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Provinsi</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->province ?? '-' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kode Pos</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->postal_code ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">ID Pelanggan (Customer ID)</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#ebb751]/30 bg-[#ebb751]/5 px-3 py-2 text-sm font-bold text-[#b58c3d] dark:text-[#ebb751]">{{ $selectedCustomer->customer_number ?? 'Belum Terbit' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Invoice Registrasi</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->invoiceRegistrasi->invoice_number ?? 'Belum Terbit' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Surat Perintah Kerja (SPK)</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->spk->spk_number ?? 'Belum Terbit' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Berita Acara Aktivasi (BAA)</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->baa->baa_number ?? 'Belum Terbit' }}</div>
                                </div>
                                <div class="pt-4 mt-2 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                                    <label class="mb-2 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Lampiran Perusahaan</label>
                                    <div class="flex flex-wrap gap-2">
                                        {{-- KTP --}}
                                        @if($selectedCustomer->ktp_file_path)
                                            <a href="{{ asset('storage/' . $selectedCustomer->ktp_file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 border border-[#60addf]/30 px-2 py-1 text-[10px] font-bold text-[#1e5d87] hover:bg-[#60addf]/20 transition-colors dark:text-[#60addf]">
                                                <i class="ti ti-id text-xs"></i> KTP
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded bg-[#f8f9fa] border border-[#e7e9eb] px-2 py-1 text-[10px] font-bold text-[#a1a9b1] cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]" title="Belum Diunggah">
                                                <i class="ti ti-id text-xs"></i> KTP
                                            </span>
                                        @endif
    
                                        {{-- NPWP --}}
                                        @if($selectedCustomer->npwp_file_path)
                                            <a href="{{ asset('storage/' . $selectedCustomer->npwp_file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 border border-[#60addf]/30 px-2 py-1 text-[10px] font-bold text-[#1e5d87] hover:bg-[#60addf]/20 transition-colors dark:text-[#60addf]">
                                                <i class="ti ti-file-barcode text-xs"></i> NPWP
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded bg-[#f8f9fa] border border-[#e7e9eb] px-2 py-1 text-[10px] font-bold text-[#a1a9b1] cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]" title="Belum Diunggah">
                                                <i class="ti ti-file-barcode text-xs"></i> NPWP
                                            </span>
                                        @endif
    
                                        {{-- NIB --}}
                                        @if($selectedCustomer->nib_file_path)
                                            <a href="{{ asset('storage/' . $selectedCustomer->nib_file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 border border-[#60addf]/30 px-2 py-1 text-[10px] font-bold text-[#1e5d87] hover:bg-[#60addf]/20 transition-colors dark:text-[#60addf]">
                                                <i class="ti ti-file-info text-xs"></i> NIB
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded bg-[#f8f9fa] border border-[#e7e9eb] px-2 py-1 text-[10px] font-bold text-[#a1a9b1] cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]" title="Belum Diunggah">
                                                <i class="ti ti-file-info text-xs"></i> NIB
                                            </span>
                                        @endif
    
                                        {{-- Sertifikat --}}
                                        @if($selectedCustomer->certificate_file_path)
                                            <a href="{{ asset('storage/' . $selectedCustomer->certificate_file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 border border-[#60addf]/30 px-2 py-1 text-[10px] font-bold text-[#1e5d87] hover:bg-[#60addf]/20 transition-colors dark:text-[#60addf]">
                                                <i class="ti ti-certificate text-xs"></i> Sertifikat
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded bg-[#f8f9fa] border border-[#e7e9eb] px-2 py-1 text-[10px] font-bold text-[#a1a9b1] cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]" title="Belum Diunggah">
                                                <i class="ti ti-certificate text-xs"></i> Sertifikat
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                            <h6 class="font-bold text-[#ebb751] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                                <i class="ti ti-headset text-lg"></i> Kontak PIC
                            </h6>
                            
                            <div class="space-y-5">
                                <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                    <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-file-invoice text-[#ebb751]"></i> PIC Finance (Penagihan)</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama PIC Finance</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->finance_name ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Finance</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white break-words">{{ $selectedCustomer->finance_email ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->finance_phone ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Penagihan (Billing)</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] min-h-[50px] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->billing_address ?? 'Sama dengan perusahaan' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                    <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-router text-[#ebb751]"></i> PIC Teknis (Instalasi)</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama PIC Teknis</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->technical_name ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Teknis</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white break-words">{{ $selectedCustomer->technical_email ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->technical_phone ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Instalasi Router</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] min-h-[50px] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->installation_address ?? 'Sama dengan perusahaan' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                    <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-briefcase text-[#ebb751]"></i> Data Sales / Marketing</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Sales / Marketing</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->service?->marketing_name ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Marketing</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->service?->marketing_phone ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex-none px-6 py-4 border-t border-[#e7e9eb] dark:border-[#37394d] bg-white dark:bg-[#1e1e2a] text-right">
                    <button wire:click="closeModal" class="btn-boron btn-boron-outline-secondary !py-2 text-sm px-6 font-semibold rounded-lg">Tutup Detail</button>
                </div>
            </div>
        </div>
    @endif

    @if($showArsipModal && $customerForArsip)
        <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm p-0 md:p-4" wire:transition.opacity>
            <div class="bg-white dark:bg-[#1e1f27] rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-3xl flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
                
                <div class="px-6 py-5 border-b border-[#e7e9eb] dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-full bg-[#1e5d87]/10 text-[#1e5d87]">
                            <i class="ti ti-folder-open text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-[#313a46] dark:text-white">Arsip Dokumen Pelanggan</h3>
                            <p class="text-xs text-[#8a969c] mt-0.5">{{ $customerForArsip->company_name }}</p>
                        </div>
                    </div>
                    <button wire:click="closeArsip" class="text-[#8a969c] bg-gray-200/50 hover:bg-[#ed6060]/10 p-2 rounded-full hover:text-[#ed6060] transition-colors"><i class="ti ti-x text-xl"></i></button>
                </div>

                <div class="p-6 bg-[#fcfcfd] dark:bg-[#1e1f27]">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        
                        <a href="{{ route('form.formulir', $customerForArsip->id) }}" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#1e5d87] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] dark:hover:border-[#60addf]">
                            <i class="ti ti-file-text text-4xl text-[#a1a9b1] group-hover:text-[#1e5d87] mb-3 transition-colors dark:group-hover:text-[#60addf]"></i>
                            <h6 class="font-bold text-sm text-[#313a46] dark:text-white text-center">Formulir Registrasi</h6>
                            <span class="text-[10px] text-[#8a969c] mt-1 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">PDF Generate</span>
                        </a>

                        <a href="{{ route('customer.invoice', $customerForArsip->id) }}" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#ebb751] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d]">
                            <i class="ti ti-file-invoice text-4xl text-[#a1a9b1] group-hover:text-[#ebb751] mb-3 transition-colors"></i>
                            <h6 class="font-bold text-sm text-[#313a46] dark:text-white text-center">Invoice Registrasi</h6>
                            <span class="text-[10px] text-[#8a969c] mt-1 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">PDF Generate</span>
                        </a>

                        @if($customerForArsip->spk)
                            <a href="{{ route('marketing.spk', $customerForArsip->id) }}" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#60addf] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-description text-4xl text-[#a1a9b1] group-hover:text-[#60addf] mb-3 transition-colors"></i>
                                <h6 class="font-bold text-sm text-[#313a46] dark:text-white text-center">SPK (Perintah Kerja)</h6>
                                <span class="text-[10px] text-[#8a969c] mt-1 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">PDF Generate</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center justify-center p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-description text-4xl text-[#dee2e6] mb-3 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-sm text-[#8a969c] text-center">SPK Belum Terbit</h6>
                            </div>
                        @endif

                        @if($customerForArsip->baa)
                            <a href="{{ route('noc.baa', $customerForArsip->id) }}" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#669776] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] dark:hover:border-[#70bb63]">
                                <i class="ti ti-certificate text-4xl text-[#a1a9b1] group-hover:text-[#669776] mb-3 transition-colors dark:group-hover:text-[#70bb63]"></i>
                                <h6 class="font-bold text-sm text-[#313a46] dark:text-white text-center">BAA (Original)</h6>
                                <span class="text-[10px] text-[#8a969c] mt-1 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">Format Kosong</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center justify-center p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-certificate text-4xl text-[#dee2e6] mb-3 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-sm text-[#8a969c] text-center">BAA Belum Terbit</h6>
                            </div>
                        @endif

                        @if($customerForArsip->baa && $customerForArsip->baa->signed_baa_path)
                            <a href="{{ asset('storage/' . $customerForArsip->baa->signed_baa_path) }}" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#70bb63] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] shadow-[0_0_0_2px_rgba(112,187,99,0.2)]">
                                <div class="relative mb-3">
                                    <i class="ti ti-file-check text-4xl text-[#70bb63]"></i>
                                    <i class="ti ti-circle-check-filled text-[#70bb63] bg-white rounded-full absolute -bottom-1 -right-2 text-sm border-2 border-white"></i>
                                </div>
                                <h6 class="font-bold text-sm text-[#313a46] dark:text-white text-center">BAA (Signed)</h6>
                                <span class="text-[10px] text-[#70bb63] font-bold mt-1 bg-[#70bb63]/10 px-2 py-0.5 rounded">Telah Di-TTD Pelanggan</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center justify-center p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-x text-4xl text-[#dee2e6] mb-3 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-sm text-[#8a969c] text-center">BAA (Signed) Belum Ada</h6>
                            </div>
                        @endif

                        @if($customerForArsip->invoiceRegistrasi?->payment_proof_file_path)
                            <a href="{{ asset('storage/' . $customerForArsip->invoiceRegistrasi->payment_proof_file_path) }}" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#60addf] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-receipt-2 text-4xl text-[#60addf] mb-3"></i>
                                <h6 class="font-bold text-sm text-[#313a46] dark:text-white text-center">Bukti Transfer</h6>
                                <span class="text-[10px] text-[#60addf] font-bold mt-1 bg-[#60addf]/10 px-2 py-0.5 rounded">Lunas / Terverifikasi</span>
                            </a>
                        @elseif($customerForArsip->service?->registration_fee == 0)
                            <div class="flex flex-col items-center justify-center p-5 rounded-xl border border-dashed border-[#70bb63] bg-[#70bb63]/5 dark:bg-[#70bb63]/10 dark:border-[#70bb63]/30">
                                <i class="ti ti-gift text-4xl text-[#70bb63] mb-3"></i>
                                <h6 class="font-bold text-sm text-[#70bb63] text-center">Bukti Transfer</h6>
                                <span class="text-[10px] text-[#70bb63] font-bold mt-1 px-2 py-0.5 rounded border border-[#70bb63]">PROMO FREE</span>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-receipt-off text-4xl text-[#dee2e6] mb-3 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-sm text-[#8a969c] text-center">Tidak Ada Bukti Bayar</h6>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('livewire.marketing.tracking.modalEdit')
</div>