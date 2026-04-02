<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $customer->company_name }}</title>
    <style>
        @page { margin: 40px 50px; }
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            color: #333; 
            font-size: 12px; 
            line-height: 1.4; 
        }
        
        /* HEADER */
        .header-table { width: 100%; border-bottom: 2px solid #1e5d87; padding-bottom: 10px; margin-bottom: 20px; }
        .company-title { font-size: 24px; font-weight: bold; color: #1e5d87; margin: 0; letter-spacing: 1px;}
        .company-sub { font-size: 11px; font-weight: bold; color: #555; margin-bottom: 5px; }
        .company-info { font-size: 10px; color: #666; line-height: 1.5; }
        .invoice-text { font-size: 32px; font-weight: bold; color: #1e5d87; text-align: right; text-transform: uppercase; letter-spacing: 2px;}
        
        /* INFO PELANGGAN & META */
        .meta-container { width: 100%; margin-bottom: 20px; }
        .meta-container td { vertical-align: top; }
        .bill-to h4 { margin: 0 0 5px 0; font-size: 12px; color: #555; text-transform: uppercase; }
        .bill-name { font-size: 16px; font-weight: bold; color: #000; margin: 0 0 3px 0; }
        .bill-address { font-size: 11px; color: #444; width: 80%; }
        
        .inv-details-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        .inv-details-table td { padding: 4px; border: 1px solid #ddd; }
        .inv-details-table .label { background-color: #f5f5f5; font-weight: bold; width: 40%; }
        
        /* TABEL ITEM */
        .item-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .item-table th, .item-table td { border: 1px solid #333; padding: 10px; text-align: left; }
        .item-table th { background-color: #1e5d87; color: white; font-weight: bold; text-transform: uppercase; font-size: 11px; text-align: center;}
        .item-table .text-right { text-align: right; }
        .item-table .text-center { text-align: center; }

        /* TOTALS */
        .total-table { width: 45%; float: right; border-collapse: collapse; }
        .total-table td { padding: 6px 10px; border: 1px solid #ddd; font-size: 11px; }
        .total-table .label { font-weight: bold; text-align: left; background-color: #f5f5f5; }
        .total-table .value { text-align: right; font-weight: bold; }
        .total-table .grand-total td { background-color: #1e5d87; color: white; font-size: 13px; }
        
        .clearfix { clear: both; }

        /* FOOTER INFO */
        .notes-section { margin-top: 30px; font-size: 11px; }
        .note-alert { background-color: #fff3cd; color: #856404; padding: 8px; border-left: 4px solid #ffeeba; margin-bottom: 15px; font-weight: bold;}
        
        .payment-info { border: 1px solid #ddd; padding: 15px; background-color: #fafafa; margin-bottom: 30px;}
        .payment-info h4 { margin: 0 0 10px 0; color: #1e5d87; font-size: 12px; text-transform: uppercase; border-bottom: 1px solid #ddd; padding-bottom: 5px;}
        .payment-info ul { margin: 0; padding-left: 20px; color: #555; }
        .payment-info li { margin-bottom: 4px; }
        
        .bank-details { margin-top: 10px; padding-top: 10px; border-top: 1px dashed #ccc;}
        .bank-name { font-size: 14px; font-weight: bold; color: #1e5d87; }
        .bank-acc { font-size: 18px; font-weight: bold; letter-spacing: 1px; margin: 5px 0; }
        
        /* SIGNATURE */
        .signature { text-align: right; margin-top: 40px; }
        .signature p { margin: 2px 0; font-size: 11px; }
        .sign-space { height: 70px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="60%">
                <h1 class="company-title">PT MEDIA SOLUSI SUKSES</h1>
                <div class="company-sub">INTERNET SERVICE PROVIDER</div>
                <div class="company-info">
                    Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong. Kec. Purwasari, Karawang, Jawa Barat<br>
                    021-39700444 | https://mediasolusisukses.co.id | admin.office@mediasolusisukses.co.id
                </div>
            </td>
            <td width="40%" class="invoice-text">
                INVOICE
            </td>
        </tr>
    </table>

    <table class="meta-container">
        <tr>
            <td width="60%">
                <div class="bill-to">
                    <h4>Kepada:</h4>
                    <p class="bill-name">{{ $customer->finance_name ?? $customer->user->name }}</p>
                    <p class="bill-name" style="font-size: 14px; color: #1e5d87;">{{ $customer->company_name }}</p>
                    <p class="bill-address">{{ $customer->billing_address ?? $customer->company_address }}</p>
                </div>
            </td>
            <td width="40%">
                <table class="inv-details-table">
                    <tr><td class="label">Tanggal</td><td>: {{ \Carbon\Carbon::parse($customer->invoice_generated_at ?? now())->format('d/m/Y') }}</td></tr>
                    <tr><td class="label">No Invoice</td><td>: <strong>{{ $customer->invoice_number }}</strong></td></tr>
                    <tr><td class="label">ID Pelanggan</td><td>: {{ $customer->customer_number }}</td></tr>
                    <tr><td class="label">Jatuh Tempo</td><td>: <span style="color:red; font-weight:bold;">{{ \Carbon\Carbon::parse($customer->invoice_generated_at ?? now())->addDays(14)->format('d/m/Y') }}</span></td></tr>
                    <tr><td class="label">Periode</td><td>: {{ $invoiceData['prorate_start'] }} s.d {{ $invoiceData['prorate_end'] }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="item-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="50%">Layanan</th>
                <th width="20%">Kapasitas</th>
                <th width="25%">Nilai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>
                    <strong>{{ $customer->service_type }} (Prorate)</strong><br>
                    <span style="font-size:10px; color:#555;">Periode {{ $invoiceData['prorate_start'] }} - {{ $invoiceData['prorate_end'] }}</span>
                </td>
                <td class="text-center">Sesuai Paket</td>
                <td class="text-right">Rp {{ number_format($invoiceData['prorate_amount'] ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="total-table">
        <tr>
            <td class="label">Subtotal:</td>
            <td class="value">Rp {{ number_format($invoiceData['prorate_amount'] ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">PPN (11%):</td>
            <td class="value">Rp {{ number_format($invoiceData['ppn'] ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Biaya Lainnya:</td>
            <td class="value">Rp 0</td>
        </tr>
        <tr class="grand-total">
            <td class="label" style="background-color: #1e5d87; color:white;">Total Tagihan:</td>
            <td class="value">Rp {{ number_format($invoiceData['grand_total'] ?? 0, 0, ',', '.') }}</td>
        </tr>
    </table>
    
    <div class="clearfix"></div>

    <div class="notes-section">
        <div class="note-alert">
            Aktif {{ $invoiceData['activation_date'] ?? '-' }} (Trial 7 Hari Gratis)
        </div>

        <div class="payment-info">
            <h4>Informasi Pembayaran</h4>
            <ul>
                <li>Pembayaran dilakukan melalui transfer ke rekening resmi PT Media Solusi Sukses.</li>
                <li>Invoice ini dinyatakan lunas setelah dana diterima di rekening PT Media Solusi Sukses.</li>
                <li>Pembayaran dilakukan sebelum tanggal jatuh tempo yang tertera pada invoice.</li>
            </ul>
            
            <div class="bank-details">
                <div class="bank-name">Bank BCA</div>
                <div class="bank-acc">5745 667 667</div>
                <div style="font-weight:bold; color:#333;">PT MEDIA SOLUSI SUKSES</div>
            </div>
        </div>
    </div>

    <div class="signature">
        <p>Best Regards</p>
        <div class="sign-space">
            </div>
        <p style="text-decoration: underline; font-weight: bold; font-size: 13px;">Sukirman</p>
        <p style="color: #666;">Finance Manager</p>
        
        <p style="margin-top: 15px; font-style: italic; color: #888; font-size: 10px;">
            thank you for the business partnership<br>
            Jika ada pertanyaan mengenai pembayaran silahkan hubungi<br>
            <strong>[0857-1676-5660]</strong>
        </p>
    </div>

</body>
</html>