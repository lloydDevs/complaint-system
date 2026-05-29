<x-app-layout>
    <x-slot name="title">Suggestions & Recommendations</x-slot>

    <div class="sugg-page">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- HEADER --}}
            <header class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10 anim">
                <div>
                    <span class="eyebrow"><span class="dot"></span> Public Feedback</span>
                    <h1 class="serif text-4xl sm:text-5xl mt-4 leading-[1.05]">
                        Suggestions &amp; <em class="italic text-[var(--green-dark)]">Recommendations</em>
                    </h1>
                    <p class="mt-3 text-sm text-[var(--ink-2)] max-w-xl">
                        Review and act on ideas submitted by citizens and stakeholders.
                    </p>
                </div>
                <div class="flex items-center gap-2 text-xs text-[var(--muted)]">
                    <i data-lucide="clock-3" class="w-3.5 h-3.5"></i>
                    Last updated {{ now()->format('M d, Y · g:i A') }}
                </div>
            </header>

            {{-- FLASH --}}
            @if (session('success'))
                <div
                    class="anim d1 flex items-center gap-3 mb-6 px-4 py-3 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-sm">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- STATS --}}
            @php
                $statDefs = [
                    ['key' => 'total', 'label' => 'Total', 'icon' => 'inbox', 'color' => '#1f6b3a', 'bg' => '#e8f3ec'],
                    [
                        'key' => 'pending',
                        'label' => 'Pending',
                        'icon' => 'clock',
                        'color' => '#92400e',
                        'bg' => '#fef3c7',
                    ],
                    [
                        'key' => 'under_review',
                        'label' => 'Under Review',
                        'icon' => 'eye',
                        'color' => '#1e40af',
                        'bg' => '#dbeafe',
                    ],
                    [
                        'key' => 'acknowledged',
                        'label' => 'Acknowledged',
                        'icon' => 'thumbs-up',
                        'color' => '#3730a3',
                        'bg' => '#e0e7ff',
                    ],
                    [
                        'key' => 'implemented',
                        'label' => 'Implemented',
                        'icon' => 'check-circle-2',
                        'color' => '#065f46',
                        'bg' => '#d1fae5',
                    ],
                    [
                        'key' => 'declined',
                        'label' => 'Declined',
                        'icon' => 'x-circle',
                        'color' => '#991b1b',
                        'bg' => '#fee2e2',
                    ],
                ];
            @endphp
            <section class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-8">
                @foreach ($statDefs as $i => $s)
                    <div class="stat anim d{{ $i + 1 }}">
                        <div class="flex items-center justify-between mb-3">
                            <span class="ico" style="background: {{ $s['bg'] }}; color: {{ $s['color'] }};">
                                <i data-lucide="{{ $s['icon'] }}" class="w-4 h-4"></i>
                            </span>
                        </div>
                        <div class="num serif">{{ $counts[$s['key']] ?? 0 }}</div>
                        <div class="lbl mt-2">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </section>

            {{-- FILTERS --}}
            <section class="surface p-5 mb-6 anim d3">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('admin.suggestions.index', array_merge(request()->query(), ['status' => null])) }}"
                            class="chip {{ !request('status') ? 'active' : '' }}">All</a>
                        @foreach ($statuses as $val => $label)
                            <a href="{{ route('admin.suggestions.index', array_merge(request()->query(), ['status' => $val])) }}"
                                class="chip {{ request('status') === $val ? 'active' : '' }}">{{ $label }}</a>
                        @endforeach
                    </div>

                    <form method="GET" action="{{ route('admin.suggestions.index') }}"
                        class="flex items-center gap-3">
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <label
                            class="text-xs text-[var(--muted)] uppercase tracking-wider font-semibold">Category</label>
                        <select name="category" onchange="this.form.submit()"
                            class="text-sm border border-[var(--line-2)] rounded-lg px-3 py-1.5 bg-white focus:outline-none focus:border-[var(--green)]">
                            <option value="">All</option>
                            @foreach ($categories as $val => $label)
                                <option value="{{ $val }}"
                                    {{ request('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if (request()->hasAny(['status', 'category']))
                            <a href="{{ route('admin.suggestions.index') }}"
                                class="text-xs text-red-500 hover:text-red-700 font-medium inline-flex items-center gap-1">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i> Clear
                            </a>
                        @endif
                    </form>
                </div>
            </section>

            {{-- TABLE --}}
            <section class="surface anim d4">
                @if ($suggestions->isEmpty())
                    <div class="empty">
                        <div class="ring"><i data-lucide="inbox" class="w-7 h-7"></i></div>
                        <h3 class="serif text-2xl">No suggestions found</h3>
                        <p class="text-sm text-[var(--muted)] mt-1">Try adjusting your filters or check back later.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="sugg-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Submitter</th>
                                    <th>Suggestion</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suggestions as $s)
                                    <tr class="sugg-row"
                                        onclick="window.location='{{ route('admin.suggestions.show', $s) }}'">
                                        <td class="text-[var(--muted)] font-mono text-xs">{{ $s->id }}</td>

                                        <td>
                                            @if ($s->name)
                                                <div class="font-medium text-[var(--ink)]">{{ $s->name }}</div>
                                                @if ($s->designation)
                                                    <div class="text-xs text-[var(--muted)] mt-0.5">
                                                        {{ $s->designation }}</div>
                                                @endif
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 text-xs text-[var(--muted)] italic">
                                                    <i data-lucide="user-x" class="w-3 h-3"></i> Anonymous
                                                </span>
                                            @endif
                                        </td>

                                        <td class="max-w-md">
                                            <p class="text-[var(--ink)] line-clamp-2 leading-relaxed">
                                                {{ $s->suggestion }}</p>
                                        </td>

                                        <td>
                                            <span class="inline-flex items-center gap-1.5 text-xs text-[var(--ink-2)]">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[var(--green)]"></span>
                                                {{ $s->category_label }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="pill pill-{{ $s->status }}">{{ $s->status_label }}</span>
                                        </td>

                                        <td>
                                            <div class="text-xs text-[var(--ink-2)]">
                                                {{ $s->created_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-[var(--muted)]">
                                                {{ $s->created_at->format('g:i A') }}</div>
                                        </td>

                                        <td onclick="event.stopPropagation()">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.suggestions.show', $s) }}" title="View"
                                                    class="icon-btn view">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('admin.suggestions.destroy', $s) }}"
                                                    onsubmit="return confirm('Delete this suggestion?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" title="Delete" class="icon-btn del">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    @if ($suggestions->hasPages())
                        <div
                            class="flex flex-col sm:flex-row items-center justify-between gap-3 px-5 py-4 border-t border-[var(--line)] bg-[var(--surface)]">
                            <div class="text-xs text-[var(--muted)]">
                                Showing <span
                                    class="text-[var(--ink)] font-semibold">{{ $suggestions->firstItem() }}–{{ $suggestions->lastItem() }}</span>
                                of <span class="text-[var(--ink)] font-semibold">{{ $suggestions->total() }}</span>
                                suggestions
                            </div>
                            <div class="flex items-center gap-1">
                                @if ($suggestions->onFirstPage())
                                    <span
                                        class="px-2.5 py-1.5 text-xs text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">
                                        <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                                    </span>
                                @else
                                    <a href="{{ $suggestions->previousPageUrl() }}"
                                        class="px-2.5 py-1.5 text-xs text-[var(--ink-2)] border border-[var(--line-2)] rounded-lg hover:border-[var(--green)] hover:text-[var(--green-dark)] transition">
                                        <i data-lucide="chevron-left" class="w-3.5 h-3.5"></i>
                                    </a>
                                @endif

                                @foreach ($suggestions->getUrlRange(max(1, $suggestions->currentPage() - 2), min($suggestions->lastPage(), $suggestions->currentPage() + 2)) as $page => $url)
                                    @if ($page == $suggestions->currentPage())
                                        <span class="px-3 py-1.5 text-xs font-semibold text-white rounded-lg"
                                            style="background: var(--ink);">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-3 py-1.5 text-xs text-[var(--ink-2)] border border-[var(--line-2)] rounded-lg hover:border-[var(--green)] hover:text-[var(--green-dark)] transition">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($suggestions->hasMorePages())
                                    <a href="{{ $suggestions->nextPageUrl() }}"
                                        class="px-2.5 py-1.5 text-xs text-[var(--ink-2)] border border-[var(--line-2)] rounded-lg hover:border-[var(--green)] hover:text-[var(--green-dark)] transition">
                                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                    </a>
                                @else
                                    <span
                                        class="px-2.5 py-1.5 text-xs text-gray-300 border border-gray-200 rounded-lg cursor-not-allowed">
                                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            </section>

        </div>
    </div>

</x-app-layout>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap');

    :root {
        --ink: #0f1a14;
        --ink-2: #4b5a52;
        --muted: #8a978f;
        --line: #ecefed;
        --line-2: #e3ede7;
        --surface: #f6f8f6;
        --canvas: #fbfcfb;
        --green: #1f6b3a;
        --green-dark: #16532c;
        --green-pale: #eaf3ed;
        --gold: #c69323;
        --gold-pale: #f7eccd;
    }

    .sugg-page {
        font-family: 'Inter', system-ui, sans-serif;
        color: var(--ink);
        background:
            radial-gradient(1200px 500px at 90% -10%, #eaf3ed 0%, transparent 60%),
            radial-gradient(900px 400px at -10% 10%, #f7eccd55 0%, transparent 55%),
            var(--canvas);
        min-height: 100vh;
    }

    .serif {
        font-family: 'Inter', system-ui, sans-serif;
        font-weight: 400;
        letter-spacing: -0.01em;
    }

    /* Eyebrow */
    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--green-dark);
        background: #fff;
        border: 1px solid var(--line-2);
        padding: .35rem .7rem;
        border-radius: 9999px;
    }

    .eyebrow .dot {
        width: 6px;
        height: 6px;
        border-radius: 9999px;
        background: var(--green);
        box-shadow: 0 0 0 4px #1f6b3a1a;
    }

    /* Stat tiles */
    .stat {
        position: relative;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 1.1rem 1.2rem;
        transition: border-color .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    .stat:hover {
        transform: translateY(-2px);
        border-color: #d6e2dc;
        box-shadow: 0 14px 30px -22px rgba(15, 26, 20, .25);
    }

    .stat .num {
        font-size: 1.9rem;
        line-height: 1;
    }

    .stat .lbl {
        font-size: .72rem;
        color: var(--muted);
        letter-spacing: .08em;
        text-transform: uppercase;
        font-weight: 600;
    }

    .stat .ico {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Pills */
    .pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .25rem .6rem;
        border-radius: 9999px;
        font-size: .7rem;
        font-weight: 600;
        border: 1px solid transparent;
    }

    .pill-pending {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }

    .pill-under_review {
        background: #dbeafe;
        color: #1e40af;
        border-color: #bfdbfe;
    }

    .pill-acknowledged {
        background: #e0e7ff;
        color: #3730a3;
        border-color: #c7d2fe;
    }

    .pill-implemented {
        background: #d1fae5;
        color: #065f46;
        border-color: #6ee7b7;
    }

    .pill-declined {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fca5a5;
    }

    /* Filter chips */
    .chip {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .4rem .85rem;
        border-radius: 9999px;
        font-size: .75rem;
        font-weight: 600;
        background: #fff;
        color: var(--ink-2);
        border: 1px solid var(--line-2);
        transition: all .18s ease;
    }

    .chip:hover {
        color: var(--green-dark);
        border-color: var(--green);
    }

    .chip.active {
        background: var(--ink);
        color: #fff;
        border-color: var(--ink);
    }

    /* Card surface */
    .surface {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 18px;
        overflow: hidden;
    }

    /* Table */
    .sugg-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .sugg-table thead th {
        font-size: .68rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--muted);
        font-weight: 600;
        padding: .9rem 1.25rem;
        text-align: left;
        background: var(--surface);
        border-bottom: 1px solid var(--line);
    }

    .sugg-table tbody td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--line);
        vertical-align: top;
        font-size: .875rem;
    }

    .sugg-row {
        cursor: pointer;
        transition: background .15s ease;
    }

    .sugg-row:hover {
        background: #fafcfb;
    }

    .sugg-row:last-child td {
        border-bottom: 0;
    }

    .icon-btn {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background .15s ease, color .15s ease;
    }

    .icon-btn.view {
        background: var(--green-pale);
        color: var(--green-dark);
    }

    .icon-btn.view:hover {
        background: #d8eadf;
    }

    .icon-btn.del {
        background: #fef2f2;
        color: #b91c1c;
    }

    .icon-btn.del:hover {
        background: #fee2e2;
    }

    /* Empty */
    .empty {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty .ring {
        width: 64px;
        height: 64px;
        border-radius: 9999px;
        background: var(--green-pale);
        color: var(--green-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    /* Animations */
    @keyframes rise {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim {
        animation: rise .45s cubic-bezier(.22, 1, .36, 1) both;
    }

    .d1 {
        animation-delay: .04s
    }

    .d2 {
        animation-delay: .08s
    }

    .d3 {
        animation-delay: .12s
    }

    .d4 {
        animation-delay: .16s
    }

    .d5 {
        animation-delay: .20s
    }

    .d6 {
        animation-delay: .24s
    }
</style>
