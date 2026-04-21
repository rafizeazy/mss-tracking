<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SPK - {{ $request->request_number }}</title>
    <style>
        /* Pengaturan Halaman A4 & Margin Presisi */
        @page { 
            size: A4 portrait;
            margin: 30px 40px; 
        }
        
        /* Tipografi Resmi (Konsisten dengan Form Awal & BAA) */
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
            margin-bottom: 20px; 
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

        /* PARAGRAF PENGANTAR */
        .paragraf-pengantar {
            margin-bottom: 15px;
            font-size: 11px;
            line-height: 1.5;
        }

        /* TABEL STANDAR RESMI */
        .tabel-resmi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .tabel-resmi td {
            border: 1px solid #000;
            padding: 7px 10px;
            vertical-align: middle;
        }
        .tabel-resmi .label-col {
            width: 35%;
            font-weight: bold;
            background-color: #f4f4f4;
            color: #1e5d87;
        }

        /* KOTAK INSTRUKSI (WARNING) */
        .kotak-instruksi {
            border: 1px solid #1e5d87;
            padding: 10px 12px;
            text-align: justify;
            margin-bottom: 30px;
            background-color: #f8f9fa;
        }
        .kotak-instruksi.danger {
            border-color: #ed6060;
            background-color: #fdf5f5;
        }
        .kotak-instruksi strong {
            display: block;
            margin-bottom: 5px;
            font-size: 11px;
            text-transform: uppercase;
        }
        .kotak-instruksi.danger strong {
            color: #ed6060;
        }

        /* AREA TANDA TANGAN */
        .tabel-ttd { 
            width: 100%; 
            text-align: center; 
            margin-top: 15px; 
            page-break-inside: avoid; 
        }
        .tabel-ttd td { 
            width: 50%; 
            vertical-align: bottom; 
        }
        .ruang-ttd { 
            height: 70px; 
            display: flex; 
            align-items: flex-end; 
            justify-content: center; 
            margin: 5px 0;
        }
        .ruang-ttd img { 
            max-height: 65px; 
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
        <h1>Surat Perintah Kerja (SPK)</h1>
        <div>Nomor: {{ $spkNumber }}</div>
    </div>

    <div class="paragraf-pengantar">
        Kepada Yth,<br>
        <strong>Tim Network Operation Center (NOC)</strong><br>
        PT Media Solusi Sukses
        <br><br>
        Berdasarkan pengajuan perubahan layanan dari pihak pelanggan, mohon segera dilakukan pengerjaan teknis pada jaringan pelanggan dengan rincian instruksi sebagai berikut:
    </div>

    <table class="tabel-resmi">
        <tr>
            <td class="label-col">Jenis Pekerjaan</td>
            <td style="font-weight: bold; color: #ebb751; font-size: 13px; text-transform: uppercase;">{{ $request->request_type }} LAYANAN</td>
        </tr>
        <tr>
            <td class="label-col">Nama Perusahaan</td>
            <td style="font-weight: bold;">{{ $request->customer->company_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Nama Pelanggan (PIC)</td>
            <td>{{ $request->customer->technical_name ?? $request->customer->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat Instalasi</td>
            <td style="line-height: 1.4;">{{ $request->customer->installation_address ?? $request->customer->company_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Vendor / Jalur Metro</td>
            <td style="font-weight: bold;">{{ $request->metro_vendor ?? '-' }}</td>
        </tr>
        
        @if($request->request_type !== 'Terminate')
            <tr>
                <td class="label-col">Kapasitas Awal</td>
                <td>{{ $request->old_bandwidth ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Kapasitas Tujuan</td>
                <td style="font-weight: bold; color: #70bb63; font-size: 13px;">{{ $request->new_bandwidth ?? '-' }}</td>
            </tr>
        @endif

        <tr>
            <td class="label-col">
                {{ $request->request_type === 'Terminate' ? 'TANGGAL PEMUTUSAN' : 'BATAS WAKTU (DEADLINE)' }}
            </td>
            <td style="font-weight: bold; color: #ed6060;">
                {{ $request->deadline_date ? \Carbon\Carbon::parse($request->deadline_date)->format('d F Y') : 'Belum Ditentukan' }}
            </td>
        </tr>
    </table>

    @if($request->request_type === 'Terminate')
        <div class="kotak-instruksi danger">
            <strong><i style="color:#ed6060">PERHATIAN:</i> INSTRUKSI PEMUTUSAN (TERMINATION)</strong>
            Harap melakukan proses pembongkaran perangkat dan pemutusan koneksi fisik secara permanen tepat pada tanggal yang telah ditentukan. Seluruh perangkat milik PT Media Solusi Sukses wajib ditarik kembali dan dikonfirmasi melalui pembuatan Berita Acara Pemutusan.
        </div>
    @else
        <div class="kotak-instruksi">
            <strong style="color:#1e5d87">INSTRUKSI PENGERJAAN</strong>
            Harap melakukan penyesuaian konfigurasi kapasitas layanan sesuai dengan *Kapasitas Tujuan* yang tertera. Tim NOC diwajibkan untuk memastikan stabilitas jaringan setelah konfigurasi selesai dan berkoordinasi kembali untuk proses penerbitan Berita Acara.
        </div>
    @endif

    <table class="tabel-ttd">
        <tr>
            <td>
                <div>Diterima & Akan Dikerjakan,<br><strong>Tim Operation</strong></div>
                <div class="ruang-ttd"></div>
                <div class="nama-ttd">( .................................................... )</div>
                <div class="jabatan-ttd">Network Operation Center (NOC)</div>
            </td>
            <td>
                <div>Dikeluarkan Oleh,<br><strong>PT Media Solusi Sukses</strong></div>
                <div class="ruang-ttd">
                    <img src="{{ public_path('ttd/marketing/ttdmarketing.png') }}" alt="TTD Marketing" onerror="this.style.display='none';">
                </div>
                <div class="nama-ttd">{{ $request->customer->marketing_name ?? 'SENDY IRAWAN' }}</div>
                <div class="jabatan-ttd">Admin Marketing</div>
            </td>
        </tr>
    </table>

</body>
</html>