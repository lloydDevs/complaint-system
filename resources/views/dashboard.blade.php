<x-app-layout>
    <div class="py-12 bg-[#FBFBFB] dark:bg-[#0B0F1A] min-h-screen antialiased transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <header class="mb-12">
                <h1 class="text-3xl font-light text-gray-900 dark:text-gray-100 tracking-tight">Support Portal</h1>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Manage your inquiries and track resolutions.</p>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                <div class="lg:col-span-6">
                    <div class="sticky top-8">
                        <h3
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 dark:text-gray-600 mb-6">
                            Create Ticket</h3>

                        <form action="{{ route('complaints.store') }}" method="POST" class="space-y-8">
                            @csrf

                            <div class="space-y-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="h-px w-8 bg-emerald-500"></span>
                                    <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-500">
                                        Agency
                                        Information</h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Government
                                            Agency</label>
                                        <div class="relative">
                                            <select name="agency" required
                                                class="appearance-none w-full bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800 dark:text-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all px-4 py-3 cursor-pointer">

                                                <option value="Department of Agriculture (DA)" selected disabled>
                                                    Department of
                                                    Agriculture MIMAROPA(DA MIMAROPA)</option>

                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                        </div>
                                        @error('agency')
                                            <p class="text-red-500 text-[10px] mt-1 uppercase font-bold">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="block text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Specific
                                            Office / Department</label>
                                        <input type="text" name="department" value="{{ old('department') }}" required
                                            class="w-full bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800 dark:text-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all px-4 py-3 placeholder-gray-300 dark:placeholder-gray-700"
                                            placeholder="e.g., HR Department">
                                        @error('department')
                                            <p class="text-red-500 text-[10px] mt-1 uppercase font-bold">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div
                                class="p-6 bg-gray-50/50 dark:bg-gray-900/40 rounded-2xl border border-gray-100 dark:border-gray-800/50">
                                <div class="flex items-center gap-2 mb-5">
                                    <h3
                                        class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 dark:text-gray-600">
                                        Respondent Details (Optional)</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label
                                            class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase mb-2">Official's
                                            Name</label>
                                        <input type="text" name="respondent_name"
                                            value="{{ old('respondent_name') }}"
                                            class="w-full bg-white/50 dark:bg-gray-900 border-gray-200 dark:border-gray-800 dark:text-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all px-4 py-3"
                                            placeholder="Full name if known">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase mb-2">Designation</label>
                                        <input type="text" name="respondent_position"
                                            value="{{ old('respondent_position') }}"
                                            class="w-full bg-white/50 dark:bg-gray-900 border-gray-200 dark:border-gray-800 dark:text-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all px-4 py-3"
                                            placeholder="e.g., Regional Director">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Subject</label>
                                    <input type="text" name="title" value="{{ old('title') }}" required
                                        class="w-full bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800 dark:text-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all px-4 py-3 placeholder-gray-300 dark:placeholder-gray-700"
                                        placeholder="Brief summary of the issue">
                                    @error('title')
                                        <p class="text-red-500 text-[10px] mt-1 uppercase font-bold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Full
                                        Statement</label>
                                    <textarea name="description" rows="6" required
                                        class="w-full bg-white dark:bg-gray-900 border-gray-100 dark:border-gray-800 dark:text-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all px-4 py-3 placeholder-gray-300 dark:placeholder-gray-700 resize-none"
                                        placeholder="Describe the incident, including dates and specific events...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-[10px] mt-1 uppercase font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full bg-emerald-600 hover:bg-emerald-500 text-white text-[11px] font-black py-5 rounded-xl transition-all duration-300 shadow-lg shadow-emerald-500/20 active:scale-[0.98] uppercase tracking-[0.4em]">
                                    Submit Official Complaint
                                </button>
                                <p
                                    class="text-center text-[10px] text-gray-400 mt-4 uppercase tracking-widest font-medium">
                                    This inquiry will be logged as an official record.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-6">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 dark:text-gray-600 mb-6">
                        Recent Activity
                    </h3>

                    <div class="space-y-8">
                        @forelse($complaints as $complaint)
                            <div
                                class="group relative bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-8 hover:border-emerald-100 dark:hover:border-emerald-900 transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="text-[10px] font-mono font-bold text-emerald-500 bg-emerald-50 dark:bg-emerald-950/30 px-2 py-0.5 rounded">
                                                #{{ $complaint->code }}
                                            </span>
                                            <h4
                                                class="text-lg font-semibold text-gray-900 dark:text-gray-100 tracking-tight">
                                                {{ $complaint->title }}
                                            </h4>
                                        </div>
                                        <p class="text-[11px] text-gray-400 dark:text-gray-500 font-medium italic">
                                            Submitted on {{ $complaint->created_at->format('M d, Y • h:i A') }}
                                        </p>
                                    </div>

                                    {{-- Dynamic Status Pill --}}
                                    @php
                                        $statusClasses = match ($complaint->status) {
                                            'pending'
                                                => 'bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-500 border-amber-100 dark:border-amber-900/50',
                                            'viewed'
                                                => 'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-500 border-emerald-100 dark:border-emerald-900/50',
                                            'resolved'
                                                => 'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-500 border-emerald-100 dark:border-emerald-900/50',
                                            default => 'bg-gray-50 text-gray-600 border-gray-100',
                                        };
                                    @endphp

                                    <span
                                        class="px-2.5 py-1 rounded-md text-[10px] font-black tracking-widest uppercase border {{ $statusClasses }}">
                                        {{ $complaint->status }}
                                    </span>
                                </div>

                                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-6">
                                    {{ $complaint->description }}
                                </p>

                                @if ($complaint->admin_response)
                                    <div
                                        class="bg-[#F9FAFB] dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800 rounded-xl p-6 relative overflow-hidden">
                                        <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500"></div>
                                        <div class="flex items-center gap-2 mb-3">
                                            <span
                                                class="text-[10px] font-black text-emerald-900 dark:text-emerald-300 uppercase tracking-tighter">
                                                Official Response
                                            </span>
                                        </div>
                                        <p
                                            class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed font-serif italic">
                                            "{{ $complaint->admin_response }}"
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div
                                class="text-center py-32 bg-white dark:bg-gray-900 rounded-3xl border border-dashed border-gray-200 dark:border-gray-800">
                                <p
                                    class="text-xs font-bold text-gray-300 dark:text-gray-700 uppercase tracking-[0.3em]">
                                    No tickets found
                                </p>
                            </div>
                        @endforelse
                    </div>
                    {{-- Pagination Section --}}
                    @if ($complaints->hasPages())
                        <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-800">
                            <div class="custom-pagination">
                                {{ $complaints->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
