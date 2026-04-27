{{--
    PT MSS Landing Page - Laravel 12 Blade
    Simpan sebagai: resources/views/landing.blade.php
    Asset logo: public/images/logo-mss.png
--}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PT MSS - Internet Cepat & Stabil</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --mss-blue: #003fc8;
            --mss-blue-dark: #06245f;
            --mss-blue-soft: #eaf1ff;
            --mss-yellow: #ffd500;
            --mss-yellow-dark: #e6b900;
            --mss-text: #101b3f;
            --mss-muted: #667085;
            --mss-border: #dce5f7;
            --mss-white: #ffffff;
            --shadow-sm: 0 10px 25px rgba(11, 39, 94, 0.08);
            --shadow-md: 0 18px 45px rgba(11, 39, 94, 0.12);
            --radius-md: 18px;
            --radius-lg: 28px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--mss-text);
            background: #fff;
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .container {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 46px;
            padding: 12px 22px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid transparent;
            transition: 0.25s ease;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--mss-blue);
            color: var(--mss-white);
            box-shadow: 0 14px 30px rgba(0, 63, 200, 0.22);
        }

        .btn-primary:hover {
            background: #002fa0;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: var(--mss-white);
            color: var(--mss-blue);
            border-color: var(--mss-blue);
        }

        .btn-outline:hover {
            background: var(--mss-blue-soft);
            transform: translateY(-2px);
        }

        .btn-yellow {
            background: var(--mss-yellow);
            color: #151515;
            border-color: var(--mss-yellow);
        }

        .btn-yellow:hover {
            background: var(--mss-yellow-dark);
            transform: translateY(-2px);
        }

        /* Header */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(220, 229, 247, 0.7);
        }

        .navbar {
            min-height: 82px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .brand img {
            height: 64px;
            width: auto;
            display: block;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 34px;
            list-style: none;
            font-weight: 700;
            font-size: 14px;
            color: #24304f;
        }

        .nav-menu a {
            position: relative;
            padding: 30px 0;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 22px;
            width: 0;
            height: 3px;
            border-radius: 999px;
            background: var(--mss-blue);
            transition: 0.25s ease;
        }

        .nav-menu a.active,
        .nav-menu a:hover {
            color: var(--mss-blue);
        }

        .nav-menu a.active::after,
        .nav-menu a:hover::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        .menu-toggle {
            display: none;
            width: 44px;
            height: 44px;
            border: 1px solid var(--mss-border);
            border-radius: 12px;
            background: var(--mss-white);
            color: var(--mss-blue);
            font-size: 20px;
        }

        /* Hero */
        .hero {
            position: relative;
            padding: 56px 0 124px;
            overflow: hidden;
            background:
                radial-gradient(circle at 80% 20%, rgba(0, 63, 200, 0.12), transparent 32%),
                linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1.08fr;
            align-items: end;
            gap: 50px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            background: var(--mss-blue-soft);
            color: var(--mss-blue);
            font-weight: 900;
            font-size: 13px;
            letter-spacing: 0.02em;
            margin-bottom: 22px;
        }

        .hero-title {
            max-width: 650px;
            font-size: clamp(38px, 5vw, 62px);
            line-height: 1.08;
            letter-spacing: -0.045em;
            font-weight: 900;
            color: #07183d;
            margin-bottom: 22px;
        }

        .hero-title span {
            color: var(--mss-blue);
        }

        .hero-description {
            max-width: 560px;
            color: var(--mss-muted);
            font-size: 18px;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .hero-points {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            color: #34405f;
            font-size: 14px;
            font-weight: 700;
        }

        .hero-points i {
            color: var(--mss-blue);
            margin-right: 6px;
        }

        .hero-visual {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .hero-image {
            width: min(840px, 115%);
            height: auto;
            object-fit: contain;
            display: block;
            transform: translateX(24px);
        }

        /* Feature */
        .features {
            position: relative;
            z-index: 5;
            margin-top: -98px;
            padding: 0 0 54px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .feature-card {
            background: var(--mss-white);
            border: 1px solid var(--mss-border);
            border-radius: var(--radius-md);
            padding: 24px;
            box-shadow: var(--shadow-sm);
            transition: 0.25s ease;
            backdrop-filter: blur(2px);
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--mss-blue);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 18px;
        }

        .feature-card h3 {
            font-size: 17px;
            margin-bottom: 8px;
        }

        .feature-card p {
            color: var(--mss-muted);
            font-size: 14px;
        }

        /* Sections */
        .section {
            padding: 64px 0;
        }

        .section-header {
            text-align: center;
            max-width: 720px;
            margin: 0 auto 38px;
        }

        .section-header h2 {
            font-size: clamp(30px, 4vw, 42px);
            line-height: 1.18;
            letter-spacing: -0.035em;
            color: #07183d;
            margin-bottom: 10px;
        }

        .section-header p {
            color: var(--mss-muted);
            font-size: 16px;
        }

        /* Pricing */
        .pricing {
            background: linear-gradient(180deg, #fff 0%, #f8fbff 100%);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 26px;
            align-items: stretch;
        }

        .price-card {
            position: relative;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--mss-border);
            border-radius: 22px;
            box-shadow: var(--shadow-sm);
            transition: 0.25s ease;
        }

        .price-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-md);
        }

        .price-card.favorite {
            border: 2px solid var(--mss-yellow);
            transform: translateY(-12px);
        }

        .price-ribbon {
            background: var(--mss-blue);
            color: #fff;
            text-align: center;
            padding: 12px;
            font-size: 13px;
            font-weight: 900;
        }

        .favorite .price-ribbon {
            background: var(--mss-yellow);
            color: #171717;
        }

        .price-content {
            padding: 34px 28px 28px;
            text-align: center;
        }

        .speed {
            color: var(--mss-blue);
            font-size: 42px;
            line-height: 1;
            font-weight: 900;
            margin-bottom: 12px;
        }

        .speed span {
            font-size: 23px;
        }

        .price {
            font-size: 30px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 20px;
        }

        .price small {
            color: var(--mss-muted);
            font-size: 14px;
            font-weight: 600;
        }

        .package-list {
            list-style: none;
            text-align: left;
            border-top: 1px solid var(--mss-border);
            padding-top: 20px;
            margin-bottom: 26px;
        }

        .package-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: #34405f;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .package-list i {
            color: var(--mss-blue);
            margin-top: 3px;
        }

        .favorite-badge {
            position: absolute;
            top: 38px;
            right: 18px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: var(--mss-yellow);
            border: 4px solid #fff;
            box-shadow: 0 10px 24px rgba(255, 213, 0, 0.4);
        }

        .tax-note {
            margin-top: 20px;
            color: var(--mss-muted);
            text-align: center;
            font-size: 14px;
        }

        .tax-note i {
            color: var(--mss-blue);
            margin-right: 7px;
        }

        /* Coverage */
        .coverage-card {
            display: grid;
            grid-template-columns: 0.95fr 1.4fr;
            gap: 30px;
            align-items: center;
            border-radius: 28px;
            padding: 34px;
            color: #fff;
            background:
                radial-gradient(circle at 20% 15%, rgba(255,255,255,0.18), transparent 25%),
                linear-gradient(135deg, var(--mss-blue), #002a92);
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .coverage-title {
            display: flex;
            gap: 18px;
            align-items: center;
        }

        .pin-icon {
            width: 78px;
            height: 78px;
            border-radius: 24px;
            background: var(--mss-yellow);
            color: var(--mss-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            flex-shrink: 0;
        }

        .coverage-title h2 {
            font-size: 26px;
            line-height: 1.2;
            margin-bottom: 5px;
        }

        .coverage-title p {
            color: rgba(255,255,255,0.82);
            font-size: 14px;
        }

        .coverage-form {
            display: flex;
            gap: 12px;
            padding: 9px;
            background: #fff;
            border-radius: 16px;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.35);
        }

        .coverage-form input {
            width: 100%;
            border: 0;
            outline: none;
            padding: 0 14px;
            font-size: 15px;
            font-family: inherit;
            color: var(--mss-text);
        }

        /* Testimonials */
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .testimonial-card {
            position: relative;
            background: #fff;
            border: 1px solid var(--mss-border);
            border-radius: 20px;
            padding: 26px;
            box-shadow: var(--shadow-sm);
        }

        .quote-mark {
            position: absolute;
            top: 22px;
            right: 24px;
            font-size: 34px;
            color: var(--mss-blue);
            opacity: 0.9;
        }

        .customer {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
        }

        .customer-avatar {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: var(--mss-blue-soft);
            color: var(--mss-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .customer h4 {
            font-size: 16px;
        }

        .customer p {
            color: var(--mss-muted);
            font-size: 13px;
        }

        .stars {
            color: var(--mss-yellow-dark);
            margin-bottom: 12px;
            font-size: 14px;
        }

        .testimonial-card > p {
            color: #34405f;
            font-size: 14px;
        }

        .dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 28px;
        }

        .dots span {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #cfd8ea;
        }

        .dots span.active {
            background: var(--mss-blue);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--mss-blue), #002274);
            color: #fff;
            padding: 54px 0 28px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 0.9fr 0.9fr 1.3fr;
            gap: 42px;
            margin-bottom: 34px;
        }

        .footer-brand img {
            width: 170px;
            margin-bottom: 16px;
        
        }

        .footer-brand p {
            color: rgba(255,255,255,0.82);
            max-width: 330px;
            margin-bottom: 22px;
        }

        .socials {
            display: flex;
            gap: 12px;
        }

        .socials a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.14);
            transition: 0.25s ease;
        }

        .socials a:hover {
            background: var(--mss-yellow);
            color: #111;
            transform: translateY(-3px);
        }

        .footer h3 {
            font-size: 17px;
            margin-bottom: 18px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
            color: rgba(255,255,255,0.82);
            font-size: 14px;
        }

        .footer-links a:hover {
            color: var(--mss-yellow);
        }

        .contact-list li {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .contact-list i {
            color: var(--mss-yellow);
            margin-top: 4px;
            width: 18px;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            color: rgba(255,255,255,0.78);
            font-size: 14px;
            border-top: 1px solid rgba(255,255,255,0.16);
            padding-top: 22px;
        }

        .footer-bottom-links {
            display: flex;
            gap: 16px;
        }

        /* Responsive */
        @media (max-width: 1080px) {
            .nav-menu {
                gap: 18px;
                font-size: 13px;
            }

            .hero-grid,
            .coverage-card {
                grid-template-columns: 1fr;
            }

            .hero-visual {
                min-height: 0;
                justify-content: center;
            }

            .hero-image {
                width: min(760px, 100%);
                transform: none;
            }

            .features {
                margin-top: -52px;
            }

            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 860px) {
            .menu-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .nav-menu {
                position: fixed;
                top: 82px;
                left: 0;
                right: 0;
                display: none;
                flex-direction: column;
                align-items: flex-start;
                gap: 0;
                padding: 20px;
                background: #fff;
                border-bottom: 1px solid var(--mss-border);
                box-shadow: var(--shadow-sm);
            }

            .nav-menu.show {
                display: flex;
            }

            .nav-menu a {
                display: block;
                padding: 12px 0;
            }

            .nav-menu a::after {
                bottom: 6px;
            }

            .nav-actions .btn {
                display: none;
            }

            .pricing-grid,
            .testimonial-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .features {
                margin-top: 0;
            }

            .price-card.favorite {
                transform: none;
            }

            .coverage-form {
                flex-direction: column;
            }

            .coverage-form input {
                min-height: 48px;
            }
        }

        @media (max-width: 620px) {
            .container {
                width: min(100% - 28px, 1180px);
            }

            .brand img {
                height: 52px;
                width: auto;
            }

            .hero {
                padding-top: 46px;
                padding-bottom: 34px;
            }

            .hero-actions,
            .hero-actions .btn {
                width: 100%;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .coverage-card {
                padding: 24px;
            }

            .coverage-title {
                flex-direction: column;
                align-items: flex-start;
            }

            .footer-bottom {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container navbar">
            <a href="#beranda" class="brand" aria-label="PT MSS">
                <img src="{{ asset('logo/logo-mss.png') }}" alt="PT MSS Logo">
            </a>

            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="#beranda" class="active">Beranda</a></li>
                    <li><a href="#paket">Paket Internet</a></li>
                    <li><a href="#cakupan">Cakupan Area</a></li>
                    <li><a href="#promo">Promo</a></li>
                    <li><a href="#bantuan">Bantuan</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </nav>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-outline">
                    <i class="fa-regular fa-user"></i>
                    Login
                </a>
                <a href="{{ route('customer.register') }}" class="btn btn-yellow">
                    <i class="fa-solid fa-user-plus"></i>
                    Daftar
                </a>
                <button type="button" class="menu-toggle" id="menuToggle" aria-label="Buka Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <main>
        <section class="hero" id="beranda">
            <div class="container hero-grid">
                <div class="hero-content">
                    

                    <h1 class="hero-title">
                        Internet <span>Cepat & Stabil</span> untuk Rumah dan Bisnis
                    </h1>

                    <p class="hero-description">
                        Nikmati koneksi fiber optic berkecepatan tinggi, Wi-Fi stabil, dukungan pelanggan 24/7, dan harga terbaik untuk kebutuhan digital Anda.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('customer.register') }}" class="btn btn-primary">
                            Daftar Sekarang
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="#paket" class="btn btn-outline">
                            Lihat Paket
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="hero-points">
                        <span><i class="fa-solid fa-shield-halved"></i> Instalasi Cepat</span>
                        <span>•</span>
                        <span>Jaringan Andal</span>
                        <span>•</span>
                        <span>Support 24/7</span>
                    </div>
                </div>

                <div class="hero-visual" aria-label="Ilustrasi layanan internet PT MSS">
                    <img src="{{ asset('logo/hero.png') }}" alt="Ilustrasi layanan internet PT MSS" class="hero-image">
                </div>
            </div>
        </section>

        <section class="features" id="promo">
            <div class="container feature-grid">
                <article class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-gauge-high"></i></div>
                    <h3>Kecepatan Tinggi</h3>
                    <p>Fiber optic berkecepatan tinggi hingga 100 Mbps untuk semua kebutuhan.</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-wifi"></i></div>
                    <h3>Jaringan Stabil</h3>
                    <p>Koneksi stabil tanpa putus, cocok untuk kerja, belajar, dan hiburan.</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-headset"></i></div>
                    <h3>Layanan 24/7</h3>
                    <p>Tim support profesional siap membantu Anda kapan saja.</p>
                </article>

                <article class="feature-card">
                    <div class="feature-icon"><i class="fa-solid fa-tag"></i></div>
                    <h3>Harga Terjangkau</h3>
                    <p>Paket internet berkualitas dengan harga terbaik untuk semua kalangan.</p>
                </article>
            </div>
        </section>

        <section class="section pricing" id="paket">
            <div class="container">
                <div class="section-header">
                    <h2>Paket Internet Terbaik untuk Anda</h2>
                    <p>Pilih paket yang sesuai dengan kebutuhan rumah, kantor, atau bisnis Anda.</p>
                </div>

                <div class="pricing-grid">
                    <article class="price-card">
                        <div class="price-ribbon">PAKET HEMAT</div>
                        <div class="price-content">
                            <h3 class="speed">30 <span>Mbps</span></h3>
                            <div class="price">Rp199.000 <small>/bulan</small></div>
                            <ul class="package-list">
                                <li><i class="fa-solid fa-circle-check"></i> Download & Upload hingga 30 Mbps</li>
                                <li><i class="fa-solid fa-circle-check"></i> Wi-Fi Router Dual Band</li>
                                <li><i class="fa-solid fa-circle-check"></i> Kuota Unlimited</li>
                                <li><i class="fa-solid fa-circle-check"></i> Support 24/7</li>
                            </ul>
                            <a href="{{ route('customer.register') }}" class="btn btn-outline" style="width: 100%;">Pilih Paket</a>
                        </div>
                    </article>

                    <article class="price-card favorite">
                        <div class="price-ribbon">PAKET FAVORIT</div>
                        <div class="favorite-badge"><i class="fa-solid fa-star"></i></div>
                        <div class="price-content">
                            <h3 class="speed">50 <span>Mbps</span></h3>
                            <div class="price">Rp299.000 <small>/bulan</small></div>
                            <ul class="package-list">
                                <li><i class="fa-solid fa-circle-check"></i> Download & Upload hingga 50 Mbps</li>
                                <li><i class="fa-solid fa-circle-check"></i> Wi-Fi Router Dual Band</li>
                                <li><i class="fa-solid fa-circle-check"></i> Kuota Unlimited</li>
                                <li><i class="fa-solid fa-circle-check"></i> Support 24/7</li>
                                <li><i class="fa-solid fa-circle-check"></i> Gratis Instalasi</li>
                            </ul>
                            <a href="{{ route('customer.register') }}" class="btn btn-primary" style="width: 100%;">Pilih Paket</a>
                        </div>
                    </article>

                    <article class="price-card">
                        <div class="price-ribbon">PAKET MAX</div>
                        <div class="price-content">
                            <h3 class="speed">100 <span>Mbps</span></h3>
                            <div class="price">Rp499.000 <small>/bulan</small></div>
                            <ul class="package-list">
                                <li><i class="fa-solid fa-circle-check"></i> Download & Upload hingga 100 Mbps</li>
                                <li><i class="fa-solid fa-circle-check"></i> Wi-Fi Router Dual Band</li>
                                <li><i class="fa-solid fa-circle-check"></i> Kuota Unlimited</li>
                                <li><i class="fa-solid fa-circle-check"></i> Support 24/7</li>
                                <li><i class="fa-solid fa-circle-check"></i> Gratis Instalasi</li>
                            </ul>
                            <a href="{{ route('customer.register') }}" class="btn btn-outline" style="width: 100%;">Pilih Paket</a>
                        </div>
                    </article>
                </div>

                <p class="tax-note"><i class="fa-solid fa-shield-halved"></i> Semua paket sudah termasuk PPN 11%</p>
            </div>
        </section>

        <section class="section" id="cakupan">
            <div class="container">
                <div class="coverage-card">
                    <div class="coverage-title">
                        <div class="pin-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <h2>Cek Ketersediaan Area</h2>
                            <p>Masukkan alamat Anda untuk memastikan layanan PT MSS tersedia di area Anda.</p>
                        </div>
                    </div>

                    <form class="coverage-form" action="#" method="GET">
                        <input type="text" name="alamat" placeholder="Masukkan alamat lengkap Anda">
                        <button type="submit" class="btn btn-yellow">
                            Cek Sekarang
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <section class="section" id="bantuan">
            <div class="container">
                <div class="section-header">
                    <h2>Apa Kata Pelanggan Kami</h2>
                    <p>Kepercayaan pelanggan adalah alasan kami terus meningkatkan kualitas layanan.</p>
                </div>

                <div class="testimonial-grid">
                    <article class="testimonial-card">
                        <i class="fa-solid fa-quote-right quote-mark"></i>
                        <div class="customer">
                            <div class="customer-avatar"><i class="fa-solid fa-user-tie"></i></div>
                            <div>
                                <h4>Andi Pratama</h4>
                                <p>Karyawan Swasta</p>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                        <p>Koneksi sangat stabil untuk kerja remote. Speed sesuai paket dan tidak pernah mengecewakan!</p>
                    </article>

                    <article class="testimonial-card">
                        <i class="fa-solid fa-quote-right quote-mark"></i>
                        <div class="customer">
                            <div class="customer-avatar"><i class="fa-solid fa-user"></i></div>
                            <div>
                                <h4>Dewi Lestari</h4>
                                <p>Ibu Rumah Tangga</p>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                        <p>Anak-anak bisa belajar online dan streaming tanpa buffering. Terima kasih PT MSS!</p>
                    </article>

                    <article class="testimonial-card">
                        <i class="fa-solid fa-quote-right quote-mark"></i>
                        <div class="customer">
                            <div class="customer-avatar"><i class="fa-solid fa-user-check"></i></div>
                            <div>
                                <h4>Rizky Maulana</h4>
                                <p>Pemilik Usaha</p>
                            </div>
                        </div>
                        <div class="stars">★★★★★</div>
                        <p>Internet cepat dan support responsif. Sangat membantu bisnis kami berjalan lebih lancar.</p>
                    </article>
                </div>

                <div class="dots" aria-hidden="true">
                    <span class="active"></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer" id="kontak">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <img src="{{ asset('logo/logo-mss.png') }}" alt="PT MSS Logo">
                    <p>Menyediakan layanan internet fiber optic cepat, stabil, dan terpercaya untuk rumah dan bisnis di seluruh Indonesia.</p>
                    <div class="socials">
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div>
                    <h3>Tautan Cepat</h3>
                    <ul class="footer-links">
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#paket">Paket Internet</a></li>
                        <li><a href="#cakupan">Cakupan Area</a></li>
                        <li><a href="#promo">Promo</a></li>
                        <li><a href="#bantuan">Bantuan</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h3>Layanan</h3>
                    <ul class="footer-links">
                        <li><a href="#">Internet Rumah</a></li>
                        <li><a href="#">Internet Bisnis</a></li>
                        <li><a href="#">Wi-Fi ID</a></li>
                        <li><a href="#">Instalasi Baru</a></li>
                        <li><a href="#">Upgrade Paket</a></li>
                    </ul>
                </div>

                <div>
                    <h3>Hubungi Kami</h3>
                    <ul class="footer-links contact-list">
                        <li><i class="fa-solid fa-phone"></i> <span>021-397 00 444</span></li>
                        <li><i class="fa-brands fa-whatsapp"></i> <span>0812-2928-5291</span></li>
                        <li><i class="fa-solid fa-envelope"></i> <span>admin.office@mediasolusisukses.co.id</span></li>
                        <li><i class="fa-solid fa-location-dot"></i> <span>Perum Bumi Karawang Residence<br>Blok G12 No. 7-9 <br>Desa Cengkong, Kecamatan Purwasari, Kabupaten Karawang, 41373</span></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>© {{ date('Y') }} PT MSS. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Kebijakan Privasi</a>
                    <span>|</span>
                    <a href="#">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');

        menuToggle?.addEventListener('click', () => {
            navMenu.classList.toggle('show');
        });

        document.querySelectorAll('.nav-menu a').forEach((link) => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('show');
            });
        });
    </script>
</body>
</html>
