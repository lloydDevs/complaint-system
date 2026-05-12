<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-red-600 dark:text-red-400 tracking-tight">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before proceeding, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 bg-red-600 hover:bg-red-700 dark:bg-red-500/10 dark:hover:bg-red-500/20 dark:text-red-400 dark:border dark:border-red-500/20 font-bold rounded-xl transition-all shadow-lg shadow-red-500/10 active:scale-95">
        {{ __('Delete Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white dark:bg-gray-900 rounded-3xl">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                {{ __('Are you sure?') }}
            </h2>

            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                {{ __('This action cannot be undone. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-8 space-y-2">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password"
                    class="block w-full bg-gray-50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 focus:ring-red-500 dark:focus:ring-red-600 rounded-xl transition-all"
                    placeholder="{{ __('Confirm Password to Proceed') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="px-6 py-3 border-gray-200 dark:border-gray-700 dark:text-gray-300 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button
                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-500/20 transition-all active:scale-95">
                    {{ __('Permanently Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
