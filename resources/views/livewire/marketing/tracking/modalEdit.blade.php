@if($isEditingCustomer)
<div class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center bg-[#313a46]/60 backdrop-blur-sm sm:p-4 md:p-6 transition-all" wire:transition.opacity>
    <div class="w-full max-w-7xl h-[85vh] sm:h-auto sm:max-h-[95vh] flex flex-col overflow-hidden rounded-t-[1.5rem] sm:rounded-2xl bg-[#f6f7fb] shadow-2xl dark:bg-[#15151b] transform transition-transform" @click.stop>
        
        <div class="w-full flex justify-center pt-3 pb-1 sm:hidden bg-white dark:bg-[#1e1e2a]">
            <div class="w-12 h-1.5 bg-[#e7e9eb] rounded-full dark:bg-[#37394d]"></div>
        </div>

        <div class="flex-none flex items-center justify-between border-b border-[#e7e9eb] bg-white px-6 py-5 dark:border-[#37394d] dark:bg-[#1e1e2a]">
            <div class="flex items-center gap-4">
                <div class="flex size-10 items-center justify-center rounded-full bg-[#ebb751]/10 text-[#ebb751]">
                    <i class="ti ti-edit text-xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-extrabold text-[#313a46] dark:text-white line-clamp-1">Edit Data Pelanggan</h5>
                    <p class="text-xs font-medium text-[#8a969c] mt-0.5">Perbarui seluruh informasi registrasi dan layanan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button wire:click="cancelEdit" class="text-[#a1a9b1] hover:text-[#ed6060] transition-colors bg-[#f8f9fa] hover:bg-[#ed6060]/10 dark:bg-[#15151b] rounded-full p-2.5">
                    <i class="ti ti-x text-lg"></i>
                </button>
            </div>
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
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Pendaftar</label>
                                <input type="text" wire:model="editData.user_name" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Direktur (Login)</label>
                                <input type="email" wire:model="editData.user_email" class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#8a969c] cursor-not-allowed dark:border-[#37394d] dark:bg-[#15151b] dark:text-[#aab8c5]" readonly>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Pendaftar</label>
                                <input type="text" wire:model="editData.phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. KTP</label>
                                <input type="text" wire:model="editData.ktp_number" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Gender</label>
                                    <select wire:model="editData.gender" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        <option value="">Pilih</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jabatan</label>
                                    <input type="text" wire:model="editData.position" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#1e5d87] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-wifi text-lg"></i> Informasi Layanan
                        </h6>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kapasitas</label>
                                    <input type="text" wire:model="editData.bandwidth" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kontrak (Tahun)</label>
                                    <input type="number" wire:model="editData.term_of_service" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Layanan</label>
                                <input type="text" wire:model="editData.service_type" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Instalasi</label>
                                <textarea wire:model="editData.installation_address" rows="3" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Pelanggan</label>
                                    <input type="text" wire:model="editData.customer_type" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tgl Aktivasi</label>
                                    <input type="date" wire:model="editData.activation_date" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div x-data="{ isCustomMetro: false }">
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jalur Metro</label>
                                    <select 
                                        wire:model="editData.metro_link" 
                                        x-show="!isCustomMetro" 
                                        @change="$event.target.value === 'Lainnya' ? (isCustomMetro = true, $wire.set('editData.metro_link', '')) : isCustomMetro = false"
                                        class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white"
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
                                        <input type="text" wire:model="editData.metro_link" placeholder="Ketik manual..." class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        <button type="button" @click="isCustomMetro = false; $wire.set('editData.metro_link', '')" class="px-2 text-[#ed6060] hover:bg-[#ed6060]/10 rounded" title="Batal isi manual">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">SLA</label>
                                    <input type="text" wire:model="editData.sla" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
                            </div>
                            <div class="border-t border-[#e7e9eb] pt-4 mt-2 dark:border-[#37394d]">
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Registrasi (Rp)</label>
                                <div x-data="{
                                    raw: @entangle('editData.registration_fee'),
                                    formatRupiah(val) {
                                        if (!val) return '';
                                        return parseInt(String(val).replace(/[^0-9]/g, '')).toLocaleString('id-ID');
                                    },
                                    onInput(e) {
                                        let val = e.target.value.replace(/[^0-9]/g, '');
                                        this.raw = val ? parseInt(val) : null;
                                        e.target.value = this.formatRupiah(val);
                                    }
                                }">
                                    <input type="text" :value="formatRupiah(raw)" @input="onInput" placeholder="0" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Bulanan (Rp)</label>
                                <div x-data="{
                                    raw: @entangle('editData.monthly_fee'),
                                    formatRupiah(val) {
                                        if (!val) return '';
                                        return parseInt(String(val).replace(/[^0-9]/g, '')).toLocaleString('id-ID');
                                    },
                                    onInput(e) {
                                        let val = e.target.value.replace(/[^0-9]/g, '');
                                        this.raw = val ? parseInt(val) : null;
                                        e.target.value = this.formatRupiah(val);
                                    }
                                }">
                                    <input type="text" :value="formatRupiah(raw)" @input="onInput" placeholder="0" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
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
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Perusahaan</label>
                                <input type="text" wire:model="editData.company_name" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Bidang Usaha</label>
                                    <input type="text" wire:model="editData.business_type" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. NPWP</label>
                                    <input type="text" wire:model="editData.npwp_number" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Telepon Kantor</label>
                                <input type="text" wire:model="editData.company_phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Lengkap Perusahaan</label>
                                <textarea wire:model="editData.company_address" rows="3" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4" x-data="{
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
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Provinsi</label>
                                    <select @change="updateProv" x-model="selectedProvId" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                        <option value="">Pilih Provinsi...</option>
                                        <template x-for="prov in provinces" :key="prov.id">
                                            <option :value="prov.id" x-text="prov.name"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kota/Kabupaten</label>
                                    <select @change="updateCity" x-model="selectedCityId" :disabled="!selectedProvId" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                                        <option value="">Pilih Kota/Kab...</option>
                                        <template x-for="city in cities" :key="city.id">
                                            <option :value="city.id" x-text="city.name"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kode Pos</label>
                                <input type="text" wire:model="editData.postal_code" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">ID Pelanggan (Customer ID)</label>
                                <input type="text" wire:model="editData.customer_number" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm font-semibold focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Invoice Registrasi</label>
                                <input type="text" wire:model="editData.invoice_number" class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#8a969c] cursor-not-allowed dark:border-[#37394d] dark:bg-[#15151b] dark:text-[#aab8c5]" readonly>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Surat Perintah Kerja (SPK)</label>
                                <input type="text" wire:model="editData.spk_number" class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#8a969c] cursor-not-allowed dark:border-[#37394d] dark:bg-[#15151b] dark:text-[#aab8c5]" readonly>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Berita Acara Aktivasi (BAA)</label>
                                <input type="text" wire:model="editData.baa_number" class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#8a969c] cursor-not-allowed dark:border-[#37394d] dark:bg-[#15151b] dark:text-[#aab8c5]" readonly>
                            </div>

                            <div class="pt-4 mt-2 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                                <label class="mb-3 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Perbarui Lampiran Perusahaan (Opsional)</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="mb-1 block text-[10px] text-[#8a969c]">KTP Penanggung Jawab</label>
                                        <input type="file" wire:model="new_ktp_path" accept=".pdf,image/*" class="w-full text-xs text-[#4c4c5c] file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:font-semibold file:bg-[#60addf]/10 file:text-[#60addf] hover:file:bg-[#60addf]/20">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] text-[#8a969c]">NPWP Perusahaan</label>
                                        <input type="file" wire:model="new_npwp_path" accept=".pdf,image/*" class="w-full text-xs text-[#4c4c5c] file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:font-semibold file:bg-[#60addf]/10 file:text-[#60addf] hover:file:bg-[#60addf]/20">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] text-[#8a969c]">NIB Berusaha</label>
                                        <input type="file" wire:model="new_nib_path" accept=".pdf,image/*" class="w-full text-xs text-[#4c4c5c] file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:font-semibold file:bg-[#60addf]/10 file:text-[#60addf] hover:file:bg-[#60addf]/20">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[10px] text-[#8a969c]">Sertifikat Standar</label>
                                        <input type="file" wire:model="new_certificate_path" accept=".pdf,image/*" class="w-full text-xs text-[#4c4c5c] file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:font-semibold file:bg-[#60addf]/10 file:text-[#60addf] hover:file:bg-[#60addf]/20">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                        <h6 class="font-bold text-[#ebb751] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                            <i class="ti ti-headset text-lg"></i> Kontak PIC & Sales
                        </h6>
                        
                        <div class="space-y-5">
                            <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-file-invoice text-[#ebb751]"></i> PIC Finance (Penagihan)</p>
                                <div class="space-y-3">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama PIC Finance</label>
                                        <input type="text" wire:model="editData.finance_name" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Finance</label>
                                        <input type="email" wire:model="editData.finance_email" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone</label>
                                        <input type="text" wire:model="editData.finance_phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Penagihan (Billing)</label>
                                        <textarea wire:model="editData.billing_address" rows="3" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-router text-[#ebb751]"></i> PIC Teknis (Instalasi)</p>
                                <div class="space-y-3">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama PIC Teknis</label>
                                        <input type="text" wire:model="editData.technical_name" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Teknis</label>
                                        <input type="email" wire:model="editData.technical_email" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone</label>
                                        <input type="text" wire:model="editData.technical_phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-briefcase text-[#ebb751]"></i> Data Sales / Marketing</p>
                                <div class="space-y-3">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Sales / Marketing</label>
                                        <input type="text" wire:model="editData.marketing_name" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Marketing</label>
                                        <input type="text" wire:model="editData.marketing_phone" class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#60addf] focus:outline-none focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex-none px-6 py-5 border-t border-[#e7e9eb] dark:border-[#37394d] bg-white dark:bg-[#1e1e2a] flex justify-end gap-3">
            <button wire:click="cancelEdit" class="btn-boron btn-boron-outline-secondary !py-2.5 px-6 font-semibold rounded-lg">
                Batal
            </button>
            <button wire:click="updateCustomer" class="btn-boron btn-boron-primary !py-2.5 px-8 font-bold rounded-lg shadow-lg">
                <i class="ti ti-device-floppy text-lg mr-1"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>
@endif