<div class="py-6">
    {{-- Page Title & Breadcrumb --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div>
            <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">{{ __('Data Pelanggan') }}</h4>
            <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">{{ __('Daftar pelanggan aktif PT Media Solusi Sukses.') }}</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-[#8a969c]">
            <i class="ti ti-home text-base"></i>
            <span>/</span>
            <span class="font-medium text-[#313a46] dark:text-white">{{ __('Data Pelanggan') }}</span>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="boron-card">
        <div class="boron-card-header flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-[#e7e9eb] pb-4 dark:border-[#37394d] gap-3 sm:gap-0">
            <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Daftar Pelanggan Aktif') }}</h5>
            <button class="w-full sm:w-auto btn-boron btn-boron-outline-secondary inline-flex justify-center items-center gap-2 !px-4 !py-2 sm:!px-3 sm:!py-1.5 text-sm rounded-lg sm:rounded">
                <i class="ti ti-download text-base"></i>
                {{ __('Export Data') }}
            </button>
        </div>
        <div class="boron-card-body p-0">
            
            {{-- Search Bar --}}
            <div class="p-4 sm:p-5 border-b border-[#e7e9eb] dark:border-[#37394d]">
                <div class="w-full sm:max-w-sm">
                    <div class="relative">
                        <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
                        <input type="text" wire:model.live="search" placeholder="{{ __('Cari nama atau ID pelanggan...') }}"
                            class="w-full rounded-lg sm:rounded-[0.3rem] border border-[#dee2e6] bg-transparent py-2.5 sm:py-2 pl-9 pr-4 text-sm placeholder:text-[#a1a9b1] focus:border-[#669776] focus:outline-none focus:ring-2 focus:ring-[#669776]/20 dark:border-[#37394d]"
                        >
                    </div>
                </div>
            </div>

            {{-- Table (Responsive Table-to-Card) --}}
            <div class="w-full">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5] block md:table">
                    
                    <thead class="hidden md:table-header-group bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">{{ __('ID / PERUSAHAAN') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('LAYANAN & KAPASITAS') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('ALAMAT INSTALASI') }}</th>
                            
                            {{-- LOGIKA RBAC: Sembunyikan Header Harga jika user adalah NOC --}}
                            @if(auth()->user()->role !== \App\Enums\Role::Noc)
                                <th class="px-6 py-4 font-semibold">{{ __('BIAYA BULANAN') }}</th>
                            @endif

                            <th class="px-6 py-4 font-semibold">{{ __('STATUS') }}</th>
                            <th class="px-6 py-4 text-center font-semibold">{{ __('AKSI') }}</th>
                        </tr>
                    </thead>
                    
                    <tbody class="block md:table-row-group divide-y-0 md:divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        @forelse ($customers ?? [] as $cust)
                            <tr class="flex flex-col md:table-row border-b border-[#e7e9eb] md:border-none dark:border-[#37394d] p-5 md:p-0 gap-3 md:gap-0 hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                
                                <!-- ID / Perusahaan -->
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">ID / Perusahaan</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold text-[#ebb751] text-xs mb-0.5">{{ $cust->customer_number ?? '-' }}</p>
                                        <p class="font-bold md:font-medium text-[#313a46] dark:text-white">{{ $cust->company_name }}</p>
                                    </div>
                                </td>
                                
                                <!-- Layanan & Kapasitas -->
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Layanan</span>
                                    <div class="text-right md:text-left">
                                        <p class="font-bold md:font-medium text-[#1e5d87] dark:text-[#60addf] md:text-[#313a46] md:dark:text-white">{{ $cust->bandwidth }}</p>
                                        <p class="text-[11px] md:text-xs text-[#8a969c] mt-0.5">{{ $cust->service_type }}</p>
                                    </div>
                                </td>
                                
                                <!-- Alamat Instalasi -->
                                <td class="flex justify-between items-start md:items-center md:table-cell md:px-6 md:py-4 border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase mt-0.5">Alamat</span>
                                    <p class="text-right md:text-left text-[13px] md:text-sm text-[#313a46] dark:text-white w-[60%] md:w-auto md:truncate md:max-w-[200px]" title="{{ $cust->installation_address ?? $cust->company_address }}">
                                        {{ $cust->installation_address ?? $cust->company_address ?? '-' }}
                                    </p>
                                </td>
                                
                                {{-- LOGIKA RBAC: Sembunyikan Isi Data Harga jika user adalah NOC --}}
                                @if(auth()->user()->role !== \App\Enums\Role::Noc)
                                    <!-- Biaya Bulanan -->
                                    <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap border-b border-dashed border-[#e7e9eb] md:border-none dark:border-[#37394d] pb-3 md:pb-0">
                                        <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">B. Bulanan</span>
                                        <span class="font-bold md:font-medium text-[#70bb63]">Rp {{ number_format($cust->monthly_fee ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                @endif

                                <!-- Status -->
                                <td class="flex justify-between items-center md:table-cell md:px-6 md:py-4 whitespace-nowrap pb-1 md:pb-0">
                                    <span class="text-[11px] font-bold text-[#8a969c] md:hidden uppercase">Status</span>
                                    <span class="inline-flex rounded border px-2.5 py-1 text-[10px] md:text-[11px] font-bold uppercase bg-[#70bb63]/10 text-[#70bb63] border-[#70bb63]/20">
                                        Aktif
                                    </span>
                                </td>
                                
                                <!-- Aksi -->
                                <td class="md:px-6 md:py-4 md:text-center mt-3 md:mt-0 block md:table-cell">
                                    <button @if(method_exists($this, 'viewDetail')) wire:click="viewDetail({{ $cust->id }})" @endif class="w-full md:w-auto inline-flex justify-center items-center btn-boron btn-boron-outline-primary !px-4 !py-2.5 md:!px-2 md:!py-1 text-sm md:text-[11px] shadow-sm gap-1 mx-auto rounded-lg md:rounded">
                                        <i class="ti ti-eye text-lg md:text-base mr-1 md:mr-0"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row">
                                <td colspan="{{ auth()->user()->role !== \App\Enums\Role::Noc ? '6' : '5' }}" class="block md:table-cell px-6 py-12 text-center text-[#8a969c]">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="ti ti-users text-4xl mb-2 opacity-50"></i>
                                        <p>Belum ada data pelanggan di dalam sistem.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if(isset($customers) && method_exists($customers, 'hasPages') && $customers->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d] flex justify-center md:justify-start">
                    <div class="w-full overflow-x-auto md:overflow-visible">
                        {{ $customers->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Render Modal Detail Jika Ada --}}
    @if(isset($showModal) && $showModal && isset($selectedCustomer))
        @include('livewire.marketing.datapelanggan._modal_detail')
    @endif
</div>