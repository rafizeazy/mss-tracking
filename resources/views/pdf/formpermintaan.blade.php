<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulir Perubahan Layanan - {{ $request->request_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; font-size: 12px; margin: 0; padding: 0; }
        .header { border-bottom: 2px solid #1e5d87; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 150px; }
        .title { text-align: center; font-size: 16px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; color: #1e5d87; }
        .subtitle { text-align: center; font-size: 11px; margin-bottom: 20px; color: #666; }
        .section-title { background-color: #f8f9fa; padding: 5px 10px; font-weight: bold; border-left: 4px solid #1e5d87; margin: 15px 0 10px 0; text-transform: uppercase; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table td { padding: 5px 0; vertical-align: top; }
        .label { width: 30%; color: #666; }
        .value { width: 70%; font-weight: bold; }
        .box { border: 1px solid #dee2e6; padding: 15px; border-radius: 5px; margin-top: 10px; }
        .footer { margin-top: 50px; }
        .signature-table td { text-align: center; width: 50%; }
        .signature-space { height: 80px; }
        .terms { font-size: 10px; color: #777; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <table style="border: none;">
            <tr>
                <td style="width: 50%;">
                    <img src="https://ui-avatars.com/api/?name=MSS&color=1e5d87&background=eef2ff&size=128" class="logo">
                </td>
                <td style="width: 50%; text-align: right; color: #1e5d87;">
                    <strong style="font-size: 14px;">PT MEDIA SOLUSI SUKSES</strong><br>
                    <span style="font-size: 10px; color: #666;">Dedicated Internet Provider<br>Jl. Bumi Karawang Residence Blk. G12 No.7, Karawang</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="title">Formulir Permohonan Perubahan Layanan</div>
    <div class="subtitle">Nomor Dokumen: {{ $request->request_number }} | Tanggal: {{ date('d F Y') }}</div>

    <div class="section-title">Data Pelanggan</div>
    <table>
        <tr>
            <td class="label">Nama Perusahaan</td>
            <td class="value">: {{ $request->customer->company_name }}</td>
        </tr>
        <tr>
            <td class="label">ID Pelanggan</td>
            <td class="value">: {{ $request->customer->customer_number }}</td>
        </tr>
        <tr>
            <td class="label">Nama Penanggung Jawab</td>
            <td class="value">: {{ $request->customer->technical_name ?? $request->customer->user->name }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Instalasi</td>
            <td class="value">: {{ $request->customer->installation_address ?? $request->customer->company_address }}</td>
        </tr>
    </table>

    <div class="section-title">Detail Perubahan ({{ $request->request_type }})</div>
    <div class="box">
        <table>
            @if($request->request_type === 'Upgrade' || $request->request_type === 'Downgrade')
                <tr>
                    <td class="label">Layanan Saat Ini</td>
                    <td class="value">: {{ $request->old_bandwidth }}</td>
                </tr>
                <tr>
                    <td class="label">Layanan Terbaru</td>
                    <td class="value" style="color: #1e5d87;">: {{ $request->new_bandwidth }}</td>
                </tr>
                <tr>
                    <td class="label">Biaya Bulanan Baru</td>
                    <td class="value" style="color: #1f6e43;">: Rp {{ number_format($request->new_monthly_fee, 0, ',', '.') }} (Excl. PPN)</td>
                </tr>
            @else
                <tr>
                    <td class="label">Jenis Permintaan</td>
                    <td class="value">: Pemutusan Layanan (Termination)</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Berhenti</td>
                    <td class="value" style="color: #ed6060;">: {{ $request->stop_date->format('d F Y') }}</td>
                </tr>
            @endif
            <tr>
                <td class="label">Alasan Perubahan</td>
                <td class="value">: {{ $request->reason ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="terms">
        <strong>Syarat & Ketentuan:</strong>
        <ol>
            <li>Perubahan layanan ini akan efektif berlaku setelah dokumen ini ditandatangani dan diverifikasi.</li>
            <li>Untuk {{ $request->request_type }}, penyesuaian tagihan akan dilakukan pada siklus penagihan bulan berikutnya.</li>
            <li>Seluruh perangkat milik PT Media Solusi Sukses tetap menjadi milik perusahaan jika terjadi pemutusan layanan.</li>
        </ol>
    </div>

    <div class="footer">
        <table class="signature-table">
            <tr>
                <td>
                    <p>Disetujui Oleh,<br><strong>PT Media Solusi Sukses</strong></p>
                    <div class="signature-space"></div>
                    <p>__________________________<br><span style="font-size: 10px;">Account Manager</span></p>
                </td>
                <td>
                    <p>Pemohon,<br><strong>{{ $request->customer->company_name }}</strong></p>
                    <div class="signature-space"></div>
                    <p>__________________________<br><span style="font-size: 10px;">Tanda Tangan & Stempel</span></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>