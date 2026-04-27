<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>BAA - {{ $customer->company_name }}</title>
    <style>
        /* Pengaturan Halaman A4 & Margin Presisi */
        @page { 
            size: A4 portrait;
            margin: 30px 40px; 
        }
        
        /* Tipografi Resmi (Font yang sama dengan SPK) */
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            color: #000000; 
            font-size: 11px; 
            line-height: 1.4; 
        }
        
        h1, h2, h3, h4, h5, p { margin: 0; padding: 0; }
        
        /* KOP SURAT */
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
            font-size: 14px; 
            text-decoration: underline; 
            text-transform: uppercase; 
            margin-bottom: 3px; 
            letter-spacing: 1px; 
        }
        .judul-dokumen p { 
            font-size: 11px; 
            font-weight: bold; 
        }

        /* PARAGRAF TEKS */
        .paragraf { 
            text-align: justify; 
            margin-bottom: 10px; 
        }
        
        /* TABEL INFORMASI RESMI */
        .tabel-resmi { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px; 
        }
        .tabel-resmi td, .tabel-resmi th { 
            border: 1px solid #000; 
            padding: 5px 8px; 
            vertical-align: middle; 
        }
        .tabel-resmi .label-col { 
            width: 25%; 
            font-weight: bold; 
            background-color: #f4f4f4; 
        }

        /* TABEL LAMPIRAN PERANGKAT */
        .tabel-perangkat th { 
            background-color: #1e5d87; 
            color: #ffffff; 
            font-weight: bold; 
            text-transform: uppercase; 
            font-size: 10px; 
        }
        .tabel-perangkat tr:nth-child(even) { background-color: #f8f9fa; }

        /* AREA TANDA TANGAN */
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
            height: 70px; 
            text-align: center;
            margin: 5px 0; 
        }
        .ruang-ttd img { 
            max-height: 65px; 
            width: auto; 
            vertical-align: bottom;
        }
        .nama-ttd { 
            font-weight: bold; 
            text-decoration: underline; 
        }
        .jabatan-ttd { 
            font-size: 10px; 
            margin-top: 2px; 
        }

        /* CATATAN KAKI */
        .footer-note { 
            font-size: 10px; 
            font-style: italic; 
            margin-top: 15px; 
            border-top: 1px dashed #000;
            padding-top: 5px;
        }

        /* PEMISAH HALAMAN (PAGE 2) */
        .page-break { page-break-before: always; }
        
        .attachment-title { 
            font-size: 12px; 
            font-weight: bold; 
            margin: 15px 0 8px 0; 
            text-transform: uppercase; 
            border-bottom: 1px solid #000; 
            padding-bottom: 3px; 
        }
        
        .img-attachment { 
            max-width: 100%; 
            max-height: 380px; 
            display: block; 
            margin: 10px auto; 
            border: 1px solid #000; 
            padding: 3px; 
        }
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
        <h1>Berita Acara Aktivasi</h1>
        <p>Nomor: {{ $customer->baa->baa_number }}</p>
    </div>

    <div class="paragraf">
        Pada hari ini, <strong>{{ $hari }}</strong> tanggal <strong>{{ $tanggal }}</strong>, bulan <strong>{{ $bulan }}</strong>, tahun <strong>{{ $tahun }}</strong> ({{ $date->format('d/m/Y') }}), bertempat di Kantor PT Media Solusi Sukses, Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong, Kec. Purwasari, Kab. Karawang, Jawa Barat. Kami yang bertanda tangan di bawah ini:
    </div>

    <table class="tabel-resmi"> 
        <tr><td class="label-col">Nama</td><td style="text-transform: uppercase;">{{ $customer->baa->noc_name }}</td></tr>
        <tr><td class="label-col">Jabatan</td><td style="text-transform: uppercase;">{{ $customer->baa->noc_position }}</td></tr>
        <tr><td class="label-col">Departemen</td><td style="text-transform: uppercase;">{{ $customer->baa->noc_department }}</td></tr>
        <tr><td class="label-col">Lokasi Kerja</td><td>{{ $customer->baa->noc_location }}</td></tr>
    </table>

    <div class="paragraf">
        Dalam hal ini bertindak untuk dan atas nama <strong>PT MEDIA SOLUSI SUKSES</strong>, yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.
    </div>

    <table class="tabel-resmi">
        <tr><td class="label-col" >ID Pelanggan</td><td style="text-transform: uppercase;">{{ $customer->customer_number }}</td></tr>
        <tr><td class="label-col">Nama PIC</td><td style="text-transform: uppercase;">{{ $customer->technical_name ?? $customer->user->name }}</td></tr>
        <tr><td class="label-col">Instansi / Perusahaan</td><td style="text-transform: uppercase;">{{ $customer->company_name }}</td></tr>
        <tr><td class="label-col">Kontak Telepon</td><td style="text-transform: uppercase;">{{ $customer->technical_phone ?? $customer->phone }}</td></tr>
    </table>

    <div class="paragraf">
        Dalam hal ini bertindak untuk dan atas nama Instansi/Perusahaan tersebut di atas, yang selanjutnya disebut sebagai <strong>PELANGGAN</strong> atau <strong>PIHAK KEDUA</strong>.<br><br>
        Kedua belah pihak secara bersama-sama menyatakan bahwa layanan di bawah ini:
    </div>

    <table class="tabel-resmi">
        <tr><td class="label-col">Alamat Instalasi</td><td style="line-height: 1.4;">{{ $customer->installation_address ?? $customer->company_address }}</td></tr>
        <tr><td class="label-col">Jenis Layanan</td><td><strong>{{ ucwords($customer->service_type) }}</strong></td></tr>
        <tr><td class="label-col">Kapasitas Bandwidth</td><td><strong>{{ $customer->bandwidth }}</strong></td></tr>
        <tr><td class="label-col">Status Layanan</td><td><strong>Aktif dan Terhubung</strong></td></tr>
    </table>

    <div class="paragraf">
        Telah selesai dilakukan instalasi, konfigurasi, serta pengujian konektivitas, dan dinyatakan <strong>SIAP DIGUNAKAN / DIOPERASIKAN</strong> terhitung sejak tanggal <strong>{{ $date->format('d-m-Y') }}</strong>.<br><br>
        Demikian Berita Acara Aktivasi ini dibuat dengan sebenar-benarnya dalam 2 (dua) rangkap untuk dapat dipergunakan sebagaimana mestinya oleh kedua belah pihak.
    </div>

    <table class="tabel-ttd">
        <tr>
            <td>
                <div>Mengetahui,<br><strong>PT Media Solusi Sukses</strong></div>
                <div class="ruang-ttd">
                    @if($customer->baa->noc_signature_path)
                        <img src="{{ public_path('storage/' . $customer->baa->noc_signature_path) }}" alt="TTD NOC">
                    @endif
                </div>
                <div class="nama-ttd">{{ $customer->baa->noc_name }}</div>
                <div class="jabatan-ttd">{{ $customer->baa->noc_position }}</div>
            </td>
            <td>
                <div>Menyetujui,<br><strong>Pelanggan (Pihak Kedua)</strong></div>
                <div class="ruang-ttd"></div>
                <div class="nama-ttd">{{ $customer->technical_name ?? $customer->user->name }}</div>
                <div class="jabatan-ttd">{{ $customer->company_name }}</div>
            </td>
        </tr>
    </table>
    
    <div class="footer-note">
        * Catatan: Apabila selama 5 (lima) hari kerja sejak dokumen BAA ini diterbitkan pihak Pelanggan tidak memberikan konfirmasi/tanda tangan, maka Pelanggan dianggap telah menyetujui seluruh isi Berita Acara ini secara otomatis.
    </div>


    <div class="page-break"></div>
    
    <table class="kop-surat">
        <tr>
            <td width="50%" style="vertical-align: middle;">
                <img src="{{ public_path('logo/Logo MSS.png') }}" class="kop-logo" alt="Logo MSS" onerror="this.style.display='none';">
            </td>
            <td width="50%" class="kop-teks" style="vertical-align: middle;">
                <strong>PT Media Solusi Sukses</strong>
                <strong>LAMPIRAN BERITA ACARA AKTIVASI</strong>
                ID Pelanggan: {{ $customer->customer_number }}
            </td>
        </tr>
    </table>

    <div class="attachment-title">A. Detail Perangkat Terpasang</div>
    <table class="tabel-resmi tabel-perangkat">
        <thead>
            <tr>
                <th width="8%" style="text-align: center;">NO</th>
                <th width="42%" style="text-align: left;">NAMA PERANGKAT</th>
                <th width="15%" style="text-align: center;">JUMLAH</th>
                <th width="35%" style="text-align: left;">SERIAL NUMBER (SN)</th>
            </tr>
        </thead>
        <tbody>
            @if(is_array($customer->baa->devices) && count($customer->baa->devices) > 0)
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
                    <td colspan="4" style="text-align: center; color: #8a969c; padding: 15px;">Tidak ada data perangkat yang dilampirkan.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="attachment-title">B. Bukti Pengujian (Speedtest / Link Test)</div>
    @if($customer->baa->speedtest_image_path)
        <img src="{{ public_path('storage/' . $customer->baa->speedtest_image_path) }}" class="img-attachment">
    @else
        <div style="padding: 40px; border: 1px dashed #000; text-align: center; color: #8a969c; background-color: #f8f9fa;">
            Gambar lampiran pengujian tidak tersedia atau belum diunggah oleh tim NOC.
        </div>
    @endif

</body>
</html>