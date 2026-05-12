<section>
    <header class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-7">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <x-input-label for="name" :value="__('Full Name')"
                class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400" />

            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-xl transition-all"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email Address')"
                class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400" />

            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-xl transition-all"
                :value="old('email', $user->email)" required autocomplete="username" />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div
                    class="mt-4 p-4 rounded-2xl bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20">
                    <p class="text-sm text-amber-800 dark:text-amber-400 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button form="send-verification"
                        class="mt-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 underline underline-offset-4 decoration-2 transition-all">
                        {{ __('Re-send verification email') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p
                            class="mt-2 font-semibold text-xs text-green-600 dark:text-green-400 uppercase tracking-wide">
                            {{ __('Verification link sent.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button
                class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                {{ __('Update Profile') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center text-sm font-bold text-green-600 dark:text-green-400">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Saved') }}
                </div>
            @endif
        </div>
    </form>
</section>
