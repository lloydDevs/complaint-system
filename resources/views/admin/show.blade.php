<x-app-layout>
    <div
        class="flex items-center justify-center py-12 px-4 bg-[#F9FAFB] dark:bg-[#0B0F1A] min-h-screen antialiased transition-colors duration-300">
        <div class="w-full max-w-xl">

            <div class="mb-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center text-xs font-semibold text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition group uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5 mr-1.5 transform group-hover:-translate-x-1 transition" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Back to Console
                </a>
            </div>

            <div class="mb-8 border-b border-gray-100 dark:border-gray-800 pb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                            Ticket: {{ $complaint->code }}
                        </h1>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            Status: <span
                                class="font-bold uppercase text-indigo-600 dark:text-indigo-400">{{ $complaint->status }}</span>
                            • Received {{ $complaint->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 px-3 py-1 rounded-full">
                        <span
                            class="text-[9px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter">Official
                            Inquiry</span>
                    </div>
                </div>
            </div>

            <div class="space-y-10">
                <section>
                    <h3 class="text-[10px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-widest mb-3">
                        Target Details</h3>
                    <div
                        class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter mb-1">Government
                                    Agency</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $complaint->agency }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter mb-1">Office /
                                    Branch</p>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $complaint->department }}</p>
                            </div>
                        </div>

                        @if ($complaint->respondent_name)
                            <div class="pt-3 border-t border-gray-50 dark:border-gray-800/50">
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter mb-1">Respondent
                                    Person-of-Interest</p>
                                <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $complaint->respondent_name }}
                                    <span class="text-gray-400 mx-2">—</span>
                                    <span
                                        class="text-xs italic text-gray-500">{{ $complaint->respondent_position ?? 'No Position Stated' }}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </section>

                <section>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-[10px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-widest">
                            Inquiry Statement</h3>
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase italic">Subject:
                            {{ $complaint->title }}</span>
                    </div>
                    <div
                        class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 shadow-sm min-h-[150px]">
                        {{ $complaint->description }}
                    </div>
                </section>

                <section>
                    <h3 class="text-[10px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-widest mb-3">
                        Final Resolution</h3>
                    <form action="{{ route('admin.update', $complaint) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div class="relative group">
                            <textarea name="admin_response" rows="5" required
                                class="w-full bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-800 dark:text-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm placeholder-gray-300 dark:placeholder-gray-700 transition-all resize-none p-5"
                                placeholder="Type the resolution here...">{{ old('admin_response', $complaint->admin_response) }}</textarea>

                            <div
                                class="absolute bottom-4 right-4 opacity-10 group-focus-within:opacity-30 transition-opacity">
                                <svg class="w-8 h-8 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M21 15h2v2h-2v-2zm0-4h2v2h-2v-2zm0-8h2v2h-2V3zm-4 0h2v2h-2V3zm2 14h2v2h-2v-2zM3 3h2v2H3V3zm0 4h2v2H3V7zm0 8h2v2H3v-2zm0-4h2v2H3v-2zm0 8h2v2H3v-2zm4 0h2v2H7v-2zm8 0h2v2h-2v-2zm-4 0h2v2h-2v-2zm0-16h2v2h-2V3z" />
                                </svg>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between gap-4 bg-gray-50 dark:bg-gray-900/20 p-4 rounded-xl border border-gray-100 dark:border-gray-800/50">
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 leading-tight max-w-[250px]">
                                <span class="text-indigo-500 font-bold uppercase">Note:</span>
                                Submitting this response will mark the ticket as <span
                                    class="text-emerald-500 font-bold">RESOLVED</span> and notify the user.
                            </p>
                            <button type="submit"
                                class="shrink-0 inline-flex items-center px-6 py-3 bg-gray-900 dark:bg-indigo-600 hover:bg-indigo-500 text-white text-[11px] font-black rounded-xl transition-all shadow-lg shadow-indigo-500/10 active:scale-95 uppercase tracking-widest">
                                Send Response
                                <svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </section>
            </div>

        </div>
    </div>
</x-app-layout>
