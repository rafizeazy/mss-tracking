<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BAA - {{ $customer->company_name }}</title>
    <style>
        @page { margin: 40px 50px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #000; font-size: 12px; line-height: 1.4; }
        
        /* Header */
        .header-table { width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
        .comp-name { font-size: 18px; font-weight: bold; color: #1e5d87; margin:0;}
        .comp-sub { font-size: 10px; color: #555; }
        
        /* Title */
        .title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin-top: 15px; }
        .subtitle { text-align: center; font-size: 12px; margin-bottom: 20px; }

        /* Content */
        .paragraph { text-align: justify; margin-bottom: 15px; line-height: 1.6; }
        .info-table { width: 90%; margin: 0 auto 15px auto; }
        .info-table td { padding: 3px 0; vertical-align: top;}
        .td-label { width: 150px; }

        /* Signatures */
        .sign-table { width: 100%; margin-top: 40px; text-align: center; }
        .sign-table td { width: 50%; vertical-align: bottom; height: 120px; }
        .sign-img { max-height: 80px; max-width: 150px; margin-bottom: 5px; }

        /* Page 2 Attachments */
        .page-break { page-break-before: always; }
        .device-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .device-table th, .device-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .device-table th { background: #eee; }
        
        .img-attachment { max-width: 100%; max-height: 400px; display: block; margin: 10px auto; border: 1px solid #ccc;}
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
            <td width="20%">
                <h1 style="color:#669776; margin:0; font-size:28px; font-style:italic;">MSS</h1>
                <div style="font-size:9px; font-weight:bold; letter-spacing:1px;">SERVICE PROVIDER</div>
            </td>
            <td width="80%">
                <h2 class="comp-name">PT MEDIA SOLUSI SUKSES</h2>
                <div class="comp-sub">
                    Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong, Kec. Purwasari,<br>
                    Kab. Karawang, Jawa Barat 41373, Indonesia<br>
                    Phone: 021-39700444 Email: admin.office@mediasolusisukses.co.id
                </div>
            </td>
        </tr>
    </table>

    <div class="title">BERITA ACARA AKTIVASI</div>
    <div class="subtitle">No. {{ $customer->baa->baa_number }}</div>

    <div class="paragraph">
        Pada hari ini, {{ $hari }} tanggal {{ $tanggal }}, bulan {{ $bulan }}, tahun {{ $tahun }} ({{ $date->format('d/m/Y') }}), bertempat di Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong, Kec. Purwasari,
        Kab. Karawang, Jawa Barat 41373, Indonesia, Kami yang bertanda tangan di bawah ini:
    </div>

    <table class="info-table">
        <tr><td class="td-label">Nama</td><td>: {{ strtoupper($customer->baa->noc_name) }}</td></tr>
        <tr><td class="td-label">Jabatan</td><td>: {{ strtoupper($customer->baa->noc_position) }}</td></tr>
        <tr><td class="td-label">Departemen</td><td>: {{ strtoupper($customer->baa->noc_department) }}</td></tr>
        <tr><td class="td-label">Lokasi Kerja</td><td>: {{ strtoupper($customer->baa->noc_location) }}</td></tr>
    </table>

    <div class="paragraph">Selanjutnya di sebut <strong>PT MEDIA SOLUSI SUKSES</strong></div>

    <table class="info-table">
        <tr><td class="td-label">ID Pelanggan</td><td>: <strong>{{ $customer->customer_number }}</strong></td></tr>
        <tr><td class="td-label">Nama</td><td>: {{ strtoupper($customer->technical_name ?? $customer->user->name) }}</td></tr>
        <tr><td class="td-label">Nama Perusahaan</td><td>: {{ strtoupper($customer->company_name) }}</td></tr>
        <tr><td class="td-label">Kontak Telp</td><td>: {{ $customer->technical_phone ?? $customer->phone }}</td></tr>
    </table>

    <div class="paragraph">Selanjutnya di sebut <strong>PELANGGAN</strong><br>Menyatakan bahwa sebagai berikut:</div>

    <table class="info-table">
        <tr><td class="td-label">Alamat Pemasangan</td><td>: {{ $customer->installation_address ?? $customer->company_address }}</td></tr>
        <tr><td class="td-label">Jenis Layanan</td><td>: {{ $customer->service_type }}</td></tr>
        <tr><td class="td-label">Keterangan</td><td>: <strong>Aktif</strong></td></tr>
    </table>

    <div class="paragraph">
        Telah selesai dilakukan integrasi, serta dinyatakan SIAP DIGUNAKAN / DIOPERASIKAN, terhitung sejak tanggal ({{ $date->format('d-m-Y') }}).<br><br>
        Demikian Berita Acara ini dibuat dengan sebenar-benarnya dan sesuai dengan ketentuan agar dapat dipergunakan sebagaimana mestinya.
    </div>

    <table class="sign-table">
        <tr>
            <td>
                <strong>PT. MEDIA SOLUSI SUKSES</strong><br>
                @if($customer->baa->noc_signature_path)
                    <img src="{{ public_path('storage/' . $customer->baa->noc_signature_path) }}" class="sign-img">
                @else
                    <br><br><br><br>
                @endif
                <br>
                <u>({{ strtoupper($customer->baa->noc_name) }})</u>
            </td>
            <td>
                <strong>{{ strtoupper($customer->company_name) }}</strong><br>
                <br><br><br><br><br>
                <u>(......................................................)</u>
            </td>
        </tr>
    </table>
    <div style="font-size: 10px; margin-top: 15px;">*Catatan: Apabila selama 5 hari kerja dokumen (BAA) tidak ditandatangani maka kami anggap Setuju.</div>


    <div class="page-break"></div>
    <div style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">Lampiran</div>
    
    <table class="header-table">
        <tr>
            <td width="20%">
                <h1 style="color:#669776; margin:0; font-size:28px; font-style:italic;">MSS</h1>
                <div style="font-size:9px; font-weight:bold; letter-spacing:1px;">SERVICE PROVIDER</div>
            </td>
            <td width="80%">
                <h2 class="comp-name">PT MEDIA SOLUSI SUKSES</h2>
                <div class="comp-sub">
                    Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong, Kec. Purwasari,<br>
                    Kab. Karawang, Jawa Barat 41373, Indonesia<br>
                    Phone: 021-39700444 Email: admin.office@mediasolusisukses.co.id
                </div>
            </td>
        </tr>
    </table>

    <div style="font-weight: bold; margin: 15px 0 10px 0;">1. Perangkat</div>
    <table class="device-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Nama Perangkat</th>
                <th width="15%">QTY</th>
                <th width="35%">Serial Number (SN)</th>
            </tr>
        </thead>
        <tbody>
            @if(is_array($customer->baa->devices))
                @foreach($customer->baa->devices as $index => $dev)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $dev['name'] ?? '-' }}</td>
                    <td>{{ $dev['qty'] ?? '1' }}</td>
                    <td>{{ $dev['sn'] ?? '-' }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div style="font-weight: bold; margin: 25px 0 10px 0;">2. Bukti Limitasi Bandwidth / Speedtest</div>
    @if($customer->baa->speedtest_image_path)
        <img src="{{ public_path('storage/' . $customer->baa->speedtest_image_path) }}" class="img-attachment">
    @else
        <p style="color: #888; font-style: italic;">Gambar lampiran tidak tersedia.</p>
    @endif

</body>
</html>