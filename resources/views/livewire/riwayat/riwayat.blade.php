<div class="py-6">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h4 class="text-xl font-bold text-[#313a46] dark:text-white">Riwayat Pelanggan & Layanan</h4>
            <p class="text-sm text-[#8a969c]">Rekam jejak aktivasi dan perubahan layanan yang telah selesai.</p>
        </div>
        
        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari ID, Nama, atau Perusahaan..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-[#dee2e6] text-sm focus:border-[#1e5d87] focus:ring-[#1e5d87]/20 dark:bg-[#1e1f27] dark:border-[#37394d] dark:text-white transition-all shadow-sm">
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
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap">ID Pelanggan</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap">Nama & Perusahaan</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap text-center">Status / Jenis</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap">Detail Layanan</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap">Tgl. Pengajuan</th>
                        <th class="p-4 text-xs font-bold text-[#8a969c] uppercase whitespace-nowrap">Tgl. Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $item)
                        <tr class="border-b border-[#e7e9eb] last:border-0 hover:bg-[#f8f9fa] transition-colors dark:border-[#37394d] dark:hover:bg-[#15151b]">
                            <td class="p-4">
                                <span class="text-sm font-black text-[#1e5d87] dark:text-[#60addf]">{{ $item['customer_number'] }}</span>
                            </td>
                            <td class="p-4">
                                <span class="text-sm font-bold text-[#313a46] dark:text-white line-clamp-1" title="{{ $item['company_name'] }}">{{ $item['company_name'] }}</span>
                                <span class="block text-[11px] font-medium text-[#8a969c] mt-0.5">{{ $item['customer_name'] }}</span>
                            </td>
                            <td class="p-4 text-center">
                                @php
                                    $typeColor = match($item['type']) {
                                        'Aktivasi' => 'text-[#60addf] bg-[#60addf]/10 border-[#60addf]/20',
                                        'Upgrade' => 'text-[#70bb63] bg-[#70bb63]/10 border-[#70bb63]/20',
                                        'Downgrade' => 'text-[#ebb751] bg-[#ebb751]/10 border-[#ebb751]/20',
                                        'Terminate' => 'text-[#ed6060] bg-[#ed6060]/10 border-[#ed6060]/20',
                                        default => 'text-[#8a969c] bg-gray-100 border-gray-200'
                                    };
                                    $icon = match($item['type']) {
                                        'Aktivasi' => 'ti-plug-connected',
                                        'Upgrade' => 'ti-arrow-up-right',
                                        'Downgrade' => 'ti-arrow-down-right',
                                        'Terminate' => 'ti-power',
                                        default => 'ti-activity'
                                    };
                                @endphp
                                <span class="px-2.5 py-1.5 {{ $typeColor }} border rounded-md text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1.5 whitespace-nowrap">
                                    <i class="ti {{ $icon }} text-xs"></i> {{ $item['type'] }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if(in_array($item['type'], ['Upgrade', 'Downgrade']))
                                    <div class="text-[11px] text-[#8a969c] whitespace-nowrap">
                                        Kapasitas: <span class="line-through decoration-[#ed6060]/50">{{ $item['old_bandwidth'] ?? '-' }}</span> 
                                        <i class="ti ti-arrow-right mx-1"></i> 
                                        <span class="font-bold text-[#313a46] dark:text-white">{{ $item['new_bandwidth'] ?? '-' }}</span>
                                    </div>

                                    {{-- Cek User Noc Bukan --}}
                                    @if(auth()->user()->role !== \App\Enums\Role::Noc)
                                        <div class="text-[11px] text-[#8a969c] mt-1 whitespace-nowrap">
                                            Harga: <span class="line-through decoration-[#ed6060]/50">Rp {{ number_format($item['old_monthly_fee'] ?? 0, 0, ',', '.') }}</span> 
                                            <i class="ti ti-arrow-right mx-1"></i> 
                                            <span class="font-bold {{ $item['type'] === 'Upgrade' ? 'text-[#70bb63]' : 'text-[#ebb751]' }}">Rp {{ number_format($item['new_monthly_fee'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                @elseif($item['type'] === 'Aktivasi')
                                    <div class="text-[11px] text-[#8a969c] whitespace-nowrap">
                                        Kapasitas: <span class="font-bold text-[#313a46] dark:text-white">{{ $item['new_bandwidth'] ?? '-' }}</span>
                                    </div>
                                    
                                    {{-- Cek User NOC bukan --}}
                                    @if(auth()->user()->role !== \App\Enums\Role::Noc)
                                        <div class="text-[11px] text-[#8a969c] mt-1 whitespace-nowrap">
                                            Harga: <span class="font-bold text-[#60addf]">Rp {{ number_format($item['new_monthly_fee'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                @elseif($item['type'] === 'Terminate')
                                    <div class="text-[11px] text-[#ed6060] font-bold">Layanan Dihentikan Permanen</div>
                                @endif
                            </td>

                            {{-- Tngl Pengajuan --}}
                            <td class="p-4">
                                <span class="text-sm font-medium text-[#313a46] dark:text-[#aab8c5] whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item['request_date'])->format('d M Y') }}
                                </span>
                            </td>

                            {{-- Tanggal Selesai --}}
                            <td class="p-4">
                                <span class="text-sm font-bold text-[#70bb63] whitespace-nowrap">
                                    <i class="ti ti-check text-xs"></i> {{ \Carbon\Carbon::parse($item['completed_date'])->format('d M Y') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center">
                                <div class="flex flex-col items-center justify-center text-[#8a969c]">
                                    <i class="ti ti-history text-5xl mb-3 text-[#dee2e6] dark:text-[#37394d]"></i>
                                    <p class="text-base font-bold text-[#313a46] dark:text-white">Tidak Ada Riwayat</p>
                                    <p class="text-sm mt-1">Belum ada data pelanggan yang selesai aktivasi atau perubahan layanan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($isPaginated) && $isPaginated)
            <div class="p-4 border-t border-[#e7e9eb] dark:border-[#37394d] bg-[#f8f9fa] dark:bg-[#15151b]">
                {{ $riwayat->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>
</div>