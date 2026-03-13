<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">Antrian Aktivasi WiFi</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">Daftar pelanggan yang pembayarannya telah dikonfirmasi dan siap untuk proses instalasi/aktivasi.</p>
        </div>
    </div>

    <div class="boron-card">
        <div class="boron-card-body p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                    <thead class="bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Perusahaan</th>
                            <th class="px-6 py-4 font-semibold">Layanan</th>
                            <th class="px-6 py-4 font-semibold">Alamat Instalasi</th>
                            <th class="px-6 py-4 font-semibold">PIC Teknis</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-medium text-[#313a46] dark:text-white">
                                    {{ $customer->company_name }}
                                </td>
                                <td class="px-6 py-4">{{ $customer->service_type }}</td>
                                <td class="px-6 py-4 max-w-[200px] truncate">
                                    {{ $customer->installation_address ?? $customer->company_address }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $customer->technical_name ?? '-' }}<br>
                                    <span class="text-xs text-[#8a969c]">{{ $customer->technical_phone ?? '' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $badges = [
                                            'pembayaran_disetujui' => ['label' => 'Siap Instalasi', 'class' => 'badge-soft-primary'],
                                            'proses_instalasi'     => ['label' => 'Proses Instalasi', 'class' => 'badge-soft-warning'],
                                            'proses_aktivasi'      => ['label' => 'Proses Aktivasi', 'class' => 'badge-soft-info'],
                                            'menunggu_baa'         => ['label' => 'Menunggu BAA', 'class' => 'badge-soft-secondary'],
                                            'baa_terbit'           => ['label' => 'BAA Terbit', 'class' => 'badge-soft-success'],
                                            'selesai'              => ['label' => 'Selesai', 'class' => 'badge-soft-success'],
                                        ];
                                        $badge = $badges[$customer->status] ?? ['label' => $customer->status, 'class' => 'badge-soft-secondary'];
                                    @endphp
                                    <span class="{{ $badge['class'] }} px-2.5 py-1 text-xs">{{ $badge['label'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-[#8a969c]">
                                    <i class="ti ti-wifi-off text-3xl block mb-2"></i>
                                    Belum ada antrian aktivasi WiFi.
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
