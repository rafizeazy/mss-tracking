<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SPK - {{ $customer->company_name }}</title>
    <style>
        @page { margin: 40px 50px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #313a46; font-size: 12px; line-height: 1.5; }
        
        .header-table { width: 100%; border-bottom: 3px solid #1e5d87; padding-bottom: 15px; margin-bottom: 25px; }
        .header-logo { height: 55px; width: auto; }
        .header-info { text-align: right; font-size: 11px; color: #8a969c; line-height: 1.4; }
        .header-info strong { color: #1e5d87; font-size: 15px; display: block; margin-bottom: 3px; letter-spacing: 0.5px; text-transform: uppercase; }
        
        .doc-title { text-align: center; font-size: 20px; font-weight: 900; color: #1e5d87; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; text-decoration: underline; }
        .doc-subtitle { text-align: center; font-size: 12px; font-weight: bold; color: #669776; letter-spacing: 1px; margin-bottom: 30px; }

        .meta-table { width: 100%; margin-bottom: 25px; border-collapse: collapse; }
        .meta-table td { padding: 8px 12px; border: 1px solid #e7e9eb; font-size: 12px; }
        .meta-table .meta-label { background-color: #f8f9fa; font-weight: bold; color: #1e5d87; width: 18%; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; }
        .meta-table .meta-value { color: #313a46; width: 32%; font-weight: 600; }

        .section-title { font-size: 13px; font-weight: bold; color: #1e5d87; margin-bottom: 10px; border-left: 4px solid #669776; padding-left: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .content-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .content-table td { padding: 10px 12px; border: 1px solid #e7e9eb; vertical-align: top; font-size: 12px; }
        .content-table .label { width: 35%; background-color: #f8f9fa; font-weight: bold; color: #4c4c5c; }
        .content-table .value { color: #313a46; }

        .instructions-box { background-color: rgba(102, 151, 118, 0.05); border: 1px solid rgba(102, 151, 118, 0.2); padding: 15px; border-radius: 4px; color: #313a46; line-height: 1.6; margin-bottom: 40px; font-style: italic; }

        .signature-table { width: 100%; text-align: center; page-break-inside: avoid; margin-top: 50px; }
        .signature-table td { width: 50%; vertical-align: bottom; position: relative; }
        .sign-title { font-weight: bold; color: #313a46; font-size: 12px; margin-bottom: 70px; }
        .sign-name { font-weight: bold; text-decoration: underline; text-transform: uppercase; font-size: 13px; color: #1e5d87; }
        .sign-role { font-size: 11px; color: #8a969c; margin-top: 4px; font-weight: 600; }
        .fake-sign { font-family: "Brush Script MT", "Lucida Handwriting", cursive, sans-serif; font-size: 34px; color: #669776; opacity: 0.6; transform: rotate(-10deg); position: absolute; top: 30px; left: 50%; margin-left: -50px; z-index: -1; }
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

    <div class="doc-title">SURAT PERINTAH KERJA (SPK)</div>
    <div class="doc-subtitle">DOKUMEN INSTALASI & AKTIVASI JARINGAN</div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Nomor SPK</td>
            <td class="meta-value" style="color: #1e5d87;">{{ $customer->spk->spk_number ?? '-' }}</td>
            <td class="meta-label">Tanggal Terbit</td>
            <td class="meta-value">{{ $customer->spk->created_at ? $customer->spk->created_at->format('d F Y') : date('d F Y') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Target Selesai</td>
            <td class="meta-value" style="color: #ed6060;">{{ $customer->spk->due_date ? \Carbon\Carbon::parse($customer->spk->due_date)->format('d F Y') : '-' }}</td>
            <td class="meta-label">Diterbitkan Oleh</td>
            <td class="meta-value">{{ strtoupper($customer->marketing_name ?? 'Administration') }}</td>
        </tr>
    </table>

    <div class="section-title">1. Informasi Pelanggan & Layanan</div>
    <table class="content-table">
        <tr>
            <td class="label">Nama Usaha / Instansi</td>
            <td class="value" style="font-weight: 800; font-size: 14px; text-transform: uppercase;">{{ $customer->company_name }}</td>
        </tr>
        <tr>
            <td class="label">ID Pelanggan</td>
            <td class="value" style="font-weight: bold;">{{ $customer->customer_number ?? 'DI ISI SETELAH AKTIF' }}</td>
        </tr>
        <tr>
            <td class="label">Tipe Pelanggan</td>
            <td class="value">{{ $customer->spk->customer_type ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Layanan</td>
            <td class="value" style="font-weight: bold; color: #1e5d87;">{{ strtoupper($customer->service_type) }}</td>
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
            <td class="value" style="font-weight: bold;">{{ strtoupper($customer->marketing_name ?? '-') }} <span style="font-weight: normal; color:#8a969c;">( {{ $customer->marketing_phone ?? '-' }} )</span></td>
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
                <div class="sign-name">( .................................................... )</div>
                <div class="sign-role">Network Operation Center (NOC)</div>
            </td>
            <td>
                <div class="sign-title">Hormat Kami,<br>PT Media Solusi Sukses</div>
                <div class="fake-sign">Approved</div>
                <div class="sign-name">{{ strtoupper($customer->marketing_name ?? 'Administration') }}</div>
                <div class="sign-role">Sales / Marketing</div>
            </td>
        </tr>
    </table>

</body>
</html>