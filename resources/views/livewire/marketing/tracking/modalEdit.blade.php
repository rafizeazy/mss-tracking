@if($isEditingCustomer)
<div class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center bg-[#313a46]/60 backdrop-blur-sm sm:p-4 md:p-6 transition-all" wire:transition.opacity>
    <div class="w-full max-w-7xl h-[85vh] sm:h-auto sm:max-h-[95vh] flex flex-col overflow-hidden rounded-t-[1.5rem] sm:rounded-2xl bg-[#f6f7fb] shadow-2xl dark:bg-[#15151b] transform transition-transform" @click.stop>
        <div class="w-full flex justify-center pt-3 pb-1 sm:hidden bg-white dark:bg-[#1e1e2a]">
            <div class="w-12 h-1.5 bg-[#e7e9eb] rounded-full dark:bg-[#37394d]"></div>
        </div>

        <div class="flex-none flex items-start sm:items-center justify-between border-b border-[#e7e9eb] bg-white px-5 sm:px-6 py-4 sm:py-5 dark:border-[#37394d] dark:bg-[#1e1e2a] gap-3">
            <div class="flex items-center gap-3 sm:gap-4 w-full sm:w-auto justify-between sm:justify-start">
                <div class="flex items-center gap-3">
                    <div class="flex size-10 sm:size-12 items-center justify-center rounded-full bg-[#1e5d87]/10 text-[#1e5d87] dark:bg-[#60addf]/10 dark:text-[#60addf] shrink-0">
                        <i class="ti ti-edit text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <h5 class="text-base sm:text-lg font-extrabold text-[#313a46] dark:text-white leading-tight">Edit Data Pelanggan</h5>
                        <p class="text-[10px] sm:text-xs font-medium text-[#8a969c] mt-0.5 line-clamp-1">Perbarui informasi registrasi dan layanan</p>
                    </div>
                </div>
                <button wire:click="cancelEdit" class="sm:hidden text-[#8a969c] bg-[#f8f9fa] hover:bg-[#ed6060]/10 p-2 rounded-full hover:text-[#ed6060] transition-colors dark:bg-[#15151b] shrink-0">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>
            
            <div class="hidden sm:flex items-center gap-2 shrink-0">
                <button wire:click="cancelEdit" class="text-[#a1a9b1] hover:text-[#ed6060] transition-colors bg-[#f8f9fa] hover:bg-[#ed6060]/10 dark:bg-[#15151b] rounded-full p-2.5">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 boron-scrollbar">
            <div class="grid gap-4 sm:gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            
                <div class="space-y-4 sm:space-y-6">
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-4 sm:p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#669776] mb-3 sm:mb-4 flex items-center gap-2 text-xs sm:text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-2 sm:pb-3 dark:border-[#37394d]">
                            <i class="ti ti-user text-base sm:text-lg"></i> Data Pendaftar
                        </h6>
                        <div class="space-y-3.5">
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Pendaftar <span class="text-[#ed6060]">*</span></label>
                                <input type="text" wire:model="editData.phone" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:text-white">
                                @error('editData.phone') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. KTP</label>
                                <input type="text" wire:model="editData.ktp_number" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:text-white">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Gender</label>
                                    <select wire:model="editData.gender" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        <option value="">Pilih...</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jabatan</label>
                                    <input type="text" wire:model="editData.position" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-4 sm:p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#1e5d87] mb-3 sm:mb-4 flex items-center gap-2 text-xs sm:text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-2 sm:pb-3 dark:border-[#37394d]">
                            <i class="ti ti-wifi text-base sm:text-lg"></i> Informasi Layanan
                        </h6>
                        <div class="space-y-3.5">
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Layanan <span class="text-[#ed6060]">*</span></label>
                                <input type="text" wire:model="editData.service_type" class="w-full rounded border border-[#dee2e6] bg-[#f8f9fa] px-3 py-2 text-[13px] sm:text-sm text-[#8a969c] cursor-not-allowed dark:border-[#37394d] dark:bg-[#15151b] dark:text-[#aab8c5]" readonly>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kapasitas <span class="text-[#ed6060]">*</span></label>
                                    <select wire:model="editData.bandwidth" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
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
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kontrak</label>
                                    <select wire:model="editData.term_of_service" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">1 Tahun</option>
                                        <option value="2">2 Tahun</option>
                                        <option value="3">3 Tahun</option>
                                    </select>
                                </div>
                            </div>
                            <div x-data="{ isCustomMetro: false }">
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Vendor Jalur Metro</label>
                                <select 
                                    wire:model="editData.jalur_metro" 
                                    x-show="!isCustomMetro" 
                                    @change="$event.target.value === 'Lainnya' ? (isCustomMetro = true, $wire.set('editData.jalur_metro', '')) : isCustomMetro = false"
                                    class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white"
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
                                    <input type="text" wire:model="editData.jalur_metro" placeholder="Ketik manual..." class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:text-white">
                                    <button type="button" @click="isCustomMetro = false; $wire.set('editData.jalur_metro', '')" class="px-2 text-[#ed6060] hover:bg-[#ed6060]/10 rounded" title="Batal isi manual">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="border-t border-[#e7e9eb] pt-3 mt-1 dark:border-[#37394d]">
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Registrasi (Rp)</label>
                                <input type="number" wire:model="editData.registration_fee" placeholder="0" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Bulanan (Rp)</label>
                                <input type="number" wire:model="editData.monthly_fee" placeholder="0" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#1e5d87] focus:outline-none focus:ring-1 focus:ring-[#1e5d87] dark:border-[#37394d] dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2 -->
                <div class="space-y-4 sm:space-y-6">
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-4 sm:p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#60addf] mb-3 sm:mb-4 flex items-center gap-2 text-xs sm:text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-2 sm:pb-3 dark:border-[#37394d]">
                            <i class="ti ti-building-skyscraper text-base sm:text-lg"></i> Instansi / PT
                        </h6>
                        <div class="space-y-3.5">
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Perusahaan <span class="text-[#ed6060]">*</span></label>
                                <input type="text" wire:model="editData.company_name" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                                @error('editData.company_name') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Bidang Usaha</label>
                                    <input type="text" wire:model="editData.business_type" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                                </div>
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. NPWP</label>
                                    <input type="text" wire:model="editData.npwp_number" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Telepon Kantor</label>
                                <input type="text" wire:model="editData.company_phone" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Lengkap PT <span class="text-[#ed6060]">*</span></label>
                                <textarea wire:model="editData.company_address" rows="3" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white"></textarea>
                            </div>
                            
                            <!-- Dynamic Dropdown Provinsi & Kota menggunakan API EMSIFA -->
                            <div class="grid grid-cols-2 gap-3" x-data="{
                                provinces: [],
                                cities: [],
                                selectedProvId: '',
                                selectedCityId: '',
                                provName: @entangle('editData.province'),
                                cityName: @entangle('editData.city'),
                                
                                init() {
                                    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                                        .then(res => res.json())
                                        .then(data => {
                                            this.provinces = data;
                                            // Pre-fill data if editing existing customer
                                            if(this.provName) {
                                                let p = data.find(x => x.name.toUpperCase() === String(this.provName).toUpperCase());
                                                if(p) {
                                                    this.selectedProvId = p.id;
                                                    this.fetchCities(p.id, true);
                                                }
                                            }
                                        });
                                },
                                fetchCities(provId, isInit = false) {
                                    if(!provId) { this.cities = []; return; }
                                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
                                        .then(res => res.json())
                                        .then(data => {
                                            this.cities = data;
                                            if(isInit && this.cityName) {
                                                let c = data.find(x => x.name.toUpperCase() === String(this.cityName).toUpperCase());
                                                if(c) this.selectedCityId = c.id;
                                            }
                                        });
                                },
                                updateProv(e) {
                                    let id = e.target.value;
                                    this.selectedProvId = id;
                                    let p = this.provinces.find(x => x.id === id);
                                    this.provName = p ? p.name : '';
                                    this.cityName = '';
                                    this.selectedCityId = '';
                                    this.fetchCities(id);
                                },
                                updateCity(e) {
                                    let id = e.target.value;
                                    this.selectedCityId = id;
                                    let c = this.cities.find(x => x.id === id);
                                    this.cityName = c ? c.name : '';
                                }
                            }">
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Provinsi</label>
                                    <select @change="updateProv" x-model="selectedProvId" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        <option value="">Pilih Provinsi...</option>
                                        <template x-for="prov in provinces" :key="prov.id">
                                            <option :value="prov.id" x-text="prov.name"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kota/Kab</label>
                                    <select @change="updateCity" x-model="selectedCityId" :disabled="!selectedProvId" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                        <option value="">Pilih Kota/Kab...</option>
                                        <template x-for="city in cities" :key="city.id">
                                            <option :value="city.id" x-text="city.name"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kode Pos</label>
                                <input type="text" wire:model="editData.postal_code" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-[13px] sm:text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:text-white">
                            </div>
                        </div>
                    </div>
                    
                    {{-- SEKSI UPLOAD ULANG DOKUMEN --}}
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-4 sm:p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#a1a9b1] mb-3 sm:mb-4 flex items-center gap-2 text-xs sm:text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-2 sm:pb-3 dark:border-[#37394d] dark:text-white">
                            <i class="ti ti-files text-base sm:text-lg text-[#a1a9b1]"></i> Perbarui Lampiran File
                        </h6>
                        <p class="text-[11px] md:text-xs text-[#8a969c] mb-3 leading-snug">Gunakan form di bawah ini hanya jika Anda perlu mengganti file lampiran yang salah upload oleh pelanggan.</p>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">KTP Penanggung Jawab (Opsional)</label>
                                <input type="file" wire:model="new_ktp_path" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-xs focus:outline-none dark:border-[#37394d] dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#f8f9fa] file:text-[#4c4c5c] hover:file:bg-[#e7e9eb] dark:file:bg-[#15151b] dark:file:text-[#aab8c5]" accept=".pdf,image/*">
                                <span wire:loading wire:target="new_ktp_path" class="text-[10px] text-[#ebb751] mt-1 block">Uploading...</span>
                                @error('new_ktp_path') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">NPWP Perusahaan (Opsional)</label>
                                <input type="file" wire:model="new_npwp_path" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-xs focus:outline-none dark:border-[#37394d] dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#f8f9fa] file:text-[#4c4c5c] hover:file:bg-[#e7e9eb] dark:file:bg-[#15151b] dark:file:text-[#aab8c5]" accept=".pdf,image/*">
                                <span wire:loading wire:target="new_npwp_path" class="text-[10px] text-[#ebb751] mt-1 block">Uploading...</span>
                                @error('new_npwp_path') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">NIB Berusaha (Opsional)</label>
                                <input type="file" wire:model="new_nib_path" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-xs focus:outline-none dark:border-[#37394d] dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#f8f9fa] file:text-[#4c4c5c] hover:file:bg-[#e7e9eb] dark:file:bg-[#15151b] dark:file:text-[#aab8c5]" accept=".pdf,image/*">
                                <span wire:loading wire:target="new_nib_path" class="text-[10px] text-[#ebb751] mt-1 block">Uploading...</span>
                                @error('new_nib_path') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Sertifikat Standar (Opsional)</label>
                                <input type="file" wire:model="new_certificate_path" class="w-full rounded border border-[#dee2e6] bg-transparent px-3 py-2 text-xs focus:outline-none dark:border-[#37394d] dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-[#f8f9fa] file:text-[#4c4c5c] hover:file:bg-[#e7e9eb] dark:file:bg-[#15151b] dark:file:text-[#aab8c5]" accept=".pdf,image/*">
                                <span wire:loading wire:target="new_certificate_path" class="text-[10px] text-[#ebb751] mt-1 block">Uploading...</span>
                                @error('new_certificate_path') <span class="text-[10px] text-[#ed6060] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom 3 -->
                <div class="space-y-4 sm:space-y-6">
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-4 sm:p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#ebb751] mb-3 sm:mb-4 flex items-center gap-2 text-xs sm:text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-2 sm:pb-3 dark:border-[#37394d]">
                            <i class="ti ti-headset text-base sm:text-lg"></i> Kontak PIC & Sales
                        </h6>
                        
                        <div class="space-y-4">
                            <div class="rounded border border-[#e7e9eb] p-3 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-[11px] sm:text-xs font-bold text-[#313a46] dark:text-white border-b border-dashed border-[#e7e9eb] pb-2 mb-2 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-file-invoice text-[#ebb751]"></i> PIC Finance (Penagihan)</p>
                                <div class="space-y-2.5">
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Finance</label>
                                        <input type="text" wire:model="editData.finance_name" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email</label>
                                            <input type="email" wire:model="editData.finance_email" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. HP</label>
                                            <input type="text" wire:model="editData.finance_phone" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Penagihan</label>
                                        <textarea wire:model="editData.billing_address" rows="2" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white" placeholder="Sama dengan PT jika kosong"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded border border-[#e7e9eb] p-3 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-[11px] sm:text-xs font-bold text-[#313a46] dark:text-white border-b border-dashed border-[#e7e9eb] pb-2 mb-2 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-router text-[#ebb751]"></i> PIC Teknis (Instalasi)</p>
                                <div class="space-y-2.5">
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Teknis</label>
                                        <input type="text" wire:model="editData.technical_name" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email</label>
                                            <input type="email" wire:model="editData.technical_email" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        </div>
                                        <div>
                                            <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. HP</label>
                                            <input type="text" wire:model="editData.technical_phone" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Instalasi</label>
                                        <textarea wire:model="editData.installation_address" rows="2" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white" placeholder="Sama dengan PT jika kosong"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded border border-[#e7e9eb] p-3 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-[11px] sm:text-xs font-bold text-[#313a46] dark:text-white border-b border-dashed border-[#e7e9eb] pb-2 mb-2 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-briefcase text-[#ebb751]"></i> Data Sales / Marketing</p>
                                <div class="space-y-2.5">
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Sales</label>
                                        <input type="text" wire:model="editData.marketing_name" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. HP Marketing</label>
                                        <input type="text" wire:model="editData.marketing_phone" class="w-full rounded border border-[#dee2e6] bg-white px-3 py-1.5 text-[13px] sm:text-sm focus:border-[#ebb751] focus:outline-none focus:ring-1 focus:ring-[#ebb751] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="flex-none flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3 border-t border-[#e7e9eb] px-5 sm:px-6 py-4 sm:py-5 bg-white dark:border-[#37394d] dark:bg-[#1e1e2a]">
            <button wire:click="cancelEdit" class="w-full sm:w-auto btn-boron !py-2.5 border border-[#dee2e6] bg-[#f8f9fa] font-semibold text-[#4c4c5c] hover:bg-[#e7e9eb] dark:bg-[#15151b] dark:border-[#37394d] dark:text-white dark:hover:bg-[#252630] text-[13px] sm:text-sm">
                Batalkan
            </button>
            <button wire:click="updateCustomer" wire:loading.attr="disabled" class="w-full sm:w-auto btn-boron btn-boron-primary !py-2.5 sm:px-5 font-bold shadow-md shadow-[#669776]/20 flex items-center justify-center gap-2 hover:-translate-y-0.5 transition-transform text-[13px] sm:text-sm">
                <i class="ti ti-device-floppy text-lg"></i> <span class="hidden sm:inline">Simpan Perubahan</span><span class="sm:hidden">Simpan Data</span>
            </button>
        </div>
        
    </div>
</div>
@endif