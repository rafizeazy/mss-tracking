<div class="py-4 md:py-6">
    <div class="mb-4 md:mb-6 flex flex-col md:flex-row md:items-center justify-between gap-2 md:gap-3">
        <div>
            <h4 class="text-lg md:text-xl font-bold md:font-semibold text-[#313a46] dark:text-white">Arsip Data Pelanggan Aktif</h4>
            <p class="mt-0.5 text-xs md:text-sm text-[#8a969c]">Basis data pelanggan yang layanannya telah beroperasi (100% Selesai).</p>
        </div>
    </div>

    <div class="boron-card shadow-sm border border-[#e7e9eb] dark:border-[#37394d]">
        <div class="boron-card-body p-0">
            <div class="w-full">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5] block md:table">
                    
                    <thead class="hidden md:table-header-group bg-[#f8f9fa] text-xs uppercase text-[#313a46] border-b border-[#e7e9eb] dark:bg-[#1e1f27] dark:text-white dark:border-[#37394d]">
                        <tr>
                            <th class="px-6 py-4 font-bold tracking-wider">ID / PERUSAHAAN</th>
                            <th class="px-6 py-4 font-bold tracking-wider">LAYANAN</th>
                            <th class="px-6 py-4 font-bold tracking-wider">TGL AKTIF</th>
                            <th class="px-6 py-4 text-center font-bold tracking-wider">AKSI CEPAT</th>
                        </tr>
                    </thead>
                    
                    <tbody class="block md:table-row-group divide-y divide-[#e7e9eb] md:divide-y-0 dark:divide-[#37394d]">
                        @forelse ($customers as $cust)
                            <tr class="flex flex-col md:table-row border-b md:border-b border-[#e7e9eb] dark:border-[#37394d] p-4 md:p-0 gap-3 md:gap-0 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors last:border-b-0">
                                
                                <td class="flex justify-between md:justify-start items-start md:items-center md:table-cell md:px-6 md:py-4">
                                    <span class="text-[10px] font-bold text-[#8a969c] md:hidden uppercase tracking-widest mt-0.5">Perusahaan</span>
                                    <div class="text-right md:text-left max-w-[65%] md:max-w-none">
                                        <p class="font-bold text-[#ebb751] text-[11px] md:text-xs mb-0.5">{{ $cust->customer_number ?? '-' }}</p>
                                        <p class="font-bold md:font-semibold text-[#313a46] dark:text-white text-sm md:text-sm leading-tight">{{ $cust->company_name }}</p>
                                    </div>
                                </td>
                                
                                <td class="flex justify-between md:justify-start items-start md:items-center md:table-cell md:px-6 md:py-4">
                                    <span class="text-[10px] font-bold text-[#8a969c] md:hidden uppercase tracking-widest mt-0.5">Layanan</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold md:font-semibold text-[#1e5d87] dark:text-[#60addf] md:text-[#313a46] md:dark:text-white text-sm">{{ $cust->bandwidth }}</p>
                                        <p class="text-[11px] md:text-xs text-[#8a969c]">{{ $cust->service_type }}</p>
                                    </div>
                                </td>
                                
                                <td class="flex justify-between md:justify-start items-center md:table-cell md:px-6 md:py-4">
                                    <span class="text-[10px] font-bold text-[#8a969c] md:hidden uppercase tracking-widest">Tgl Aktif</span>
                                    <span class="font-medium md:font-normal text-[#70bb63] md:text-[#313a46] dark:text-white text-xs md:text-sm bg-[#70bb63]/10 md:bg-transparent px-2 py-0.5 md:px-0 md:py-0 rounded">{{ $cust->baa && $cust->baa->activation_date ? $cust->baa->activation_date->format('d M Y') : '-' }}</span>
                                </td>
                                
                                <td class="md:px-6 md:py-4 md:text-center mt-3 md:mt-0 pt-3 md:pt-0 border-t border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] block md:table-cell">
                                    <div class="flex flex-row md:flex-row items-center justify-center gap-2">
                                        <button wire:click="viewDetail({{ $cust->id }})" class="flex-1 md:flex-none btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-2.5 md:!py-1.5 !px-3 text-[11px] md:text-xs shadow-sm flex justify-center items-center gap-1.5 dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">
                                            <i class="ti ti-list-details text-base text-[#60addf]"></i> <span class="hidden sm:inline">Detail</span>
                                        </button>
                                        <button wire:click="editCustomer({{ $cust->id }})" class="flex-1 md:flex-none btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-2.5 md:!py-1.5 !px-3 text-[11px] md:text-xs shadow-sm flex justify-center items-center gap-1.5 dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">
                                            <i class="ti ti-edit text-base text-[#ebb751]"></i> <span class="hidden sm:inline">Edit</span>
                                        </button>
                                        <button wire:click="openArsip({{ $cust->id }})" class="flex-1 md:flex-none btn-boron btn-boron-primary !py-2.5 md:!py-1.5 !px-3 md:!px-4 text-[11px] md:text-xs shadow-sm flex justify-center items-center gap-1.5">
                                            <i class="ti ti-folder text-base"></i> Dokumen
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row">
                                <td colspan="4" class="block md:table-cell px-6 py-12 text-center text-[#8a969c]">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="ti ti-inbox text-5xl mb-3 opacity-30"></i>
                                        <p class="text-sm">Belum ada arsip pelanggan aktif.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($customers->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d] flex justify-center md:justify-end bg-[#f8f9fa] dark:bg-white/5 rounded-b-lg">
                    <div class="w-full overflow-x-auto md:overflow-visible">
                        {{ $customers->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($showModal && $selectedCustomer)
        <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-[#313a46]/70 backdrop-blur-sm p-0 md:p-4 transition-all duration-300" wire:transition.opacity>
            <div class="bg-[#f6f7fb] dark:bg-[#15151b] rounded-t-[1.5rem] md:rounded-2xl shadow-2xl w-full max-w-7xl h-[85vh] md:h-auto md:max-h-[90vh] flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d] transform transition-transform" @click.stop>
                
                <div class="w-full flex justify-center pt-3 pb-1 md:hidden bg-white dark:bg-[#1e1e2a]">
                    <div class="w-12 h-1.5 bg-[#e7e9eb] rounded-full dark:bg-[#37394d]"></div>
                </div>

                <div class="flex-none flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-[#e7e9eb] bg-white px-5 md:px-6 py-4 md:py-5 dark:border-[#37394d] dark:bg-[#1e1e2a] gap-3 sm:gap-0">
                    <div class="flex items-center gap-3 md:gap-4 w-full sm:w-auto justify-between sm:justify-start">
                        <div class="flex items-center gap-3">
                            <div class="flex size-10 md:size-12 items-center justify-center rounded-full bg-[#60addf]/10 text-[#60addf] shrink-0">
                                <i class="ti ti-list-details text-xl md:text-2xl"></i>
                            </div>
                            <div>
                                <h5 class="text-base md:text-lg font-bold text-[#313a46] dark:text-white line-clamp-1 leading-tight">Data: {{ $selectedCustomer->company_name }}</h5>
                                <p class="text-[11px] md:text-xs font-medium text-[#8a969c] mt-0.5">ID: <span class="font-bold text-[#ebb751]">{{ $selectedCustomer->customer_number ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                        <button wire:click="closeModal" class="sm:hidden text-[#8a969c] bg-[#f8f9fa] hover:bg-[#ed6060]/10 p-2 rounded-full hover:text-[#ed6060] transition-colors dark:bg-[#15151b]"><i class="ti ti-x text-lg"></i></button>
                    </div>
                    
                    <div class="w-full sm:w-auto flex items-center justify-end gap-2">
                        <a href="{{ route('form.formulir', $selectedCustomer->id) }}" target="_blank" class="w-full sm:w-auto flex justify-center btn-boron !py-2.5 sm:!py-2 items-center gap-1.5 bg-[#1e5d87]/10 text-[#1e5d87] hover:bg-[#1e5d87]/20 border border-[#1e5d87]/20 transition-colors font-semibold text-[13px] sm:text-xs rounded-lg">
                            <i class="ti ti-file-text text-lg sm:text-base"></i> <span class="sm:hidden">Cetak</span> Formulir
                        </a>
                        <button wire:click="closeModal" class="hidden sm:block text-[#a1a9b1] hover:text-[#ed6060] transition-colors bg-[#f8f9fa] hover:bg-[#ed6060]/10 dark:bg-[#15151b] rounded-full p-2.5">
                            <i class="ti ti-x text-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-4 md:p-6 boron-scrollbar">
                    <div class="grid gap-5 md:gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                        
                        <div class="space-y-5 md:space-y-6">
                            <div class="rounded-xl border border-[#e7e9eb] bg-white p-4 md:p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                                <h6 class="font-bold text-[#669776] mb-3 md:mb-4 flex items-center gap-2 text-xs md:text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-2 md:pb-3 dark:border-[#37394d]">
                                    <i class="ti ti-user text-base md:text-lg"></i> Pendaftar
                                </h6>
                                <div class="space-y-3.5">
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Lengkap</label>
                                        <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->user->name }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone</label>
                                            <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] break-all dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->phone ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. KTP</label>
                                            <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] break-all dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->ktp_number ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Gender</label>
                                            <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->gender === 'L' ? 'Laki-laki' : ($selectedCustomer->gender === 'P' ? 'Perempuan' : '-') }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jabatan</label>
                                            <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] line-clamp-1 dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->position ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-xl border border-[#e7e9eb] bg-white p-4 md:p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                                <h6 class="font-bold text-[#1e5d87] mb-3 md:mb-4 flex items-center gap-2 text-xs md:text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-2 md:pb-3 dark:border-[#37394d]">
                                    <i class="ti ti-wifi text-base md:text-lg"></i> Layanan
                                </h6>
                                <div class="space-y-3.5">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kapasitas</label>
                                            <div class="w-full rounded border border-[#60addf]/40 bg-[#60addf]/10 px-3 py-2 text-[13px] md:text-sm font-bold text-[#1e5d87] dark:text-[#60addf] shadow-inner">{{ $selectedCustomer->bandwidth }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kontrak</label>
                                            <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->term_of_service }} Tahun</div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Layanan</label>
                                        <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->service_type }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Pelanggan</label>
                                            <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->spk->customer_type ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tgl Aktif</label>
                                            <div class="w-full rounded border border-[#70bb63]/30 bg-[#70bb63]/10 px-3 py-2 text-[13px] font-bold text-[#4a8a3f] dark:text-[#70bb63]">{{ $selectedCustomer->baa && $selectedCustomer->baa->activation_date ? $selectedCustomer->baa->activation_date->format('d M Y') : '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jalur Metro</label>
                                            <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] line-clamp-1 dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->jalur_metro ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">SLA</label>
                                            <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->sla ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="border-t border-[#e7e9eb] pt-3 mt-1 dark:border-[#37394d]">
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Registrasi (Rp)</label>
                                        <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ number_format($selectedCustomer->registration_fee ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Bulanan (Rp)</label>
                                        <div class="w-full rounded border border-[#ebb751]/40 bg-[#ebb751]/10 px-3 py-2 text-base font-black text-[#b58c3d] tracking-wide dark:text-[#ebb751] shadow-inner">{{ number_format($selectedCustomer->monthly_fee ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[#e7e9eb] bg-white p-4 md:p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a] h-fit">
                            <h6 class="font-bold text-[#60addf] mb-3 md:mb-4 flex items-center gap-2 text-xs md:text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-2 md:pb-3 dark:border-[#37394d]">
                                <i class="ti ti-building-skyscraper text-base md:text-lg"></i> Perusahaan
                            </h6>
                            <div class="space-y-3.5">
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Instansi/PT</label>
                                    <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-bold text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->company_name }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Bidang Usaha</label>
                                        <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] line-clamp-1 dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->business_type ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. NPWP</label>
                                        <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] break-all dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->npwp_number ?? '-' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Telepon Kantor</label>
                                    <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->company_phone ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Lengkap</label>
                                    <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] min-h-[70px] leading-relaxed dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->company_address ?? '-' }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kota/Kab</label>
                                        <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->city ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Provinsi</label>
                                        <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] line-clamp-1 dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->province ?? '-' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kode Pos</label>
                                    <div class="w-full rounded border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-[13px] font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->postal_code ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[#e7e9eb] bg-white p-4 md:p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a] h-fit">
                            <h6 class="font-bold text-[#ebb751] mb-3 md:mb-4 flex items-center gap-2 text-xs md:text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-2 md:pb-3 dark:border-[#37394d]">
                                <i class="ti ti-headset text-base md:text-lg"></i> Kontak Ops & Finance
                            </h6>
                            
                            <div class="space-y-4">
                                <div class="rounded border border-[#e7e9eb] p-3 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                    <p class="text-[11px] md:text-xs font-bold text-[#313a46] dark:text-white border-b border-dashed border-[#e7e9eb] pb-2 mb-2.5 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-file-invoice text-[#ebb751] text-sm"></i> PIC Penagihan</p>
                                    <div class="space-y-2">
                                        <div class="flex items-start gap-2">
                                            <i class="ti ti-user text-[#8a969c] mt-0.5"></i>
                                            <div>
                                                <p class="text-[10px] font-bold text-[#8a969c] uppercase">Nama</p>
                                                <p class="text-[13px] font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->finance_name ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <i class="ti ti-phone text-[#8a969c] mt-0.5"></i>
                                            <div>
                                                <p class="text-[10px] font-bold text-[#8a969c] uppercase">Kontak</p>
                                                <p class="text-[13px] font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->finance_phone ?? '-' }}</p>
                                                <p class="text-[12px] text-[#8a969c] break-all">{{ $selectedCustomer->finance_email ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <i class="ti ti-map-pin text-[#8a969c] mt-0.5"></i>
                                            <div>
                                                <p class="text-[10px] font-bold text-[#8a969c] uppercase">Alamat Invoice</p>
                                                <p class="text-[12px] text-[#313a46] leading-snug dark:text-[#aab8c5]">{{ $selectedCustomer->billing_address ?? 'Sama dengan perusahaan' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded border border-[#e7e9eb] p-3 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                    <p class="text-[11px] md:text-xs font-bold text-[#313a46] dark:text-white border-b border-dashed border-[#e7e9eb] pb-2 mb-2.5 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-router text-[#ebb751] text-sm"></i> PIC Teknis (NOC)</p>
                                    <div class="space-y-2">
                                        <div class="flex items-start gap-2">
                                            <i class="ti ti-user text-[#8a969c] mt-0.5"></i>
                                            <div>
                                                <p class="text-[13px] font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->technical_name ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <i class="ti ti-phone text-[#8a969c] mt-0.5"></i>
                                            <div>
                                                <p class="text-[13px] font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->technical_phone ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <i class="ti ti-map-pin text-[#8a969c] mt-0.5"></i>
                                            <div>
                                                <p class="text-[12px] text-[#313a46] leading-snug dark:text-[#aab8c5]">{{ $selectedCustomer->installation_address ?? 'Sama dengan perusahaan' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded border border-[#e7e9eb] p-3 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d] flex items-center justify-between">
                                    <div>
                                        <p class="text-[10px] font-bold text-[#8a969c] uppercase mb-0.5"><i class="ti ti-briefcase mr-1"></i> Sales / AM</p>
                                        <p class="text-[13px] font-bold text-[#313a46] dark:text-white">{{ $selectedCustomer->marketing_name ?? '-' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[12px] font-medium text-[#1e5d87] dark:text-[#60addf] bg-[#1e5d87]/10 px-2 py-1 rounded">{{ $selectedCustomer->marketing_phone ?? '-' }}</p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex-none px-5 md:px-6 py-4 md:py-5 border-t border-[#e7e9eb] dark:border-[#37394d] bg-white dark:bg-[#1e1e2a]">
                    <button wire:click="closeModal" class="w-full md:w-auto md:float-right btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-3 md:!py-2 text-[13px] md:text-sm px-6 font-bold tracking-wide rounded-xl md:rounded-lg shadow-sm dark:!bg-[#15151b] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">Tutup Detail Data</button>
                    <div class="clear-both"></div>
                </div>
            </div>
        </div>
    @endif

    @if($showArsipModal && $customerForArsip)
        <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm p-0 md:p-4 transition-all duration-300" wire:transition.opacity>
            <div class="bg-white dark:bg-[#1e1f27] rounded-t-[1.5rem] md:rounded-2xl shadow-2xl w-full max-w-4xl flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d] transform transition-transform" @click.stop>
                
                <div class="w-full flex justify-center pt-3 pb-1 md:hidden bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div class="w-12 h-1.5 bg-[#e7e9eb] rounded-full dark:bg-[#37394d]"></div>
                </div>

                <div class="px-5 md:px-6 py-4 md:py-5 border-b border-[#e7e9eb] dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 md:size-12 items-center justify-center rounded-full bg-[#ebb751]/10 text-[#ebb751] shrink-0">
                            <i class="ti ti-folder-open text-xl md:text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base md:text-lg text-[#313a46] dark:text-white leading-tight">Arsip Dokumen</h3>
                            <p class="text-[11px] md:text-xs text-[#8a969c] mt-0.5 line-clamp-1">{{ $customerForArsip->company_name }}</p>
                        </div>
                    </div>
                    <button wire:click="closeArsip" class="text-[#8a969c] bg-white border border-[#e7e9eb] md:border-transparent md:bg-transparent hover:bg-[#ed6060]/10 p-2 md:p-1.5 rounded-full hover:text-[#ed6060] transition-colors dark:bg-[#1e1e2a] dark:border-[#37394d]"><i class="ti ti-x text-lg md:text-xl"></i></button>
                </div>

                <div class="p-5 md:p-6 bg-[#fcfcfd] dark:bg-[#1e1f27] overflow-y-auto max-h-[70vh] md:max-h-none boron-scrollbar">
                    <div class="grid grid-cols-1 min-[480px]:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                        
                        <a href="{{ route('form.formulir', $customerForArsip->id) }}" target="_blank" class="flex flex-row min-[480px]:flex-col items-center min-[480px]:justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#1e5d87] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] dark:hover:border-[#60addf] gap-4 min-[480px]:gap-0">
                            <div class="flex-none min-[480px]:w-full min-[480px]:text-center">
                                <i class="ti ti-file-text text-3xl md:text-4xl text-[#a1a9b1] group-hover:text-[#1e5d87] min-[480px]:mb-3 transition-colors dark:group-hover:text-[#60addf]"></i>
                            </div>
                            <div class="flex-1 min-[480px]:text-center">
                                <h6 class="font-bold text-[13px] md:text-sm text-[#313a46] dark:text-white">Formulir Registrasi</h6>
                                <span class="inline-block text-[10px] text-[#8a969c] mt-1 md:mt-1.5 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">PDF Generate</span>
                            </div>
                        </a>

                        <a href="{{ route('customer.invoice', $customerForArsip->id) }}" target="_blank" class="flex flex-row min-[480px]:flex-col items-center min-[480px]:justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#ebb751] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] gap-4 min-[480px]:gap-0">
                            <div class="flex-none min-[480px]:w-full min-[480px]:text-center">
                                <i class="ti ti-file-invoice text-3xl md:text-4xl text-[#a1a9b1] group-hover:text-[#ebb751] min-[480px]:mb-3 transition-colors"></i>
                            </div>
                            <div class="flex-1 min-[480px]:text-center">
                                <h6 class="font-bold text-[13px] md:text-sm text-[#313a46] dark:text-white">Invoice Registrasi</h6>
                                <span class="inline-block text-[10px] text-[#8a969c] mt-1 md:mt-1.5 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">PDF Generate</span>
                            </div>
                        </a>

                        @if($customerForArsip->payment_proof_file_path)
                            <a href="{{ asset('storage/' . $customerForArsip->payment_proof_file_path) }}" target="_blank" class="flex flex-row min-[480px]:flex-col items-center min-[480px]:justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#60addf] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] gap-4 min-[480px]:gap-0">
                                <div class="flex-none min-[480px]:w-full min-[480px]:text-center">
                                    <i class="ti ti-receipt-2 text-3xl md:text-4xl text-[#60addf] min-[480px]:mb-3"></i>
                                </div>
                                <div class="flex-1 min-[480px]:text-center">
                                    <h6 class="font-bold text-[13px] md:text-sm text-[#313a46] dark:text-white">Bukti Transfer</h6>
                                    <span class="inline-block text-[10px] text-[#60addf] font-bold mt-1 md:mt-1.5 bg-[#60addf]/10 px-2 py-0.5 rounded">Terverifikasi</span>
                                </div>
                            </a>
                        @elseif($customerForArsip->registration_fee == 0)
                            <div class="flex flex-row min-[480px]:flex-col items-center min-[480px]:justify-center p-4 md:p-5 rounded-xl border border-dashed border-[#70bb63] bg-[#70bb63]/5 dark:bg-[#70bb63]/10 dark:border-[#70bb63]/30 gap-4 min-[480px]:gap-0">
                                <div class="flex-none min-[480px]:w-full min-[480px]:text-center">
                                    <i class="ti ti-gift text-3xl md:text-4xl text-[#70bb63] min-[480px]:mb-3"></i>
                                </div>
                                <div class="flex-1 min-[480px]:text-center">
                                    <h6 class="font-bold text-[13px] md:text-sm text-[#70bb63]">Bukti Transfer</h6>
                                    <span class="inline-block text-[10px] text-[#70bb63] font-bold mt-1 md:mt-1.5 px-2 py-0.5 rounded border border-[#70bb63]">PROMO FREE</span>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-row min-[480px]:flex-col items-center min-[480px]:justify-center p-4 md:p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d] gap-4 min-[480px]:gap-0">
                                <div class="flex-none min-[480px]:w-full min-[480px]:text-center">
                                    <i class="ti ti-receipt-off text-3xl md:text-4xl text-[#dee2e6] min-[480px]:mb-3 dark:text-[#37394d]"></i>
                                </div>
                                <div class="flex-1 min-[480px]:text-center">
                                    <h6 class="font-bold text-[13px] md:text-sm text-[#8a969c]">Belum Ada Bukti</h6>
                                </div>
                            </div>
                        @endif

                        @if($customerForArsip->baa && $customerForArsip->baa->signed_baa_path)
                            <a href="{{ asset('storage/' . $customerForArsip->baa->signed_baa_path) }}" target="_blank" class="flex flex-row min-[480px]:flex-col items-center min-[480px]:justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#70bb63] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] shadow-[0_0_0_2px_rgba(112,187,99,0.2)] gap-4 min-[480px]:gap-0">
                                <div class="flex-none min-[480px]:w-full min-[480px]:flex min-[480px]:justify-center">
                                    <div class="relative min-[480px]:mb-3 w-fit">
                                        <i class="ti ti-file-check text-3xl md:text-4xl text-[#70bb63]"></i>
                                        <i class="ti ti-circle-check-filled text-[#70bb63] bg-white rounded-full absolute -bottom-1 -right-1 md:-right-2 text-xs md:text-sm border-2 border-white"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-[480px]:text-center">
                                    <h6 class="font-bold text-[13px] md:text-sm text-[#313a46] dark:text-white">BAA (Signed)</h6>
                                    <span class="inline-block text-[10px] text-[#70bb63] font-bold mt-1 md:mt-1.5 bg-[#70bb63]/10 px-2 py-0.5 rounded">Telah Di-TTD</span>
                                </div>
                            </a>
                        @else
                            <div class="flex flex-row min-[480px]:flex-col items-center min-[480px]:justify-center p-4 md:p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d] gap-4 min-[480px]:gap-0">
                                <div class="flex-none min-[480px]:w-full min-[480px]:text-center">
                                    <i class="ti ti-file-x text-3xl md:text-4xl text-[#dee2e6] min-[480px]:mb-3 dark:text-[#37394d]"></i>
                                </div>
                                <div class="flex-1 min-[480px]:text-center">
                                    <h6 class="font-bold text-[13px] md:text-sm text-[#8a969c]">BAA Belum Ada</h6>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('livewire.marketing.tracking.modalEdit')
</div>