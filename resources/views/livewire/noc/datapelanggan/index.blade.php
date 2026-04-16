<div class="py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div>
            <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">Arsip Data Pelanggan Aktif</h4>
            <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">Basis data pelanggan yang layanannya telah beroperasi (100% Selesai).</p>
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
                                        <p class="font-bold md:font-medium text-[#1e5d87] dark:text-[#60addf] md:text-[#313a46] md:dark:text-white">{{ $cust->bandwidth }}</p>
                                        <p class="text-[11px] md:text-xs text-[#8a969c]">{{ $cust->service_type }}</p>
                                    </div>
                                </td>
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 pb-1 md:pb-0 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Tgl Aktif</span>
                                    <span class="font-medium md:font-normal text-[#313a46] dark:text-white md:text-inherit">{{ $cust->baa && $cust->baa->activation_date ? $cust->baa->activation_date->format('d M Y') : '-' }}</span>
                                </td>
                                
                                <td class="md:px-6 md:py-4 md:text-center mt-3 md:mt-0 block md:table-cell">
                                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                        <button wire:click="viewDetail({{ $cust->id }})" class="w-full sm:w-auto btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-1.5 !px-4 text-xs shadow-sm flex justify-center items-center gap-1.5 dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">
                                            <i class="ti ti-list-details text-base text-[#60addf]"></i> Detail Data
                                        </button>
                                        <button wire:click="openArsip({{ $cust->id }})" class="w-full sm:w-auto btn-boron btn-boron-primary !py-1.5 !px-4 text-xs shadow-sm flex justify-center items-center gap-1.5">
                                            <i class="ti ti-folder text-base"></i> Dok. Teknis
                                        </button>
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
                            <h5 class="text-lg font-extrabold text-[#313a46] dark:text-white line-clamp-1">Detail Teknis: {{ $selectedCustomer->company_name }}</h5>
                            <p class="text-xs font-medium text-[#8a969c] mt-0.5">ID Pelanggan: <span class="font-bold text-[#ebb751]">{{ $selectedCustomer->customer_number ?? 'N/A' }}</span></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
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
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Pendaftar</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->phone ?? '-' }}</div>
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
                                    <i class="ti ti-wifi text-lg"></i> Layanan & Detail Teknis
                                </h6>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kapasitas</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#60addf]/30 bg-[#60addf]/5 px-3 py-2 text-sm font-bold text-[#1e5d87] dark:text-[#60addf]">{{ $selectedCustomer->bandwidth }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kontrak</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->term_of_service }} Tahun</div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Layanan</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->service_type }}</div>
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
                                    <div class="grid grid-cols-2 gap-4 border-t border-[#e7e9eb] pt-3 mt-1 dark:border-[#37394d]">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jalur Metro</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#fcfcfd] px-3 py-2 text-sm font-bold text-[#ebb751] dark:border-[#37394d] dark:bg-[#15151b]">{{ $selectedCustomer->jalur_metro ?? 'Belum Diisi' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">SLA</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->sla ?? '-' }}</div>
                                        </div>
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
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Telepon Kantor</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->company_phone ?? '-' }}</div>
                                    </div>
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
                            </div>
                        </div>

                        <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                            <h6 class="font-bold text-[#ebb751] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                                <i class="ti ti-headset text-lg"></i> Kontak Operasional
                            </h6>
                            
                            <div class="space-y-5">
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
                                    <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-briefcase text-[#ebb751]"></i> Account Manager (Sales)</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Sales / Marketing</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->marketing_name ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Marketing</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->marketing_phone ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex-none px-6 py-4 border-t border-[#e7e9eb] dark:border-[#37394d] bg-white dark:bg-[#1e1e2a] text-right">
                    <button wire:click="closeModal" class="btn-boron btn-boron-outline-secondary !py-2 text-sm px-6 font-semibold rounded-lg">Tutup Detail Data</button>
                </div>
            </div>
        </div>
    @endif

    @if($showArsipModal && $customerForArsip)
        <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm p-0 md:p-4" wire:transition.opacity>
            <div class="bg-white dark:bg-[#1e1f27] rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-2xl flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
                
                <div class="px-6 py-5 border-b border-[#e7e9eb] dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-full bg-[#60addf]/10 text-[#60addf]">
                            <i class="ti ti-folder-open text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-[#313a46] dark:text-white">Dokumen Teknis NOC</h3>
                            <p class="text-xs text-[#8a969c] mt-0.5">{{ $customerForArsip->company_name }}</p>
                        </div>
                    </div>
                    <button wire:click="closeArsip" class="text-[#8a969c] bg-gray-200/50 hover:bg-[#ed6060]/10 p-2 rounded-full hover:text-[#ed6060] transition-colors"><i class="ti ti-x text-xl"></i></button>
                </div>

                <div class="p-6 bg-[#fcfcfd] dark:bg-[#1e1f27]">
                    <p class="text-sm text-[#8a969c] mb-5 text-center">Pilih dokumen yang ingin Anda lihat atau cetak.</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        @if($customerForArsip->spk)
                            <a href="{{ route('marketing.spk', $customerForArsip->id) }}" target="_blank" class="flex flex-col items-center justify-center p-6 rounded-xl border border-[#dee2e6] bg-white hover:border-[#60addf] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-description text-5xl text-[#a1a9b1] group-hover:text-[#60addf] mb-4 transition-colors"></i>
                                <h6 class="font-bold text-base text-[#313a46] dark:text-white text-center">SPK (Perintah Kerja)</h6>
                                <span class="text-xs text-[#8a969c] mt-1">Cetak PDF</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center justify-center p-6 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-description text-5xl text-[#dee2e6] mb-4 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-base text-[#8a969c] text-center">SPK Tidak Ditemukan</h6>
                            </div>
                        @endif

                        @if($customerForArsip->baa && $customerForArsip->baa->signed_baa_path)
                            <a href="{{ asset('storage/' . $customerForArsip->baa->signed_baa_path) }}" target="_blank" class="flex flex-col items-center justify-center p-6 rounded-xl border border-[#dee2e6] bg-white hover:border-[#70bb63] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] shadow-[0_0_0_2px_rgba(112,187,99,0.2)]">
                                <div class="relative mb-4">
                                    <i class="ti ti-file-check text-5xl text-[#70bb63]"></i>
                                    <i class="ti ti-circle-check-filled text-[#70bb63] bg-white rounded-full absolute -bottom-1 -right-2 text-base border-2 border-white"></i>
                                </div>
                                <h6 class="font-bold text-base text-[#313a46] dark:text-white text-center">BAA (Selesai TTD)</h6>
                                <span class="text-[11px] text-[#70bb63] font-bold mt-1.5 bg-[#70bb63]/10 px-2.5 py-0.5 rounded">Telah Di-TTD Pelanggan</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center justify-center p-6 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-x text-5xl text-[#dee2e6] mb-4 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-base text-[#8a969c] text-center">BAA (Signed) Belum Ada</h6>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif

</div>