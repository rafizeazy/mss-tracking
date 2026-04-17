<div class="py-6">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h4 class="text-xl font-bold text-[#313a46] dark:text-white">Monitoring Pengajuan Layanan</h4>
            <p class="text-sm text-[#8a969c]">Pantau perubahan kapasitas dan penyesuaian tagihan pelanggan.</p>
        </div>
        
        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari No. Pengajuan atau Pelanggan..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#dee2e6] text-sm focus:border-[#1e5d87] focus:ring-[#1e5d87]/20 dark:bg-[#1e1f27] dark:border-[#37394d] dark:text-white transition-all shadow-sm">
            <i class="ti ti-search absolute left-3.5 top-1/2 -translate-y-1/2 text-[#8a969c] text-lg"></i>
            <div wire:loading wire:target="search" class="absolute right-3.5 top-1/2 -translate-y-1/2">
                <i class="ti ti-loader animate-spin text-[#1e5d87]"></i>
            </div>
        </div>
    </div>

    <div class="boron-card rounded-2xl border border-[#dee2e6] bg-white shadow-sm overflow-hidden dark:bg-[#1e1f27] dark:border-[#37394d]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#f8f9fa] border-b border-[#e7e9eb] dark:bg-[#15151b] dark:border-[#37394d]">
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap">No. Pengajuan</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap">Pelanggan</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap text-center">Jenis</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap">Dampak Finansial</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap">Status</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <tr class="border-b border-[#e7e9eb] last:border-0 hover:bg-[#f8f9fa] transition-colors dark:border-[#37394d] dark:hover:bg-[#15151b]">
                            <td class="p-4">
                                <span class="text-sm font-bold text-[#313a46] dark:text-white">{{ $req->request_number }}</span>
                                <span class="block text-[11px] text-[#8a969c] mt-0.5 whitespace-nowrap"><i class="ti ti-calendar text-[10px]"></i> {{ $req->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="p-4">
                                <span class="text-sm font-bold text-[#313a46] dark:text-white line-clamp-1" title="{{ $req->customer->company_name }}">{{ $req->customer->company_name }}</span>
                                <span class="block text-[11px] font-medium text-[#1e5d87] mt-0.5">{{ $req->customer->customer_number }}</span>
                            </td>
                            <td class="p-4 text-center">
                                @php
                                    $typeColor = $req->request_type === 'Upgrade' ? 'text-[#70bb63] bg-[#70bb63]/10 border-[#70bb63]/20' : 
                                                ($req->request_type === 'Downgrade' ? 'text-[#ebb751] bg-[#ebb751]/10 border-[#ebb751]/20' : 
                                                'text-[#ed6060] bg-[#ed6060]/10 border-[#ed6060]/20');
                                @endphp
                                <span class="px-2.5 py-1 {{ $typeColor }} border rounded-md text-[10px] font-bold uppercase tracking-wider inline-block">
                                    {{ $req->request_type }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    <span class="text-xs font-bold text-[#8a969c] line-through decoration-[#ed6060]/50" title="Harga Lama">
                                        Rp {{ number_format($req->customer->monthly_fee ?? 0, 0, ',', '.') }}
                                    </span>
                                    <i class="ti ti-arrow-right text-[#8a969c] text-[10px]"></i>
                                    <span class="text-sm font-black {{ $req->new_monthly_fee ? 'text-[#70bb63]' : 'text-[#ebb751]' }}" title="Harga Baru">
                                        {{ $req->new_monthly_fee ? 'Rp ' . number_format($req->new_monthly_fee, 0, ',', '.') : 'TBA / Menunggu Review' }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-4">
                                @php
                                    $statusStr = $req->status;
                                    if(in_array($statusStr, ['selesai'])) {
                                        $bg = 'bg-[#70bb63]/10 text-[#70bb63] border-[#70bb63]/20';
                                        $icon = 'ti-circle-check';
                                    } elseif(in_array($statusStr, ['form_disetujui', 'proses_upgrade', 'pembuatan_bau'])) {
                                        $bg = 'bg-[#1e5d87]/10 text-[#1e5d87] border-[#1e5d87]/20';
                                        $icon = 'ti-settings';
                                    } elseif(in_array($statusStr, ['ditolak'])) {
                                        $bg = 'bg-[#ed6060]/10 text-[#ed6060] border-[#ed6060]/20';
                                        $icon = 'ti-x';
                                    } else {
                                        $bg = 'bg-[#ebb751]/10 text-[#b58c3d] border-[#ebb751]/20';
                                        $icon = 'ti-clock';
                                    }
                                @endphp
                                <span class="px-2.5 py-1.5 {{ $bg }} border rounded-lg text-[10px] font-bold uppercase tracking-wider flex w-fit items-center gap-1.5 whitespace-nowrap">
                                    <i class="ti {{ $icon }} text-xs"></i> 
                                    {{ str_replace('_', ' ', $statusStr) }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('finance.request.show', $req->id) }}" wire:navigate class="btn-boron inline-flex justify-center items-center gap-1.5 bg-white border border-[#dee2e6] text-[#313a46] px-4 py-2 rounded-xl text-xs font-bold hover:bg-[#f8f9fa] hover:text-[#1e5d87] hover:border-[#1e5d87] transition-all shadow-sm dark:bg-[#1e1f27] dark:border-[#37394d] dark:text-white whitespace-nowrap">
                                    <i class="ti ti-eye text-sm"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center">
                                <div class="flex flex-col items-center justify-center text-[#8a969c]">
                                    <i class="ti ti-folder-off text-5xl mb-3 text-[#dee2e6] dark:text-[#37394d]"></i>
                                    <p class="text-base font-bold text-[#313a46] dark:text-white">Tidak Ada Data Pengajuan</p>
                                    <p class="text-sm mt-1">Belum ada pelanggan yang mengajukan perubahan layanan, atau data tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($requests->hasPages())
            <div class="p-4 border-t border-[#e7e9eb] dark:border-[#37394d] bg-[#f8f9fa] dark:bg-[#15151b]">
                {{ $requests->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>
</div>