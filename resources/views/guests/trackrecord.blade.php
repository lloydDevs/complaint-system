<x-guest-layout>
    @php
        $statusKey = isset($complaint) ? strtolower($complaint->status) : null;
        $stepIndex = match ($statusKey) {
            'pending' => 0,
            'viewed' => 1,
            'resolved' => 2,
            default => -1,
        };
        $progressPct = match ($stepIndex) {
            0 => 8,
            1 => 50,
            2 => 100,
            default => 0,
        };
        $statusBadge = match ($statusKey) {
            'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'viewed' => 'bg-sky-100 text-sky-700 ring-sky-200',
            'resolved' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            default => 'bg-slate-100 text-slate-600 ring-slate-200',
        };
    @endphp

    <style>
        :root {
            --da-green: #0f5132;
            --da-green-2: #1a7a4c;
            --da-gold: #c8a44a;
            --da-cream: #f7f3e9;
        }

        .da-bg {
            background:
                radial-gradient(1200px 600px at -10% -20%, rgba(26, 122, 76, .12), transparent 60%),
                radial-gradient(900px 500px at 110% 10%, rgba(200, 164, 74, .14), transparent 60%),
                linear-gradient(180deg, #fbfaf6 0%, #f3efe4 100%);
        }

        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(60px);
            opacity: .35;
            pointer-events: none;
            animation: floatBlob 14s ease-in-out infinite;
        }

        .blob.b1 {
            width: 320px;
            height: 320px;
            background: #1a7a4c;
            top: -80px;
            left: -80px;
        }

        .blob.b2 {
            width: 260px;
            height: 260px;
            background: #c8a44a;
            bottom: -60px;
            right: -60px;
            animation-delay: -6s;
        }

        @keyframes floatBlob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(20px, -25px) scale(1.06);
            }
        }

        .card-elev {
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(15, 81, 50, .08);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, .6) inset,
                0 30px 60px -30px rgba(15, 81, 50, .25),
                0 8px 20px -10px rgba(15, 81, 50, .12);
        }

        .reveal {
            opacity: 0;
            transform: translateY(14px);
            animation: revealUp .55s ease-out forwards;
        }

        .reveal-1 {
            animation-delay: .05s;
        }

        .reveal-2 {
            animation-delay: .15s;
        }

        .reveal-3 {
            animation-delay: .25s;
        }

        @keyframes revealUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-glow:focus {
            outline: none;
            border-color: var(--da-green-2);
            box-shadow: 0 0 0 4px rgba(26, 122, 76, .15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--da-green) 0%, var(--da-green-2) 100%);
            color: #fff;
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
            box-shadow: 0 10px 24px -10px rgba(15, 81, 50, .55);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary[disabled] {
            opacity: .7;
            cursor: not-allowed;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border-radius: 9999px;
            border: 2px solid rgba(255, 255, 255, .4);
            border-top-color: #fff;
            animation: spin .8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Timeline */
        .tl-track {
            position: relative;
            height: 4px;
            background: rgba(15, 81, 50, .12);
            border-radius: 9999px;
            overflow: hidden;
        }

        .tl-fill {
            position: absolute;
            inset: 0 auto 0 0;
            width: 0%;
            background: linear-gradient(90deg, var(--da-green), var(--da-gold));
            transition: width 1.1s cubic-bezier(.2, .7, .2, 1);
        }

        .tl-node {
            width: 36px;
            height: 36px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 2px solid rgba(15, 81, 50, .15);
            color: #6b7280;
            font-weight: 700;
            font-size: 13px;
            transition: all .4s ease;
        }

        .tl-node.active {
            background: linear-gradient(135deg, var(--da-green), var(--da-green-2));
            color: #fff;
            border-color: transparent;
            box-shadow: 0 8px 18px -8px rgba(15, 81, 50, .6);
            transform: scale(1.05);
        }

        .tl-node.done {
            background: var(--da-gold);
            color: #fff;
            border-color: transparent;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: #16a34a;
            box-shadow: 0 0 0 0 rgba(22, 163, 74, .55);
            animation: pulse 1.6s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(22, 163, 74, .55);
            }

            70% {
                box-shadow: 0 0 0 12px rgba(22, 163, 74, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(22, 163, 74, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .reveal,
            .blob,
            .pulse-dot,
            .tl-fill {
                animation: none !important;
                transition: none !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }

        @media (max-width: 640px) {
            .tl-node {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }
        }
    </style>

    <section class="da-bg relative min-h-[80vh] py-10 sm:py-16 px-4 overflow-hidden">
        <span class="blob b1"></span>
        <span class="blob b2"></span>

        <div class="relative max-w-3xl mx-auto">
            {{-- Header --}}
            <div class="text-center mb-8 reveal reveal-1">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/70 ring-1 ring-emerald-100 text-emerald-800 text-xs font-semibold mb-4">
                    <span class="pulse-dot"></span>
                    Live Complaint Tracker
                </div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-[color:var(--da-green)]">
                    Track Your Complaint
                </h1>
                <p class="mt-2 text-sm sm:text-base text-slate-600 max-w-xl mx-auto">
                    Enter the unique reference code from your submission to view real-time status updates.
                </p>
            </div>

            {{-- Search Card --}}
            <div class="card-elev rounded-2xl p-5 sm:p-7 reveal reveal-2">
                <form id="trackForm" method="GET" action="{{ route('complaints.track') }}" class="space-y-4">
                    @csrf

                    <label for="tracking_code" class="block text-xs font-bold uppercase tracking-wider text-slate-600">
                        Tracking Reference
                    </label>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </svg>
                            </span>
                            <input id="tracking_code" name="tracking_code" type="text"
                                value="{{ old('tracking_code') }}" placeholder="e.g. DA-CARE-XXXXXX" required
                                class="input-glow w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white/90 text-sm font-mono tracking-wider uppercase placeholder:normal-case placeholder:font-sans placeholder:text-slate-400 transition" />
                        </div>
                        <button id="searchBtn" type="submit"
                            class="btn-primary inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold text-sm">
                            <span id="btnLabel" class="inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </svg>
                                Track Now
                            </span>
                            <span id="btnLoading" class="hidden items-center gap-2">
                                <span class="spinner"></span> Searching…
                            </span>
                        </button>
                    </div>

                    @error('tracking_code')
                        <div
                            class="reveal flex items-start gap-2 text-sm text-red-600 bg-red-50 border border-red-100 rounded-lg px-3 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 shrink-0" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </form>
            </div>

            {{-- Result --}}
            @if (isset($complaint))
                <div class="card-elev rounded-2xl mt-6 overflow-hidden reveal reveal-3">
                    {{-- Top bar --}}
                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-5 sm:px-7 py-5 border-b border-slate-100 bg-gradient-to-r from-emerald-50/60 to-amber-50/60">
                        <div>
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Tracking
                                Reference</div>
                            <div class="flex items-center gap-2 mt-1">
                                <span id="codeText"
                                    class="font-mono text-lg font-bold text-[color:var(--da-green)]">{{ $complaint->code }}</span>
                                <button type="button" onclick="copyCode()"
                                    class="text-xs px-2 py-1 rounded-md border border-slate-200 hover:bg-white transition text-slate-600">
                                    <span id="copyLabel">Copy</span>
                                </button>
                            </div>
                        </div>
                        <div class="text-left sm:text-right">
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Current Status
                            </div>
                            <span
                                class="inline-block mt-1 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider ring-1 {{ $statusBadge }}">
                                {{ $complaint->status }}
                            </span>
                        </div>
                    </div>

                    {{-- Timeline --}}
                    <div class="px-5 sm:px-7 pt-6 pb-2">
                        <div class="tl-track">
                            <div id="tlFill" class="tl-fill" style="width: 0%"></div>
                        </div>
                        <div class="grid grid-cols-3 mt-3 text-center">
                            @foreach (['Submitted', 'Under Review', 'Resolved'] as $i => $label)
                                @php
                                    $cls = $i < $stepIndex ? 'done' : ($i === $stepIndex ? 'active' : '');
                                @endphp
                                <div class="flex flex-col items-center gap-2">
                                    <span class="tl-node {{ $cls }}">{{ $i + 1 }}</span>
                                    <span
                                        class="text-[11px] sm:text-xs font-semibold {{ $i <= $stepIndex ? 'text-[color:var(--da-green)]' : 'text-slate-400' }}">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="px-5 sm:px-7 py-6 space-y-5">
                        <div>
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Subject
                            </div>
                            <div class="text-base sm:text-lg font-semibold text-slate-800">{{ $complaint->title }}
                            </div>
                        </div>

                        <div>
                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Description
                            </div>
                            <p
                                class="text-sm text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50/70 border border-slate-100 rounded-xl p-4">
                                {{ $complaint->description }}</p>
                        </div>

                        @if ($complaint->admin_response)
                            <div class="border-l-4 border-[color:var(--da-gold)] bg-amber-50/60 rounded-r-xl p-4">
                                <div
                                    class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-amber-700 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                        </path>
                                    </svg>
                                    Official Response
                                </div>
                                <p class="text-sm text-slate-800 leading-relaxed">{{ $complaint->admin_response }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="mt-6 text-center text-sm text-slate-500 reveal reveal-3">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/70 ring-1 ring-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        Use the unique code provided during your initial submission.
                    </div>
                </div>
            @endif
        </div>
    </section>

    <script>
        // Loading state on submit
        (function() {
            const form = document.getElementById('trackForm');
            const btn = document.getElementById('searchBtn');
            const label = document.getElementById('btnLabel');
            const loading = document.getElementById('btnLoading');
            if (form) {
                form.addEventListener('submit', () => {
                    btn.setAttribute('disabled', 'disabled');
                    label.classList.add('hidden');
                    loading.classList.remove('hidden');
                    loading.classList.add('inline-flex');
                });
            }

            // Animate timeline fill on load
            const fill = document.getElementById('tlFill');
            if (fill) {
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        fill.style.width = '{{ $progressPct }}%';
                    }, 250);
                });
            }
        })();

        function copyCode() {
            const code = document.getElementById('codeText')?.innerText?.trim();
            const label = document.getElementById('copyLabel');
            if (!code || !label) return;
            navigator.clipboard.writeText(code).then(() => {
                label.textContent = 'Copied!';
                setTimeout(() => (label.textContent = 'Copy'), 1500);
            });
        }
    </script>
</x-guest-layout>
