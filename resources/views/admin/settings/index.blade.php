<x-app-layout>
    <div class="py-12 bg-[#FBFBFB] dark:bg-[#0B0F1A] min-h-screen antialiased">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <header class="mb-10">
                <h1 class="text-2xl font-light text-gray-900 dark:text-gray-100 tracking-tight">System Settings</h1>
                <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest font-bold">Manage Administrative Access
                </p>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left: Add Admin Form -->
                <div class="lg:col-span-4">
                    <div
                        class="bg-white dark:bg-gray-900 p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                        <h3
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500 mb-6 flex items-center gap-2">
                            <span class="h-px w-4 bg-emerald-500"></span>
                            New Administrator
                        </h3>

                        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Full
                                    Name</label>
                                <input type="text" name="name" required
                                    class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm py-3 px-4 focus:ring-2 focus:ring-emerald-500/20">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Email
                                    Address</label>
                                <input type="email" name="email" required
                                    class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm py-3 px-4 focus:ring-2 focus:ring-emerald-500/20">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Temporary
                                    Password</label>
                                <input type="password" name="password" required
                                    class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-sm py-3 px-4 focus:ring-2 focus:ring-emerald-500/20">
                            </div>

                            <button type="submit"
                                class="w-full bg-gray-900 dark:bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-black py-4 rounded-xl transition-all uppercase tracking-widest shadow-lg shadow-emerald-900/10">
                                Create Admin Account
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Admin List -->
                <div class="lg:col-span-8">
                    <div
                        class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-50 dark:border-gray-800">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Current Staff
                            </h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 dark:bg-gray-800/30">
                                        <th
                                            class="px-6 py-4 text-[9px] font-black uppercase tracking-widest text-gray-400">
                                            User</th>
                                        <th
                                            class="px-6 py-4 text-[9px] font-black uppercase tracking-widest text-gray-400">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-[9px] font-black uppercase tracking-widest text-gray-400 text-right">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                                    @foreach ($admins as $admin)
                                        <tr
                                            class="group hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="h-8 w-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 font-bold text-xs uppercase">
                                                        {{ substr($admin->name, 0, 2) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">
                                                            {{ $admin->name }}</p>
                                                        <p class="text-[10px] text-gray-400 font-mono">
                                                            {{ $admin->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    // last_activity is a Unix timestamp in the sessions table
                                                    $isActiveSession =
                                                        $admin->session_activity &&
                                                        $admin->session_activity >=
                                                            now()->subMinutes(5)->getTimestamp();
                                                @endphp

                                                <div class="flex items-center gap-2">
                                                    @if ($isActiveSession)
                                                        <span class="relative flex h-2 w-2">
                                                            <span
                                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                            <span
                                                                class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                                        </span>
                                                        <span
                                                            class="text-[10px] font-black uppercase tracking-widest text-emerald-600">
                                                            Active Session
                                                        </span>
                                                    @else
                                                        <div class="h-2 w-2 rounded-full bg-gray-300"></div>
                                                        <span
                                                            class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                                            Offline
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <form action="{{ route('admin.users.destroy', $admin->id) }}"
                                                    method="POST" onsubmit="return confirm('Remove admin access?');">
                                                    @csrf @method('DELETE')
                                                    <button class="text-gray-300 hover:text-red-500 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
