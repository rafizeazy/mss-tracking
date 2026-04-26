@if($isEditingCustomer)
<div class="fixed inset-0 z-[100] flex items-center justify-center bg-[#313a46]/60 backdrop-blur-sm p-4 sm:p-6 transition-all">
    <div class="w-full max-w-7xl max-h-[95vh] flex flex-col overflow-hidden rounded-2xl bg-[#f6f7fb] shadow-2xl dark:bg-[#15151b]">
        
        <div class="flex-none flex items-center justify-between border-b border-[#e7e9eb] bg-white px-6 py-5 dark:border-[#37394d] dark:bg-[#1e1e2a]">
            <div class="flex items-center gap-4">
                <div class="flex size-10 items-center justify-center rounded-full bg-[#1e5d87]/10 text-[#1e5d87] dark:bg-[#60addf]/10 dark:text-[#60addf]">
                    <i class="ti ti-edit text-xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-extrabold text-[#313a46] dark:text-white">Edit Master Data Pelanggan</h5>
                    <p class="text-xs font-medium text-[#8a969c] mt-0.5">Perbarui informasi registrasi, layanan, dokumen, dan kontak PIC</p>
                </div>
            </div>
            <button wire:click="cancelEdit" class="text-[#a1a9b1] hover:text-[#ed6060] transition-colors bg-[#f8f9fa] hover:bg-[#ed6060]/10 dark:bg-[#15151b] rounded-full p-2.5">
                <i class="ti ti-x text-lg"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-6 boron-scrollbar">
            <div class="grid gap-6 lg:grid-cols-3">
                
                <div class="space-y-6">
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#669776] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-user text-lg"></i> Data Pendaftar
                        </h6>
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Pendaftar <span class="text-[#ed6060]">*</span></label>
                                <input type="text" wire:model="editData.phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:text-white">
                                @error('editData.phone') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">No. KTP</label>
                                <input type="text" wire:model="editData.ktp_number" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:text-white">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Gender</label>
                                    <select wire:model="editData.gender" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        <option value="">Pilih...</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Jabatan</label>
                                    <input type="text" wire:model="editData.position" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#1e5d87] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-wifi text-lg"></i> Informasi Layanan
                        </h6>
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Layanan <span class="text-[#ed6060]">*</span></label>
                                <input type="text" wire:model="editData.service_type" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-[#f8f9fa] px-3 py-2 text-sm text-[#8a969c] cursor-not-allowed dark:border-[#37394d] dark:bg-[#15151b] dark:text-[#aab8c5]" readonly>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Kapasitas <span class="text-[#ed6060]">*</span></label>
                                    <select wire:model="editData.bandwidth" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        <option value="">-- Pilih --</option>
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
                                        <option value="2500 Mbps">2500 Mbps</option>
                                        <option value="3000 Mbps">3000 Mbps</option>
                                        <option value="3500 Mbps">3500 Mbps</option>
                                        <option value="4000 Mbps">4000 Mbps</option>
                                    </select>
                                    @error('editData.bandwidth') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Kontrak</label>
                                    <select wire:model="editData.term_of_service" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">1 Tahun</option>
                                        <option value="2">2 Tahun</option>
                                        <option value="3">3 Tahun</option>
                                    </select>
                                </div>
                            </div>
                            <div x-data="{ isCustomMetro: false }">
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Vendor Jalur Metro</label>
                                <select 
                                    wire:model="editData.jalur_metro" 
                                    x-show="!isCustomMetro" 
                                    @change="$event.target.value === 'Lainnya' ? (isCustomMetro = true, $wire.set('editData.jalur_metro', '')) : isCustomMetro = false"
                                    class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white"
                                >
                                    <option value="">Pilih Jalur Metro...</option>
                                    <option value="Lokal Link">Lokal Link</option>
                                    <option value="Telkom">Telkom</option>
                                    <option value="Lintas Arta">Lintas Arta</option>
                                    <option value="Indosat">Indosat</option>
                                    <option value="MV. Net Telkom">MV. Net Telkom</option>
                                    <option value="Fiber Star">Fiber Star</option>
                                    <option value="Iforte">Iforte</option>
                                    <option value="Lainnya">Lainnya...</option>
                                </select>
                                
                                <div x-show="isCustomMetro" style="display: none;" class="flex gap-2">
                                    <input type="text" wire:model="editData.jalur_metro" placeholder="Ketik nama vendor jalur metro..." class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:text-white">
                                    <button type="button" @click="isCustomMetro = false; $wire.set('editData.jalur_metro', '')" class="px-2 text-[#ed6060] hover:bg-[#ed6060]/10 rounded" title="Batal isi manual">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="border-t border-[#e7e9eb] pt-3 mt-1 dark:border-[#37394d]">
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Registrasi (Rp)</label>
                                <input type="number" wire:model="editData.registration_fee" placeholder="0" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Bulanan (Rp)</label>
                                <input type="number" wire:model="editData.monthly_fee" placeholder="0" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#60addf] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-building-skyscraper text-lg"></i> Instansi / Perusahaan
                        </h6>
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Perusahaan <span class="text-[#ed6060]">*</span></label>
                                <input type="text" wire:model="editData.company_name" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                                @error('editData.company_name') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Bidang Usaha</label>
                                    <input type="text" wire:model="editData.business_type" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">No. NPWP</label>
                                    <input type="text" wire:model="editData.npwp_number" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Telepon Kantor</label>
                                <input type="text" wire:model="editData.company_phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Lengkap Perusahaan <span class="text-[#ed6060]">*</span></label>
                                <textarea wire:model="editData.company_address" rows="3" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Kota/Kabupaten</label>
                                    <input type="text" wire:model="editData.city" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Provinsi</label>
                                    <input type="text" wire:model="editData.province" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold text-[#8a969c] uppercase tracking-wider">Kode Pos</label>
                                <input type="text" wire:model="editData.postal_code" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#ebb751] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-headset text-lg"></i> Kontak PIC
                        </h6>
                        
                        <div class="space-y-5">
                            <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-file-invoice text-[#ebb751]"></i> PIC Finance (Penagihan)</p>
                                <div class="space-y-3">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama PIC Finance</label>
                                        <input type="text" wire:model="editData.finance_name" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Finance</label>
                                        <input type="email" wire:model="editData.finance_email" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone</label>
                                        <input type="text" wire:model="editData.finance_phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Penagihan (Billing)</label>
                                        <textarea wire:model="editData.billing_address" rows="2" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white" placeholder="Kosongkan jika sama dengan perusahaan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-router text-[#ebb751]"></i> PIC Teknis (Instalasi)</p>
                                <div class="space-y-3">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama PIC Teknis</label>
                                        <input type="text" wire:model="editData.technical_name" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Teknis</label>
                                        <input type="email" wire:model="editData.technical_email" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone</label>
                                        <input type="text" wire:model="editData.technical_phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Instalasi Router</label>
                                        <textarea wire:model="editData.installation_address" rows="2" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white" placeholder="Kosongkan jika sama dengan perusahaan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-briefcase text-[#ebb751]"></i> Data Sales / Marketing</p>
                                <div class="space-y-3">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Sales / Marketing</label>
                                        <input type="text" wire:model="editData.marketing_name" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Marketing</label>
                                        <input type="text" wire:model="editData.marketing_phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- SEKSI UPLOAD ULANG DOKUMEN (Dengan wire:model yang telah diperbarui) --}}
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#a1a9b1] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d] dark:text-white">
                            <i class="ti ti-files text-lg text-[#a1a9b1]"></i> Perbarui Lampiran File
                        </h6>
                        <p class="text-xs text-[#8a969c] mb-4">Gunakan form di bawah ini hanya jika Anda perlu mengganti file lampiran yang salah upload oleh pelanggan.</p>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">KTP Penanggung Jawab (Opsional)</label>
                                <input type="file" wire:model="new_ktp_path" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-xs focus:outline-none dark:border-[#37394d] dark:text-white" accept=".pdf,image/*">
                                <span wire:loading wire:target="new_ktp_path" class="text-[10px] text-[#ebb751] mt-1 block">Uploading...</span>
                                @error('new_ktp_path') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">NPWP Perusahaan (Opsional)</label>
                                <input type="file" wire:model="new_npwp_path" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-xs focus:outline-none dark:border-[#37394d] dark:text-white" accept=".pdf,image/*">
                                <span wire:loading wire:target="new_npwp_path" class="text-[10px] text-[#ebb751] mt-1 block">Uploading...</span>
                                @error('new_npwp_path') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">NIB Berusaha (Opsional)</label>
                                <input type="file" wire:model="new_nib_path" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-xs focus:outline-none dark:border-[#37394d] dark:text-white" accept=".pdf,image/*">
                                <span wire:loading wire:target="new_nib_path" class="text-[10px] text-[#ebb751] mt-1 block">Uploading...</span>
                                @error('new_nib_path') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Sertifikat/Izin Usaha (Opsional)</label>
                                <input type="file" wire:model="new_certificate_path" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-xs focus:outline-none dark:border-[#37394d] dark:text-white" accept=".pdf,image/*">
                                <span wire:loading wire:target="new_certificate_path" class="text-[10px] text-[#ebb751] mt-1 block">Uploading...</span>
                                @error('new_certificate_path') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex-none flex items-center justify-end gap-3 border-t border-[#e7e9eb] px-6 py-5 bg-white dark:border-[#37394d] dark:bg-[#1e1e2a]">
            <button wire:click="cancelEdit" class="btn-boron !py-2.5 border border-[#dee2e6] bg-[#f8f9fa] font-semibold text-[#4c4c5c] hover:bg-[#e7e9eb] dark:bg-[#15151b] dark:border-[#37394d] dark:text-white dark:hover:bg-[#252630]">
                Batalkan
            </button>
            <button wire:click="updateCustomer" wire:loading.attr="disabled" class="btn-boron btn-boron-primary !py-2.5 px-5 font-bold shadow-lg shadow-[#669776]/30 flex items-center gap-2 hover:-translate-y-0.5 transition-transform">
                <i class="ti ti-device-floppy text-lg"></i> Simpan Perubahan
            </button>
        </div>
        
    </div>
</div>
@endif