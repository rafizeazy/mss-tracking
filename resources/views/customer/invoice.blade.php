<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Invoice {{ $service->invoiceRegistrasi?->invoice_number ?? 'DRAFT' }} | PT Media Solusi Sukses</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            align-items: flex-start;
            background: #edf2f7;
            color: #172033;
            display: flex;
            font-family: Arial, Helvetica, sans-serif;
            justify-content: center;
            min-height: 100vh;
            padding: 32px 18px;
        }

        .a4-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 22px 45px rgba(20, 31, 45, 0.16);
            min-height: 297mm;
            overflow: hidden;
            width: 210mm;
        }

        .print-button-container {
            padding: 14px 22px 0;
            text-align: right;
        }

        .btn-print {
            background: #17633d;
            border: 0;
            border-radius: 999px;
            color: #ffffff;
            cursor: pointer;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.2px;
            padding: 9px 18px;
        }

        .btn-print:hover {
            background: #104b2d;
        }

        .invoice-content {
            padding: 28px 34px 30px;
        }

        .header-row {
            align-items: center;
            border-bottom: 2px solid #dbe8e2;
            display: flex;
            justify-content: space-between;
            padding-bottom: 20px;
        }

        .brand {
            align-items: center;
            display: flex;
            gap: 14px;
        }

        .logo {
            height: 48px;
            object-fit: contain;
            width: auto;
        }

        .company h3 {
            color: #102033;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.15;
        }

        .company p {
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            margin-top: 3px;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h1 {
            color: #17633d;
            font-size: 34px;
            font-weight: 900;
            letter-spacing: 3px;
            line-height: 1;
        }

        .inv-num {
            background: #e9f6ef;
            border: 1px solid #cbe8d8;
            border-radius: 999px;
            color: #17633d;
            display: inline-block;
            font-size: 12px;
            font-weight: 800;
            margin-top: 10px;
            padding: 5px 14px;
        }

        .meta-strip {
            background: #f7faf8;
            border: 1px solid #dbe8e2;
            border-radius: 8px;
            display: grid;
            gap: 0;
            grid-template-columns: repeat(3, 1fr);
            margin: 20px 0;
            overflow: hidden;
        }

        .meta-item {
            border-right: 1px solid #dbe8e2;
            padding: 12px 14px;
        }

        .meta-item:last-child {
            border-right: 0;
        }

        .meta-item span {
            color: #6b778c;
            display: block;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.8px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .meta-item strong {
            color: #172033;
            display: block;
            font-size: 13px;
        }

        .info-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: 1.05fr 0.95fr;
            margin-bottom: 22px;
        }

        .info-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px 18px;
        }

        .section-label {
            align-items: center;
            color: #17633d;
            display: flex;
            font-size: 11px;
            font-weight: 900;
            gap: 8px;
            letter-spacing: 1px;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .section-label::before {
            background: #17633d;
            border-radius: 999px;
            content: '';
            display: inline-block;
            height: 8px;
            width: 8px;
        }

        .info-card p {
            color: #1e293b;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.5;
        }

        .small-meta {
            border-top: 1px dashed #dbe4ef;
            color: #64748b;
            font-size: 11px;
            line-height: 1.6;
            margin-top: 10px;
            padding-top: 9px;
        }

        .text-right {
            text-align: right;
        }

        .table-wrapper {
            border: 1px solid #dbe4ef;
            border-radius: 8px;
            margin: 4px 0 20px;
            overflow: hidden;
        }

        .invoice-table {
            border-collapse: collapse;
            font-size: 13px;
            width: 100%;
        }

        .invoice-table th {
            background: #f1f5f9;
            border-bottom: 1px solid #dbe4ef;
            color: #475569;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 0.9px;
            padding: 12px 14px;
            text-align: left;
            text-transform: uppercase;
        }

        .invoice-table th:last-child,
        .invoice-table td:last-child {
            text-align: right;
        }

        .invoice-table td {
            border-bottom: 1px solid #edf2f7;
            color: #172033;
            font-weight: 600;
            padding: 16px 14px;
            vertical-align: top;
        }

        .invoice-table tr:last-child td {
            border-bottom: 0;
        }

        .service-desc small {
            color: #64748b;
            display: block;
            font-size: 11px;
            font-weight: 500;
            margin-top: 5px;
        }

        .amount {
            color: #17633d;
            font-weight: 900;
        }

        .total-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 26px;
        }

        .total-card {
            width: 300px;
        }

        .total-row {
            align-items: center;
            border-bottom: 1px dashed #cbd5e1;
            color: #334155;
            display: flex;
            font-size: 13px;
            justify-content: space-between;
            padding: 8px 0;
        }

        .total-row.grand {
            border-bottom: 0;
            border-top: 2px solid #172033;
            color: #0f172a;
            font-size: 15px;
            font-weight: 900;
            margin-top: 4px;
            padding-top: 12px;
            text-transform: uppercase;
        }

        .total-row.grand span:last-child {
            color: #17633d;
            font-size: 17px;
        }

        .bottom-flex {
            align-items: flex-end;
            display: grid;
            gap: 24px;
            grid-template-columns: 1.35fr 0.65fr;
        }

        .payment-box {
            background: #f3fbf6;
            border: 1px solid #cfe8da;
            border-left: 5px solid #17633d;
            border-radius: 8px;
            padding: 18px 20px;
        }

        .payment-box h4 {
            color: #17633d;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .payment-details p {
            color: #172033;
            display: flex;
            font-size: 12px;
            line-height: 1.55;
            margin-bottom: 4px;
        }

        .payment-details strong {
            display: inline-block;
            min-width: 108px;
        }

        .payment-note {
            background: #e3f4ea;
            border: 1px solid #c3e5d1;
            border-radius: 999px;
            color: #17633d;
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            margin-top: 10px;
            padding: 7px 12px;
        }

        .signature {
            text-align: center;
        }

        .sign-title {
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .signature-img-container {
            align-items: center;
            display: flex;
            height: 64px;
            justify-content: center;
            margin-bottom: 10px;
        }

        .signature-img-container img {
            max-height: 64px;
            width: auto;
        }

        .sign-line {
            border-top: 1px solid #94a3b8;
            margin: 0 auto 7px;
            width: 150px;
        }

        .sign-name {
            color: #0f172a;
            font-size: 12px;
            font-weight: 900;
        }

        .sign-role {
            color: #64748b;
            font-size: 10px;
            margin-top: 2px;
        }

        .footer-notes {
            border-top: 1px solid #dbe4ef;
            color: #64748b;
            font-size: 10px;
            line-height: 1.55;
            margin-top: 24px;
            padding-top: 14px;
            text-align: center;
        }

        @media print {
            body {
                background: #ffffff;
                display: block;
                margin: 0;
                padding: 0;
            }

            .a4-container {
                border-radius: 0;
                box-shadow: none;
                min-height: auto;
                width: 100%;
            }

            .print-button-container {
                display: none;
            }

            .invoice-content {
                padding: 0;
            }

            .info-card,
            .payment-box,
            .invoice-table tr,
            .total-row {
                break-inside: avoid;
            }

            @page {
                margin: 1.2cm;
                size: A4 portrait;
            }
        }

        @media screen and (max-width: 850px) {
            body {
                padding: 10px;
            }

            .a4-container {
                width: 100%;
            }

            .header-row,
            .brand,
            .info-grid,
            .bottom-flex,
            .meta-strip {
                display: block;
            }

            .invoice-title,
            .text-right {
                margin-top: 16px;
                text-align: left;
            }

            .meta-item {
                border-bottom: 1px solid #dbe8e2;
                border-right: 0;
            }

            .meta-item:last-child {
                border-bottom: 0;
            }

            .info-card,
            .signature {
                margin-top: 12px;
            }
        }
    </style>
</head>
<body>
<div class="a4-container">
    <div class="print-button-container">
        <button class="btn-print" onclick="window.print()">Cetak / Simpan PDF (A4 Portrait)</button>
    </div>

    <div class="invoice-content">
        <div class="header-row">
            <div class="brand">
                <img src="{{ asset('logo/Logo MSS.png') }}" class="logo" alt="Logo MSS" onerror="this.style.display='none';">
                <div class="company">
                    <h3>PT Media Solusi Sukses</h3>
                    <p>Internet Service Provider</p>
                </div>
            </div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <div class="inv-num">{{ $service->invoiceRegistrasi?->invoice_number ?? 'DRAFT' }}</div>
            </div>
        </div>

        <div class="meta-strip">
            <div class="meta-item">
                <span>Tanggal Terbit</span>
                <strong>{{ $service->invoiceRegistrasi?->invoice_generated_at?->format('d M Y') ?? now()->format('d M Y') }}</strong>
            </div>
            <div class="meta-item">
                <span>Jatuh Tempo</span>
                <strong>{{ ($service->invoiceRegistrasi?->invoice_generated_at ?? now())->addDays(14)->format('d M Y') }}</strong>
            </div>
            <div class="meta-item">
                <span>Nomor NPWP</span>
                <strong>{{ $customer->npwp_number ?? '-' }}</strong>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <div class="section-label">Ditagihkan Kepada</div>
                <p>
                    <strong>{{ $customer->company_name }}</strong><br>
                    {{ $customer->billing_address ?? $customer->company_address }}<br>
                    @if($customer->city){{ $customer->city }}@endif @if($customer->province), {{ $customer->province }}@endif
                </p>
                <div class="small-meta">
                    UP: {{ $customer->finance_name ?? $customer->user->name }}<br>
                    @if($customer->finance_phone)Telepon: {{ $customer->finance_phone }}@endif
                    @if($customer->finance_email)<br>Email: {{ $customer->finance_email }}@endif
                </div>
            </div>
            <div class="info-card text-right">
                <div class="section-label">Detail Layanan</div>
                <p>
                    <strong>{{ $service->service_type ?? '-' }}</strong><br>
                    Kapasitas: {{ $service->bandwidth ?? '-' }}<br>
                    Masa berlangganan: {{ $service->term_of_service ?? '-' }} Tahun
                </p>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th style="width: 8%">No</th>
                        <th style="width: 62%">Deskripsi Layanan</th>
                        <th style="width: 30%">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="service-desc">
                            Biaya Registrasi / Instalasi Awal
                            <small>{{ $service->bandwidth ?? '-' }} - {{ $service->service_type ?? '-' }}</small>
                        </td>
                        <td class="amount">Rp {{ number_format($service->registration_fee ?? 0, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="total-section">
            <div class="total-card">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span>PPN (0%)</span>
                    <span>Rp {{ number_format($ppn, 0, ',', '.') }}</span>
                </div>
                <div class="total-row grand">
                    <span>Total Tagihan</span>
                    <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="bottom-flex">
            <div class="payment-box">
                <h4>Informasi Pembayaran</h4>
                <div class="payment-details">
                    <p><strong>Bank</strong> Bank BCA</p>
                    <p><strong>No. Rekening</strong> 1234567890</p>
                    <p><strong>Atas Nama</strong> PT Media Solusi Sukses</p>
                </div>
                <div class="payment-note">Setelah transfer, upload bukti bayar via Dashboard Pelanggan.</div>
            </div>
            <div class="signature">
                <div class="sign-title">Hormat Kami,</div>
                <div class="signature-img-container">
                    <img src="{{ asset('ttd/finance/ttdfinance.png') }}" alt="TTD Finance">
                </div>
                <div class="sign-line"></div>
                <div class="sign-name">{{ config('invoice.signature_name', 'Finance Department') }}</div>
                <div class="sign-role">Finance Department</div>
            </div>
        </div>

        <div class="footer-notes">
            <p>Invoice ini dibuat secara otomatis oleh sistem. Biaya berlangganan bulan pertama akan ditagihkan secara terpisah setelah layanan aktif atau BAA diterbitkan. Apabila ada pertanyaan mengenai tagihan ini, silakan hubungi tim Finance kami.</p>
            <p style="margin-top: 8px;">{{ date('Y') }} PT Media Solusi Sukses - {{ config('app.url', 'mss.co.id') }}</p>
        </div>
    </div>
</div>
</body>
</html>
