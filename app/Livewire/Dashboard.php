<?php

namespace App\Livewire;

use App\Models\Customer;
use Carbon\Carbon;
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

    #[On('echo:mss-updates,CustomerUpdated')]
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

        $currPendaftar = Customer::whereBetween('created_at', [$currentStart, $currentEnd])->count();
        $prevPendaftar = Customer::whereBetween('created_at', [$prevStart, $prevEnd])->count();

        $currAktif = Customer::where('status', 'selesai')->whereBetween('updated_at', [$currentStart, $currentEnd])->count();
        $prevAktif = Customer::where('status', 'selesai')->whereBetween('updated_at', [$prevStart, $prevEnd])->count();

        $currProses = Customer::whereNotIn('status', ['selesai', 'ditolak'])->whereBetween('created_at', [$currentStart, $currentEnd])->count();
        $prevProses = Customer::whereNotIn('status', ['selesai', 'ditolak'])->whereBetween('created_at', [$prevStart, $prevEnd])->count();

        $totalKeseluruhan = Customer::where('status', 'selesai')->count();

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
            'total_all' => ['total' => $totalKeseluruhan],
        ];

        $monthExpr = \DB::connection()->getDriverName() === 'sqlite'
            ? "CAST(strftime('%m', created_at) AS INTEGER)"
            : 'MONTH(created_at)';

        $monthExprUpdated = \DB::connection()->getDriverName() === 'sqlite'
            ? "CAST(strftime('%m', updated_at) AS INTEGER)"
            : 'MONTH(updated_at)';

        $yearlyPendaftar = Customer::selectRaw("{$monthExpr} as month, count(*) as total")
            ->whereYear('created_at', $year)
            ->groupBy('month')->pluck('total', 'month')->toArray();

        $yearlyAktif = Customer::selectRaw("{$monthExprUpdated} as month, count(*) as total")
            ->where('status', 'selesai')
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

    public function render()
    {
        return view('livewire.dashboard');
    }
}
