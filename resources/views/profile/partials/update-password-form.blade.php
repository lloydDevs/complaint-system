<section>
    <header class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-7">
        @csrf
        @method('put')

        <div class="space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Current Password')"
                class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400" />

            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-xl transition-all"
                autocomplete="current-password" />

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password" :value="__('New Password')"
                class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400" />

            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-xl transition-all"
                autocomplete="new-password" />

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')"
                class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400" />

            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-xl transition-all"
                autocomplete="new-password" />

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button
                class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-400 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center text-sm font-bold text-green-600 dark:text-green-400">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Security updated') }}
                </div>
            @endif
        </div>
    </form>
</section>
