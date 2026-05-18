<x-guest-layout>
    <style>
        :root {
            --da-green: #1f6b3a;
            --da-green-dark: #154d29;
            --da-green-light: #2e8b50;
            --da-cream: #fdfaf3;
            --da-soft-green: #e8f3ec;
            --da-gold: #d4a437;
            --da-text: #1a2e1f;
            --da-muted: #5a6b5e;
        }

        .da-about * {
            box-sizing: border-box;
        }

        .da-about {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--da-text);
            background: var(--da-cream);
        }

        /* Hero */
        .about-hero {
            position: relative;
            background: linear-gradient(135deg, var(--da-soft-green) 0%, var(--da-cream) 100%);
            padding: 80px 24px 100px;
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(31, 107, 58, 0.15), transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .about-hero::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: -100px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(212, 164, 55, 0.18), transparent 70%);
            border-radius: 50%;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-30px) scale(1.05);
            }
        }

        .about-hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .about-eyebrow {
            display: inline-block;
            background: rgba(31, 107, 58, 0.1);
            color: var(--da-green);
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 20px;
            animation: fadeUp 0.6s ease-out;
        }

        .about-title {
            font-size: clamp(36px, 5vw, 56px);
            font-weight: 800;
            line-height: 1.1;
            margin: 0 0 20px;
            color: var(--da-green-dark);
            animation: fadeUp 0.7s ease-out 0.1s backwards;
        }

        .about-title .accent {
            color: var(--da-gold);
        }

        .about-lede {
            font-size: clamp(16px, 1.6vw, 19px);
            color: var(--da-muted);
            max-width: 720px;
            margin: 0 auto;
            line-height: 1.6;
            animation: fadeUp 0.8s ease-out 0.2s backwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Section base */
        .da-section {
            padding: 80px 24px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: clamp(28px, 3.5vw, 40px);
            font-weight: 800;
            color: var(--da-green-dark);
            text-align: center;
            margin: 0 0 12px;
        }

        .section-sub {
            text-align: center;
            color: var(--da-muted);
            max-width: 640px;
            margin: 0 auto 48px;
            font-size: 16px;
            line-height: 1.6;
        }

        /* Mission / Vision */
        .mv-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .mv-card {
            background: white;
            border-radius: 20px;
            padding: 36px 28px;
            border: 1px solid rgba(31, 107, 58, 0.08);
            box-shadow: 0 4px 20px rgba(31, 107, 58, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .mv-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(31, 107, 58, 0.12);
        }

        .mv-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--da-green), var(--da-gold));
        }

        .mv-icon {
            width: 56px;
            height: 56px;
            background: var(--da-soft-green);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--da-green);
            margin-bottom: 20px;
        }

        .mv-icon svg {
            width: 28px;
            height: 28px;
        }

        .mv-card h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 12px;
            color: var(--da-green-dark);
        }

        .mv-card p {
            color: var(--da-muted);
            line-height: 1.6;
            margin: 0;
            font-size: 15px;
        }

        /* Values */
        .values-section {
            background: linear-gradient(180deg, white 0%, var(--da-soft-green) 100%);
            padding: 80px 24px;
        }

        .values-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .value-item {
            background: white;
            border-radius: 16px;
            padding: 28px 24px;
            text-align: center;
            border: 1px solid rgba(31, 107, 58, 0.08);
            transition: all 0.3s ease;
        }

        .value-item:hover {
            transform: translateY(-4px);
            border-color: var(--da-green-light);
        }

        .value-emoji {
            font-size: 36px;
            margin-bottom: 12px;
            display: block;
        }

        .value-item h4 {
            font-size: 17px;
            font-weight: 700;
            margin: 0 0 8px;
            color: var(--da-green-dark);
        }

        .value-item p {
            font-size: 14px;
            color: var(--da-muted);
            margin: 0;
            line-height: 1.5;
        }

        /* How It Works */
        .how-section {
            padding: 80px 24px;
            background: var(--da-cream);
        }

        .how-inner {
            max-width: 1100px;
            margin: 0 auto;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            position: relative;
        }

        .step-card {
            background: white;
            border-radius: 20px;
            padding: 36px 28px;
            text-align: center;
            border: 1px solid rgba(31, 107, 58, 0.08);
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(31, 107, 58, 0.12);
        }

        .step-number {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--da-green), var(--da-green-light));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 800;
            margin: 0 auto 20px;
            box-shadow: 0 8px 20px rgba(31, 107, 58, 0.25);
        }

        .step-card h4 {
            font-size: 20px;
            font-weight: 700;
            color: var(--da-green-dark);
            margin: 0 0 10px;
        }

        .step-card p {
            color: var(--da-muted);
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
        }

        /* 72-hour banner */
        .quick-action {
            margin: 60px auto;
            max-width: 1100px;
            background: linear-gradient(135deg, var(--da-green-dark) 0%, var(--da-green) 100%);
            border-radius: 24px;
            padding: 48px 40px;
            color: white;
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 32px;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .quick-action::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(212, 164, 55, 0.25), transparent 70%);
            border-radius: 50%;
        }

        .qa-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .qa-icon svg {
            width: 40px;
            height: 40px;
            color: var(--da-gold);
        }

        .qa-text {
            position: relative;
            z-index: 2;
        }

        .qa-text .badge {
            display: inline-block;
            background: var(--da-gold);
            color: var(--da-green-dark);
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .qa-text h3 {
            font-size: 26px;
            font-weight: 800;
            margin: 0 0 6px;
        }

        .qa-text p {
            margin: 0;
            opacity: 0.9;
            font-size: 15px;
        }

        .qa-cta {
            position: relative;
            z-index: 2;
            background: white;
            color: var(--da-green-dark);
            padding: 14px 28px;
            border-radius: 999px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            white-space: nowrap;
        }

        .qa-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Stats */
        .stats-section {
            background: white;
            padding: 60px 24px;
        }

        .stats-grid {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 32px;
            text-align: center;
        }

        .stat-item .num {
            font-size: 48px;
            font-weight: 800;
            color: var(--da-green);
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-item .num .plus {
            color: var(--da-gold);
        }

        .stat-item .label {
            color: var(--da-muted);
            font-weight: 500;
            font-size: 15px;
        }

        /* CTA */
        .cta-section {
            background: linear-gradient(135deg, var(--da-soft-green), var(--da-cream));
            padding: 80px 24px;
            text-align: center;
        }

        .cta-inner {
            max-width: 720px;
            margin: 0 auto;
        }

        .cta-section h2 {
            font-size: clamp(28px, 3.5vw, 38px);
            font-weight: 800;
            color: var(--da-green-dark);
            margin: 0 0 16px;
        }

        .cta-section p {
            color: var(--da-muted);
            margin: 0 0 32px;
            font-size: 17px;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--da-green);
            color: white;
            padding: 14px 32px;
            border-radius: 999px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--da-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(31, 107, 58, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--da-green-dark);
            padding: 14px 32px;
            border-radius: 999px;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid var(--da-green);
            transition: all 0.2s;
        }

        .btn-outline:hover {
            background: var(--da-green);
            color: white;
        }

        /* Reveal on scroll */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.in {
            opacity: 1;
            transform: translateY(0);
        }

        /* ---------- Responsive ---------- */

        /* Tablet */
        @media (max-width: 1024px) {
            .da-section {
                padding: 64px 20px;
            }

            .values-section,
            .how-section,
            .cta-section {
                padding: 64px 20px;
            }

            .quick-action {
                padding: 40px 32px;
                gap: 24px;
            }

            .qa-text h3 {
                font-size: 22px;
            }
        }

        /* Small tablet / large phone */
        @media (max-width: 768px) {
            .about-hero {
                padding: 64px 20px 72px;
            }

            .about-hero::before {
                width: 260px;
                height: 260px;
                top: -80px;
                right: -80px;
            }

            .about-hero::after {
                width: 240px;
                height: 240px;
                bottom: -100px;
                left: -80px;
            }

            .about-eyebrow {
                font-size: 12px;
                padding: 5px 14px;
            }

            .about-lede {
                font-size: 15px;
            }

            .da-section {
                padding: 56px 18px;
            }

            .section-sub {
                margin-bottom: 36px;
                font-size: 15px;
            }

            .mv-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .mv-card {
                padding: 28px 22px;
                border-radius: 16px;
            }

            .mv-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                margin-bottom: 16px;
            }

            .mv-icon svg {
                width: 24px;
                height: 24px;
            }

            .mv-card h3 {
                font-size: 18px;
            }

            .mv-card p {
                font-size: 14.5px;
            }

            .values-section {
                padding: 56px 18px;
            }

            .values-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }

            .value-item {
                padding: 22px 16px;
                border-radius: 14px;
            }

            .value-emoji {
                font-size: 30px;
            }

            .value-item h4 {
                font-size: 15px;
            }

            .value-item p {
                font-size: 13px;
            }

            .how-section {
                padding: 56px 18px;
            }

            .steps-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .step-card {
                padding: 28px 22px;
                border-radius: 16px;
            }

            .step-number {
                width: 56px;
                height: 56px;
                font-size: 22px;
                margin-bottom: 16px;
            }

            .step-card h4 {
                font-size: 18px;
            }

            .quick-action {
                grid-template-columns: 1fr;
                text-align: center;
                padding: 32px 22px;
                gap: 18px;
                margin: 40px auto;
                border-radius: 20px;
            }

            .qa-icon {
                margin: 0 auto;
                width: 68px;
                height: 68px;
                border-radius: 16px;
            }

            .qa-icon svg {
                width: 32px;
                height: 32px;
            }

            .qa-text h3 {
                font-size: 22px;
            }

            .qa-text p {
                font-size: 14px;
            }

            .qa-cta {
                padding: 12px 24px;
                font-size: 15px;
                display: inline-block;
            }

            .stats-section {
                padding: 48px 18px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 28px 16px;
            }

            .stat-item .num {
                font-size: 38px;
            }

            .stat-item .label {
                font-size: 13.5px;
            }

            .cta-section {
                padding: 64px 18px;
            }

            .cta-section p {
                font-size: 15.5px;
            }

            .cta-buttons {
                flex-direction: column;
                gap: 12px;
                align-items: stretch;
            }

            .btn-primary,
            .btn-outline {
                padding: 14px 24px;
                justify-content: center;
                width: 100%;
                font-size: 15px;
            }
        }

        /* Phone */
        @media (max-width: 480px) {
            .about-hero {
                padding: 56px 16px 64px;
            }

            .da-section,
            .values-section,
            .how-section,
            .stats-section,
            .cta-section {
                padding-left: 14px;
                padding-right: 14px;
            }

            .values-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .mv-card,
            .step-card {
                padding: 24px 18px;
            }

            .quick-action {
                padding: 28px 18px;
            }

            .qa-text h3 {
                font-size: 20px;
            }

            .stat-item .num {
                font-size: 42px;
            }
        }

        /* Touch devices: disable hover lifts that feel sticky on tap */
        @media (hover: none) {

            .mv-card:hover,
            .step-card:hover,
            .value-item:hover,
            .qa-cta:hover,
            .btn-primary:hover,
            .btn-outline:hover {
                transform: none;
                box-shadow: none;
            }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {

            .about-hero::before,
            .about-hero::after,
            .qa-icon,
            .reveal,
            .about-eyebrow,
            .about-title,
            .about-lede {
                animation: none !important;
                transition: none !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }
    </style>

    <div class="da-about">

        {{-- HERO --}}
        <section class="about-hero">
            <div class="about-hero-inner">
                <!-- Localized Eyebrow -->
                <span class="about-eyebrow">About DA-CARE MIMAROPA</span>

                <h1 class="about-title">
                    Listening, Acting, <span class="accent">Caring.</span>
                </h1>

                <!-- Updated Lede to match specific system functions -->
                <p class="about-lede">
                    DA-CARE is the dedicated grievance and feedback platform for <strong>DA RFO MIMAROPA</strong>.
                    We provide a secure, localized channel designed to address both individual stakeholder concerns
                    and workplace-related issues, ensuring accountability and professional resolution across our
                    regional offices.
                </p>
            </div>
        </section>
        {{-- MISSION / VISION / MANDATE --}}
        <section class="da-section">
            <h2 class="section-title">Why DA-CARE MIMAROPA Exists</h2>
            <p class="section-sub">
                We ensure that every concern—whether from the field or within our offices—reaches the right hands for a
                swift, localized response.
            </p>

            <div class="mv-grid">
                <!-- Our Mission -->
                <div class="mv-card reveal">
                    <div class="mv-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To provide a secure and accountable platform for the MIMAROPA agricultural community and our
                        regional workforce, ensuring all grievances are resolved with professional integrity.</p>
                </div>

                <!-- Our Vision -->
                <div class="mv-card reveal">
                    <div class="mv-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3>Our Vision</h3>
                    <p>A culture of transparency and accountability within DA MIMAROPA, where every voice—from farmers
                        to employees—drives excellence in regional service.</p>
                </div>

                <!-- Our Mandate -->
                <div class="mv-card reveal">
                    <div class="mv-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3>Our Mandate</h3>
                    <p>We uphold the right to swift redress and workplace justice through our specialized routing,
                        offering full "Identity Shield" protection for all complaints.</p>
                </div>
            </div>
        </section>

        {{-- CORE VALUES --}}
        <section class="values-section">
            <div class="values-inner">
                <h2 class="section-title">Our Core Values</h2>
                <p class="section-sub">The principles that shape every action we take on your concern.</p>

                <div class="values-grid">
                    @php
                        $values = [
                            [
                                'emoji' => '🔒',
                                'title' => 'Confidentiality',
                                'desc' => 'Your identity and details are protected at every step.',
                            ],
                            [
                                'emoji' => '⏱️',
                                'title' => 'Timeliness',
                                'desc' => 'Quick action within 72 hours',
                            ],
                            [
                                'emoji' => '⚖️',
                                'title' => 'Accountability',
                                'desc' => 'Clear ownership and full traceability of every case.',
                            ],
                            [
                                'emoji' => '🤝',
                                'title' => 'Integrity',
                                'desc' => 'Honest, unbiased handling — no exceptions.',
                            ],
                        ];
                    @endphp
                    @foreach ($values as $v)
                        <div class="value-item reveal">
                            <span class="value-emoji">{{ $v['emoji'] }}</span>
                            <h4>{{ $v['title'] }}</h4>
                            <p>{{ $v['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- HOW IT WORKS --}}
        <section class="how-section">
            <div class="how-inner">
                <h2 class="section-title">How It Works</h2>
                <p class="section-sub">Three simple steps from concern to resolution.</p>

                <div class="steps-grid">
                    @php
                        $steps = [
                            [
                                'n' => '1',
                                'title' => 'Submit',
                                'desc' => 'Fill out the complaint form with the details of your concern.',
                            ],
                            ['n' => '2', 'title' => 'Review', 'desc' => 'We review and evaluate your complaint.'],
                            [
                                'n' => '3',
                                'title' => 'Resolve',
                                'desc' => 'We act and provide a resolution within the prescribed timeline.',
                            ],
                        ];
                    @endphp
                    @foreach ($steps as $s)
                        <div class="step-card reveal">
                            <div class="step-number">{{ $s['n'] }}</div>
                            <h4>{{ $s['title'] }}</h4>
                            <p>{{ $s['desc'] }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- 72-hour Quick Action --}}
                <div class="quick-action reveal">
                    <div class="qa-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="qa-text">
                        <span class="badge">Service Pledge</span>
                        <h3>72-Hour Quick Action</h3>
                        <p>Every submitted complaint receives an initial response and case assignment within 72 hours.
                        </p>
                    </div>
                    <a href="{{ url('/newcomplaint') }}" class="qa-cta">Submit a Complaint →</a>
                </div>
            </div>
        </section>

        {{-- STATS --}}
        <section class="stats-section">
            <div class="stats-grid">
                <div class="stat-item reveal">
                    <div class="num">72<span class="plus">h</span></div>
                    <div class="label">Initial response time</div>
                </div>
                <div class="stat-item reveal">
                    <div class="num">100<span class="plus">%</span></div>
                    <div class="label">Confidential handling</div>
                </div>
                <div class="stat-item reveal">
                    <div class="num">30+</div>
                    <div class="label">Offices across MIMAROPA Region</div>
                </div>
                <div class="stat-item reveal">
                    <div class="num">24<span class="plus">/7</span></div>
                    <div class="label">Online submission</div>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="cta-section">
            <div class="cta-inner">
                <h2>Have a concern? We're ready to listen.</h2>
                <p>You can submit a complaint anonymously or track an existing one anytime.</p>
                <div class="cta-buttons">
                    <a href="{{ url('/newcomplaint') }}" class="btn-primary">
                        Submit Anonymous Complaint
                    </a>
                    <a href="{{ url('/trackcomplaint') }}" class="btn-outline">
                        Track My Complaint
                    </a>
                </div>
            </div>
        </section>
    </div>

    <script>
        (function() {
            const els = document.querySelectorAll('.reveal');
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('in');
                        io.unobserve(e.target);
                    }
                });
            }, {
                threshold: 0.15
            });
            els.forEach(el => io.observe(el));
        })();
    </script>
</x-guest-layout>
