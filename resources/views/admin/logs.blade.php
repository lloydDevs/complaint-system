<x-app-layout>

    @section('content')
        <div class="p-6 max-w-7xl mx-auto space-y-6" x-data="{ confirmingClear: false }">

            <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 dark:border-gray-800 pb-5">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">System Activity Logs
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Monitor security events, internal workplace grievance routing, and user sessions for DA RFO
                        MIMAROPA.
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-[#0B0F1A] rounded-xl border border-gray-100 dark:border-gray-800 p-4 shadow-sm">
                <form action="{{ url('admin/logs') }}" method="GET"
                    class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
                    <div class="flex flex-1 flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i data-lucide="search" class="w-4 h-4"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search users, actions, keywords..."
                                class="w-full pl-9 pr-4 py-2 border border-gray-200 dark:border-gray-700 bg-transparent rounded-lg text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition">
                        </div>

                        <div class="w-full sm:w-48">
                            <select name="action_type" onchange="this.form.submit()"
                                class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0B0F1A] text-gray-900 dark:text-white rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition">
                                <option value="">All Actions</option>
                                @foreach ($distinctActions as $action)
                                    <option value="{{ $action }}"
                                        {{ request('action_type') == $action ? 'selected' : '' }}>
                                        {{ $action }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if (request()->filled('search') || request()->filled('action_type'))
                        <a href="{{ url('admin/logs') }}"
                            class="inline-flex justify-center items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition">
                            Reset Filters
                        </a>
                    @endif
                </form>
            </div>

            <div
                class="bg-white dark:bg-[#0B0F1A] rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50/70 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <th class="px-6 py-3.5">User Details</th>
                                <th class="px-6 py-3.5">Action Type</th>
                                <th class="px-6 py-3.5">Log Details</th>
                                <th class="px-6 py-3.5">Network Identity</th>
                                <th class="px-6 py-3.5">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody
                            class="divide-y divide-gray-100 dark:divide-gray-800 text-sm text-gray-700 dark:text-gray-300">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-900/20 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        @if ($log->user)
                                            <div class="flex flex-col">
                                                <span>{{ $log->user->name }}</span>
                                                <span
                                                    class="text-xs font-normal text-gray-400">{{ $log->user->email }}</span>
                                            </div>
                                        @else
                                            <span
                                                class="text-gray-400 dark:text-gray-500 italic">{{ $log->user_name ?? 'System Event' }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            // Using strtolower to ensure safe mapping regardless of string case
                                            $badgeClasses = match (strtolower($log->action)) {
                                                // --- Session Management ---
                                                'login'
                                                    => 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 border border-blue-200 dark:border-blue-800/30',

                                                'logout'
                                                    => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800/30',

                                                'failed login'
                                                    => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400 font-bold border border-red-300 dark:border-red-800',
                                                // --- View & Analytics Events (Read Only) ---
                                                'view analytics'
                                                    => 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400 border border-amber-200 dark:border-amber-800/30',

                                                'view dashboard index'
                                                    => 'bg-purple-50 text-purple-700 dark:bg-purple-900/20 dark:text-purple-400 border border-purple-200 dark:border-purple-800/30',

                                                'view complaint'
                                                    => 'bg-cyan-50 text-cyan-700 dark:bg-cyan-900/20 dark:text-cyan-400 border border-cyan-200 dark:border-cyan-800/30',
                                                // --- Lifecycle Transitions & Pipeline Actions ---
                                                'open new complaint'
                                                    => 'bg-sky-50 text-sky-700 dark:bg-sky-900/20 dark:text-sky-400 border border-sky-200 dark:border-sky-800/30',

                                                'status update',
                                                'resolve complaint',
                                                'resolved'
                                                    => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/30',
                                                // --- Dangerous, Destructive, or High-Alert Actions ---
                                                'delete',
                                                'retaliation warning'
                                                    => 'bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400 border border-rose-200 dark:border-rose-800/30',
                                                // --- Fallback State Control ---
                                                default
                                                    => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700',
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold uppercase tracking-wide {{ $badgeClasses }}">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 max-w-sm font-normal text-gray-600 dark:text-gray-400 break-words">
                                        {{ $log->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-mono text-gray-400">
                                        <div class="flex flex-col">
                                            <span>IP: {{ $log->ip_address ?? 'N/A' }}</span>
                                            <span class="max-w-[150px] truncate" title="{{ $log->user_agent }}">UA:
                                                {{ $log->user_agent }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                        {{ $log->created_at->format('M d, Y • h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 dark:text-gray-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <i data-lucide="database-backup"
                                                class="w-8 h-8 text-gray-300 dark:text-gray-700"></i>
                                            <span>No system activity logs found matching current parameters.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($logs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/20">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </x-app-layout>
