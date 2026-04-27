@if($showRequestModal && $pendingRequest)
    <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm p-0 md:p-4" wire:transition.opacity>
        <div class="bg-white dark:bg-[#1e1f27] rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-2xl flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
            
            <div class="px-6 py-5 border-b border-[#e7e9eb] dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                <div class="flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-full bg-[#ebb751]/10 text-[#ebb751]">
                        <i class="ti ti-clipboard-data text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-[#313a46] dark:text-white leading-tight">Form Pengajuan {{ $pendingRequest->request_type }}</h3>
                        <p class="text-xs text-[#8a969c] mt-0.5">No. Pengajuan: <span class="font-bold text-[#1e5d87] dark:text-[#60addf]">{{ $pendingRequest->request_number }}</span></p>
                    </div>
                </div>
                <button wire:click="closeRequestModal" class="text-[#8a969c] bg-gray-200/50 dark:bg-white/5 hover:bg-[#ed6060]/10 p-2 rounded-full hover:text-[#ed6060] transition-colors"><i class="ti ti-x text-xl"></i></button>
            </div>

            <div class="p-6 bg-[#fcfcfd] dark:bg-[#1e1f27] overflow-y-auto max-h-[70vh]">
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 rounded-xl p-4 mb-6">
                    <h6 class="text-[11px] font-bold text-blue-800 dark:text-blue-300 uppercase tracking-wider mb-3">Informasi Pelanggan (Otomatis)</h6>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] text-blue-600 dark:text-blue-400 block mb-1">Perusahaan / Instansi</label>
                            <p class="text-sm font-bold text-[#313a46] dark:text-white">{{ $customer->company_name }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] text-blue-600 dark:text-blue-400 block mb-1">Penanggung Jawab (PIC)</label>
                            <p class="text-sm font-bold text-[#313a46] dark:text-white">{{ $customer->technical_name ?? $customer->user->name }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-[10px] text-blue-600 dark:text-blue-400 block mb-1">Alamat Instalasi</label>
                            <p class="text-[13px] font-medium text-[#313a46] dark:text-[#aab8c5]">{{ $customer->installation_address ?? $customer->company_address }}</p>
                        </div>
                        <div class="sm:col-span-2 border-t border-blue-100/50 dark:border-blue-800/20 pt-3 mt-1">
                            <label class="text-[10px] text-blue-600 dark:text-blue-400 block mb-1">Kapasitas Layanan Saat Ini</label>
                            <p class="text-base font-black text-blue-800 dark:text-blue-300">{{ $customer->bandwidth }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    @if($pendingRequest->request_type === 'Upgrade' || $pendingRequest->request_type === 'Downgrade')
                        <div>
                            <label class="mb-2 block text-sm font-bold text-[#313a46] dark:text-white">Pilih Kapasitas (Bandwidth) Baru <span class="text-[#ed6060]">*</span></label>
                            <p class="text-xs text-[#8a969c] mb-3">Silakan pilih kapasitas internet yang ingin Anda gunakan ke depannya.</p>
                            
                            <select wire:model="requestForm.new_bandwidth" class="w-full rounded-xl border border-[#dee2e6] bg-white px-4 py-3.5 text-sm font-medium focus:border-[#ebb751] focus:outline-none focus:ring-2 focus:ring-[#ebb751]/20 dark:border-[#37394d] dark:bg-[#15151b] dark:text-white transition-all shadow-sm cursor-pointer">
                                <option value="">-- Klik untuk Pilih Kapasitas --</option>
                                <option value="100 Mbps">100 Mbps</option>
                                <option value="200 Mbps">200 Mbps</option>
                                <option value="300 Mbps">300 Mbps</option>
                                <option value="400 Mbps">400 Mbps</option>
                                <option value="500 Mbps">500 Mbps</option>
                                <option value="600 Mbps">600 Mbps</option>
                                <option value="700 Mbps">700 Mbps</option>
                                <option value="800 Mbps">800 Mbps</option>
                                <option value="900 Mbps">900 Mbps</option>
                                <option value="1000 Mbps">1000 Mbps</option>
                                <option value="1500 Mbps">1500 Mbps</option>
                                <option value="2000 Mbps">2000 Mbps</option>
                            </select>
                            @error('requestForm.new_bandwidth') <span class="text-xs font-medium text-[#ed6060] mt-1.5 block flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-[#313a46] dark:text-white">Alasan / Keterangan Tambahan <span class="text-[#8a969c] font-normal">(Opsional)</span></label>
                            <textarea wire:model="requestForm.reason" rows="3" placeholder="Tuliskan keterangan tambahan jika ada..." class="w-full rounded-xl border border-[#dee2e6] bg-white px-4 py-3 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-2 focus:ring-[#ebb751]/20 dark:border-[#37394d] dark:bg-[#15151b] dark:text-white transition-all shadow-sm placeholder:text-[#a1a9b1]"></textarea>
                        </div>
                    @endif

                    @if($pendingRequest->request_type === 'Terminate')
                        <div>
                            <label class="mb-2 block text-sm font-bold text-[#313a46] dark:text-white">Tanggal Berhenti Berlangganan <span class="text-[#ed6060]">*</span></label>
                            <p class="text-xs text-[#8a969c] mb-3">Tentukan tanggal mulai dihentikannya layanan internet (maksimal bulan ini).</p>
                            
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-[#8a969c]">
                                    <i class="ti ti-calendar-event text-lg"></i>
                                </div>
                                <input type="date" wire:model="requestForm.stop_date" class="w-full rounded-xl border border-[#dee2e6] bg-white pl-11 pr-4 py-3.5 text-sm font-medium focus:border-[#ed6060] focus:outline-none focus:ring-2 focus:ring-[#ed6060]/20 dark:border-[#37394d] dark:bg-[#15151b] dark:text-white transition-all shadow-sm cursor-pointer">
                            </div>
                            @error('requestForm.stop_date') <span class="text-xs font-medium text-[#ed6060] mt-1.5 block flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-bold text-[#313a46] dark:text-white">Alasan Pemutusan Layanan <span class="text-[#ed6060]">*</span></label>
                            <p class="text-xs text-[#8a969c] mb-3">Mohon sampaikan alasan Anda berhenti berlangganan sebagai bahan evaluasi kami.</p>
                            
                            <textarea wire:model="requestForm.reason" rows="4" placeholder="Contoh: Pindah lokasi kantor, dsb..." class="w-full rounded-xl border border-[#dee2e6] bg-white px-4 py-3 text-sm focus:border-[#ed6060] focus:outline-none focus:ring-2 focus:ring-[#ed6060]/20 dark:border-[#37394d] dark:bg-[#15151b] dark:text-white transition-all shadow-sm placeholder:text-[#a1a9b1]"></textarea>
                            @error('requestForm.reason') <span class="text-xs font-medium text-[#ed6060] mt-1.5 block flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
            </div>

            <div class="px-6 py-5 bg-white dark:bg-[#15151b] border-t border-[#e7e9eb] dark:border-[#37394d] flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4">
                <button wire:click="closeRequestModal" class="w-full sm:w-auto btn-boron border border-[#dee2e6] px-6 py-3 text-sm font-bold text-[#313a46] hover:bg-[#f8f9fa] dark:border-[#37394d] dark:text-white dark:hover:bg-white/5 rounded-xl transition-colors">Batal</button>
                <button wire:click="submitRequestForm" class="w-full sm:w-auto btn-boron bg-[#ebb751] text-white hover:bg-[#d4a03c] px-8 py-3 text-sm font-bold flex items-center justify-center gap-2 shadow-lg shadow-[#ebb751]/20 rounded-xl transition-all">
                    <i class="ti ti-send text-lg"></i> Kirim Form ke Pusat
                </button>
            </div>
        </div>
    </div>
@endif