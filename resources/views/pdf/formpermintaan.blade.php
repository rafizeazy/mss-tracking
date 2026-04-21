<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Perubahan Layanan - {{ $request->request_number }}</title>
    <style>
        /* Pengaturan Halaman A4 & Margin Presisi */
        @page { 
            size: A4 portrait;
            margin: 30px 40px; 
        }
        
        /* Tipografi Resmi (Konsisten dengan form awal) */
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            color: #000000; 
            font-size: 11px; 
            line-height: 1.3; 
        }
        
        h1, h2, h3, h4, h5, p { margin: 0; padding: 0; }

        /* KOP SURAT KONSISTEN */
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
            display: block; 
            margin-bottom: 2px; 
            text-transform: uppercase;
        }

        /* JUDUL DOKUMEN */
        .judul-dokumen { 
            text-align: center; 
            margin-bottom: 15px; 
        }
        .judul-dokumen h1 { 
            font-size: 16px; 
            text-decoration: underline; 
            text-transform: uppercase; 
            margin-bottom: 3px; 
            letter-spacing: 1px; 
        }
        .judul-dokumen p { 
            font-size: 11px; 
            font-weight: bold; 
            color: #4b5563;
        }

        /* JUDUL BAGIAN (SECTION) */
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

        /* TABEL STANDAR RESMI */
        .tabel-resmi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .tabel-resmi td {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: middle;
        }
        .tabel-resmi .label-col {
            width: 35%;
            font-weight: bold;
            background-color: #f4f4f4;
        }

        /* KOTAK SYARAT & KETENTUAN */
        .syarat-ketentuan {
            border: 1px solid #000;
            border-top: none;
            padding: 8px 10px 8px 25px;
            margin-bottom: 15px;
            font-size: 10px;
            line-height: 1.4;
        }
        .syarat-ketentuan ol {
            margin: 0;
            padding-left: 10px;
        }

        /* AREA TANDA TANGAN */
        .tabel-ttd { 
            width: 100%; 
            text-align: center; 
            margin-top: 15px; 
            page-break-inside: avoid; 
            border-collapse: collapse;
        }
        .tabel-ttd th {
            border: 1px solid #000;
            background-color: #f4f4f4;
            padding: 6px;
            font-weight: bold;
        }
        .tabel-ttd td { 
            border: 1px solid #000;
            width: 50%; 
            vertical-align: bottom; 
            height: 90px;
            padding: 5px;
        }
        .ruang-ttd { 
            height: 60px; 
            display: flex; 
            align-items: flex-end; 
            justify-content: center; 
        }
        .ruang-ttd img { 
            max-height: 60px; 
            width: auto; 
        }
        .nama-ttd { 
            font-weight: bold; 
            text-decoration: underline; 
            text-transform: uppercase;
            font-size: 11px;
        }
        .jabatan-ttd { 
            font-size: 10px; 
            margin-top: 2px; 
        }

        /* CATATAN KAKI */
        .footer-address { 
            text-align: center; 
            font-size: 9px; 
            color: #6b7280; 
            margin-top: 15px; 
            border-top: 1px dashed #000; 
            padding-top: 10px; 
        }
    </style>
