<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Berita Acara - {{ $request->customer->company_name }}</title>
    <style>
        @page { margin: 40px 50px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #313a46; font-size: 12px; line-height: 1.5; }
        .header-table { width: 100%; border-bottom: 3px solid #1e5d87; padding-bottom: 15px; margin-bottom: 25px; }
        .header-logo { max-height: 60px; width: auto; }
        .comp-name { font-size: 20px; font-weight: 900; color: #1e5d87; margin: 0 0 5px 0; text-transform: uppercase; letter-spacing: 0.5px; }
        .comp-sub { font-size: 10px; color: #8a969c; line-height: 1.4; }
        .title-container { text-align: center; margin-bottom: 30px; }
        .title { font-size: 18px; font-weight: bold; color: #313a46; text-decoration: underline; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 1px; }
        .subtitle { font-size: 13px; font-weight: bold; color: #669776; }
        .paragraph { text-align: justify; margin-bottom: 15px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 8px 12px; border: 1px solid #e7e9eb; vertical-align: middle; }
        .info-table .td-label { width: 30%; background-color: #f8f9fa; font-weight: bold; color: #1e5d87; border-right: 2px solid #1e5d87; }
        .sign-table { width: 100%; margin-top: 40px; text-align: center; }
        .sign-table td { width: 50%; vertical-align: bottom; height: 130px; }
        .sign-title { font-weight: bold; color: #1e5d87; margin-bottom: 10px; }
        .sign-img { max-height: 90px; max-width: 180px; margin-bottom: 10px; }
        .sign-name { font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        .page-break { page-break-before: always; }
        .attachment-title { font-size: 16px; font-weight: bold; color: #1e5d87; margin: 20px 0 15px 0; border-left: 4px solid #669776; padding-left: 10px; }
        .img-attachment { max-width: 100%; max-height: 400px; display: block; margin: 10px auto; border: 2px dashed #dee2e6; padding: 5px; border-radius: 4px; }
        .footer-note { font-size: 10px; color: #ed6060; font-style: italic; margin-top: 20px; }
    </style>
</head>
<body>
    @php
        \Carbon\Carbon::setLocale('id');
        $date = ($request->bau && $request->bau->upgrade_date) ? \Carbon\Carbon::parse($request->bau->upgrade_date) : \Carbon\Carbon::now();
        $hari = $date->translatedFormat('l');
        $tanggal = $date->format('d');
        $bulan = $date->translatedFormat('F');
        $tahun = $date->format('Y');
        
        $isTerminate = $request->request_type === 'Terminate';
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
        <div class="title">
            {{ $isTerminate ? 'BERITA ACARA PEMUTUSAN LAYANAN' : 'BERITA ACARA PERUBAHAN LAYANAN' }}
        </div>
        <div class="subtitle">NOMOR: BAU/{{ $request->request_number }}/{{ $date->format('m/Y') }}</div>
    </div>

    <div class="paragraph">
        Pada hari ini, <strong>{{ $hari }}</strong> tanggal <strong>{{ $tanggal }}</strong>, bulan <strong>{{ $bulan }}</strong>, tahun <strong>{{ $tahun }}</strong> ({{ $date->format('d/m/Y') }}), bertempat di Kantor PT Media Solusi Sukses, Kami yang bertanda tangan di bawah ini:
    </div>

    <table class="info-table">
        <tr>
            <td class="td-label">Nama Teknisi</td>
            <td>{{ strtoupper($request->bau->noc_pic_name ?? 'TIM NOC MSS') }}</td>
        </tr>
        <tr>
            <td class="td-label">Departemen</td>
            <td>NETWORK OPERATION CENTER (NOC)</td>
        </tr>
    </table>

    <div class="paragraph">
        Dalam hal ini bertindak untuk dan atas nama <strong>PT MEDIA SOLUSI SUKSES</strong>, yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.
    </div>

    <table class="info-table">
        <tr>
            <td class="td-label">ID Pelanggan</td>
            <td><strong>{{ $request->customer->customer_number }}</strong></td>
        </tr>
        <tr>
            <td class="td-label">Nama PIC</td>
            <td>{{ strtoupper($request->customer->technical_name ?? $request->customer->user->name) }}</td>
        </tr>
        <tr>
            <td class="td-label">Instansi / Perusahaan</td>
            <td>{{ strtoupper($request->customer->company_name) }}</td>
        </tr>
    </table>

    <div class="paragraph">
        Dalam hal ini bertindak untuk dan atas nama Instansi/Perusahaan tersebut di atas, yang selanjutnya disebut sebagai <strong>PELANGGAN</strong> atau <strong>PIHAK KEDUA</strong>.<br><br>
        Kedua belah pihak secara bersama-sama menyatakan bahwa telah dilakukan pekerjaan <strong>{{ strtoupper($request->request_type) }}</strong> layanan jaringan dengan rincian sebagai berikut:
    </div>

    <table class="info-table">
        <tr>
            <td class="td-label">Alamat Instalasi</td>
            <td>{{ $request->customer->installation_address ?? $request->customer->company_address }}</td>
        </tr>
        
        @if($isTerminate)
            <tr>
                <td class="td-label">Layanan / Kapasitas</td>
                <td><span style="color: #ed6060; font-weight: bold;">{{ $request->old_bandwidth }}</span></td>
            </tr>
            <tr>
                <td class="td-label">Status Pekerjaan</td>
                <td><strong style="color: #ed6060;">DIPUTUS DAN DIBONGKAR PERMANEN</strong></td>
            </tr>
        @else
            <tr>
                <td class="td-label">Kapasitas Awal</td>
                <td><span style="text-decoration: line-through; color: #ed6060;">{{ $request->old_bandwidth }}</span></td>
            </tr>
            <tr>
                <td class="td-label">Kapasitas Baru</td>
                <td><strong style="color: #70bb63;">{{ $request->new_bandwidth }}</strong></td>
            </tr>
            <tr>
                <td class="td-label">Status Pekerjaan</td>
                <td><strong style="color: #70bb63;">SELESAI DAN STABIL</strong></td>
            </tr>
        @endif
    </table>

    <div class="paragraph">
        @if($isTerminate)
            Seluruh perangkat fisik milik PIHAK PERTAMA telah dicabut/dibongkar dari lokasi PIHAK KEDUA (terlampir dokumentasi pembongkaran). Dengan ditandatanganinya Berita Acara ini, maka seluruh kewajiban penyediaan layanan internet oleh PIHAK PERTAMA kepada PIHAK KEDUA dinyatakan <strong>BERAKHIR</strong>.
        @else
            Seluruh konfigurasi fisik maupun sistem telah selesai diuji coba (terlampir hasil *speedtest*), dan layanan dengan kapasitas terbaru dinyatakan <strong>SIAP DIGUNAKAN</strong>.
        @endif
        <br><br>
        Demikian Berita Acara ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya oleh kedua belah pihak.
    </div>

    <table class="sign-table">
        <tr>
            <td>
                <div class="sign-title">PT MEDIA SOLUSI SUKSES</div>
                @if($request->bau && $request->bau->noc_signature_path)
                    <img src="{{ public_path('storage/' . $request->bau->noc_signature_path) }}" class="sign-img">
                @else
                    <br><br><br><br><br>
                @endif
                <div class="sign-name">{{ strtoupper($request->bau->noc_pic_name ?? 'NOC MSS') }}</div>
                <div style="font-size: 11px; color: #8a969c; margin-top: 5px;">NETWORK OPERATION CENTER</div>
            </td>
            <td>
                <div class="sign-title">PELANGGAN</div>
                <br><br><br><br><br>
                <div class="sign-name">{{ strtoupper($request->customer->technical_name ?? $request->customer->user->name) }}</div>
                <div style="font-size: 11px; color: #8a969c; margin-top: 5px;">{{ strtoupper($request->customer->company_name) }}</div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        * Catatan: Apabila dalam 5 (lima) hari kerja Pelanggan tidak memberikan konfirmasi/tanda tangan, maka Pelanggan dianggap telah menyetujui hasil dari Berita Acara ini.
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
                    <strong>LAMPIRAN BERITA ACARA {{ $isTerminate ? 'PEMUTUSAN' : 'PERUBAHAN' }} LAYANAN</strong><br>
                    ID Pelanggan: {{ $request->customer->customer_number }}
                </div>
            </td>
        </tr>
    </table>

    <div class="attachment-title">
        {{ $isTerminate ? 'Bukti Dokumentasi Pemutusan' : 'Bukti Pengujian Jaringan (Speedtest) Kapasitas Baru' }}
    </div>
    
    @if($request->bau && $request->bau->speedtest_image_path)
        <img src="{{ public_path('storage/' . $request->bau->speedtest_image_path) }}" class="img-attachment">
    @else
        <div style="padding: 30px; border: 2px dashed #dee2e6; text-align: center; color: #8a969c; background-color: #f8f9fa;">
            Gambar lampiran tidak tersedia atau belum diunggah.
        </div>
    @endif
</body>
</html>