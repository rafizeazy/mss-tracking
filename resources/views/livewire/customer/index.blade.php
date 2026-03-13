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
        <div class="boron-card-header flex items-center justify-between">
            <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Daftar Pelanggan Aktif') }}</h5>
            <button class="btn-boron btn-boron-outline-secondary inline-flex items-center gap-2 !px-3 !py-1.5 text-sm">
                <i class="ti ti-download text-base"></i>
                {{ __('Export Data') }}
            </button>
        </div>
        <div class="boron-card-body">
            {{-- Search Bar --}}
            <div class="mb-5 max-w-sm">
                <div class="relative">
                    <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
                    <input type="text" placeholder="{{ __('Cari nama atau ID pelanggan...') }}"
                        class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent py-2 pl-9 pr-4 text-sm placeholder:text-[#a1a9b1] focus:border-[#669776] focus:outline-none focus:ring-2 focus:ring-[#669776]/20 dark:border-[#37394d]"
                    >
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="boron-table w-full whitespace-nowrap">
                    <thead>
                        <tr>
                            <th class="text-left">{{ __('ID Pelanggan') }}</th>
                            <th class="text-left">{{ __('Nama Pelanggan') }}</th>
                            <th class="text-left">{{ __('Layanan') }}</th>
                            <th class="text-left">{{ __('Alamat Instalasi') }}</th>
                            
                            {{-- LOGIKA RBAC: Sembunyikan Header Harga jika user adalah NOC --}}
                            @if(auth()->user()->role !== \App\Enums\Role::Noc)
                                <th class="text-left">{{ __('Harga Bulanan') }}</th>
                            @endif

                            <th class="text-left">{{ __('Status') }}</th>
                            <th class="text-right">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Data Dummy Pelanggan
                            $customers = [
                                ['id' => 'MSS-CUST-001', 'name' => 'PT Karawang Sentosa', 'service' => 'Internet Dedicated 100 Mbps', 'address' => 'Kawasan Industri KIIC, Karawang', 'price' => 'Rp 5.500.000', 'status' => 'Aktif'],
                                ['id' => 'MSS-CUST-002', 'name' => 'Klinik Sehat Bersama', 'service' => 'Broadband Business 50 Mbps', 'address' => 'Jl. Tuparev, Karawang', 'price' => 'Rp 1.200.000', 'status' => 'Aktif'],
                                ['id' => 'MSS-CUST-003', 'name' => 'CV Maju Terus', 'service' => 'Internet Dedicated 50 Mbps', 'address' => 'Suryacipta, Karawang', 'price' => 'Rp 3.000.000', 'status' => 'Aktif'],
                            ];
                        @endphp

                        @foreach($customers as $cust)
                            <tr>
                                <td class="font-medium text-[#669776]">{{ $cust['id'] }}</td>
                                <td class="font-medium text-[#313a46] dark:text-white">{{ $cust['name'] }}</td>
                                <td>{{ $cust['service'] }}</td>
                                <td class="truncate max-w-[200px]" title="{{ $cust['address'] }}">{{ $cust['address'] }}</td>
                                
                                {{-- LOGIKA RBAC: Sembunyikan Isi Data Harga jika user adalah NOC --}}
                                @if(auth()->user()->role !== \App\Enums\Role::Noc)
                                    <td class="font-medium">{{ $cust['price'] }}</td>
                                @endif

                                <td><span class="badge-soft-success">{{ $cust['status'] }}</span></td>
                                <td class="text-right">
                                    <button class="boron-topbar-btn !size-8 !rounded-[0.3rem]" title="{{ __('Detail') }}">
                                        <i class="ti ti-eye text-sm text-[#60addf]"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>