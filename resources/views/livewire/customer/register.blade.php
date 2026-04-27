<div class="flex min-h-screen items-center justify-center bg-zinc-100 px-4 py-10 dark:bg-[#15151b]">
    <div class="w-full max-w-4xl">

        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-full bg-[#669776]/20">
                <i class="ti ti-wifi text-2xl text-[#669776]"></i>
            </div>
            <h2 class="text-2xl font-bold text-[#313a46] dark:text-white">Registrasi Layanan Internet</h2>
            <p class="mt-2 text-sm text-zinc-600">PT Media Solusi Sukses — Silakan lengkapi data registrasi di bawah ini.</p>
        </div>

        <div class="mb-8">
            <div class="flex items-center">
                @php
                    $steps = [
                        1 => ['label' => 'Data Pendaftar',   'icon' => 'ti-user'],
                        2 => ['label' => 'Info Perusahaan',  'icon' => 'ti-building'],
                        3 => ['label' => 'Penanggung Jawab', 'icon' => 'ti-users'],
                        4 => ['label' => 'Layanan & Dokumen','icon' => 'ti-clipboard-list'],
                    ];
                @endphp

                @foreach ($steps as $stepNumber => $info)
                    <div class="flex flex-1 flex-col items-center">
                        <div @class([
                            'relative z-10 flex size-10 items-center justify-center rounded-full border-2 text-sm font-bold transition-all duration-300',
                            'border-[#669776] bg-[#669776] text-white shadow-lg shadow-[#669776]/30' => $currentStep === $stepNumber,
                            'border-[#669776] bg-[#669776] text-white'                              => $currentStep > $stepNumber,
                            'border-[#dee2e6] bg-white text-[#adb5bd] dark:border-[#37394d] dark:bg-[#1e1e2a]' => $currentStep < $stepNumber,
                        ])>
                            @if ($currentStep > $stepNumber)
                                <i class="ti ti-check text-base"></i>
                            @else
                                <i class="{{ $info['icon'] }} text-base"></i>
                            @endif
                        </div>
                        <span @class([
                            'mt-2 text-center text-xs font-medium leading-tight',
                            'text-[#669776]'   => $currentStep >= $stepNumber,
                            'text-[#adb5bd]'   => $currentStep < $stepNumber,
                        ])>{{ $info['label'] }}</span>
                    </div>

                    @if ($stepNumber < count($steps))
                        <div class="relative -mt-5 h-0.5 flex-1">
                            <div class="h-full bg-[#dee2e6] dark:bg-[#37394d]"></div>
                            <div @class([
                                'absolute inset-0 h-full bg-[#669776] transition-all duration-500',
                                'w-full' => $currentStep > $stepNumber,
                                'w-0'    => $currentStep <= $stepNumber,
                            ])></div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        @if ($currentStep === 1)
            <div class="boron-card">
                <div class="boron-card-header border-b border-zinc-300 pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">
                        <i class="ti ti-user mr-2 text-[#669776]"></i>1. Data Pendaftar (Yang Diberi Wewenang)
                    </h5>
                </div>
                <div class="boron-card-body grid gap-5 p-6 md:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Nama Lengkap <span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="name"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('name') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Alamat Email <span class="text-[#ed6060]">*</span></label>
                        <input type="email" wire:model="email"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('email') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">No. KTP <span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="ktp_number" maxlength="16"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('ktp_number') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Jenis Kelamin <span class="text-[#ed6060]">*</span></label>
                        <select wire:model="gender"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                            <option value="">Pilih...</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('gender') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Jabatan <span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="position"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('position') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Nomor Handphone <span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="phone"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('phone') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        @endif

        @if ($currentStep === 2)
            <div class="boron-card">
                <div class="boron-card-header border-b border-zinc-300 pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">
                        <i class="ti ti-building mr-2 text-[#669776]"></i>2. Informasi Perusahaan / Institusi
                    </h5>
                </div>
                <div class="boron-card-body grid gap-5 p-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Nama Perusahaan / Institusi / Nama Usaha<span class="text-[#ed6060]">*</span></label>
                        <input type="text" wire:model="company_name"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                        @error('company_name') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Jenis / Bidang Usaha</label>
                        <input type="text" wire:model="business_type"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">NPWP Perusahaan</label>
                        <input type="text" wire:model="npwp_number"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Alamat Perusahaan <span class="text-[#ed6060]">*</span></label>
                        <textarea rows="2" wire:model="company_address"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]"></textarea>
                        @error('company_address') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Provinsi &amp; Kota/Kabupaten <span class="text-[#ed6060]">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <select wire:model.live="province_id"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:bg-[#1e1e2a]">
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                @endforeach
                            </select>
                    
                            <select wire:model="city_id"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:bg-[#1e1e2a]"
                                {{ empty($cities) ? 'disabled' : '' }}>
                                <option value="">-- Pilih Kota --</option>
                                @foreach($cities as $cit)
                                    <option value="{{ $cit->id }}">{{ $cit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('province_id') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        @error('city_id') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Kode Pos &amp; No. Telepon</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" wire:model="postal_code" placeholder="Kode Pos"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                            <input type="text" wire:model="company_phone" placeholder="No. Telepon"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($currentStep === 3)
            <div class="grid gap-6 md:grid-cols-2">

                <div class="boron-card">
                    <div class="boron-card-header border-b border-zinc-300 pb-3 dark:border-[#37394d]">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">
                            <i class="ti ti-receipt mr-2 text-[#669776]"></i>3. Penanggung Jawab Invoice/Keuangan
                        </h5>
                    </div>
                    <div class="boron-card-body space-y-4 p-6">
                        <div>
                            <label class="mb-1 block text-xs font-medium">Nama Bagian Keuangan <span class="text-[#ed6060]">*</span></label>
                            <input type="text" wire:model="finance_name"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            @error('finance_name') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">Alamat Email Keuangan <span class="text-[#ed6060]">*</span></label>
                            <input type="email" wire:model="finance_email"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            @error('finance_email') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">No. Handphone <span class="text-[#ed6060]">*</span></label>
                            <input type="text" wire:model="finance_phone"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            @error('finance_phone') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">Alamat Penagihan <span class="text-[#ed6060]">*</span></label>
                            <textarea rows="3" wire:model="billing_address"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]"></textarea>
                            @error('billing_address') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="boron-card">
                    <div class="boron-card-header border-b border-zinc-300 pb-3 dark:border-[#37394d]">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">
                            <i class="ti ti-tool mr-2 text-[#669776]"></i>4. Penanggung Jawab Teknis
                        </h5>
                    </div>
                    <div class="boron-card-body space-y-4 p-6">
                        <div>
                            <label class="mb-1 block text-xs font-medium">Nama Penanggung Jawab Teknis <span class="text-[#ed6060]">*</span></label>
                            <input type="text" wire:model="technical_name"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            @error('technical_name') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">Alamat Email Teknis <span class="text-[#ed6060]">*</span></label>
                            <input type="email" wire:model="technical_email"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            @error('technical_email') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">No. Handphone <span class="text-[#ed6060]">*</span></label>
                            <input type="text" wire:model="technical_phone"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            @error('technical_phone') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">Alamat Instalasi <span class="text-[#ed6060]">*</span></label>
                            <textarea rows="3" wire:model="installation_address"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]"></textarea>
                            @error('installation_address') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            </div>
        @endif

        @if ($currentStep === 4)
            <div x-data="{ 
                showTermsModal: false, 
                scrolledToBottom: false,
                checkScroll(e) {
                    if (e.target.scrollHeight - e.target.scrollTop <= e.target.clientHeight + 30) {
                        this.scrolledToBottom = true;
                    }
                }
            }" class="space-y-6">
                
                <div class="boron-card">
                    <div class="boron-card-header border-b border-zinc-300 pb-3 dark:border-[#37394d]">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">
                            <i class="ti ti-clipboard-list mr-2 text-[#669776]"></i>5. Detail Layanan &amp; Kelengkapan Dokumen
                        </h5>
                    </div>
                    <div class="boron-card-body grid gap-6 p-6 md:grid-cols-2">
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium">Tipe Layanan <span class="text-[#ed6060]">*</span></label>
                                <input type="text" value="Internet Dedicated 1:1" readonly
                                    class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-[#f8f9fa] px-3 py-2 text-sm text-zinc-600 cursor-not-allowed dark:border-[#37394d] dark:bg-[#15151b] dark:text-[#aab8c5]">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium">Kapasitas Bandwidth <span class="text-[#ed6060]">*</span></label>
                                <select wire:model="bandwidth"
                                    class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:bg-[#1e1e2a]">
                                    <option value="">-- Pilih Kapasitas --</option>
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
                                @error('bandwidth') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium">Jangka Waktu Berlangganan <span class="text-[#ed6060]">*</span></label>
                                <select wire:model="term_of_service"
                                    class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                                    <option value="1">1 Tahun (12 Bulan)</option>
                                    <option value="2">2 Tahun (24 Bulan)</option>
                                    <option value="3">3 Tahun (36 Bulan)</option>
                                </select>
                                @error('term_of_service') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-3 rounded-[0.3rem] border border-dashed border-[#dee2e6] p-4 dark:border-[#37394d]">
                            <p class="text-xs font-semibold uppercase text-zinc-600">Upload Dokumen Pendukung</p>
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium">File KTP <span class="text-[#ed6060]">*</span></span>
                                <input wire:model="ktp_file" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                    class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:font-medium file:text-[#669776]">
                            </div>
                            @error('ktp_file') <p class="text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium">File NPWP</span>
                                <input wire:model="npwp_file" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                    class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:font-medium file:text-[#669776]">
                            </div>
                            @error('npwp_file') <p class="text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium">File NIB</span>
                                <input wire:model="nib_file" type="file" accept=".pdf"
                                    class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:font-medium file:text-[#669776]">
                            </div>
                            @error('nib_file') <p class="text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium">Sertifikat Standar</span>
                                <input wire:model="certificate_file" type="file" accept=".pdf"
                                    class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:font-medium file:text-[#669776]">
                            </div>
                            @error('certificate_file') <p class="text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="boron-card bg-[#669776]/5">
                    <div class="boron-card-body p-6">
                        <h5 class="mb-4 text-center font-semibold text-[#313a46] dark:text-white">
                            <i class="ti ti-lock mr-2 text-[#669776]"></i>Buat Password Akun Pelanggan
                        </h5>
                        <div class="mx-auto grid max-w-lg gap-4 text-left sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium">Password <span class="text-[#ed6060]">*</span></label>
                                <input type="password" wire:model="password" placeholder="Minimal 8 karakter"
                                    class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:bg-transparent">
                                @error('password') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium">Konfirmasi Password <span class="text-[#ed6060]">*</span></label>
                                <input type="password" wire:model="password_confirmation" placeholder="Ulangi password"
                                    class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:bg-transparent">
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col items-center justify-center gap-2 text-sm">
                            <div class="flex items-center gap-2">
                                <input wire:model="accepted_terms" type="checkbox" id="terms" :disabled="!scrolledToBottom"
                                    class="size-4 rounded border-[#dee2e6] text-[#669776] focus:ring-[#669776] disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                                <label for="terms" class="text-[#313a46] dark:text-[#aab8c5] cursor-pointer">
                                    Saya telah membaca dan menyetujui <button type="button" @click="showTermsModal = true" class="font-bold text-[#1e5d87] hover:underline dark:text-[#60addf]">Syarat dan Ketentuan Berlangganan</button>.
                                </label>
                            </div>
                            <p x-show="!scrolledToBottom" class="text-xs text-[#ebb751] bg-[#ebb751]/10 px-3 py-1 rounded">
                                <i class="ti ti-info-circle"></i> Klik teks berwarna biru di atas untuk membaca Syarat & Ketentuan.
                            </p>
                            @error('accepted_terms') <p class="mt-1 text-center text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div x-show="showTermsModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" x-transition x-cloak>
                    <div class="w-full max-w-3xl bg-white dark:bg-[#1e1e2a] rounded-xl shadow-2xl flex flex-col max-h-[85vh]" @click.stop>
                        <div class="p-5 border-b border-zinc-300 dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-white/5 rounded-t-xl">
                            <h3 class="text-base font-bold text-[#313a46] dark:text-white"><i class="ti ti-file-text text-[#1e5d87] mr-1"></i> Syarat dan Ketentuan Berlangganan</h3>
                            <button @click="showTermsModal = false" class="text-zinc-600 hover:text-[#ed6060]"><i class="ti ti-x text-xl"></i></button>
                        </div>
                        
                        <div class="p-6 overflow-y-auto" @scroll="checkScroll">
                            @include('livewire.customer.partials.terms')
                        </div>
                        
                        <div class="p-5 border-t border-zinc-300 dark:border-[#37394d] bg-[#f8f9fa] dark:bg-white/5 flex justify-between items-center rounded-b-xl">
                            <div class="text-xs font-medium">
                                <span x-show="!scrolledToBottom" class="text-[#ed6060] animate-pulse"><i class="ti ti-arrow-down-circle"></i> Silakan baca (scroll) sampai ke baris paling akhir.</span>
                                <span x-show="scrolledToBottom" style="display: none;" class="text-[#70bb63]"><i class="ti ti-circle-check"></i> Syarat dan Ketentuan telah dibaca.</span>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" @click="showTermsModal = false" class="btn-boron border border-[#dee2e6] px-4 py-2 text-sm text-[#313a46] hover:bg-zinc-300 dark:border-[#37394d] dark:text-white dark:hover:bg-white/5">Tutup</button>
                                
                                <button type="button" :disabled="!scrolledToBottom" @click="$wire.set('accepted_terms', true); showTermsModal = false;" 
                                    class="btn-boron btn-boron-primary px-5 py-2 text-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-1">
                                    <i class="ti ti-check"></i> Ya, Saya Setuju
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif

        <div @class([
            'mt-6 flex items-center',
            'justify-between' => $currentStep > 1,
            'justify-end'     => $currentStep === 1,
        ])>
            @if ($currentStep > 1)
                <button type="button" wire:click="previousStep"
                    class="btn-boron flex items-center gap-2 border border-[#dee2e6] bg-white px-6 py-2.5 text-sm font-medium text-[#313a46] hover:bg-zinc-100 dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white dark:hover:bg-[#252535]">
                    <i class="ti ti-chevron-left"></i> Sebelumnya
                </button>
            @endif

            @if ($currentStep < $totalSteps)
                <button type="button" wire:click="nextStep"
                    class="btn-boron btn-boron-primary flex items-center gap-2 px-8 py-2.5 text-sm shadow-md shadow-[#669776]/30">
                    Berikutnya <i class="ti ti-chevron-right"></i>
                </button>
            @else
                <button type="button" wire:click="submit"
                    class="btn-boron btn-boron-primary flex items-center gap-2 px-8 py-2.5 text-sm shadow-lg shadow-[#669776]/30">
                    <i class="ti ti-send"></i> Kirim Formulir
                </button>
            @endif
        </div>

        <p class="mt-6 text-center text-sm text-[#8a969c]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-[#669776] hover:underline">Login di sini</a>
        </p>

    </div>
</div>