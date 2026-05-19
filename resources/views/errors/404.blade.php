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
            --da-border: #e3ebe5;
        }

        .da-error * {
            box-sizing: border-box;
        }

        .da-error {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--da-text);
            background: var(--da-cream);
            min-height: 100vh;
            padding: 48px 20px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 90%;
        }

        .da-error::before,
        .da-error::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .da-error::before {
            top: -120px;
            right: -120px;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(31, 107, 58, 0.12), transparent 70%);
            animation: floatBlob 9s ease-in-out infinite;
        }

        .da-error::after {
            bottom: -140px;
            left: -100px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(212, 164, 55, 0.16), transparent 70%);
            animation: floatBlob 11s ease-in-out infinite reverse;
        }

        @keyframes floatBlob {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-30px) scale(1.05);
            }
        }

        .err-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 520px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--da-border);
            border-radius: 20px;
            padding: 48px 36px;
            text-align: center;
            box-shadow: 0 20px 60px -20px rgba(21, 77, 41, 0.18);
            animation: revealUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes revealUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .err-icon {
            width: 84px;
            height: 84px;
            margin: 0 auto 24px;
            background: var(--da-soft-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .err-icon svg {
            width: 40px;
            height: 40px;
            color: var(--da-green);
            stroke-width: 1.5;
        }

        .err-code {
            font-size: 76px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--da-green-dark), var(--da-green));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
        }

        .err-title {
            font-size: 22px;
            font-weight: 600;
            color: var(--da-text);
            margin: 16px 0 12px;
        }

        .err-msg {
            font-size: 14px;
            line-height: 1.6;
            color: var(--da-muted);
            margin: 0 0 32px;
        }

        .err-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-secondary,
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: 0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary {
            background: #ffffff;
            color: var(--da-text);
            border: 1px solid var(--da-border);
        }

        .btn-secondary:hover {
            background: var(--da-cream);
            box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.08);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--da-green), var(--da-green-dark));
            color: #ffffff;
            box-shadow: 0 4px 12px -2px rgba(31, 107, 58, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -4px rgba(31, 107, 58, 0.45);
        }

        .btn-primary svg,
        .btn-secondary svg {
            width: 16px;
            height: 16px;
        }

        .err-footer {
            position: relative;
            z-index: 1;
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: var(--da-muted);
            opacity: 0.7;
        }

        @media (prefers-reduced-motion: reduce) {

            .err-card,
            .da-error::before,
            .da-error::after {
                animation: none;
            }
        }

        @media (max-width: 480px) {
            .err-card {
                padding: 36px 24px;
            }

            .err-code {
                font-size: 60px;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="da-error">
        <div style="position: relative; z-index: 1; width: 100%; max-width: 520px;">
            <div class="err-card">
                <div class="err-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 2v6h6" />
                        <circle cx="11.5" cy="14.5" r="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m13.5 16.5 2 2" />
                    </svg>
                </div>

                <h1 class="err-code">404</h1>
                <h2 class="err-title">Page Not Found</h2>
                <p class="err-msg">
                    The page you're looking for doesn't exist or has been moved.
                    Please check the URL or return to the previous page.
                </p>

                <div class="err-actions">
                    <button type="button" class="btn-secondary" onclick="window.history.back()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7" />
                        </svg>
                        Go Back
                    </button>
                    <a href="{{ url('/') }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10" />
                        </svg>
                        Go Home
                    </a>
                </div>
            </div>

            <p class="err-footer">Anonymity Protected by Identity Shield</p>
        </div>
    </div>
</x-guest-layout>
