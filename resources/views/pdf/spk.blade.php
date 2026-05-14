<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SPK - {{ $customer->company_name }}</title>
    <style>
        @page { 
            size: A4 portrait;
            margin: 30px 40px; 
        }
        
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            color: #000000; 
            font-size: 11px; 
            line-height: 1.3; 
        }
        
        h1, h2, h3, h4, h5, p { margin: 0; padding: 0; }

        .kop-surat { 
            width: 100%; 
            border-bottom: 3px solid #000; 
            padding-bottom: 10px; 
            margin-bottom: 15px; 
        }
        .kop-logo { max-height: 45px; width: auto; }
        .kop-teks { 
            text-align: right; 
            font-size: 10px; 
            line-height: 1.4;
        }
        .kop-teks strong { 
            font-size: 14px; 
            color: #1e5d87; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 2px;
        }

        .judul-dokumen {
            text-align: center;
            margin-bottom: 15px;
        }
        .judul-dokumen h1 {
            font-size: 14px;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }
        .judul-dokumen p {
            font-size: 10px;
            text-transform: uppercase;
        }

        .tabel-resmi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .tabel-resmi th, .tabel-resmi td {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: middle;
        }
        .tabel-resmi .label-col {
            width: 25%;
            font-weight: bold;
            background-color: #f4f4f4;
        }

        .judul-bagian {
            background-color: #1e5d87;
            color: #ffffff;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            padding: 4px 8px;
            margin-bottom: 0;
            border: 1px solid #1e5d87;
        }

        .kotak-instruksi {
            border: 1px solid #000;
            border-top: none;
            padding: 8px 10px;
            text-align: justify;
            margin-bottom: 15px;
            min-height: 35px;
        }

        .tabel-ttd {
            width: 100%;
            text-align: center;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .tabel-ttd td {
            width: 50%;
            vertical-align: bottom;
        }
        .ruang-ttd {
            height: 60px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            margin: 5px 0;
        }
        .ruang-ttd img {
            max-height: 60px;
            width: auto;
        }
        .nama-ttd {
            font-weight: bold;
            text-decoration: underline;
        }
        .jabatan-ttd {
            font-size: 10px;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    
    <table class="kop-surat">
        <tr>
            <td width="50%" style="vertical-align: middle;">
                <img src="{{ $pdfLogoPath ?? public_path('logo/Logo MSS.png') }}" class="kop-logo" alt="Logo MSS" onerror="this.style.display='none';">
            </td>
            <td width="50%" class="kop-teks" style="vertical-align: middle;">
                <strong>PT Media Solusi Sukses</strong>
                Perum. Bumi Karawang Residence, Blok G12 No. 7-9<br>
                Cengkong, Purwasari, Kab. Karawang, 41373<br>
                P: +62 21 397 00 444 | E: admin@mediasolusisukses.co.id
            </td>
        </tr>
    </table>

    <div class="judul-dokumen">
        <h1>Surat Perintah Kerja (SPK)</h1>
        <p>Dokumen Instalasi & Aktivasi Jaringan</p>
    </div>

    <table class="tabel-resmi">
        <tr>
            <td class="label-col" style="width: 18%;">Nomor SPK</td>
            <td style="width: 32%; font-weight: bold;">{{ $spk->spk_number ?? '-' }}</td>
            <td class="label-col" style="width: 18%;">Tanggal Terbit</td>
            <td style="width: 32%;">{{ $spk->created_at ? $spk->created_at->format('d F Y') : date('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label-col">Target Selesai</td>
            <td style="color: #d32f2f; font-weight: bold;">{{ $spk->due_date ? \Carbon\Carbon::parse($spk->due_date)->format('d F Y') : '-' }}</td>
            <td class="label-col">Diterbitkan Oleh</td>
            <td>{{ $service->marketing_name ?? 'Administration' }}</td>
        </tr>
    </table>

    <div class="judul-bagian">1. Informasi Pelanggan & Spesifikasi Layanan</div>
    <table class="tabel-resmi" style="border-top: none;">
        <tr>
            <td class="label-col">Nama Instansi/Usaha</td>
            <td style="font-weight: bold;">{{ $customer->company_name }}</td>
        </tr>
        <tr>
            <td class="label-col">ID Pelanggan</td>
            <td>{{ $customer->customer_number ?? 'DIISI SETELAH LAYANAN AKTIF' }}</td>
        </tr>
        <tr>
            <td class="label-col">Kategori Pelanggan</td>
            <td>{{ $spk->customer_type ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Jenis Layanan</td>
            <td>{{ $service->service_type ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Kapasitas Bandwidth</td>
            <td style="font-weight: bold; font-size: 12px;">{{ $service->bandwidth }}</td>
        </tr>
        <tr>
            <td class="label-col">Vendor Jalur Metro</td>
            <td>{{ $service->metro_link ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Jenis Pekerjaan</td>
            <td style="font-weight: bold;">{{ $spk->job_type ?? 'New Activation' }}</td>
        </tr>
    </table>

    <div class="judul-bagian">2. Lokasi Instalasi & Narahubung</div>
    <table class="tabel-resmi" style="border-top: none;">
        <tr>
            <td class="label-col">Alamat Pemasangan</td>
            <td style="line-height: 1.4;">{{ $service->installation_address ?? $customer->company_address }}</td>
        </tr>
        <tr>
            <td class="label-col">PIC Teknis (Lokasi)</td>
            <td>{{ $customer->technical_name ?? $customer->user->name }}</td>
        </tr>
        <tr>
            <td class="label-col">Nomor Kontak PIC</td>
            <td>{{ $customer->technical_phone ?? $customer->phone }}</td>
        </tr>
        <tr>
            <td class="label-col">PIC Sales/Marketing</td>
            <td>{{ $service->marketing_name ?? '-' }} ({{ $service->marketing_phone ?? '-' }})</td>
        </tr>
    </table>

    <div class="judul-bagian">3. Instruksi Khusus Pekerjaan NOC</div>
    <div class="kotak-instruksi">
        {!! nl2br(e($spk->notes ?? 'Tim NOC diminta untuk melakukan proses penyediaan layanan sesuai dengan spesifikasi di atas. Pekerjaan mencakup penarikan kabel, instalasi perangkat (OLT/Router), aktivasi bandwidth, dan pengujian stabilitas koneksi sebelum dilakukan serah terima Berita Acara (BAA) kepada pelanggan.')) !!}
    </div>

    <table class="tabel-ttd">
        <tr>
            <td>
                <div>Mengetahui & Melaksanakan,<br><strong>Tim Operation</strong></div>
                <div class="ruang-ttd"></div>
                <div class="nama-ttd">( .................................................... )</div>
                <div class="jabatan-ttd">Network Operation Center (NOC)</div>
            </td>
            <td>
                <div>Hormat Kami,<br><strong>PT Media Solusi Sukses</strong></div>
                <div class="ruang-ttd">
                    <img src="{{ $pdfMarketingSignaturePath ?? public_path('ttd/marketing/ttdmarketing.png') }}" alt="TTD Marketing" onerror="this.style.display='none';">
                </div>
                <div class="nama-ttd">{{ $service->marketing_name ?? 'Administration' }}</div>
                <div class="jabatan-ttd">Admin Marketing</div>
            </td>
        </tr>
    </table>
</body>
</html>
