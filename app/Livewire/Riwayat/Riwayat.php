<?php

namespace App\Livewire\Riwayat;

use App\Models\Customer;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Carbon\Carbon;

#[Title('Riwayat Layanan Pelanggan')]
#[Layout('layouts.app')]
class Riwayat extends Component
{
    public $search = '';

    public function render()
    {
        $searchQuery = '%' . $this->search . '%';
        $activations = Customer::with('user')
            ->whereNotNull('customer_number') 
            ->when($this->search, function ($query) use ($searchQuery) {
                $query->where('customer_number', 'like', $searchQuery)
                      ->orWhere('company_name', 'like', $searchQuery);
            })
            ->get()
            ->map(function ($customer) {
                return [
                    'customer_number' => $customer->customer_number,
                    'company_name'    => $customer->company_name,
                    'customer_name'   => $customer->technical_name ?? $customer->user->name ?? '-',
                    'type'            => 'Aktivasi',
                    'request_date'    => $customer->created_at,
                    'completed_date'  => $customer->updated_at,
                    'old_bandwidth'   => null,
                    'new_bandwidth'   => $customer->bandwidth,
                    'old_monthly_fee' => null,
                    'new_monthly_fee' => $customer->monthly_fee,
                ];
            });
        $requests = ServiceRequest::with(['customer.user', 'bau'])
            ->where('status', 'selesai')
            ->when($this->search, function ($query) use ($searchQuery) {
                $query->whereHas('customer', function ($q) use ($searchQuery) {
                    $q->where('customer_number', 'like', $searchQuery)
                      ->orWhere('company_name', 'like', $searchQuery);
                });
            })
            ->get()
            ->map(function ($req) {
                return [
                    'customer_number' => $req->customer->customer_number,
                    'company_name'    => $req->customer->company_name,
                    'customer_name'   => $req->customer->technical_name ?? $req->customer->user->name ?? '-',
                    'type'            => $req->request_type, 
                    'request_date'    => $req->created_at,
                    'completed_date'  => $req->bau?->upgrade_date ? Carbon::parse($req->bau->upgrade_date) : $req->updated_at,
                    'old_bandwidth'   => $req->old_bandwidth,
                    'new_bandwidth'   => $req->new_bandwidth,
                    'old_monthly_fee' => $req->old_monthly_fee ?? 0, 
                    'new_monthly_fee' => $req->new_monthly_fee,
                ];
            });
        $riwayatMerged = $activations->concat($requests)
            ->sortByDesc(function ($item) {
                return Carbon::parse($item['completed_date'])->timestamp;
            })
            ->values()
            ->all();

        return view('livewire.riwayat.riwayat', [
            'riwayat' => $riwayatMerged,
            'isPaginated' => false 
        ]);
    }
}