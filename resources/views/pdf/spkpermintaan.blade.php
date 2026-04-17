<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SPK - {{ $request->request_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.5; margin: 0; padding: 20px;}
        .header { text-align: center; border-bottom: 2px solid #1e5d87; padding-bottom: 15px; margin-bottom: 25px; position: relative;}
        .title { font-size: 18px; font-weight: bold; text-decoration: underline; margin-bottom: 5px; color: #1e5d87; }
        .spk-info { margin-bottom: 25px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        table th, table td { border: 1px solid #dee2e6; padding: 12px; text-align: left; vertical-align: top; }
        .bg-light { background-color: #f8f9fa; font-weight: bold; width: 35%; color: #1e5d87; }
        .footer { margin-top: 50px; }
        .signature { width: 40%; text-align: center; float: right; }
        .warning { background-color: #ed6060; color: white; font-weight: bold; padding: 12px; margin-top: 25px; border-radius: 5px; text-align: center; font-size: 11px;}
    </style>
</head>
<body>
    <div class="header">
        <div class="title">SURAT PERINTAH KERJA (SPK) NOC</div>
        <div>Nomor Dokumen: SPK/{{ $request->request_number }}/{{ date('Y') }}</div>
    </div>

    <div class="spk-info">
        <p>Kepada Yth,<br><strong>Team NOC PT Media Solusi Sukses</strong></p>
        <p>Mohon dilakukan pengerjaan teknis pada jaringan pelanggan dengan detail sebagai berikut:</p>
    </div>

    <table>
        <tr><td class="bg-light">Jenis Pekerjaan</td><td><strong style="color: #ebb751; font-size: 14px;">{{ strtoupper($request->request_type) }} LAYANAN</strong></td></tr>
        <tr><td class="bg-light">Nama Pelanggan (PIC)</td><td>{{ $request->customer->technical_name ?? $request->customer->user->name ?? '-' }}</td></tr>
        <tr><td class="bg-light">Nama Perusahaan</td><td>{{ $request->customer->company_name ?? '-' }}</td></tr>
        <tr><td class="bg-light">Alamat Instalasi</td><td>{{ $request->customer->installation_address ?? $request->customer->company_address ?? '-' }}</td></tr>
        <tr><td class="bg-light">Metro / Vendor</td><td><strong>{{ $request->metro_vendor ?? '-' }}</strong></td></tr>
        
        @if($request->request_type !== 'Terminate')
            <tr><td class="bg-light">Kapasitas Awal</td><td>{{ $request->old_bandwidth ?? '-' }}</td></tr>
            <tr><td class="bg-light">Kapasitas Tujuan</td><td><strong style="color: #70bb63; font-size: 14px;">{{ $request->new_bandwidth ?? '-' }}</strong></td></tr>
        @endif

        <tr>
            {{-- Ubah Label Khusus Terminate --}}
            <td class="bg-light">
                {{ $request->request_type === 'Terminate' ? 'Tanggal Pemutusan' : 'Batas Waktu (Deadline)' }}
            </td>
            <td>
                <strong style="color: #ed6060;">
                    {{ $request->deadline_date ? \Carbon\Carbon::parse($request->deadline_date)->format('d F Y') : 'Belum Ditentukan' }}
                </strong>
            </td>
        </tr>
    </table>

    <div class="warning">
        @if($request->request_type === 'Terminate')
            WAJIB DIBACA: Harap melakukan pembongkaran/pemutusan perangkat tepat pada tanggal yang telah ditentukan, lalu konfirmasi pembuatan Berita Acara.
        @else
            WAJIB DIBACA: Harap melakukan pengecekan stabilitas jaringan setelah konfigurasi selesai dan segera berkoordinasi untuk penerbitan Berita Acara.
        @endif
    </div>

    <div class="footer">
        <div class="signature">
            <p>Dikeluarkan oleh,<br><strong>Marketing</strong></p>
            
            @php
                $ttdPath = public_path('ttd/marketing/ttdmarketing.png');
            @endphp

            @if(file_exists($ttdPath))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($ttdPath)) }}" alt="TTD Marketing" style="height: 80px; margin: 10px 0;">
            @else
                <br><br><br><br>
            @endif
            
            <p>( Sendy Irawan )</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>