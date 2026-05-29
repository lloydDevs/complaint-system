<x-guest-layout>
    @php

        $metrics = [
            [
                'label' => 'Total Seeded',
                'value' => $counts['total'] ?? 0,
                'icon' => 'sprout',
                'class' => 'text-[#1f6b3a] bg-[#eaf3ed]',
            ],
            [
                'label' => 'In Review',
                'value' => $counts['under_review'] ?? 0,
                'icon' => 'search',
                'class' => 'text-blue-600 bg-blue-50',
            ],
            [
                'label' => 'Acknowledged',
                'value' => $counts['acknowledged'] ?? 0,
                'icon' => 'check',
                'class' => 'text-indigo-600 bg-indigo-50',
            ],
            [
                'label' => 'Implemented',
                'value' => $counts['implemented'] ?? 0,
                'icon' => 'leaf',
                'class' => 'text-emerald-600 bg-emerald-50',
            ],
        ];
    @endphp

    <div
        class="tree-page min-h-screen bg-[#fbfcfb] text-[#0f1a14] font-sans antialiased py-12 px-4 selection:bg-[#1f6b3a]/10">
        <div class="max-w-6xl mx-auto">

            {{-- HEADER --}}
            <header class="text-center mb-12">
                <span
                    class="inline-block px-3 py-1 rounded-full bg-[#eaf3ed] text-[#16532c] text-xs font-bold tracking-wider uppercase mb-3">
                    Ideas in Bloom
                </span>

                <h1 class="serif text-5xl md:text-6xl text-[#0f1a14]">
                    The Suggestion Tree
                </h1>

                <p class="text-[#4b5a52] max-w-2xl mx-auto mt-3 text-sm md:text-base">
                    A visual ecosystem of community contributions. Watch the canopy grow as feedback and transparent
                    proposals are seeded by citizens.
                </p>
            </header>

            {{-- METRICS --}}
            <section class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                @foreach ($metrics as $metric)
                    <div
                        class="flex items-center gap-4 bg-white border border-[#ecefed] rounded-2xl p-4 shadow-sm transition-transform hover:-translate-y-0.5">

                        <div class="p-2.5 rounded-xl {{ $metric['class'] }}">
                            <i data-lucide="{{ $metric['icon'] }}" class="w-5 h-5"></i>
                        </div>

                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-[#8a978f]">
                                {{ $metric['label'] }}
                            </div>

                            <div class="serif text-3xl text-[#0f1a14] font-bold leading-none mt-1">
                                {{ $metric['value'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>

            {{-- FILTERS --}}
            <form method="GET" action="{{ route('suggestions.index') }}"
                class="flex flex-wrap items-center justify-between gap-4 mb-8 bg-white border border-[#ecefed] p-3 rounded-2xl shadow-sm">

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('suggestions.index') }}" class="chip {{ !request('status') ? 'active' : '' }}">
                        All Ideas
                    </a>

                    @foreach ($statuses as $val => $label)
                        <a href="{{ route('suggestions.index', array_merge(request()->query(), ['status' => $val])) }}"
                            class="chip {{ request('status') === $val ? 'active' : '' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <select name="category" onchange="this.form.submit()"
                        class="w-full sm:w-auto text-xs border border-[#e3ede7] rounded-xl px-3 py-2 bg-white focus:outline-none focus:border-[#1f6b3a] focus:ring-1 focus:ring-[#1f6b3a]">

                        <option value="">All Categories</option>

                        @foreach ($categories as $val => $label)
                            <option value="{{ $val }}" {{ request('category') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @if (request()->hasAny(['status', 'category']))
                        <a href="{{ route('suggestions.index') }}"
                            class="p-2 border border-red-100 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 transition-colors"
                            title="Clear Filters">

                            <i data-lucide="list-restart" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </form>

            @if ($suggestions->isEmpty())
                <div class="text-center py-20 bg-white border border-[#ecefed] rounded-3xl shadow-sm">
                    <i data-lucide="tree-deciduous" class="w-12 h-12 text-[#8a978f] mx-auto animate-pulse"></i>

                    <h3 class="serif text-2xl mt-4 text-[#0f1a14]">
                        Quiet in the forest
                    </h3>

                    <p class="text-sm text-[#4b5a52] mt-1">
                        No suggestions matched your current filters.
                    </p>
                </div>
            @else
                @php
                    $count = $suggestions->count();

                    if ($count <= 2) {
                        $stageTitle = 'Sprout Stage';
                        $stageDesc = 'The initial seed has broken ground. Your ideas are beginning to take root.';
                        $viewBox = '0 0 200 200';
                    } elseif ($count <= 9) {
                        $stageTitle = 'Sapling Stage';
                        $stageDesc = 'A young tree establishing its structure. Branches are spreading out.';
                        $viewBox = '0 0 400 400';
                    } elseif ($count <= 24) {
                        $stageTitle = 'Young Canopy Stage';
                        $stageDesc = 'A robust tree breaking out with distinct structural clusters and deep foliage.';
                        $viewBox = '0 0 600 500';
                    } else {
                        $stageTitle = 'Mature Ecosystem Stage';
                        $stageDesc = 'A majestic, deep-rooted structure sheltering a dense canopy of citizen feedback.';
                        $viewBox = '0 0 800 600';
                    }

                    $saplingCoords = [
                        ['x' => 140, 'y' => 170, 'side' => 'left'],
                        ['x' => 260, 'y' => 160, 'side' => 'right'],
                        ['x' => 205, 'y' => 130, 'side' => 'top'],
                        ['x' => 165, 'y' => 195, 'side' => 'left'],
                        ['x' => 230, 'y' => 180, 'side' => 'right'],
                        ['x' => 198, 'y' => 170, 'side' => 'top'],
                        ['x' => 148, 'y' => 150, 'side' => 'left'],
                        ['x' => 252, 'y' => 140, 'side' => 'right'],
                        ['x' => 202, 'y' => 110, 'side' => 'top'],
                    ];

                    $clusters = [
                        ['cx' => 180, 'cy' => 180, 'r' => 70],
                        ['cx' => 300, 'cy' => 120, 'r' => 80],
                        ['cx' => 420, 'cy' => 180, 'r' => 75],
                        ['cx' => 240, 'cy' => 260, 'r' => 60],
                        ['cx' => 360, 'cy' => 260, 'r' => 65],
                    ];
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                    {{-- TREE --}}
                    <div
                        class="lg:col-span-7 bg-gradient-to-b from-[#cfe7d6]/30 via-[#eaf3ed]/40 to-white border border-[#ecefed] rounded-3xl p-6 shadow-sm sticky top-6">

                        <div class="flex justify-between items-center border-b border-[#e3ede7] pb-4 mb-4">
                            <div>
                                <h4 class="text-sm font-bold text-[#0f1a14]">
                                    {{ $stageTitle }}
                                </h4>

                                <p class="text-xs text-[#4b5a52]">
                                    {{ $stageDesc }}
                                </p>
                            </div>

                            <span
                                class="text-xs bg-[#1f6b3a]/10 text-[#1f6b3a] px-2.5 py-1 rounded-md font-semibold tracking-wide">
                                {{ $count }} Active {{ Str::plural('Leaf', $count) }}
                            </span>
                        </div>

                        <div class="w-full h-[350px] sm:h-[450px] flex items-center justify-center overflow-hidden">
                            <svg viewBox="{{ $viewBox }}"
                                class="w-full h-full max-h-[420px] drop-shadow-md transition-all duration-700"
                                xmlns="http://www.w3.org/2000/svg">

                                <defs>
                                    <linearGradient id="trunkGrad" x1="0%" y1="0%" x2="100%"
                                        y2="0%">
                                        <stop offset="0%" stop-color="#4a3222" />
                                        <stop offset="50%" stop-color="#5a3d29" />
                                        <stop offset="100%" stop-color="#3b2518" />
                                    </linearGradient>

                                    <linearGradient id="leafGrad" x1="0%" y1="0%" x2="100%"
                                        y2="100%">
                                        <stop offset="0%" stop-color="#54b86f" />
                                        <stop offset="100%" stop-color="#1f6b3a" />
                                    </linearGradient>

                                    <filter id="shadow" x="-10%" y="-10%" width="120%" height="120%">
                                        <feDropShadow dx="0" dy="2" stdDeviation="2"
                                            flood-opacity="0.1" />
                                    </filter>
                                </defs>

                                {{-- SPROUT --}}
                                @if ($count <= 2)
                                    <g>
                                        <path d="M 100 200 C 100 170, 95 140, 100 110" fill="none"
                                            stroke="url(#trunkGrad)" stroke-width="7" stroke-linecap="round" />

                                        <path d="M 100 110 C 100 95, 105 85, 103 75" fill="none"
                                            stroke="url(#trunkGrad)" stroke-width="4" stroke-linecap="round" />

                                        <path d="M 101 130 C 120 120, 125 95, 102 105 C 100 120, 101 125, 101 130 Z"
                                            fill="url(#leafGrad)" id="node-leaf-0"
                                            class="interactive-leaf cursor-pointer" onclick="focusSuggestion(0)" />

                                        @if ($count == 2)
                                            <path d="M 100 100 C 75 90, 70 65, 96 78 C 99 90, 100 95, 100 100 Z"
                                                fill="url(#leafGrad)" id="node-leaf-1"
                                                class="interactive-leaf cursor-pointer" onclick="focusSuggestion(1)" />
                                        @endif
                                    </g>

                                    {{-- SAPLING --}}
                                @elseif ($count <= 9)
                                    <g>
                                        <path d="M 200 400 Q 195 300, 200 240" fill="none" stroke="url(#trunkGrad)"
                                            stroke-width="12" stroke-linecap="round" />

                                        <path d="M 200 250 Q 160 210, 140 170" fill="none" stroke="url(#trunkGrad)"
                                            stroke-width="6" stroke-linecap="round" />

                                        <path d="M 200 240 Q 240 195, 260 160" fill="none" stroke="url(#trunkGrad)"
                                            stroke-width="6" stroke-linecap="round" />

                                        <path d="M 200 240 Q 195 180, 205 130" fill="none" stroke="url(#trunkGrad)"
                                            stroke-width="5" stroke-linecap="round" />

                                        @foreach ($suggestions as $index => $s)
                                            @php
                                                $coord = $saplingCoords[$index] ?? null;
                                            @endphp

                                            @if ($coord)
                                                @if ($coord['side'] === 'left')
                                                    <path d="M {{ $coord['x'] }} {{ $coord['y'] }}
                                                        C {{ $coord['x'] - 25 }} {{ $coord['y'] - 10 }},
                                                          {{ $coord['x'] - 30 }} {{ $coord['y'] - 35 }},
                                                          {{ $coord['x'] - 5 }} {{ $coord['y'] - 20 }} Z"
                                                        fill="url(#leafGrad)" id="node-leaf-{{ $index }}"
                                                        class="interactive-leaf cursor-pointer"
                                                        onclick="focusSuggestion({{ $index }})" />
                                                @elseif ($coord['side'] === 'right')
                                                    <path d="M {{ $coord['x'] }} {{ $coord['y'] }}
                                                        C {{ $coord['x'] + 25 }} {{ $coord['y'] - 10 }},
                                                          {{ $coord['x'] + 30 }} {{ $coord['y'] - 35 }},
                                                          {{ $coord['x'] + 5 }} {{ $coord['y'] - 20 }} Z"
                                                        fill="url(#leafGrad)" id="node-leaf-{{ $index }}"
                                                        class="interactive-leaf cursor-pointer"
                                                        onclick="focusSuggestion({{ $index }})" />
                                                @else
                                                    <path d="M {{ $coord['x'] }} {{ $coord['y'] }}
                                                        C {{ $coord['x'] - 15 }} {{ $coord['y'] - 25 }},
                                                          {{ $coord['x'] + 15 }} {{ $coord['y'] - 35 }},
                                                          {{ $coord['x'] + 2 }} {{ $coord['y'] - 15 }} Z"
                                                        fill="url(#leafGrad)" id="node-leaf-{{ $index }}"
                                                        class="interactive-leaf cursor-pointer"
                                                        onclick="focusSuggestion({{ $index }})" />
                                                @endif
                                            @endif
                                        @endforeach
                                    </g>

                                    {{-- YOUNG CANOPY --}}
                                @elseif ($count <= 24)
                                    <g>
                                        @foreach ($clusters as $cluster)
                                            <circle cx="{{ $cluster['cx'] }}" cy="{{ $cluster['cy'] }}"
                                                r="{{ $cluster['r'] }}" fill="#1f6b3a" fill-opacity="0.08"
                                                stroke="#4fa05a" stroke-width="1" stroke-dasharray="3 3" />
                                        @endforeach

                                        @for ($i = 0; $i < $count; $i++)
                                            @php
                                                $cx = 300 + cos($i * 2.4) * (100 + $i * 5);
                                                $cy = 230 + sin($i * 2.1) * (90 + $i * 2);
                                            @endphp

                                            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="10"
                                                fill="url(#leafGrad)" id="node-leaf-{{ $i }}"
                                                class="interactive-leaf cursor-pointer" filter="url(#shadow)"
                                                onclick="focusSuggestion({{ $i }})" />

                                            <text x="{{ $cx }}" y="{{ $cy + 3 }}" font-size="8"
                                                fill="#fff" text-anchor="middle"
                                                class="pointer-events-none font-bold">
                                                {{ $i + 1 }}
                                            </text>
                                        @endfor
                                    </g>

                                    {{-- MATURE --}}
                                @else
                                    <g>
                                        @php
                                            $maxLeaves = min($count, 60);
                                            $seedFactor = (float) request('seed', 2.3);
                                        @endphp

                                        @for ($i = 0; $i < $maxLeaves; $i++)
                                            @php
                                                $angle = $i * (360 / $maxLeaves) * $seedFactor;
                                                $radius = 70 + (($i * 7) % 140);

                                                $cx = 400 + cos(deg2rad($angle)) * ($radius * 1.6);
                                                $cy = 260 + sin(deg2rad($angle)) * $radius;
                                            @endphp

                                            @if ($cy < 500)
                                                <circle cx="{{ $cx }}" cy="{{ $cy }}" r="9"
                                                    fill="url(#leafGrad)" id="node-leaf-{{ $i }}"
                                                    class="interactive-leaf cursor-pointer" filter="url(#shadow)"
                                                    onclick="focusSuggestion({{ $i }})" />

                                                <text x="{{ $cx }}" y="{{ $cy + 3 }}" font-size="7"
                                                    fill="#fff" text-anchor="middle"
                                                    class="pointer-events-none font-medium">
                                                    {{ $i + 1 }}
                                                </text>
                                            @endif
                                        @endfor
                                    </g>
                                @endif
                            </svg>
                        </div>

                        <div class="text-center mt-2 text-[11px] text-[#8a978f] font-medium">
                            <i data-lucide="info" class="w-3 h-3 inline mr-1 -mt-0.5"></i>
                            Click any numbered leaf node to highlight the citizen feedback.
                        </div>
                    </div>

                    {{-- SUGGESTIONS --}}
                    <div class="lg:col-span-5 space-y-3 max-h-[75vh] overflow-y-auto pr-2 custom-scrollbar">

                        @foreach ($suggestions as $index => $s)
                            @php
                                $statusClasses =
                                    [
                                        'pending' => 'bg-amber-50 text-amber-800 border-amber-200',
                                        'under_review' => 'bg-blue-50 text-blue-800 border-blue-200',
                                        'acknowledged' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
                                        'implemented' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                        'declined' => 'bg-red-50 text-red-800 border-red-200',
                                    ][$s->status] ?? 'bg-gray-50 text-gray-800 border-gray-200';
                            @endphp

                            <article id="card-suggestion-{{ $index }}"
                                class="suggestion-card bg-white border border-[#ecefed] rounded-2xl p-4 shadow-sm transition-all duration-300 hover:border-[#1f6b3a]/40">

                                <header class="flex justify-between items-start gap-2 mb-2">
                                    <div class="min-w-0">
                                        @if ($s->name)
                                            <h3 class="font-bold text-sm text-[#0f1a14] truncate">
                                                {{ $s->name }}
                                            </h3>

                                            @if ($s->designation)
                                                <p class="text-[11px] text-[#8a978f] truncate">
                                                    {{ $s->designation }}
                                                </p>
                                            @endif
                                        @else
                                            <div
                                                class="inline-flex items-center gap-1 text-xs italic text-[#8a978f] font-medium">
                                                <i data-lucide="shield" class="w-3 h-3"></i>
                                                Anonymous Citizen
                                            </div>
                                        @endif
                                    </div>

                                    <span
                                        class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $statusClasses }}">
                                        {{ $s->status_label ?? ucfirst(str_replace('_', ' ', $s->status)) }}
                                    </span>
                                </header>

                                <p class="text-xs sm:text-sm text-[#4b5a52] leading-relaxed mb-3 break-words">
                                    {{ $s->suggestion }}
                                </p>

                                <footer
                                    class="flex justify-between items-center text-[11px] text-[#8a978f] pt-2.5 border-t border-[#ecefed]">

                                    <span class="inline-flex items-center gap-1 font-medium">
                                        <i data-lucide="tag" class="w-3 h-3 text-[#1f6b3a]"></i>
                                        {{ $s->category_label ?? ucfirst($s->category) }}
                                    </span>

                                    <span class="inline-flex items-center gap-1">
                                        <i data-lucide="calendar" class="w-3 h-3"></i>
                                        {{ $s->created_at->format('M d, Y') }}
                                    </span>
                                </footer>
                            </article>
                        @endforeach

                        <div class="pt-4">
                            {{ $suggestions->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>

{{-- SCRIPTS --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    function focusSuggestion(index) {
        document.querySelectorAll('.suggestion-card').forEach(card => {
            card.classList.remove(
                'border-[#1f6b3a]',
                'ring-2',
                'ring-[#1f6b3a]/20',
                'bg-[#eaf3ed]/10'
            );
        });

        const targetCard = document.getElementById(`card-suggestion-${index}`);

        if (targetCard) {
            targetCard.classList.add(
                'border-[#1f6b3a]',
                'ring-2',
                'ring-[#1f6b3a]/20',
                'bg-[#eaf3ed]/10'
            );

            targetCard.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        document.querySelectorAll('.interactive-leaf').forEach(leaf => {
            leaf.setAttribute('stroke', 'none');
        });

        const targetLeaf = document.getElementById(`node-leaf-${index}`);

        if (targetLeaf) {
            targetLeaf.setAttribute('stroke', '#0f1a14');
            targetLeaf.setAttribute('stroke-width', '1.5');
        }
    }
</script>

{{-- STYLES --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap');

    .serif {
        font-family: 'Inter', system-ui, sans-serif;
        letter-spacing: -0.01em;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        padding: 0.45rem 0.9rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        background: #fff;
        color: #4b5a52;
        border: 1px solid #e3ede7;
        transition: all 0.15s ease;
    }

    .chip:hover {
        color: #16532c;
        border-color: #1f6b3a;
    }

    .chip.active {
        background: #0f1a14;
        color: #fff;
        border-color: #0f1a14;
    }

    .interactive-leaf {
        transition:
            transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275),
            fill 0.2s ease;
    }

    .interactive-leaf:hover {
        transform-box: fill-box;
        transform-origin: center;
        fill: #4fa05a;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e3ede7;
        border-radius: 9999px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #8a978f;
    }
</style>
