<div class="py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div>
            <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">
                {{ $showCancelled ? __('Data Registrasi Batal / Ditolak') : __('Tracking Antrean Registrasi') }}
            </h4>
            <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">
                {{ $showCancelled ? __('Daftar pelanggan yang pengajuannya telah dibatalkan atau ditolak.') : __('Daftar pelanggan baru yang menunggu verifikasi data dan dokumen.') }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="toggleCancelled" class="btn-boron !py-2 text-sm font-medium transition-colors border {{ $showCancelled ? 'bg-[#1e5d87]/10 text-[#1e5d87] border-[#1e5d87]/20 hover:bg-[#1e5d87]/20' : 'bg-[#ed6060]/10 text-[#ed6060] border-[#ed6060]/20 hover:bg-[#ed6060]/20' }}">
                @if($showCancelled)
                    <i class="ti ti-arrow-left mr-1"></i> Kembali ke Antrean Aktif
                @else
                    <i class="ti ti-ban mr-1"></i> Lihat Registrasi Batal
                @endif
            </button>
        </div>
        <div class="relative w-full md:w-72">
            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
            <input
                type="text"
                wire:model.live.debounce.400ms="search"
                placeholder="Cari nama perusahaan atau telepon..."
                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white py-2 pl-9 pr-4 text-sm text-[#4c4c5c] shadow-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1f27] dark:text-[#aab8c5]"
            >
        </div>
    </div>

    <div class="boron-card">
        <div class="boron-card-body p-0">
            <div class="w-full">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5] block md:table">
                    <thead class="hidden md:table-header-group bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">TANGGAL REGISTRASI</th>
                            <th class="px-6 py-4 font-semibold">NAMA PERUSAHAAN</th>
                            <th class="px-6 py-4 font-semibold">PIC / KONTAK</th>
                            <th class="px-6 py-4 font-semibold">LAYANAN</th>
                            <th class="px-6 py-4 font-semibold">STATUS</th>
                            <th class="px-6 py-4 text-center font-semibold">AKSI</th>
                        </tr>
                    </thead>
                    
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($customers as $customer)
                            <tr class="flex flex-col md:table-row border-b border-[#e7e9eb] md:border-none dark:border-[#37394d] p-5 md:p-0 gap-3 md:gap-0 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Tanggal</span>
                                    <span class="text-sm md:text-sm font-medium md:font-normal text-[#313a46] dark:text-white md:text-inherit">{{ $customer->created_at->format('d M Y, H:i') }}</span>
                                </td>
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Perusahaan</span>
                                    <span class="font-bold md:font-medium text-[#313a46] dark:text-white text-right md:text-left">{{ $customer->company_name }}</span>
                                </td>
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">PIC / Kontak</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->user->name }}</p>
                                        <p class="text-xs text-[#8a969c]">{{ $customer->phone }}</p>
                                    </div>
                                </td>
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Layanan</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold md:font-medium text-[#1e5d87] dark:text-[#60addf] md:text-[#313a46] md:dark:text-white">{{ $customer->service?->bandwidth ?? '-' }}</p>
                                        <p class="text-[11px] md:text-xs text-[#8a969c]">{{ $customer->service?->service_type ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap pb-1 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Status</span>
                                    @php
                                        $statusFormat = match($customer->status) {
                                            'menunggu_verifikasi' => ['label' => 'Menunggu Verifikasi', 'class' => 'bg-[#ebb751]/10 text-[#ebb751] border-[#ebb751]/20'],
                                            'menunggu_invoice'    => ['label' => 'Menunggu Invoice', 'class' => 'bg-[#60addf]/10 text-[#60addf] border-[#60addf]/20'],
                                            'menunggu_pembayaran' => ['label' => 'Menunggu Pembayaran', 'class' => 'bg-[#ebb751]/10 text-[#ebb751] border-[#ebb751]/20'],
                                            'verifikasi_pembayaran'=> ['label' => 'Verifikasi Pembayaran', 'class' => 'bg-[#60addf]/10 text-[#60addf] border-[#60addf]/20'],
                                            'pembayaran_disetujui'=> ['label' => 'Pembayaran Disetujui', 'class' => 'bg-[#70bb63]/10 text-[#70bb63] border-[#70bb63]/20'],
                                            'proses_instalasi'    => ['label' => 'Proses Instalasi', 'class' => 'bg-[#1e5d87]/10 text-[#1e5d87] border-[#1e5d87]/20'],
                                            'proses_aktivasi'     => ['label' => 'Proses Aktivasi', 'class' => 'bg-[#1e5d87]/10 text-[#1e5d87] border-[#1e5d87]/20'],
                                            'review_baa'          => ['label' => 'Review BAA (NOC)', 'class' => 'bg-[#60addf]/10 text-[#60addf] border-[#60addf]/20'],
                                            'menunggu_baa'        => ['label' => 'Tunggu TTD Pelanggan', 'class' => 'bg-[#ebb751]/10 text-[#ebb751] border-[#ebb751]/20'],
                                            'verifikasi_baa'      => ['label' => 'Verifikasi Akhir BAA', 'class' => 'bg-[#70bb63]/10 text-[#70bb63] border-[#70bb63]/20 ring-2 ring-[#70bb63]/50 animate-pulse'],
                                            'selesai'             => ['label' => 'Selesai & Aktif', 'class' => 'bg-[#70bb63]/10 text-[#70bb63] border-[#70bb63]/20'],
                                            'dibatalkan'          => ['label' => 'Dibatalkan', 'class' => 'bg-[#ed6060]/10 text-[#ed6060] border-[#ed6060]/20'],
                                            'ditolak'             => ['label' => 'Ditolak', 'class' => 'bg-[#ed6060]/10 text-[#ed6060] border-[#ed6060]/20'],
                                            default               => ['label' => ucwords(str_replace('_', ' ', $customer->status)), 'class' => 'bg-[#f8f9fa] text-[#8a969c] border-[#dee2e6] dark:bg-[#15151b] dark:border-[#37394d]']
                                        };
                                    @endphp
                                    <span class="inline-flex rounded border px-2.5 py-1 text-[10px] md:text-[11px] font-bold uppercase {{ $statusFormat['class'] }}">
                                        {{ $statusFormat['label'] }}
                                    </span>
                                </td>
                                <td class="md:px-6 md:py-4 md:text-center mt-3 md:mt-0 block md:table-cell">
                                    <a href="{{ route('marketing.tracking.show', $customer->service?->id ?? $customer->id) }}" wire:navigate class="w-full md:w-auto inline-flex justify-center items-center btn-boron btn-boron-outline-primary !px-4 !py-2.5 md:!px-3 md:!py-1.5 text-sm md:text-xs rounded-lg md:rounded">
                                        <i class="ti ti-arrow-right md:hidden mr-1 text-lg"></i> 
                                        {{ $showCancelled ? 'Lihat Detail' : 'Detail & Proses' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row">
                                <td colspan="6" class="block md:table-cell px-6 py-12 text-center text-[#8a969c]">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="ti ti-inbox text-4xl mb-2 opacity-50"></i>
                                        <p>{{ $showCancelled ? 'Tidak ada data registrasi yang dibatalkan atau ditolak.' : 'Belum ada data pendaftar layanan internet baru.' }}</p>
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