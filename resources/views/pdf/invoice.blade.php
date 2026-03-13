<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $customer->company_name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #333; font-size: 14px; line-height: 1.5; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); }
        .header { width: 100%; margin-bottom: 20px; }
        .header td { padding: 5px; vertical-align: top; }
        .title { font-size: 28px; font-weight: bold; color: #313a46; }
        .company-info { text-align: right; }
        .invoice-details { margin-top: 20px; width: 100%; }
        .invoice-details td { padding: 5px; vertical-align: top; }
        .table-items { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .table-items th { background: #f8f9fa; padding: 10px; border-bottom: 2px solid #ddd; text-align: left; }
        .table-items td { padding: 10px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        .totals { margin-top: 20px; width: 100%; border-collapse: collapse; }
        .totals td { padding: 8px; text-align: right; }
        .grand-total { font-weight: bold; font-size: 18px; color: #1e5d87; border-top: 2px solid #333; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table class="header">
            <tr>
                <td>
                    <div class="title">INVOICE REGISTRASI</div>
                    <div style="color: #8a969c;">INV-REG-{{ date('Ymd') }}-{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}</div>
                </td>
                <td class="company-info">
                    <strong>PT Media Solusi Sukses</strong><br>
                    Layanan Internet & IT Solution<br>
                    Tanggal: {{ date('d F Y') }}
                </td>
            </tr>
        </table>

        <table class="invoice-details">
            <tr>
                <td>
                    <strong>Ditagihkan Kepada:</strong><br>
                    {{ $customer->company_name }}<br>
                    {{ $customer->billing_address ?? $customer->company_address }}<br>
                    UP: {{ $customer->finance_name ?? $customer->user->name }}
                </td>
            </tr>
        </table>

        <table class="table-items">
            <thead>
                <tr>
                    <th>Deskripsi Layanan</th>
                    <th class="text-right">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Biaya Registrasi / Instalasi Awal</td>
                    <td class="text-right">{{ number_format($customer->registration_fee, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Layanan Bulan Pertama ({{ $customer->service_type }})</td>
                    <td class="text-right">{{ number_format($customer->monthly_fee, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td style="width: 60%;"></td>
                <td>Subtotal:</td>
                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td>PPN (11%):</td>
                <td>Rp {{ number_format($ppn, 0, ',', '.') }}</td>
            </tr>
            <tr class="grand-total">
                <td></td>
                <td>TOTAL TAGIHAN:</td>
                <td>Rp {{ number_format($grand_total, 0, ',', '.') }}</td>
            </tr>
        </table>
        
        <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #8a969c;">
            Harap lakukan pembayaran sesuai dengan nominal Total Tagihan. Terima kasih.
        </div>
    </div>
</body>
</html>