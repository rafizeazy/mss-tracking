<div class="py-6">
    {{-- Page Title --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Data Pelanggan') }}</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">{{ __('Daftar pelanggan aktif PT Media Solusi Sukses.') }}</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-[#8a969c]">
            <i class="ti ti-home text-base"></i>
            <span>/</span>
            <span class="font-medium text-[#313a46] dark:text-white">{{ __('Data Pelanggan') }}</span>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="boron-card">
        <div class="boron-card-header flex items-center justify-between border-b border-[#e7e9eb] pb-4 dark:border-[#37394d]">
            <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Daftar Pelanggan Aktif') }}</h5>
            <button class="btn-boron btn-boron-outline-secondary inline-flex items-center gap-2 !px-3 !py-1.5 text-sm">
                <i class="ti ti-download text-base"></i>
                {{ __('Export Data') }}
            </button>
        </div>
        <div class="boron-card-body p-0">
            
            {{-- Search Bar --}}
            <div class="p-5 border-b border-[#e7e9eb] dark:border-[#37394d]">
                <div class="max-w-sm">
                    <div class="relative">
                        <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
                        <input type="text" wire:model.live="search" placeholder="{{ __('Cari nama atau ID pelanggan...') }}"
                            class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent py-2 pl-9 pr-4 text-sm placeholder:text-[#a1a9b1] focus:border-[#669776] focus:outline-none focus:ring-2 focus:ring-[#669776]/20 dark:border-[#37394d]"
                        >
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-[#4c4c5c] dark:text-[#aab8c5]">
                    <thead class="bg-[#f8f9fa] text-xs uppercase text-[#313a46] dark:bg-[#1e1f27] dark:text-white">
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
                    <tbody class="divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                        {{-- Menggunakan Variabel Asli dari Database --}}
                        @forelse ($customers ?? [] as $cust)
                            <tr class="hover:bg-[#f8f9fa] dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-[#ebb751] text-xs mb-0.5">{{ $cust->customer_number ?? '-' }}</p>
                                    <p class="font-medium text-[#313a46] dark:text-white">{{ $cust->company_name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-[#313a46] dark:text-white">{{ $cust->bandwidth }}</p>
                                    <p class="text-[11px] text-[#8a969c] mt-0.5">{{ $cust->service_type }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="truncate max-w-[200px]" title="{{ $cust->installation_address ?? $cust->company_address }}">
                                        {{ $cust->installation_address ?? $cust->company_address ?? '-' }}
                                    </p>
                                </td>
                                
                                {{-- LOGIKA RBAC: Sembunyikan Isi Data Harga jika user adalah NOC --}}
                                @if(auth()->user()->role !== \App\Enums\Role::Noc)
                                    <td class="px-6 py-4 font-medium text-[#70bb63]">
                                        Rp {{ number_format($cust->monthly_fee ?? 0, 0, ',', '.') }}
                                    </td>
                                @endif

                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded border px-2.5 py-1 text-[11px] font-bold uppercase bg-[#70bb63]/10 text-[#70bb63] border-[#70bb63]/20">
                                        Aktif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button @if(method_exists($this, 'viewDetail')) wire:click="viewDetail({{ $cust->id }})" @endif class="btn-boron btn-boron-outline-primary !px-2 !py-1 text-[11px] shadow-sm flex items-center gap-1 mx-auto">
                                        <i class="ti ti-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role !== \App\Enums\Role::Noc ? '6' : '5' }}" class="px-6 py-8 text-center text-[#8a969c]">
                                    Belum ada data pelanggan di dalam sistem.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if(isset($customers) && method_exists($customers, 'hasPages') && $customers->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d]">
                    {{ $customers->links() }}
                </div>
            @endif

        </div>
    </div>

    {{-- Render Modal Detail Jika Ada --}}
    @if(isset($showModal) && $showModal && isset($selectedCustomer))
        @include('livewire.marketing.datapelanggan._modal_detail') {{-- Anda bisa menyesuaikan path ini jika Anda memisahkan modal ke komponen terpisah --}}
    @endif
</div>