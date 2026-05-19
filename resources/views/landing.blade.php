<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DA-CARE | Department of Agriculture</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/damimaropa-logo.jpg') }}">
    <meta name="description"
        content="DA-CARE — Complaints, Accountability, & Resolution for Everyone. The Department of Agriculture's official complaints platform." />

    {{-- Tailwind CDN (swap for Vite build in production) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'da-green': '#1f6b3a',
                        'da-green-dark': '#16532c',
                        'da-gold': '#d4a437',
                        'da-cream': '#fdf6e3',
                        'da-soft-green': '#e8f3ec',
                        'da-soft-blue': '#e8eef7',
                        'da-soft-amber': '#fbf2dc',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>

    {{-- Lucide icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            color: #1f2937;
            -webkit-font-smoothing: antialiased;
            background: #ffffff;
        }

        /* ===== Keyframe animations ===== */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        @keyframes pulseRing {
            0% {
                box-shadow: 0 0 0 0 rgba(31, 107, 58, .45);
            }

            70% {
                box-shadow: 0 0 0 18px rgba(31, 107, 58, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(31, 107, 58, 0);
            }
        }

        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(20px, -30px) scale(1.08);
            }

            66% {
                transform: translate(-25px, 15px) scale(.95);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes ticker {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* ===== Reveal on scroll ===== */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .8s ease, transform .8s cubic-bezier(.22, 1, .36, 1);
            will-change: opacity, transform;
        }

        .reveal.in {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: .08s;
        }

        .reveal-delay-2 {
            transition-delay: .16s;
        }

        .reveal-delay-3 {
            transition-delay: .24s;
        }

        .reveal-delay-4 {
            transition-delay: .32s;
        }

        /* ===== Hero ===== */
        .hero {
            position: relative;
            overflow: hidden;
            background: linear-gradient(120deg, #f1f9f3 0%, #fdf6e3 50%, #eef5f0 100%);
            background-size: 200% 200%;
            animation: gradientShift 18s ease infinite;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: .55;
            pointer-events: none;
            animation: blob 14s ease-in-out infinite;
        }

        .blob.b1 {
            width: 380px;
            height: 380px;
            background: #bfe3c9;
            top: -120px;
            left: -100px;
        }

        .blob.b2 {
            width: 320px;
            height: 320px;
            background: #f7e2a3;
            bottom: -120px;
            right: -80px;
            animation-delay: -6s;
        }

        .blob.b3 {
            width: 220px;
            height: 220px;
            background: #cfe6d6;
            top: 40%;
            right: 20%;
            animation-delay: -3s;
            opacity: .35;
        }

        .hero-headline {
            animation: fadeUp .9s cubic-bezier(.22, 1, .36, 1) both;
        }

        .hero-sub {
            animation: fadeUp .9s .15s cubic-bezier(.22, 1, .36, 1) both;
        }

        .hero-cta {
            animation: fadeUp .9s .3s cubic-bezier(.22, 1, .36, 1) both;
        }

        .hero-img-wrap {
            animation: float 7s ease-in-out infinite;
        }

        .gradient-text {
            background: linear-gradient(90deg, #1f6b3a, #2f9d5a, #d4a437);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: shimmer 6s linear infinite;
        }

        /* ===== Buttons ===== */
        .btn-primary {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--da-green), #2f9d5a);
            color: #fff;
            transition: transform .25s ease, box-shadow .25s ease;
            box-shadow: 0 10px 25px -10px rgba(31, 107, 58, .55);
        }

        .btn-primary::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(255, 255, 255, .35) 50%, transparent 70%);
            transform: translateX(-120%);
            transition: transform .7s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 35px -12px rgba(31, 107, 58, .6);
        }

        .btn-primary:hover::after {
            transform: translateX(120%);
        }

        /* ===== Floating value props ===== */
        .value-card {
            transition: transform .35s ease, box-shadow .35s ease;
        }

        .value-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 40px -18px rgba(0, 0, 0, .18);
        }

        /* ===== Quick action cards ===== */
        .qa-card {
            position: relative;
            overflow: hidden;
            transition: transform .4s cubic-bezier(.22, 1, .36, 1), box-shadow .4s ease;
        }

        .qa-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(31, 107, 58, .08), transparent 60%);
            opacity: 0;
            transition: opacity .4s ease;
        }

        .qa-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 45px -18px rgba(0, 0, 0, .18);
        }

        .qa-card:hover::before {
            opacity: 1;
        }

        .qa-card:hover .qa-icon {
            transform: rotate(-6deg) scale(1.08);
        }

        .qa-icon {
            transition: transform .4s ease;
        }

        .qa-arrow {
            transition: transform .3s ease;
        }

        .qa-card:hover .qa-arrow {
            transform: translateX(6px);
        }

        /* ===== Step circle ===== */
        .step-num {
            background: linear-gradient(135deg, var(--da-green), #2f9d5a);
            color: #fff;
            box-shadow: 0 8px 20px -8px rgba(31, 107, 58, .55);
            animation: pulseRing 2.6s ease-out infinite;
        }

        /* ===== 8888 banner ===== */
        .banner-8888 {
            background: linear-gradient(120deg, #16532c 0%, #1f6b3a 50%, #2f9d5a 100%);
            background-size: 200% 200%;
            animation: gradientShift 12s ease infinite;
            position: relative;
            overflow: hidden;
        }

        .banner-8888::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 30%, rgba(255, 255, 255, .12), transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(212, 164, 55, .18), transparent 45%);
            pointer-events: none;
        }

        .megaphone {
            animation: float 4s ease-in-out infinite;
        }

        /* ===== Marquee / trust ticker ===== */
        .ticker {
            display: flex;
            width: max-content;
            animation: ticker 30s linear infinite;
        }

        .ticker:hover {
            animation-play-state: paused;
        }

        /* ===== Card lift ===== */
        .lift {
            transition: transform .35s ease, box-shadow .35s ease;
        }

        .lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px -18px rgba(0, 0, 0, .2);
        }

        /* ===== Underline link ===== */
        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -6px;
            height: 2px;
            background: var(--da-green);
            transform: scaleX(0);
            transform-origin: right center;
            transition: transform .35s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            transform: scaleX(1);
            transform-origin: left center;
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>

