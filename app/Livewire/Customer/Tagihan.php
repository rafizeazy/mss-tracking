<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tagihan Saya')]
#[Layout('layouts.app')]
class Tagihan extends Component
{
    public $customer;
    public $isBilled = false;
    public $invoiceData = [];

    public function mount()
    {
        // Ambil data customer berdasarkan user yang sedang login
        $this->customer = Customer::with('baa')->where('user_id', auth()->id())->first();

        // Jika layanan sudah selesai (aktif) dan punya BAA, hitung tagihan prorate-nya
        if ($this->customer && $this->customer->status === 'selesai' && $this->customer->baa) {
            $this->calculateFirstBill();
        }
    }

    public function calculateFirstBill()
    {
        // 1. Ambil tanggal aktif dari BAA
        $activationDate = Carbon::parse($this->customer->baa->activation_date);
        
        // 2. Masa Trial 7 Hari
        $trialEndDate = $activationDate->copy()->addDays(7);
        
        // 3. Tanggal mulai tagihan (H+1 setelah trial habis)
        $prorateStartDate = $trialEndDate->copy()->addDay();
        
        // 4. Akhir bulan dari bulan tagihan tersebut
        $endOfMonth = $prorateStartDate->copy()->endOfMonth();
        
        // 5. Hitung jumlah hari
        $daysInMonth = $prorateStartDate->daysInMonth;
        $billableDays = $prorateStartDate->diffInDays($endOfMonth) + 1;

        // 6. Perhitungan Uang
        $monthlyFee = $this->customer->monthly_fee ?? 0;
        $prorateAmount = ($monthlyFee / $daysInMonth) * $billableDays;
        
        $ppn = $prorateAmount * 0.11; // PPN 11%
        $grandTotal = $prorateAmount + $ppn;

        // Cek apakah hari ini sudah melewati masa trial
        $this->isBilled = now()->startOfDay()->greaterThan($trialEndDate->startOfDay());

        // Simpan data untuk dikirim ke view
        $this->invoiceData = [
            'activation_date' => $activationDate->format('d M Y'),
            'trial_end_date' => $trialEndDate->format('d M Y'),
            'prorate_start' => $prorateStartDate->format('d M Y'),
            'prorate_end' => $endOfMonth->format('d M Y'),
            'billable_days' => $billableDays,
            'days_in_month' => $daysInMonth,
            'monthly_fee' => $monthlyFee,
            'prorate_amount' => $prorateAmount,
            'ppn' => $ppn,
            'grand_total' => $grandTotal,
            'status' => $this->isBilled ? 'UNPAID' : 'TRIAL',
        ];
    }

    public function render()
    {
        return view('livewire.customer.tagihan');
    }
}