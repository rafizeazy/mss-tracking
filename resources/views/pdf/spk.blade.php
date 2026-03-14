<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SPK - {{ $customer->company_name }}</title>
    <style>
        @page { margin: 40px 50px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 13px; line-height: 1.4; }
        
        /* Header Section */
        .header-table { width: 100%; border-bottom: 2px solid #669776; padding-bottom: 15px; margin-bottom: 20px; }
        .header-left { width: 60%; }
        .header-right { width: 40%; text-align: right; }
        .company-name { font-size: 22px; font-weight: 900; color: #669776; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        .company-sub { font-size: 12px; color: #8a969c; margin-top: 4px; letter-spacing: 0.5px; }
        
        /* Title Section */
        .doc-title { text-align: center; font-size: 20px; font-weight: bold; margin: 20px 0 5px 0; text-transform: uppercase; color: #313a46; letter-spacing: 1px; text-decoration: underline; }
        .doc-subtitle { text-align: center; font-size: 12px; color: #8a969c; margin-bottom: 30px; letter-spacing: 2px; }

        /* Meta Info */
        .meta-table { width: 100%; margin-bottom: 20px; font-size: 13px; }
        .meta-table td { padding: 5px 0; }
        .meta-label { font-weight: bold; width: 140px; color: #4c4c5c; }

        /* Sections & Tables */
        .section-title { font-weight: bold; background: #f6f7fb; color: #1e5d87; padding: 8px 12px; margin-top: 20px; border-left: 4px solid #60addf; font-size: 13px; border-top: 1px solid #e7e9eb; border-right: 1px solid #e7e9eb; border-bottom: 1px solid #e7e9eb; text-transform: uppercase; letter-spacing: 0.5px; }
        .content-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e9eb; border-top: none; }
        .content-table td { border-bottom: 1px solid #e7e9eb; padding: 10px 12px; vertical-align: top; }
        .content-table td.label { width: 35%; font-weight: 600; color: #4c4c5c; background-color: #fdfdfd; border-right: 1px solid #e7e9eb; }

        /* Instructions */
        .instructions { border: 1px solid #e7e9eb; padding: 15px; min-height: 80px; background-color: #fdfdfd; color: #4c4c5c; font-style: italic; border-top: none; line-height: 1.6; }

        /* Signatures */
        .signature-table { width: 100%; margin-top: 50px; text-align: center; page-break-inside: avoid; }
        .signature-table td { width: 50%; padding-top: 10px; }
        .sign-area { height: 90px; position: relative; }
        .sign-name { font-weight: bold; text-decoration: underline; margin-bottom: 4px; font-size: 14px; color: #313a46; }
        .sign-title { color: #8a969c; font-size: 12px; }

        /* Fake Signature / Stamp */
        .fake-sign { font-family: "Brush Script MT", "Lucida Handwriting", cursive, sans-serif; font-size: 32px; color: #669776; line-height: 90px; opacity: 0.8; transform: rotate(-5deg); display: inline-block; }
    </style>
</head>
<body>
    
    <table class="header-table">
        <tr>
            <td class="header-left">
                <h1 class="company-name">PT MEDIA SOLUSI SUKSES</h1>
                <div class="company-sub">Layanan Internet & IT Solution Berdedikasi</div>
            </td>
            <td class="header-right">
                <div style="font-size: 11px; line-height: 1.5; color: #8a969c;">
                    Perum. Bumi Karawang Residence, Blok G12 No. 7-9<br>
                    Cengkong, Purwasari, Kab. Karawang, 41373<br>
                    +62 21 397 00 444 | admin@mediasolusisukses.co.id
                </div>
            </td>
        </tr>
    </table>

    <div class="doc-title">SURAT PERINTAH KERJA (SPK)</div>
    <div class="doc-subtitle">DOKUMEN INSTALASI & AKTIVASI JARINGAN</div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Nomor SPK</td>
            <td>: <strong style="color: #313a46;">{{ $customer->spk->spk_number ?? '-' }}</strong></td>
            <td class="meta-label">Tanggal Terbit</td>
            <td>: {{ $customer->spk->created_at ? $customer->spk->created_at->format('d F Y') : date('d F Y') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Target Selesai (Due)</td>
            <td style="color: #ed6060; font-weight: bold;">: {{ $customer->spk->due_date ? \Carbon\Carbon::parse($customer->spk->due_date)->format('d F Y') : '-' }}</td>
            <td class="meta-label">Diterbitkan Oleh</td>
            <td>: {{ $customer->marketing_name ?? 'Administration' }}</td>
        </tr>
    </table>

    <div class="section-title">1. Informasi Pelanggan & Layanan</div>
    <table class="content-table">
        <tr>
            <td class="label">Nama Usaha / Instansi</td>
            <td style="font-weight: bold; font-size: 15px; color: #313a46;">{{ $customer->company_name }}</td>
        </tr>
        <tr>
            <td class="label">ID Pelanggan</td>
            <td style="color: #ebb751; font-weight: bold;">{{ $customer->customer_number ?? 'DI ISI SETELAH AKTIF' }}</td>
        </tr>
        <tr>
            <td class="label">Tipe Pelanggan</td>
            <td>{{ $customer->spk->customer_type ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Layanan</td>
            <td style="font-weight: bold; color: #1e5d87;">{{ $customer->service_type }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Pekerjaan NOC</td>
            <td>{{ $customer->spk->job_type ?? 'Aktivasi Baru' }}</td>
        </tr>
    </table>

    <div class="section-title">2. Lokasi Instalasi & Kontak Terkait</div>
    <table class="content-table">
        <tr>
            <td class="label">Alamat Lengkap Instalasi</td>
            <td style="line-height: 1.5;">{{ $customer->installation_address ?? $customer->company_address }}</td>
        </tr>
        <tr>
            <td class="label">Nama PIC Teknis (Lokasi)</td>
            <td>{{ $customer->technical_name ?? $customer->user->name }}</td>
        </tr>
        <tr>
            <td class="label">Kontak PIC Teknis</td>
            <td>{{ $customer->technical_phone ?? $customer->phone }}</td>
        </tr>
        <tr>
            <td class="label">Tim Sales / Marketing</td>
            <td style="font-weight: bold;">{{ $customer->marketing_name ?? '-' }} <span style="font-weight: normal; color:#8a969c;">( {{ $customer->marketing_phone ?? '-' }} )</span></td>
        </tr>
    </table>

    <div class="section-title">3. Instruksi Khusus Pekerjaan</div>
    <div class="instructions">
        {!! nl2br(e($customer->spk->notes ?? 'Tim NOC diminta untuk melakukan proses penyediaan layanan sesuai detail di atas, termasuk penarikan kabel, pemasangan OLT/Router, aktivasi bandwidth, serta memastikan konektivitas internet berjalan dengan baik sebelum dilakukan serah terima (BAA) kepada pelanggan.')) !!}
    </div>

    <table class="signature-table">
        <tr>
            <td>
                Mengetahui & Menjalankan,<br>
                <strong>Tim Operation</strong>
                <div class="sign-area">
                    </div>
                <div class="sign-name">( .................................................... )</div>
                <div class="sign-title">Network Operation Center (NOC)</div>
            </td>
            <td>
                Hormat Kami,<br>
                <strong>PT Media Solusi Sukses</strong>
                <div class="sign-area">
                    <div class="fake-sign">Approved</div>
                </div>
                <div class="sign-name">{{ $customer->marketing_name ?? 'Administration' }}</div>
                <div class="sign-title">Sales / Marketing</div>
            </td>
        </tr>
    </table>

</body>
</html>