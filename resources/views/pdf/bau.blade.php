<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Berita Acara - {{ $request->customer->company_name }}</title>
    <style>
        /* Pengaturan Halaman A4 & Margin Presisi (Sama dengan BAA & SPK) */
        @page { 
            size: A4 portrait;
            margin: 30px 40px; 
        }
        
        /* Tipografi Resmi */
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            color: #000000; 
            font-size: 11px; 
            line-height: 1.4; 
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
            max-height: 400px; 
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
        $date = ($request->bau && $request->bau->upgrade_date) ? \Carbon\Carbon::parse($request->bau->upgrade_date) : \Carbon\Carbon::now();
        $hari = $date->translatedFormat('l');
        $tanggal = $date->format('d');
        $bulan = $date->translatedFormat('F');
        $tahun = $date->format('Y');
        
        $isTerminate = $request->request_type === 'Terminate';
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
        <h1>{{ $isTerminate ? 'Berita Acara Pemutusan Layanan' : 'Berita Acara Perubahan Layanan' }}</h1>
        <p>Nomor : {{ $bauNumber }}</p>
    </div>

    <div class="paragraf">
        Pada hari ini, <strong>{{ $hari }}</strong> tanggal <strong>{{ $tanggal }}</strong>, bulan <strong>{{ $bulan }}</strong>, tahun <strong>{{ $tahun }}</strong> ({{ $date->format('d/m/Y') }}), bertempat di Kantor PT Media Solusi Sukses, Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong, Kec. Purwasari, Kab. Karawang, Jawa Barat. Kami yang bertanda tangan di bawah ini:
    </div>

    <table class="tabel-resmi">
        <tr><td class="label-col">Nama Teknisi</td><td>{{ $request->bau->noc_pic_name ?? 'Tim NOC MSS' }}</td></tr>
        <tr><td class="label-col">Departemen</td><td>Network Operation Center (NOC)</td></tr>
    </table>

    <div class="paragraf">
        Dalam hal ini bertindak untuk dan atas nama <strong>PT MEDIA SOLUSI SUKSES</strong>, yang selanjutnya disebut sebagai <strong>PIHAK PERTAMA</strong>.
    </div>

    <table class="tabel-resmi">
        <tr><td class="label-col">ID Pelanggan</td><td><strong>{{ $request->customer->customer_number }}</strong></td></tr>
        <tr><td class="label-col">Nama PIC</td><td>{{ $request->customer->technical_name ?? $request->customer->user->name }}</td></tr>
        <tr><td class="label-col">Instansi / Perusahaan</td><td><strong>{{ $request->customer->company_name }}</strong></td></tr>
    </table>

    <div class="paragraf">
        Dalam hal ini bertindak untuk dan atas nama Instansi/Perusahaan tersebut di atas, yang selanjutnya disebut sebagai <strong>PELANGGAN</strong> atau <strong>PIHAK KEDUA</strong>.<br><br>
        Kedua belah pihak secara bersama-sama menyatakan bahwa telah dilakukan pekerjaan <strong>{{ strtoupper($request->request_type) }}</strong> layanan jaringan dengan rincian sebagai berikut:
    </div>

    <table class="tabel-resmi">
        <tr>
            <td class="label-col">Alamat Instalasi</td>
            <td style="line-height: 1.4;">{{ $request->customer->installation_address ?? $request->customer->company_address }}</td>
        </tr>
        
        @if($isTerminate)
            <tr>
                <td class="label-col">Layanan / Kapasitas</td>
                <td style="color: #d32f2f; font-weight: bold;">{{ $request->old_bandwidth }}</td>
            </tr>
            <tr>
                <td class="label-col">Status Pekerjaan</td>
                <td><strong>DIPUTUS DAN DIBONGKAR PERMANEN</strong></td>
            </tr>
        @else
            <tr>
                <td class="label-col">Kapasitas Awal</td>
                <td style="text-decoration: line-through; color: #d32f2f;">{{ $request->old_bandwidth }}</td>
            </tr>
            <tr>
                <td class="label-col">Kapasitas Baru</td>
                <td style="font-weight: bold; font-size: 12px;">{{ $request->new_bandwidth }}</td>
            </tr>
            <tr>
                <td class="label-col">Status Pekerjaan</td>
                <td><strong>Selesai dan Stabil</strong></td>
            </tr>
        @endif
    </table>

    <div class="paragraf">
        @if($isTerminate)
            Seluruh perangkat fisik milik PIHAK PERTAMA telah dicabut/dibongkar dari lokasi PIHAK KEDUA (terlampir dokumentasi pembongkaran). Dengan ditandatanganinya Berita Acara ini, maka seluruh kewajiban penyediaan layanan internet oleh PIHAK PERTAMA kepada PIHAK KEDUA dinyatakan <strong>BERAKHIR</strong>.
        @else
            Seluruh konfigurasi sistem maupun perangkat fisik (jika ada) telah selesai diuji coba (terlampir hasil pengujian Speedtest). Koneksi jaringan telah dinyatakan stabil dan layanan dengan kapasitas terbaru siap beroperasi dan digunakan.
        @endif
        <br><br>
        Demikian Berita Acara ini dibuat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya oleh kedua belah pihak.
    </div>

    <table class="tabel-ttd">
        <tr>
            <td>
                <div>Mengetahui,<br><strong>PT Media Solusi Sukses</strong></div>
                <div class="ruang-ttd">
                    @if($request->bau && $request->bau->noc_signature_path)
                        <img src="{{ public_path('storage/' . $request->bau->noc_signature_path) }}" alt="TTD NOC">
                    @endif
                </div>
                <div class="nama-ttd">{{ $request->bau->noc_pic_name ?? 'NOC MSS' }}</div>
                <div class="jabatan-ttd">Network Operation Center</div>
            </td>
            <td>
                <div>Menyetujui,<br><strong>Pelanggan (Pihak Kedua)</strong></div>
                <div class="ruang-ttd"></div>
                <div class="nama-ttd">{{ $request->customer->technical_name ?? $request->customer->user->name }}</div>
                <div class="jabatan-ttd">{{ $request->customer->company_name }}</div>
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
                <strong>LAMPIRAN BERITA ACARA {{ $isTerminate ? 'PEMUTUSAN' : 'PERUBAHAN' }}</strong>
                ID Pelanggan: {{ $request->customer->customer_number }}
            </td>
        </tr>
    </table>

    <div class="attachment-title">
        {{ $isTerminate ? 'A. Bukti Dokumentasi Pemutusan/Pembongkaran' : 'A. Bukti Pengujian Jaringan (Speedtest) Kapasitas Baru' }}
    </div>
    
    @if($request->bau && $request->bau->speedtest_image_path)
        <img src="{{ public_path('storage/' . $request->bau->speedtest_image_path) }}" class="img-attachment">
    @else
        <div style="padding: 40px; border: 1px dashed #000; text-align: center; color: #8a969c; background-color: #f8f9fa;">
            Gambar lampiran dokumentasi tidak tersedia atau belum diunggah oleh tim NOC.
        </div>
    @endif

</body>
</html>