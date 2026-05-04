<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PT MSS - Internet Cepat & Stabil</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue: '#003fc8',
                            darkBlue: '#06245f',
                            softBlue: '#eaf1ff',
                            yellow: '#ffd500',
                            darkYellow: '#e6b900',
                            dark: '#101b3f',
                            muted: '#667085',
                            border: '#dce5f7',
                        }
                    },
                    boxShadow: {
                        'soft': '0 10px 25px rgba(11, 39, 94, 0.08)',
                        'hover': '0 18px 45px rgba(11, 39, 94, 0.12)',
                        'btn': '0 14px 30px rgba(0, 63, 200, 0.22)',
                        'badge': '0 10px 24px rgba(255, 213, 0, 0.4)',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-brand-dark antialiased bg-white selection:bg-brand-blue selection:text-white">

    <!-- Header / Navbar -->
    <header class="fixed w-full z-50 bg-white/92 backdrop-blur-[18px] border-b border-brand-border/70 transition-all duration-300">
        <div class="max-w-[1180px] mx-auto px-5 sm:px-6">
            <div class="flex justify-between items-center h-[82px]">
                
                <!-- Logo -->
                <a href="#beranda" class="flex-shrink-0 flex items-center gap-3">
                    <img src="{{ asset('logo/Logo MSS.png') }}" alt="PT MSS Logo" class="h-16 w-auto object-contain">
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="text-sm font-bold text-brand-blue relative py-[30px] after:content-[''] after:absolute after:left-0 after:bottom-[22px] after:w-full after:h-[3px] after:rounded-full after:bg-brand-blue after:transition-all">Beranda</a>
                    <a href="#paket" class="text-sm font-bold text-[#24304f] hover:text-brand-blue transition-colors relative py-[30px] after:content-[''] after:absolute after:left-0 after:bottom-[22px] after:w-0 hover:after:w-full after:h-[3px] after:rounded-full after:bg-brand-blue after:transition-all">Paket Internet</a>
                    <a href="#cakupan" class="text-sm font-bold text-[#24304f] hover:text-brand-blue transition-colors relative py-[30px] after:content-[''] after:absolute after:left-0 after:bottom-[22px] after:w-0 hover:after:w-full after:h-[3px] after:rounded-full after:bg-brand-blue after:transition-all">Cakupan Area</a>
                    <a href="#promo" class="text-sm font-bold text-[#24304f] hover:text-brand-blue transition-colors relative py-[30px] after:content-[''] after:absolute after:left-0 after:bottom-[22px] after:w-0 hover:after:w-full after:h-[3px] after:rounded-full after:bg-brand-blue after:transition-all">Promo</a>
                    <a href="#kontak" class="text-sm font-bold text-[#24304f] hover:text-brand-blue transition-colors relative py-[30px] after:content-[''] after:absolute after:left-0 after:bottom-[22px] after:w-0 hover:after:w-full after:h-[3px] after:rounded-full after:bg-brand-blue after:transition-all">Kontak</a>
                </nav>
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-3.5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-3 text-sm font-bold text-white bg-brand-blue rounded-xl shadow-btn hover:bg-[#002fa0] hover:-translate-y-0.5 transition-all">
                            Dashboard <i class="fa-solid fa-arrow-right ml-2.5"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-3 text-sm font-bold text-brand-blue bg-white border border-brand-blue rounded-xl hover:bg-brand-softBlue hover:-translate-y-0.5 transition-all">
                            <i class="fa-regular fa-user mr-2.5"></i> Login
                        </a>
                        <a href="{{ route('customer.register') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-3 text-sm font-bold text-[#151515] bg-brand-yellow rounded-xl hover:bg-brand-darkYellow hover:-translate-y-0.5 transition-all">
                            <i class="fa-solid fa-user-plus mr-2.5"></i> Daftar
                        </a>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button type="button" id="menuToggle" class="md:hidden inline-flex items-center justify-center w-11 h-11 border border-brand-border rounded-xl text-brand-blue hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-blue/50" aria-expanded="false">
                        <span class="sr-only">Buka main menu</span>
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobileMenu" class="md:hidden hidden bg-white border-b border-brand-border shadow-soft absolute w-full left-0 top-[82px]">
            <div class="px-5 pt-2 pb-6 space-y-1">
                <a href="#beranda" class="mobile-link block px-3 py-3 rounded-lg text-base font-bold text-brand-blue bg-brand-softBlue">Beranda</a>
                <a href="#paket" class="mobile-link block px-3 py-3 rounded-lg text-base font-bold text-[#24304f] hover:bg-gray-50 hover:text-brand-blue">Paket Internet</a>
                <a href="#cakupan" class="mobile-link block px-3 py-3 rounded-lg text-base font-bold text-[#24304f] hover:bg-gray-50 hover:text-brand-blue">Cakupan Area</a>
                <a href="#promo" class="mobile-link block px-3 py-3 rounded-lg text-base font-bold text-[#24304f] hover:bg-gray-50 hover:text-brand-blue">Promo</a>
                <a href="#kontak" class="mobile-link block px-3 py-3 rounded-lg text-base font-bold text-[#24304f] hover:bg-gray-50 hover:text-brand-blue">Kontak</a>
                
                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center px-5 py-3 text-sm font-bold text-white bg-brand-blue rounded-xl shadow-btn">
                            Dashboard <i class="fa-solid fa-arrow-right ml-2.5"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center px-5 py-3 text-sm font-bold text-brand-blue border border-brand-blue rounded-xl hover:bg-brand-softBlue">
                            <i class="fa-regular fa-user mr-2.5"></i> Login
                        </a>
                        <a href="{{ route('customer.register') }}" class="w-full inline-flex items-center justify-center px-5 py-3 text-sm font-bold text-[#151515] bg-brand-yellow rounded-xl hover:bg-brand-darkYellow">
                            <i class="fa-solid fa-user-plus mr-2.5"></i> Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="beranda" class="relative pt-[138px] pb-[124px] overflow-hidden bg-[radial-gradient(circle_at_80%_20%,rgba(0,63,200,0.12),transparent_32%),linear-gradient(180deg,#ffffff_0%,#f8fbff_100%)]">
            <div class="max-w-[1180px] mx-auto px-5 sm:px-6">
                <div class="grid lg:grid-cols-[1fr_1.08fr] gap-12 lg:gap-[50px] items-end">
                    
                    <div class="pt-4 lg:pt-0 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-softBlue text-brand-blue font-black text-[13px] tracking-[0.02em] mb-[22px]">
                            Koneksi Simetris 1:1 Eksklusif
                        </div>
                        
                        <h1 class="text-[clamp(38px,5vw,62px)] leading-[1.08] tracking-[-0.045em] font-black text-[#07183d] mb-[22px] max-w-[650px] mx-auto lg:mx-0">
                            Internet <span class="text-brand-blue">Cepat & Stabil</span> untuk Rumah dan Bisnis
                        </h1>
                        
                        <p class="text-[18px] text-brand-muted mb-[28px] max-w-[560px] mx-auto lg:mx-0">
                            Nikmati koneksi fiber optic berkecepatan tinggi, Wi-Fi stabil, dukungan pelanggan 24/7, dan harga terbaik untuk kebutuhan digital Anda.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-[18px] mb-[30px]">
                            @if (Route::has('customer.register'))
                                <a href="{{ route('customer.register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-[22px] py-3 text-sm font-bold text-white bg-brand-blue rounded-xl shadow-btn hover:bg-[#002fa0] hover:-translate-y-0.5 transition-all">
                                    Daftar Sekarang <i class="fa-solid fa-arrow-right ml-2.5"></i>
                                </a>
                            @endif
                            <a href="#paket" class="w-full sm:w-auto inline-flex items-center justify-center px-[22px] py-3 text-sm font-bold text-brand-blue bg-white border border-brand-blue rounded-xl hover:bg-brand-softBlue hover:-translate-y-0.5 transition-all">
                                Lihat Paket <i class="fa-solid fa-arrow-right ml-2.5"></i>
                            </a>
                        </div>

                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 text-[#34405f] text-sm font-bold">
                            <span><i class="fa-solid fa-shield-halved text-brand-blue mr-1.5"></i> Instalasi Cepat</span>
                            <span class="text-gray-300">•</span>
                            <span>Jaringan Andal</span>
                            <span class="text-gray-300">•</span>
                            <span>Support 24/7</span>
                        </div>
                    </div>

                    <div class="relative flex items-center justify-center lg:justify-end mt-8 lg:mt-0">
                        <img src="{{ asset('hero/hero.png') }}" alt="Ilustrasi Layanan Internet" class="w-full max-w-[760px] lg:w-[min(840px,115%)] lg:max-w-none h-auto object-contain lg:translate-x-[24px]">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features / Promo Section -->
        <section id="promo" class="relative z-10 -mt-[52px] lg:-mt-[98px] pb-[54px]">
            <div class="max-w-[1180px] mx-auto px-5 sm:px-6">
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Card 1 -->
                    <article class="bg-white/80 backdrop-blur-sm border border-brand-border rounded-[18px] p-6 shadow-soft hover:-translate-y-1.5 hover:shadow-hover transition-all">
                        <div class="w-16 h-16 rounded-full bg-brand-blue text-white flex items-center justify-center text-[28px] mb-[18px]">
                            <i class="fa-solid fa-gauge-high"></i>
                        </div>
                        <h3 class="text-[17px] font-bold text-brand-dark mb-2">Kecepatan Tinggi</h3>
                        <p class="text-sm text-brand-muted">Fiber optic berkecepatan tinggi hingga 100 Mbps untuk semua kebutuhan.</p>
                    </article>

                    <!-- Card 2 -->
                    <article class="bg-white/80 backdrop-blur-sm border border-brand-border rounded-[18px] p-6 shadow-soft hover:-translate-y-1.5 hover:shadow-hover transition-all">
                        <div class="w-16 h-16 rounded-full bg-brand-blue text-white flex items-center justify-center text-[28px] mb-[18px]">
                            <i class="fa-solid fa-wifi"></i>
                        </div>
                        <h3 class="text-[17px] font-bold text-brand-dark mb-2">Jaringan Stabil</h3>
                        <p class="text-sm text-brand-muted">Koneksi stabil tanpa putus, cocok untuk kerja, belajar, dan hiburan.</p>
                    </article>

                    <!-- Card 3 -->
                    <article class="bg-white/80 backdrop-blur-sm border border-brand-border rounded-[18px] p-6 shadow-soft hover:-translate-y-1.5 hover:shadow-hover transition-all">
                        <div class="w-16 h-16 rounded-full bg-brand-blue text-white flex items-center justify-center text-[28px] mb-[18px]">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h3 class="text-[17px] font-bold text-brand-dark mb-2">Layanan 24/7</h3>
                        <p class="text-sm text-brand-muted">Tim support profesional siap membantu Anda kapan saja.</p>
                    </article>

                    <!-- Card 4 -->
                    <article class="bg-white/80 backdrop-blur-sm border border-brand-border rounded-[18px] p-6 shadow-soft hover:-translate-y-1.5 hover:shadow-hover transition-all">
                        <div class="w-16 h-16 rounded-full bg-brand-blue text-white flex items-center justify-center text-[28px] mb-[18px]">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <h3 class="text-[17px] font-bold text-brand-dark mb-2">Harga Terjangkau</h3>
                        <p class="text-sm text-brand-muted">Paket internet berkualitas dengan harga terbaik untuk semua kalangan.</p>
                    </article>

                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="paket" class="py-16 lg:py-[64px] bg-[linear-gradient(180deg,#fff_0%,#f8fbff_100%)]">
            <div class="max-w-[1180px] mx-auto px-5 sm:px-6">
                <div class="text-center max-w-[720px] mx-auto mb-[38px]">
                    <h2 class="text-[clamp(30px,4vw,42px)] leading-[1.18] tracking-[-0.035em] font-black text-[#07183d] mb-2.5">Paket Internet Terbaik untuk Anda</h2>
                    <p class="text-base text-brand-muted">Pilih paket yang sesuai dengan kebutuhan rumah, kantor, atau bisnis Anda.</p>
                </div>

                <div class="grid lg:grid-cols-3 gap-6 items-stretch">
                    
                    <!-- Paket 1 -->
                    <article class="relative bg-white border border-brand-border rounded-[22px] shadow-soft hover:-translate-y-2 hover:shadow-hover transition-all overflow-hidden">
                        <div class="bg-brand-blue text-white text-center py-3 text-[13px] font-black">PAKET HEMAT</div>
                        <div class="p-[34px_28px_28px] text-center">
                            <h3 class="text-[42px] leading-none font-black text-brand-blue mb-3">30 <span class="text-[23px]">Mbps</span></h3>
                            <div class="text-[30px] font-black text-[#111827] mb-5">Rp199.000 <small class="text-sm font-semibold text-brand-muted">/bulan</small></div>
                            <ul class="text-left border-t border-brand-border pt-5 mb-[26px] space-y-3 text-[#34405f] text-sm">
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Download & Upload hingga 30 Mbps</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Wi-Fi Router Dual Band</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Kuota Unlimited</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Support 24/7</li>
                            </ul>
                            <a href="{{ route('customer.register') }}" class="block w-full text-center px-[22px] py-3 text-sm font-bold text-brand-blue bg-white border border-brand-blue rounded-xl hover:bg-brand-softBlue transition-all">Pilih Paket</a>
                        </div>
                    </article>

                    <!-- Paket 2 (Favorite) -->
                    <article class="relative bg-white border-2 border-brand-yellow rounded-[22px] shadow-hover lg:-translate-y-3 overflow-hidden">
                        <div class="bg-brand-yellow text-[#171717] text-center py-3 text-[13px] font-black">PAKET FAVORIT</div>
                        <div class="absolute top-[38px] right-[18px] w-12 h-12 rounded-full bg-brand-yellow border-4 border-white text-white flex items-center justify-center shadow-badge"><i class="fa-solid fa-star"></i></div>
                        <div class="p-[34px_28px_28px] text-center">
                            <h3 class="text-[42px] leading-none font-black text-brand-blue mb-3">50 <span class="text-[23px]">Mbps</span></h3>
                            <div class="text-[30px] font-black text-[#111827] mb-5">Rp299.000 <small class="text-sm font-semibold text-brand-muted">/bulan</small></div>
                            <ul class="text-left border-t border-brand-border pt-5 mb-[26px] space-y-3 text-[#34405f] text-sm">
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Download & Upload hingga 50 Mbps</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Wi-Fi Router Dual Band</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Kuota Unlimited</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Support 24/7</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Gratis Instalasi</li>
                            </ul>
                            <a href="{{ route('customer.register') }}" class="block w-full text-center px-[22px] py-3 text-sm font-bold text-white bg-brand-blue shadow-btn rounded-xl hover:bg-[#002fa0] hover:-translate-y-0.5 transition-all">Pilih Paket</a>
                        </div>
                    </article>

                    <!-- Paket 3 -->
                    <article class="relative bg-white border border-brand-border rounded-[22px] shadow-soft hover:-translate-y-2 hover:shadow-hover transition-all overflow-hidden">
                        <div class="bg-brand-blue text-white text-center py-3 text-[13px] font-black">PAKET MAX</div>
                        <div class="p-[34px_28px_28px] text-center">
                            <h3 class="text-[42px] leading-none font-black text-brand-blue mb-3">100 <span class="text-[23px]">Mbps</span></h3>
                            <div class="text-[30px] font-black text-[#111827] mb-5">Rp499.000 <small class="text-sm font-semibold text-brand-muted">/bulan</small></div>
                            <ul class="text-left border-t border-brand-border pt-5 mb-[26px] space-y-3 text-[#34405f] text-sm">
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Download & Upload hingga 100 Mbps</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Wi-Fi Router Dual Band</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Kuota Unlimited</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Support 24/7</li>
                                <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle-check text-brand-blue mt-[3px]"></i> Gratis Instalasi</li>
                            </ul>
                            <a href="{{ route('customer.register') }}" class="block w-full text-center px-[22px] py-3 text-sm font-bold text-brand-blue bg-white border border-brand-blue rounded-xl hover:bg-brand-softBlue transition-all">Pilih Paket</a>
                        </div>
                    </article>

                </div>

                <p class="text-center text-sm text-brand-muted mt-5"><i class="fa-solid fa-shield-halved text-brand-blue mr-1.5"></i> Semua paket sudah termasuk PPN 11%</p>
            </div>
        </section>

        <!-- Coverage Section -->
        <section id="cakupan" class="py-16 lg:py-[64px]">
            <div class="max-w-[1180px] mx-auto px-5 sm:px-6">
                <div class="grid lg:grid-cols-[0.95fr_1.4fr] gap-7 lg:gap-[30px] items-center bg-[radial-gradient(circle_at_20%_15%,rgba(255,255,255,0.18),transparent_25%),linear-gradient(135deg,#003fc8,#002a92)] text-white p-6 md:p-[34px] rounded-[28px] shadow-hover overflow-hidden">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-[18px]">
                        <div class="w-16 h-16 sm:w-[78px] sm:h-[78px] rounded-[24px] bg-brand-yellow text-brand-blue flex items-center justify-center text-3xl sm:text-[38px] shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl sm:text-[26px] leading-[1.2] font-bold mb-1.5">Cek Ketersediaan Area</h2>
                            <p class="text-sm text-white/80">Masukkan alamat Anda untuk memastikan layanan PT MSS tersedia di area Anda.</p>
                        </div>
                    </div>

                    <form action="#" method="GET" class="flex flex-col sm:flex-row gap-3 p-2.5 bg-white rounded-2xl shadow-[inset_0_0_0_1px_rgba(255,255,255,0.35)]">
                        <input type="text" name="alamat" placeholder="Masukkan alamat lengkap Anda" class="w-full sm:flex-1 border-0 outline-none px-4 h-12 sm:h-auto text-[15px] font-sans text-brand-dark bg-transparent">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-[22px] py-3 text-sm font-bold text-[#151515] bg-brand-yellow rounded-xl hover:bg-brand-darkYellow transition-all shrink-0">
                            Cek Sekarang <i class="fa-solid fa-arrow-right ml-2.5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Testimonial Section -->
        <section id="bantuan" class="py-16 lg:py-[64px]">
            <div class="max-w-[1180px] mx-auto px-5 sm:px-6">
                <div class="text-center max-w-[720px] mx-auto mb-[38px]">
                    <h2 class="text-[clamp(30px,4vw,42px)] leading-[1.18] tracking-[-0.035em] font-black text-[#07183d] mb-2.5">Apa Kata Pelanggan Kami</h2>
                    <p class="text-base text-brand-muted">Kepercayaan pelanggan adalah alasan kami terus meningkatkan kualitas layanan.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-[22px]">
                    
                    <article class="relative bg-white border border-brand-border rounded-[20px] p-[26px] shadow-soft">
                        <i class="fa-solid fa-quote-right absolute top-[22px] right-[24px] text-[34px] text-brand-blue/90"></i>
                        <div class="flex items-center gap-[14px] mb-[14px]">
                            <div class="w-[58px] h-[58px] rounded-full bg-brand-softBlue text-brand-blue flex items-center justify-center text-[24px] shrink-0"><i class="fa-solid fa-user-tie"></i></div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark">Andi Pratama</h4>
                                <p class="text-[13px] text-brand-muted">Karyawan Swasta</p>
                            </div>
                        </div>
                        <div class="text-brand-darkYellow text-sm mb-3">★★★★★</div>
                        <p class="text-sm text-[#34405f]">Koneksi sangat stabil untuk kerja remote. Speed sesuai paket dan tidak pernah mengecewakan!</p>
                    </article>

                    <article class="relative bg-white border border-brand-border rounded-[20px] p-[26px] shadow-soft">
                        <i class="fa-solid fa-quote-right absolute top-[22px] right-[24px] text-[34px] text-brand-blue/90"></i>
                        <div class="flex items-center gap-[14px] mb-[14px]">
                            <div class="w-[58px] h-[58px] rounded-full bg-brand-softBlue text-brand-blue flex items-center justify-center text-[24px] shrink-0"><i class="fa-solid fa-user"></i></div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark">Dewi Lestari</h4>
                                <p class="text-[13px] text-brand-muted">Ibu Rumah Tangga</p>
                            </div>
                        </div>
                        <div class="text-brand-darkYellow text-sm mb-3">★★★★★</div>
                        <p class="text-sm text-[#34405f]">Anak-anak bisa belajar online dan streaming tanpa buffering. Terima kasih PT MSS!</p>
                    </article>

                    <article class="relative bg-white border border-brand-border rounded-[20px] p-[26px] shadow-soft">
                        <i class="fa-solid fa-quote-right absolute top-[22px] right-[24px] text-[34px] text-brand-blue/90"></i>
                        <div class="flex items-center gap-[14px] mb-[14px]">
                            <div class="w-[58px] h-[58px] rounded-full bg-brand-softBlue text-brand-blue flex items-center justify-center text-[24px] shrink-0"><i class="fa-solid fa-user-check"></i></div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark">Rizky Maulana</h4>
                                <p class="text-[13px] text-brand-muted">Pemilik Usaha</p>
                            </div>
                        </div>
                        <div class="text-brand-darkYellow text-sm mb-3">★★★★★</div>
                        <p class="text-sm text-[#34405f]">Internet cepat dan support responsif. Sangat membantu bisnis kami berjalan lebih lancar.</p>
                    </article>

                </div>

                <div class="flex justify-center gap-2 mt-[28px]" aria-hidden="true">
                    <span class="w-[9px] h-[9px] rounded-full bg-brand-blue"></span>
                    <span class="w-[9px] h-[9px] rounded-full bg-[#cfd8ea]"></span>
                    <span class="w-[9px] h-[9px] rounded-full bg-[#cfd8ea]"></span>
                    <span class="w-[9px] h-[9px] rounded-full bg-[#cfd8ea]"></span>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="kontak" class="bg-[linear-gradient(135deg,#003fc8,#002274)] text-white pt-[54px] pb-[28px]">
        <div class="max-w-[1180px] mx-auto px-5 sm:px-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-[1.5fr_0.9fr_0.9fr_1.3fr] gap-10 lg:gap-[42px] mb-[34px]">
                
                <div>
                    <img src="{{ asset('logo/logo-mss.png') }}" alt="PT MSS Logo" class="w-[170px] mb-4 bg-white/10 p-2 rounded-xl">
                    <p class="text-white/80 max-w-[330px] mb-[22px] text-sm leading-relaxed">Menyediakan layanan internet fiber optic cepat, stabil, dan terpercaya untuk rumah dan bisnis di seluruh Indonesia.</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-white/10 hover:bg-brand-yellow hover:text-[#111] hover:-translate-y-[3px] transition-all" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-white/10 hover:bg-brand-yellow hover:text-[#111] hover:-translate-y-[3px] transition-all" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-white/10 hover:bg-brand-yellow hover:text-[#111] hover:-translate-y-[3px] transition-all" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center bg-white/10 hover:bg-brand-yellow hover:text-[#111] hover:-translate-y-[3px] transition-all" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="text-[17px] font-bold mb-[18px]">Tautan Cepat</h3>
                    <ul class="space-y-2.5 text-sm text-white/80">
                        <li><a href="#beranda" class="hover:text-brand-yellow transition-colors">Beranda</a></li>
                        <li><a href="#paket" class="hover:text-brand-yellow transition-colors">Paket Internet</a></li>
                        <li><a href="#cakupan" class="hover:text-brand-yellow transition-colors">Cakupan Area</a></li>
                        <li><a href="#promo" class="hover:text-brand-yellow transition-colors">Promo</a></li>
                        <li><a href="#bantuan" class="hover:text-brand-yellow transition-colors">Bantuan</a></li>
                        <li><a href="#kontak" class="hover:text-brand-yellow transition-colors">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-[17px] font-bold mb-[18px]">Layanan</h3>
                    <ul class="space-y-2.5 text-sm text-white/80">
                        <li><a href="#" class="hover:text-brand-yellow transition-colors">Internet Rumah</a></li>
                        <li><a href="#" class="hover:text-brand-yellow transition-colors">Internet Bisnis</a></li>
                        <li><a href="#" class="hover:text-brand-yellow transition-colors">Wi-Fi ID</a></li>
                        <li><a href="#" class="hover:text-brand-yellow transition-colors">Instalasi Baru</a></li>
                        <li><a href="#" class="hover:text-brand-yellow transition-colors">Upgrade Paket</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-[17px] font-bold mb-[18px]">Hubungi Kami</h3>
                    <ul class="space-y-3 text-sm text-white/80">
                        <li class="flex items-start gap-3"><i class="fa-solid fa-phone text-brand-yellow mt-1 w-[18px]"></i> <span>021-397 00 444</span></li>
                        <li class="flex items-start gap-3"><i class="fa-brands fa-whatsapp text-brand-yellow mt-1 w-[18px]"></i> <span>0812-2928-5291</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-envelope text-brand-yellow mt-1 w-[18px]"></i> <span>admin.office@mediasolusisukses.co.id</span></li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot text-brand-yellow mt-1 w-[18px]"></i> <span>Perum Bumi Karawang Residence<br>Blok G12 No. 7-9 <br>Desa Cengkong, Kecamatan Purwasari, Kabupaten Karawang, 41373</span></li>
                    </ul>
                </div>

            </div>

            <div class="flex flex-col md:flex-row justify-between gap-5 text-sm text-white/80 border-t border-white/20 pt-[22px]">
                <p>© {{ date('Y') }} PT MSS. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <span>|</span>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileLinks = document.querySelectorAll('.mobile-link');
            const menuIcon = menuToggle.querySelector('i');

            // Toggle menu on button click
            menuToggle.addEventListener('click', function () {
                const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
                menuToggle.setAttribute('aria-expanded', !isExpanded);
                
                if (!isExpanded) {
                    mobileMenu.classList.remove('hidden');
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-xmark');
                } else {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('fa-xmark');
                    menuIcon.classList.add('fa-bars');
                }
            });

            // Close menu when a link is clicked
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    menuToggle.setAttribute('aria-expanded', 'false');
                    menuIcon.classList.remove('fa-xmark');
                    menuIcon.classList.add('fa-bars');
                });
            });
        });
    </script>
</body>
</html>