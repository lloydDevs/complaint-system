<x-app-layout>
    <div class="py-12 bg-[#F9FAFB] dark:bg-[#0B0F1A] min-h-screen antialiased transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 tracking-tight">Management Console
                    </h1>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Overview of system-wide user inquiries.</p>
                </div>

                <div class="text-right">
                    <span
                        class="text-[10px] font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-[0.2em]">Live
                        Status</span>
                </div>
                <a href="{{ route('admin.analytics') }}"
                    class="inline-flex items-center gap-2 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 px-4 py-2 rounded-xl text-[11px] font-bold text-gray-600 dark:text-gray-400 hover:text-indigo-500 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    VIEW ANALYTICS
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-6 rounded-2xl shadow-sm">
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                        Total
                        Influx</p>
                    <p class="text-3xl font-light text-gray-900 dark:text-gray-100">{{ $data['total'] }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-6 rounded-2xl shadow-sm">
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                        Awaiting Action</p>
                    <p class="text-3xl font-light text-amber-600 dark:text-amber-500">{{ $data['pending'] }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-6 rounded-2xl shadow-sm">
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                        Under Review</p>
                    <p class="text-3xl font-light text-indigo-600 dark:text-indigo-400">{{ $data['viewed'] }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-6 rounded-2xl shadow-sm">
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                        Resolved Cases</p>
                    <p class="text-3xl font-light text-emerald-600 dark:text-emerald-500">{{ $data['resolved'] }}</p>
                </div>
            </div>

            <div
                class="mb-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-4 rounded-2xl shadow-sm">
                <form action="{{ route('admin.dashboard') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                    <div class="md:col-span-1">
                        <label
                            class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Code..."
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-xs text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500 pl-8">
                            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label
                            class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Status</label>
                        <select name="status"
                            class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-xs text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="viewed" {{ request('status') == 'viewed' ? 'selected' : '' }}>Viewed</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Month</label>
                        <select name="month"
                            class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-xs text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Months</option>
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Year</label>
                        <select name="year"
                            class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-xs text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500">
                            @foreach (range(date('Y'), 2024) as $y)
                                <option value="{{ $y }}"
                                    {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">Agency</label>
                        <select name="agency"
                            class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-lg text-xs text-gray-600 dark:text-gray-300 focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer">
                            <option value="">All Agencies</option>
                            @foreach ($agencies as $agency)
                                <option value="{{ $agency }}"
                                    {{ request('agency') == $agency ? 'selected' : '' }}>{{ $agency }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white text-[10px] font-bold py-2.5 rounded-lg transition-all uppercase tracking-widest">Filter</button>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex-1 bg-gray-100 dark:bg-gray-800 text-gray-500 text-[10px] font-bold py-2.5 rounded-lg transition-all uppercase tracking-widest text-center">Reset</a>
                    </div>
                </form>
            </div>

            <div
                class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm">
                <div
                    class="px-6 py-5 border-b border-gray-50 dark:border-gray-800 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 bg-white dark:bg-gray-900">
                    <!-- Title Section -->
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-black text-gray-800 dark:text-gray-200 uppercase tracking-widest">
                            Control Console
                        </h3>
                    </div>

                    <!-- Quick Action Filters -->
                    <div class="flex flex-wrap items-center gap-3">

                        <!-- HIGH URGENCY: NEEDS ATTENTION -->
                        <a href="{{ route('admin.dashboard', ['status' => 'pending']) }}"
                            class="group relative flex items-center gap-2.5 bg-red-600 px-4 py-2 rounded-xl transition-all active:scale-95 shadow-[0_0_15px_rgba(220,38,38,0.5)] animate-pulse">

                            <div class="flex items-center gap-2">
                                <span class="relative flex h-2.5 w-2.5">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
                                </span>
                                <span class="text-[10px] font-black text-white uppercase tracking-tighter">Needs
                                    Attention</span>
                            </div>

                            <div
                                class="bg-white text-red-600 text-[11px] font-black px-2 py-0.5 rounded-lg shadow-inner">
                                {{ $data['pending'] }}
                            </div>

                            <!-- Urgent Tooltip (Optional visual flare) -->
                            <span
                                class="absolute -top-2 -right-1 bg-black text-[8px] text-white font-bold px-1.5 py-0.5 rounded shadow-lg border border-red-500 animate-bounce">
                                URGENT
                            </span>
                        </a>

                        <!-- Viewed (Neutral) -->
                        <a href="{{ route('admin.dashboard', ['status' => 'viewed']) }}"
                            class="group flex items-center gap-2.5 bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/30 px-3 py-2 rounded-xl transition-all hover:bg-indigo-100 dark:hover:bg-indigo-900/20 active:scale-95">
                            <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                            <span
                                class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Viewed</span>
                            <div class="bg-indigo-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-md">
                                {{ $data['viewed'] }}
                            </div>
                        </a>

                        <!-- Resolved (Completed) -->
                        <a href="{{ route('admin.dashboard', ['status' => 'resolved']) }}"
                            class="group flex items-center gap-2.5 bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-100 dark:border-emerald-900/30 px-3 py-2 rounded-xl transition-all hover:bg-emerald-100 dark:hover:bg-emerald-900/20 active:scale-95">
                            <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span
                                class="text-[10px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Resolved</span>
                            <div class="bg-emerald-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-md">
                                {{ $data['resolved'] }}
                            </div>
                        </a>

                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-gray-800/50">
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                                    Ticket / Agency</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                                    Subject</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                                    Target Office</th>
                                <th
                                    class="px-6 py-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @forelse ($complaints as $complaint)
                                <tr
                                    class="group hover:bg-gray-50/80 dark:hover:bg-gray-800/40 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="text-[10px] font-mono font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded w-fit uppercase">{{ $complaint->code }}</span>
                                            <span
                                                class="text-xs font-bold text-gray-700 dark:text-gray-300 truncate max-w-[150px]">{{ $complaint->agency }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm text-gray-600 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors truncate max-w-[200px]">{{ $complaint->title }}</span>
                                            <span
                                                class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-tighter">Submitted
                                                {{ $complaint->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col text-xs">
                                            <span
                                                class="text-gray-600 dark:text-gray-400">{{ $complaint->department }}</span>
                                            @if ($complaint->respondent_name)
                                                <span class="text-[10px] text-indigo-500 font-medium">Attn:
                                                    {{ $complaint->respondent_name }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @php
                                                $dotColor = match ($complaint->status) {
                                                    'pending' => 'bg-amber-400',
                                                    'viewed' => 'bg-indigo-400',
                                                    'resolved' => 'bg-emerald-400',
                                                    default => 'bg-gray-400',
                                                };
                                                $textColor = match ($complaint->status) {
                                                    'pending' => 'text-amber-700 dark:text-amber-500',
                                                    'viewed' => 'text-indigo-700 dark:text-indigo-500',
                                                    'resolved' => 'text-emerald-700 dark:text-emerald-500',
                                                    default => 'text-gray-500',
                                                };
                                            @endphp
                                            <span
                                                class="inline-block w-2 h-2 rounded-full mr-2 {{ $dotColor }}"></span>
                                            <span
                                                class="text-[10px] font-bold uppercase tracking-widest {{ $textColor }}">
                                                {{ $complaint->status }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.show', $complaint) }}"
                                            class="inline-flex items-center text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors duration-200">
                                            REVIEW
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-12 text-center text-gray-400 dark:text-gray-600 text-xs italic">
                                        No inquiries match the current filters.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                    <div
                        class="px-6 py-4 bg-gray-50/30 dark:bg-gray-800/20 border-t border-gray-100 dark:border-gray-800">
                        {{ $complaints->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
