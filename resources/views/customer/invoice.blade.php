<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $customer->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f6f7fb; color: #313a46; }

        .page { max-width: 820px; margin: 40px auto; background: white; padding: 48px; box-shadow: 0 4px 24px rgba(0,0,0,.08); border-radius: 8px; }

        /* Header */
        .header { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 24px; border-bottom: 2px solid #669776; }
        .header-left { display: flex; align-items: center; gap: 16px; }
        .logo { height: 50px; width: auto; }
        .company-name { font-size: 22px; font-weight: 800; color: #669776; letter-spacing: -0.5px; }
        .company-sub  { font-size: 12px; color: #8a969c; margin-top: 4px; }
        .invoice-title { text-align: right; }
        .invoice-title h1 { font-size: 28px; font-weight: 900; color: #313a46; letter-spacing: 2px; }
        .invoice-title .inv-num { font-size: 13px; color: #669776; font-weight: 600; margin-top: 4px; }

        /* Meta grid */
        .meta { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin: 28px 0; }
        .meta-box label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #8a969c; font-weight: 700; display: block; margin-bottom: 6px; }
        .meta-box p  { font-size: 13px; color: #313a46; font-weight: 500; line-height: 1.6; }

        /* Table */
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        thead th { background: #f6f7fb; padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #8a969c; border-bottom: 2px solid #e7e9eb; }
        thead th:last-child { text-align: right; }
        tbody td { padding: 14px 16px; font-size: 13px; color: #4c4c5c; border-bottom: 1px dashed #e7e9eb; }
        tbody td:last-child { text-align: right; font-weight: 600; }

        /* Totals */
        .totals { display: flex; justify-content: flex-end; margin-top: 16px; }
        .totals-box { width: 300px; }
        .totals-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 13px; color: #4c4c5c; border-bottom: 1px dashed #e7e9eb; }
        .totals-row.grand { font-size: 16px; font-weight: 800; color: #313a46; border-bottom: none; border-top: 2px solid #313a46; padding-top: 12px; margin-top: 4px; }
        .totals-row.grand span:last-child { color: #669776; }

        /* Bottom Section (Payment & Signature) */
        .bottom-section { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 36px; gap: 24px; }
        
        .payment-info { padding: 20px; background: #f6f7fb; border-radius: 6px; border-left: 4px solid #669776; flex: 1; }
        .payment-info h4 { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #669776; font-weight: 700; margin-bottom: 12px; }
        .payment-info p  { font-size: 12px; color: #4c4c5c; margin-bottom: 6px; }
        .payment-info p strong { color: #313a46; }

        .signature-box { width: 220px; text-align: center; }
        .signature-box p.title { font-size: 13px; font-weight: 600; color: #313a46; margin-bottom: 70px; }
        .signature-box .sign-name { font-size: 13px; font-weight: 800; color: #313a46; text-decoration: underline; text-transform: uppercase; }
        .signature-box .sign-role { font-size: 11px; color: #8a969c; margin-top: 4px; font-weight: 600; }

        /* Notes */
        .notes { margin-top: 36px; font-size: 11px; color: #8a969c; border-top: 1px solid #e7e9eb; padding-top: 20px; }

        /* Print button */
        .print-bar { background: #669776; color: white; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 99; }
        .print-bar h6 { font-size: 13px; font-weight: 600; }
        .print-bar button { background: white; color: #669776; border: none; padding: 8px 20px; border-radius: 4px; font-weight: 700; font-size: 13px; cursor: pointer; }
        @media print {
            .print-bar { display: none; }
            body { background: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .page { box-shadow: none; border-radius: 0; margin: 0; max-width: 100%; padding: 20px; }
        }
    </style>
</head>
<body>

<div class="print-bar">
    <h6>Invoice Registrasi #{{ $customer->invoice_number }} — PT Media Solusi Sukses</h6>
    <button onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
</div>

<div class="page">

    <div class="header">
        <div class="header-left">
            <img src="{{ asset('logo/Logo MSS.png') }}" class="logo" alt="Logo MSS" onerror="this.style.display='none';">
            <div>
                <div class="company-name">PT Media Solusi Sukses</div>
                <div class="company-sub">Penyedia Layanan Internet Terpercaya</div>
            </div>
        </div>
        <div class="invoice-title">
            <h1>INVOICE</h1>
            <div class="inv-num">{{ $customer->invoice_number }}</div>
        </div>
    </div>

    <div class="meta">
        <div class="meta-box">
            <label>Ditagihkan Kepada</label>
            <p>
                <strong>{{ $customer->company_name }}</strong><br>
                {{ $customer->billing_address ?? $customer->company_address }}<br>
                @if($customer->city){{ $customer->city }}@endif@if($customer->province), {{ $customer->province }}@endif<br>
                UP: {{ $customer->finance_name ?? $customer->user->name }}
                @if($customer->finance_phone) — {{ $customer->finance_phone }}@endif
            </p>
        </div>
        <div class="meta-box" style="text-align:right">
            <label>Detail Invoice</label>
            <p>
                <strong>Tanggal Terbit:</strong> {{ $customer->invoice_generated_at?->format('d M Y') ?? now()->format('d M Y') }}<br>
                <strong>Jatuh Tempo:</strong> {{ ($customer->invoice_generated_at ?? now())->addDays(14)->format('d M Y') }}<br>
                <strong>No. NPWP:</strong> {{ $customer->npwp_number ?? '-' }}
            </p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Deskripsi Layanan</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>
                    Biaya Registrasi / Instalasi Awal<br>
                    <small style="color:#8a969c">Layanan: {{ $customer->service_type }}</small>
                </td>
                <td>{{ number_format($customer->registration_fee ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="totals">
        <div class="totals-box">
            <div class="totals-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="totals-row">
                <span>PPN (0%)</span>
                <span>Rp {{ number_format($ppn, 0, ',', '.') }}</span>
            </div>
            <div class="totals-row grand">
                <span>TOTAL TAGIHAN</span>
                <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="bottom-section">
        <div class="payment-info">
            <h4>Informasi Pembayaran</h4>
            <p><strong>Bank:</strong> Bank BCA</p>
            <p><strong>No. Rekening:</strong> 1234567890</p>
            <p><strong>Atas Nama:</strong> PT Media Solusi Sukses</p>
            <p style="margin-top:8px;color:#669776;font-weight:600;">
                Setelah melakukan transfer, harap unggah bukti pembayaran melalui Dashboard Pelanggan Anda.
            </p>
        </div>

        <div class="signature-box">
            <p class="title">Hormat Kami,</p>
            <div class="sign-name">PT Media Solusi Sukses</div>
            <div class="sign-role">Finance Department</div>
        </div>
    </div>

    <div class="notes">
        <p>Invoice ini dibuat secara otomatis oleh sistem. Biaya berlangganan bulan pertama akan ditagihkan secara terpisah setelah layanan aktif (BAA diterbitkan). Apabila ada pertanyaan mengenai tagihan ini, silakan hubungi tim Finance kami.</p>
        <p style="margin-top:8px;">© {{ date('Y') }} PT Media Solusi Sukses — {{ config('app.url') }}</p>
    </div>

</div>
</body>
</html>jnjn