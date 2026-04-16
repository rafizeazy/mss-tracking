<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SPK - {{ $customer->company_name }}</title>
    <style>
        /* Reset & Base Typography */
        @page { margin: 40px 50px; }
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            color: #1f2937; /* Dark Gray / Almost Black for better print contrast */
            font-size: 12px; 
            line-height: 1.5; 
        }
        
        /* Typography Scale */
        h1, h2, h3, h4, h5, p { margin: 0; padding: 0; }
        
        /* Header Section */
        .header-table { 
            width: 100%; 
            border-bottom: 2px solid #1e5d87; /* Corporate Blue Accent */
            padding-bottom: 15px; 
            margin-bottom: 25px; 
        }
        .header-logo { height: 50px; width: auto; }
        .header-info { 
            text-align: right; 
            font-size: 10px; 
            color: #4b5563; 
            line-height: 1.4; 
        }
        .header-info strong { 
            color: #1e5d87; 
            font-size: 14px; 
            display: block; 
            margin-bottom: 4px; 
            letter-spacing: 0.5px; 
            text-transform: uppercase; 
        }
        
        /* Document Titles */
        .doc-title-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .doc-title { 
            font-size: 18px; 
            font-weight: bold; 
            color: #111827; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            text-decoration: underline;
            margin-bottom: 4px;
        }
        .doc-subtitle { 
            font-size: 11px; 
            font-weight: 600; 
            color: #4b5563; 
            letter-spacing: 0.5px; 
            text-transform: uppercase;
        }

        /* Meta Information Table (Top Box) */
        .meta-table { 
            width: 100%; 
            margin-bottom: 30px; 
            border-collapse: collapse; 
        }
        .meta-table td { 
            padding: 8px 12px; 
            border: 1px solid #e5e7eb; 
            font-size: 11px; 
        }
        .meta-table .meta-label { 
            background-color: #f9fafb; 
            font-weight: bold; 
            color: #4b5563; 
            width: 18%; 
            text-transform: uppercase; 
        }
        .meta-table .meta-value { 
            color: #111827; 
            width: 32%; 
            font-weight: bold; 
        }

        /* Section Titles */
        .section-title { 
            font-size: 12px; 
            font-weight: bold; 
            color: #1e5d87; /* Corporate Blue */
            margin-bottom: 10px; 
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }

        /* Main Content Tables */
        .content-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 25px; 
        }
        .content-table td { 
            padding: 9px 12px; 
            border: 1px solid #e5e7eb; 
            vertical-align: top; 
            font-size: 12px; 
        }
        .content-table .label { 
            width: 35%; 
            background-color: #f9fafb; 
            font-weight: bold; 
            color: #4b5563; 
        }
        .content-table .value { 
            color: #111827; 
            font-weight: 500;
        }

        /* Special Values Emphasis (Clean) */
        .val-highlight { font-weight: bold; text-transform: uppercase; }
        .val-sub { font-weight: normal; color: #6b7280; font-size: 11px; }

        /* Instructions Box */
        .instructions-box { 
            background-color: #f9fafb; 
            border: 1px solid #e5e7eb; 
            padding: 12px 15px; 
            border-radius: 4px; 
            color: #374151; 
            line-height: 1.6; 
            margin-bottom: 50px; 
            font-size: 11px;
        }

        /* Signatures */
        .signature-table { 
            width: 100%; 
            text-align: center; 
            page-break-inside: avoid; 
            margin-top: 40px; 
        }
        .signature-table td { 
            width: 50%; 
            vertical-align: bottom; 
        }
        .sign-title { 
            color: #111827; 
            font-size: 11px; 
            margin-bottom: 15px; 
        }
        .sign-space { 
            height: 65px; 
            margin-bottom: 5px; 
        }
        .sign-img { 
            max-height: 65px; 
            width: auto; 
        }
        .sign-name { 
            font-weight: bold; 
            text-decoration: underline; 
            text-transform: uppercase; 
            font-size: 12px; 
            color: #111827; 
        }
        .sign-role { 
            font-size: 10px; 
            color: #4b5563; 
            margin-top: 3px; 
        }
    </style>
</head>
<body>
    
    <table class="header-table">
        <tr>
            <td width="50%" style="vertical-align: middle;">
                <img src="{{ public_path('logo/Logo MSS.png') }}" class="header-logo" alt="Logo MSS" onerror="this.style.display='none';">
            </td>
            <td width="50%" class="header-info" style="vertical-align: middle;">
                <strong>PT Media Solusi Sukses</strong>
                Perum. Bumi Karawang Residence, Blok G12 No. 7-9<br>
                Cengkong, Purwasari, Kab. Karawang, 41373<br>
                P: +62 21 397 00 444 | E: admin@mediasolusisukses.co.id
            </td>
        </tr>
    </table>

    <div class="doc-title-container">
        <div class="doc-title">Surat Perintah Kerja (SPK)</div>
        <div class="doc-subtitle">Dokumen Instalasi & Aktivasi Jaringan</div>
    </div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Nomor SPK</td>
            <td class="meta-value">{{ $customer->spk->spk_number ?? '-' }}</td>
            <td class="meta-label">Tanggal Terbit</td>
            <td class="meta-value">{{ $customer->spk->created_at ? $customer->spk->created_at->format('d F Y') : date('d F Y') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Target Selesai</td>
            <td class="meta-value">{{ $customer->spk->due_date ? \Carbon\Carbon::parse($customer->spk->due_date)->format('d F Y') : '-' }}</td>
            <td class="meta-label">Diterbitkan Oleh</td>
            <td class="meta-value">{{ strtoupper($customer->marketing_name ?? 'Administration') }}</td>
        </tr>
    </table>

    <div class="section-title">1. Informasi Pelanggan & Layanan</div>
    <table class="content-table">
        <tr>
            <td class="label">Nama Usaha / Instansi</td>
            <td class="value val-highlight">{{ $customer->company_name }}</td>
        </tr>
        <tr>
            <td class="label">ID Pelanggan</td>
            <td class="value">{{ $customer->customer_number ?? 'DI ISI SETELAH AKTIF' }}</td>
        </tr>
        <tr>
            <td class="label">Tipe Pelanggan</td>
            <td class="value">{{ $customer->spk->customer_type ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Layanan</td>
            <td class="value">{{ strtoupper($customer->service_type) }}</td>
        </tr>
        <tr>
            <td class="label">Kapasitas Bandwidth</td>
            <td class="value val-highlight">{{ strtoupper($customer->bandwidth) }}</td>
        </tr>
        <tr>
            <td class="label">Vendor Jalur Metro</td>
            <td class="value">{{ strtoupper($customer->jalur_metro ?? '-') }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Pekerjaan NOC</td>
            <td class="value">{{ strtoupper($customer->spk->job_type ?? 'Aktivasi Baru') }}</td>
        </tr>
    </table>

    <div class="section-title">2. Lokasi Instalasi & Kontak Terkait</div>
    <table class="content-table">
        <tr>
            <td class="label">Alamat Lengkap Instalasi</td>
            <td class="value" style="line-height: 1.6;">{{ $customer->installation_address ?? $customer->company_address }}</td>
        </tr>
        <tr>
            <td class="label">Nama PIC Teknis (Lokasi)</td>
            <td class="value">{{ strtoupper($customer->technical_name ?? $customer->user->name) }}</td>
        </tr>
        <tr>
            <td class="label">Kontak PIC Teknis</td>
            <td class="value">{{ $customer->technical_phone ?? $customer->phone }}</td>
        </tr>
        <tr>
            <td class="label">Tim Sales / Marketing</td>
            <td class="value">
                {{ strtoupper($customer->marketing_name ?? '-') }} 
                <span class="val-sub">( {{ $customer->marketing_phone ?? '-' }} )</span>
            </td>
        </tr>
    </table>

    <div class="section-title">3. Instruksi Khusus Pekerjaan</div>
    <div class="instructions-box">
        {!! nl2br(e($customer->spk->notes ?? 'Tim NOC diminta untuk melakukan proses penyediaan layanan sesuai detail di atas, termasuk penarikan kabel, pemasangan OLT/Router, aktivasi bandwidth, serta memastikan konektivitas internet berjalan dengan baik sebelum dilakukan serah terima (BAA) kepada pelanggan.')) !!}
    </div>

    <table class="signature-table">
        <tr>
            <td>
                <div class="sign-title">Mengetahui & Menjalankan,<br>Tim Operation</div>
                <div class="sign-space"></div>
                <div class="sign-name">( .................................................... )</div>
                <div class="sign-role">Network Operation Center (NOC)</div>
            </td>
            <td>
                <div class="sign-title">Hormat Kami,<br>PT Media Solusi Sukses</div>
                <div class="sign-space">
                    <img src="{{ public_path('ttd/marketing/ttdmarketing.png') }}" class="sign-img" alt="TTD Marketing" onerror="this.style.display='none';">
                </div>
                <div class="sign-name">{{ strtoupper($customer->marketing_name ?? 'Administration') }}</div>
                <div class="sign-role">Admin Marketing</div>
            </td>
        </tr>
    </table>

</body>
</html>