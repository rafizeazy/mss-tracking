<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Dashboard Marketing') }}</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">{{ __('Kelola prospek dan pendaftaran pelanggan baru.') }}</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="boron-card">
            <div class="boron-card-header">
                <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Link Registrasi Pelanggan') }}</h5>
            </div>
            <div class="boron-card-body" x-data="{ 
                link: '{{ route('customer.register') }}', 
                copied: false,
                copyToClipboard() {
                    navigator.clipboard.writeText(this.link);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                }
            }">
                <p class="mb-4 text-sm text-[#8a969c]">
                    Bagikan tautan ini kepada calon pelanggan yang telah sepakat melakukan pemasangan layanan internet. Link ini bersifat statis dan dapat digunakan untuk semua pelanggan baru.
                </p>
                
                <div class="flex items-center gap-2">
                    <div class="relative flex-1">
                        <i class="ti ti-link absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
                        <input type="text" readonly x-model="link" 
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-[#f8f9fa] py-2 pl-9 pr-4 text-sm text-[#4c4c5c] focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#1e1f27] dark:text-[#aab8c5]"
                        >
                    </div>
                    <button @click="copyToClipboard" 
                        class="btn-boron btn-boron-primary flex items-center gap-2 whitespace-nowrap !px-4 !py-2"
                        :class="copied ? '!bg-[#70bb63] !border-[#70bb63]' : ''"
                    >
                        <i class="ti" :class="copied ? 'ti-check' : 'ti-copy'"></i>
                        <span x-text="copied ? 'Tersalin!' : 'Copy Link'"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="boron-card flex items-center justify-center border-dashed border-[#dee2e6] bg-transparent shadow-none dark:border-[#37394d]">
            <p class="text-sm text-[#8a969c]">Statistik Prospek (Coming Soon)</p>
        </div>
    </div>
</div>