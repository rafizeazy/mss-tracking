<div
    x-data="{
        storageKey: 'mss.customer.register.draft.v1',
        restoring: false,
        fields: [
            'currentStep',
            'name',
            'email',
            'ktp_number',
            'gender',
            'position',
            'phone',
            'company_name',
            'business_type',
            'npwp_number',
            'company_address',
            'province_id',
            'city_id',
            'postal_code',
            'company_phone',
            'finance_name',
            'finance_email',
            'billing_address',
            'finance_phone',
            'technical_name',
            'technical_email',
            'technical_phone',
            'bandwidth',
            'term_of_service',
            'installation_address',
            'accepted_terms',
        ],
        init() {
            this.restoreDraft();
            this.$watch('$wire.currentStep', () => this.saveDraft());
        },
        restoreDraft() {
            const rawDraft = localStorage.getItem(this.storageKey);

            if (! rawDraft) {
                return;
            }

            let draft;

            try {
                draft = JSON.parse(rawDraft);
            } catch (error) {
                localStorage.removeItem(this.storageKey);
                return;
            }

            this.restoring = true;
            this.$wire.restoreDraft(draft).then(() => {
                this.restoring = false;
            });
        },
        saveDraft() {
            if (this.restoring) {
                return;
            }

            const draft = {};

            this.fields.forEach((field) => {
                draft[field] = this.$wire.get(field);
            });

            localStorage.setItem(this.storageKey, JSON.stringify(draft));
        },
        clearDraft() {
            localStorage.removeItem(this.storageKey);
        },
    }"
    x-on:input.debounce.500ms="saveDraft()"
    x-on:change.debounce.500ms="saveDraft()"
    x-on:registration-submitted.window="clearDraft()"
    class="flex min-h-screen items-center justify-center bg-zinc-100 px-4 py-10 dark:bg-[#15151b]"
