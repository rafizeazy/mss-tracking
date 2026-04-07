<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">Arsip Data Pelanggan Aktif</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">Basis data pelanggan yang layanannya telah beroperasi (100% Selesai).</p>
        </div>
    </div>

    <div class="boron-card">
        <div class="boron-card-body p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                    <thead class="bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">ID / PERUSAHAAN</th>
                            <th class="px-6 py-4 font-semibold">LAYANAN</th>
                            <th class="px-6 py-4 font-semibold">TGL AKTIF</th>
                            <th class="px-6 py-4 text-center font-semibold">AKSI & DOKUMEN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($customers as $cust)
                            <tr class="hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-[#ebb751] text-xs mb-0.5">{{ $cust->customer_number ?? '-' }}</p>
                                    <p class="font-medium text-[#313a46] dark:text-white">{{ $cust->company_name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-[#313a46] dark:text-white">{{ $cust->bandwidth }}</p>
                                    <p class="text-xs text-[#8a969c]">{{ $cust->service_type }}</p>
                                </td>
                                <td class="px-6 py-4">{{ $cust->baa && $cust->baa->activation_date ? $cust->baa->activation_date->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                        <button wire:click="viewDetail({{ $cust->id }})" class="btn-boron bg-[#60addf] text-white hover:bg-[#4d9acc] !px-3 !py-1 text-[11px] shadow-md flex items-center gap-1 border-none">
                                            <i class="ti ti-list-details"></i> Detail Data
                                        </button>
                                        
                                        <a href="{{ route('form.formulir', $cust->id) }}" target="_blank" class="btn-boron btn-boron-outline-secondary !px-2 !py-1 text-[11px]" title="Cetak Formulir">
                                            <i class="ti ti-file-text text-[#1e5d87]"></i> FORM
                                        </a>

                                        @if($cust->spk) 
                                            <a href="{{ route('marketing.spk', $cust->id) }}" target="_blank" class="btn-boron btn-boron-outline-primary !px-2 !py-1 text-[11px]" title="Lihat SPK"><i class="ti ti-file-description"></i> SPK</a> 
                                        @endif
                                        @if($cust->baa) 
                                            <a href="{{ route('noc.baa', $cust->id) }}" target="_blank" class="btn-boron btn-boron-outline-success !px-2 !py-1 text-[11px] !text-[#70bb63] !border-[#70bb63]" title="Lihat BAA"><i class="ti ti-file-certificate"></i> BAA</a> 
                                        @endif
                                        <a href="{{ route('customer.invoice', $cust->id) }}" target="_blank" class="btn-boron btn-boron-outline-warning !px-2 !py-1 text-[11px] !text-[#ebb751] !border-[#ebb751]" title="Lihat Invoice"><i class="ti ti-file-invoice"></i> INV</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-[#8a969c]">Belum ada arsip pelanggan aktif.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($customers->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d]">{{ $customers->links() }}</div>
            @endif
        </div>
    </div>

    @if($showModal && $selectedCustomer)
        <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 sm:p-6" wire:transition.opacity>
            <div class="bg-white dark:bg-[#1e1f27] rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
                
                <div class="px-6 py-4 border-b border-[#e7e9eb] dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div>
                        <h3 class="font-bold text-lg text-[#313a46] dark:text-white">Detail Pelanggan: {{ $selectedCustomer->company_name }}</h3>
                        <p class="text-xs text-[#8a969c] mt-0.5">ID Pelanggan: <span class="font-bold text-[#ebb751]">{{ $selectedCustomer->customer_number ?? 'N/A' }}</span></p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('form.formulir', $selectedCustomer->id) }}" target="_blank" class="btn-boron !py-1.5 flex items-center gap-1 bg-[#1e5d87]/10 text-[#1e5d87] hover:bg-[#1e5d87]/20 border border-[#1e5d87]/20 transition-colors font-medium dark:bg-[#60addf]/10 dark:text-[#60addf] dark:border-[#60addf]/20">
                            <i class="ti ti-file-text"></i> Cetak Formulir
                        </a>
                        <button wire:click="closeModal" class="text-[#8a969c] hover:text-[#ed6060] transition-colors"><i class="ti ti-x text-2xl"></i></button>
                    </div>
                </div>

                <div class="p-6 overflow-y-auto boron-scrollbar flex-1 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf] uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-building"></i> Data Perusahaan</h5>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Nama PT/Instansi</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->company_name }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Bidang Usaha</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->business_type ?? '-' }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">No. NPWP</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->npwp_number ?? '-' }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Telp Perusahaan</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->company_phone ?? '-' }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Alamat Lengkap</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->company_address ?? '-' }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Kota / Provinsi</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->city ?? '-' }}, {{ $selectedCustomer->province ?? '-' }} ({{ $selectedCustomer->postal_code ?? '-' }})</span></div>
                        </div>

                        <div class="space-y-3">
                            <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf] uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-user"></i> Data PIC Utama (Pendaftar)</h5>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Nama Lengkap</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->user->name }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">No. KTP</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->ktp_number ?? '-' }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Jenis Kelamin</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->gender === 'L' ? 'Laki-Laki' : ($selectedCustomer->gender === 'P' ? 'Perempuan' : '-') }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Jabatan</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->position ?? '-' }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">No. Handphone</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->phone ?? '-' }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Email Login</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->user->email }}</span></div>
                        </div>

                        <div class="space-y-3 mt-4 md:mt-0">
                            <h5 class="font-bold text-[#669776] uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-address-book"></i> Kontak Operasional</h5>
                            <p class="text-xs font-semibold text-[#8a969c] uppercase mb-1">PIC Keuangan (Finance)</p>
                            <div class="bg-[#f8f9fa] dark:bg-white/5 p-3 rounded text-xs space-y-2 border border-[#e7e9eb] dark:border-[#37394d]">
                                <p><span class="text-[#8a969c] w-[90px] inline-block">Nama:</span> <span class="font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->finance_name ?? '-' }}</span></p>
                                <p><span class="text-[#8a969c] w-[90px] inline-block">No. HP:</span> <span class="font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->finance_phone ?? '-' }}</span></p>
                                <p><span class="text-[#8a969c] w-[90px] inline-block">Email:</span> <span class="font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->finance_email ?? '-' }}</span></p>
                                <p><span class="text-[#8a969c] w-[90px] inline-block align-top">Alamat Tagihan:</span> <span class="font-medium text-[#313a46] dark:text-white inline-block w-[calc(100%-100px)]">{{ $selectedCustomer->billing_address ?? '-' }}</span></p>
                            </div>

                            <p class="text-xs font-semibold text-[#8a969c] uppercase mb-1 mt-4">PIC Teknis / Lapangan</p>
                            <div class="bg-[#f8f9fa] dark:bg-white/5 p-3 rounded text-xs space-y-2 border border-[#e7e9eb] dark:border-[#37394d]">
                                <p><span class="text-[#8a969c] w-[90px] inline-block">Nama:</span> <span class="font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->technical_name ?? '-' }}</span></p>
                                <p><span class="text-[#8a969c] w-[90px] inline-block">No. HP:</span> <span class="font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->technical_phone ?? '-' }}</span></p>
                                <p><span class="text-[#8a969c] w-[90px] inline-block">Email:</span> <span class="font-medium text-[#313a46] dark:text-white">{{ $selectedCustomer->technical_email ?? '-' }}</span></p>
                                <p><span class="text-[#8a969c] w-[90px] inline-block align-top">Alamat Instalasi:</span> <span class="font-medium text-[#313a46] dark:text-white inline-block w-[calc(100%-100px)]">{{ $selectedCustomer->installation_address ?? '-' }}</span></p>
                            </div>
                        </div>

                        <div class="space-y-3 mt-4 md:mt-0">
                            <h5 class="font-bold text-[#ebb751] uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-report-money"></i> Layanan & Komersial</h5>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Kapasitas</span><span class="col-span-2 font-bold text-[#1e5d87] dark:text-[#60addf]">: {{ $selectedCustomer->bandwidth }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Jenis Layanan</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->service_type }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Masa Kontrak</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->term_of_service }} Tahun</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">SLA</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->sla ?? '-' }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Biaya Bulanan</span><span class="col-span-2 font-bold text-[#70bb63]">: Rp {{ number_format($selectedCustomer->monthly_fee ?? 0, 0, ',', '.') }}</span></div>
                            <div class="grid grid-cols-3 gap-2"><span class="text-[#8a969c]">Biaya Registrasi</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: Rp {{ number_format($selectedCustomer->registration_fee ?? 0, 0, ',', '.') }}</span></div>
                            <div class="grid grid-cols-3 gap-2 mt-2 pt-2 border-t border-[#e7e9eb] dark:border-[#37394d]"><span class="text-[#8a969c]">Marketing</span><span class="col-span-2 font-medium text-[#313a46] dark:text-white">: {{ $selectedCustomer->marketing_name ?? '-' }} ({{ $selectedCustomer->marketing_phone ?? '-' }})</span></div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h5 class="font-bold text-[#313a46] dark:text-white uppercase text-xs border-b border-dashed border-[#e7e9eb] dark:border-[#37394d] pb-2 mb-3"><i class="ti ti-paperclip"></i> Dokumen Pendukung Terlampir</h5>
                        <div class="flex flex-wrap gap-3">
                            @if($selectedCustomer->ktp_file_path) <a href="{{ asset('storage/' . $selectedCustomer->ktp_file_path) }}" target="_blank" class="px-3 py-1.5 bg-[#60addf]/10 text-[#60addf] rounded text-xs font-semibold hover:bg-[#60addf] hover:text-white transition-colors"><i class="ti ti-id"></i> File KTP</a> @endif
                            @if($selectedCustomer->npwp_file_path) <a href="{{ asset('storage/' . $selectedCustomer->npwp_file_path) }}" target="_blank" class="px-3 py-1.5 bg-[#60addf]/10 text-[#60addf] rounded text-xs font-semibold hover:bg-[#60addf] hover:text-white transition-colors"><i class="ti ti-file-text"></i> File NPWP</a> @endif
                            @if($selectedCustomer->nib_file_path) <a href="{{ asset('storage/' . $selectedCustomer->nib_file_path) }}" target="_blank" class="px-3 py-1.5 bg-[#60addf]/10 text-[#60addf] rounded text-xs font-semibold hover:bg-[#60addf] hover:text-white transition-colors"><i class="ti ti-certificate"></i> File NIB</a> @endif
                            @if($selectedCustomer->payment_proof_file_path) <a href="{{ asset('storage/' . $selectedCustomer->payment_proof_file_path) }}" target="_blank" class="px-3 py-1.5 bg-[#70bb63]/10 text-[#70bb63] rounded text-xs font-semibold hover:bg-[#70bb63] hover:text-white transition-colors"><i class="ti ti-receipt"></i> Bukti Bayar</a> @endif
                        </div>
                    </div>

                </div>

                <div class="px-6 py-4 border-t border-[#e7e9eb] dark:border-[#37394d] flex justify-end bg-[#f8f9fa] dark:bg-[#15151b]">
                    <button wire:click="closeModal" class="btn-boron btn-boron-outline-secondary !py-1.5 !px-4 text-sm">Tutup Detail</button>
                </div>
            </div>
        </div>
    @endif

</div>