<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PT Media Solusi Sukses | Layanan Internet Dedicated Corporate</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
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
                            blue: '#1e5d87',
                            lightBlue: '#60addf',
                            green: '#1f6e43',
                            lightGreen: '#70bb63',
                            yellow: '#ebb751',
                            dark: '#313a46',
                            gray: '#8a969c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
    </style>
</head>
<body class="font-sans text-brand-dark antialiased bg-gray-50 selection:bg-brand-lightBlue selection:text-white">

    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img src="{{ asset('logo/Logo MSS.png') }}" alt="Logo MSS" class="h-10 w-auto object-contain" onerror="this.src='https://ui-avatars.com/api/?name=MSS&color=1e5d87&background=eef2ff'">
                    <div class="hidden sm:block">
                        <h1 class="text-lg font-extrabold text-brand-blue leading-tight tracking-tight">PT Media Solusi Sukses</h1>
                        <p class="text-[10px] font-semibold text-brand-gray uppercase tracking-wider">Internet Service Provider</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
                        <a href="#beranda" class="hover:text-brand-blue transition-colors">Beranda</a>
                        <a href="#keunggulan" class="hover:text-brand-blue transition-colors">Keunggulan Layanan</a>
                    </div>
                    
                    <div class="flex items-center gap-3 pl-6 md:border-l border-gray-200">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-brand-blue rounded-lg shadow-md hover:bg-[#164a6e] hover:shadow-lg transition-all">
                                Dashboard <i class="ti ti-arrow-right ml-2 text-lg"></i>
                            </a>
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-brand-blue hover:text-[#164a6e] transition-colors">
                                    Masuk Akun
                                </a>
                            @endif
                            @if (Route::has('customer.register'))
                                <a href="{{ route('customer.register') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-brand-green rounded-lg shadow-md hover:bg-[#175232] transition-all">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-white">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-[0.03]"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-lightBlue/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-lightGreen/10 blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-yellow/10 text-brand-yellow font-semibold text-xs uppercase tracking-wide border border-brand-yellow/20 mb-6">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-yellow opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-yellow"></span>
                </span>
                Koneksi Simetris 1:1 Eksklusif
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-brand-dark tracking-tight mb-6">
                Internet Dedicated <span class="text-brand-blue">Terbaik</span><br class="hidden md:block"> Untuk Bisnis Anda.
            </h1>
            
            <p class="mt-4 max-w-2xl mx-auto text-base md:text-lg text-gray-500 mb-10">
                Layanan internet premium dengan bandwidth murni tanpa bagi rasio. Kami menjamin kelancaran operasional perusahaan, transfer data besar, dan komunikasi server Anda dengan SLA 99.5%.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                @if (Route::has('customer.register'))
                    <a href="{{ route('customer.register') }}" class="group relative w-full sm:w-auto px-8 py-3.5 text-base font-bold text-white bg-brand-blue rounded-xl shadow-lg shadow-brand-blue/30 hover:bg-[#164a6e] hover:shadow-xl hover:-translate-y-0.5 transition-all overflow-hidden flex items-center justify-center gap-2">
                        <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-[shimmer_1.5s_infinite]"></div>
                        Bergabung Bersama Kami Sekarang
                        <i class="ti ti-arrow-right text-lg group-hover:translate-x-1 transition-transform"></i>
                    </a>
                @endif

                @auth
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-3.5 text-base font-bold text-brand-blue border-2 border-brand-blue rounded-xl hover:bg-brand-blue hover:text-white transition-all">
                        Buka Dashboard
                    </a>
                @endauth

                <a href="#keunggulan" class="w-full sm:w-auto px-8 py-3.5 text-base font-bold text-brand-dark bg-white border-2 border-gray-200 rounded-xl hover:border-brand-blue hover:text-brand-blue transition-all">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <section id="keunggulan" class="py-20 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-brand-dark mb-4">Mengapa Memilih Layanan Kami?</h2>
                <p class="text-gray-500">Kami fokus pada satu hal dan melakukannya dengan sangat baik: Menyediakan jalur internet khusus (Dedicated) yang tidak akan pernah mengecewakan operasional bisnis Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:border-brand-lightBlue/30 transition-all group">
                    <div class="w-14 h-14 bg-brand-blue/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="ti ti-arrows-transfer-up-down text-3xl text-brand-blue"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-3">Kecepatan Simetris 1:1</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">Nikmati rasio kecepatan Upload dan Download yang sama persis. Bandwidth 100% murni milik Anda tanpa dibagi dengan pengguna lain.</p>
                    <ul class="space-y-2 text-sm font-medium text-brand-dark mb-6">
                        <li class="flex items-center gap-2"><i class="ti ti-check text-brand-green text-lg"></i> Upload & Download Seimbang</li>
                        <li class="flex items-center gap-2"><i class="ti ti-check text-brand-green text-lg"></i> Tanpa Fair Usage Policy (FUP)</li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:border-brand-lightBlue/30 transition-all group relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-brand-yellow text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg uppercase tracking-wider">High Availability</div>
                    <div class="w-14 h-14 bg-brand-lightBlue/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="ti ti-shield-check text-3xl text-brand-lightBlue"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-3">Jaminan SLA 99.5%</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">Kami menjamin uptime jaringan yang maksimal untuk kelancaran operasional perusahaan Anda setiap hari.</p>
                    <ul class="space-y-2 text-sm font-medium text-brand-dark mb-6">
                        <li class="flex items-center gap-2"><i class="ti ti-check text-brand-green text-lg"></i> Infrastruktur Fiber Optic</li>
                        <li class="flex items-center gap-2"><i class="ti ti-check text-brand-green text-lg"></i> Garansi Kompensasi SLA</li>
                    </ul>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:border-brand-lightBlue/30 transition-all group">
                    <div class="w-14 h-14 bg-brand-green/10 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <i class="ti ti-headset text-3xl text-brand-green"></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-3">Proactive NOC 24/7</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">Tim teknis kami memantau trafik jaringan Anda secara proaktif selama 24 jam sehari untuk mencegah kendala.</p>
                    <ul class="space-y-2 text-sm font-medium text-brand-dark mb-6">
                        <li class="flex items-center gap-2"><i class="ti ti-check text-brand-green text-lg"></i> Respon Cepat 24 Jam</li>
                        <li class="flex items-center gap-2"><i class="ti ti-check text-brand-green text-lg"></i> Dedicated Account Manager</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-brand-blue relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center justify-between">
            <div class="text-center md:text-left mb-8 md:mb-0">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Sudah Menjadi Pelanggan?</h2>
                <p class="text-brand-lightBlue text-sm md:text-base">Pantau progres instalasi layanan, manajemen tagihan, hingga unduh dokumen BAA secara real-time.</p>
            </div>
            <div>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-brand-blue bg-white rounded-xl shadow-lg hover:bg-gray-50 transition-all">
                    <i class="ti ti-search text-xl mr-2"></i> Lacak Status Layanan Anda
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo/Logo MSS.png') }}" alt="Logo MSS" class="h-8 w-auto grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all" onerror="this.src='https://ui-avatars.com/api/?name=MSS&color=8a969c&background=f8f9fa'">
                    <div>
                        <p class="text-sm font-bold text-gray-600">PT Media Solusi Sukses</p>
                        <p class="text-xs text-gray-400">Jl. Bumi Karawang Residence Blk. G12 No.7, Karawang</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500 font-medium">
                    &copy; {{ date('Y') }} PT Media Solusi Sukses. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

</body>
</html>