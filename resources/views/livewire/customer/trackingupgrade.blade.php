@if($activeRequest)
<div class="mt-6 md:mt-8">
    <div class="boron-card shadow-sm rounded-3xl border border-[#e7e9eb] dark:border-[#37394d] overflow-hidden bg-white dark:bg-[#1e1f27]">
        <div class="p-6 md:p-8">
            <div class="mb-8 md:mb-10 border-b border-[#e7e9eb] pb-5 dark:border-[#37394d]">
                <h5 class="text-lg md:text-xl font-bold text-[#1e5d87] dark:text-[#60addf] flex items-center gap-2">
                    <i class="ti ti-activity"></i> Progres {{ $activeRequest->request_type }}
                </h5>
                <p class="text-sm text-[#8a969c] mt-1">No. Pengajuan: <span class="font-bold text-[#313a46] dark:text-white">{{ $activeRequest->request_number }}</span></p>
            </div>

            @php
                $reqSteps = [
                    'menunggu_approval' => ['title' => 'Pengiriman Form', 'desc' => 'Formulir berhasil dikirim, menunggu verifikasi Marketing.', 'icon' => 'ti-send'],
                    'form_disetujui' => ['title' => 'Form Disetujui', 'desc' => 'Pengajuan telah disetujui. Dokumen sedang disiapkan.', 'icon' => 'ti-check'],
                    'menunggu_ttd_pelanggan' => ['title' => 'Menunggu TTD Anda', 'desc' => 'Silakan download dokumen, tandatangani, dan upload kembali.', 'icon' => 'ti-signature'],
                    'verifikasi_ttd_pelanggan' => ['title' => 'Verifikasi Dokumen', 'desc' => 'Dokumen Anda sedang diverifikasi oleh tim kami.', 'icon' => 'ti-file-search'],
                    'proses_upgrade' => ['title' => 'Proses Pengerjaan', 'desc' => 'Tim NOC kami sedang memproses permintaan Anda di lokasi.', 'icon' => 'ti-router'],
                    'pembuatan_bau' => ['title' => 'Pembuatan Berita Acara', 'desc' => 'Pekerjaan teknis selesai. Menunggu draf Berita Acara.', 'icon' => 'ti-file-description'],
                    'menunggu_ttd_bau' => ['title' => 'Menunggu TTD Berita Acara', 'desc' => 'Silakan tandatangani Berita Acara penyelesaian pekerjaan.', 'icon' => 'ti-certificate'],
                    'verifikasi_ttd_bau' => ['title' => 'Verifikasi Akhir', 'desc' => 'Berita Acara sedang dicek secara final oleh tim Marketing.', 'icon' => 'ti-file-search'], 
                    'selesai' => ['title' => 'Selesai', 'desc' => 'Seluruh proses telah selesai. Terima kasih!', 'icon' => 'ti-circle-check'],
                ];
                
                $reqStatusOrder = array_keys($reqSteps);
                $reqCurrentIndex = array_search($activeRequest->status, $reqStatusOrder);
                if ($reqCurrentIndex === false && $activeRequest->status !== 'menunggu_pelanggan') $reqCurrentIndex = 0;
            @endphp

            <div class="space-y-0 pl-1 md:pl-2 relative">
                @foreach($reqSteps as $key => $step)
                    @php
                        if ($activeRequest->status === 'ditolak') {
                            $rState = 'rejected';
                        } elseif ($activeRequest->status === 'menunggu_pelanggan') {
                            $rState = 'pending';
                        } else {
                            $sIndex = array_search($key, $reqStatusOrder);
                            if ($sIndex < $reqCurrentIndex) {
                                $rState = 'completed';
                            } elseif ($sIndex === $reqCurrentIndex) {
                                $rState = 'active';
                            } else {
                                $rState = 'pending';
                            }
                        }

                        $rIconClass = $rState === 'completed' ? 'border-[#70bb63] bg-[#70bb63]/10 text-[#70bb63]' : 
                                     ($rState === 'active' ? 'border-[#1e5d87] bg-[#1e5d87]/10 text-[#1e5d87] ring-[6px] ring-[#1e5d87]/20' : 
                                     ($rState === 'rejected' ? 'border-[#ed6060] bg-[#ed6060]/10 text-[#ed6060]' : 'border-[#e7e9eb] bg-white text-[#a1a9b1] dark:bg-[#1e1f27] dark:border-[#37394d]'));
                        
                        $rLineClass = $rState === 'completed' ? 'bg-[#70bb63]' : 'bg-[#e7e9eb] dark:bg-[#37394d]';
                    @endphp

                    <div class="flex gap-4 md:gap-6 group">
                        <div class="flex flex-col items-center">
                            <div class="size-10 md:size-12 rounded-full border flex items-center justify-center z-10 shrink-0 transition-all duration-500 {{ $rIconClass }}">
                                @if($rState === 'completed')
                                    <div class="relative">
                                        <i class="ti {{ $step['icon'] }} text-lg md:text-xl"></i>
                                        <div class="absolute -bottom-1 -right-1 bg-[#70bb63] text-white rounded-full size-3.5 flex items-center justify-center border-2 border-white dark:border-[#1e1f27]">
                                            <i class="ti ti-check text-[8px]"></i>
                                        </div>
                                    </div>
                                @elseif($rState === 'rejected')
                                    <i class="ti ti-x text-lg md:text-xl"></i>
                                @else
                                    <i class="ti {{ $step['icon'] }} text-lg md:text-xl {{ $rState === 'active' ? 'animate-pulse' : '' }}"></i>
                                @endif
                            </div>
                            <div class="w-[2px] h-full my-2 group-last:hidden transition-all duration-500 {{ $rLineClass }}"></div>
                        </div>
                        <div class="flex-1 pb-6 md:pb-8 flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1 mt-0.5">
                            <div class="w-full">
                                <h5 class="text-sm md:text-base font-bold {{ $rState === 'active' ? 'text-[#313a46] dark:text-white' : ($rState === 'completed' ? 'text-[#313a46] dark:text-white' : ($rState === 'rejected' ? 'text-[#ed6060]' : 'text-[#a1a9b1] dark:text-[#6c757d]')) }}">
                                    {{ $rState === 'rejected' ? 'Pengajuan Ditolak' : $step['title'] }}
                                </h5>
                                <p class="text-xs md:text-[13px] mt-0.5 {{ $rState === 'active' ? 'text-[#4c4c5c] dark:text-[#aab8c5] font-medium' : ($rState === 'completed' ? 'text-[#8a969c]' : 'text-[#a1a9b1]/70 dark:text-[#6c757d]/70') }}">
                                    @if($rState === 'rejected')
                                        Mohon maaf, pengajuan Anda tidak dapat diproses. Silakan hubungi kami.
                                    @elseif($key === 'proses_upgrade' && $activeRequest->request_type === 'Terminate')
                                        Tim NOC kami sedang melakukan pembongkaran/pemutusan di lokasi Anda.
                                    @else
                                        {{ $step['desc'] }}
                                    @endif
                                </p>

                                @if($key === 'menunggu_ttd_pelanggan' && $rState === 'active')
                                    <div class="mt-5 w-full">
                                        <a href="{{ route('customer.request.pdf', $activeRequest->id) }}" target="_blank" class="w-full flex justify-center items-center gap-2 bg-[#60addf]/10 text-[#60addf] border border-[#60addf]/30 px-4 py-3 rounded-full text-sm font-bold hover:bg-[#60addf] hover:text-white transition-all shadow-sm">
                                            <i class="ti ti-download text-lg"></i> 1. Download Dokumen Form
                                        </a>
                                        <div class="relative mt-2.5">
                                            <input type="file" wire:model.live="signed_request_doc" id="upload-req-doc" class="hidden" accept=".pdf,image/*">
                                            <label for="upload-req-doc" class="w-full flex justify-center items-center gap-2 bg-[#669776] text-white px-4 py-3 rounded-full text-sm font-bold shadow-md shadow-[#669776]/20 hover:bg-[#527a5f] hover:shadow-lg transition-all cursor-pointer" wire:loading.class="opacity-70" wire:target="signed_request_doc">
                                                <i class="ti ti-upload text-lg"></i>
                                                <span wire:loading.remove wire:target="signed_request_doc">2. Upload TTD Dokumen</span>
                                                <span wire:loading wire:target="signed_request_doc">Memproses File...</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('signed_request_doc')
                                        <div class="mt-3 bg-[#ed6060]/10 border border-[#ed6060]/20 p-2.5 rounded-lg text-xs text-[#ed6060] font-medium flex items-center gap-2">
                                            <i class="ti ti-alert-circle text-base"></i> {{ $message }}
                                        </div>
                                    @enderror
                                    @if($signed_request_doc)
                                        <div class="mt-4 p-4 rounded-2xl border border-[#669776]/30 bg-[#f8f9fa] dark:bg-[#15151b] flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                                            <div class="flex items-center gap-3 overflow-hidden">
                                                <div class="bg-[#669776]/10 p-2.5 rounded-xl shrink-0"><i class="ti ti-file text-[#669776] text-xl"></i></div>
                                                <div class="truncate">
                                                    <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-0.5">File Dokumen:</p>
                                                    <p class="text-sm font-bold text-[#313a46] dark:text-white truncate">{{ $signed_request_doc->getClientOriginalName() }}</p>
                                                </div>
                                            </div>
                                            <button wire:click="uploadSignedRequest" wire:loading.attr="disabled" class="btn-boron btn-boron-primary !px-6 !py-3 text-sm rounded-full w-full sm:w-auto shadow-md shrink-0">
                                                <i class="ti ti-send text-lg mr-1.5"></i> Kirim
                                            </button>
                                        </div>
                                    @endif
                                @endif

                                @if($key === 'menunggu_ttd_bau' && $rState === 'active')
                                    <div class="mt-5 w-full">
                                        <a href="{{ route('customer.bau.pdf', $activeRequest->id) }}" target="_blank" class="w-full flex justify-center items-center gap-2 bg-[#60addf]/10 text-[#60addf] border border-[#60addf]/30 px-4 py-3 rounded-full text-sm font-bold hover:bg-[#60addf] hover:text-white transition-all shadow-sm">
                                            <i class="ti ti-download text-lg"></i> 1. Download Berita Acara
                                        </a>
                                        <div class="relative mt-2.5">
                                            <input type="file" wire:model.live="signed_bau_doc" id="upload-bau-doc" class="hidden" accept=".pdf,image/*">
                                            <label for="upload-bau-doc" class="w-full flex justify-center items-center gap-2 bg-[#669776] text-white px-4 py-3 rounded-full text-sm font-bold shadow-md shadow-[#669776]/20 hover:bg-[#527a5f] hover:shadow-lg transition-all cursor-pointer" wire:loading.class="opacity-70" wire:target="signed_bau_doc">
                                                <i class="ti ti-upload text-lg"></i>
                                                <span wire:loading.remove wire:target="signed_bau_doc">2. Upload TTD Berita Acara</span>
                                                <span wire:loading wire:target="signed_bau_doc">Memproses File...</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('signed_bau_doc')
                                        <div class="mt-3 bg-[#ed6060]/10 border border-[#ed6060]/20 p-2.5 rounded-lg text-xs text-[#ed6060] font-medium flex items-center gap-2">
                                            <i class="ti ti-alert-circle text-base"></i> {{ $message }}
                                        </div>
                                    @enderror
                                    @if($signed_bau_doc)
                                        <div class="mt-4 p-4 rounded-2xl border border-[#669776]/30 bg-[#f8f9fa] dark:bg-[#15151b] flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                                            <div class="flex items-center gap-3 overflow-hidden">
                                                <div class="bg-[#669776]/10 p-2.5 rounded-xl shrink-0"><i class="ti ti-file text-[#669776] text-xl"></i></div>
                                                <div class="truncate">
                                                    <p class="text-[11px] font-bold text-[#8a969c] uppercase mb-0.5">File Dokumen:</p>
                                                    <p class="text-sm font-bold text-[#313a46] dark:text-white truncate">{{ $signed_bau_doc->getClientOriginalName() }}</p>
                                                </div>
                                            </div>
                                            <button wire:click="uploadSignedBau" wire:loading.attr="disabled" class="btn-boron btn-boron-primary !px-6 !py-3 text-sm rounded-full w-full sm:w-auto shadow-md shrink-0">
                                                <i class="ti ti-send text-lg mr-1.5"></i> Kirim
                                            </button>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="text-[10px] md:text-[11px] text-[#8a969c] sm:text-right shrink-0 mt-1 sm:mt-0 font-medium">
                                @if($rState === 'completed' || $rState === 'active' || $rState === 'rejected')
                                    {{ $activeRequest->updated_at->format('d M Y, H:i') }}
                                @else
                                    TBA
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif