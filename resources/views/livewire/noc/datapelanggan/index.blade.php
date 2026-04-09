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
                            <th class="px-6 py-4 text-center font-semibold">AKSI & DOKUMEN</th>
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
                                    <div class="flex flex-col md:flex-row items-center justify-center gap-2 md:gap-1.5 md:flex-wrap">
                                        <button wire:click="viewDetail({{ $cust->id }})" class="w-full md:w-auto justify-center btn-boron bg-[#60addf] text-white hover:bg-[#4d9acc] !py-2.5 md:!px-3 md:!py-1 text-sm md:text-[11px] shadow-md flex items-center gap-1.5 border-none rounded-lg md:rounded">
                                            <i class="ti ti-list-details text-lg md:text-base"></i> Detail Data
                                        </button>
                                        
                                        <!-- Grid untuk tombol-tombol dokumen di Mobile -->
                                        <div class="grid grid-cols-2 md:flex w-full md:w-auto gap-2 md:gap-1.5">
                                            @if($cust->spk) 
                                                <a href="{{ route('marketing.spk', $cust->id) }}" target="_blank" class="flex justify-center btn-boron btn-boron-outline-primary !py-2 md:!px-2 md:!py-1 text-xs md:text-[11px] rounded-lg md:rounded" title="Lihat SPK">
                                                    <i class="ti ti-file-description mr-1"></i> SPK
                                                </a> 
                                            @endif
                                            
                                            @if($cust->baa) 
                                                <a href="{{ route('noc.baa', $cust->id) }}" target="_blank" class="flex justify-center btn-boron btn-boron-outline-success !py-2 md:!px-2 md:!py-1 text-xs md:text-[11px] !text-[#70bb63] !border-[#70bb63] rounded-lg md:rounded" title="Lihat BAA">
                                                    <i class="ti ti-file-certificate mr-1"></i> BAA
                                                </a> 
                                            @endif
                                        </div>
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
            <div class="bg-white dark:bg-[#1e1f27] rounded-t-2xl md:rounded-xl shadow-2xl w-full max-w-5xl h-[90vh] md:h-auto md:max-h-[90vh] flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>

                <div class="w-full flex justify-center pt-3 pb-1 md:hidden bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div class="w-12 h-1.5 bg-gray-300 rounded-full dark:bg-gray-600"></div>
                </div>

                <div class="px-5 md:px-6 py-4 md:py-4 border-b border-[#e7e9eb] dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div>
                        <h3 class="font-bold text-base md:text-lg text-[#313a46] dark:text-white line-clamp-1">Detail: {{ $selectedCustomer->company_name }}</h3>
                        <p class="text-[11px] md:text-xs text-[#8a969c] mt-0.5">ID Pelanggan: <span class="font-bold text-[#ebb751]">{{ $selectedCustomer->customer_number ?? 'N/A' }}</span></p>
                    </div>
                    <button wire:click="closeModal" class="text-[#8a969c] bg-gray-200/50 md:bg-transparent p-1.5 md:p-0 rounded-full md:rounded-none hover:text-[#ed6060] transition-colors"><i class="ti ti-x text-xl md:text-2xl"></i></button>
                </div>

                <div class="p-5 md:p-6 overflow-y-auto boron-scrollbar flex-1 text-[13px] md:text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                        
                        <!-- Kolom Kiri -->
                        <div class="space-y-6 md:space-y-8">
                            <div class="space-y-3">
                                <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf] uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-building text-sm md:text-base mr-1"></i> Data Perusahaan</h5>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">PT/Instansi</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->company_name }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Bidang Usaha</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->business_type ?? '-' }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">No. NPWP</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->npwp_number ?? '-' }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Telepon</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->company_phone ?? '-' }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Alamat</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->company_address ?? '-' }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Kota/Prov</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->city ?? '-' }}, {{ $selectedCustomer->province ?? '-' }} ({{ $selectedCustomer->postal_code ?? '-' }})</span></div>
                            </div>

                            <div class="space-y-3">
                                <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf] uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-user text-sm md:text-base mr-1"></i> Data PIC Utama</h5>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Nama PIC</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->user->name }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">No. KTP</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->ktp_number ?? '-' }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Gender</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->gender === 'L' ? 'Laki-Laki' : ($selectedCustomer->gender === 'P' ? 'Perempuan' : '-') }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Jabatan</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->position ?? '-' }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">No. HP</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->phone ?? '-' }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Email Login</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->user->email }}</span></div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-6 md:space-y-8">
                            <div class="space-y-3">
                                <h5 class="font-bold text-[#ebb751] uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-router text-sm md:text-base mr-1"></i> Data Layanan & Teknis</h5>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Kapasitas</span><span class="md:col-span-2 font-bold text-[#1e5d87] dark:text-[#60addf]">: {{ $selectedCustomer->bandwidth }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Jenis Layanan</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->service_type }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">Masa Kontrak</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->term_of_service }} Tahun</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2"><span class="text-[#8a969c]">SLA</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->sla ?? '-' }}</span></div>
                                <div class="grid grid-cols-[100px_1fr] md:grid-cols-3 gap-2 mt-2 pt-2 border-t border-[#e7e9eb] dark:border-[#37394d]"><span class="text-[#8a969c]">Marketing</span><span class="md:col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->marketing_name ?? '-' }} ({{ $selectedCustomer->marketing_phone ?? '-' }})</span></div>
                            </div>

                            <div class="space-y-4">
                                <h5 class="font-bold text-[#669776] uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-address-book text-sm md:text-base mr-1"></i> Kontak Operasional</h5>

                                <div>
                                    <p class="text-[11px] font-semibold text-[#8a969c] uppercase mb-1">PIC Teknis / Lapangan</p>
                                    <div class="bg-[#f8f9fa] dark:bg-white/5 p-3 md:p-4 rounded-lg text-xs md:text-sm space-y-2 border border-[#e7e9eb] dark:border-[#37394d]">
                                        <p><span class="text-[#8a969c] w-[80px] md:w-[90px] inline-block">Nama:</span> <span class="font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->technical_name ?? '-' }}</span></p>
                                        <p><span class="text-[#8a969c] w-[80px] md:w-[90px] inline-block">No. HP:</span> <span class="font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->technical_phone ?? '-' }}</span></p>
                                        <p><span class="text-[#8a969c] w-[80px] md:w-[90px] inline-block align-top">Email:</span> <span class="font-medium text-[#313a46] dark:text-white inline-block w-[calc(100%-80px)] md:w-[calc(100%-90px)] break-words">{{ $selectedCustomer->technical_email ?? '-' }}</span></p>
                                        <p><span class="text-[#8a969c] w-[80px] md:w-[90px] inline-block align-top mt-1">Alamat Instalasi:</span> <span class="font-medium text-[#313a46] dark:text-white inline-block w-[calc(100%-80px)] md:w-[calc(100%-90px)] mt-1">{{ $selectedCustomer->installation_address ?? '-' }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 mb-4 md:mb-0">
                        <h5 class="font-bold text-[#313a46] dark:text-white uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-paperclip text-sm md:text-base mr-1"></i> Dokumen Pendukung Terlampir</h5>
                        <div class="grid grid-cols-2 md:flex flex-wrap gap-2 md:gap-3">
                            @if($selectedCustomer->ktp_file_path) <a href="{{ asset('storage/' . $selectedCustomer->ktp_file_path) }}" target="_blank" class="flex justify-center px-3 py-2 md:py-1.5 bg-[#60addf]/10 text-[#60addf] rounded-lg md:rounded text-xs font-semibold hover:bg-[#60addf] hover:text-white transition-colors"><i class="ti ti-id mr-1 text-sm md:text-xs"></i> File KTP</a> @endif
                            @if($selectedCustomer->npwp_file_path) <a href="{{ asset('storage/' . $selectedCustomer->npwp_file_path) }}" target="_blank" class="flex justify-center px-3 py-2 md:py-1.5 bg-[#60addf]/10 text-[#60addf] rounded-lg md:rounded text-xs font-semibold hover:bg-[#60addf] hover:text-white transition-colors"><i class="ti ti-file-text mr-1 text-sm md:text-xs"></i> File NPWP</a> @endif
                            @if($selectedCustomer->nib_file_path) <a href="{{ asset('storage/' . $selectedCustomer->nib_file_path) }}" target="_blank" class="flex justify-center px-3 py-2 md:py-1.5 bg-[#60addf]/10 text-[#60addf] rounded-lg md:rounded text-xs font-semibold hover:bg-[#60addf] hover:text-white transition-colors"><i class="ti ti-certificate mr-1 text-sm md:text-xs"></i> File NIB</a> @endif
                            @if(!$selectedCustomer->ktp_file_path && !$selectedCustomer->npwp_file_path && !$selectedCustomer->nib_file_path)
                                <span class="text-xs text-[#8a969c] italic col-span-2 text-center md:text-left py-2">Tidak ada dokumen pendukung yang dilampirkan.</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="px-5 md:px-6 py-4 border-t border-[#e7e9eb] dark:border-[#37394d] bg-[#f8f9fa] dark:bg-[#15151b]">
                    <button wire:click="closeModal" class="w-full md:w-auto md:float-right btn-boron btn-boron-outline-secondary !py-2.5 md:!py-1.5 !px-4 text-sm font-semibold rounded-lg md:rounded">Tutup Detail</button>
                    <div class="clear-both"></div>
                </div>
            </div>
        </div>
    @endif

</div>