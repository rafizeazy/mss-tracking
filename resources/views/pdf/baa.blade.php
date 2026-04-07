<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>BAA - {{ $customer->company_name }}</title>
    <style>
        @page { margin: 40px 50px; }
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            color: #313a46; 
            font-size: 12px; 
            line-height: 1.5; 
        }
        
        /* Header & Kop Surat */
        .header-table { 
            width: 100%; 
            border-bottom: 3px solid #1e5d87; 
            padding-bottom: 15px; 
            margin-bottom: 25px; 
        }
        .header-logo { max-height: 60px; width: auto; }
        .comp-name { 
            font-size: 20px; 
            font-weight: 900; 
            color: #1e5d87; 
            margin: 0 0 5px 0; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .comp-sub { font-size: 10px; color: #8a969c; line-height: 1.4; }
        
        /* Judul Dokumen */
        .title-container { text-align: center; margin-bottom: 30px; }
        .title { 
            font-size: 18px; 
            font-weight: bold; 
            color: #313a46;
            text-decoration: underline; 
            text-transform: uppercase;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        .subtitle { font-size: 13px; font-weight: bold; color: #669776; }

        /* Konten & Paragraf */
        .paragraph { text-align: justify; margin-bottom: 15px; }
        
        /* Tabel Informasi Modern */
        .info-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        .info-table td { 
            padding: 8px 12px; 
            border: 1px solid #e7e9eb; 
            vertical-align: middle; 
        }
        .info-table .td-label { 
            width: 30%; 
            background-color: #f8f9fa; 
            font-weight: bold; 
            color: #1e5d87; 
            border-right: 2px solid #1e5d87;
        }

        /* Tabel Tanda Tangan */
        .sign-table { width: 100%; margin-top: 40px; text-align: center; }
        .sign-table td { width: 50%; vertical-align: bottom; height: 130px; }
        .sign-title { font-weight: bold; color: #1e5d87; margin-bottom: 10px; }
        .sign-img { max-height: 90px; max-width: 180px; margin-bottom: 10px; }
        .sign-name { font-weight: bold; text-decoration: underline; text-transform: uppercase; }

        /* Halaman Lampiran */
        .page-break { page-break-before: always; }
        .attachment-title { 
            font-size: 16px; 
            font-weight: bold; 
            color: #1e5d87;
            margin: 20px 0 15px 0; 
            border-left: 4px solid #669776;
            padding-left: 10px;
        }

        /* Tabel Perangkat */
        .device-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .device-table th, .device-table td { 
            border: 1px solid #dee2e6; 
            padding: 10px; 
            text-align: left; 
        }
        .device-table th { 
            background-color: #1e5d87; 
            color: #ffffff; 
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .device-table tr:nth-child(even) { background-color: #f8f9fa; }
        
        .img-attachment { 
            max-width: 100%; 
            max-height: 350px; 
            display: block; 
            margin: 10px auto; 
            border: 2px dashed #dee2e6;
            padding: 5px;
            border-radius: 4px;
        }
        .footer-note { font-size: 10px; color: #ed6060; font-style: italic; margin-top: 20px; }
    </style>
</head>
<body>
    @php
        \Carbon\Carbon::setLocale('id');
        $date = \Carbon\Carbon::parse($customer->baa->activation_date);
        $hari = $date->translatedFormat('l');
        $tanggal = $date->format('d');
        $bulan = $date->translatedFormat('F');
        $tahun = $date->format('Y');
    @endphp

    <table class="header-table">
        <tr>
            <td width="25%" style="vertical-align: middle;">
                <img src="{{ public_path('logo/Logo MSS.png') }}" class="header-logo" alt="Logo MSS">
            </td>
            <td width="75%" style="text-align: right; vertical-align: middle;">
                <div class="comp-name">PT MEDIA SOLUSI SUKSES</div>
                <div class="comp-sub">
                    Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong, Kec. Purwasari,<br>
                    Kab. Karawang, Jawa Barat 41373, Indonesia<br>
                    <strong>Phone:</strong> 021-39700444 &nbsp;|&nbsp; <strong>Email:</strong> admin.office@mediasolusisukses.co.id
                </div>
            </td>
        </tr>
    </table>

    <div class="title-container">
        <div class="title">BERITA ACARA AKTIVASI</div>
        <div class="subtitle">NOMOR: {{ $customer->baa->baa_number }}</div>
    </div>

    <div class="paragraph">
        Pada hari ini, <strong>{{ $hari }}</strong> tanggal <strong>{{ $tanggal }}</strong>, bulan <strong>{{ $bulan }}</strong>, tahun <strong>{{ $tahun }}</strong> ({{ $date->format('d/m/Y') }}), bertempat di Kantor PT Media Solusi Sukses, Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong, Kec. Purwasari, Kab. Karawang, Jawa Barat, Kami yang bertanda tangan di bawah ini:
    </div>

    <table class="info-table">
        <tr><td class="td-label">Nama</td><td>{{ strtoupper($customer->baa->noc_name) }}</td></tr>
        <tr><td class="td-label">Jabatan</td><td>{{ strtoupper($customer->baa->noc_position) }}</td></tr>
        <tr><td class="td-label">Departemen</td><td>{{ strtoupper($customer->baa->noc_department) }}</td></tr>
        <tr><td class="td-label">Lokasi Kerja</td><td>{{ strtoupper($customer->baa->noc_location) }}</td></tr>
    </table>

    <div class="paragraph">
        Dalam hal ini bertindak untuk dan atas nama <strong>PT MEDIA SOLUSI SUKSES</strong>, yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.
    </div>

    <table class="info-table">
        <tr><td class="td-label">ID Pelanggan</td><td><strong>{{ $customer->customer_number }}</strong></td></tr>
        <tr><td class="td-label">Nama PIC</td><td>{{ strtoupper($customer->technical_name ?? $customer->user->name) }}</td></tr>
        <tr><td class="td-label">Instansi / Perusahaan</td><td>{{ strtoupper($customer->company_name) }}</td></tr>
        <tr><td class="td-label">Kontak Telepon</td><td>{{ $customer->technical_phone ?? $customer->phone }}</td></tr>
    </table>

    <div class="paragraph">
        Dalam hal ini bertindak untuk dan atas nama Instansi/Perusahaan tersebut di atas, yang selanjutnya disebut sebagai <strong>PELANGGAN</strong> atau <strong>PIHAK KEDUA</strong>.<br><br>
        Kedua belah pihak secara bersama-sama menyatakan bahwa layanan di bawah ini:
    </div>

    <table class="info-table">
        <tr><td class="td-label">Alamat Instalasi</td><td>{{ $customer->installation_address ?? $customer->company_address }}</td></tr>
        <tr><td class="td-label">Jenis Layanan</td><td><strong>{{ strtoupper($customer->service_type) }}</strong></td></tr>
        <tr><td class="td-label">Kapasitas Bandwidth</td><td><strong>{{ strtoupper($customer->bandwidth) }}</strong></td></tr>
        <tr><td class="td-label">Status Layanan</td><td><strong style="color: #70bb63;">AKTIF DAN TERHUBUNG</strong></td></tr>
    </table>

    <div class="paragraph">
        Telah selesai dilakukan instalasi, konfigurasi, serta pengujian konektivitas, dan dinyatakan <strong>SIAP DIGUNAKAN / DIOPERASIKAN</strong> terhitung sejak tanggal <strong>{{ $date->format('d-m-Y') }}</strong>.<br><br>
        Demikian Berita Acara Aktivasi ini dibuat dengan sebenar-benarnya dalam 2 (dua) rangkap untuk dapat dipergunakan sebagaimana mestinya oleh kedua belah pihak.
    </div>

    <table class="sign-table">
        <tr>
            <td>
                <div class="sign-title">PT MEDIA SOLUSI SUKSES</div>
                @if($customer->baa->noc_signature_path)
                    <img src="{{ public_path('storage/' . $customer->baa->noc_signature_path) }}" class="sign-img">
                @else
                    <br><br><br><br><br>
                @endif
                <div class="sign-name">{{ strtoupper($customer->baa->noc_name) }}</div>
                <div style="font-size: 11px; color: #8a969c; mt-1;">{{ strtoupper($customer->baa->noc_position) }}</div>
            </td>
            <td>
                <div class="sign-title">PELANGGAN</div>
                <br><br><br><br><br>
                <div class="sign-name">{{ strtoupper($customer->technical_name ?? $customer->user->name) }}</div>
                <div style="font-size: 11px; color: #8a969c; mt-1;">{{ strtoupper($customer->company_name) }}</div>
            </td>
        </tr>
    </table>
    
    <div class="footer-note">
        * Catatan: Apabila selama 5 (lima) hari kerja sejak dokumen BAA ini diterbitkan pihak Pelanggan tidak memberikan konfirmasi/tanda tangan, maka Pelanggan dianggap telah menyetujui seluruh isi Berita Acara ini.
    </div>

    <div class="page-break"></div>
    
    <table class="header-table">
        <tr>
            <td width="25%" style="vertical-align: middle;">
                <img src="{{ public_path('logo/Logo MSS.png') }}" class="header-logo" alt="Logo MSS">
            </td>
            <td width="75%" style="text-align: right; vertical-align: middle;">
                <div class="comp-name">PT MEDIA SOLUSI SUKSES</div>
                <div class="comp-sub">
                    <strong>LAMPIRAN BERITA ACARA AKTIVASI</strong><br>
                    ID Pelanggan: {{ $customer->customer_number }}
                </div>
            </td>
        </tr>
    </table>

    <div class="attachment-title">1. Detail Perangkat Terpasang</div>
    <table class="device-table">
        <thead>
            <tr>
                <th width="8%">NO</th>
                <th width="42%">NAMA PERANGKAT</th>
                <th width="15%">JUMLAH</th>
                <th width="35%">SERIAL NUMBER (SN)</th>
            </tr>
        </thead>
        <tbody>
            @if(is_array($customer->baa->devices))
                @foreach($customer->baa->devices as $index => $dev)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $dev['name'] ?? '-' }}</td>
                    <td style="text-align: center;">{{ $dev['qty'] ?? '1' }} Unit</td>
                    <td>{{ $dev['sn'] ?? '-' }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center; color: #8a969c;">Tidak ada data perangkat.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="attachment-title">2. Bukti Pengujian (Speedtest / Link Test)</div>
    @if($customer->baa->speedtest_image_path)
        <img src="{{ public_path('storage/' . $customer->baa->speedtest_image_path) }}" class="img-attachment">
    @else
        <div style="padding: 30px; border: 2px dashed #dee2e6; text-align: center; color: #8a969c; background-color: #f8f9fa;">
            Gambar lampiran pengujian tidak tersedia atau belum diunggah.
        </div>
    @endif

</body>
</html>