</head>
<body>

    <table class="kop-surat">
        <tr>
            <td width="50%" style="vertical-align: middle;">
                <img src="{{ public_path('logo/Logo MSS.png') }}" class="kop-logo" alt="Logo MSS" onerror="this.style.display='none';">
            </td>
            <td width="50%" class="kop-teks" style="vertical-align: middle;">
                <strong>PT Media Solusi Sukses</strong>
                Perum. Bumi Karawang Residence, Blok G12 No. 7-9<br>
                Cengkong, Purwasari, Kab. Karawang, 41373<br>
                P: +62 21 397 00 444 | E: admin.office@mediasolusisukses.co.id
            </td>
        </tr>
    </table>
    
    <div class="judul-dokumen">
        <h1>Formulir Perubahan Layanan</h1>
        <p>Nomor Pengajuan: {{ $formNumber }} | Tanggal: {{ date('d F Y') }}</p>
    </div>
    
    <div class="judul-bagian">1. Data Pelanggan</div>
    <table class="tabel-resmi" style="border-top: none;">
        <tr>
            <td class="label-col">Nama Perusahaan</td>
            <td style="font-weight: bold;">{{ $request->customer->company_name }}</td>
        </tr>
        <tr>
            <td class="label-col">ID Pelanggan</td>
            <td>{{ $request->customer->customer_number }}</td>
        </tr>
        <tr>
            <td class="label-col">Nama Penanggung Jawab</td>
            <td>{{ $request->customer->technical_name ?? $request->customer->user->name }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Instalasi</td>
            <td>{{ $request->customer->installation_address ?? $request->customer->company_address }}</td>
        </tr>
    </table>

    <div class="judul-bagian">2. Detail Perubahan ({{ $request->request_type }})</div>
    <table class="tabel-resmi" style="border-top: none;">
        @if($request->request_type === 'Upgrade' || $request->request_type === 'Downgrade')
            <tr>
                <td class="label-col">Layanan Saat Ini</td>
                <td>{{ $request->old_bandwidth }}</td>
            </tr>
            <tr>
                <td class="label-col">Layanan Terbaru</td>
                <td style="font-weight: bold; color: #1e5d87;">{{ $request->new_bandwidth }}</td>
            </tr>
            <tr>
                <td class="label-col">Biaya Bulanan Baru</td>
                <td style="font-weight: bold; color: #1f6e43;">Rp {{ number_format($request->new_monthly_fee, 0, ',', '.') }} (Excl. PPN)</td>
            </tr>
        @else
            <tr>
                <td class="label-col">Jenis Permintaan</td>
                <td style="font-weight: bold;">Pemutusan Layanan (Termination)</td>
            </tr>
            <tr>
                <td class="label-col">Tanggal Berhenti</td>
                <td style="font-weight: bold; color: #d32f2f;">{{ $request->stop_date->format('d F Y') }}</td>
            </tr>
        @endif
        <tr>
            <td class="label-col">Alasan Perubahan</td>
            <td>{{ $request->reason ?? '-' }}</td>
        </tr>
    </table>

    <div class="judul-bagian">3. Syarat & Ketentuan</div>
    <div class="syarat-ketentuan">
        <ol>
            <li>Perubahan layanan ini akan efektif berlaku setelah dokumen ini ditandatangani dan diverifikasi.</li>
            <li>Untuk proses {{ $request->request_type }}, penyesuaian tagihan akan dilakukan pada siklus penagihan bulan berikutnya.</li>
            <li>Seluruh perangkat milik PT Media Solusi Sukses tetap menjadi milik perusahaan jika terjadi pemutusan layanan.</li>
        </ol>
    </div>

    <table class="tabel-ttd">
        <tr>
            <th>Pelanggan / Penanggung Jawab</th>
            <th>Untuk diisi oleh MSS</th>
        </tr>
        <tr>
            <td>
                <div class="ruang-ttd">
                    @if($request->signed_pdf_path)
                        <img src="{{ public_path('storage/' . $request->signed_pdf_path) }}" alt="TTD Pelanggan">
                    @endif
                </div>
                <div class="nama-ttd">{{ $request->customer->user->name ?? '-' }}</div>
                <div class="jabatan-ttd">
                    {{ $request->customer->company_name }}<br>
                    Tanggal: {{ $request->updated_at ? $request->updated_at->format('d M Y') : date('d M Y') }}
                </div>
            </td>
            <td>
                <div class="ruang-ttd">
                    <img src="{{ public_path('ttd/marketing/ttdmarketing.png') }}" alt="TTD Marketing" onerror="this.style.display='none';">
                </div>
                <div class="nama-ttd">{{ $request->customer->marketing_name ?? 'SENDY IRAWAN' }}</div>
                <div class="jabatan-ttd">
                    Account Manager<br>
                    Tanggal: {{ $request->updated_at ? $request->updated_at->format('d M Y') : date('d M Y') }}
                </div>
            </td>
        </tr>
    </table>

    <div class="footer-address">
        Kantor Pusat: Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong, Kec. Purwasari, Kab. Karawang, Jawa Barat, Indonesia
    </div>

</body>
</html>