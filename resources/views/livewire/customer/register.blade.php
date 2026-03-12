<div class="flex min-h-screen items-center justify-center bg-[#f6f7fb] px-4 py-10 dark:bg-[#15151b]">
    <div class="w-full max-w-4xl">
        
        {{-- Header Form --}}
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-full bg-[#669776]/20">
                <i class="ti ti-file-description text-2xl text-[#669776]"></i>
            </div>
            <h2 class="text-2xl font-bold text-[#313a46] dark:text-white">{{ __('Formulir Berlangganan Layanan') }}</h2>
            <p class="mt-2 text-sm text-[#8a969c]">{{ __('PT Media Solusi Sukses - Silakan lengkapi data registrasi di bawah ini.') }}</p>
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">

            {{-- 1. Nama yang diberi wewenang --}}
            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">1. Data Pendaftar (Yang Diberi Wewenang)</h5>
                </div>
                <div class="boron-card-body p-6 grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Nama Lengkap <span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="name" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('name') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">No. KTP <span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="ktp_number" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('ktp_number') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Jenis Kelamin <span class="text-[#ed6060]">*</span></label>
                        <select wire:model="gender" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                            <option value="">Pilih...</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('gender') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Jabatan <span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="position" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('position') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Alamat Email <span class="text-[#ed6060]">*</span></label>
                        <input type="email" wire:model="email" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('email') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Nomor Handphone <span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="phone" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('phone') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- 2. Informasi Perusahaan --}}
            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">2. Informasi Perusahaan / Institusi</h5>
                </div>
                <div class="boron-card-body p-6 grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Nama Perusahaan / Institusi <span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="company_name" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('company_name') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Jenis / Bidang Usaha</label>
                        <input type="text" wire:model="business_type" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">NPWP Perusahaan</label>
                        <input type="text" wire:model="npwp_number" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Alamat Perusahaan <span class="text-[#ed6060]">*</span></label>
                        <textarea rows="2" wire:model="company_address" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]"></textarea>
                        @error('company_address') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Kota & Provinsi</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" wire:model="city" placeholder="Kota" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                            <input type="text" wire:model="province" placeholder="Provinsi" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Kode Pos & Nomor Telepon</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" wire:model="postal_code" placeholder="Kode Pos" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                            <input type="text" wire:model="company_phone" placeholder="No. Telepon" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3 & 4. Kontak PIC (Grid 2 Kolom Besar) --}}
            <div class="grid gap-6 md:grid-cols-2">
                
                {{-- Penanggung Jawab Keuangan --}}
                <div class="boron-card">
                    <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">3. Penanggung Jawab Invoice/Keuangan</h5>
                    </div>
                    <div class="boron-card-body p-6 space-y-4">
                        <div>
                            <label class="mb-1 block text-xs font-medium">Nama Bagian Keuangan</label>
                            <input type="text" wire:model="finance_name" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">Alamat Penagihan</label>
                            <textarea rows="2" wire:model="billing_address" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]"></textarea>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">Jabatan</label>
                            <input type="text" wire:model="finance_position" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="mb-1 block text-xs font-medium">Email</label>
                                <input type="email" wire:model="finance_email" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium">No. Handphone</label>
                                <input type="text" wire:model="finance_phone" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Penanggung Jawab Teknis --}}
                <div class="boron-card">
                    <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">4. Penanggung Jawab Teknis</h5>
                    </div>
                    <div class="boron-card-body p-6 space-y-4">
                        <div>
                            <label class="mb-1 block text-xs font-medium">Kontak Teknis (Nama)</label>
                            <input type="text" wire:model="technical_name" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">Alamat Instalasi</label>
                            <textarea rows="2" wire:model="installation_address" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="mb-1 block text-xs font-medium">Bagian / Departemen</label>
                                <input type="text" wire:model="technical_department" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium">Jabatan</label>
                                <input type="text" wire:model="technical_position" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="mb-1 block text-xs font-medium">Email</label>
                                <input type="email" wire:model="technical_email" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium">No. Handphone</label>
                                <input type="text" wire:model="technical_phone" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 5. Detail Layanan & Dokumen --}}
            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">5. Detail Layanan & Kelengkapan Dokumen</h5>
                </div>
                <div class="boron-card-body p-6 grid gap-6 md:grid-cols-2">
                    
                    {{-- Layanan --}}
                    <div class="space-y-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium">Tipe Layanan & Bandwidth <span class="text-[#ed6060]">*</span></label>
                            <input type="text" wire:model="service_type" placeholder="Contoh: Dedicated Internet 100 Mbps" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm dark:border-[#37394d]">
                            @error('service_type') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium">Jangka Waktu Berlangganan (Term of Service) <span class="text-[#ed6060]">*</span></label>
                            <select wire:model="term_of_service" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm dark:border-[#37394d]">
                                <option value="">Pilih Jangka Waktu...</option>
                                <option value="1">1 Tahun (12 Bulan)</option>
                                <option value="2">2 Tahun (24 Bulan)</option>
                                <option value="3">3 Tahun (36 Bulan)</option>
                            </select>
                            @error('term_of_service') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Upload Dokumen --}}
                    <div class="space-y-3 rounded-[0.3rem] border border-dashed border-[#dee2e6] p-4 dark:border-[#37394d]">
                        <p class="text-xs font-semibold text-[#8a969c] uppercase">Upload Dokumen Pendukung</p>
                        
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium">File KTP</span>
                            <input type="file" wire:model="ktp_file" accept=".jpg,.png,.pdf" class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:text-[#669776] file:font-medium">
                        </div>
                        @error('ktp_file') <span class="text-xs text-[#ed6060] block text-right">{{ $message }}</span> @enderror

                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium">File NPWP</span>
                            <input type="file" wire:model="npwp_file" accept=".jpg,.png,.pdf" class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:text-[#669776] file:font-medium">
                        </div>
                        @error('npwp_file') <span class="text-xs text-[#ed6060] block text-right">{{ $message }}</span> @enderror

                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium">File NIB</span>
                            <input type="file" wire:model="nib_file" accept=".jpg,.png,.pdf" class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:text-[#669776] file:font-medium">
                        </div>
                        @error('nib_file') <span class="text-xs text-[#ed6060] block text-right">{{ $message }}</span> @enderror

                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="font-medium">Sertifikat Standar</span>
                            <input type="file" wire:model="certificate_file" accept=".jpg,.png,.pdf" class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:text-[#669776] file:font-medium">
                        </div>
                        @error('certificate_file') <span class="text-xs text-[#ed6060] block text-right">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Pembuatan Password --}}
            <div class="boron-card bg-[#669776]/5">
                <div class="boron-card-body p-6 text-center">
                    <h5 class="mb-4 font-semibold text-[#313a46] dark:text-white">Buat Password Akun Pelanggan</h5>
                    <div class="mx-auto grid max-w-lg gap-4 sm:grid-cols-2 text-left">
                        <div>
                            <input type="password" wire:model="password" placeholder="Password" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm dark:border-[#37394d] dark:bg-transparent">
                            @error('password') <span class="text-xs text-[#ed6060]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="password" wire:model="password_confirmation" placeholder="Konfirmasi Password" class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm dark:border-[#37394d] dark:bg-transparent">
                        </div>
                    </div>
                    
                    <div class="mt-6 flex items-center justify-center gap-2 text-sm text-[#8a969c]">
                        <input type="checkbox" wire:model="accepted_terms" id="terms" class="rounded border-[#dee2e6] text-[#669776] focus:ring-[#669776]">
                        <label for="terms">Saya menyatakan bahwa seluruh data yang diberikan adalah benar.</label>
                    </div>
                    @error('accepted_terms') <div class="mt-1 text-xs text-[#ed6060]">{{ $message }}</div> @enderror

                    {{-- Tombol diubah menjadi type="submit" --}}
                    <button type="submit" class="btn-boron btn-boron-primary mx-auto mt-6 flex items-center justify-center gap-2 !px-8 !py-3 text-base shadow-lg shadow-[#669776]/30">
                        <i class="ti ti-check text-xl"></i>
                        {{ __('Kirim Formulir Berlangganan') }}
                    </button>
                </div>
            </div>
            
        </form>
    </div>
</div>