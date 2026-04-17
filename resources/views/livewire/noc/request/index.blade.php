<div class="py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div>
            <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">Antrean Eksekusi Jaringan</h4>
            <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">Daftar Surat Perintah Kerja (SPK) dari Marketing yang harus dieksekusi.</p>
        </div>
    </div>

    <div class="boron-card">
        <div class="boron-card-body p-0">
            <div class="w-full">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5] block md:table">
                    <thead class="hidden md:table-header-group bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">NO. SPK / PELANGGAN</th>
                            <th class="px-6 py-4 font-semibold">JENIS PEKERJAAN</th>
                            <th class="px-6 py-4 font-semibold">DEADLINE</th>
                            <th class="px-6 py-4 font-semibold">STATUS</th>
                            <th class="px-6 py-4 text-center font-semibold">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($requests as $req)
                            <tr class="flex flex-col md:table-row border-b border-[#e7e9eb] md:border-none dark:border-[#37394d] p-5 md:p-0 gap-3 md:gap-0 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">SPK</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold text-[#1e5d87] text-xs mb-0.5"><i class="ti ti-file-certificate"></i> SPK/{{ $req->request_number }}</p>
                                        <p class="font-bold md:font-medium text-[#313a46] dark:text-white">{{ $req->customer->company_name }}</p>
                                    </div>
                                </td>

                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Jenis Pekerjaan</span>
                                    <div class="text-right md:text-left">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold {{ $req->request_type === 'Upgrade' ? 'bg-[#70bb63]/10 text-[#70bb63]' : ($req->request_type === 'Downgrade' ? 'bg-[#ebb751]/10 text-[#ebb751]' : 'bg-[#ed6060]/10 text-[#ed6060]') }}">
                                            <i class="ti {{ $req->request_type === 'Upgrade' ? 'ti-arrow-up-right' : ($req->request_type === 'Downgrade' ? 'ti-arrow-down-right' : 'ti-power') }}"></i>
                                            {{ $req->request_type }}
                                        </span>
                                        <div class="text-[11px] font-medium text-[#8a969c] mt-1">{{ $req->old_bandwidth }} <i class="ti ti-arrow-right"></i> <strong class="text-[#313a46] dark:text-white">{{ $req->new_bandwidth }}</strong></div>
                                    </div>
                                </td>

                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Deadline</span>
                                    @if($req->deadline_date)
                                        <span class="text-sm font-bold {{ \Carbon\Carbon::parse($req->deadline_date)->isPast() ? 'text-[#ed6060]' : 'text-[#313a46] dark:text-white' }}">
                                            <i class="ti ti-calendar-due"></i> {{ \Carbon\Carbon::parse($req->deadline_date)->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-sm font-medium text-[#8a969c]">-</span>
                                    @endif
                                </td>

                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Status</span>
                                    @if($req->status === 'proses_upgrade')
                                        <span class="text-xs font-bold text-[#ebb751] bg-[#ebb751]/10 border border-[#ebb751]/20 px-2.5 py-1 rounded-md animate-pulse">Tugas Baru Masuk</span>
                                    @elseif($req->status === 'pembuatan_bau')
                                        <span class="text-xs font-bold text-[#1e5d87] bg-[#1e5d87]/10 border border-[#1e5d87]/20 px-2.5 py-1 rounded-md">Generate BAU</span>
                                    @elseif($req->status === 'menunggu_ttd_bau')
                                        <span class="text-xs font-bold text-[#60addf] bg-[#60addf]/10 border border-[#60addf]/20 px-2.5 py-1 rounded-md">Menunggu TTD BAU</span>
                                    @elseif($req->status === 'selesai')
                                        <span class="text-xs font-bold text-[#70bb63] bg-[#70bb63]/10 border border-[#70bb63]/20 px-2.5 py-1 rounded-md">Selesai</span>
                                    @else
                                        <span class="text-xs font-semibold text-[#8a969c] bg-gray-100 px-2.5 py-1 rounded-md dark:bg-white/5">{{ str_replace('_', ' ', strtoupper($req->status)) }}</span>
                                    @endif
                                </td>

                                <td class="md:px-6 md:py-4 md:text-center mt-3 md:mt-0 block md:table-cell">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Catatan: Pastikan Anda membuat file Livewire NOC/Request/Show dan menambahkan rutenya nanti --}}
                                        <a href="{{ route('noc.request.show', $req->id) }}" wire:navigate class="w-full sm:w-auto btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-1.5 !px-3 text-xs shadow-sm flex justify-center items-center gap-1.5 dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d]">
                                            <i class="ti ti-tools text-base text-[#1e5d87]"></i> Kerjakan Tugas
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row">
                                <td colspan="5" class="block md:table-cell px-6 py-12 text-center text-[#8a969c]">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="ti ti-router text-4xl mb-2 opacity-50"></i>
                                        <p>Belum ada tugas SPK yang masuk untuk NOC.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($requests->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d]">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>