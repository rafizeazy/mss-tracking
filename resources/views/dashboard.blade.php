<x-layouts::app :title="__('Dashboard')">
    <div class="py-6">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Dashboard') }}</h4>
                <p class="mt-0.5 text-sm text-[#8a969c]">{{ __('Welcome back, :name!', ['name' => Str::words(auth()->user()->name, 1, '')]) }}</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-[#8a969c]">
                <i class="ti ti-home text-base"></i>
                <span>/</span>
                <span class="font-medium text-[#313a46] dark:text-white">{{ __('Dashboard') }}</span>
            </div>
        </div>

        @if(auth()->user()->role === \App\Enums\Role::Marketing)
            <div class="mb-6 boron-card border border-[#669776]/30 shadow-sm dark:border-[#669776]/30">
                <div class="boron-card-header bg-[#669776]/10 pb-3">
                    <h5 class="font-semibold text-[#669776] dark:text-[#70bb63]">
                        <i class="ti ti-link mr-1"></i> {{ __('Link Registrasi Pelanggan Baru') }}
                    </h5>
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
                        {{ __('Salin dan bagikan tautan ini kepada calon pelanggan yang telah sepakat untuk melakukan registrasi layanan internet. Tautan ini bersifat statis.') }}
                    </p>
                    
                    <div class="flex items-center gap-2 max-w-2xl">
                        <div class="relative flex-1">
                            <i class="ti ti-world absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
                            <input type="text" readonly x-model="link" 
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-[#f8f9fa] py-2 pl-9 pr-4 text-sm text-[#4c4c5c] focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#1e1f27] dark:text-[#aab8c5]"
                            >
                        </div>
                        <button @click="copyToClipboard" 
                            class="btn-boron btn-boron-primary flex items-center gap-2 whitespace-nowrap !px-4 !py-2 transition-colors"
                            :class="copied ? '!bg-[#70bb63] !border-[#70bb63]' : ''"
                        >
                            <i class="ti" :class="copied ? 'ti-check' : 'ti-copy'"></i>
                            <span x-text="copied ? 'Tersalin!' : 'Copy Link'"></span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @php
                $stats = [
                    ['label' => 'Total Shipments', 'value' => '1,284', 'change' => '+12.5%', 'up' => true, 'icon' => 'ti-truck-delivery', 'color' => '#669776', 'bg' => 'rgba(102,151,118,0.18)'],
                    ['label' => 'Active Tracking', 'value' => '342', 'change' => '+8.2%', 'up' => true, 'icon' => 'ti-map-pin', 'color' => '#60addf', 'bg' => 'rgba(96,173,223,0.18)'],
                    ['label' => 'Pending Review', 'value' => '56', 'change' => '-3.1%', 'up' => false, 'icon' => 'ti-clock-hour-3', 'color' => '#ebb751', 'bg' => 'rgba(235,183,81,0.18)'],
                    ['label' => 'Issues Reported', 'value' => '8', 'change' => '+2.4%', 'up' => false, 'icon' => 'ti-alert-triangle', 'color' => '#ed6060', 'bg' => 'rgba(237,96,96,0.18)'],
                ];
            @endphp

            @foreach($stats as $stat)
                <div class="boron-card">
                    <div class="boron-card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="mb-1 text-sm text-[#8a969c]">{{ __($stat['label']) }}</p>
                                <h3 class="text-2xl font-bold text-[#313a46] dark:text-white">{{ $stat['value'] }}</h3>
                            </div>
                            <span class="flex size-12 items-center justify-center rounded-full" style="background: {{ $stat['bg'] }};">
                                <i class="ti {{ $stat['icon'] }} text-xl" style="color: {{ $stat['color'] }};"></i>
                            </span>
                        </div>
                        <div class="mt-3 flex items-center gap-1.5">
                            @if($stat['up'])
                                <i class="ti ti-caret-up-filled text-sm text-[#70bb63]"></i>
                                <span class="text-sm font-medium text-[#70bb63]">{{ $stat['change'] }}</span>
                            @else
                                <i class="ti ti-caret-down-filled text-sm text-[#ed6060]"></i>
                                <span class="text-sm font-medium text-[#ed6060]">{{ $stat['change'] }}</span>
                            @endif
                            <span class="text-xs text-[#8a969c]">{{ __('vs last month') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 grid gap-5 lg:grid-cols-3">
            <div class="boron-card lg:col-span-2">
                <div class="boron-card-header">
                    <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Recent Activity') }}</h5>
                    <span class="badge-soft-secondary">{{ __('Last 7 days') }}</span>
                </div>
                <div class="boron-card-body">
                    @php
                        $activities = [
                            ['icon' => 'ti-package', 'color' => '#669776', 'title' => 'Shipment #MSS-2847 delivered', 'time' => '2 hours ago', 'desc' => 'Successfully delivered to Kuala Lumpur hub'],
                            ['icon' => 'ti-alert-circle', 'color' => '#ebb751', 'title' => 'Delay reported on #MSS-2831', 'time' => '4 hours ago', 'desc' => 'Weather conditions causing transit delay'],
                            ['icon' => 'ti-circle-check', 'color' => '#60addf', 'title' => 'Invoice #INV-1042 approved', 'time' => '6 hours ago', 'desc' => 'Finance team approved the billing'],
                            ['icon' => 'ti-user-plus', 'color' => '#669776', 'title' => 'New user account created', 'time' => '1 day ago', 'desc' => 'NOC team member added to the system'],
                            ['icon' => 'ti-package', 'color' => '#ed6060', 'title' => 'Shipment #MSS-2820 returned', 'time' => '2 days ago', 'desc' => 'Address verification failed'],
                        ];
                    @endphp

                    <div class="boron-timeline">
                        @foreach($activities as $activity)
                            <div class="timeline-item">
                                <div class="timeline-dot" style="background: {{ $activity['color'] }}20; border-color: {{ $activity['color'] }};"></div>
                                <div class="timeline-content">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3">
                                            <span class="mt-0.5 flex size-8 shrink-0 items-center justify-center rounded-full" style="background: {{ $activity['color'] }}20;">
                                                <i class="ti {{ $activity['icon'] }} text-base" style="color: {{ $activity['color'] }};"></i>
                                            </span>
                                            <div>
                                                <p class="text-sm font-medium text-[#313a46] dark:text-white">{{ $activity['title'] }}</p>
                                                <p class="mt-0.5 text-xs text-[#8a969c]">{{ $activity['desc'] }}</p>
                                            </div>
                                        </div>
                                        <span class="shrink-0 whitespace-nowrap text-xs text-[#8a969c]">{{ $activity['time'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="boron-card">
                    <div class="boron-card-header">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('System Status') }}</h5>
                    </div>
                    <div class="boron-card-body">
                        <div class="space-y-3">
                            @php
                                $services = [
                                    ['name' => 'API Gateway', 'status' => 'Operational', 'ok' => true],
                                    ['name' => 'Tracking Service', 'status' => 'Operational', 'ok' => true],
                                    ['name' => 'Notification Queue', 'status' => 'Degraded', 'ok' => false],
                                    ['name' => 'Database', 'status' => 'Operational', 'ok' => true],
                                ];
                            @endphp
                            @foreach($services as $service)
                                <div class="flex items-center justify-between rounded-[0.3rem] border border-dashed border-[#e7e9eb] px-3 py-2 dark:border-[#37394d]">
                                    <div class="flex items-center gap-2">
                                        <span class="size-2 rounded-full {{ $service['ok'] ? 'bg-[#70bb63]' : 'bg-[#ebb751]' }}"></span>
                                        <span class="text-sm text-[#4c4c5c] dark:text-[#aab8c5]">{{ __($service['name']) }}</span>
                                    </div>
                                    <span class="{{ $service['ok'] ? 'badge-soft-success' : 'badge-soft-warning' }}">
                                        {{ __($service['status']) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="boron-card">
                    <div class="boron-card-header">
                        <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Team Online') }}</h5>
                        <span class="badge-soft-primary">4</span>
                    </div>
                    <div class="boron-card-body">
                        <div class="space-y-3">
                            @php
                                $team = [
                                    ['name' => 'Super Admin', 'role' => 'Super Admin', 'online' => true],
                                    ['name' => 'Ahmad Razif', 'role' => 'NOC', 'online' => true],
                                    ['name' => 'Siti Aminah', 'role' => 'Finance', 'online' => false],
                                    ['name' => 'Ismail Harun', 'role' => 'Marketing', 'online' => true],
                                ];
                            @endphp
                            @foreach($team as $member)
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <span class="flex size-9 items-center justify-center rounded-full bg-[#669776]/15 text-xs font-bold text-[#669776]">
                                            {{ collect(explode(' ', $member['name']))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('') }}
                                        </span>
                                        @if($member['online'])
                                            <span class="absolute -bottom-0.5 -right-0.5 size-2.5 rounded-full border-2 border-white bg-[#70bb63] dark:border-[#1e1f27]"></span>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-[#313a46] dark:text-white">{{ $member['name'] }}</p>
                                        <p class="text-xs text-[#8a969c]">{{ $member['role'] }}</p>
                                    </div>
                                    <span class="{{ $member['online'] ? 'badge-soft-success' : 'badge-soft-secondary' }}">
                                        {{ $member['online'] ? __('Online') : __('Offline') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>