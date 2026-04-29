<div class="py-6">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h4 class="text-xl md:text-lg font-bold md:font-semibold text-[#313a46] dark:text-white">{{ __('Dashboard Analytics') }}</h4>
            <p class="mt-1 md:mt-0.5 text-sm text-[#8a969c]">{{ __('Selamat datang kembali, :name!', ['name' => Str::words(auth()->user()->name, 1, '')]) }}</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 w-full md:w-auto">
            <select wire:model.live="filterMonth" class="w-full sm:w-auto rounded-lg sm:rounded-[0.3rem] border border-[#dee2e6] bg-white py-2 sm:py-1.5 px-3 text-sm font-medium text-[#313a46] shadow-sm focus:border-[#60addf] focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1f27] dark:text-white">
                <option value="all" class="font-bold text-[#1e5d87]">-- Semua Bulan --</option>
                
                @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $num => $name)
                    <option value="{{ $num }}">{{ $name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filterYear" class="w-full sm:w-auto rounded-lg sm:rounded-[0.3rem] border border-[#dee2e6] bg-white py-2 sm:py-1.5 px-3 text-sm font-medium text-[#313a46] shadow-sm focus:border-[#60addf] focus:ring-1 focus:ring-[#60addf] dark:border-[#37394d] dark:bg-[#1e1f27] dark:text-white">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    @if(auth()->user()->role === \App\Enums\Role::Marketing)
        <div class="mb-6 boron-card border border-[#669776]/30 shadow-sm dark:border-[#669776]/30 rounded-xl sm:rounded-lg overflow-hidden">
            <div class="boron-card-header bg-[#669776]/10 pb-3 px-4 sm:px-6 pt-4">
                <h5 class="font-semibold text-[#669776] dark:text-[#70bb63] text-sm md:text-base">
                    <i class="ti ti-link mr-1"></i> {{ __('Link Registrasi Pelanggan Baru') }}
                </h5>
            </div>
            
            <div class="boron-card-body p-4 sm:p-6" x-data="{ 
                link: '{{ route('customer.register') }}', 
                copied: false,
                copyToClipboard() {
                    navigator.clipboard.writeText(this.link);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                }
            }">
                <p class="mb-4 text-[13px] md:text-sm text-[#8a969c] leading-relaxed">
                    {{ __('Salin dan bagikan tautan ini kepada calon pelanggan yang telah sepakat untuk melakukan registrasi layanan internet. Tautan ini bersifat statis.') }}
                </p>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 max-w-3xl">
                    <div class="relative flex-1">
                        <i class="ti ti-world absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
                        <input type="text" readonly x-model="link" 
                            class="w-full rounded-lg sm:rounded-[0.3rem] border border-[#dee2e6] bg-[#f8f9fa] py-2.5 sm:py-2 pl-9 pr-4 text-sm text-[#4c4c5c] focus:border-[#669776] focus:outline-none dark:border-[#37394d] dark:bg-[#1e1f27] dark:text-[#aab8c5]"
                        >
                    </div>
                    <button @click="copyToClipboard" 
                        class="w-full sm:w-auto btn-boron btn-boron-primary flex justify-center items-center gap-2 whitespace-nowrap !px-5 sm:!px-4 !py-2.5 sm:!py-2 rounded-lg sm:rounded shadow-sm transition-colors"
                        :class="copied ? '!bg-[#70bb63] !border-[#70bb63]' : ''"
                    >
                        <i class="ti" :class="copied ? 'ti-check' : 'ti-copy'"></i>
                        <span x-text="copied ? 'Tersalin!' : 'Copy Link'"></span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 md:gap-5">
        
        <div class="boron-card rounded-xl sm:rounded-lg">
            <div class="boron-card-body p-5 md:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-[11px] md:text-[10px] font-semibold text-[#8a969c] uppercase">Pemesanan / Registrasi</p>
                        <h3 class="text-2xl md:text-3xl font-bold text-[#313a46] dark:text-white">{{ $stats['pendaftar']['total'] }}</h3>
                    </div>
                    <span class="flex size-10 items-center justify-center rounded-full bg-[#60addf]/20 shrink-0">
                        <i class="ti ti-users-plus text-lg text-[#60addf]"></i>
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d] pt-3">
                    <i class="ti {{ $stats['pendaftar']['change']['up'] ? 'ti-trending-up text-[#70bb63]' : 'ti-trending-down text-[#ed6060]' }} text-sm"></i>
                    <span class="text-xs font-bold {{ $stats['pendaftar']['change']['up'] ? 'text-[#70bb63]' : 'text-[#ed6060]' }}">{{ $stats['pendaftar']['change']['val'] }}%</span>
                    <span class="text-[10px] text-[#8a969c] ml-1">{{ $comparisonLabel }}</span>
                </div>
            </div>
        </div>

        <div class="boron-card rounded-xl sm:rounded-lg">
            <div class="boron-card-body p-5 md:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-[11px] md:text-[10px] font-semibold text-[#8a969c] uppercase">{{ $filterMonth === 'all' ? 'Aktif Tahun Ini' : 'Aktif Bulan Ini' }}</p>
                        <h3 class="text-2xl md:text-3xl font-bold text-[#313a46] dark:text-white">{{ $stats['aktif']['total'] }}</h3>
                    </div>
                    <span class="flex size-10 items-center justify-center rounded-full bg-[#70bb63]/20 shrink-0">
                        <i class="ti ti-wifi text-lg text-[#70bb63]"></i>
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d] pt-3">
                    <i class="ti {{ $stats['aktif']['change']['up'] ? 'ti-trending-up text-[#70bb63]' : 'ti-trending-down text-[#ed6060]' }} text-sm"></i>
                    <span class="text-xs font-bold {{ $stats['aktif']['change']['up'] ? 'text-[#70bb63]' : 'text-[#ed6060]' }}">{{ $stats['aktif']['change']['val'] }}%</span>
                    <span class="text-[10px] text-[#8a969c] ml-1">{{ $comparisonLabel }}</span>
                </div>
            </div>
        </div>

        <div class="boron-card rounded-xl sm:rounded-lg">
            <div class="boron-card-body p-5 md:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-[11px] md:text-[10px] font-semibold text-[#8a969c] uppercase">Belum Aktif (Proses)</p>
                        <h3 class="text-2xl md:text-3xl font-bold text-[#313a46] dark:text-white">{{ $stats['proses']['total'] }}</h3>
                    </div>
                    <span class="flex size-10 items-center justify-center rounded-full bg-[#ebb751]/20 shrink-0">
                        <i class="ti ti-loader text-lg text-[#ebb751] animate-spin-slow"></i>
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d] pt-3">
                    <i class="ti {{ $stats['proses']['change']['up'] ? 'ti-trending-up text-[#ed6060]' : 'ti-trending-down text-[#70bb63]' }} text-sm"></i>
                    <span class="text-xs font-bold {{ $stats['proses']['change']['up'] ? 'text-[#ed6060]' : 'text-[#70bb63]' }}">{{ $stats['proses']['change']['val'] }}%</span>
                    <span class="text-[10px] text-[#8a969c] ml-1">{{ $comparisonLabel }}</span>
                </div>
            </div>
        </div>

        <div class="boron-card rounded-xl sm:rounded-lg">
            <div class="boron-card-body p-5 md:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="mb-1 text-[11px] md:text-[10px] font-semibold text-[#8a969c] uppercase">Pelanggan Berhenti</p>
                        <h3 class="text-2xl md:text-3xl font-bold text-[#313a46] dark:text-white">{{ $stats['berhenti']['total'] ?? 0 }}</h3>
                    </div>
                    <span class="flex size-10 items-center justify-center rounded-full bg-[#ed6060]/20 shrink-0">
                        <i class="ti ti-hand-stop text-lg text-[#ed6060]"></i>
                    </span>
                </div>
                <div class="mt-4 flex items-center gap-1.5 border-t border-dashed border-[#e7e9eb] dark:border-[#37394d] pt-3">
                    <i class="ti {{ ($stats['berhenti']['change']['up'] ?? false) ? 'ti-trending-up text-[#ed6060]' : 'ti-trending-down text-[#70bb63]' }} text-sm"></i>
                    <span class="text-xs font-bold {{ ($stats['berhenti']['change']['up'] ?? false) ? 'text-[#ed6060]' : 'text-[#70bb63]' }}">{{ $stats['berhenti']['change']['val'] ?? 0 }}%</span>
                    <span class="text-[10px] text-[#8a969c] ml-1">{{ $comparisonLabel }}</span>
                </div>
            </div>
        </div>

        <div class="boron-card bg-white border border-[#e7e9eb] dark:border-[#37394d] dark:bg-[#1e1f27] rounded-xl sm:rounded-lg overflow-hidden relative" x-data="{
            time: '',
            date: '',
            updateTime() {
                const now = new Date();
                
                // Format Waktu (09:13:04 PM)
                let hours = now.getHours();
                let minutes = now.getMinutes().toString().padStart(2, '0');
                let seconds = now.getSeconds().toString().padStart(2, '0');
                let ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // Jam '0' menjadi '12'
                hours = hours.toString().padStart(2, '0');
                
                this.time = `${hours}:${minutes}:${seconds} ${ampm}`;

                // Format Tanggal (Rabu, 29 April 2026)
                const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                this.date = `${hari[now.getDay()]}, ${now.getDate()} ${bulan[now.getMonth()]} ${now.getFullYear()}`;
            }
        }" x-init="updateTime(); setInterval(() => updateTime(), 1000)">
            <div class="boron-card-body p-5 md:p-6 flex flex-col h-full justify-between items-center text-center">
                <div class="w-full">
                    <p class="mb-1 text-[11px] md:text-[10px] font-semibold text-[#8a969c] uppercase">Waktu Saat Ini</p>
                    <h3 class="text-2xl md:text-3xl font-black text-[#1e5d87] dark:text-[#60addf]" x-text="time"></h3>
                </div>
                <div class="mt-auto w-full pt-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#f8f9fa] dark:bg-white/5 text-[10px] font-bold text-[#8a969c] border border-[#e7e9eb] dark:border-[#37394d]">
                        <i class="ti ti-calendar text-xs"></i> <span x-text="date"></span>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-6 boron-card rounded-xl sm:rounded-lg overflow-hidden">
        <div class="boron-card-header flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 px-4 sm:px-6 pt-5 pb-3">
            <div>
                <h5 class="font-bold md:font-semibold text-[#313a46] dark:text-white text-base md:text-lg">{{ __('Grafik Tren Registrasi & Aktivasi') }}</h5>
                <p class="text-[11px] md:text-xs text-[#8a969c] mt-0.5">Report pergerakan perbulan di sepanjang tahun {{ $filterYear }}</p>
            </div>
            <span class="badge-soft-secondary px-3 py-1.5 text-xs self-start sm:self-auto rounded-md shadow-sm"><i class="ti ti-chart-line mr-1 text-sm"></i> Live Report</span>
        </div>
        <div class="boron-card-body pt-2 pb-6 px-2 sm:px-4">
            
            <div x-data="{
                chart: null,
                init() {
                    let options = {
                        series: [
                            { name: 'Registrasi Baru', data: [] },
                            { name: 'Berhasil Aktif', data: [] },
                            { name: 'Berhenti', data: [] }
                        ],
                        chart: { 
                            type: 'area', 
                            height: 350, 
                            toolbar: { show: false }, 
                            fontFamily: 'inherit',
                            parentHeightOffset: 0
                        },
                        colors: ['#60addf', '#70bb63', '#ed6060'],
                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 2 },
                        xaxis: { 
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            labels: { style: { colors: '#8a969c', fontSize: '10px' }, rotate: -45 }
                        },
                        yaxis: { labels: { style: { colors: '#8a969c', fontSize: '11px' } } },
                        legend: { position: 'top', horizontalAlign: 'right', fontSize: '12px' },
                        grid: { borderColor: '#e7e9eb', strokeDashArray: 4, padding: { left: 10, right: 10 } }
                    };

                    // Penyesuaian konfigurasi chart untuk layar kecil
                    if(window.innerWidth < 640) {
                        options.xaxis.labels.rotate = -90;
                        options.stroke.width = 2;
                        options.legend.position = 'bottom';
                        options.legend.horizontalAlign = 'center';
                    }

                    this.chart = new ApexCharts(this.$refs.myChart, options);
                    this.chart.render();

                    this.$watch('$wire.chartData', value => {
                        let data = JSON.parse(value);
                        this.chart.updateSeries([
                            { name: 'Registrasi Baru', data: data.pendaftar },
                            { name: 'Berhasil Aktif', data: data.aktif },
                            { name: 'Berhenti', data: data.berhenti || [] }
                        ]);
                    });

                    let initialData = JSON.parse(this.$wire.chartData);
                    this.chart.updateSeries([
                        { name: 'Registrasi Baru', data: initialData.pendaftar },
                        { name: 'Berhasil Aktif', data: initialData.aktif },
                        { name: 'Berhenti', data: initialData.berhenti || [] }
                    ]);
                }
            }" class="w-full relative">
                <div x-ref="myChart" class="w-full min-h-[350px]"></div>
            </div>

        </div>
    </div>

</div>