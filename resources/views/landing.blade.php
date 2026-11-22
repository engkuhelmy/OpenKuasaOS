<!DOCTYPE html>
<html lang="ms" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KerjaAI — Sistem Operasi Perniagaan AI Sumber Terbuka Pertama Malaysia</title>
    <meta name="description" content="Iklan, jualan, staf, kewangan dan e-Invois LHDN dalam satu log masuk. 100% Sumber Terbuka berasaskan Laravel dan PostgreSQL dengan ejen pintar Tuah AI.">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap">
    <script>
        (function() {
            try {
                var theme = localStorage.getItem('openkuasa_theme');
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --ap-light: #F4F6F9;
            --ap-dark: #020B19;
            --ap-ink: #0B1D3A;
            --ap-ink-2: #4B5870;
            --ap-blue: #2563FF;
            --ap-blue-dark: #3697FE;
            --ap-gap: 14px;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #000;
            color: #111827;
            -webkit-font-smoothing: antialiased;
        }

        /* Top ribbon */
        .ap-ribbon {
            background: #0f172a;
            color: #e2e8f0;
            text-align: center;
            padding: 10px 20px;
            font-size: 13px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .ap-ribbon a {
            color: #60a5fa;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .ap-ribbon a:hover {
            text-decoration: underline;
        }

        /* Sticky Glass Nav */
        #navbar {
            background-color: rgba(0, 0, 0, 0.88) !important;
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        /* Hero Background with Space Earth Atmosphere */
        .hero-space {
            position: relative;
            background: radial-gradient(circle at 50% 20%, #0d1b3e 0%, #030816 60%, #000000 100%);
            overflow: hidden;
            min-height: 85vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 90px 24px 70px;
            color: #fff;
        }

        .hero-space::before {
            content: '';
            position: absolute;
            bottom: -150px;
            left: 50%;
            transform: translateX(-50%);
            width: 1200px;
            height: 380px;
            border-radius: 50%;
            background: radial-gradient(ellipse at 50% 10%, rgba(37, 99, 255, 0.35) 0%, rgba(59, 130, 246, 0.12) 40%, transparent 75%);
            filter: blur(28px);
            pointer-events: none;
        }

        .hero-grid-pattern {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 64px 64px;
            -webkit-mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.8) 0%, transparent 80%);
            mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.8) 0%, transparent 80%);
            pointer-events: none;
        }

        /* Caret blink */
        .ap-caret {
            display: inline-block;
            width: 3px;
            height: 0.9em;
            margin-left: 4px;
            vertical-align: -0.05em;
            background: #38bdf8;
            border-radius: 2px;
            animation: apCaret 1s steps(1, end) infinite;
        }
        @keyframes apCaret { 50% { opacity: 0; } }

        /* Bento Grid Apple-Style */
        .ap-stack {
            display: flex;
            flex-direction: column;
            gap: var(--ap-gap);
            background: #fff;
            padding: var(--ap-gap) 0;
        }

        .ap-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--ap-gap);
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
            padding: 0 16px;
        }

        .ap-tile {
            position: relative;
            overflow: hidden;
            background: var(--ap-light);
            border-radius: 28px;
            border: 1px solid rgba(11, 29, 58, 0.08);
            padding: 48px 32px;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .ap-tile--dark {
            background: var(--ap-dark);
            color: #f8fafc;
            border-color: rgba(255, 255, 255, 0.1);
        }

        .ap-tile--full {
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
        }

        /* Pulse and Animations */
        .live-dot {
            position: relative;
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
        }
        .live-dot::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 9999px;
            border: 1.5px solid rgba(34, 197, 94, 0.5);
            animation: livePulse 2s ease-out infinite;
        }
        @keyframes livePulse {
            0% { transform: scale(0.6); opacity: 1; }
            100% { transform: scale(2.2); opacity: 0; }
        }

        /* OS Flow Animation */
        .ap-os-flow {
            stroke: #3b82f6;
            stroke-width: 2.5;
            fill: none;
            stroke-dasharray: 6 12;
            stroke-linecap: round;
            animation: apFlow 1.6s linear infinite;
        }
        @keyframes apFlow {
            from { stroke-dashoffset: 36; }
            to { stroke-dashoffset: 0; }
        }

        /* Phone Mockup Frame */
        .phone-frame {
            border-radius: 36px;
            border: 8px solid #0f172a;
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .ap-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body class="bg-black text-slate-900 selection:bg-indigo-600 selection:text-white" x-data="{
    mobileMenuOpen: false,
    megaMenuOpen: false,
    words: ['Usahawan!', 'Founders!', 'Majikan!', 'Syarikat Berkembang!', 'Perniagaan Malaysia!'],
    currentWordIndex: 0,
    currentText: '',
    isDeleting: false,
    init() {
        this.typeEffect();
    },
    typeEffect() {
        const fullWord = this.words[this.currentWordIndex];
        if (this.isDeleting) {
            this.currentText = fullWord.substring(0, this.currentText.length - 1);
        } else {
            this.currentText = fullWord.substring(0, this.currentText.length + 1);
        }

        let speed = this.isDeleting ? 45 : 95;
        if (!this.isDeleting && this.currentText === fullWord) {
            speed = 1800; // Tunggu seketika selepas selesai menaip perkataan
            this.isDeleting = true;
        } else if (this.isDeleting && this.currentText === '') {
            this.isDeleting = false;
            this.currentWordIndex = (this.currentWordIndex + 1) % this.words.length;
            speed = 400;
        }
        setTimeout(() => this.typeEffect(), speed);
    }
}">

    <!-- ==============================================
         1. TOP ANNOUNCEMENT RIBBON
         ============================================== -->
    <div class="ap-ribbon">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-2 flex-wrap">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                ⚡ V2.0 Sumber Terbuka
            </span>
            <span>KerjaAI — Sistem Operasi Perniagaan Berkuasa AI 100% Percuma &amp; Self-Hosted Malaysia.</span>
            <a href="https://github.com/engkuhelmy/OpenKuasaOS" target="_blank" rel="noopener noreferrer">
                Bintang di GitHub <span aria-hidden="true">&rsaquo;</span>
            </a>
        </div>
    </div>

    <!-- ==============================================
         2. STICKY GLASS NAVBAR
         ============================================== -->
    <nav id="navbar" class="w-full">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <div class="flex items-center gap-8">
                <a href="{{ route('landing') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl overflow-hidden flex items-center justify-center shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform bg-white/10 p-0.5">
                        <img src="{{ asset('images/logo.png') }}" alt="KerjaAI Logo" class="w-full h-full object-cover rounded-[10px]">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-lg text-white tracking-tight leading-none">
                            Kerja<span class="text-indigo-400">AI</span>
                        </span>
                        <span class="text-[9px] uppercase tracking-widest text-slate-400 font-semibold mt-0.5">Open Source AI Business Platform</span>
                    </div>
                </a>

                <!-- Desktop Menu Links -->
                <div class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-300">
                    <!-- Modul Mega Trigger -->
                    <button type="button" @click="megaMenuOpen = !megaMenuOpen" class="flex items-center gap-1.5 hover:text-white transition-colors py-2 focus:outline-none">
                        <span>Modul Sistem</span>
                        <svg class="w-3.5 h-3.5 transition-transform" :class="megaMenuOpen ? 'rotate-180 text-indigo-400' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <a href="#ekosistem" class="hover:text-white transition-colors">Ekosistem Pahlawan</a>
                    <a href="#opensource" class="hover:text-white transition-colors">Kelebihan Open Source</a>
                    <a href="#arkitektur" class="hover:text-white transition-colors">Teknologi</a>
                    <a href="#faq" class="hover:text-white transition-colors">Soalan Lazim</a>
                </div>
            </div>

            <!-- Header Right CTAs -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2.5 rounded-full transition shadow-lg shadow-indigo-600/30">
                        <span>Buka Dashboard</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-white px-3 py-2 transition-colors">
                        Log Masuk
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 text-xs font-bold bg-white text-slate-950 hover:bg-slate-100 px-5 py-2.5 rounded-full transition shadow-md hover:shadow-lg">
                        <span>Mula Percuma</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-slate-300 hover:text-white p-2 focus:outline-none" aria-label="Toggle menu">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- ==================== DESKTOP MEGA MENU ==================== -->
        <div x-show="megaMenuOpen" @click.away="megaMenuOpen = false" x-transition class="absolute left-0 top-full w-full bg-slate-900 border-b border-slate-800 shadow-2xl py-8 px-6 text-slate-200">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-800">
                    <div>
                        <h4 class="text-sm font-bold text-white uppercase tracking-wider">5 Modul Pahlawan KerjaAI</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Semua peranti operasi perniagaan anda bersatu dalam satu pangkalan data terbuka.</p>
                    </div>
                    <span class="text-xs font-medium text-indigo-400 bg-indigo-950/60 border border-indigo-800 px-3 py-1 rounded-full">
                        Dikuasakan Laravel 13 &amp; PostgreSQL
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($modules as $mod)
                    <div class="group p-3 rounded-2xl border border-slate-800/80 bg-slate-950/50 hover:bg-slate-800/50 hover:border-indigo-500/40 transition">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-indigo-400 font-bold group-hover:bg-indigo-600 group-hover:text-white transition">
                                @if($mod['code'] === 'tuah') 🧠
                                @elseif($mod['code'] === 'jebat') 📢
                                @elseif($mod['code'] === 'kasturi') 🤝
                                @elseif($mod['code'] === 'lekiu') 👥
                                @elseif($mod['code'] === 'lekir') ⚖️
                                @else 💼
                                @endif
                            </span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h5 class="text-sm font-bold text-white group-hover:text-indigo-400 transition">{{ $mod['name'] }}</h5>
                                    <span class="text-[9px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded bg-slate-800 text-slate-300">{{ $mod['badge'] }}</span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ $mod['subtitle'] }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-2.5 line-clamp-2 leading-relaxed">
                            {{ $mod['description'] }}
                        </p>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400">
                    <span>100% Bebas Caj Lesen Per Pengguna &bull; Data 100% Hak Milik Anda</span>
                    <a href="{{ route('dashboard') }}" class="font-bold text-indigo-400 hover:text-indigo-300 flex items-center gap-1">
                        Terokai Dashboard Langsung &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- ==================== MOBILE MENU ==================== -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-slate-950 border-b border-slate-800 px-6 py-6 space-y-4 text-slate-200">
            <div class="space-y-2">
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Modul Pahlawan</p>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    @foreach($modules as $m)
                    <div class="p-2 rounded-lg bg-slate-900 border border-slate-800 flex items-center gap-2">
                        <span class="text-xs">
                            @if($m['code'] === 'tuah') 🧠
                            @elseif($m['code'] === 'jebat') 📢
                            @elseif($m['code'] === 'kasturi') 🤝
                            @elseif($m['code'] === 'lekiu') 👥
                            @elseif($m['code'] === 'lekir') ⚖️
                            @else ⚡
                            @endif
                        </span>
                        <span class="font-bold text-white">{{ $m['name'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 flex flex-col gap-2.5">
                <a href="#opensource" @click="mobileMenuOpen = false" class="text-sm font-semibold hover:text-white py-1">Kelebihan Open Source</a>
                <a href="#arkitektur" @click="mobileMenuOpen = false" class="text-sm font-semibold hover:text-white py-1">Teknologi</a>
                <a href="#faq" @click="mobileMenuOpen = false" class="text-sm font-semibold hover:text-white py-1">Soalan Lazim</a>
                
                <div class="pt-2 flex flex-col gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-sm">Buka Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl bg-slate-800 text-white font-bold text-sm">Log Masuk</a>
                        <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl bg-white text-slate-900 font-bold text-sm">Mula Percuma Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ==============================================
         3. HERO SECTION PENUH (LUXURY SPACE / DJI STYLE)
         ============================================== -->
    <section class="hero-space">
        <div class="hero-grid-pattern"></div>

        <!-- Badge Pelancaran -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/20 backdrop-blur-md text-xs font-semibold text-slate-200 mb-8 z-10 shadow-lg shadow-black/40">
            <span class="live-dot"></span>
            <span>KerjaAI V2.0 &bull; Alternatif Sumber Terbuka Kuasa AI Pertama Malaysia</span>
        </div>

        <!-- Headline Dinamik dengan Text Rotator -->
        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight max-w-5xl leading-[1.08] z-10 text-white">
            Hello <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-amber-300" x-text="currentText"></span><span class="ap-caret" aria-hidden="true"></span>
        </h1>

        <!-- Subtitle Berwawasan -->
        <p class="text-lg sm:text-2xl text-slate-300 font-medium max-w-3xl mt-6 leading-relaxed z-10">
            Sistem Operasi Perniagaan AI Sumber Terbuka Pertama Malaysia.
        </p>
        <p class="text-sm sm:text-base text-slate-400 max-w-2xl mt-2 leading-normal z-10">
            Iklan (Jebat), Jualan &amp; Produk (Kasturi), HR &amp; Pengambilan Staf (Lekiu) serta Kewangan &amp; Invois (Lekir) disatukan dengan kecerdasan Tuah AI di pelayan anda sendiri.
        </p>

        <!-- Butang Tindakan Hero -->
        <div class="flex flex-wrap items-center justify-center gap-4 mt-8 z-10">
            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full bg-white text-slate-950 font-bold text-base hover:bg-slate-100 transition shadow-xl hover:scale-105 transform">
                    <span>Buka Sistem KerjaAI</span>
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full bg-white text-slate-950 font-bold text-base hover:bg-slate-100 transition shadow-xl hover:scale-105 transform">
                    <span>Pasang Percuma Sekarang</span>
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            @endauth

            <a href="#ekosistem" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-base transition backdrop-blur-md">
                <span>Terokai 5 Modul Pahlawan</span>
                <span aria-hidden="true">&rsaquo;</span>
            </a>
        </div>

        <!-- Launch Perks Tag Bar -->
        <div class="flex flex-wrap justify-center items-center gap-3 mt-8 z-10 text-xs text-slate-300 font-medium">
            <span class="px-3 py-1 rounded-full bg-white/5 border border-white/15 backdrop-blur-sm">
                <b class="text-white">100% Percuma</b> &bull; Tiada Bayaran Lesen Per Pengguna
            </span>
            <span class="px-3 py-1 rounded-full bg-white/5 border border-white/15 backdrop-blur-sm">
                <b class="text-white">Self-Hosted</b> &bull; Privasi Data 100% Hak Milik Anda (PDPA)
            </span>
            <span class="px-3 py-1 rounded-full bg-white/5 border border-white/15 backdrop-blur-sm">
                <b class="text-white">Multi-AI</b> &bull; Sokongan Ollama Tempatan &amp; Google Gemini
            </span>
            <span class="px-3 py-1 rounded-full bg-white/5 border border-white/15 backdrop-blur-sm">
                <b class="text-white">Patuh Malaysia</b> &bull; KWSP, PERKESO, EIS &amp; MyInvois LHDN
            </span>
        </div>

        <!-- ==============================================
             PIXEL OFFICE KERJAAI (ANIMATED RETRO HQ)
             ============================================== -->
        <div class="w-full max-w-5xl mt-12 mb-2 z-10 px-2 sm:px-4">
            <div class="rounded-3xl border border-white/15 bg-slate-950/85 backdrop-blur-xl overflow-hidden shadow-2xl shadow-indigo-950/70 transition hover:border-indigo-500/40">
                <!-- Console Top Header Bar -->
                <div class="px-4 py-3 bg-slate-900/90 border-b border-white/10 flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2.5">
                        <span class="live-dot"></span>
                        <span class="font-extrabold text-white tracking-wide uppercase text-[11px] flex items-center gap-1.5">
                            <span>🏢</span> KerjaAI Live Pixel HQ &bull; @if (config('services.office_hub.embed_url'))Pejabat AI Masa Nyata @else Simulasi Pejabat Beroperasi @endif
                        </span>
                    </div>
                    @unless (config('services.office_hub.embed_url'))
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] text-slate-400 hidden sm:inline">Pekerja pahlawan sibuk bertugas:</span>
                        <div class="flex items-center gap-1.5">
                            <button type="button" id="btn-coffee-break" class="px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-slate-200 text-[10px] font-bold transition flex items-center gap-1 active:scale-95">
                                ☕ Rehat Kopi
                            </button>
                            <button type="button" id="btn-rush-mode" class="px-2.5 py-1 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-[10px] font-bold transition flex items-center gap-1 shadow-sm active:scale-95">
                                ⚡ Waktu Sibuk
                            </button>
                            <button type="button" id="btn-tuah-assist" class="px-2.5 py-1 rounded-lg bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/40 text-[10px] font-bold transition flex items-center gap-1 active:scale-95">
                                ✨ Panggil Tuah AI
                            </button>
                        </div>
                    </div>
                    @endunless
                </div>

                @if (config('services.office_hub.embed_url'))
                <!-- Bangunan live dari EA AI Office Hub (data masa nyata) -->
                <div class="relative bg-slate-950 overflow-hidden" style="aspect-ratio: 1440 / 860;">
                    <iframe src="{{ config('services.office_hub.embed_url') }}" title="KerjaAI Live Office"
                            class="absolute inset-0 w-full h-full border-0" loading="lazy"
                            referrerpolicy="no-referrer" allow="fullscreen"></iframe>
                </div>
                @else
                <!-- Canvas Wrapper -->
                <div class="relative bg-slate-950 flex items-center justify-center p-1 sm:p-2 overflow-hidden select-none cursor-pointer group">
                    <canvas id="pixel-office-canvas" width="860" height="340" class="w-full h-auto max-w-full rounded-2xl block" style="image-rendering: pixelated; image-rendering: crisp-edges;"></canvas>
                    
                    <!-- Overlay hint for interactive touch/click -->
                    <div class="absolute bottom-3 right-4 px-2.5 py-1 rounded-md bg-black/60 backdrop-blur-md border border-white/10 text-[10px] text-slate-400 pointer-events-none hidden sm:flex items-center gap-1.5">
                        <span>💡 Klik mana-mana pekerja untuk lihat tugas semasa</span>
                    </div>
                </div>
                @endif

                <!-- Status Ticker Bar Bawah -->
                <div class="px-4 py-2.5 bg-slate-900/70 border-t border-white/5 flex flex-wrap items-center justify-between text-[11px] text-slate-400 gap-2">
                    <div class="flex items-center gap-2 font-mono">
                        <span class="text-indigo-400 font-bold">STATUS OPERASI:</span>
                        <span id="pixel-office-status" class="text-slate-200">Semua pahlawan bertugas aktif di pelayan tempatan anda.</span>
                    </div>
                    <div class="flex items-center gap-3 text-[10px] text-slate-500">
                        @if (config('services.office_hub.embed_url'))<span>🔴 Data langsung dari AI Office Hub</span>@else<span>⚡ 60 FPS Engine</span>@endif
                        <span>&bull;</span>
                        <span>0% Beban Server Luar</span>
                        <span>&bull;</span>
                        <span class="text-emerald-400 font-semibold">100% Data Selamat</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==============================================
         4. JUBIN STATISTIK KEKUATAN SISTEM
         ============================================== -->
    <div class="bg-white border-y border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-xs uppercase tracking-widest font-bold text-slate-600">Ekosistem Pahlawan</p>
                    <p class="text-4xl font-extrabold text-slate-900 mt-2">5 Modul</p>
                    <p class="text-xs text-slate-700 mt-1">Bersepadu Dalam Satu Pangkalan Data</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-widest font-bold text-slate-600">Pemilikan Penuh</p>
                    <p class="text-4xl font-extrabold text-indigo-600 mt-2">100%</p>
                    <p class="text-xs text-slate-700 mt-1">Kod Sumber Terbuka &amp; Tiada Kunci Vendor</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-widest font-bold text-slate-600">Kos Lesen Per Staf</p>
                    <p class="text-4xl font-extrabold text-emerald-600 mt-2">RM 0</p>
                    <p class="text-xs text-slate-700 mt-1">Jimat Ribuan Ringgit Setiap Bulan</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-widest font-bold text-slate-600">Kepatuhan Tempatan</p>
                    <p class="text-4xl font-extrabold text-slate-900 mt-2">Malaysia</p>
                    <p class="text-xs text-slate-700 mt-1">Patuh Akta Buruh &amp; e-Invois LHDN</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ==============================================
         5. MODUL UTAMA: TUAH AI & JEBAT (FEATURED SHOWCASE)
         ============================================== -->
    <div class="ap-stack" id="ekosistem">
        <!-- Hero Modul 1: Magic Ads & Pemasaran Pintar (Jebat) -->
        <section class="ap-tile ap-tile--full bg-slate-50 border-slate-200">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full">
                    Pemasaran &amp; Pengiklanan Pintar
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900 mt-3">
                    Jebat &bull; Magic Ads Autopilot
                </h2>
                <p class="text-base sm:text-xl text-slate-600 mt-3">
                    Iklan yang melancarkan diri mereka sendiri. Memantau pulangan kos iklan (ROAS) dan menghentikan pembaziran secara automatik.
                </p>
            </div>

            <!-- Visual Interaktif Mockup Telefon & Dashboard Analitis -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center max-w-5xl mx-auto w-full">
                <!-- Phone Mockup -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="phone-frame w-72 h-[480px] flex flex-col bg-slate-900 text-white">
                        <div class="p-3 border-b border-slate-800 flex items-center justify-between text-xs">
                            <span class="font-bold flex items-center gap-1.5 text-indigo-400">
                                <span>⚡</span> Jebat Ads
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                Sedang Bersiaran
                            </span>
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between bg-gradient-to-b from-slate-900 to-slate-950">
                            <div class="rounded-2xl overflow-hidden bg-slate-800 border border-slate-700 p-3">
                                <div class="h-36 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-amber-500 flex items-center justify-center text-white text-center p-3 font-bold text-sm">
                                    Promosi Akhir Tahun &bull; Jimat 40% Hari Ini!
                                </div>
                                <div class="mt-3 flex items-center justify-between text-xs">
                                    <span class="font-semibold text-slate-300">Kempen Digital Jebat</span>
                                    <span class="px-2 py-0.5 rounded bg-blue-600 text-white text-[10px] font-bold">Ketahui Lanjut</span>
                                </div>
                            </div>
                            <div class="p-3 rounded-xl bg-slate-800/80 border border-slate-700/60 text-xs space-y-1.5">
                                <div class="flex justify-between text-slate-400 text-[11px]">
                                    <span>Klik Unik:</span>
                                    <span class="font-bold text-white">1,420</span>
                                </div>
                                <div class="flex justify-between text-slate-400 text-[11px]">
                                    <span>Kos / Prospek (CPL):</span>
                                    <span class="font-bold text-emerald-400">RM 3.20</span>
                                </div>
                                <div class="flex justify-between text-slate-400 text-[11px]">
                                    <span>Status AI:</span>
                                    <span class="font-bold text-indigo-400">Dioptimumkan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live AI Log Panel -->
                <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-600">Tuah AI Autopilot Log</span>
                            <h4 class="text-lg font-bold text-slate-900 mt-0.5">Pantau Prestasi Kempen Masa Nyata</h4>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                            <span class="live-dot"></span> Autopilot Aktif
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 my-5">
                        <div class="p-3.5 sm:p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between sm:block">
                            <div>
                                <span class="text-[11px] sm:text-[10px] font-bold uppercase tracking-wider text-slate-600 block">Jumlah Prospek</span>
                                <span class="text-xs font-semibold text-emerald-600 block sm:hidden mt-0.5">+24% minggu ini</span>
                            </div>
                            <div class="text-right sm:text-left">
                                <p class="text-2xl sm:text-xl font-black text-slate-900 sm:mt-1">324</p>
                                <span class="text-[10px] font-semibold text-emerald-600 hidden sm:block">+24% minggu ini</span>
                            </div>
                        </div>
                        <div class="p-3.5 sm:p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between sm:block">
                            <div>
                                <span class="text-[11px] sm:text-[10px] font-bold uppercase tracking-wider text-slate-600 block">Purata Kos</span>
                                <span class="text-xs font-semibold text-emerald-600 block sm:hidden mt-0.5">Jimat 35%</span>
                            </div>
                            <div class="text-right sm:text-left">
                                <p class="text-2xl sm:text-xl font-black text-slate-900 sm:mt-1">RM 2.85</p>
                                <span class="text-[10px] font-semibold text-emerald-600 hidden sm:block">Jimat 35%</span>
                            </div>
                        </div>
                        <div class="p-3.5 sm:p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between sm:block">
                            <div>
                                <span class="text-[11px] sm:text-[10px] font-bold uppercase tracking-wider text-slate-600 block">Kadar Tutup</span>
                                <span class="text-xs font-semibold text-indigo-600 block sm:hidden mt-0.5">Tinggi</span>
                            </div>
                            <div class="text-right sm:text-left">
                                <p class="text-2xl sm:text-xl font-black text-slate-900 sm:mt-1">18.4%</p>
                                <span class="text-[10px] font-semibold text-indigo-600 hidden sm:block">Tinggi</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 font-mono text-xs text-slate-600 bg-slate-900 text-slate-300 p-4 rounded-2xl">
                        <div class="flex items-center justify-between text-indigo-400 border-b border-slate-800 pb-2">
                            <span>[09:15 AM] AI mengesan saluran B berprestasi 4x ganda</span>
                            <span class="text-[10px] text-slate-500">Auto-Rebalance</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                            <span>[10:30 AM] Salinan iklan #3 digantikan dengan sudut tawaran baru</span>
                            <span class="text-[10px] text-slate-500">Magic Copy</span>
                        </div>
                        <div class="flex items-center justify-between text-emerald-400">
                            <span>[11:00 AM] 12 prospek baru dihantar automatik ke Kasturi CRM</span>
                            <span class="text-[10px] text-slate-500">Pipeline Sync</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==============================================
             6. BENTO GRID: MODUL-MODUL OPERASI UTAMA
             ============================================== -->
        <div class="ap-grid">
            <!-- Bento 1: Kasturi (CRM, Jualan & Katalog Produk) -->
            <section class="ap-tile">
                <div class="flex items-center justify-between mb-4">
                    <span class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xl">
                        🤝
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Kasturi &bull; Jualan &amp; Katalog Produk
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">Saluran Urus Niaga &amp; Katalog Produk</h3>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                    Urus prospek dari klik pertama iklan sehingga menjadi pelanggan setia. Corong visual Kanban, direktori pelanggan, dan katalog inventori produk dengan pintasan jana iklan terus ke Jebat.
                </p>

                <!-- Mockup Corong Urus Niaga & Produk -->
                <div class="mt-6 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                    <div class="flex items-center justify-between text-xs pb-2 border-b border-slate-100">
                        <span class="font-bold text-slate-800">Urus Niaga: Retail Maju Jaya</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700">Rundingan</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-600">Nilai Urus Niaga</span>
                            <p class="text-base font-extrabold text-slate-900">RM 14,800.00</p>
                        </div>
                        <div class="flex gap-1.5">
                            <span class="w-3.5 h-1.5 rounded-full bg-blue-600"></span>
                            <span class="w-3.5 h-1.5 rounded-full bg-blue-600"></span>
                            <span class="w-3.5 h-1.5 rounded-full bg-blue-600"></span>
                            <span class="w-3.5 h-1.5 rounded-full bg-slate-200"></span>
                        </div>
                    </div>
                    <!-- Katalog Produk Snippet -->
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-900 block">Minyak Wangi Kasturi 50ml</span>
                            <span class="text-[10px] text-slate-500">SKU-WNG-50 &bull; Stok: 80 unit</span>
                        </div>
                        <span class="font-extrabold text-emerald-600 text-xs">RM 120.00</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Pintasan: 1-Klik hantar produk ke Jebat Ad Studio atau tukar deal ke invois Lekir.</p>
                </div>
            </section>

            <!-- Bento 2: Lekiu (Modal Insan, Gaji Tempatan & Pengambilan Staf) -->
            <section class="ap-tile">
                <div class="flex items-center justify-between mb-4">
                    <span class="w-10 h-10 rounded-2xl bg-cyan-100 text-cyan-700 flex items-center justify-center font-bold text-xl">
                        👥
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-cyan-50 text-cyan-700 border border-cyan-200">
                        Lekiu &bull; Modal Insan &amp; Pengambilan
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">Slip Gaji Statutori &amp; Pengambilan Staf</h3>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                    Patuhi akta buruh Malaysia tanpa pening kepala. Kehadiran GPS, kelulusan cuti, pengiraan caruman KWSP, PERKESO, EIS, PCB serta portal pengambilan bakat (Hire / ATS).
                </p>

                <!-- Mockup Slip Gaji & Calon Resume -->
                <div class="mt-6 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2.5">
                    <div class="flex items-center justify-between text-xs pb-2 border-b border-slate-100">
                        <span class="font-bold text-slate-800">Penggajian: Aina Farhana</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Telah Disahkan</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-xs">
                        <div class="p-2 rounded-xl bg-slate-50 text-center">
                            <span class="text-[9px] uppercase font-bold text-slate-600 block">Gaji Pokok</span>
                            <p class="font-bold text-slate-900 text-xs mt-0.5">RM 4,500</p>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-50 text-center">
                            <span class="text-[9px] uppercase font-bold text-slate-600 block">KWSP+SOCSO</span>
                            <p class="font-bold text-rose-600 text-xs mt-0.5">-RM 585</p>
                        </div>
                        <div class="p-2 rounded-xl bg-emerald-50 border border-emerald-200/60 text-center">
                            <span class="text-[9px] uppercase font-bold text-emerald-800 block">Bersih</span>
                            <p class="font-extrabold text-emerald-700 text-xs mt-0.5">RM 3,915</p>
                        </div>
                    </div>
                    <!-- ATS Calon Snippet -->
                    <div class="p-2.5 rounded-xl bg-purple-50/70 border border-purple-100 text-xs flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-900 block">Calon: Syamil (Senior Dev)</span>
                            <span class="text-[10px] text-slate-500">Iklan: Eksekutif Pemasaran &bull; Padanan AI 94%</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700">Temu Duga</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Integrasi: Hantar iklan jawatan ke Jebat Studio &amp; kos gaji dieksport ke Lejar Lekir.</p>
                </div>
            </section>

            <!-- Bento 3: Lekir (Kewangan, e-Invois LHDN & Perakaunan) -->
            <section class="ap-tile">
                <div class="flex items-center justify-between mb-4">
                    <span class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xl">
                        ⚖️
                    </span>
                    <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                        Lekir &bull; Kewangan &amp; e-Invois LHDN
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">Invois, Lejar Berimbang &amp; Cukai SST</h3>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                    Menyandang amanah kewangan perbendaharaan: sebut harga ke invois jualan, kira cukai SST (6%/8%), persediaan portal MyInvois LHDN, lejar Debit = Kredit dan simpan resit Shoebox.
                </p>

                <!-- Mockup Invois & Lejar Ready -->
                <div class="mt-6 p-4 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2.5">
                    <div class="flex items-center justify-between text-xs pb-2 border-b border-slate-100">
                        <span class="font-bold text-slate-800">Invois #INV-2026-081</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">Patuh MyInvois</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-600">Jumlah Bersih</span>
                            <p class="text-base font-extrabold text-slate-900">RM 8,450.00</p>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] uppercase font-bold text-slate-600">Cukai SST (6%)</span>
                            <p class="text-sm font-bold text-slate-700">RM 507.00</p>
                        </div>
                    </div>
                    <!-- Lejar Snippet -->
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs flex items-center justify-between font-mono">
                        <span class="text-slate-600 text-[10px]">Lejar Am:</span>
                        <span class="text-emerald-600 font-bold text-[10px]">Debit RM8,957 = Kredit RM8,957 ✓</span>
                    </div>
                    <p class="text-[11px] text-slate-500">Cetak PDF segera atau kongsi pautan rasmi terus ke WhatsApp / Emel pelanggan.</p>
                </div>
            </section>
        </div>

        <!-- ==============================================
             7. SATU SISTEM SATU MEMORI: INFOGRAFIK TERAS AI (TUAH)
             ============================================== -->
        <section class="ap-tile ap-tile--full ap-tile--dark my-4" id="arkitektur">
            <div class="text-center max-w-3xl mx-auto mb-8">
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-400 bg-indigo-950/80 border border-indigo-800 px-3 py-1 rounded-full">
                    Arkitektur Bersepadu
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white mt-4">
                    Satu Sistem. Satu Memori Bersama.
                </h2>
                <p class="text-base sm:text-lg text-slate-300 mt-3">
                    Tambah pelanggan sekali di Jebat &amp; Kasturi — mereka terus wujud di Lekir Kewangan. Lantik staf di Lekiu — rekod mereka terus bersedia untuk gaji. Semua dibaca oleh Tuah AI.
                </p>
            </div>

            <!-- Modul Cards Array -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-4xl mx-auto w-full mb-8">
                <div class="p-4 rounded-2xl bg-slate-900/90 border border-slate-800 text-center">
                    <span class="text-2xl">📢</span>
                    <h5 class="text-sm font-bold text-white mt-1">Jebat</h5>
                    <p class="text-[11px] text-slate-400">Pemasaran &amp; Studio Iklan</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/90 border border-slate-800 text-center">
                    <span class="text-2xl">🤝</span>
                    <h5 class="text-sm font-bold text-white mt-1">Kasturi</h5>
                    <p class="text-[11px] text-slate-400">Jualan &amp; Katalog Produk</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/90 border border-slate-800 text-center">
                    <span class="text-2xl">👥</span>
                    <h5 class="text-sm font-bold text-white mt-1">Lekiu</h5>
                    <p class="text-[11px] text-slate-400">Modal Insan &amp; Pengambilan</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/90 border border-slate-800 text-center">
                    <span class="text-2xl">⚖️</span>
                    <h5 class="text-sm font-bold text-white mt-1">Lekir</h5>
                    <p class="text-[11px] text-slate-400">Kewangan &amp; e-Invois</p>
                </div>
            </div>

            <!-- Flow Connecting Lines (SVG Animation) -->
            <div class="max-w-4xl mx-auto w-full hidden md:block">
                <svg viewBox="0 0 1000 80" class="w-full h-12" aria-hidden="true">
                    <path class="ap-os-flow" d="M100,0 L100,40 L500,40 L500,80" />
                    <path class="ap-os-flow" d="M300,0 L300,40 L500,40 L500,80" />
                    <path class="ap-os-flow" d="M500,0 L500,80" />
                    <path class="ap-os-flow" d="M700,0 L700,40 L500,40 L500,80" />
                    <path class="ap-os-flow" d="M900,0 L900,40 L500,40 L500,80" />
                    <circle cx="500" cy="40" r="5" fill="#3b82f6" />
                </svg>
            </div>

            <!-- Central Tuah AI Core -->
            <div class="max-w-3xl mx-auto w-full p-8 rounded-3xl bg-gradient-to-tr from-slate-950 via-slate-900 to-indigo-950 border border-indigo-500/30 text-center shadow-2xl relative overflow-hidden mt-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-blue-500 flex items-center justify-center text-white text-3xl font-black mx-auto mb-4 shadow-lg shadow-indigo-500/30">
                    🧠
                </div>
                <h4 class="text-2xl font-black text-white">Teras Tuah AI &bull; C-Suite Co-Pilot</h4>
                <p class="text-sm text-slate-300 max-w-xl mx-auto mt-2 leading-relaxed">
                    Ejen pintar yang menyaring kesemua rekod syarikat anda. Tanya apa sahaja tentang baki tunai, prestasi staf atau kempen jualan melalui teks mahupun suara.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-6 text-xs text-left">
                    <div class="p-3 rounded-xl bg-slate-900/80 border border-slate-800">
                        <span class="font-bold text-white block">Sokongan Model Terbuka</span>
                        <span class="text-slate-400 mt-0.5 block">Pasang Ollama tempatan tanpa sebarang bayaran token.</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-900/80 border border-slate-800">
                        <span class="font-bold text-white block">Privasi Penuh Pelayan</span>
                        <span class="text-slate-400 mt-0.5 block">Data kewangan dan staf tidak dikongsi dengan pihak ketiga.</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-900/80 border border-slate-800">
                        <span class="font-bold text-white block">Audit &amp; Sumber Sah</span>
                        <span class="text-slate-400 mt-0.5 block">Setiap jawapan AI memaparkan rujukan dokumen asal.</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==============================================
             8. KELEBIHAN SUMBER TERBUKA (PERBANDINGAN JADUAL)
             ============================================== -->
        <section class="ap-tile ap-tile--full bg-slate-50 border-slate-200 py-16" id="opensource">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                    Nilai Untuk Perniagaan Anda
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-slate-900 mt-3">
                    Mengapa Pilih Open Source?
                </h2>
                <p class="text-base sm:text-xl text-slate-600 mt-3">
                    Perbandingan jujur antara KerjaAI dengan platform perisian proprietari langganan tertutup.
                </p>
            </div>

            <div class="max-w-4xl mx-auto w-full overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="bg-slate-100 text-xs font-bold uppercase text-slate-600 border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6">Perkara</th>
                            <th class="py-4 px-6 text-indigo-700 font-extrabold bg-indigo-50/70 border-x border-indigo-100">
                                KerjaAI (Self-Hosted)
                            </th>
                            <th class="py-4 px-6 text-slate-500">SaaS Tertutup Lain</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-4 px-6 font-bold text-slate-900">Kos Lesen Bulanan</td>
                            <td class="py-4 px-6 font-extrabold text-emerald-600 bg-indigo-50/30 border-x border-indigo-100">
                                RM 0 (Percuma Sepenuhnya)
                            </td>
                            <td class="py-4 px-6 text-slate-500">RM 200 - RM 1,500+ setiap bulan bertambah ikut staf</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 font-bold text-slate-900">Hak Milik Data Pelanggan</td>
                            <td class="py-4 px-6 font-bold text-slate-900 bg-indigo-50/30 border-x border-indigo-100">
                                100% Milik Anda di PostgreSQL Sendiri
                            </td>
                            <td class="py-4 px-6 text-slate-500">Tersimpan di pelayan pihak ketiga (Vendor Lock-in)</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 font-bold text-slate-900">Enjin Kecerdasan AI</td>
                            <td class="py-4 px-6 font-bold text-slate-900 bg-indigo-50/30 border-x border-indigo-100">
                                Bebas: Guna Ollama tempatan atau bawa API sendiri
                            </td>
                            <td class="py-4 px-6 text-slate-500">Caj kredit token berharga mahal dengan margin tinggi</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 font-bold text-slate-900">Fleksibiliti Penyesuaian Kod</td>
                            <td class="py-4 px-6 font-bold text-slate-900 bg-indigo-50/30 border-x border-indigo-100">
                                Kod Terbuka Laravel 13 &bull; Ubah suai tanpa had
                            </td>
                            <td class="py-4 px-6 text-slate-500">Mustahil diubahsuai, terikat kepada ciri pembangun sahaja</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 font-bold text-slate-900">Kepatuhan Tempatan Malaysia</td>
                            <td class="py-4 px-6 font-bold text-slate-900 bg-indigo-50/30 border-x border-indigo-100">
                                KWSP, SOCSO, EIS, PCB &amp; MyInvois LHDN Terbina
                            </td>
                            <td class="py-4 px-6 text-slate-500">Perisian luar negara sering tidak patuh undang-undang tempatan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- ==============================================
         9. SOALAN LAZIM (FAQ INTERAKTIF)
         ============================================== -->
    <section class="py-20 bg-white" id="faq" x-data="{ openFaq: null }">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 border border-indigo-200 px-3 py-1 rounded-full">
                    Jawapan Terus
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 mt-3">
                    Soalan Lazim Berkenaan KerjaAI
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-2">
                    Segala yang perlu anda ketahui tentang pelaksanaan, privasi dan kelebihan platform kami.
                </p>
            </div>

            <div class="divide-y divide-slate-200 border-y border-slate-200">
                @foreach($faqs as $idx => $faq)
                <div class="py-5">
                    <button type="button" @click="openFaq = (openFaq === {{ $idx }} ? null : {{ $idx }})" class="w-full flex items-center justify-between text-left font-bold text-base sm:text-lg text-slate-900 hover:text-indigo-600 transition focus:outline-none">
                        <span>{{ $faq['q'] }}</span>
                        <span class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-sm font-black transition-transform" :class="openFaq === {{ $idx }} ? 'rotate-45 bg-indigo-100 text-indigo-600' : ''">
                            +
                        </span>
                    </button>
                    <div x-show="openFaq === {{ $idx }}" x-collapse class="mt-3 text-slate-600 text-sm leading-relaxed pr-8">
                        {{ $faq['a'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==============================================
         10. CALL-TO-ACTION TERAKHIR & FOOTER GELAP
         ============================================== -->
    <section class="bg-black text-white py-20 border-t border-slate-900 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
            <img src="{{ asset('images/banner.png') }}" alt="KerjaAI — Sistem Berasaskan AI" class="h-16 sm:h-24 w-auto max-w-[680px] sm:max-w-lg mx-auto mb-8 object-contain">
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-3xl mx-auto leading-tight">
                Miliki Platform Perniagaan Anda Sendiri Hari Ini.
            </h2>
            <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto mt-4 leading-relaxed">
                Tiada lagi data yang tersangkut dalam pelayan pihak ketiga. Pasang KerjaAI dan kendalikan perniagaan anda dengan kebebasan sumber terbuka sepenuhnya.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4 mt-8">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-8 py-3.5 rounded-full bg-white text-slate-950 font-bold text-base hover:bg-slate-100 transition shadow-xl hover:scale-105 transform">
                        Masuk ke Dashboard Sistem &rarr;
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-3.5 rounded-full bg-white text-slate-950 font-bold text-base hover:bg-slate-100 transition shadow-xl hover:scale-105 transform">
                        Daftar Perniagaan &amp; Mula Percuma &rarr;
                    </a>
                    <a href="{{ route('login') }}" class="px-7 py-3.5 rounded-full bg-slate-900 border border-slate-700 text-white font-semibold text-base hover:bg-slate-800 transition">
                        Log Masuk Pengguna
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- FOOTER NAVIGASI -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-12 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-5 gap-8">
            <div class="col-span-2">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg overflow-hidden flex items-center justify-center bg-white/10 p-0.5">
                        <img src="{{ asset('images/logo.png') }}" alt="KerjaAI Logo" class="w-full h-full object-cover rounded-md">
                    </div>
                    <span class="font-extrabold text-base text-white">Kerja<span class="text-indigo-400">AI</span></span>
                </div>
                <p class="text-slate-500 mt-3 text-xs leading-relaxed max-w-sm">
                    Platform Perniagaan AI Sumber Terbuka Pertama Malaysia berasaskan Laravel 13 &amp; PostgreSQL. Dicipta khas untuk usahawan yang mementingkan privasi data, kepatuhan tempatan dan kawalan penuh.
                </p>
                <p class="text-slate-600 mt-4 text-[11px]">
                    &copy; {{ date('Y') }} KerjaAI Community. Hak cipta terpelihara.
                </p>
            </div>

            <div>
                <h5 class="text-xs font-bold text-white uppercase tracking-wider mb-3">5 Bersaudara</h5>
                <ul class="space-y-2">
                    <li><a href="#ekosistem" class="hover:text-white transition">Tuah (Pusat Kawalan C-Suite)</a></li>
                    <li><a href="#ekosistem" class="hover:text-white transition">Jebat (Pemasaran &amp; Studio Iklan)</a></li>
                    <li><a href="#ekosistem" class="hover:text-white transition">Kasturi (Jualan &amp; Katalog Produk)</a></li>
                    <li><a href="#ekosistem" class="hover:text-white transition">Lekiu (Modal Insan &amp; Pengambilan)</a></li>
                    <li><a href="#ekosistem" class="hover:text-white transition">Lekir (Kewangan &amp; e-Invois LHDN)</a></li>
                </ul>
            </div>

            <div>
                <h5 class="text-xs font-bold text-white uppercase tracking-wider mb-3">Pematuhan Tempatan</h5>
                <ul class="space-y-2">
                    <li><a href="#ekosistem" class="hover:text-white transition">e-Invois MyInvois LHDN</a></li>
                    <li><a href="#ekosistem" class="hover:text-white transition">Cukai Perkhidmatan SST (6% &amp; 8%)</a></li>
                    <li><a href="#ekosistem" class="hover:text-white transition">Caruman KWSP (12%/13% &amp; 11%)</a></li>
                    <li><a href="#ekosistem" class="hover:text-white transition">PERKESO, EIS &amp; PCB LHDN</a></li>
                </ul>
            </div>

            <div>
                <h5 class="text-xs font-bold text-white uppercase tracking-wider mb-3">Akses &amp; Sumber</h5>
                <ul class="space-y-2">
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Buka Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Log Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Daftar Akaun Baru</a></li>
                    @endauth
                    <li><a href="#opensource" class="hover:text-white transition">Kelebihan Open Source</a></li>
                    <li><a href="#faq" class="hover:text-white transition">Soalan Lazim</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- ==============================================
         PIXEL OFFICE CANVAS ENGINE SCRIPT
         ============================================== -->
    <script>
    (function () {
        const canvas = document.getElementById('pixel-office-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        const W = canvas.width;  // 860
        const H = canvas.height; // 340

        let time = 0;
        let isRush = false;
        let rushTimer = 0;

        const statusEl = document.getElementById('pixel-office-status');
        const btnCoffee = document.getElementById('btn-coffee-break');
        const btnRush = document.getElementById('btn-rush-mode');
        const btnTuah = document.getElementById('btn-tuah-assist');

        function setStatus(text) {
            if (statusEl) statusEl.textContent = text;
        }

        // Bintang di luar tingkap
        const stars = [];
        for (let i = 0; i < 24; i++) {
            stars.push({
                x: 235 + Math.random() * 380,
                y: 18 + Math.random() * 76,
                size: Math.random() > 0.6 ? 2 : 1,
                speed: 0.04 + Math.random() * 0.08,
                phase: Math.random() * Math.PI * 2
            });
        }

        // Zarah Asap Kopi
        const steams = [];
        for (let i = 0; i < 8; i++) {
            steams.push({
                x: 785 + Math.random() * 8,
                y: 95 + Math.random() * 25,
                alpha: Math.random(),
                speedY: 0.35 + Math.random() * 0.4,
                wobble: Math.random() * Math.PI * 2
            });
        }

        // Zarah Kilauan Sparkles
        const sparkles = [];
        function addSparkle(x, y, color) {
            sparkles.push({
                x: x,
                y: y,
                vx: (Math.random() - 0.5) * 2.5,
                vy: (Math.random() - 0.5) * 2.5 - 1,
                life: 30 + Math.random() * 20,
                maxLife: 50,
                color: color || '#38bdf8',
                size: 2 + Math.random() * 2
            });
        }

        // Senarai Pekerja Pahlawan
        const workers = [
            {
                id: 'jebat',
                name: 'Jebat',
                role: 'Pemasaran & Studio Iklan',
                color: '#2563eb', // Blue
                hair: '#0f172a',
                deskX: 110,
                deskY: 195,
                x: 110,
                y: 195,
                targetX: 110,
                targetY: 195,
                state: 'typing', // typing, walking, coffee, whiteboard, server, happy
                timer: 180,
                speed: 1.3,
                dir: 1,
                walkFrame: 0,
                item: null,
                bubble: 'Jana salinan di Ad Studio! ✨',
                bubbleTimer: 140,
                bubbles: [
                    'Jana salinan di Ad Studio! ✨',
                    'Magic Ads ROAS 4.6x! 🎯',
                    'Kempen Meta & TikTok dioptimumkan',
                    'Iklan produk & kerjaya sedia'
                ]
            },
            {
                id: 'kasturi',
                name: 'Kasturi',
                role: 'Jualan & Katalog Produk',
                color: '#059669', // Emerald
                hair: '#451a03',
                deskX: 250,
                deskY: 195,
                x: 250,
                y: 195,
                targetX: 250,
                targetY: 195,
                state: 'typing',
                timer: 240,
                speed: 1.2,
                dir: 1,
                walkFrame: 0,
                item: null,
                bubble: null,
                bubbleTimer: 0,
                bubbles: [
                    'Katalog produk dikemas kini 📦',
                    'Closing urus niaga RM24k 🤝',
                    'Pintasan jana iklan ke Jebat 📢',
                    'Urus niaga won tukar ke invois'
                ]
            },
            {
                id: 'lekiu',
                name: 'Lekiu',
                role: 'Modal Insan & Pengambilan',
                color: '#0891b2', // Cyan
                hair: '#312e81',
                deskX: 520,
                deskY: 195,
                x: 520,
                y: 195,
                targetX: 520,
                targetY: 195,
                state: 'typing',
                timer: 210,
                speed: 1.15,
                dir: -1,
                walkFrame: 0,
                item: null,
                bubble: null,
                bubbleTimer: 0,
                bubbles: [
                    'Slip gaji KWSP/PERKESO siap ✓',
                    'Iklan jawatan kosong disiarkan 💼',
                    'Semak jam masuk GPS staf 📍',
                    'Tapisan resume calon Lekiu Hire'
                ]
            },
            {
                id: 'lekir',
                name: 'Lekir',
                role: 'Kewangan & e-Invois LHDN',
                color: '#d97706', // Amber
                hair: '#475569',
                deskX: 660,
                deskY: 195,
                x: 660,
                y: 195,
                targetX: 660,
                targetY: 195,
                state: 'typing',
                timer: 300,
                speed: 1.1,
                dir: -1,
                walkFrame: 0,
                item: null,
                bubble: null,
                bubbleTimer: 0,
                bubbles: [
                    'e-Invois LHDN disahkan! 🧾',
                    'Lejar am berimbang: Debit = Kredit ⚖️',
                    'Sebut harga ditukar ke invois',
                    'Penyata SST & resit siap diproses'
                ]
            }
        ];

        // Tuah AI Dron Bot
        const tuahBot = {
            x: 430,
            y: 130,
            targetX: 430,
            targetY: 130,
            timer: 180,
            speed: 1.6,
            bubble: 'Tuah AI: 5 Bersaudara bersepadu 100% ⚡',
            bubbleTimer: 180
        };

        // Sasaran Navigasi Pejabat
        const spots = {
            coffee: { x: 770, y: 190, name: 'Pantri Kopi' },
            whiteboard: { x: 125, y: 160, name: 'Papan Putih Strategi' },
            server: { x: 675, y: 160, name: 'Rak Pelayan Tuah AI' }
        };

        // Interaksi Tetikus
        let hoveredWorker = null;

        canvas.addEventListener('mousemove', function (e) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = W / rect.width;
            const scaleY = H / rect.height;
            const mx = (e.clientX - rect.left) * scaleX;
            const my = (e.clientY - rect.top) * scaleY;

            hoveredWorker = null;
            for (let w of workers) {
                const dist = Math.hypot(w.x - mx, w.y - my);
                if (dist < 32) {
                    hoveredWorker = w;
                    break;
                }
            }
            if (!hoveredWorker) {
                const botDist = Math.hypot(tuahBot.x - mx, tuahBot.y - my);
                if (botDist < 30) hoveredWorker = { name: 'Tuah AI', role: 'Pusat Kawalan & Co-Pilot C-Suite', bubble: 'Tanya saya sebarang analisis perniagaan 5 Bersaudara!' };
            }
        });

        canvas.addEventListener('click', function (e) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = W / rect.width;
            const scaleY = H / rect.height;
            const mx = (e.clientX - rect.left) * scaleX;
            const my = (e.clientY - rect.top) * scaleY;

            // Cari watak terdekat
            let found = null;
            let minDist = 45;
            for (let w of workers) {
                const dist = Math.hypot(w.x - mx, w.y - my);
                if (dist < minDist) {
                    minDist = dist;
                    found = w;
                }
            }

            if (found) {
                found.state = 'happy';
                found.timer = 90;
                found.bubble = 'Hai! ' + found.name + ' (' + found.role + ') sedia berkhidmat!';
                found.bubbleTimer = 160;
                for (let k = 0; k < 12; k++) addSparkle(found.x, found.y - 15, found.color);
                setStatus('✨ ' + found.name + ' (' + found.role + '): ' + found.bubble);
                return;
            }

            // Semak klik pada Tuah AI Bot
            const botDist = Math.hypot(tuahBot.x - mx, tuahBot.y - my);
            if (botDist < 40) {
                tuahBot.bubble = 'Tuah AI: Memproses telemetri sistem 5 Bersaudara ⚡';
                tuahBot.bubbleTimer = 160;
                for (let k = 0; k < 16; k++) addSparkle(tuahBot.x, tuahBot.y, '#38bdf8');
                setStatus('🧠 Tuah AI Co-Pilot: Pusat arahan pintar 5 Bersaudara sedia menjawab soalan pengurusan.');
            }
        });

        // Butang Tindakan Console
        if (btnCoffee) {
            btnCoffee.addEventListener('click', function () {
                setStatus('☕ Waktu rehat kopi! Semua pahlawan menuju ke pantri.');
                workers.forEach((w, idx) => {
                    w.state = 'walking';
                    w.targetX = spots.coffee.x - idx * 22;
                    w.targetY = spots.coffee.y + (idx % 2 === 0 ? 10 : -10);
                    w.item = 'coffee';
                    w.bubble = 'Kopi time! ☕';
                    w.bubbleTimer = 130;
                });
            });
        }

        if (btnRush) {
            btnRush.addEventListener('click', function () {
                isRush = !isRush;
                rushTimer = isRush ? 360 : 0;
                if (isRush) {
                    setStatus('⚡ Waktu sibuk diaktifkan! Kelajuan operasi dan pertukaran fail digandakan.');
                    workers.forEach(w => {
                        w.state = 'walking';
                        w.targetX = 100 + Math.random() * 650;
                        w.targetY = 160 + Math.random() * 110;
                        w.bubble = 'Banyak closing hari ini! 🚀';
                        w.bubbleTimer = 120;
                    });
                } else {
                    setStatus('Semua pahlawan kembali beroperasi pada kadar biasa.');
                    workers.forEach(w => {
                        w.state = 'walking';
                        w.targetX = w.deskX;
                        w.targetY = w.deskY;
                    });
                }
            });
        }

        if (btnTuah) {
            btnTuah.addEventListener('click', function () {
                setStatus('✨ Tuah AI mengimbas seluruh data perniagaan 5 Bersaudara (Jebat, Kasturi, Lekiu, Lekir).');
                tuahBot.targetX = 430;
                tuahBot.targetY = 110;
                tuahBot.bubble = 'Tuah AI: 5 Bersaudara bersepadu 100% ⚡';
                tuahBot.bubbleTimer = 180;
                for (let i = 0; i < 30; i++) {
                    addSparkle(tuahBot.x + (Math.random() - 0.5) * 60, tuahBot.y + (Math.random() - 0.5) * 40, '#f59e0b');
                }
                workers.forEach(w => {
                    w.state = 'happy';
                    w.timer = 80;
                });
            });
        }

        // ==========================================
        // FUNGSI LUKISAN PEJABAT PIKSEL
        // ==========================================

        function drawBackground() {
            // Dinding latar
            const wallGrad = ctx.createLinearGradient(0, 0, 0, 130);
            wallGrad.addColorStop(0, '#060a12');
            wallGrad.addColorStop(1, '#111827');
            ctx.fillStyle = wallGrad;
            ctx.fillRect(0, 0, W, 130);

            // Tingkap Pejabat Lebar
            ctx.fillStyle = '#020617';
            ctx.fillRect(230, 15, 385, 80);

            // Bintang berkelip di luar tingkap
            stars.forEach(s => {
                const alpha = 0.35 + 0.65 * Math.sin(time * s.speed + s.phase);
                ctx.fillStyle = 'rgba(224, 242, 254, ' + Math.max(0, alpha) + ')';
                ctx.fillRect(s.x, s.y, s.size, s.size);
            });

            // Siluet Bandar Kuala Lumpur (KLCC & KL Tower)
            ctx.fillStyle = '#0f172a';
            // Menara Berkembar KLCC
            ctx.fillRect(390, 32, 14, 63);
            ctx.fillRect(414, 32, 14, 63);
            ctx.fillRect(397, 24, 2, 8); // Puncak tiang kiri
            ctx.fillRect(421, 24, 2, 8); // Puncak tiang kanan
            ctx.fillRect(404, 52, 10, 4);  // Skybridge
            // Menara KL
            ctx.fillRect(460, 40, 6, 55);
            ctx.fillRect(455, 48, 16, 8); // Pod tinjau
            ctx.fillRect(462, 28, 2, 12); // Tiang antena
            // Lampu merah puncak Menara KL
            const beaconAlpha = 0.3 + 0.7 * Math.sin(time * 0.1);
            ctx.fillStyle = 'rgba(239, 68, 68, ' + beaconAlpha + ')';
            ctx.fillRect(462, 26, 2, 2);

            // Bingkai Tingkap Grid Retro
            ctx.strokeStyle = '#334155';
            ctx.lineWidth = 3;
            ctx.strokeRect(230, 15, 385, 80);
            ctx.beginPath();
            ctx.moveTo(358, 15); ctx.lineTo(358, 95);
            ctx.moveTo(486, 15); ctx.lineTo(486, 95);
            ctx.moveTo(230, 55); ctx.lineTo(615, 55);
            ctx.stroke();

            // Papan Putih (Whiteboard)
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(50, 25, 145, 75);
            ctx.strokeStyle = '#94a3b8';
            ctx.lineWidth = 3;
            ctx.strokeRect(50, 25, 145, 75);

            // Tulisan & Graf Papan Putih
            ctx.fillStyle = '#0f172a';
            ctx.font = 'bold 9px monospace';
            ctx.fillText('TARGET Q4 🚀', 60, 40);

            // Graf Garisan Hijau
            ctx.strokeStyle = '#10b981';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(60, 85);
            ctx.lineTo(85, 75);
            ctx.lineTo(110, 80);
            ctx.lineTo(135, 60);
            ctx.lineTo(165, 50);
            ctx.stroke();

            // Sticky Notes pada Papan Putih
            ctx.fillStyle = '#fde047'; ctx.fillRect(145, 72, 10, 10);
            ctx.fillStyle = '#f43f5e'; ctx.fillRect(160, 72, 10, 10);
            ctx.fillStyle = '#38bdf8'; ctx.fillRect(175, 72, 10, 10);

            // Rak Pelayan Tuah AI (Server Rack)
            ctx.fillStyle = '#090d16';
            ctx.fillRect(645, 20, 85, 95);
            ctx.strokeStyle = '#334155';
            ctx.lineWidth = 2;
            ctx.strokeRect(645, 20, 85, 95);

            // Rack Units & LED Lights
            for (let r = 0; r < 4; r++) {
                const ry = 28 + r * 20;
                ctx.fillStyle = '#1e293b';
                ctx.fillRect(650, ry, 75, 16);
                ctx.strokeStyle = '#475569';
                ctx.lineWidth = 1;
                ctx.strokeRect(650, ry, 75, 16);

                // LED lights
                const ledGreen = (Math.sin(time * 0.15 + r) > 0);
                const ledBlue = (Math.sin(time * 0.2 + r * 2) > -0.2);
                ctx.fillStyle = ledGreen ? '#22c55e' : '#14532d';
                ctx.fillRect(655, ry + 6, 3, 3);
                ctx.fillStyle = ledBlue ? '#38bdf8' : '#0369a1';
                ctx.fillRect(662, ry + 6, 3, 3);
                ctx.fillStyle = '#f59e0b';
                ctx.fillRect(669, ry + 6, 3, 3);

                // Grid ventilasi server
                ctx.fillStyle = '#0f172a';
                ctx.fillRect(685, ry + 5, 34, 5);
            }
            ctx.fillStyle = '#38bdf8';
            ctx.font = 'bold 7px monospace';
            ctx.fillText('TUAH CORE', 662, 110);

            // Sudut Pantri Kopi (Coffee Station)
            ctx.fillStyle = '#1e293b';
            ctx.fillRect(755, 60, 85, 55);
            ctx.strokeStyle = '#334155';
            ctx.lineWidth = 2;
            ctx.strokeRect(755, 60, 85, 55);

            // Mesin Kopi Espresso Merah
            ctx.fillStyle = '#dc2626';
            ctx.fillRect(762, 38, 26, 22);
            ctx.fillStyle = '#991b1b';
            ctx.fillRect(764, 40, 8, 8); // Skrin
            ctx.fillStyle = '#22c55e';
            ctx.fillRect(776, 42, 3, 3);  // LED ready

            // Dispenser Air Mineral
            ctx.fillStyle = '#0284c7';
            ctx.fillRect(800, 32, 16, 16); // Tong air biru
            ctx.fillStyle = '#f8fafc';
            ctx.fillRect(802, 48, 12, 12); // Pili air

            // Zarah Asap Wap Kopi
            steams.forEach(st => {
                st.y -= st.speedY;
                st.x += Math.sin(time * 0.05 + st.wobble) * 0.25;
                if (st.y < 20) {
                    st.y = 55;
                    st.x = 770 + Math.random() * 8;
                }
                ctx.fillStyle = 'rgba(255, 255, 255, 0.4)';
                ctx.fillRect(st.x, st.y, 2, 2);
            });

            // Papan Tanda Neon HQ di dinding
            ctx.fillStyle = '#0f172a';
            ctx.fillRect(380, 5, 100, 16);
            ctx.strokeStyle = '#38bdf8';
            ctx.lineWidth = 1;
            ctx.strokeRect(380, 5, 100, 16);
            ctx.fillStyle = '#67e8f9';
            ctx.font = 'bold 8px monospace';
            ctx.fillText('⚡ KERJAAI HQ', 390, 16);

            // Skirting Dinding Kayu
            ctx.fillStyle = '#334155';
            ctx.fillRect(0, 125, W, 12);

            // Lantai Pejabat Berjubin Isometrik Moden
            const floorTop = 137;
            const tileH = 20;
            const tileW = 32;

            for (let y = floorTop; y < H; y += tileH) {
                const row = Math.floor((y - floorTop) / tileH);
                for (let x = 0; x < W; x += tileW) {
                    const col = Math.floor(x / tileW);
                    const isDark = (row + col) % 2 === 0;
                    ctx.fillStyle = isDark ? '#0b0f19' : '#111827';
                    ctx.fillRect(x, y, tileW, tileH);
                    ctx.strokeStyle = '#1e293b';
                    ctx.lineWidth = 0.5;
                    ctx.strokeRect(x, y, tileW, tileH);
                }
            }
        }

        // Lukis Meja Kerja Pejabat
        function drawDesk(x, y, label, screenColor) {
            // Bayang meja di lantai
            ctx.fillStyle = 'rgba(0, 0, 0, 0.35)';
            ctx.fillRect(x - 22, y + 16, 84, 14);

            // Kaki meja
            ctx.fillStyle = '#0f172a';
            ctx.fillRect(x - 18, y + 6, 4, 18);
            ctx.fillRect(x + 54, y + 6, 4, 18);

            // Permukaan Meja
            ctx.fillStyle = '#1e293b';
            ctx.fillRect(x - 20, y - 2, 80, 10);
            ctx.fillStyle = '#334155';
            ctx.fillRect(x - 20, y - 4, 80, 3); // Bevel kayu

            // Monitor Komputer
            ctx.fillStyle = '#0f172a';
            ctx.fillRect(x + 6, y - 24, 28, 20); // Bingkai monitor
            ctx.fillStyle = screenColor || '#38bdf8';
            ctx.fillRect(x + 8, y - 22, 24, 16); // Skrin nyala
            // Garisan data pada skrin
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(x + 10, y - 18, 12, 1.5);
            ctx.fillRect(x + 10, y - 14, 18, 1.5);
            ctx.fillRect(x + 10, y - 10, 14, 1.5);
            // Kaki monitor
            ctx.fillStyle = '#475569';
            ctx.fillRect(x + 18, y - 4, 4, 3);
            ctx.fillRect(x + 14, y - 1, 12, 2);

            // Keyboard & Mouse
            ctx.fillStyle = '#94a3b8';
            ctx.fillRect(x + 10, y + 1, 16, 3);
            ctx.fillStyle = '#cbd5e1';
            ctx.fillRect(x + 30, y + 2, 3, 2);

            // Mug Kopi di atas meja
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(x - 10, y - 1, 6, 5);
            ctx.fillStyle = '#d97706';
            ctx.fillRect(x - 9, y - 1, 4, 1);

            // Label Nama Stesen di hadapan meja
            ctx.fillStyle = '#0f172a';
            ctx.fillRect(x - 8, y + 8, 56, 10);
            ctx.strokeStyle = '#334155';
            ctx.lineWidth = 1;
            ctx.strokeRect(x - 8, y + 8, 56, 10);
            ctx.fillStyle = '#94a3b8';
            ctx.font = 'bold 7px monospace';
            ctx.textAlign = 'center';
            ctx.fillText(label, x + 20, y + 16);
            ctx.textAlign = 'left';
        }

        // Lukis Karakter Pekerja Piksel
        function drawWorker(w) {
            ctx.save();
            const px = Math.round(w.x);
            const py = Math.round(w.y);

            // Bayang watak
            ctx.fillStyle = 'rgba(0, 0, 0, 0.4)';
            ctx.beginPath();
            ctx.ellipse(px, py + 14, 9, 4, 0, 0, Math.PI * 2);
            ctx.fill();

            // Offset melompat (happy jump)
            let jumpY = 0;
            if (w.state === 'happy') {
                jumpY = -Math.abs(Math.sin(time * 0.2)) * 8;
            }

            const by = py + jumpY;

            // Kaki & Kasut
            if (w.state === 'typing') {
                // Duduk di kerusi
                ctx.fillStyle = '#0f172a';
                ctx.fillRect(px - 5, by + 4, 10, 8);
            } else {
                // Berjalan / Berdiri
                const walkCycle = Math.floor(w.walkFrame) % 4;
                ctx.fillStyle = w.pants;

                if (walkCycle === 0) {
                    ctx.fillRect(px - 4, by + 4, 3, 8);
                    ctx.fillRect(px + 1, by + 4, 3, 8);
                } else if (walkCycle === 1) {
                    ctx.fillRect(px - 5, by + 4, 3, 6);
                    ctx.fillRect(px + 2, by + 4, 3, 9);
                } else if (walkCycle === 2) {
                    ctx.fillRect(px - 3, by + 4, 3, 8);
                    ctx.fillRect(px, by + 4, 3, 8);
                } else {
                    ctx.fillRect(px - 2, by + 4, 3, 9);
                    ctx.fillRect(px - 5, by + 4, 3, 6);
                }

                // Kasut putih
                ctx.fillStyle = '#f8fafc';
                ctx.fillRect(px - 4, by + 12, 3, 2);
                ctx.fillRect(px + 1, by + 12, 3, 2);
            }

            // Badan & Baju
            ctx.fillStyle = w.color;
            ctx.fillRect(px - 5, by - 6, 10, 11);

            // Kolar Baju
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(px - 2, by - 6, 4, 2);

            // Tangan
            ctx.fillStyle = w.color;
            if (w.state === 'typing') {
                // Tangan di atas meja menaip
                const typingOffset = Math.sin(time * 0.4) > 0 ? 1 : -1;
                ctx.fillRect(px + 4 * w.dir, by - 2 + typingOffset, 3, 3);
            } else if (w.state === 'happy') {
                // Tangan terangkat ke atas gembira
                ctx.fillRect(px - 7, by - 12, 3, 7);
                ctx.fillRect(px + 4, by - 12, 3, 7);
            } else {
                // Tangan berayun
                ctx.fillRect(px - 6 * w.dir, by - 4, 3, 7);
                if (w.item === 'coffee') {
                    // Pegang cawan kopi
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(px + 5 * w.dir, by - 3, 4, 4);
                }
            }

            // Kepala & Wajah
            ctx.fillStyle = '#fed7aa'; // Kulit cerah
            ctx.fillRect(px - 4, by - 16, 8, 9);

            // Mata piksel
            const blink = Math.sin(time * 0.05 + w.x) > 0.95;
            if (!blink) {
                ctx.fillStyle = '#0f172a';
                ctx.fillRect(px - 2 + (w.dir === 1 ? 1 : 0), by - 13, 2, 2);
                ctx.fillRect(px + 2 + (w.dir === 1 ? 1 : 0), by - 13, 2, 2);
            }

            // Rambut
            ctx.fillStyle = w.hair;
            ctx.fillRect(px - 5, by - 19, 10, 5);
            ctx.fillRect(px - (w.dir === 1 ? 5 : -3), by - 17, 3, 7);

            // Highlight hover
            if (hoveredWorker && hoveredWorker.id === w.id) {
                ctx.strokeStyle = '#f59e0b';
                ctx.lineWidth = 1.5;
                ctx.strokeRect(px - 7, by - 21, 14, 36);
            }

            ctx.restore();

            // Lukis Gelembung Sembang (Speech Bubble)
            if (w.bubble && w.bubbleTimer > 0) {
                drawBubble(px, by - 24, w.bubble);
            }
        }

        // Lukis Tuah AI Dron Bot
        function drawTuahBot(b) {
            ctx.save();
            const bx = Math.round(b.x);
            const floatY = Math.sin(time * 0.08) * 5;
            const by = Math.round(b.y + floatY);

            // Bayang bawah
            ctx.fillStyle = 'rgba(56, 189, 248, 0.15)';
            ctx.beginPath();
            ctx.ellipse(bx, 190, 14, 5, 0, 0, Math.PI * 2);
            ctx.fill();

            // Thruster jet particles
            if (Math.random() > 0.4) {
                addSparkle(bx - 6 + Math.random() * 12, by + 12, '#38bdf8');
            }

            // Badan Bot
            ctx.fillStyle = '#f8fafc';
            ctx.beginPath();
            ctx.arc(bx, by, 11, 0, Math.PI * 2);
            ctx.fill();
            ctx.strokeStyle = '#38bdf8';
            ctx.lineWidth = 2;
            ctx.stroke();

            // Visor Skrin LED
            ctx.fillStyle = '#0f172a';
            ctx.fillRect(bx - 7, by - 4, 14, 7);

            // Mata Biru Neon Senyum
            ctx.fillStyle = '#38bdf8';
            ctx.fillRect(bx - 5, by - 2, 3, 2);
            ctx.fillRect(bx + 2, by - 2, 3, 2);

            // Antena Atas dengan Mentol Berkelip
            ctx.fillStyle = '#94a3b8';
            ctx.fillRect(bx - 1, by - 16, 2, 6);
            const bulbPulsing = 0.5 + 0.5 * Math.sin(time * 0.15);
            ctx.fillStyle = 'rgba(245, 158, 11, ' + bulbPulsing + ')';
            ctx.beginPath();
            ctx.arc(bx, by - 17, 3, 0, Math.PI * 2);
            ctx.fill();

            // Sayap Mini di Kiri Kanan
            ctx.fillStyle = '#60a5fa';
            ctx.fillRect(bx - 14, by - 1, 4, 3);
            ctx.fillRect(bx + 10, by - 1, 4, 3);

            ctx.restore();

            if (b.bubble && b.bubbleTimer > 0) {
                drawBubble(bx, by - 24, b.bubble);
            }
        }

        // Gelembung Dialog Piksel (Speech Bubble)
        function drawBubble(x, y, text) {
            ctx.save();
            ctx.font = 'bold 9px sans-serif';
            const metrics = ctx.measureText(text);
            const padX = 8;
            const padY = 5;
            const bw = metrics.width + padX * 2;
            const bh = 18;

            let bx = x - bw / 2;
            let by = y - bh;

            // Pastikan gelembung tidak terkeluar dari sempadan kanvas
            if (bx < 10) bx = 10;
            if (bx + bw > W - 10) bx = W - 10 - bw;
            if (by < 10) by = 10;

            // Kotak Putih dengan Bucu Bulat
            ctx.fillStyle = '#ffffff';
            ctx.beginPath();
            ctx.roundRect(bx, by, bw, bh, 6);
            ctx.fill();

            // Sempadan
            ctx.strokeStyle = '#0f172a';
            ctx.lineWidth = 1.2;
            ctx.stroke();

            // Ekor gelembung
            ctx.fillStyle = '#ffffff';
            ctx.beginPath();
            ctx.moveTo(x - 3, by + bh);
            ctx.lineTo(x + 3, by + bh);
            ctx.lineTo(x, by + bh + 4);
            ctx.closePath();
            ctx.fill();
            ctx.stroke();

            // Teks dialog
            ctx.fillStyle = '#0f172a';
            ctx.fillText(text, bx + padX, by + 12);

            ctx.restore();
        }

        // ==========================================
        // KEMAS KINI AI LOGIK PERGERAKAN PEKERJA
        // ==========================================

        function updateWorkers() {
            time++;

            // Tangani Waktu Sibuk (Rush mode timer)
            if (isRush && rushTimer > 0) {
                rushTimer--;
                if (rushTimer <= 0) {
                    isRush = false;
                    setStatus('Waktu sibuk berakhir. Pekerja kembali ke stesen masing-masing.');
                }
            }

            // Kemas kini zarah kilauan
            for (let i = sparkles.length - 1; i >= 0; i--) {
                const sp = sparkles[i];
                sp.x += sp.vx;
                sp.y += sp.vy;
                sp.life--;
                if (sp.life <= 0) sparkles.splice(i, 1);
            }

            // Kemas kini setiap pekerja
            workers.forEach(w => {
                if (w.bubbleTimer > 0) w.bubbleTimer--;
                else w.bubble = null;

                const curSpeed = isRush ? w.speed * 1.8 : w.speed;

                if (w.state === 'typing') {
                    w.timer--;
                    if (w.timer <= 0) {
                        // Pilih aktiviti seterusnya secara rawak
                        const r = Math.random();
                        if (r < 0.35) {
                            // Pergi ke pantri kopi
                            w.state = 'walking';
                            w.targetX = spots.coffee.x;
                            w.targetY = spots.coffee.y;
                            w.item = 'coffee';
                            w.bubble = 'Pergi bancuh kopi sekejap ☕';
                            w.bubbleTimer = 90;
                        } else if (r < 0.65) {
                            // Pergi ke papan putih / server
                            const target = (Math.random() > 0.5) ? spots.whiteboard : spots.server;
                            w.state = 'walking';
                            w.targetX = target.x;
                            w.targetY = target.y;
                            w.item = 'file';
                            w.bubble = 'Semak ' + target.name + '...';
                            w.bubbleTimer = 90;
                        } else {
                            // Berbual atau cetus dialog baru di meja
                            w.bubble = w.bubbles[Math.floor(Math.random() * w.bubbles.length)];
                            w.bubbleTimer = 140;
                            w.timer = 200 + Math.floor(Math.random() * 200);
                        }
                    }
                } else if (w.state === 'walking') {
                    const dx = w.targetX - w.x;
                    const dy = w.targetY - w.y;
                    const dist = Math.hypot(dx, dy);

                    if (dist > 3) {
                        w.dir = dx >= 0 ? 1 : -1;
                        w.x += (dx / dist) * curSpeed;
                        w.y += (dy / dist) * curSpeed;
                        w.walkFrame += 0.25;
                    } else {
                        // Sampai ke destinasi
                        w.walkFrame = 0;
                        if (w.targetX === w.deskX && w.targetY === w.deskY) {
                            // Kembali ke meja
                            w.state = 'typing';
                            w.timer = 220 + Math.floor(Math.random() * 180);
                            w.item = null;
                        } else {
                            // Sedang berada di destinasi luar meja
                            w.timer = 120;
                            w.state = 'idle_at_dest';
                            w.bubble = w.bubbles[Math.floor(Math.random() * w.bubbles.length)];
                            w.bubbleTimer = 120;
                        }
                    }
                } else if (w.state === 'idle_at_dest') {
                    w.timer--;
                    if (w.timer <= 0) {
                        // Balik ke meja sendiri
                        w.state = 'walking';
                        w.targetX = w.deskX;
                        w.targetY = w.deskY;
                    }
                } else if (w.state === 'happy') {
                    w.timer--;
                    if (w.timer <= 0) {
                        w.state = 'typing';
                        w.timer = 180;
                    }
                }
            });

            // Kemas kini Tuah AI Bot
            if (tuahBot.bubbleTimer > 0) tuahBot.bubbleTimer--;
            else tuahBot.bubble = null;

            tuahBot.timer--;
            if (tuahBot.timer <= 0) {
                // Pilih meja pekerja untuk dilawati
                const randomWorker = workers[Math.floor(Math.random() * workers.length)];
                tuahBot.targetX = randomWorker.x + (Math.random() > 0.5 ? 25 : -25);
                tuahBot.targetY = randomWorker.y - 45;
                tuahBot.timer = 260 + Math.floor(Math.random() * 200);

                const botPhrases = [
                    'Tuah AI: Membantu ' + randomWorker.name + ' menyemak metrik',
                    'Tuah AI: Log audit integriti disahkan ✓',
                    'Tuah AI: Model Ollama memproses data setempat',
                    'Tuah AI: Taklimat CEO harian dikemas kini'
                ];
                tuahBot.bubble = botPhrases[Math.floor(Math.random() * botPhrases.length)];
                tuahBot.bubbleTimer = 160;
            }

            const bdx = tuahBot.targetX - tuahBot.x;
            const bdy = tuahBot.targetY - tuahBot.y;
            const bdist = Math.hypot(bdx, bdy);
            if (bdist > 2) {
                tuahBot.x += (bdx / bdist) * tuahBot.speed;
                tuahBot.y += (bdy / bdist) * tuahBot.speed;
            }
        }

        // ==========================================
        // GELUNG UTAMA ANIMASI KANVAS (60 FPS)
        // ==========================================

        function render() {
            ctx.clearRect(0, 0, W, H);

            // 1. Dinding, tingkap, papan putih, server & lantai
            drawBackground();

            // 2. Meja-meja stesen kerja
            drawDesk(110, 195, 'JEBAT', '#2563eb');
            drawDesk(250, 195, 'KASTURI', '#059669');
            drawDesk(520, 195, 'LEKIU', '#0891b2');
            drawDesk(660, 195, 'LEKIR', '#d97706');

            // 3. Susun watak mengikut kedalaman Y (Depth Sorting)
            const sortedWorkers = [...workers].sort((a, b) => a.y - b.y);
            sortedWorkers.forEach(w => drawWorker(w));

            // 4. Tuah AI Dron Bot
            drawTuahBot(tuahBot);

            // 5. Zarah Sparkles
            sparkles.forEach(sp => {
                ctx.fillStyle = sp.color;
                ctx.fillRect(sp.x, sp.y, sp.size, sp.size);
            });

            // 6. Kemas kini logik pergerakan
            updateWorkers();

            requestAnimationFrame(render);
        }

        // Mulakan gelung render
        requestAnimationFrame(render);
    })();
    </script>
</body>
</html>
