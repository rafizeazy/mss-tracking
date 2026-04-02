<div class="py-6">
    <div class="mb-6">
        <h4 class="text-xl font-bold text-[#313a46] dark:text-white">Tagihan & Pembayaran</h4>
        <p class="text-sm text-[#8a969c] mt-1">Riwayat seluruh tagihan layanan internet dan status pembayaran Anda.</p>
    </div>

    @if(!$customer || $customer->status !== 'selesai' || !$customer->baa)
        {{-- STATE: BELUM AKTIF --}}
        <div class="rounded-xl border border-[#e7e9eb] bg-white p-8 text-center shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
            <div class="mx-auto flex size-20 items-center justify-center rounded-full bg-[#f8f9fa] dark:bg-[#15151b]">
                <i class="ti ti-receipt-off text-4xl text-[#a1a9b1]"></i>
            </div>
            <h5 class="mt-4 text-lg font-bold text-[#313a46] dark:text-white">Belum Ada Tagihan</h5>
            <p class="mx-auto mt-2 max-w-md text-sm text-[#8a969c]">
                Layanan Anda saat ini belum aktif sepenuhnya atau BAA belum diterbitkan.
            </p>
        </div>

    @else
        {{-- MASA TRIAL ALERT --}}
        @if($invoiceData && $invoiceData['status'] === 'TRIAL')
            <div class="mb-6 rounded-xl border border-[#70bb63]/30 bg-[#70bb63]/10 p-5 text-[#4a8a3f] dark:text-[#70bb63] shadow-sm flex gap-4 items-center">
                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#70bb63]/20 text-2xl">
                    <i class="ti ti-gift"></i>
                </div>
                <div>
                    <h6 class="font-bold text-base">Masa Trial Aktif! (Akses Gratis)</h6>
                    <p class="text-sm mt-0.5 text-[#4a8a3f]/80 dark:text-[#70bb63]/80">
                        Layanan aktif sejak <strong>{{ $invoiceData['activation_date'] }}</strong>. Masa trial Anda berlaku hingga <strong>{{ $invoiceData['trial_end_date'] }}</strong>. Tagihan akan diterbitkan setelah masa trial berakhir.
                    </p>
                </div>
            </div>
        @endif

        {{-- TABEL RIWAYAT TAGIHAN --}}
        <div class="boron-card">
            <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d] bg-[#f8f9fa] dark:bg-white/5">
                <h5 class="font-semibold text-[#313a46] dark:text-white text-sm"><i class="ti ti-history text-[#1e5d87] mr-1"></i> Riwayat Transaksi</h5>
            </div>
            
            <div class="overflow-x-auto boron-scrollbar">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                    <thead class="bg-[#fcfcfd] text-xs uppercase text-[#8a969c] dark:bg-[#15151b]">
                        <tr>
                            <th class="border-b border-[#e7e9eb] px-4 py-3 font-semibold dark:border-[#37394d]">Periode Tagihan</th>
                            <th class="border-b border-[#e7e9eb] px-4 py-3 font-semibold dark:border-[#37394d]">No. Invoice</th>
                            <th class="border-b border-[#e7e9eb] px-4 py-3 font-semibold dark:border-[#37394d]">Jatuh Tempo</th>
                            <th class="border-b border-[#e7e9eb] px-4 py-3 font-semibold text-right dark:border-[#37394d]">Total (Rp)</th>
                            <th class="border-b border-[#e7e9eb] px-4 py-3 font-semibold text-center dark:border-[#37394d]">Status</th>
                            <th class="border-b border-[#e7e9eb] px-4 py-3 font-semibold text-center dark:border-[#37394d]">Aksi / Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($invoiceData && $invoiceData['status'] !== 'TRIAL')
                            <tr class="hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors border-b border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                                <td class="px-4 py-4 font-medium text-[#313a46] dark:text-white">
                                    {{ $invoiceData['prorate_start'] }} - {{ $invoiceData['prorate_end'] }}
                                </td>
                                <td class="px-4 py-4">{{ $customer->invoice_number ?? 'INV-MSS/PRO/'.date('Y') }}</td>
                                <td class="px-4 py-4 text-[#ed6060] font-semibold">{{ $invoiceData['prorate_start'] }}</td>
                                <td class="px-4 py-4 text-right font-bold text-[#313a46] dark:text-white">
                                    {{ number_format($invoiceData['grand_total'], 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($invoiceData['status'] === 'UNPAID')
                                        <span class="rounded bg-[#ebb751]/10 px-2 py-1 text-[10px] font-bold uppercase text-[#ebb751] border border-[#ebb751]/20">Belum Dibayar</span>
                                    @else
                                        <span class="rounded bg-[#70bb63]/10 px-2 py-1 text-[10px] font-bold uppercase text-[#70bb63] border border-[#70bb63]/20">LUNAS</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('customer.invoice.pdf', $customer->id) }}" target="_blank" class="btn-boron !py-1 !px-2 bg-white border border-[#dee2e6] text-[#1e5d87] hover:bg-[#1e5d87] hover:text-white dark:bg-[#15151b] dark:border-[#37394d] transition-colors tooltip" title="Cetak/Lihat Invoice PDF">
                                            <i class="ti ti-file-invoice text-base"></i> Invoice
                                        </a>
                                        
                                        @if($invoiceData['status'] === 'PAID')
                                            <a href="#" class="btn-boron !py-1 !px-2 bg-white border border-[#dee2e6] text-[#70bb63] hover:bg-[#70bb63] hover:text-white dark:bg-[#15151b] dark:border-[#37394d] transition-colors" title="Kuitansi Pembayaran">
                                                <i class="ti ti-receipt text-base"></i> Kuitansi
                                            </a>
                                        @else
                                            <button class="btn-boron btn-boron-primary !py-1 !px-3 text-xs shadow-md shadow-[#669776]/30">
                                                Bayar
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                        
                        @if(!$invoiceData || $invoiceData['status'] === 'TRIAL')
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-[#8a969c]">
                                    Belum ada riwayat tagihan yang diterbitkan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>