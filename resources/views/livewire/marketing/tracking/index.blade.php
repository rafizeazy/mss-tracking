<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Tracking Antrean Registrasi') }}</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">{{ __('Daftar pelanggan baru yang menunggu verifikasi data dan dokumen.') }}</p>
        </div>
    </div>

    <div class="boron-card">
        <div class="boron-card-body p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                    <thead class="bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">TANGGAL REGISTRASI</th>
                            <th class="px-6 py-4 font-semibold">NAMA PERUSAHAAN</th>
                            <th class="px-6 py-4 font-semibold">PIC / KONTAK</th>
                            <th class="px-6 py-4 font-semibold">LAYANAN</th>
                            <th class="px-6 py-4 font-semibold">STATUS</th>
                            <th class="px-6 py-4 text-center font-semibold">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $customer->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 font-medium text-[#313a46] dark:text-white">
                                    {{ $customer->company_name }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium">{{ $customer->user->name }}</p>
                                    <p class="text-xs text-[#8a969c]">{{ $customer->phone }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- PERUBAHAN DI SINI: Menampilkan Bandwidth dan Tipe Layanan --}}
                                    <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->bandwidth }}</p>
                                    <p class="text-xs text-[#8a969c]">{{ $customer->service_type }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                            'ditolak'             => ['label' => 'Ditolak', 'class' => 'bg-[#ed6060]/10 text-[#ed6060] border-[#ed6060]/20'],
                                            default               => ['label' => ucwords(str_replace('_', ' ', $customer->status)), 'class' => 'bg-[#f8f9fa] text-[#8a969c] border-[#dee2e6] dark:bg-[#15151b] dark:border-[#37394d]']
                                        };
                                    @endphp
                                    <span class="inline-flex rounded border px-2.5 py-1 text-[11px] font-bold uppercase {{ $statusFormat['class'] }}">
                                        {{ $statusFormat['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('marketing.tracking.show', $customer->id) }}" wire:navigate class="btn-boron btn-boron-outline-primary !px-3 !py-1 text-xs">
                                        Detail & Proses
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-[#8a969c]">
                                    Belum ada data pendaftar layanan internet.
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