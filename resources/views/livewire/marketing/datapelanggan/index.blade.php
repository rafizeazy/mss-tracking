<div class="py-6">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
         <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">
          {{ $showDeletedOnly ? 'Layanan Terhapus Sementara' : ($showBerhentiOnly ? 'Arsip Data Pelanggan Berhenti' : 'Arsip Data Pelanggan Aktif') }}
                        </h4>
         <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">
                            {{ $showDeletedOnly ? 'Daftar layanan yang masih bisa dipulihkan oleh Super Admin.' : ($showBerhentiOnly ? 'Basis data pelanggan yang layanannya telah dihentikan.' : 'Basis data pelanggan yang layanannya telah beroperasi (100% Selesai).') }}
                        </p>
         </div>
        <div class="flex gap-2">
            <button wire:click="$toggle('showBerhentiOnly')" @disabled($showDeletedOnly) class="btn-boron {{ $showBerhentiOnly ? 'bg-[#ed6060] text-white border-transparent' : '!bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]' }} !py-2 !px-4 text-sm font-semibold shadow-sm transition-colors disabled:opacity-50">
                <i class="ti ti-hand-stop mr-1.5 text-lg"></i> {{ $showBerhentiOnly ? 'Kembali ke Aktif' : 'Lihat Pelanggan Berhenti' }}
            </button>
            @if(auth()->user()?->isSuperAdmin())
                <button wire:click="toggleDeletedOnly" class="btn-boron {{ $showDeletedOnly ? 'bg-[#ebb751] text-white border-transparent' : '!bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] dark:!bg-[#1e1f27] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]' }} !py-2 !px-4 text-sm font-semibold shadow-sm transition-colors">
                    <i class="ti ti-archive mr-1.5 text-lg"></i> {{ $showDeletedOnly ? 'Kembali ke Data Aktif' : 'Lihat Terhapus' }}
                </button>
            @endif
        </div>
    </div>

    <div class="boron-card overflow-hidden rounded-[0.4rem] border border-[#d5deea] bg-white shadow-sm dark:border-[#37394d] dark:bg-[#15151b]">
        <div class="boron-card-body p-0">
            <div class="flex flex-col gap-4 border-b border-[#d5deea] p-4 lg:flex-row lg:items-center lg:justify-between dark:border-[#37394d]">
                <div>
                    <h3 class="text-xl font-bold text-[#313a46] dark:text-white">Daftar Layanan</h3>
                    <p class="mt-1 text-sm text-[#8a969c]">Kelola dan pantau semua layanan pelanggan.</p>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row">
                <div class="relative w-full md:w-80">
                    <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-[#8a969c]"></i>
                    <input
                        type="text"
                        wire:model.live.debounce.400ms="search"
                        placeholder="Cari ID/Perusahaan..."
                        class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white py-2.5 pl-9 pr-10 text-sm text-[#313a46] shadow-sm outline-none transition focus:border-[#60addf] focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white"
                    >
                    @if($search !== '')
                        <button type="button" wire:click="$set('search', '')" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full p-1 text-[#8a969c] hover:bg-[#ed6060]/10 hover:text-[#ed6060]">
                            <i class="ti ti-x text-base"></i>
                        </button>
                    @endif
                </div>
                <button type="button" class="inline-flex items-center justify-center gap-2 rounded-[0.4rem] border border-[#dee2e6] bg-white px-4 py-2.5 text-sm font-bold text-[#313a46] shadow-sm dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">
                    <i class="ti ti-filter text-[#60addf]"></i> Filter
                </button>
                </div>
            </div>
            <div class="w-full overflow-x-auto rounded-[0.4rem] border border-[#d5deea] bg-white dark:border-[#37394d] dark:bg-[#15151b]">
                <table class="w-full min-w-[900px] text-left text-sm text-[#1f2937] dark:text-[#e7edf5]">
                    <thead class="bg-[#f1f6ff] text-[11px] uppercase tracking-wide text-[#2f4c75] dark:bg-[#1e1f27] dark:text-[#c7d4e5]">
                        <tr>
                            <th class="px-4 py-3 font-bold">ID / Perusahaan</th>
                            <th class="px-4 py-3 font-bold">Layanan</th>
                            <th class="px-4 py-3 font-bold">Tgl Aktif</th>
                            <th class="px-4 py-3 text-center font-bold">Aksi Cepat</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#e7edf5] dark:divide-[#2f3442]">
                        @php
                            $groupedServices = $services->getCollection()->groupBy('customer_id');
                        @endphp

                        @forelse ($groupedServices as $customerServices)
                            @php
                                $groupCustomer = $customerServices->first()->customer;
                                $isExpanded = ! in_array($groupCustomer->id, $collapsedCustomerIds, true);
                            @endphp

                            <tr class="bg-[#cfe0f8] text-[#0f2744] dark:bg-[#263852] dark:text-[#e8f1ff]" data-customer-group-id="{{ $groupCustomer->customer_number ?? $groupCustomer->id }}">
                                <td colspan="4" class="px-4 py-2">
                                    <button type="button" wire:click="toggleCustomerGroup({{ $groupCustomer->id }})" class="flex w-full items-center gap-2 text-left text-xs font-bold">
                                        <i class="ti {{ $isExpanded ? 'ti-building-store' : 'ti-building' }} text-[#0b6ea8] dark:text-[#60addf]"></i>
                                        <span>{{ $groupCustomer->customer_number ?? '-' }} - {{ $groupCustomer->company_name }}</span>
                                    </button>
                                </td>
                            </tr>

                            @if($isExpanded)
                                @foreach ($customerServices as $srv)
                                    <tr class="bg-white text-[#111827] hover:bg-[#f7fbff] dark:bg-[#15151b] dark:text-[#e7edf5] dark:hover:bg-[#1d2230]">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3 pl-4">
                                                <span class="h-5 border-l-2 border-[#c4d0dd] dark:border-[#4b5565]"></span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <p class="font-bold text-[#111827] dark:text-white">{{ $srv->bandwidth ?? '-' }}</p>
                                            <p class="text-xs text-[#536175] dark:text-[#aab8c5]">{{ $srv->service_type ?? '-' }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-[#111827] dark:text-[#e7edf5]">
                                            {{ $srv->baa && $srv->baa->activation_date ? $srv->baa->activation_date->format('d M Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center gap-3">
                                            @if($showDeletedOnly)
                                                <button wire:click="restoreService({{ $srv->id }})" title="Pulihkan" class="text-[#70bb63] hover:text-[#4f9d43]">
                                                    <i class="ti ti-restore text-base"></i>
                                                </button>
                                            @else
                                                <button wire:click="viewDetail({{ $srv->id }})" title="Detail" class="text-[#1e5d87] hover:text-[#60addf] dark:text-[#60addf]">
                                                    <i class="ti ti-eye text-base"></i>
                                                </button>
                                                @if(auth()->user()?->isSuperAdmin())
                                                    <button wire:click="editCustomer({{ $srv->id }})" title="Edit" class="text-[#1e5d87] hover:text-[#60addf] dark:text-[#60addf]">
                                                        <i class="ti ti-pencil text-base"></i>
                                                    </button>
                                                @endif
                                                <button wire:click="openArsip({{ $srv->id }})" title="Arsip Dokumen" class="text-[#1e5d87] hover:text-[#60addf] dark:text-[#60addf]">
                                                    <i class="ti ti-folder text-base"></i>
                                                </button>
                                                @if(auth()->user()?->isSuperAdmin())
                                                    @if($srv->status !== 'berhenti')
                                                        <button wire:click="confirmBerhentikanPelanggan({{ $srv->id }})" title="Berhenti" class="text-[#dc2626] hover:text-[#ef4444]">
                                                            <i class="ti ti-ban text-base"></i>
                                                        </button>
                                                    @else
                                                        <button wire:click="aktifkanKembaliPelanggan({{ $srv->id }})" title="Aktifkan" class="text-[#70bb63] hover:text-[#4f9d43]">
                                                            <i class="ti ti-rotate-clockwise-2 text-base"></i>
                                                        </button>
                                                    @endif
                                                    <button wire:click="confirmDeleteService({{ $srv->id }})" title="Hapus" class="text-[#dc2626] hover:text-[#ef4444]">
                                                        <i class="ti ti-trash text-base"></i>
                                                    </button>
                                                @endif
                                            @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-[#8a969c]">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="ti ti-inbox text-4xl mb-2 opacity-50"></i>
                                        <p>{{ $showDeletedOnly ? 'Belum ada layanan yang dihapus sementara.' : ($showBerhentiOnly ? 'Belum ada arsip pelanggan yang berhenti.' : 'Belum ada arsip pelanggan aktif.') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($services->hasPages())
                <div class="border-t border-[#e7e9eb] p-4 dark:border-[#37394d] flex justify-center md:justify-start">
                    <div class="w-full overflow-x-auto md:overflow-visible">
                        {{ $services->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($showModal && $selectedService)
        <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/50 backdrop-blur-sm p-0 md:p-4" wire:transition.opacity>
            <div class="bg-[#f6f7fb] dark:bg-[#15151b] rounded-t-2xl md:rounded-2xl shadow-2xl w-full max-w-7xl h-[90vh] md:h-auto md:max-h-[95vh] flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d]" @click.stop>
                
                <div class="flex-none flex items-center justify-between border-b border-[#e7e9eb] bg-white px-6 py-5 dark:border-[#37394d] dark:bg-[#1e1e2a]">
                    <div class="flex items-center gap-4">
                        <div class="flex size-10 items-center justify-center rounded-full bg-[#60addf]/10 text-[#60addf]">
                            <i class="ti ti-list-details text-xl"></i>
                        </div>
                        <div>
                            <h5 class="text-lg font-extrabold text-[#313a46] dark:text-white line-clamp-1">Detail Data: {{ $selectedService->customer->company_name }}</h5>
                            <p class="text-xs font-medium text-[#8a969c] mt-0.5">ID Pelanggan: <span class="font-bold text-[#ebb751]">{{ $selectedService->customer->customer_number ?? 'N/A' }}</span></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('form.formulir', $selectedService->id) }}" target="_blank" class="hidden sm:flex btn-boron !py-1.5 items-center gap-1.5 bg-[#1e5d87]/10 text-[#1e5d87] hover:bg-[#1e5d87]/20 border border-[#1e5d87]/20 transition-colors font-medium text-xs rounded-lg">
                            <i class="ti ti-file-text text-base"></i> Cetak Formulir
                        </a>
                        <button wire:click="closeModal" class="text-[#a1a9b1] hover:text-[#ed6060] transition-colors bg-[#f8f9fa] hover:bg-[#ed6060]/10 dark:bg-[#15151b] rounded-full p-2.5">
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
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->user->name }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Direktur (Login)</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#1e5d87] dark:border-[#37394d] dark:bg-[#15151b] dark:text-[#60addf]">{{ $selectedService->customer->user->email }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Pendaftar</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->phone ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. KTP</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->ktp_number ?? '-' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Gender</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->gender === 'L' ? 'Laki-laki' : ($selectedService->customer->gender === 'P' ? 'Perempuan' : '-') }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jabatan</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->position ?? '-' }}</div>
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
                                            <div class="w-full rounded-[0.4rem] border border-[#60addf]/30 bg-[#60addf]/5 px-3 py-2 text-sm font-bold text-[#1e5d87] dark:text-[#60addf]">{{ $selectedService->bandwidth ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kontrak</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->term_of_service ?? '-' }} Tahun</div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Layanan</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->service_type ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Instalasi</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] min-h-[50px] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedService->installation_address ?? $selectedService->customer->installation_address ?? 'Sama dengan perusahaan' }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tipe Pelanggan</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->spk->customer_type ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Tgl Aktivasi</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#70bb63] dark:border-[#37394d] dark:bg-[#15151b]">{{ $selectedService->baa && $selectedService->baa->activation_date ? $selectedService->baa->activation_date->format('d M Y') : '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Jalur Metro</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->metro_link ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">SLA</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->sla ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="border-t border-[#e7e9eb] pt-3 mt-1 dark:border-[#37394d]">
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Registrasi (Rp)</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ number_format($selectedService->registration_fee ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Biaya Bulanan (Rp)</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#ebb751]/30 bg-[#ebb751]/5 px-3 py-2 text-sm font-bold text-[#b58c3d] dark:text-[#ebb751]">{{ number_format($selectedService->monthly_fee ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                            <h6 class="font-bold text-[#60addf] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                                <i class="ti ti-building-skyscraper text-lg"></i> Instansi / Perusahaan
                            </h6>
                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Perusahaan</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-bold text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->company_name }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Bidang Usaha</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->business_type ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. NPWP</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->npwp_number ?? '-' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Telepon Kantor</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->company_phone ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Lengkap Perusahaan</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] min-h-[80px] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->company_address ?? '-' }}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kota/Kabupaten</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->city ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Provinsi</label>
                                        <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->province ?? '-' }}</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Kode Pos</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->customer->postal_code ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">ID Pelanggan (Customer ID)</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#ebb751]/30 bg-[#ebb751]/5 px-3 py-2 text-sm font-bold text-[#b58c3d] dark:text-[#ebb751]">{{ $selectedService->customer->customer_number ?? 'Belum Terbit' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Invoice Registrasi</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->invoiceRegistrasi->invoice_number ?? 'Belum Terbit' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Surat Perintah Kerja (SPK)</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->spk->spk_number ?? 'Belum Terbit' }}</div>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Berita Acara Aktivasi (BAA)</label>
                                    <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-[#f8f9fa] px-3 py-2 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white">{{ $selectedService->baa->baa_number ?? 'Belum Terbit' }}</div>
                                </div>
                                <div class="pt-4 mt-2 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                                    <label class="mb-2 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Lampiran Perusahaan</label>
                                    <div class="flex flex-wrap gap-2">
                                        @if($selectedService->customer->ktp_file_path)
                                            <a href="{{ asset('storage/' . $selectedService->customer->ktp_file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 border border-[#60addf]/30 px-2 py-1 text-[10px] font-bold text-[#1e5d87] hover:bg-[#60addf]/20 transition-colors dark:text-[#60addf]">
                                                <i class="ti ti-id text-xs"></i> KTP
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded bg-[#f8f9fa] border border-[#e7e9eb] px-2 py-1 text-[10px] font-bold text-[#a1a9b1] cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]" title="Belum Diunggah">
                                                <i class="ti ti-id text-xs"></i> KTP
                                            </span>
                                        @endif
    
                                        @if($selectedService->customer->npwp_file_path)
                                            <a href="{{ asset('storage/' . $selectedService->customer->npwp_file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 border border-[#60addf]/30 px-2 py-1 text-[10px] font-bold text-[#1e5d87] hover:bg-[#60addf]/20 transition-colors dark:text-[#60addf]">
                                                <i class="ti ti-file-barcode text-xs"></i> NPWP
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded bg-[#f8f9fa] border border-[#e7e9eb] px-2 py-1 text-[10px] font-bold text-[#a1a9b1] cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]" title="Belum Diunggah">
                                                <i class="ti ti-file-barcode text-xs"></i> NPWP
                                            </span>
                                        @endif
    
                                        @if($selectedService->customer->nib_file_path)
                                            <a href="{{ asset('storage/' . $selectedService->customer->nib_file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 border border-[#60addf]/30 px-2 py-1 text-[10px] font-bold text-[#1e5d87] hover:bg-[#60addf]/20 transition-colors dark:text-[#60addf]">
                                                <i class="ti ti-file-info text-xs"></i> NIB
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded bg-[#f8f9fa] border border-[#e7e9eb] px-2 py-1 text-[10px] font-bold text-[#a1a9b1] cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]" title="Belum Diunggah">
                                                <i class="ti ti-file-info text-xs"></i> NIB
                                            </span>
                                        @endif
    
                                        @if($selectedService->customer->certificate_file_path)
                                            <a href="{{ asset('storage/' . $selectedService->customer->certificate_file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded bg-[#60addf]/10 border border-[#60addf]/30 px-2 py-1 text-[10px] font-bold text-[#1e5d87] hover:bg-[#60addf]/20 transition-colors dark:text-[#60addf]">
                                                <i class="ti ti-certificate text-xs"></i> Sertifikat
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded bg-[#f8f9fa] border border-[#e7e9eb] px-2 py-1 text-[10px] font-bold text-[#a1a9b1] cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]" title="Belum Diunggah">
                                                <i class="ti ti-certificate text-xs"></i> Sertifikat
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[#e7e9eb] bg-white p-5 shadow-sm dark:border-[#37394d] dark:bg-[#1e1e2a]">
                            <h6 class="font-bold text-[#ebb751] mb-4 flex items-center gap-2 text-sm uppercase tracking-wide border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
                                <i class="ti ti-headset text-lg"></i> Kontak PIC
                            </h6>
                            
                            <div class="space-y-5">
                                <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                    <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-file-invoice text-[#ebb751]"></i> PIC Finance (Penagihan)</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama PIC Finance</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedService->customer->finance_name ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Finance</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white break-words">{{ $selectedService->customer->finance_email ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedService->customer->finance_phone ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Alamat Penagihan (Billing)</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] min-h-[50px] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedService->customer->billing_address ?? 'Sama dengan perusahaan' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                    <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-router text-[#ebb751]"></i> PIC Teknis (Instalasi)</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama PIC Teknis</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedService->customer->technical_name ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Email Teknis</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white break-words">{{ $selectedService->customer->technical_email ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedService->customer->technical_phone ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg border border-[#e7e9eb] p-4 bg-[#fcfcfd] dark:bg-[#15151b] dark:border-[#37394d]">
                                    <p class="text-xs font-extrabold text-[#313a46] dark:text-white border-b border-[#e7e9eb] pb-2.5 mb-3 dark:border-[#37394d] flex items-center gap-1.5"><i class="ti ti-briefcase text-[#ebb751]"></i> Data Sales / Marketing</p>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">Nama Sales / Marketing</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedService->marketing_name ?? '-' }}</div>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-[10px] font-bold text-[#8a969c] uppercase tracking-wider">No. Handphone Marketing</label>
                                            <div class="w-full rounded-[0.4rem] border border-[#e7e9eb] bg-white px-3 py-1.5 text-sm font-medium text-[#313a46] dark:border-[#37394d] dark:bg-[#1e1e2a] dark:text-white">{{ $selectedService->marketing_phone ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>
                <div class="flex-none px-6 py-4 border-t border-[#e7e9eb] dark:border-[#37394d] bg-white dark:bg-[#1e1e2a] text-right">
                    <button wire:click="closeModal" class="btn-boron btn-boron-outline-secondary !py-2 text-sm px-6 font-semibold rounded-lg">Tutup Detail</button>
                </div>
            </div>

            
        </div>
    @endif

    @if($showArsipModal && $serviceForArsip)
        <div class="fixed inset-0 z-[999] flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm p-0 md:p-4 transition-all duration-300" wire:transition.opacity>
            <div class="bg-white dark:bg-[#1e1f27] rounded-t-[1.5rem] md:rounded-2xl shadow-2xl w-full max-w-4xl flex flex-col overflow-hidden border-t md:border border-[#e7e9eb] dark:border-[#37394d] transform transition-transform h-[85vh] md:h-auto md:max-h-[90vh]" @click.stop>
                <div class="w-full flex justify-center pt-3 pb-1 md:hidden bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div class="w-12 h-1.5 bg-[#e7e9eb] rounded-full dark:bg-[#37394d]"></div>
                </div>

                <div class="px-5 md:px-6 py-4 md:py-5 border-b border-[#e7e9eb] dark:border-[#37394d] flex justify-between items-center bg-[#f8f9fa] dark:bg-[#15151b]">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 md:size-12 items-center justify-center rounded-full bg-[#1e5d87]/10 text-[#1e5d87] shrink-0">
                            <i class="ti ti-folder-open text-xl md:text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base md:text-lg text-[#313a46] dark:text-white leading-tight">Arsip Dokumen Pelanggan</h3>
                            <p class="text-[11px] md:text-xs text-[#8a969c] mt-0.5 line-clamp-1">{{ $serviceForArsip->customer->company_name }}</p>
                        </div>
                    </div>
                    <button wire:click="closeArsip" class="text-[#8a969c] bg-white border border-[#e7e9eb] md:border-transparent md:bg-transparent hover:bg-[#ed6060]/10 p-2 md:p-1.5 rounded-full hover:text-[#ed6060] transition-colors dark:bg-[#1e1e2a] dark:border-[#37394d] shrink-0">
                        <i class="ti ti-x text-lg md:text-xl"></i>
                    </button>
                </div>

                <div class="p-4 md:p-6 bg-[#fcfcfd] dark:bg-[#1e1f27] overflow-y-auto boron-scrollbar flex-1">
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
                        
                        <a href="{{ route('form.formulir', $serviceForArsip->id) }}" target="_blank" class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#1e5d87] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] dark:hover:border-[#60addf]">
                            <i class="ti ti-file-text text-3xl md:text-4xl text-[#a1a9b1] group-hover:text-[#1e5d87] mb-2 md:mb-3 transition-colors dark:group-hover:text-[#60addf]"></i>
                            <h6 class="font-bold text-xs md:text-sm text-[#313a46] dark:text-white text-center leading-tight">Formulir Registrasi</h6>
                            <span class="text-[9px] md:text-[10px] text-[#8a969c] mt-1 md:mt-1.5 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">PDF Generate</span>
                        </a>

                        <a href="{{ route('customer.invoice', $serviceForArsip->id) }}" target="_blank" class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#ebb751] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d]">
                            <i class="ti ti-file-invoice text-3xl md:text-4xl text-[#a1a9b1] group-hover:text-[#ebb751] mb-2 md:mb-3 transition-colors"></i>
                            <h6 class="font-bold text-xs md:text-sm text-[#313a46] dark:text-white text-center leading-tight">Invoice Registrasi</h6>
                            <span class="text-[9px] md:text-[10px] text-[#8a969c] mt-1 md:mt-1.5 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">PDF Generate</span>
                        </a>

                        @if($serviceForArsip->spk)
                            <a href="{{ route('marketing.spk', $serviceForArsip->id) }}" target="_blank" class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#60addf] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-description text-3xl md:text-4xl text-[#a1a9b1] group-hover:text-[#60addf] mb-2 md:mb-3 transition-colors"></i>
                                <h6 class="font-bold text-xs md:text-sm text-[#313a46] dark:text-white text-center leading-tight">SPK (Perintah Kerja)</h6>
                                <span class="text-[9px] md:text-[10px] text-[#8a969c] mt-1 md:mt-1.5 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">PDF Generate</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-description text-3xl md:text-4xl text-[#dee2e6] mb-2 md:mb-3 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-xs md:text-sm text-[#8a969c] text-center leading-tight">SPK Belum Terbit</h6>
                            </div>
                        @endif

                        @if($serviceForArsip->baa)
                            <a href="{{ route('noc.baa', $serviceForArsip->id) }}" target="_blank" class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#669776] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] dark:hover:border-[#70bb63]">
                                <i class="ti ti-certificate text-3xl md:text-4xl text-[#a1a9b1] group-hover:text-[#669776] mb-2 md:mb-3 transition-colors dark:group-hover:text-[#70bb63]"></i>
                                <h6 class="font-bold text-xs md:text-sm text-[#313a46] dark:text-white text-center leading-tight">BAA (Original)</h6>
                                <span class="text-[9px] md:text-[10px] text-[#8a969c] mt-1 md:mt-1.5 bg-[#f8f9fa] dark:bg-white/5 px-2 py-0.5 rounded">Format Kosong</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-certificate text-3xl md:text-4xl text-[#dee2e6] mb-2 md:mb-3 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-xs md:text-sm text-[#8a969c] text-center leading-tight">BAA Belum Terbit</h6>
                            </div>
                        @endif

                        @if($serviceForArsip->baa && $serviceForArsip->baa->signed_baa_path)
                            <a href="{{ asset('storage/' . $serviceForArsip->baa->signed_baa_path) }}" target="_blank" class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#70bb63] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d] shadow-[0_0_0_2px_rgba(112,187,99,0.2)]">
                                <div class="relative mb-2 md:mb-3">
                                    <i class="ti ti-file-check text-3xl md:text-4xl text-[#70bb63]"></i>
                                    <i class="ti ti-circle-check-filled text-[#70bb63] bg-white rounded-full absolute -bottom-1 -right-1 md:-right-2 text-[10px] md:text-sm border-[1.5px] md:border-2 border-white"></i>
                                </div>
                                <h6 class="font-bold text-xs md:text-sm text-[#313a46] dark:text-white text-center leading-tight">BAA (Signed)</h6>
                                <span class="text-[9px] md:text-[10px] text-[#70bb63] font-bold mt-1 md:mt-1.5 bg-[#70bb63]/10 px-2 py-0.5 rounded text-center">Telah Di-TTD</span>
                            </a>
                        @else
                            <div class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-file-x text-3xl md:text-4xl text-[#dee2e6] mb-2 md:mb-3 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-xs md:text-sm text-[#8a969c] text-center leading-tight">BAA (Signed) Belum Ada</h6>
                            </div>
                        @endif
                        @if($serviceForArsip->invoiceRegistrasi?->payment_proof_file_path)
                            <a href="{{ asset('storage/' . $serviceForArsip->invoiceRegistrasi->payment_proof_file_path) }}" target="_blank" class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-[#dee2e6] bg-white hover:border-[#60addf] hover:shadow-md transition-all group dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-receipt-2 text-3xl md:text-4xl text-[#60addf] mb-2 md:mb-3"></i>
                                <h6 class="font-bold text-xs md:text-sm text-[#313a46] dark:text-white text-center leading-tight">Bukti Transfer</h6>
                                <span class="text-[9px] md:text-[10px] text-[#60addf] font-bold mt-1 md:mt-1.5 bg-[#60addf]/10 px-2 py-0.5 rounded text-center">Lunas / Terverifikasi</span>
                            </a>
                        @elseif($serviceForArsip->service?->registration_fee == 0)
                            <div class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-dashed border-[#70bb63] bg-[#70bb63]/5 dark:bg-[#70bb63]/10 dark:border-[#70bb63]/30">
                                <i class="ti ti-gift text-3xl md:text-4xl text-[#70bb63] mb-2 md:mb-3"></i>
                                <h6 class="font-bold text-xs md:text-sm text-[#70bb63] text-center leading-tight">Bukti Transfer</h6>
                                <span class="text-[9px] md:text-[10px] text-[#70bb63] font-bold mt-1 md:mt-1.5 px-2 py-0.5 rounded border border-[#70bb63]">PROMO FREE</span>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center p-4 md:p-5 rounded-xl border border-dashed border-[#dee2e6] bg-[#f8f9fa] opacity-70 cursor-not-allowed dark:bg-[#15151b] dark:border-[#37394d]">
                                <i class="ti ti-receipt-off text-3xl md:text-4xl text-[#dee2e6] mb-2 md:mb-3 dark:text-[#37394d]"></i>
                                <h6 class="font-bold text-xs md:text-sm text-[#8a969c] text-center leading-tight">Tidak Ada Bukti Bayar</h6>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 md:hidden pb-2">
                        <button wire:click="closeArsip" class="w-full btn-boron !bg-[#f8f9fa] !text-[#313a46] border border-[#dee2e6] hover:!bg-[#e7e9eb] !py-3 text-sm font-bold rounded-xl dark:!bg-[#15151b] dark:!text-white dark:border-[#37394d] dark:hover:!bg-[#252630]">
                            Tutup Arsip
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($stoppingServiceId)
        <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" wire:transition.opacity>
            <div class="w-full max-w-md rounded-2xl border border-[#e7e9eb] bg-white p-6 shadow-2xl dark:border-[#37394d] dark:bg-[#1e1f27]">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-full bg-[#ed6060]/10 text-[#ed6060]">
                        <i class="ti ti-hand-stop text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#313a46] dark:text-white">Berhentikan Pelanggan</h3>
                        <p class="text-xs text-[#8a969c]">Alasan akan tersimpan di audit log.</p>
                    </div>
                </div>
                <textarea wire:model="stopReason" rows="4" placeholder="Tulis alasan berhenti..." class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#ed6060] focus:outline-none focus:ring-1 focus:ring-[#ed6060] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white"></textarea>
                @error('stopReason') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                <div class="mt-5 flex justify-end gap-2">
                    <button wire:click="cancelBerhenti" class="btn-boron btn-boron-outline-secondary !py-2 text-sm px-4">Batal</button>
                    <button wire:click="berhentikanPelanggan" class="btn-boron bg-[#ed6060] text-white hover:bg-[#c84d4d] !py-2 text-sm px-4 font-bold">Simpan</button>
                </div>
            </div>
        </div>
    @endif

    @if($deletingServiceId)
        <div class="fixed inset-0 z-[999] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" wire:transition.opacity>
            <div class="w-full max-w-md rounded-2xl border border-[#e7e9eb] bg-white p-6 shadow-2xl dark:border-[#37394d] dark:bg-[#1e1f27]">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-full bg-[#ed6060]/10 text-[#ed6060]">
                        <i class="ti ti-trash text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#313a46] dark:text-white">Hapus Layanan Sementara</h3>
                        <p class="text-xs text-[#8a969c]">Data layanan bisa dipulihkan dari menu Lihat Terhapus.</p>
                    </div>
                </div>
                <textarea wire:model="deleteReason" rows="4" placeholder="Tulis alasan hapus sementara..." class="w-full rounded-[0.4rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#ed6060] focus:outline-none focus:ring-1 focus:ring-[#ed6060] dark:border-[#37394d] dark:bg-[#15151b] dark:text-white"></textarea>
                @error('deleteReason') <p class="mt-1 text-xs text-[#ed6060]">{{ $message }}</p> @enderror
                <div class="mt-5 flex justify-end gap-2">
                    <button wire:click="cancelDeleteService" class="btn-boron btn-boron-outline-secondary !py-2 text-sm px-4">Batal</button>
                    <button wire:click="deleteService" class="btn-boron bg-[#ed6060] text-white hover:bg-[#c84d4d] !py-2 text-sm px-4 font-bold">Simpan</button>
                </div>
            </div>
        </div>
    @endif

    @include('livewire.marketing.tracking.modalEdit')
</div>
