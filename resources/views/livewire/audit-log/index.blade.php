<div class="py-6">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">Audit Log Aktivitas</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">Riwayat aktivitas sistem, user, customer, status, dan alasan perubahan.</p>
        </div>
    </div>

    <div class="boron-card mb-6">
        <div class="boron-card-header border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
            <h5 class="font-semibold text-[#313a46] dark:text-white">Filter Log</h5>
        </div>
        <div class="boron-card-body grid gap-4 p-5 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <label class="mb-1.5 block text-xs font-semibold uppercase text-[#8a969c]">Search</label>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari deskripsi, reason, action, user, atau customer..." class="w-full rounded-[0.35rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none focus:ring-1 focus:ring-[#669776] dark:border-[#37394d] dark:bg-[#15151b]">
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase text-[#8a969c]">Action</label>
                <select wire:model.live="action" class="w-full rounded-[0.35rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#15151b]">
                    <option value="">Semua action</option>
                    @foreach($actions as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase text-[#8a969c]">Role Pelaku</label>
                <select wire:model.live="role" class="w-full rounded-[0.35rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#15151b]">
                    <option value="">Semua role</option>
                    @foreach($roles as $item)
                        <option value="{{ $item->value }}">{{ $item->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase text-[#8a969c]">User Pelaku</label>
                <select wire:model.live="userId" class="w-full rounded-[0.35rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#15151b]">
                    <option value="">Semua user</option>
                    @foreach($users as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->email }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase text-[#8a969c]">Customer</label>
                <select wire:model.live="customerId" class="w-full rounded-[0.35rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#15151b]">
                    <option value="">Semua customer</option>
                    @foreach($customers as $item)
                        <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase text-[#8a969c]">Tanggal Dari</label>
                <input type="date" wire:model.live="dateFrom" class="w-full rounded-[0.35rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#15151b]">
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase text-[#8a969c]">Tanggal Sampai</label>
                <input type="date" wire:model.live="dateTo" class="w-full rounded-[0.35rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#15151b]">
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase text-[#8a969c]">Per Halaman</label>
                <select wire:model.live="perPage" class="w-full rounded-[0.35rem] border border-[#dee2e6] bg-white px-3 py-2 text-sm focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#15151b]">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="button" wire:click="resetFilters" class="btn-boron w-full border border-[#dee2e6] px-4 py-2 text-sm text-[#313a46] hover:bg-zinc-100 dark:border-[#37394d] dark:text-white dark:hover:bg-white/5">
                    Reset Filter
                </button>
            </div>
        </div>
    </div>

    <div class="boron-card overflow-hidden">
        <div class="boron-card-header flex flex-wrap items-center justify-between gap-3 border-b border-[#e7e9eb] pb-3 dark:border-[#37394d]">
            <h5 class="font-semibold text-[#313a46] dark:text-white">Riwayat Aktivitas</h5>
            <span class="rounded-full bg-[#669776]/10 px-3 py-1 text-xs font-semibold text-[#669776]">{{ $logs->total() }} log</span>
        </div>

        <div class="boron-card-body overflow-x-auto p-0">
            <table class="w-full min-w-[980px] text-left text-sm">
                <thead class="border-b border-[#e7e9eb] bg-[#f8f9fa] text-xs uppercase text-[#8a969c] dark:border-[#37394d] dark:bg-white/5">
                    <tr>
                        <th class="px-5 py-3 font-bold">Waktu</th>
                        <th class="px-5 py-3 font-bold">Pelaku</th>
                        <th class="px-5 py-3 font-bold">Customer</th>
                        <th class="px-5 py-3 font-bold">Action</th>
                        <th class="px-5 py-3 font-bold">Deskripsi</th>
                        <th class="px-5 py-3 font-bold">Reason</th>
                        <th class="px-5 py-3 font-bold">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e7e9eb] dark:divide-[#37394d]">
                    @forelse($logs as $log)
                        <tr class="hover:bg-[#f8f9fa] dark:hover:bg-white/5">
                            <td class="whitespace-nowrap px-5 py-4 text-xs text-[#8a969c]">
                                <div class="font-semibold text-[#313a46] dark:text-white">{{ $log->created_at->format('d M Y') }}</div>
                                <div>{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[#313a46] dark:text-white">{{ $log->user?->name ?? 'Sistem' }}</div>
                                <div class="text-xs text-[#8a969c]">{{ $log->user?->email ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-4 font-medium text-[#313a46] dark:text-white">{{ $log->customer?->company_name ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-[#60addf]/10 px-2.5 py-1 text-xs font-semibold text-[#1e5d87] dark:text-[#60addf]">{{ $log->action }}</span>
                            </td>
                            <td class="max-w-xs px-5 py-4 text-[#4c4c5c] dark:text-[#aab8c5]">{{ $log->description }}</td>
                            <td class="max-w-xs px-5 py-4 text-[#4c4c5c] dark:text-[#aab8c5]">{{ $log->reason ?: '-' }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-xs text-[#8a969c]">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-sm text-[#8a969c]">Belum ada audit log yang cocok dengan filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-[#e7e9eb] px-5 py-4 dark:border-[#37394d]">
            {{ $logs->links() }}
        </div>
    </div>
</div>
