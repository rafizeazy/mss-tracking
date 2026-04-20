<div class="py-6 w-full">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route($backRoute) }}" class="size-10 flex items-center justify-center rounded-full bg-white border border-[#dee2e6] text-[#8a969c] hover:text-[#1e5d87] transition-all shadow-sm">
                <i class="ti ti-arrow-left text-xl"></i>
            </a>
            <div>
                <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#ed6060] dark:text-[#ed6060]">Arsip Pelanggan Berhenti</h4>
                <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">Daftar perusahaan yang telah melakukan pemutusan layanan secara permanen.</p>
            </div>
        </div>
    </div>

    <div class="boron-card border-t-4 border-t-[#ed6060] shadow-sm">
        <div class="boron-card-body p-0">
            <div class="w-full">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5] block md:table">
                    
                    <thead class="hidden md:table-header-group bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">ID / PERUSAHAAN</th>
                            <th class="px-6 py-4 font-semibold">KAPASITAS TERAKHIR</th>
                            <th class="px-6 py-4 font-semibold">TGL BERHENTI</th>
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
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Kapasitas</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold md:font-medium text-[#ed6060] line-through decoration-[#ed6060]/50">{{ $cust->bandwidth }}</p>
                                        <p class="text-[11px] md:text-xs text-[#8a969c]">{{ $cust->service_type }}</p>
                                    </div>
                                </td>
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 pb-1 md:pb-0 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Tgl Berhenti</span>
                                    <span class="font-medium md:font-normal text-[#313a46] dark:text-white md:text-inherit">{{ $cust->updated_at->format('d M Y') }}</span>
                                </td>
                                
                                <td class="md:px-6 md:py-4 md:text-center mt-3 md:mt-0 block md:table-cell">
                                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2 flex-wrap">
                                        <button wire:click="viewDetail({{ $cust->id }})" class="w-full sm:w-auto btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-1.5 !px-3 text-xs shadow-sm flex justify-center items-center gap-1.5 dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">
                                            <i class="ti ti-list-details text-base text-[#60addf]"></i> Detail
                                        </button>
                                        <button wire:click="openArsip({{ $cust->id }})" class="w-full sm:w-auto btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-1.5 !px-3 text-xs shadow-sm flex justify-center items-center gap-1.5 dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">
                                            <i class="ti ti-folder text-base text-[#1e5d87]"></i> Arsip Dok.
                                        </button>
                                        <button wire:click="confirmReactivate({{ $cust->id }})" class="w-full sm:w-auto btn-boron bg-[#70bb63]/10 text-[#70bb63] border border-[#70bb63]/30 hover:bg-[#70bb63] hover:text-white transition-all !py-1.5 !px-3 text-xs shadow-sm flex justify-center items-center gap-1.5">
                                            <i class="ti ti-power text-base"></i> Aktivasi Ulang
                                        </button>
                                        <button wire:click="confirmDelete({{ $cust->id }})" class="w-full sm:w-auto btn-boron bg-[#ed6060]/10 text-[#ed6060] border border-[#ed6060]/30 hover:bg-[#ed6060] hover:text-white transition-all !py-1.5 !px-3 text-xs shadow-sm flex justify-center items-center gap-1.5">
                                            <i class="ti ti-trash text-base"></i> Hapus Permanen
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row">
                                <td colspan="4" class="block md:table-cell px-6 py-12 text-center text-[#8a969c]">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="ti ti-user-off text-4xl mb-3 opacity-50"></i>
                                        <p>Tidak ada riwayat pelanggan berhenti.</p>
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

    {{-- MODAL KONFIRMASI AKTIVASI ULANG --}}
    @if($showReactivateModal && $customerToReactivate)
        <div class="fixed inset-0 z-[1000] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" wire:transition.opacity>
            <div class="bg-white dark:bg-[#1e1f27] rounded-2xl shadow-2xl w-full max-w-md flex flex-col overflow-hidden border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
                <div class="p-6 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-[#70bb63]/10 mb-4">
                        <i class="ti ti-power text-3xl text-[#70bb63]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#313a46] dark:text-white mb-2">Aktivasi Ulang Layanan?</h3>
                    <p class="text-sm text-[#8a969c] mb-6">
                        Anda yakin ingin mengaktifkan kembali layanan internet untuk perusahaan <strong>{{ $customerToReactivate->company_name }}</strong>? Statusnya akan dikembalikan menjadi Aktif (Selesai).
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-3 justify-center">
                        <button wire:click="$set('showReactivateModal', false)" class="w-full sm:w-auto btn-boron bg-[#f8f9fa] text-[#313a46] border border-[#dee2e6] hover:bg-[#e7e9eb] px-6 py-2.5 rounded-xl font-semibold dark:bg-[#15151b] dark:text-white dark:border-[#37394d]">Batal</button>
                        <button wire:click="reactivateCustomer" class="w-full sm:w-auto btn-boron bg-[#70bb63] text-white hover:bg-[#5da352] px-6 py-2.5 rounded-xl font-bold shadow-md shadow-[#70bb63]/20 flex items-center justify-center gap-2" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="reactivateCustomer">Ya, Aktifkan Sekarang</span>
                            <span wire:loading wire:target="reactivateCustomer"><i class="ti ti-loader animate-spin text-lg"></i> Memproses...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL KONFIRMASI HAPUS PERMANEN --}}
    @if($showDeleteModal && $customerToDelete)
        <div class="fixed inset-0 z-[1000] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" wire:transition.opacity>
            <div class="bg-white dark:bg-[#1e1f27] rounded-2xl shadow-2xl w-full max-w-md flex flex-col overflow-hidden border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
                <div class="p-6 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-[#ed6060]/10 mb-4">
                        <i class="ti ti-alert-triangle text-3xl text-[#ed6060]"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#313a46] dark:text-white mb-2">Hapus Data Permanen?</h3>
                    <p class="text-sm text-[#8a969c] mb-6">
                        Anda yakin ingin menghapus seluruh data pelanggan <strong>{{ $customerToDelete->company_name }}</strong>? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua riwayat pengajuan serta dokumen terkait.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-3 justify-center">
                        <button wire:click="$set('showDeleteModal', false)" class="w-full sm:w-auto btn-boron bg-[#f8f9fa] text-[#313a46] border border-[#dee2e6] hover:bg-[#e7e9eb] px-6 py-2.5 rounded-xl font-semibold dark:bg-[#15151b] dark:text-white dark:border-[#37394d]">Batal</button>
                        <button wire:click="deleteCustomer" class="w-full sm:w-auto btn-boron bg-[#ed6060] text-white hover:bg-[#c84d4d] px-6 py-2.5 rounded-xl font-bold shadow-md shadow-[#ed6060]/20 flex items-center justify-center gap-2" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="deleteCustomer">Ya, Hapus Permanen</span>
                            <span wire:loading wire:target="deleteCustomer"><i class="ti ti-loader animate-spin text-lg"></i> Menghapus...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL DETAIL PELANGGAN --}}
    @if($showModal && $selectedCustomer)
        <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/50 backdrop-blur-sm p-0 md:p-4" wire:transition.opacity>
            <div class="bg-[#f6f7fb] dark:bg-[#15151b] rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-7xl h-[90vh] md:h-auto md:max-h-[95vh] flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
                
                <div class="flex-none flex items-center justify-between border-b border-[#e7e9eb] bg-white px-6 py-5 dark:border-[#37394d] dark:bg-[#1e1e2a]">
                    <div class="flex items-center gap-4">
                        <div class="flex size-10 items-center justify-center rounded-full bg-[#ed6060]/10 text-[#ed6060]">
                            <i class="ti ti-list-details text-xl"></i>
                        </div>
                        <div>
                            <h5 class="text-lg font-extrabold text-[#313a46] dark:text-white line-clamp-1">Riwayat Detail: {{ $selectedCustomer->company_name }}</h5>
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
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Lengkap Perusahaan</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] min-h-[80px] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedCustomer->company_address ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                            <h6 class="font-bold text-[#ebb751] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                                <i class="ti ti-headset text-lg"></i> Kontak PIC
                            </h6>
                            <div class="space-y-5">
                                <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                    <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-router text-[#ebb751]"></i> PIC Teknis (Instalasi)</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama PIC Teknis</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedCustomer->technical_name ?? '-' }}</div>
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

    {{-- MODAL ARSIP DOKUMEN --}}
    @if($showArsipModal && $customerForArsip)
        <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm p-0 md:p-4" wire:transition.opacity>
            <div class="bg-white dark:bg-[#1e1f27] rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-3xl flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
                
                <div class="px-6 py-5 border-b border-[#e7e9eb] dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-full bg-[#1e5d87]/10 text-[#1e5d87]">
                            <i class="ti ti-folder-open text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-[#313a46] dark:text-white">Arsip Dokumen Pelanggan Berhenti</h3>
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
                        </a>

                        @if($customerForArsip->baa && $customerForArsip->baa->signed_baa_path)
                            <a href="{{ asset('storage/' . $customerForArsip->baa->signed_baa_path) }}" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#70bb63] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-check text-4xl text-[#70bb63] mb-3"></i>
                                <h6 class="font-bold text-sm text-[#313a46] dark:text-white text-center">BAA Awal (Signed)</h6>
                            </a>
                        @endif

                        {{-- Dokumen Terminate Jika Ada --}}
                        @php
                            $terminateReq = \App\Models\ServiceRequest::with('bau')
                                ->where('customer_id', $customerForArsip->id)
                                ->where('request_type', 'Terminate')
                                ->where('status', 'selesai')
                                ->first();
                        @endphp
                        
                        @if($terminateReq && $terminateReq->bau && $terminateReq->bau->signed_bau_path)
                            <a href="{{ asset('storage/' . $terminateReq->bau->signed_bau_path) }}" target="_blank" class="flex flex-col items-center justify-center p-5 rounded-xl border border-[#ed6060]/50 bg-[#ed6060]/5 hover:bg-[#ed6060]/10 hover:shadow-md transition-all group dark:bg-[#1e1f27] dark:border-[#ed6060]/30 shadow-[0_0_0_2px_rgba(237,96,96,0.2)]">
                                <div class="relative mb-3">
                                    <i class="ti ti-power text-4xl text-[#ed6060]"></i>
                                    <i class="ti ti-circle-check-filled text-[#ed6060] bg-white rounded-full absolute -bottom-1 -right-2 text-sm border-2 border-white"></i>
                                </div>
                                <h6 class="font-bold text-sm text-[#ed6060] text-center">BA Pemutusan</h6>
                                <span class="text-[10px] text-[#ed6060] font-bold mt-1 bg-[#ed6060]/10 px-2 py-0.5 rounded">Telah Di-TTD</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center justify-center p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-x text-4xl text-[#dee2e6] mb-3 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-sm text-[#8a969c] text-center">BA Pemutusan Kosong</h6>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>