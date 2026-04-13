<div class="py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div>
            <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">{{ __('Antrean SPK & Instalasi') }}</h4>
            <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">{{ __('Daftar Surat Perintah Kerja (SPK) yang harus dikerjakan oleh tim NOC.') }}</p>
        </div>
        <div class="relative w-full md:w-72">
            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
            <input
                type="text"
                wire:model.live.debounce.400ms="search"
                placeholder="Cari nama perusahaan atau telepon..."
                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white py-2 pl-9 pr-4 text-sm text-[#4c4c5c] shadow-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:bg-[#1e1f27] dark:text-[#aab8c5]"
            >
        </div>
    </div>

    <div class="boron-card">
        <div class="boron-card-body p-0">
            <div class="w-full">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5] block md:table">
                    
                    <thead class="hidden md:table-header-group bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">TENGGAT WAKTU (DUE)</th>
                            <th class="px-6 py-4 font-semibold">NO. SPK</th>
                            <th class="px-6 py-4 font-semibold">PELANGGAN</th>
                            <th class="px-6 py-4 font-semibold">LAYANAN</th>
                            <th class="px-6 py-4 font-semibold">STATUS</th>
                            <th class="px-6 py-4 text-center font-semibold">AKSI</th>
                        </tr>
                    </thead>
                    
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($customers as $cust)
                            <tr class="flex flex-col md:table-row border-b border-[#e7e9eb] md:border-none dark:border-[#37394d] p-5 md:p-0 gap-3 md:gap-0 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Tenggat Waktu</span>
                                    <span class="font-bold md:font-medium {{ $cust->spk && \Carbon\Carbon::parse($cust->spk->due_date)->isPast() ? 'text-[#ed6060]' : 'text-[#ebb751]' }}">
                                        @if($cust->spk && $cust->spk->due_date)
                                            {{ \Carbon\Carbon::parse($cust->spk->due_date)->format('d M Y') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </td>
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">No. SPK</span>
                                    <span class="font-bold md:font-semibold text-[#1e5d87] dark:text-[#60addf]">
                                        {{ $cust->spk->spk_number ?? '-' }}
                                    </span>
                                </td>
                                
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Pelanggan</span>
                                    <div class="text-right md:text-left w-[60%] md:w-auto">
                                        <p class="font-bold md:font-medium text-[#313a46] dark:text-white line-clamp-1">{{ $cust->company_name }}</p>
                                        <p class="text-[11px] md:text-xs text-[#8a969c] mt-0.5 line-clamp-2 md:line-clamp-none">{{ $cust->installation_address ?? $cust->company_address }}</p>
                                    </div>
                                </td>
                                
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Layanan</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold md:font-medium text-[#313a46] dark:text-white">{{ $cust->bandwidth }}</p>
                                        <p class="text-[11px] md:text-xs text-[#8a969c] mt-0.5">{{ $cust->service_type }}</p>
                                    </div>
                                </td>
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap pb-1 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Status</span>
                                    <div>
                                        @if($cust->status === 'proses_instalasi')
                                            <span class="rounded bg-[#ed6060]/10 px-2.5 py-1 text-[10px] md:text-xs font-semibold text-[#ed6060] animate-pulse ring-2 ring-[#ed6060]/50">Tugas Baru (Instalasi)</span>
                                        @elseif($cust->status === 'proses_aktivasi')
                                            <span class="rounded bg-[#ebb751]/10 px-2.5 py-1 text-[10px] md:text-xs font-semibold text-[#ebb751]">Tahap Aktivasi</span>
                                        @elseif($cust->status === 'review_baa')
                                            <span class="rounded bg-[#60addf]/10 px-2.5 py-1 text-[10px] md:text-xs font-semibold text-[#60addf]">Review BAA Internal</span>
                                        @elseif($cust->status === 'menunggu_baa')
                                            <span class="rounded bg-[#8a969c]/10 px-2.5 py-1 text-[10px] md:text-xs font-semibold text-[#8a969c]">Tunggu TTD Pelanggan</span>
                                        @elseif($cust->status === 'verifikasi_baa')
                                            <span class="rounded bg-[#70bb63]/10 px-2.5 py-1 text-[10px] md:text-xs font-semibold text-[#70bb63]">Verifikasi Marketing</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="md:px-6 md:py-4 md:text-center mt-3 md:mt-0 block md:table-cell">
                                    <a href="{{ route('noc.tracking.show', $cust->id) }}" wire:navigate class="w-full md:w-auto inline-flex justify-center items-center btn-boron btn-boron-outline-primary !px-4 !py-2.5 md:!px-3 md:!py-1 text-sm md:text-xs rounded-lg md:rounded">
                                        <i class="ti ti-settings md:hidden mr-1.5 text-lg"></i> Buka SPK
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row">
                                <td colspan="6" class="block md:table-cell px-6 py-12 text-center text-[#8a969c]">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="ti ti-router text-4xl mb-2 opacity-50"></i>
                                        <p>Belum ada antrean pekerjaan untuk tim NOC saat ini.</p>
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
</div>