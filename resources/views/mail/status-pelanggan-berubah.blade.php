<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $statusConfig['subject'] }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; background-color: #f0f4f8; color: #313a46; }
        .wrapper { max-width: 600px; margin: 40px auto; padding: 20px; }
        .card { background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: {{ $statusConfig['color'] }}; padding: 36px 40px; text-align: center; }
        .header .icon { font-size: 48px; line-height: 1; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; line-height: 1.3; }
        .body { padding: 36px 40px; }
        .greeting { font-size: 16px; color: #8a969c; margin-bottom: 20px; }
        .greeting strong { color: #313a46; }
        .message { font-size: 15px; color: #4c4c5c; line-height: 1.7; margin-bottom: 28px; }
        .detail-card { background: #f8f9fa; border: 1px solid #e7e9eb; border-radius: 8px; padding: 20px; margin-bottom: 28px; }
        .detail-card h3 { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #8a969c; letter-spacing: 0.08em; margin-bottom: 14px; }
        .detail-row { display: flex; justify-content: space-between; align-items: baseline; padding: 6px 0; border-bottom: 1px dashed #e7e9eb; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-size: 13px; color: #8a969c; }
        .detail-value { font-size: 13px; font-weight: 600; color: #313a46; text-align: right; max-width: 60%; }
        .cta-wrapper { text-align: center; margin-bottom: 28px; }
        .cta-button { display: inline-block; background: {{ $statusConfig['color'] }}; color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-size: 15px; font-weight: 700; letter-spacing: 0.01em; }
        .divider { border: none; border-top: 1px solid #e7e9eb; margin: 24px 0; }
        .footer { padding: 0 40px 36px; text-align: center; }
        .footer p { font-size: 12px; color: #a1a9b1; line-height: 1.6; }
        .footer strong { color: #8a969c; }
        .status-badge { display: inline-block; background: {{ $statusConfig['color'] }}20; color: {{ $statusConfig['color'] }}; border: 1px solid {{ $statusConfig['color'] }}40; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            {{-- Header --}}
            <div class="header">
                <div class="icon">{{ $statusConfig['icon'] }}</div>
                <h1>{{ $statusConfig['headline'] }}</h1>
            </div>

            {{-- Body --}}
            <div class="body">
                <p class="greeting">
                    Halo, <strong>{{ $customer->user->name }}</strong>
                </p>

                <p class="message" style="white-space: pre-line;">
                    {{ $statusConfig['body'] }}
                </p>

                {{-- Detail Layanan --}}
                <div class="detail-card">
                    <h3>Informasi Layanan</h3>
                    <div class="detail-row">
                        <span class="detail-label">Nama Perusahaan</span>
                        <span class="detail-value">{{ $customer->company_name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Paket Layanan</span>
                        <span class="detail-value">{{ $customer->bandwidth }} — {{ $customer->service_type }}</span>
                    </div>
                    @if ($customer->customer_number)
                        <div class="detail-row">
                            <span class="detail-label">ID Pelanggan</span>
                            <span class="detail-value">{{ $customer->customer_number }}</span>
                        </div>
                    @endif
                    <div class="detail-row">
                        <span class="detail-label">Status Saat Ini</span>
                        <span class="detail-value">
                            <span class="status-badge">{{ ucwords(str_replace('_', ' ', $newStatus)) }}</span>
                        </span>
                    </div>
                </div>

                {{-- CTA Button --}}
                <div class="cta-wrapper">
                    <a href="{{ config('app.url') }}" class="cta-button">
                        {{ $statusConfig['cta_label'] }} →
                    </a>
                </div>

                <hr class="divider">

                <p style="font-size: 13px; color: #8a969c; line-height: 1.6;">
                    Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi tim kami melalui email atau telepon. Kami siap membantu.
                </p>
            </div>

            {{-- Footer --}}
            <div class="footer">
                <p>
                    Email ini dikirim secara otomatis oleh sistem MSS Tracking.<br>
                    <strong>PT. Mitra Sarana Sukses</strong> &mdash; Karawang, Jawa Barat<br>
                    &copy; {{ date('Y') }} MSS. All rights reserved.
                </p>
            </div>
        </div>

        <p style="text-align: center; font-size: 11px; color: #c0c7d0; margin-top: 16px;">
            Anda menerima email ini karena terdaftar sebagai pelanggan MSS.
        </p>
    </div>
</body>
</html>
