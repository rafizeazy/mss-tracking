<div class="py-6">
    {{-- Page Header --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Provisioning Tracking') }}</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">{{ __('Pantau status aktivasi dan validasi dokumen keuangan pelanggan.') }}</p>
        </div>
    </div>

    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="boron-card p-4 flex items-center gap-3">
            <div class="size-10 rounded-full bg-[#ebb751]/10 flex items-center justify-center text-[#ebb751]">
                <i class="ti ti-clock-pause text-xl"></i>
            </div>
            <div>
                <p class="text-xs text-[#8a969c]">Menunggu Validasi</p>
                <h5 class="font-bold text-[#313a46] dark:text-white">12</h5>
            </div>
        </div>
        </div>

    <div class="boron-card">
        <div class="boron-card-header">
            <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Data Progress Pelanggan') }}</h5>
        </div>
        <div class="boron-card-body">
            <div class="overflow-x-auto">
                <table class="boron-table w-full text-sm">
                    <thead>
                        <tr class="text-left border-b border-[#e7e9eb] dark:border-[#37394d]">
                            <th class="pb-3">{{ __('Customer') }}</th>
                            <th class="pb-3">{{ __('Layanan') }}</th>
                            <th class="pb-3">{{ __('Status Terakhir') }}</th>
                            <th class="pb-3">{{ __('Timeline') }}</th>
                            <th class="pb-3 text-right">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p class="font-medium text-[#313a46] dark:text-white">PT. Maju Bersama</p>
                                <p class="text-xs text-[#8a969c]">REG-2024001</p>
                            </td>
                            <td>Dedicated 50 Mbps</td>
                            <td><span class="badge-soft-warning">Menunggu Invoice Registrasi</span></td>
                            <td class="text-xs text-[#8a969c]">Update: 2 jam yang lalu</td>
                            <td class="text-right">
                                <button class="btn-boron btn-boron-primary !px-3 !py-1 text-xs">Detail</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>