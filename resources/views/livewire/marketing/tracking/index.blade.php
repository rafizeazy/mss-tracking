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
                                    {{ $customer->service_type }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($customer->status === 'menunggu_verifikasi')
                                        <span class="badge-soft-warning px-2.5 py-1 text-xs">Menunggu Verifikasi</span>
                                    @elseif($customer->status === 'ditolak')
                                        <span class="badge-soft-danger px-2.5 py-1 text-xs">Ditolak</span>
                                    @else
                                        <span class="badge-soft-success px-2.5 py-1 text-xs">Telah Diverifikasi</span>
                                    @endif
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
            
            {{-- Pagination Links --}}
            @if($customers->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d]">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </div>
</div>