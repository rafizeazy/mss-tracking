<div class="flex min-h-screen items-center justify-center bg-[#f6f7fb] px-4 py-10 dark:bg-[#15151b]">
    <div class="w-full max-w-4xl">

        {{-- Header Form --}}
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-full bg-[#669776]/20">
                <i class="ti ti-wifi text-2xl text-[#669776]"></i>
            </div>
            <h2 class="text-2xl font-bold text-[#313a46] dark:text-white">Registrasi Layanan Internet</h2>
            <p class="mt-2 text-sm text-[#8a969c]">PT Media Solusi Sukses — Silakan lengkapi data registrasi di bawah ini.</p>
        </div>

        {{-- Progress Timeline --}}
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

        {{-- STEP 1: Data Pendaftar --}}
        @if ($currentStep === 1)
            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
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

        {{-- STEP 2: Informasi Perusahaan --}}
        @if ($currentStep === 2)
            <div class="boron-card">
                <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">
                        <i class="ti ti-building mr-2 text-[#669776]"></i>2. Informasi Perusahaan / Institusi
                    </h5>
                </div>
                <div class="boron-card-body grid gap-5 p-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-1.5 block text-sm font-medium">Nama Perusahaan / Institusi <span class="text-[#ed6060]">*</span></label>
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
                        <label class="mb-1.5 block text-sm font-medium">Kota &amp; Provinsi</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" wire:model="city" placeholder="Kota"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                            <input type="text" wire:model="province" placeholder="Provinsi"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                        </div>
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

        {{-- STEP 3: Penanggung Jawab Keuangan & Teknis --}}
        @if ($currentStep === 3)
            <div class="grid gap-6 md:grid-cols-2">

                {{-- PIC Keuangan --}}
                <div class="boron-card">
                    <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">
                            <i class="ti ti-receipt mr-2 text-[#669776]"></i>3. Penanggung Jawab Invoice/Keuangan
                        </h5>
                    </div>
                    <div class="boron-card-body space-y-4 p-6">
                        <div>
                            <label class="mb-1 block text-xs font-medium">Nama Bagian Keuangan</label>
                            <input type="text" wire:model="finance_name"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">Alamat Penagihan</label>
                            <textarea rows="3" wire:model="billing_address"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]"></textarea>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">No. Handphone</label>
                            <input type="text" wire:model="finance_phone"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                        </div>
                    </div>
                </div>

                {{-- PIC Teknis --}}
                <div class="boron-card">
                    <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">
                            <i class="ti ti-tool mr-2 text-[#669776]"></i>4. Penanggung Jawab Teknis
                        </h5>
                    </div>
                    <div class="boron-card-body space-y-4 p-6">
                        <div>
                            <label class="mb-1 block text-xs font-medium">Kontak Teknis (Nama)</label>
                            <input type="text" wire:model="technical_name"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">Alamat Instalasi</label>
                            <textarea rows="3" wire:model="installation_address"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]"></textarea>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium">No. Handphone</label>
                            <input type="text" wire:model="technical_phone"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                        </div>
                    </div>
                </div>

            </div>
        @endif

        {{-- STEP 4: Layanan, Dokumen & Password --}}
        @if ($currentStep === 4)
            <div class="space-y-6">
                {{-- Detail Layanan & Dokumen --}}
                <div class="boron-card">
                    <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">
                            <i class="ti ti-clipboard-list mr-2 text-[#669776]"></i>5. Detail Layanan &amp; Kelengkapan Dokumen
                        </h5>
                    </div>
                    <div class="boron-card-body grid gap-6 p-6 md:grid-cols-2">
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium">Tipe Layanan &amp; Bandwidth <span class="text-[#ed6060]">*</span></label>
                                <input type="text" wire:model="service_type" placeholder="Contoh: Dedicated Internet 100 Mbps"
                                    class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d]">
                                @error('service_type') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
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
                            <p class="text-xs font-semibold uppercase text-[#8a969c]">Upload Dokumen Pendukung</p>
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium">File KTP</span>
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

                {{-- Buat Password --}}
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

                        <div class="mt-5 flex items-center justify-center gap-2 text-sm text-[#8a969c]">
                            <input wire:model="accepted_terms" type="checkbox" id="terms"
                                class="rounded border-[#dee2e6] text-[#669776] focus:ring-[#669776]">
                            <label for="terms">Saya menyatakan bahwa seluruh data yang diberikan adalah benar.</label>
                        </div>
                        @error('accepted_terms') <p class="mt-1 text-center text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        @endif

        {{-- Navigation Buttons --}}
        <div @class([
            'mt-6 flex items-center',
            'justify-between' => $currentStep > 1,
            'justify-end'     => $currentStep === 1,
        ])>
            @if ($currentStep > 1)
                <button type="button" wire:click="previousStep"
                    class="btn-boron flex items-center gap-2 border border-[#dee2e6] bg-white px-6 py-2.5 text-sm font-medium text-[#313a46] hover:bg-[#f6f7fb] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white dark:hover:bg-[#252535]">
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

        {{-- Login link --}}
        <p class="mt-6 text-center text-sm text-[#8a969c]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-[#669776] hover:underline">Login di sini</a>
        </p>

    </div>
</div>