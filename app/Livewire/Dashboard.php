<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use App\Models\CustomerService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard MSS')]
#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $filterMonth;

    public $filterYear;

    public $chartData = '{"pendaftar":[], "aktif":[]}';

    public $stats = [];

    public $slaAlerts = [];

    public $recentActivityLogs = [];

    public $comparisonLabel = 'vs Bulan Lalu';

    public function mount()
    {
        $this->filterMonth = date('m');
        $this->filterYear = date('Y');
        $this->loadDashboardData();
    }

    public function updatedFilterMonth()
    {
        $this->loadDashboardData();
    }

    public function updatedFilterYear()
    {
        $this->loadDashboardData();
    }

    #[On('echo-private:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $year = $this->filterYear;
        $month = $this->filterMonth;

        if ($month === 'all') {
            $currentStart = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $currentEnd = $currentStart->copy()->endOfYear();

            $prevStart = $currentStart->copy()->subYear()->startOfYear();
            $prevEnd = $currentStart->copy()->subYear()->endOfYear();

            $this->comparisonLabel = 'vs Tahun Lalu';
        } else {
            $currentStart = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $currentEnd = $currentStart->copy()->endOfMonth();

            $prevStart = $currentStart->copy()->subMonth()->startOfMonth();
            $prevEnd = $currentStart->copy()->subMonth()->endOfMonth();

            $this->comparisonLabel = 'vs Bulan Lalu';
        }

        $currPendaftar = CustomerService::whereBetween('created_at', [$currentStart, $currentEnd])->count();
        $prevPendaftar = CustomerService::whereBetween('created_at', [$prevStart, $prevEnd])->count();

        $currAktif = CustomerService::whereHas('customer', function ($q) {
            $q->where('status', 'selesai');
        })->whereBetween('updated_at', [$currentStart, $currentEnd])->count();

        $prevAktif = CustomerService::whereHas('customer', function ($q) {
            $q->where('status', 'selesai');
        })->whereBetween('updated_at', [$prevStart, $prevEnd])->count();

        $currProses = CustomerService::whereHas('customer', function ($q) {
            $q->whereNotIn('status', ['selesai', 'ditolak', 'berhenti']);
        })->whereBetween('created_at', [$currentStart, $currentEnd])->count();

        $prevProses = CustomerService::whereHas('customer', function ($q) {
            $q->whereNotIn('status', ['selesai', 'ditolak', 'berhenti']);
        })->whereBetween('created_at', [$prevStart, $prevEnd])->count();

        $currBerhenti = CustomerService::whereHas('customer', function ($q) {
            $q->where('status', 'berhenti');
        })->whereBetween('updated_at', [$currentStart, $currentEnd])->count();

        $prevBerhenti = CustomerService::whereHas('customer', function ($q) {
            $q->where('status', 'berhenti');
        })->whereBetween('updated_at', [$prevStart, $prevEnd])->count();

        $totalKeseluruhan = CustomerService::whereHas('customer', function ($q) {
            $q->where('status', 'selesai');
        })->count();

        $calcChange = function ($curr, $prev) {
            if ($prev == 0) {
                return ['val' => $curr > 0 ? 100 : 0, 'up' => true];
            }
            $diff = $curr - $prev;

            return ['val' => round(abs($diff / $prev) * 100, 1), 'up' => $diff >= 0];
        };

        $this->stats = [
            'pendaftar' => ['total' => $currPendaftar, 'change' => $calcChange($currPendaftar, $prevPendaftar)],
            'aktif' => ['total' => $currAktif, 'change' => $calcChange($currAktif, $prevAktif)],
            'proses' => ['total' => $currProses, 'change' => $calcChange($currProses, $prevProses)],
            'berhenti' => ['total' => $currBerhenti, 'change' => $calcChange($currBerhenti, $prevBerhenti)],
            'total_all' => ['total' => $totalKeseluruhan],
        ];

        $this->loadSlaAlerts();
        $this->loadRecentActivityLogs();

        $createdMonthExpression = $this->monthSelectExpression('created_at');
        $updatedMonthExpression = $this->monthSelectExpression('updated_at');

        $yearlyPendaftar = CustomerService::selectRaw($createdMonthExpression.' as month, count(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')->pluck('total', 'month')->toArray();

        $yearlyAktif = CustomerService::selectRaw($updatedMonthExpression.' as month, count(*) as total')
            ->whereHas('customer', function ($q) {
                $q->where('status', 'selesai');
            })
            ->whereYear('updated_at', $year)
            ->groupBy('month')->pluck('total', 'month')->toArray();

        $chartPendaftar = [];
        $chartAktif = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartPendaftar[] = $yearlyPendaftar[$i] ?? 0;
            $chartAktif[] = $yearlyAktif[$i] ?? 0;
        }

        $this->chartData = json_encode([
            'pendaftar' => $chartPendaftar,
            'aktif' => $chartAktif,
        ]);
    }

    protected function monthSelectExpression(string $column): string
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return "CAST(strftime('%m', {$column}) AS INTEGER)";
        }

        return "MONTH({$column})";
    }

    protected function loadRecentActivityLogs(): void
    {
        $this->recentActivityLogs = ActivityLog::with(['user', 'customer'])
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (ActivityLog $log): array => [
                'description' => $log->description,
                'reason' => $log->reason,
                'user_name' => $log->user?->name ?? 'Sistem',
                'company_name' => $log->customer?->company_name ?? '-',
                'created_at' => $log->created_at->diffForHumans(),
            ])
            ->toArray();
    }

    protected function loadSlaAlerts(): void
    {
        $thresholdHours = 48;

        $this->slaAlerts = CustomerService::with('customer.user')
            ->whereHas('customer', function ($query) use ($thresholdHours) {
                $query->whereNotIn('status', ['selesai', 'berhenti', 'dibatalkan', 'ditolak'])
                    ->where('updated_at', '<=', now()->subHours($thresholdHours));
            })
            ->latest()
            ->limit(5)
            ->get()
            ->map(function (CustomerService $service) use ($thresholdHours) {
                return [
                    'service_id' => $service->id,
                    'company_name' => $service->customer->company_name,
                    'status' => $service->customer->status,
                    'hours' => $service->customer->updated_at->diffInHours(now()),
                    'threshold_hours' => $thresholdHours,
                ];
            })
            ->toArray();

        $this->stats['sla_overdue'] = ['total' => count($this->slaAlerts)];
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
