<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Invoice {{ $customer->invoice_number }} | PT Media Solusi Sukses</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #e2e8f0;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            min-height: 100vh;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            padding: 40px 20px;
        }

        .a4-container {
            width: 210mm;
            min-height: 297mm;
            background: white;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            overflow: hidden;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }

        .invoice-content {
            padding: 1.8rem 2rem 1.5rem 2rem;
            flex: 1;
            display: flex;
            flex-direction: column; 
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e6f0ec;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo {
            height: 48px;
            width: auto;
            object-fit: contain;
        }
        .company h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f2b2b;
            letter-spacing: -0.3px;
        }
        .company p {
            font-size: 0.7rem;
            color: #4b6b6b;
            font-weight: 500;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1f6e43;
            letter-spacing: 1px;
        }
        .invoice-title .inv-num {
            background: #eef2ff;
            padding: 0.2rem 0.8rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #1f6e43;
            margin-top: 5px;
        }

        .info-grid {
            display: flex;
            justify-content: space-between;
            gap: 1.2rem;
            margin-bottom: 1.5rem;
        }
        .info-card {
            background: #f9fafb;
            padding: 0.8rem 1rem;
            border-radius: 16px;
            flex: 1;
            border: 1px solid #eef2ff;
        }
        .info-card label {
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 800;
            color: #1f6e43;
            letter-spacing: 0.8px;
            display: block;
            margin-bottom: 8px;
        }
        .info-card p {
            font-size: 0.8rem;
            color: #1e293b;
            line-height: 1.4;
            font-weight: 500;
        }
        .info-card .small-meta {
            font-size: 0.7rem;
            color: #5b6e8c;
            margin-top: 5px;
        }
        .text-right {
            text-align: right;
        }

        .table-wrapper {
            margin: 0.8rem 0 1rem 0;
            border-radius: 16px;
            border: 1px solid #eef2ff;
            overflow-x: auto;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }
        .invoice-table th {
            background: #f8fafc;
            padding: 0.7rem 1rem;
            text-align: left;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #4b5563;
            border-bottom: 1px solid #e2e8f0;
        }
        .invoice-table th:last-child {
            text-align: right;
        }
        .invoice-table td {
            padding: 0.8rem 1rem;
            border-bottom: 1px solid #f0f2f5;
            color: #1e293b;
            font-weight: 500;
        }
        .invoice-table td:last-child {
            text-align: right;
            font-weight: 700;
            color: #1f6e43;
        }
        .service-desc small {
            display: block;
            font-size: 0.65rem;
            color: #6c757d;
            font-weight: 400;
            margin-top: 3px;
        }

        .total-section {
            display: flex;
            justify-content: flex-end;
            margin: 0.5rem 0 1.2rem 0;
        }
        .total-card {
            width: 260px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            font-size: 0.8rem;
            color: #334155;
            border-bottom: 1px dashed #e2e8f0;
        }
        .total-row.grand {
            border-top: 2px solid #1e293b;
            border-bottom: none;
            margin-top: 5px;
            padding-top: 0.7rem;
            font-weight: 800;
            font-size: 0.95rem;
            color: #0f172a;
        }
        .grand span:last-child {
            color: #1f6e43;
            font-size: 1.05rem;
        }

        .bottom-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 1.5rem;
            margin-top: 1.5rem; 
            margin-bottom: 1rem;
        }
        .payment-box {
            background: #f4fbf7;
            border-radius: 18px;
            padding: 0.9rem 1.2rem;
            flex: 2;
            border-left: 4px solid #1f6e43;
        }
        .payment-box h4 {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1f6e43;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .payment-details p {
            font-size: 0.75rem;
            margin-bottom: 5px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .payment-details strong {
            min-width: 95px;
            font-weight: 700;
            color: #0f172a;
        }
        .payment-note {
            margin-top: 8px;
            font-size: 0.7rem;
            background: #e0f2e9;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            color: #1e5a3a;
        }
        .signature {
            flex: 1;
            text-align: center;
        }
        .signature .sign-title {
            font-size: 0.7rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 1rem;
        }
        .sign-line {
            border-top: 1.5px dashed #b9c7d9;
            width: 140px;
            margin: 0 auto 0.4rem auto;
        }
        .sign-name {
            font-weight: 800;
            font-size: 0.8rem;
            color: #0f172a;
        }
        .sign-role {
            font-size: 0.65rem;
            color: #6b7280;
        }
        .signature-img-container {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .signature-img-container img {
            max-height: 100%;
            width: auto;
        }

        .footer-notes {
            margin-top: auto; 
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.65rem;
            color: #64748b;
            text-align: center;
            line-height: 1.5;
        }
        .footer-notes p {
            margin-bottom: 4px;
        }

        .print-button-container {
            text-align: right;
            margin-bottom: 12px;
        }
        .btn-print {
            background: #1f6e43;
            border: none;
            padding: 8px 20px;
            border-radius: 40px;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .btn-print:hover {
            background: #0f4d2f;
            transform: scale(0.98);
        }

        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .a4-container {
                width: 100%;
                min-height: 265mm; 
                box-shadow: none;
                border-radius: 0;
                margin: 0;
                display: flex; 
                flex-direction: column;
            }
            .print-button-container {
                display: none;
            }
            .invoice-content {
                padding: 0; 
                display: flex; 
                flex-direction: column;
                flex: 1;
            }
            .info-card, .payment-box {
                break-inside: avoid;
            }
            .total-row, .invoice-table tr {
                break-inside: avoid;
            }
            @page {
                size: A4 portrait;
                margin: 1.2cm; 
            }
        }

        @media screen and (max-width: 850px) {
            body { padding: 10px; }
            .a4-container {
                width: 100%;
                margin: 0;
            }
            .info-grid {
                flex-direction: column;
                gap: 0.8rem;
            }
            .bottom-flex {
                flex-direction: column;
                align-items: stretch;
                margin-top: 1.5rem; 
            }
            .signature {
                text-align: left;
                margin-top: 0.5rem;
            }
            .sign-line {
                margin-left: 0;
                width: 100%;
            }
            .footer-notes {
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
<div class="a4-container">
    <div class="print-button-container" style="padding: 12px 20px 0 0;">
        <button class="btn-print" onclick="window.print()">
            🖨️ Cetak / Simpan PDF (A4 Portrait)
        </button>
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
                <div class="inv-num">{{ $customer->invoice_number }}</div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <label>📋 DITAGIHKAN KEPADA</label>
                <p>
                    <strong>{{ $customer->company_name }}</strong><br>
                    {{ $customer->billing_address ?? $customer->company_address }}<br>
                    @if($customer->city){{ $customer->city }}@endif @if($customer->province), {{ $customer->province }}@endif
                </p>
                <div class="small-meta">
                    UP: {{ $customer->finance_name ?? $customer->user->name }}<br>
                    @if($customer->finance_phone)📞 {{ $customer->finance_phone }} @endif
                    @if($customer->finance_email) ✉️ {{ $customer->finance_email }} @endif
                </div>
            </div>
            <div class="info-card text-right">
                <label>📅 DETAIL INVOICE</label>
                <p>
                    <strong>Tanggal Terbit:</strong> {{ $customer->invoice_generated_at?->format('d M Y') ?? now()->format('d M Y') }}<br>
                    <strong>Jatuh Tempo:</strong> {{ ($customer->invoice_generated_at ?? now())->addDays(14)->format('d M Y') }}<br>
                    <strong>NPWP:</strong> {{ $customer->npwp_number ?? '-' }}
                </p>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th style="width: 8%">#</th>
                        <th style="width: 62%">Deskripsi Layanan</th>
                        <th style="width: 30%">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="service-desc">
                            Biaya Registrasi / Instalasi Awal
                            <small>{{ $customer->bandwidth }} • {{ $customer->service_type }}</small>
                        </td>
                        <td>Rp {{ number_format($customer->registration_fee ?? 0, 0, ',', '.') }}</td>
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
                    <span>TOTAL TAGIHAN</span>
                    <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="bottom-flex">
            <div class="payment-box">
                <h4>💳 INFORMASI PEMBAYARAN</h4>
                <div class="payment-details">
                    <p><strong>Bank :</strong> Bank BCA</p>
                    <p><strong>No. Rekening :</strong> 1234567890</p>
                    <p><strong>Atas Nama :</strong> PT Media Solusi Sukses</p>
                </div>
                <div class="payment-note">
                    ✔️ Setelah transfer, upload bukti bayar via Dashboard Pelanggan
                </div>
            </div>
            <div class="signature">
                <div class="sign-title">Hormat Kami,</div>
                <div class="signature-img-container">
                    <img src="{{ asset('ttd/finance/ttdfinance.png') }}" alt="TTD Finance" style="max-height: 70px; width: auto; display: block; margin: 0 auto;">
                </div>
                <div class="sign-line"></div>
                <div class="sign-name">{{ config('invoice.signature_name', 'Finance Department') }}</div>
                <div class="sign-role">Finance Department</div>
            </div>
        </div>

        <div class="footer-notes">
            <p>Invoice ini dibuat secara otomatis oleh sistem. Biaya berlangganan bulan pertama akan ditagihkan secara terpisah setelah layanan aktif (BAA diterbitkan). Apabila ada pertanyaan mengenai tagihan ini, silakan hubungi tim Finance kami.</p>
            <p style="margin-top: 8px;">© {{ date('Y') }} PT Media Solusi Sukses — {{ config('app.url', 'mss.co.id') }}</p>
        </div>
    </div>
</div>
</body>
</html>