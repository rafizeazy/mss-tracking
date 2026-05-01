<div class="py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div>
            <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">{{ __('Antrean Penagihan & Invoice') }}</h4>
            <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">{{ __('Daftar pelanggan yang menunggu penerbitan Invoice dan verifikasi pembayaran.') }}</p>
        </div>
    </div>

    <div class="boron-card">
        <div class="boron-card-body p-0">
            <div class="w-full">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5] block md:table">
                    
                    <thead class="hidden md:table-header-group bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">TANGGAL APPROVED</th>
                            <th class="px-6 py-4 font-semibold">PERUSAHAAN & LAYANAN</th>
                            <th class="px-6 py-4 font-semibold">BIAYA REGISTRASI</th>
                            <th class="px-6 py-4 font-semibold">BIAYA BULANAN</th>
                            <th class="px-6 py-4 font-semibold">STATUS</th>
                            <th class="px-6 py-4 text-center font-semibold">AKSI</th>
                        </tr>
                    </thead>
                    
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($services as $service)
                            <tr class="flex flex-col md:table-row border-b border-[#e7e9eb] md:border-none dark:border-[#37394d] p-5 md:p-0 gap-3 md:gap-0 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Tgl Approved</span>
                                    <span class="font-medium md:font-normal text-[#313a46] dark:text-white md:text-inherit">{{ $service->updated_at->translatedFormat('d M Y, H:i') }}</span>
                                </td>
                                
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Perusahaan & Layanan</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold md:font-medium text-[#313a46] dark:text-white">{{ $service->customer->company_name }}</p>
                                        <p class="text-[11px] text-[#8a969c] mt-0.5">{{ $service->bandwidth }} • {{ $service->service_type }}</p>
                                    </div>
                                </td>
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap font-bold md:font-medium text-[#313a46] dark:text-white border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">B. Registrasi</span>
                                    <span>Rp {{ number_format($service->registration_fee ?? 0, 0, ',', '.') }}</span>
                                </td>
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap font-bold md:font-medium text-[#70bb63] md:text-[#313a46] md:dark:text-white border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">B. Bulanan</span>
                                    <span>Rp {{ number_format($service->monthly_fee ?? 0, 0, ',', '.') }}</span>
                                </td>
                                
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap pb-1 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Status</span>
                                    @php
                                        $statusFormat = match($service->customer->status) {
                                            'menunggu_invoice'    => ['label' => 'Buat Invoice', 'class' => 'bg-[#ed6060]/10 text-[#ed6060] border-[#ed6060]/20 ring-2 ring-[#ed6060]/50 animate-pulse'],
                                            'menunggu_pembayaran' => ['label' => 'Tunggu Transfer', 'class' => 'bg-[#ebb751]/10 text-[#ebb751] border-[#ebb751]/20'],
                                            'verifikasi_pembayaran'=> ['label' => 'Cek Bukti TF', 'class' => 'bg-[#60addf]/10 text-[#60addf] border-[#60addf]/20 ring-2 ring-[#60addf]/50 animate-pulse'],
                                            'pembayaran_disetujui'=> ['label' => 'Pembayaran Lunas', 'class' => 'bg-[#70bb63]/10 text-[#70bb63] border-[#70bb63]/20'],
                                            default               => ['label' => ucwords(str_replace('_', ' ', $service->customer->status)), 'class' => 'bg-[#f8f9fa] text-[#8a969c] border-[#dee2e6] dark:bg-[#15151b] dark:border-[#37394d]']
                                        };
                                    @endphp
                                    <span class="inline-flex rounded border px-2.5 py-1 text-[10px] md:text-[11px] font-bold uppercase {{ $statusFormat['class'] }}">
                                        {{ $statusFormat['label'] }}
                                    </span>
                                </td>
                                
                                <td class="md:px-6 md:py-4 md:text-center mt-3 md:mt-0 block md:table-cell">
                                    <a href="{{ route('finance.tracking.show', $service->id) }}" wire:navigate class="w-full md:w-auto inline-flex justify-center items-center btn-boron btn-boron-outline-primary !px-4 !py-2.5 md:!px-3 md:!py-1 text-sm md:text-xs rounded-lg md:rounded">
                                        <i class="ti ti-arrow-right md:hidden mr-1 text-lg"></i> Detail Penagihan
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row">
                                <td colspan="6" class="block md:table-cell px-6 py-12 text-center text-[#8a969c]">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="ti ti-inbox text-4xl mb-2 opacity-50"></i>
                                        <p>Belum ada antrean penagihan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($services->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d] flex justify-center md:justify-start">
                    <div class="w-full overflow-x-auto md:overflow-visible">
                        {{ $services->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>