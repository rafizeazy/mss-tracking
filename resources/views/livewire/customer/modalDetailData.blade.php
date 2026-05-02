<div x-data="{ open: false }" 
     x-on:open-detail-modal.window="open = true" 
     x-show="open" 
     style="display: none;" 
     class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/50 backdrop-blur-sm p-0 md:p-4" 
     x-transition.opacity>
    
    <div class="bg-[#f6f7fb] dark:bg-[#15151b] rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-5xl h-[90vh] md:h-auto md:max-h-[95vh] flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
        
        <div class="flex-none flex items-center justify-between border-b border-[#e7e9eb] bg-white px-6 py-5 dark:border-[#37394d] dark:bg-[#1e1e2a]">
            <div class="flex items-center gap-4">
                <div class="flex size-10 items-center justify-center rounded-full bg-[#1e5d87]/10 text-[#1e5d87]">
                    <i class="ti ti-list-details text-xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-extrabold text-[#313a46] dark:text-white line-clamp-1">Detail Data Lengkap</h5>
                    <p class="text-xs font-medium text-[#8a969c] mt-0.5">{{ $customer->company_name }}</p>
                </div>
            </div>
            <button @click="open = false" class="text-[#a1a9b1] hover:text-[#ed6060] transition-colors bg-[#f8f9fa] hover:bg-[#ed6060]/10 dark:bg-[#15151b] rounded-full p-2.5">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-6 boron-scrollbar">
            <div class="grid gap-6 md:grid-cols-2">
                
                <div class="space-y-6">
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#669776] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-user text-lg"></i> Data Pendaftar
                        </h6>
                        <ul class="space-y-3.5 text-sm">
                            <li class="flex flex-col gap-1">
                                <span class="text-[10px] font-bold text-[#8a969c] uppercase">Nama Lengkap</span>
                                <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->user->name ?? '-' }}</span>
                            </li>
                            <li class="flex flex-col gap-1">
                                <span class="text-[10px] font-bold text-[#8a969c] uppercase">Email Login</span>
                                <span class="font-medium text-[#1e5d87] dark:text-[#60addf]">{{ $customer->user->email ?? '-' }}</span>
                            </li>
                            <li class="flex flex-col gap-1">
                                <span class="text-[10px] font-bold text-[#8a969c] uppercase">Nomor HP</span>
                                <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->phone ?? '-' }}</span>
                            </li>
                            <li class="flex flex-col gap-1">
                                <span class="text-[10px] font-bold text-[#8a969c] uppercase">No. KTP</span>
                                <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->ktp_number ?? '-' }}</span>
                            </li>
                            <div class="grid grid-cols-2 gap-4">
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Gender</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->gender === 'L' ? 'Laki-laki' : ($customer->gender === 'P' ? 'Perempuan' : '-') }}</span>
                                </li>
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Jabatan</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->position ?? '-' }}</span>
                                </li>
                            </div>
                        </ul>
                    </div>

                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#1e5d87] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-wifi text-lg"></i> Informasi Layanan
                        </h6>
                        <ul class="space-y-3.5 text-sm">
                            <div class="grid grid-cols-2 gap-4">
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Kapasitas</span>
                                    <span class="font-bold text-[#1e5d87] dark:text-[#60addf]">{{ $customer->service?->bandwidth ?? '-' }}</span>
                                </li>
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Kontrak</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->service?->term_of_service ?? '-' }} Tahun</span>
                                </li>
                            </div>
                            <li class="flex flex-col gap-1">
                                <span class="text-[10px] font-bold text-[#8a969c] uppercase">Tipe Layanan</span>
                                <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->service?->service_type ?? '-' }}</span>
                            </li>
                            <li class="flex flex-col gap-1">
                                <span class="text-[10px] font-bold text-[#8a969c] uppercase">Alamat Instalasi</span>
                                <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->service?->installation_address ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#60addf] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-building-skyscraper text-lg"></i> Instansi / Perusahaan
                        </h6>
                        <ul class="space-y-3.5 text-sm">
                            <li class="flex flex-col gap-1">
                                <span class="text-[10px] font-bold text-[#8a969c] uppercase">Nama Perusahaan</span>
                                <span class="font-bold text-[#313a46] dark:text-white">{{ $customer->company_name ?? '-' }}</span>
                            </li>
                            <div class="grid grid-cols-2 gap-4">
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Bidang Usaha</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->business_type ?? '-' }}</span>
                                </li>
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">No. NPWP</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->npwp_number ?? '-' }}</span>
                                </li>
                            </div>
                            <li class="flex flex-col gap-1">
                                <span class="text-[10px] font-bold text-[#8a969c] uppercase">Alamat Lengkap</span>
                                <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->company_address ?? '-' }}</span>
                            </li>
                            <div class="grid grid-cols-2 gap-4">
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Kota/Kabupaten</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->city ?? '-' }}</span>
                                </li>
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Provinsi</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->province ?? '-' }}</span>
                                </li>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Kode Pos</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->postal_code ?? '-' }}</span>
                                </li>
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Telepon Kantor</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->company_phone ?? '-' }}</span>
                                </li>
                            </div>
                        </ul>
                    </div>

                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#ebb751] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-headset text-lg"></i> Kontak PIC
                        </h6>
                        <ul class="space-y-4 text-sm">
                            <div class="bg-[#f8f9fa] dark:bg-[#15151b] p-3 rounded-lg border border-[#e7e9eb] dark:border-[#37394d]">
                                <p class="text-[10px] font-bold text-[#ebb751] uppercase mb-2">PIC Finance (Penagihan)</p>
                                <li class="flex flex-col gap-1 mb-2">
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->finance_name ?? '-' }}</span>
                                    <span class="text-[#8a969c]">{{ $customer->finance_phone ?? '-' }} | {{ $customer->finance_email ?? '-' }}</span>
                                </li>
                                <li class="flex flex-col gap-1">
                                    <span class="text-[10px] font-bold text-[#8a969c] uppercase">Alamat Penagihan</span>
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->billing_address ?? '-' }}</span>
                                </li>
                            </div>
                            <div class="bg-[#f8f9fa] dark:bg-[#15151b] p-3 rounded-lg border border-[#e7e9eb] dark:border-[#37394d]">
                                <p class="text-[10px] font-bold text-[#ebb751] uppercase mb-2">PIC Teknis (Instalasi)</p>
                                <li class="flex flex-col gap-1">
                                    <span class="font-medium text-[#313a46] dark:text-white">{{ $customer->technical_name ?? '-' }}</span>
                                    <span class="text-[#8a969c]">{{ $customer->technical_phone ?? '-' }} | {{ $customer->technical_email ?? '-' }}</span>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex-none px-6 py-4 border-t border-[#e7e9eb] dark:border-[#37394d] bg-white dark:bg-[#1e1e2a] text-right">
            <button @click="open = false" class="btn-boron btn-boron-outline-secondary !py-2 text-sm px-6 font-semibold rounded-lg">Tutup</button>
        </div>
    </div>
</div>