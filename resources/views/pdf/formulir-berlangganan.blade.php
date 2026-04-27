<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Berlangganan - {{ $customer->company_name ?? 'Pelanggan' }}</title>
    <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px; 
            color: #111827; 
            line-height: 1.4; 
            margin: 0; 
            padding: 0; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 12px; 
        }
        td { 
            vertical-align: middle; 
        }
        .header-table {
            border-bottom: 3px solid #1e5d87; 
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-logo {
            height: 50px; 
            width: auto;
            object-fit: contain;
        }
        .header-company-name {
            font-size: 16px;
            font-weight: 800;
            color: #1e5d87;
            margin: 0 0 3px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header-contact {
            text-align: right;
            font-size: 10px;
            color: #4b5563;
            line-height: 1.4;
        }
        .header-contact strong {
            color: #1e5d87;
            font-size: 11px;
        }
        .title-doc { 
            text-align: center; 
            font-size: 18px; 
            font-weight: 800; 
            color: #1f2937; 
            letter-spacing: 1px; 
            margin-bottom: 4px; 
            text-decoration: underline; 
        }
        .subtitle-doc { 
            text-align: center; 
            font-size: 11px; 
            color: #4b5563; 
            margin-bottom: 20px; 
        }
        .section-header { 
            background-color: #f3f4f6; 
            font-size: 11px; 
            font-weight: bold; 
            color: #1e5d87; 
            padding: 6px 8px; 
            border: 1px solid #d1d5db; 
            border-bottom: none; 
        }
        .data-table td { 
            border: 1px solid #d1d5db; 
            padding: 6px 8px; 
        }
        .label-col { 
            width: 35%; 
            font-weight: bold; 
            color: #374151; 
            background-color: #f9fafb; 
        }
        .agreement-text { 
            font-size: 9.5px; 
            text-align: justify; 
            margin: 15px 0; 
            color: #374151; 
            line-height: 1.5; 
        }
        .signature-table { 
            margin-top: 15px; 
            page-break-inside: avoid;
        }
        .signature-table td { 
            border: 1px solid #d1d5db; 
            text-align: center; 
            padding: 5px; 
            width: 50%; 
            vertical-align: top;
        }
        .signature-header { 
            font-weight: bold; 
            background-color: #f3f4f6; 
            padding: 8px !important; 
            color: #1f2937; 
        }
        .signature-box { 
            height: 70px; 
        }
        .signature-name { 
            font-weight: bold; 
            text-decoration: underline; 
            font-size: 12px; 
            margin-bottom: 2px;
            color: #111827;
        }
        .signature-meta { 
            font-size: 10px; 
            color: #4b5563; 
        }
        .footer-address { 
            text-align: center; 
            font-size: 9px; 
            color: #6b7280; 
            margin-top: 25px; 
            border-top: 1px dashed #cbd5e1; 
            padding-top: 10px; 
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <table class="header-table" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 50%; vertical-align: middle;">
                <img src="{{ public_path('logo/Logo MSS.png') }}" alt="Logo MSS" class="header-logo">
            </td>
            <td style="width: 50%; vertical-align: middle;" class="header-contact">
                <h2 class="header-company-name">PT Media Solusi Sukses</h2>
                <strong>021-397 00 444</strong><br>
                admin.office@mediasolusisukses.co.id<br>
                www.mediasolusisukses.co.id
            </td>
        </tr>
    </table>
    
    <div class="title-doc">FORMULIR BERLANGGANAN</div>
    <div class="subtitle-doc">Dokumen Registrasi Resmi Pelanggan Baru</div>
    
    <div class="section-header">1. Data Penanggung Jawab (Pemberi Wewenang)</div>
    <table class="data-table">
        <tr><td class="label-col">Nama</td><td>{{ strtoupper($customer->user->name ?? '-') }}</td></tr>
        <tr><td class="label-col">No. KTP*</td><td>{{ $customer->ktp_number ?? '-' }}</td></tr>
        <tr><td class="label-col">Jenis Kelamin*</td><td>{{ strtoupper($customer->gender == 'L' ? 'Laki-Laki' : 'Perempuan') }}</td></tr>
        <tr><td class="label-col">Jabatan</td><td>{{ strtoupper($customer->position ?? '-') }}</td></tr>
        <tr><td class="label-col">Alamat Email*</td><td>{{ $customer->user->email ?? '-' }}</td></tr>
        <tr><td class="label-col">Nomor Handphone*</td><td>{{ $customer->phone ?? '-' }}</td></tr>
    </table>

    <div class="section-header">2. Informasi Perusahaan</div>
    <table class="data-table">
        <tr><td class="label-col">Nama Perusahaan / Institusi*</td><td>{{ strtoupper($customer->company_name ?? '-') }}</td></tr>
        <tr><td class="label-col">Jenis / Bidang Usaha*</td><td>{{ strtoupper($customer->business_type ?? '-') }}</td></tr>
        <tr><td class="label-col">NPWP Perusahaan</td><td>{{ $customer->npwp_number ?? '-' }}</td></tr>
        <tr><td class="label-col">Alamat Perusahaan</td><td>{{ strtoupper($customer->company_address ?? '-') }}</td></tr>
        <tr><td class="label-col">Kota *</td><td>{{ strtoupper($customer->city ?? '-') }}</td></tr>
        <tr><td class="label-col">Provinsi*</td><td>{{ strtoupper($customer->province ?? '-') }}</td></tr>
        <tr><td class="label-col">Kode Pos*</td><td>{{ $customer->postal_code ?? '-' }}</td></tr>
        <tr><td class="label-col">Nomor Telepon</td><td>{{ $customer->company_phone ?? '-' }}</td></tr>
    </table>

    <div class="section-header">3. Penanggung Jawab Invoice/Keuangan</div>
    <table class="data-table">
        <tr><td class="label-col">Nama Bagian Keuangan</td><td>{{ strtoupper($customer->finance_name ?? '-') }}</td></tr>
        <tr><td class="label-col">Alamat Penagihan</td><td>{{ strtoupper($customer->billing_address ?? '-') }}</td></tr>
        <tr><td class="label-col">Alamat Email</td><td>{{ $customer->finance_email ?? '-' }}</td></tr>
        <tr><td class="label-col">Nomor Handphone</td><td>{{ $customer->finance_phone ?? '-' }}</td></tr>
    </table>

    <div class="section-header">4. Penanggung Jawab Teknis</div>
    <table class="data-table">
        <tr><td class="label-col">Kontak Teknis</td><td>{{ strtoupper($customer->technical_name ?? '-') }}</td></tr>
        <tr><td class="label-col">Alamat Instalasi</td><td>{{ strtoupper($customer->installation_address ?? '-') }}</td></tr>
        <tr><td class="label-col">Alamat Email</td><td>{{ $customer->technical_email ?? '-' }}</td></tr>
        <tr><td class="label-col">Nomor Handphone</td><td>{{ $customer->technical_phone ?? '-' }}</td></tr>
    </table>
    <br><br><br><br><br>
    <div class="section-header">5. Provider Support Information</div>
    <table class="data-table">
        <tr><td class="label-col">Account Manager</td><td><strong>{{ $customer->marketing_name ?? 'Tegar Setya Anggara' }}</strong> ({{ $customer->marketing_phone ?? '0856-0029-9019' }})</td></tr>
        <tr><td class="label-col">Technical Support</td><td><strong>021-397 00 444</strong> / admin.office@mediasolusisukses.co.id</td></tr>
    </table>

    <div class="section-header">6. Detail Layanan / Service Details</div>
    <table class="data-table">
        <tr><td class="label-col">A. Tipe Layanan</td><td>{{ $customer->service_type ?? 'Internet Dedicated 1:1' }}</td></tr>
        <tr><td class="label-col">B. Kapasitas Bandwidth*</td><td>{{ $customer->bandwidth ?? '-' }}</td></tr>
        <tr><td class="label-col">C. Biaya Instalasi*</td><td>Rp {{ number_format($customer->registration_fee ?? 0, 0, ',', '.') }}</td></tr>
        <tr><td class="label-col">D. Biaya Bulanan*</td><td>Rp {{ number_format($customer->monthly_fee ?? 0, 0, ',', '.') }}</td></tr>
        <tr><td class="label-col">E. Masa Berlangganan</td><td> {{ $customer->term_of_service }} Tahun ({{ $customer->term_of_service * 12 }} Bulan)</td></tr>
        <tr><td class="label-col">F. Service Level Agreement (SLA)</td><td>{{ $customer->sla ?? '99.5%' }}</td></tr>
    </table>

    <!-- AGREEMENT & SIGNATURE -->
    <div class="agreement-text">
        Dengan ini kami menyatakan bahwa seluruh data dan informasi yang kami berikan di atas adalah benar dan dapat dipertanggungjawabkan. Kami telah membaca dan memahami Ketentuan dan Syarat Berlangganan Produk dan Layanan <b>PT Media Solusi Sukses</b> beserta lampiran-lampirannya yang merupakan satu kesatuan yang tidak terpisahkan dari Formulir Berlangganan ini. Dengan menandatangani Formulir Berlangganan ini, kami menyatakan menerima dan menyetujui untuk mematuhi seluruh ketentuan dan syarat yang berlaku di <b>PT Media Solusi Sukses</b> tanpa pengecualian.
    </div>

    <table class="signature-table" cellspacing="0">
        <tr>
            <td class="signature-header">Pelanggan / Penanggung Jawab</td>
            <td class="signature-header">Untuk diisi oleh MSS</td>
        </tr>
        <tr>
            <td>
                <div class="signature-box"></div>
                <div class="signature-name">{{ strtoupper($customer->user->name ?? '-') }}</div>
                <div class="signature-meta">
                    Jabatan: {{ strtoupper($customer->position ?? '-') }}<br>
                    Tanggal: {{ now()->format('d M Y') }}
                </div>
            </td>
            <td>
                <div class="signature-box">
                    <img src="{{ public_path('ttd/marketing/ttdmarketing.png') }}" alt="TTD Marketing" style="max-height: 80px; width: auto; margin: 0 auto; display: block;">
                </div>
                <div class="signature-name">{{ strtoupper($customer->marketing_name ?? 'Marketing') }}</div>
                <div class="signature-meta">
                    Marketing<br>
                    Tanggal: {{ now()->format('d M Y') }}
                </div>
            </td>
        </tr>
    </table>

    <table class="data-table" style="margin-top: 15px; page-break-inside: avoid;">
        <tr><td colspan="2" class="section-header" style="border-bottom: 1px solid #d1d5db;">Kelengkapan Dokumen Lampiran</td></tr>
        <tr>
            <td style="width:50%;">KTP Penanggung Jawab</td>
            <td style="width:50%;">NIB (Nomor Induk Berusaha)</td>
        </tr>
        <tr>
            <td style="width:50%;">NPWP Perusahaan</td>
            <td style="width:50%;">Sertifikat Standar / Izin Usaha</td>
        </tr>
    </table>

    <div class="footer-address">
        Kantor Pusat: Jl. Bumi Karawang Residence Blk. G12 No.7, Cengkong, Kec. Purwasari, Kab. Karawang, Jawa Barat, Indonesia
    </div>

</body>
</html>