<body class="bg-white">

    {{-- ========== HEADER / NAV ========== --}}
    <header class="sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-da-green to-emerald-600 flex items-center justify-center text-white font-extrabold shadow-md group-hover:scale-105 transition">
                        DA
                    </div>
                    <div>
                        <p class="text-da-green font-extrabold tracking-wide leading-none">DA-CARE</p>
                        <p class="text-[11px] text-gray-500 leading-tight">Complaints, Accountability, & Resolution for
                            Everyone</p>
                    </div>
                </a>

                <nav class="hidden lg:flex items-center gap-8 text-sm text-gray-700 font-medium">
                    @php
                        $links = [
                            ['Home', '/'],
                            ['Submit a Complaint', '/newcomplaint'],
                            ['Track My Complaint', '/trackrecord'],
                            ['About DA-CARE', '/about'],
                        ];
                    @endphp
                    @foreach ($links as [$label, $href])
                        @php $active = request()->is(trim($href, '/') ?: '/'); @endphp
                        <a href="{{ url($href) }}"
                            class="nav-link hover:text-da-green transition {{ $active ? 'text-da-green font-semibold active' : '' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="hidden sm:inline-flex bg-emerald-700 hover:bg-emerald-800 text-white items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-sm">
                            <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Go to Dashboard
                        </a>
                    @endauth

                    @guest
                        <a href="{{ url('/login') }}"
                            class="hidden sm:inline-flex bg-emerald-700 hover:bg-emerald-800 text-white items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-sm">
                            <i data-lucide="log-in" class="w-4 h-4"></i> Login
                        </a>
                    @endguest

                    <button @click="open = !open"
                        class="lg:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors focus:outline-none">
                        <svg x-show="!open" class="w-6 h-6 text-emerald-700 dark:text-emerald-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        <svg x-show="open" x-cloak class="w-6 h-6 text-emerald-700 dark:text-emerald-500"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobileMenu" class="hidden lg:hidden pb-4 space-y-1">
                @foreach ($links as [$label, $href])
                    <a href="{{ url($href) }}"
                        class="block px-3 py-2 rounded-md text-gray-700 hover:bg-da-soft-green hover:text-da-green">{{ $label }}</a>
                @endforeach
                <a href="{{ url('/login') }}"
                    class="block px-3 py-2 rounded-md text-white bg-da-green text-center mt-2">Login</a>
            </div>
        </div>
    </header>

    {{-- ========== HERO ========== --}}
    <section class="hero">
        <div class="blob b1"></div>
        <div class="blob b2"></div>
        <div class="blob b3"></div>

        <div
            class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span
                    class="hero-sub inline-flex items-center gap-2 bg-white/70 backdrop-blur px-4 py-1.5 rounded-full text-xs font-semibold text-da-green border border-da-green/20 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-da-green animate-pulse"></span>
                    Official DA MIMAROPA Complaints Platform
                </span>

                <h1
                    class="hero-headline mt-5 text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight text-gray-900">
                    Your concern <span class="gradient-text">matters.</span><br>
                    We are here to <span class="text-da-green">listen</span> and act.
                </h1>

                <p class="hero-sub mt-6 text-lg text-gray-600 max-w-xl">
                    DA-CARE is the Department of Agriculture Mimaropa's official platform for complaints,
                    accountability, and fair resolution. Committed to transparency, efficiency,
                    and responsive public service.
                </p>

                <div class="hero-cta mt-8 flex flex-wrap gap-4">
                    <a href="{{ url('/newcomplaint') }}"
                        class="btn-primary inline-flex items-center gap-2 px-7 py-4 rounded-full font-semibold text-sm tracking-wide">
                        <i data-lucide="file-pen" class="w-4 h-4"></i> SUBMIT A COMPLAINT
                    </a>
                    <a href="{{ url('/trackrecord') }}"
                        class="inline-flex items-center gap-2 px-7 py-4 rounded-full font-semibold text-sm tracking-wide bg-white border border-gray-200 hover:border-da-green hover:text-da-green transition">
                        <i data-lucide="search" class="w-4 h-4"></i> TRACK MY COMPLAINT
                    </a>
                </div>

                <div class="hero-cta mt-8 flex items-center gap-6 text-sm text-gray-600">
                    <div class="flex items-center gap-2"><i data-lucide="shield-check"
                            class="w-4 h-4 text-da-green"></i> 100% Confidential</div>
                    <div class="flex items-center gap-2"><i data-lucide="zap" class="w-4 h-4 text-da-gold"></i> 72-Hour
                        Response</div>
                </div>
            </div>

            <div class="relative">
                <div
                    class="hero-img-wrap relative mx-auto w-full max-w-md aspect-square rounded-[2rem] bg-gradient-to-br from-da-soft-green via-white to-da-soft-amber shadow-2xl overflow-hidden border border-white">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i data-lucide="sprout" class="w-40 h-40 text-da-green/80"></i>
                    </div>
                    <div
                        class="absolute top-6 left-6 bg-white/80 backdrop-blur px-3 py-1.5 rounded-full text-xs font-semibold text-da-green shadow">
                        🌱 Serving Filipino Farmers
                    </div>
                </div>

                <div
                    class="absolute -bottom-6 -left-6 lg:-left-10 bg-white rounded-2xl shadow-xl p-5 w-64 reveal reveal-delay-2 value-card">
                    @foreach ([['shield-check', 'Confidential', 'Your identity is protected.'], ['clock', 'Timely', 'Action within 72 hours.'], ['users', 'Accountable', 'Resolution & continuous improvement.']] as $i => $item)
                        @php [$icon, $title, $desc] = $item; @endphp
                        <div class="flex items-start gap-3 {{ $i > 0 ? 'mt-3 pt-3 border-t border-gray-100' : '' }}">
                            <div
                                class="w-9 h-9 rounded-lg bg-da-soft-green flex items-center justify-center text-da-green shrink-0">
                                <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $title }}</p>
                                <p class="text-xs text-gray-500">{{ $desc }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ========== TRUST TICKER ========== --}}
    <div class="bg-da-green text-white/90 overflow-hidden border-y border-white/10">
        <div class="ticker py-3 text-xs font-semibold tracking-[0.25em] uppercase">
            @for ($i = 0; $i < 2; $i++)
                <div class="flex items-center gap-10 px-6">
                    @foreach (['Confidential', 'Transparent', 'Accountable', 'Responsive', 'Citizen-First', '72-Hour Response', 'Fair Resolution'] as $w)
                        <span class="flex items-center gap-3"><i data-lucide="leaf"
                                class="w-3.5 h-3.5 text-da-gold"></i> {{ $w }}</span>
                    @endforeach
                </div>
            @endfor
        </div>
    </div>

    {{-- ========== QUICK ACTION CARDS ========== --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 reveal">
                <p class="text-xs font-bold tracking-[0.25em] text-da-green uppercase">Quick Actions</p>
                <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold text-gray-900">How can we help you today?</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @php
                    $cards = [
                        [
                            'file-pen',
                            'SUBMIT A COMPLAINT',
                            'File your complaint or feedback quickly and securely.',
                            'da-soft-green',
                            'da-green',
                            '/newcomplaint',
                        ],
                        [
                            'search',
                            'TRACK MY COMPLAINT',
                            'Monitor the status and updates of your submitted complaint.',
                            'da-soft-blue',
                            'blue-700',
                            '/trackrecord',
                        ],
                        [
                            'lightbulb',
                            'KNOWLEDGE BASE',
                            'Learn more about our processes, policies, and your rights.',
                            'da-soft-amber',
                            'amber-700',
                            '/about',
                        ],
                    ];
                @endphp
                @foreach ($cards as $i => $card)
                    @php [$icon, $title, $desc, $bg, $color, $href] = $card; @endphp
                    <a href="{{ url($href) }}"
                        class="qa-card reveal reveal-delay-{{ $i + 1 }} group bg-white border border-gray-100 rounded-2xl p-7 shadow-sm block">
                        <div
                            class="qa-icon w-14 h-14 rounded-xl bg-{{ $bg }} flex items-center justify-center mb-5 text-{{ $color }}">
                            <i data-lucide="{{ $icon }}" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 tracking-wide">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $desc }}</p>
                        <div class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-da-green">
                            Get Started <i data-lucide="arrow-right" class="qa-arrow w-4 h-4"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========== HOW IT WORKS + NEED HELP ========== --}}
    <section class="py-20 bg-gradient-to-b from-da-soft-green/40 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2">
                <div class="reveal">
                    <p class="text-xs font-bold tracking-[0.25em] text-da-green uppercase">Process</p>
                    <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold text-gray-900">How It Works</h2>
                    <p class="mt-3 text-gray-600 max-w-xl">A simple, transparent 3-step process to make sure your
                        concern is heard and resolved.</p>
                </div>

                <div class="mt-10 grid sm:grid-cols-3 gap-6">
                    @php
                        $steps = [
                            [
                                '1',
                                'file-pen',
                                'Submit',
                                'Fill out the complaint form with the details of your concern.',
                            ],
                            ['2', 'clipboard-list', 'Review', 'We review and evaluate your complaint.'],
                            ['3', 'check-circle-2', 'Resolve', 'We act and provide a resolution within 72 hours.'],
                        ];
                    @endphp
                    @foreach ($steps as $i => $step)
                        @php [$n, $icon, $title, $desc] = $step; @endphp
                        <div
                            class="reveal reveal-delay-{{ $i + 1 }} lift bg-white rounded-2xl p-6 border border-gray-100 shadow-sm relative">
                            <div
                                class="step-num w-12 h-12 rounded-full flex items-center justify-center text-lg font-extrabold mb-4">
                                {{ $n }}
                            </div>
                            <div class="flex items-center gap-2 text-da-green mb-1">
                                <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $title }}</h3>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <aside
                class="reveal reveal-delay-2 bg-gradient-to-br from-da-green to-da-green-dark text-white rounded-2xl p-8 shadow-xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full bg-da-gold/20 blur-2xl"></div>
                <div class="relative">
                    <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center mb-4">
                        <i data-lucide="life-buoy" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold">NEED HELP?</h3>
                    <p class="mt-2 text-white/85 text-sm">For concerns or assistance, you may contact us:</p>

                    <div class="mt-6 space-y-4 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center"><i
                                    data-lucide="phone" class="w-4 h-4"></i></div>
                            09477115706
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center"><i
                                    data-lucide="mail" class="w-4 h-4"></i></div>
                            <a href="mailto:ored@mimaropa.da.gov.ph"
                                class="hover:underline">ored@mimaropa.da.gov.ph</a>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-white/15 flex items-center justify-center"><i
                                    data-lucide="map-pin" class="w-4 h-4"></i></div>
                            3F ATI Building, Elliptical Rd, Diliman, QC | King's Building, Camilmil, Calapan City,
                            Oriental Mindoro
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    {{-- ========== ESCALATION / 8888 ========== --}}
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="banner-8888 rounded-3xl text-white p-10 lg:p-14 grid lg:grid-cols-2 gap-10 items-center reveal">
                <div class="relative flex items-start gap-5">
                    <div class="megaphone w-16 h-16 rounded-2xl bg-white/15 flex items-center justify-center shrink-0">
                        <i data-lucide="megaphone" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold tracking-[0.25em] text-da-gold uppercase">Escalation</p>
                        <h3 class="mt-2 text-2xl lg:text-3xl font-extrabold">Unresolved concern?</h3>
                        <p class="mt-3 text-white/85 max-w-md text-sm leading-relaxed">
                            If your concern is not resolved within 72 hours, you may elevate it through the
                            8888 Citizen's Complaint Hotline.
                        </p>
                    </div>
                </div>

                <div class="relative">
                    <div class="text-center mb-5">
                        <p class="text-6xl lg:text-7xl font-black tracking-tight gradient-text"
                            style="background: linear-gradient(90deg,#fff,#f7e2a3,#fff); -webkit-background-clip:text; background-clip:text;">
                            8888</p>
                        <p class="text-sm text-white/80 mt-1">Citizen's Complaint Hotline</p>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-center">
                        <a href="https://8888.gov.ph" target="_blank"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-white text-da-green font-semibold text-sm hover:scale-105 transition">
                            <i data-lucide="external-link" class="w-4 h-4"></i> 8888.gov.ph
                        </a>
                        <a href="tel:8888"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-white/15 hover:bg-white/25 font-semibold text-sm transition">
                            <i data-lucide="phone" class="w-4 h-4"></i> Dial 8888
                        </a>
                        <a href="sms:8888"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-white/15 hover:bg-white/25 font-semibold text-sm transition">
                            <i data-lucide="message-square" class="w-4 h-4"></i> SMS 8888
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== FOOTER ========== --}}
    <footer class="bg-gradient-to-br from-da-green-dark to-da-green text-white/90">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid lg:grid-cols-3 gap-10">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center font-extrabold">
                        <img src="{{ asset('logo/damimaropa-logo.jpg') }}" alt="">
                    </div>
                    <div>
                        <p class="font-extrabold text-white">Department of Agriculture MIMAROPA</p>
                        <p class="text-xs text-white/70">Republic of the Philippines</p>
                    </div>
                </div>
                <p class="text-sm">3F ATI Building, Elliptical Rd, Diliman, QC | King's Building, Camilmil, Calapan
                    City,
                    Oriental Mindoro1</p>
                <p class="text-sm">Philippines</p>
                <p class="text-sm mt-3"><i data-lucide="phone" class="w-4 h-4 inline mr-1"></i> 09477115706</p>
                <p class="text-sm"><i data-lucide="mail" class="w-4 h-4 inline mr-1"></i> ored@mimaropa.da.gov.phh
                </p>
            </div>

            <div>
                <p class="font-bold text-white mb-3 tracking-wide">Quick Links</p>
                <ul class="space-y-2 text-sm">
                    @foreach ($links as [$label, $href])
                        <li><a href="{{ url($href) }}"
                                class="hover:text-da-gold transition">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="font-bold text-white mb-3 tracking-wide">Connect</p>
                <div class="flex gap-3">
                    @foreach ([['facebook', 'https://facebook.com'], ['mail', 'mailto:dacare@da.gov.ph']] as [$icon, $href])
                        <a href="{{ $href }}"
                            class="w-10 h-10 rounded-full bg-white/10 hover:bg-emerald-500 hover:text-emerald-900 flex items-center justify-center transition group">
                            <!-- Added a class for targeting if needed, and ensured data-lucide is correct -->
                            <i data-lucide="{{ $icon }}"
                                class="w-5 h-5 text-white group-hover:text-inherit"></i>
                        </a>
                    @endforeach
                </div>
                <p class="text-xs text-white/70 mt-5 leading-relaxed">
                    DA-CARE is committed to transparency, accountability, and citizen-centered service.
                </p>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/70">
                <p>© {{ date('Y') }} Department of Agriculture MIMAROPA | Powered by MIS | All rights reserved.</p>

            </div>
        </div>
    </footer>
    <script>
        // This function tells Lucide to replace all <i data-lucide="..."> with actual SVGs
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Lucide icons
        lucide.createIcons();

        // Mobile menu toggle
        const toggle = document.getElementById('mobileToggle');
        const menu = document.getElementById('mobileMenu');
        toggle?.addEventListener('click', () => menu.classList.toggle('hidden'));

        // Scroll reveal
        const io = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('in');
                    io.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.12
        });
        document.querySelectorAll('.reveal').forEach((el) => io.observe(el));
    </script>
</body>

</html>
