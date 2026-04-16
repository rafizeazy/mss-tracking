<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">
                Verifikasi Tagihan: {{ $customer->company_name }}
            </h4>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('form.formulir', $customer->id) }}" target="_blank" class="btn-boron !py-1.5 flex items-center gap-1 bg-[#1e5d87]/10 text-[#1e5d87] hover:bg-[#1e5d87]/20 border border-[#1e5d87]/20 transition-colors font-medium dark:bg-[#60addf]/10 dark:text-[#60addf] dark:border-[#60addf]/20">
                <i class="ti ti-file-text"></i> Cetak Formulir
            </a>
            <a href="{{ route('finance.tracking.index') }}" wire:navigate class="btn-boron btn-boron-outline-secondary !py-1.5">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 rounded-[0.3rem] border border-[#70bb63]/30 bg-[#70bb63]/10 p-3 text-sm text-[#70bb63]">
            <i class="ti ti-check mr-1"></i> {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-[0.3rem] border border-[#ed6060]/30 bg-[#ed6060]/10 p-3 text-sm text-[#ed6060]">
            <i class="ti ti-x mr-1"></i> {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-3">
        
        <div class="space-y-6 xl:col-span-2">
            
            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">Ringkasan Data (Telah Disetujui Marketing)</h5>
                </div>
                <div class="boron-card-body p-5 grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Nama Perusahaan</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->company_name }}</p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Kapasitas & Layanan</p>
                        <p class="font-bold text-[#1e5d87] dark:text-[#60addf]">{{ $customer->bandwidth }}</p>
                        <p class="text-[10px] text-[#8a969c] leading-tight mt-0.5">{{ $customer->service_type }}</p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-xs text-[#8a969c] uppercase mb-1">PIC Keuangan</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->finance_name ?? '-' }}</p>
                        <p class="text-xs text-[#8a969c] mt-0.5">
                            @if($customer->finance_phone) {{ $customer->finance_phone }} @endif
                            @if($customer->finance_email) | {{ $customer->finance_email }} @endif
                        </p>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-xs text-[#8a969c] uppercase mb-1">Alamat Penagihan (Invoice)</p>
                        <p class="font-medium text-[#313a46] dark:text-white">{{ $customer->billing_address ?? $customer->company_address }}</p>
                    </div>
                </div>
            </div>
            
            @if($customer->payment_proof_file_path)
                <div class="boron-card {{ $customer->status === 'verifikasi_pembayaran' ? 'border-2 border-[#ebb751] shadow-lg' : 'border border-[#e7e9eb] dark:border-[#37394d]' }}">
                    <div class="boron-card-header {{ $customer->status === 'verifikasi_pembayaran' ? 'bg-[#ebb751]/10 border-b border-[#ebb751]/20' : 'border-b border-[#e7e9eb] dark:border-[#37394d]' }} pb-3 flex justify-between items-center">
                        <h5 class="font-bold {{ $customer->status === 'verifikasi_pembayaran' ? 'text-[#b58c3d] dark:text-[#ebb751]' : 'text-[#313a46] dark:text-white' }}">
                            <i class="ti ti-photo mr-1"></i> Lampiran Bukti Transfer Pelanggan
                        </h5>
                        @if($customer->status !== 'verifikasi_pembayaran')
                            <span class="rounded bg-[#70bb63]/10 px-2 py-1 text-[10px] font-bold text-[#70bb63] uppercase">Arsip Disetujui</span>
                        @endif
                    </div>
                    <div class="boron-card-body p-5 bg-[#f8f9fa] dark:bg-[#15151b]">
                        <div x-data="{ openImage: false }" class="w-full flex justify-center">
                            {{-- Gambar Utama --}}
                            <img @click="openImage = true" src="{{ asset('storage/' . $customer->payment_proof_file_path) }}" alt="Bukti Transfer" class="max-w-full max-h-[500px] rounded border border-[#dee2e6] shadow-sm cursor-zoom-in hover:opacity-90 transition-opacity dark:border-[#37394d]">
                            
                            {{-- Modal Zoom Image --}}
                            <div x-show="openImage" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/90 p-4" x-transition.opacity>
                                <button @click="openImage = false" class="absolute top-4 right-4 text-white hover:text-gray-300">
                                    <i class="ti ti-x text-4xl"></i>
                                </button>
                                <img src="{{ asset('storage/' . $customer->payment_proof_file_path) }}" alt="Bukti Transfer Zoom" @click.away="openImage = false" class="max-h-[90vh] max-w-[90vw] rounded shadow-2xl">
                            </div>
                        </div>
                        <p class="text-center text-xs text-[#8a969c] mt-3"><i class="ti ti-zoom-in"></i> Klik gambar untuk memperbesar</p>
                    </div>
                </div>
            @endif

            @if($showInvoicePreview && $customer->status === 'menunggu_invoice')
                <div class="boron-card bg-white dark:bg-[#15151b] border-2 border-[#669776] shadow-xl p-8">
                    <div class="flex justify-between items-start border-b border-[#e7e9eb] pb-6 dark:border-[#37394d]">
                        <div>
                            <h2 class="text-2xl font-bold text-[#313a46] dark:text-white uppercase tracking-wider">INVOICE</h2>
                            <p class="text-sm text-[#8a969c] mt-1">INV-REG-{{ date('Ymd') }}-{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="text-right">
                            <h4 class="font-bold text-[#313a46] dark:text-white">PT Media Solusi Sukses</h4>
                            <p class="text-sm text-[#8a969c]">Tanggal Terbit: {{ date('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <p class="text-xs text-[#8a969c] uppercase font-semibold mb-2">Ditagihkan Kepada:</p>
                        <h5 class="font-bold text-[#313a46] dark:text-white">{{ $customer->company_name }}</h5>
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5]">{{ $customer->billing_address ?? $customer->company_address }}</p>
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5]">UP: {{ $customer->finance_name ?? $customer->user->name }}</p>
                        <p class="text-xs text-[#8a969c] mt-0.5">
                            @if($customer->finance_phone) {{ $customer->finance_phone }} @endif
                            @if($customer->finance_email) | {{ $customer->finance_email }} @endif
                        </p>
                    </div>

                    <div class="mt-8 border border-[#e7e9eb] rounded dark:border-[#37394d]">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-[#f8f9fa] dark:bg-[#1e1f27]">
                                <tr>
                                    <th class="p-3 font-semibold text-[#313a46] dark:text-white">Deskripsi Layanan</th>
                                    <th class="p-3 font-semibold text-right text-[#313a46] dark:text-white">Jumlah (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                                <tr>
                                    <td class="p-3">
                                        Biaya Registrasi / Instalasi Awal Jaringan<br>
                                        <small class="text-[#8a969c] font-semibold">{{ $customer->bandwidth }}</small><br>
                                        <small class="text-[#8a969c]">{{ $customer->service_type }}</small>
                                    </td>
                                    <td class="p-3 text-right font-medium text-[#313a46] dark:text-white">{{ number_format($customer->registration_fee, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <div class="w-full sm:w-1/2">
                            <div class="flex justify-between py-2 text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between py-2 text-sm text-[#4c4c5c] dark:text-[#aab8c5] border-b border-[#e7e9eb] dark:border-[#37394d]">
                                <span>PPN (0%):</span>
                                <span>Rp 0</span>
                            </div>
                            <div class="flex justify-between py-3 text-lg font-bold text-[#313a46] dark:text-white">
                                <span>TOTAL TAGIHAN:</span>
                                <span>Rp {{ number_format($grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <div class="space-y-6">
            
            @if($customer->status === 'menunggu_invoice')
                <div class="boron-card border-2 border-[#60addf] shadow-lg">
                    <div class="boron-card-header bg-[#60addf]/10 border-b border-[#60addf]/20 pb-3">
                        <h5 class="font-bold text-[#1e5d87] dark:text-[#60addf]"><i class="ti ti-file-invoice"></i> Aksi Penagihan</h5>
                    </div>
                    <div class="boron-card-body p-5">
                        @if(!$showInvoicePreview)
                            <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mb-5">
                                Sistem akan mengkalkulasikan biaya registrasi. Silakan pratinjau invoice sebelum dikirim. Anda juga dapat menggratiskan (Free) biaya registrasi jika diperlukan.
                            </p>
                            
                            <div class="flex flex-col gap-3">
                                <button wire:click="generatePreview" class="w-full btn-boron btn-boron-outline-primary flex justify-center gap-2 !py-2.5">
                                    <i class="ti ti-search text-lg"></i> Cek & Preview Invoice
                                </button>
                                
                                <button 
                            onclick="if(confirm('Apakah Anda yakin ingin menggratiskan biaya registrasi ini? Status pelanggan akan langsung dilempar ke tim Instalasi (NOC) tanpa harus menunggu proses pembayaran.')) { @this.call('markAsFree') }"
                            class="w-full btn-boron bg-transparent text-[#70bb63] border border-[#70bb63] hover:bg-[#70bb63]/10 flex justify-center gap-2 !py-2.5 transition-colors"
                        >
                            <i class="ti ti-gift text-lg"></i> Registrasi Free (Skip Tagihan)
                        </button>
                            </div>
                        @else
                            <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mb-5">
                                Jika angka yang tertera pada pratinjau invoice di sebelah kiri sudah benar, Anda dapat langsung mengirimkannya ke Dashboard Pelanggan.
                            </p>
                            <div class="flex flex-col gap-3">
                                <button wire:click="sendInvoice" class="w-full btn-boron btn-boron-primary flex justify-center gap-2 !py-2.5 shadow-lg shadow-[#669776]/30">
                                    <i class="ti ti-send text-lg"></i> Kirim Invoice ke Pelanggan
                                </button>
                                <button wire:click="$set('showInvoicePreview', false)" class="w-full btn-boron btn-boron-outline-secondary flex justify-center gap-2 !py-2.5">
                                    <i class="ti ti-arrow-left text-lg"></i> Batal / Kembali
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif($customer->status === 'menunggu_pembayaran')
                <div class="boron-card border border-[#ebb751]/30 bg-[#ebb751]/10">
                    <div class="boron-card-body p-5 text-center">
                        <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-[#ebb751] text-white shadow-lg shadow-[#ebb751]/30 mb-3">
                            <i class="ti ti-hourglass-high text-2xl animate-pulse"></i>
                        </div>
                        <h5 class="font-bold text-[#b58c3d] dark:text-[#ebb751]">Menunggu Pembayaran</h5>
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mt-1">
                            Invoice berhasil dikirim. Saat ini sedang menunggu pelanggan untuk melakukan transfer dan mengunggah bukti pembayaran.
                        </p>
                    </div>
                </div>
            @elseif($customer->status === 'verifikasi_pembayaran')
                <div class="boron-card border-2 border-[#ebb751] shadow-lg">
                    <div class="boron-card-header bg-[#ebb751]/10 border-b border-[#ebb751]/20 pb-3">
                        <h5 class="font-bold text-[#b58c3d] dark:text-[#ebb751]"><i class="ti ti-search"></i> Verifikasi Pembayaran</h5>
                    </div>
                    <div class="boron-card-body p-5">
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mb-5">
                            Pelanggan telah mengunggah bukti pembayaran. Silakan cek gambar di sebelah kiri dan cocokan dengan mutasi rekening perusahaan.
                        </p>
                        <div x-data="{ confirmType: null }" class="flex flex-col gap-3">

                            <template x-if="!confirmType">
                                <div class="flex flex-col gap-3">
                                    <button @click="confirmType = 'approve'" class="w-full btn-boron btn-boron-primary flex justify-center gap-2 py-2.5 shadow-lg shadow-[#669776]/30">
                                        <i class="ti ti-check text-lg"></i> Pembayaran Valid (Setujui)
                                    </button>
                                    <button @click="confirmType = 'reject'" class="w-full btn-boron bg-transparent text-[#ed6060] border border-[#ed6060] hover:bg-[#ed6060]/10 flex justify-center gap-2 py-2.5 transition-colors">
                                        <i class="ti ti-x text-lg"></i> Tolak (Tidak Valid)
                                    </button>
                                </div>
                            </template>

                            <template x-if="confirmType">
                                <div>
                                    <div class="fixed inset-0 z-[9990] bg-black/40 backdrop-blur-sm" @click="confirmType = null"></div>
                                    
                                    <div class="fixed inset-0 z-[9991] flex items-center justify-center p-4">
                                        <div class="w-full max-w-sm rounded-[0.5rem] bg-white p-6 shadow-2xl dark:bg-[#1e1e2a]">
                                            <div class="mb-4 flex items-center gap-3">
                                                <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-[#ebb751]/10">
                                                    <i class="ti ti-alert-triangle text-xl text-[#ebb751]"></i>
                                                </div>
                                                <h5 class="font-semibold text-[#313a46] dark:text-white">Konfirmasi Aksi</h5>
                                            </div>
                                            <p class="mb-6 text-sm leading-relaxed text-[#4c4c5c] dark:text-[#aab8c5]" x-text="confirmType === 'approve' ? 'Dana sudah masuk ke rekening perusahaan? Lanjutkan layanan ke tim Instalasi?' : 'Tolak bukti ini? Pelanggan akan diminta mengunggah ulang bukti transfer yang valid.'"></p>
                                            <div class="flex justify-end gap-3">
                                                <button @click="confirmType = null" class="btn-boron border border-[#dee2e6] px-4 py-2 text-sm text-[#313a46] hover:bg-[#f6f7fb] dark:border-[#37394d] dark:text-white dark:hover:bg-white/5">
                                                    Batal
                                                </button>
                                                <button
                                                    @click="confirmType === 'approve' ? $wire.approvePayment() : $wire.rejectPayment(); confirmType = null"
                                                    :class="confirmType === 'approve' ? 'btn-boron-primary shadow-md shadow-[#669776]/30' : 'bg-[#ed6060] text-white hover:bg-[#d95454]'"
                                                    class="btn-boron px-4 py-2 text-sm"
                                                >
                                                    <span x-text="confirmType === 'approve' ? 'Ya, Konfirmasi' : 'Ya, Tolak'"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                </div>
            @else
                <div class="boron-card border border-[#70bb63]/30 bg-[#70bb63]/10">
                    <div class="boron-card-body p-5 text-center">
                        <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-[#70bb63] text-white shadow-lg shadow-[#70bb63]/30 mb-3">
                            <i class="ti ti-check text-2xl"></i>
                        </div>
                        <h5 class="font-bold text-[#4a8a3f] dark:text-[#70bb63]">Pembayaran Telah Lunas</h5>
                        <p class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] mt-1">
                            Layanan ini sudah dilempar ke tim Instalasi (NOC) untuk proses pemasangan.
                        </p>
                    </div>
                </div>
            @endif

            <div class="boron-card h-fit">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">Progres Layanan</h5>
                </div>
                <div class="boron-card-body p-6">
                @php
                    $statusOrder = [
                        'menunggu_verifikasi', 'menunggu_invoice', 'menunggu_pembayaran', 
                        'verifikasi_pembayaran', 'pembayaran_disetujui', 'proses_instalasi', 
                        'proses_aktivasi', 'review_baa', 'menunggu_baa', 'verifikasi_baa', 'selesai'
                    ];
                    $currentIndex = array_search($customer->status, $statusOrder);
                    
                    $workflows = [
                        ['id' => 'menunggu_verifikasi', 'title' => 'Menunggu Verifikasi', 'icon' => 'ti-shield-check'],
                        ['id' => 'menunggu_invoice', 'title' => 'Menunggu Invoice', 'icon' => 'ti-file-invoice'],
                        ['id' => 'menunggu_pembayaran', 'title' => 'Menunggu Pembayaran', 'icon' => 'ti-receipt'],
                        ['id' => 'verifikasi_pembayaran', 'title' => 'Verifikasi Pembayaran', 'icon' => 'ti-search'],
                        ['id' => 'pembayaran_disetujui', 'title' => 'Pembayaran Disetujui', 'icon' => 'ti-cash'],
                        ['id' => 'proses_instalasi', 'title' => 'Proses Instalasi', 'icon' => 'ti-router'],
                        ['id' => 'proses_aktivasi', 'title' => 'Proses Aktivasi', 'icon' => 'ti-wifi'],
                        ['id' => 'review_baa', 'title' => 'Review BAA (NOC)', 'icon' => 'ti-eye'],
                        ['id' => 'menunggu_baa', 'title' => 'Tunggu TTD Pelanggan', 'icon' => 'ti-signature'],
                        ['id' => 'verifikasi_baa', 'title' => 'Verifikasi Akhir BAA', 'icon' => 'ti-file-check'],
                        ['id' => 'selesai', 'title' => 'Selesai & Aktif', 'icon' => 'ti-circle-check'],
                    ];
                @endphp

                    <div class="relative ml-3 border-l-2 border-[#e7e9eb] dark:border-[#37394d]">
                        @foreach($workflows as $index => $step)
                            @php
                                $stepIndex = array_search($step['id'], $statusOrder);
                                if ($customer->status === 'ditolak') {
                                    $state = 'pending';
                                } elseif ($stepIndex < $currentIndex) {
                                    $state = 'completed';
                                } elseif ($stepIndex === $currentIndex) {
                                    $state = 'active';
                                } else {
                                    $state = 'pending';
                                }
                            @endphp

                            <div class="mb-6 ml-8 relative last:mb-0">
                                @if($state === 'completed')
                                    <span class="absolute -left-[2.85rem] flex size-10 items-center justify-center rounded-full bg-[#669776] text-white ring-4 ring-white dark:ring-[#15151b]">
                                        <i class="ti ti-check text-xl"></i>
                                    </span>
                                @elseif($state === 'active')
                                    <span class="absolute -left-[2.85rem] flex size-10 items-center justify-center rounded-full bg-[#60addf] text-white ring-4 ring-white dark:ring-[#15151b] shadow-[0_0_15px_rgba(96,173,223,0.5)]">
                                        <i class="ti {{ $step['icon'] }} text-xl animate-pulse"></i>
                                    </span>
                                @else
                                    <span class="absolute -left-[2.85rem] flex size-10 items-center justify-center rounded-full bg-[#f8f9fa] border-2 border-[#dee2e6] text-[#a1a9b1] ring-4 ring-white dark:bg-[#1e1f27] dark:border-[#37394d] dark:ring-[#15151b]">
                                        <i class="ti {{ $step['icon'] }} text-xl"></i>
                                    </span>
                                @endif

                                <div>
                                    <h5 class="text-sm font-semibold pt-2 {{ $state === 'active' ? 'text-[#60addf]' : ($state === 'completed' ? 'text-[#313a46] dark:text-white' : 'text-[#8a969c]') }}">
                                        {{ $step['title'] }}
                                    </h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>