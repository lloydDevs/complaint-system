<!-- Include Alpine.js if it's not in your main layout -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<header x-data="{ open: false }"
    class="sticky top-0 z-50 bg-white  border-b border-gray-100 transition-colors duration-300">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-3 flex items-center justify-between gap-4">

        <!-- Brand / Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0">
            <img src="{{ asset('logo/damimaropa-logo.jpg') }}" alt="DA Seal"
                class="h-10 w-10 sm:h-12 sm:w-12 object-contain" />
            <div class="leading-tight">
                <div class="text-lg sm:text-2xl font-extrabold text-emerald-700 dark:text-emerald-500 tracking-tight">
                    DA-CARE</div>
                <div class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 hidden md:block">
                    Complaints, Accountability, &<br />Resolution for Everyone
                </div>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center gap-8 text-[15px] font-medium text-gray-700 dark:text-gray-300">
            @php
                $links = [
                    ['Home', '/'],
                    ['Submit a Complaint', '/newcomplaint'],
                    ['Track My Complaint', '/trackrecord'],
                    ['About DA-CARE', '/about'],
                ];
            @endphp
            @foreach ($links as [$label, $href])
                @php $active = request()->is(trim($href, '/') ?: '/'); @endphp
                <a href="{{ url($href) }}"
                    class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors {{ $active ? 'text-emerald-700 dark:text-emerald-500 font-semibold border-b-2 border-emerald-700 dark:border-emerald-500 pb-1' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2 sm:gap-4">
            {{-- <!-- Theme Toggle -->
            <div
                class="flex items-center gap-1 bg-gray-50 dark:bg-gray-900 p-1 rounded-xl border border-gray-100 dark:border-gray-800">
                <button @click="setTheme('light')"
                    class="p-1.5 rounded-lg hover:bg-white dark:hover:bg-gray-800 text-gray-400 hover:text-emerald-500 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"
                            stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
                <button @click="setTheme('dark')"
                    class="p-1.5 rounded-lg hover:bg-white dark:hover:bg-gray-800 text-gray-400 hover:text-emerald-500 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                            stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </div> --}}

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="hidden sm:inline-flex bg-emerald-700 hover:bg-emerald-800 text-white items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-sm">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Go to Dashboard
                    </a>
                @endauth

                @guest
                    <a href="{{ url('/login') }}"
                        class="hidden sm:inline-flex bg-emerald-700 hover:bg-emerald-800 text-white items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-sm">
                        <i data-lucide="log-in" class="w-4 h-4"></i> Login
                    </a>
                @endguest

                <button @click="open = !open"
                    class="lg:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors focus:outline-none">
                    <svg x-show="!open" class="w-6 h-6 text-emerald-700 dark:text-emerald-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                    <svg x-show="open" x-cloak class="w-6 h-6 text-emerald-700 dark:text-emerald-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <nav x-show="open" x-cloak @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-[#0B0F1A] px-4 py-3 space-y-1 shadow-xl">
        @foreach ($links as [$label, $href])
            <a href="{{ url($href) }}"
                class="block px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                {{ $label }}
            </a>
        @endforeach
        <a href="{{ url('/login') }}"
            class="block sm:hidden mt-4 text-center bg-emerald-700 text-white px-4 py-3 rounded-md font-bold shadow-md">Login</a>
    </nav>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</header>
