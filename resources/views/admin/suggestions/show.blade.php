<x-app-layout>
    <div class="sugg-page min-h-screen" style="background:var(--surface);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- ── BREADCRUMB ── --}}
            <div class="flex items-center gap-2 text-xs text-gray-400 mb-6 anim">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-green-700 transition">Dashboard</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <a href="{{ route('admin.suggestions.index') }}" class="hover:text-green-700 transition">Suggestions</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-gray-600 font-medium">#{{ $suggestion->id }}</span>
            </div>

            {{-- ── PAGE HEADER ── --}}
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-7 anim">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center gap-3"
                        style="font-family:'DM Serif Display',serif;">
                        Suggestion
                        <span class="text-base font-normal text-gray-400 font-sans">#{{ $suggestion->id }}</span>
                    </h1>
                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <span class="pill-{{ $suggestion->status }} text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $suggestion->status_label }}
                        </span>
                        <span class="text-xs text-gray-400">
                            Received {{ $suggestion->created_at->format('M d, Y \a\t g:i A') }}
                            · {{ $suggestion->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('admin.suggestions.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:border-green-400 hover:text-green-700 rounded-full px-4 py-2 transition shadow-sm whitespace-nowrap">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to list
                </a>
            </div>

            {{-- ── FLASH ── --}}
            @if (session('success'))
                <div
                    class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-green-800 text-sm anim">
                    <i data-lucide="check-circle-2" class="w-4 h-4 shrink-0 text-green-600"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-6">

                {{-- ══════════════════════════════════════
                 LEFT COL — submission detail
            ══════════════════════════════════════ --}}
                <div class="lg:col-span-2 space-y-5">

                    {{-- Submitter info --}}
                    <div class="detail-card anim anim-d1">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                            <i data-lucide="user-circle-2" class="w-4 h-4 text-green-600"></i>
                            <h2 class="text-sm font-semibold text-gray-700">Submitter Information</h2>
                        </div>
                        <div class="px-6 py-5 grid sm:grid-cols-2 gap-5">
                            {{-- Name --}}
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Full Name</p>
                                @if ($suggestion->name)
                                    <p class="text-sm font-semibold text-gray-800">{{ $suggestion->name }}</p>
                                @else
                                    <p class="text-sm text-gray-400 italic flex items-center gap-1">
                                        <i data-lucide="minus" class="w-3.5 h-3.5"></i> Not provided
                                    </p>
                                @endif
                            </div>
                            {{-- Designation --}}
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Designation /
                                    Role</p>
                                @if ($suggestion->designation)
                                    <p class="text-sm font-semibold text-gray-800">{{ $suggestion->designation }}</p>
                                @else
                                    <p class="text-sm text-gray-400 italic flex items-center gap-1">
                                        <i data-lucide="minus" class="w-3.5 h-3.5"></i> Not provided
                                    </p>
                                @endif
                            </div>
                            {{-- Category --}}
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Category</p>
                                <span
                                    class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-full px-3 py-1">
                                    <i data-lucide="tag" class="w-3 h-3"></i>
                                    {{ $suggestion->category_label }}
                                </span>
                            </div>
                            {{-- Submitted --}}
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Submitted</p>
                                <p class="text-sm text-gray-800">{{ $suggestion->created_at->format('F d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $suggestion->created_at->format('g:i A') }} ·
                                    {{ $suggestion->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Suggestion body --}}
                    <div class="detail-card anim anim-d2">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                            <i data-lucide="message-square-text" class="w-4 h-4 text-green-600"></i>
                            <h2 class="text-sm font-semibold text-gray-700">Suggestion / Recommendation</h2>
                            <span class="ml-auto text-xs text-gray-400">{{ str_word_count($suggestion->suggestion) }}
                                words</span>
                        </div>
                        <div class="px-6 py-5">
                            <div class="sugg-body">{{ $suggestion->suggestion }}</div>
                        </div>
                    </div>

                    {{-- Admin notes (read-only display if already set) --}}
                    @if ($suggestion->admin_notes)
                        <div class="detail-card anim anim-d3">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                                <i data-lucide="notebook-pen" class="w-4 h-4 text-amber-500"></i>
                                <h2 class="text-sm font-semibold text-gray-700">Admin Notes</h2>
                            </div>
                            <div class="px-6 py-5">
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">
                                    {{ $suggestion->admin_notes }}</p>
                                @if ($suggestion->reviewer)
                                    <p class="mt-3 text-xs text-gray-400 flex items-center gap-1.5">
                                        <i data-lucide="user-check" class="w-3.5 h-3.5"></i>
                                        Reviewed by <strong
                                            class="text-gray-600">{{ $suggestion->reviewer->name }}</strong>
                                        on {{ $suggestion->reviewed_at->format('M d, Y g:i A') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Metadata timeline --}}
                    <div class="detail-card anim anim-d3">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                            <i data-lucide="activity" class="w-4 h-4 text-green-600"></i>
                            <h2 class="text-sm font-semibold text-gray-700">Timeline</h2>
                        </div>
                        <div class="px-6 py-5 space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="tl-dot">
                                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Suggestion submitted</p>
                                    <p class="text-xs text-gray-400">
                                        {{ $suggestion->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>

                            @if ($suggestion->reviewed_at)
                                <div class="flex items-start gap-3">
                                    <div class="tl-dot" style="background:#e0e7ff;color:#3730a3;">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">
                                            Status changed to <strong>{{ $suggestion->status_label }}</strong>
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $suggestion->reviewed_at->format('M d, Y \a\t g:i A') }}
                                            @if ($suggestion->reviewer)
                                                · by {{ $suggestion->reviewer->name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>{{-- /left col --}}

                {{-- ══════════════════════════════════════
                 RIGHT COL — update action panel
            ══════════════════════════════════════ --}}
                <div class="space-y-5">

                    {{-- Update status form --}}
                    <div class="detail-card anim anim-d2 sticky top-6">
                        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2"
                            style="background:linear-gradient(135deg,#f0f9f3,#fff);">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                                style="background:var(--green-pale);">
                                <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5 text-green-700"></i>
                            </div>
                            <h2 class="text-sm font-semibold text-gray-800">Update Status</h2>
                        </div>

                        <form method="POST" action="{{ route('admin.suggestions.update', $suggestion) }}"
                            class="px-5 py-5">
                            @csrf
                            @method('PUT')

                            {{-- Status radio group --}}
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                Set Status
                            </p>
                            <div class="space-y-2 mb-5">
                                @php
                                    $statusIcons = [
                                        'pending' => 'clock',
                                        'under_review' => 'eye',
                                        'acknowledged' => 'thumbs-up',
                                        'implemented' => 'check-circle-2',
                                        'declined' => 'x-circle',
                                    ];
                                @endphp
                                @foreach ($statuses as $val => $label)
                                    <div class="status-option">
                                        <input type="radio" id="status_{{ $val }}" name="status"
                                            value="{{ $val }}"
                                            {{ $suggestion->status === $val ? 'checked' : '' }}>
                                        <label for="status_{{ $val }}">
                                            <i data-lucide="{{ $statusIcons[$val] ?? 'circle' }}"
                                                class="w-3.5 h-3.5"></i>
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @error('status')
                                <p class="text-xs text-red-500 mb-3">{{ $message }}</p>
                            @enderror

                            {{-- Admin notes --}}
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Admin Notes <span class="normal-case font-normal text-gray-400">(optional)</span>
                            </p>
                            <textarea name="admin_notes" rows="4"
                                placeholder="Add internal notes, follow-up actions, or reasoning for status change…"
                                class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-green-400 bg-gray-50 placeholder-gray-400 resize-none transition">{{ old('admin_notes', $suggestion->admin_notes) }}</textarea>
                            @error('admin_notes')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                            <button type="submit"
                                class="mt-4 w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-white transition shadow-sm hover:opacity-90 active:scale-95"
                                style="background:linear-gradient(135deg,#1f6b3a,#2f9d5a);">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Save Changes
                            </button>
                        </form>

                        {{-- Danger zone --}}
                        <div class="px-5 pb-5">
                            <div class="border-t border-dashed border-gray-200 pt-4">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Danger
                                    Zone
                                </p>
                                <form method="POST" action="{{ route('admin.suggestions.destroy', $suggestion) }}"
                                    onsubmit="return confirm('Permanently remove this suggestion? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        Delete Suggestion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Quick info sidebar --}}
                    <div class="detail-card anim anim-d3">
                        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
                            <i data-lucide="info" class="w-4 h-4 text-gray-400"></i>
                            <h2 class="text-sm font-semibold text-gray-700">Quick Info</h2>
                        </div>
                        <div class="px-5 py-4 space-y-3 text-xs text-gray-500">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">ID</span>
                                <span class="font-mono font-semibold text-gray-700">#{{ $suggestion->id }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Word count</span>
                                <span
                                    class="font-semibold text-gray-700">{{ str_word_count($suggestion->suggestion) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Anonymous</span>
                                <span
                                    class="font-semibold text-gray-700">{{ $suggestion->name ? 'No' : 'Yes' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Has been reviewed</span>
                                <span
                                    class="font-semibold text-gray-700">{{ $suggestion->reviewed_at ? 'Yes' : 'No' }}</span>
                            </div>
                            @if ($suggestion->updated_at->ne($suggestion->created_at))
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Last updated</span>
                                    <span
                                        class="font-semibold text-gray-700">{{ $suggestion->updated_at->diffForHumans() }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>{{-- /right col --}}

            </div>{{-- /grid --}}
        </div>{{-- /max-w --}}
    </div>{{-- /page --}}

</x-app-layout>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap');

    :root {
        --green: #1f6b3a;
        --green-dark: #16532c;
        --green-pale: #e8f3ec;
        --gold: #d4a437;
        --gold-pale: #fbf2dc;
        --surface: #f7faf8;
        --border: #e3ede7;
    }

    .sugg-page {
        font-family: 'DM Sans', system-ui, sans-serif;
    }

    /* Status pills */
    .pill-pending {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .pill-under_review {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .pill-acknowledged {
        background: #e0e7ff;
        color: #3730a3;
        border: 1px solid #c7d2fe;
    }

    .pill-implemented {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .pill-declined {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    /* Content card */
    .detail-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 1.25rem;
        overflow: hidden;
    }

    /* Suggestion body display */
    .sugg-body {
        background: var(--surface);
        border: 1px solid var(--border);
        border-left: 4px solid var(--green);
        border-radius: .75rem;
        padding: 1.25rem 1.5rem;
        line-height: 1.75;
        color: #374151;
        font-size: .9375rem;
        white-space: pre-wrap;
        word-break: break-word;
    }

    /* Status option cards */
    .status-option input[type="radio"] {
        display: none;
    }

    .status-option label {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .65rem 1rem;
        border-radius: .75rem;
        border: 1.5px solid var(--border);
        cursor: pointer;
        font-size: .8125rem;
        font-weight: 500;
        color: #4b5563;
        transition: all .2s ease;
        background: #fff;
    }

    .status-option input:checked+label {
        border-color: var(--green);
        background: var(--green-pale);
        color: var(--green);
        font-weight: 600;
    }

    .status-option label:hover {
        border-color: var(--green);
        color: var(--green);
    }

    /* Timeline dot */
    .tl-dot {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--green-pale);
        color: var(--green);
        flex-shrink: 0;
    }

    /* Animations */
    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim {
        animation: fadeSlideUp .45s cubic-bezier(.22, 1, .36, 1) both;
    }

    .anim-d1 {
        animation-delay: .05s;
    }

    .anim-d2 {
        animation-delay: .12s;
    }

    .anim-d3 {
        animation-delay: .19s;
    }
</style>
