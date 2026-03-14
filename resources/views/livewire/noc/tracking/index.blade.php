<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Antrean SPK & Instalasi') }}</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">{{ __('Daftar Surat Perintah Kerja (SPK) yang harus dikerjakan oleh tim NOC.') }}</p>
        </div>
    </div>

    <div class="boron-card">
        <div class="boron-card-body p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                    <thead class="bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">TENGGAT WAKTU (DUE)</th>
                            <th class="px-6 py-4 font-semibold">NO. SPK</th>
                            <th class="px-6 py-4 font-semibold">PELANGGAN</th>
                            <th class="px-6 py-4 font-semibold">LAYANAN</th>
                            <th class="px-6 py-4 font-semibold">STATUS</th>
                            <th class="px-6 py-4 text-center font-semibold">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($customers as $cust)
                            <tr class="hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium {{ $cust->spk && \Carbon\Carbon::parse($cust->spk->due_date)->isPast() ? 'text-[#ed6060]' : 'text-[#ebb751]' }}">
                                    @if($cust->spk && $cust->spk->due_date)
                                        {{ \Carbon\Carbon::parse($cust->spk->due_date)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-[#1e5d87] dark:text-[#60addf]">
                                    {{ $cust->spk->spk_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-[#313a46] dark:text-white">{{ $cust->company_name }}</p>
                                    <p class="text-xs text-[#8a969c]">{{ $cust->installation_address ?? $cust->company_address }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $cust->service_type }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($cust->status === 'proses_instalasi')
                                        <span class="rounded bg-[#ed6060]/10 px-2.5 py-1 text-xs font-semibold text-[#ed6060] animate-pulse ring-2 ring-[#ed6060]/50">Tugas Baru (Instalasi)</span>
                                    @elseif($cust->status === 'proses_aktivasi')
                                        <span class="rounded bg-[#ebb751]/10 px-2.5 py-1 text-xs font-semibold text-[#ebb751]">Tahap Aktivasi</span>
                                    @elseif($cust->status === 'review_baa')
                                        <span class="rounded bg-[#60addf]/10 px-2.5 py-1 text-xs font-semibold text-[#60addf]">Review BAA Internal</span>
                                    @elseif($cust->status === 'menunggu_baa')
                                        <span class="rounded bg-[#8a969c]/10 px-2.5 py-1 text-xs font-semibold text-[#8a969c]">Tunggu TTD Pelanggan</span>
                                    @elseif($cust->status === 'verifikasi_baa')
                                        <span class="rounded bg-[#70bb63]/10 px-2.5 py-1 text-xs font-semibold text-[#70bb63]">Verifikasi Marketing</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('noc.tracking.show', $cust->id) }}" wire:navigate class="btn-boron btn-boron-outline-primary !px-3 !py-1 text-xs">
                                        Buka SPK
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-[#8a969c]">
                                    Belum ada antrean pekerjaan untuk tim NOC saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($customers->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d]">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>