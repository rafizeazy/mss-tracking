<div class="py-6">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Dashboard Analytics') }}</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">{{ __('Selamat datang kembali, :name!', ['name' => Str::words(auth()->user()->name, 1, '')]) }}</p>
        </div>
        
        <div class="flex items-center gap-2">
            <select wire:model.live="filterMonth" class="rounded-[0.3rem] border border-[#dee2e6] bg-white py-1.5 px-3 text-sm font-medium text-[#313a46] shadow-sm focus:border-[#60addf] focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1f27] dark:text-white">
                <option value="all" class="font-bold text-[#1e5d87]">-- Semua Bulan --</option>
                
                @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $num => $name)
                    <option value="{{ $num }}">{{ $name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterYear" class="rounded-[0.3rem] border border-[#dee2e6] bg-white py-1.5 px-3 text-sm font-medium text-[#313a46] shadow-sm focus:border-[#60addf] focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1f27] dark:text-white">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
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
        <div class="boron-card">
            <div class="boron-card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-sm font-semibold text-[#8a969c] uppercase">Pemesanan / Registrasi</p>
                        <h3 class="text-3xl font-bold text-[#313a46] dark:text-white">{{ $stats['pendaftar']['total'] }}</h3>
                    </div>
                    <span class="flex size-12 items-center justify-center rounded-full bg-[#60addf]/20">
                        <i class="ti ti-users-plus text-xl text-[#60addf]"></i>
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d] pt-3">
                    <i class="ti {{ $stats['pendaftar']['change']['up'] ? 'ti-trending-up text-[#70bb63]' : 'ti-trending-down text-[#ed6060]' }} text-base"></i>
                    <span class="text-sm font-bold {{ $stats['pendaftar']['change']['up'] ? 'text-[#70bb63]' : 'text-[#ed6060]' }}">{{ $stats['pendaftar']['change']['val'] }}%</span>
                    <span class="text-xs text-[#8a969c] ml-1">{{ $comparisonLabel }}</span>
                </div>
            </div>
        </div>

        <div class="boron-card">
            <div class="boron-card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-sm font-semibold text-[#8a969c] uppercase">{{ $filterMonth === 'all' ? 'Aktif Tahun Ini' : 'Aktif Bulan Ini' }}</p>
                        <h3 class="text-3xl font-bold text-[#313a46] dark:text-white">{{ $stats['aktif']['total'] }}</h3>
                    </div>
                    <span class="flex size-12 items-center justify-center rounded-full bg-[#70bb63]/20">
                        <i class="ti ti-wifi text-xl text-[#70bb63]"></i>
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d] pt-3">
                    <i class="ti {{ $stats['aktif']['change']['up'] ? 'ti-trending-up text-[#70bb63]' : 'ti-trending-down text-[#ed6060]' }} text-base"></i>
                    <span class="text-sm font-bold {{ $stats['aktif']['change']['up'] ? 'text-[#70bb63]' : 'text-[#ed6060]' }}">{{ $stats['aktif']['change']['val'] }}%</span>
                    <span class="text-xs text-[#8a969c] ml-1">{{ $comparisonLabel }}</span>
                </div>
            </div>
        </div>

        <div class="boron-card">
            <div class="boron-card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-sm font-semibold text-[#8a969c] uppercase">Belum Aktif (Proses)</p>
                        <h3 class="text-3xl font-bold text-[#313a46] dark:text-white">{{ $stats['proses']['total'] }}</h3>
                    </div>
                    <span class="flex size-12 items-center justify-center rounded-full bg-[#ebb751]/20">
                        <i class="ti ti-loader text-xl text-[#ebb751] animate-spin-slow"></i>
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d] pt-3">
                    <i class="ti {{ $stats['proses']['change']['up'] ? 'ti-trending-up text-[#ed6060]' : 'ti-trending-down text-[#70bb63]' }} text-base"></i>
                    <span class="text-sm font-bold {{ $stats['proses']['change']['up'] ? 'text-[#ed6060]' : 'text-[#70bb63]' }}">{{ $stats['proses']['change']['val'] }}%</span>
                    <span class="text-xs text-[#8a969c] ml-1">{{ $comparisonLabel }}</span>
                </div>
            </div>
        </div>

        <div class="boron-card bg-[#1e5d87] border-[#1e5d87] text-white">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 size-24 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
            <div class="boron-card-body relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-sm font-semibold text-white/70 uppercase">Total Keseluruhan Aktif</p>
                        <h3 class="text-3xl font-black text-white">{{ $stats['total_all']['total'] }}</h3>
                    </div>
                    <span class="flex size-12 items-center justify-center rounded-full bg-white/20">
                        <i class="ti ti-server text-xl text-white"></i>
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 border-t border-dashed border-white/20 pt-3">
                    <span class="text-xs text-white/80"><i class="ti ti-circle-check text-[#70bb63] mr-1"></i> Data real-time seluruh sistem</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 boron-card">
        <div class="boron-card-header flex justify-between items-center">
            <div>
                <h5 class="font-semibold text-[#313a46] dark:text-white">{{ __('Grafik Tren Registrasi & Aktivasi') }}</h5>
                <p class="text-xs text-[#8a969c] mt-0.5">Report pergerakan perbulan di sepanjang tahun {{ $filterYear }}</p>
            </div>
            <span class="badge-soft-secondary px-3 py-1"><i class="ti ti-chart-line mr-1"></i> Live Report</span>
        </div>
        <div class="boron-card-body pt-2 pb-6 px-4">
            
            <div x-data="{
                chart: null,
                init() {
                    let options = {
                        series: [
                            { name: 'Registrasi Baru', data: [] },
                            { name: 'Berhasil Aktif', data: [] }
                        ],
                        chart: { type: 'area', height: 350, toolbar: { show: false }, fontFamily: 'inherit' },
                        colors: ['#60addf', '#70bb63'],
                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        xaxis: { 
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            labels: { style: { colors: '#8a969c' } }
                        },
                        yaxis: { labels: { style: { colors: '#8a969c' } } },
                        legend: { position: 'top', horizontalAlign: 'right' },
                        grid: { borderColor: '#e7e9eb', strokeDashArray: 4 }
                    };

                    this.chart = new ApexCharts(this.$refs.myChart, options);
                    this.chart.render();

                    this.$watch('$wire.chartData', value => {
                        let data = JSON.parse(value);
                        this.chart.updateSeries([
                            { name: 'Registrasi Baru', data: data.pendaftar },
                            { name: 'Berhasil Aktif', data: data.aktif }
                        ]);
                    });

                    let initialData = JSON.parse(this.$wire.chartData);
                    this.chart.updateSeries([
                        { name: 'Registrasi Baru', data: initialData.pendaftar },
                        { name: 'Berhasil Aktif', data: initialData.aktif }
                    ]);
                }
            }">
                <div x-ref="myChart" class="w-full"></div>
            </div>

        </div>
    </div>

</div>