>
    <div class="w-full max-w-4xl">

        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex items-center justify-center">
                <img src="{{ asset('logo/Logo MSS.png') }}" alt="Logo MSS" class="object-contain" style="width: 96px; height: auto;">
            </div>
            <h2 class="text-2xl font-bold text-[#313a46] dark:text-white">Registrasi Layanan Internet</h2>
            <p class="mt-2 text-sm text-zinc-600">PT Media Solusi Sukses — Silakan lengkapi data registrasi di bawah ini.</p>
        </div>

        <div class="mb-8">
            <div class="flex items-center">
                @php
                    $steps = [
                        1 => ['label' => 'Data Pendaftar',   'icon' => 'ti ti-user-circle'],
                        2 => ['label' => 'Info Perusahaan',  'icon' => 'ti ti-building-skyscraper'],
                        3 => ['label' => 'Penanggung Jawab', 'icon' => 'ti ti-user-shield'],
                        4 => ['label' => 'Layanan & Dokumen','icon' => 'ti ti-file-description'],
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
                        <input type="text" wire:model="ktp_number" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
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
                        <input type="text" wire:model="phone" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
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
                        <input type="text" wire:model="npwp_number" oninput="this.value = this.value.replace(/[^0-9.-]/g, '')"
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
                            <input type="text" wire:model="postal_code" placeholder="Kode Pos" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d]">
                            <input type="text" wire:model="company_phone" placeholder="No. Telepon" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
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
                            <input type="text" wire:model="finance_phone" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
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
                            <input type="text" wire:model="technical_phone" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]">
                            @error('technical_phone') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
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
                            <div>
                                <label class="mb-1.5 block text-sm font-medium">Alamat Instalasi Layanan <span class="text-[#ed6060]">*</span></label>
                                <textarea rows="3" wire:model="installation_address" placeholder="masukkan alamat lengkap"
                                    class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent px-3 py-1.5 text-sm dark:border-[#37394d]"></textarea>
                                @error('installation_address') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-3 rounded-[0.3rem] border border-dashed border-[#dee2e6] p-4 dark:border-[#37394d]" x-data="{
                            previewOpen: false,
                            previewUrl: '',
                            previewType: '',
                            previewName: '',
                            docs: {},
                            setPreview(key, event) {
                                const file = event.target.files[0];
                                if (!file) {
                                    this.docs[key] = null;
                                    return;
                                }

                                const type = file.type.startsWith('image/') ? 'image' : (file.type === 'application/pdf' ? 'pdf' : 'file');
                                const existing = this.docs[key]?.url;
                                if (existing) {
                                    URL.revokeObjectURL(existing);
                                }

                                this.docs[key] = {
                                    name: file.name,
                                    size: (file.size / 1024 / 1024).toFixed(2),
                                    type,
                                    url: type === 'file' ? '' : URL.createObjectURL(file),
                                };
                            },
                            openPreview(key) {
                                const doc = this.docs[key];
                                if (!doc?.url) {
                                    return;
                                }

                                this.previewUrl = doc.url;
                                this.previewType = doc.type;
                                this.previewName = doc.name;
                                this.previewOpen = true;
                            }
                        }">
                            <p class="text-xs font-semibold uppercase text-zinc-600">Upload Dokumen Pendukung</p>
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium">File KTP <span class="text-[#ed6060]">*</span><span class="mt-0.5 block text-[10px] font-normal text-[#8a969c]">JPG, PNG, atau PDF. Maks. 5 MB.</span></span>
                                <input wire:model="ktp_file" @change="setPreview('ktp', $event)" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                    class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:font-medium file:text-[#669776]">
                            </div>
                            <div x-show="docs.ktp" class="flex items-center justify-between rounded bg-[#f8f9fa] px-3 py-2 text-xs dark:bg-white/5" style="display: none;">
                                <span class="truncate text-[#4c4c5c] dark:text-[#aab8c5]" x-text="`${docs.ktp.name} (${docs.ktp.size} MB)`"></span>
                                <button type="button" x-show="docs.ktp.url" @click="openPreview('ktp')" class="font-bold text-[#1e5d87] hover:underline dark:text-[#60addf]">Preview</button>
                            </div>
                            @error('ktp_file') <p class="text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium">File NPWP<span class="mt-0.5 block text-[10px] font-normal text-[#8a969c]">JPG, PNG, atau PDF. Maks. 5 MB.</span></span>
                                <input wire:model="npwp_file" @change="setPreview('npwp', $event)" type="file" accept=".jpg,.jpeg,.png,.pdf"
                                    class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:font-medium file:text-[#669776]">
                            </div>
                            <div x-show="docs.npwp" class="flex items-center justify-between rounded bg-[#f8f9fa] px-3 py-2 text-xs dark:bg-white/5" style="display: none;">
                                <span class="truncate text-[#4c4c5c] dark:text-[#aab8c5]" x-text="`${docs.npwp.name} (${docs.npwp.size} MB)`"></span>
                                <button type="button" x-show="docs.npwp.url" @click="openPreview('npwp')" class="font-bold text-[#1e5d87] hover:underline dark:text-[#60addf]">Preview</button>
                            </div>
                            @error('npwp_file') <p class="text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium">File NIB<span class="mt-0.5 block text-[10px] font-normal text-[#8a969c]">PDF. Maks. 5 MB.</span></span>
                                <input wire:model="nib_file" @change="setPreview('nib', $event)" type="file" accept=".pdf"
                                    class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:font-medium file:text-[#669776]">
                            </div>
                            <div x-show="docs.nib" class="flex items-center justify-between rounded bg-[#f8f9fa] px-3 py-2 text-xs dark:bg-white/5" style="display: none;">
                                <span class="truncate text-[#4c4c5c] dark:text-[#aab8c5]" x-text="`${docs.nib.name} (${docs.nib.size} MB)`"></span>
                                <button type="button" x-show="docs.nib.url" @click="openPreview('nib')" class="font-bold text-[#1e5d87] hover:underline dark:text-[#60addf]">Preview</button>
                            </div>
                            @error('nib_file') <p class="text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            <div class="flex items-center justify-between gap-3 text-sm">
                                <span class="font-medium">Sertifikat Standar<span class="mt-0.5 block text-[10px] font-normal text-[#8a969c]">PDF. Maks. 5 MB.</span></span>
                                <input wire:model="certificate_file" @change="setPreview('certificate', $event)" type="file" accept=".pdf"
                                    class="block w-full max-w-[200px] text-xs file:mr-2 file:rounded file:border-0 file:bg-[#669776]/10 file:px-2 file:py-1 file:font-medium file:text-[#669776]">
                            </div>
                            <div x-show="docs.certificate" class="flex items-center justify-between rounded bg-[#f8f9fa] px-3 py-2 text-xs dark:bg-white/5" style="display: none;">
                                <span class="truncate text-[#4c4c5c] dark:text-[#aab8c5]" x-text="`${docs.certificate.name} (${docs.certificate.size} MB)`"></span>
                                <button type="button" x-show="docs.certificate.url" @click="openPreview('certificate')" class="font-bold text-[#1e5d87] hover:underline dark:text-[#60addf]">Preview</button>
                            </div>
                            @error('certificate_file') <p class="text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                            <p wire:loading wire:target="ktp_file,npwp_file,nib_file,certificate_file" class="text-xs font-medium text-[#ebb751]">
                                <i class="ti ti-loader-2 animate-spin"></i> Mengunggah dokumen...
                            </p>

                            <div x-show="previewOpen" style="display: none;" class="fixed inset-0 z-[999] flex items-center justify-center bg-black/70 p-4" x-transition.opacity>
                                <div class="flex h-[85vh] w-full max-w-4xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-[#1e1f27]">
                                    <div class="flex items-center justify-between border-b border-[#e7e9eb] px-5 py-4 dark:border-[#37394d]">
                                        <h3 class="truncate text-sm font-bold text-[#313a46] dark:text-white" x-text="previewName"></h3>
                                        <button type="button" @click="previewOpen = false" class="rounded-full p-2 text-[#8a969c] hover:bg-[#ed6060]/10 hover:text-[#ed6060]">
                                            <i class="ti ti-x text-lg"></i>
                                        </button>
                                    </div>
                                    <div class="flex-1 overflow-auto bg-[#f8f9fa] p-4 dark:bg-[#15151b]">
                                        <img x-show="previewType === 'image'" :src="previewUrl" class="mx-auto max-h-full rounded border border-[#dee2e6] object-contain dark:border-[#37394d]" alt="Preview dokumen">
                                        <iframe x-show="previewType === 'pdf'" :src="previewUrl" class="h-full min-h-[70vh] w-full rounded border border-[#dee2e6] bg-white dark:border-[#37394d]"></iframe>
                                    </div>
                                </div>
                            </div>
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
                                
                                <button type="button" :disabled="!scrolledToBottom" @click="$wire.set('accepted_terms', true); showTermsModal = false; $nextTick(() => saveDraft());" 
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
                <button type="button" wire:click="submit" wire:loading.attr="disabled" wire:target="ktp_file,npwp_file,nib_file,certificate_file,submit"
                    class="btn-boron btn-boron-primary flex items-center gap-2 px-8 py-2.5 text-sm shadow-lg shadow-[#669776]/30 disabled:cursor-not-allowed disabled:opacity-60">
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
