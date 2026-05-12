<x-app-layout>
    <div class="py-12 bg-[#F9FAFB] dark:bg-[#0B0F1A] min-h-screen antialiased transition-colors duration-300">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10">
                <a href="{{ route('admin.dashboard') }}"
                    class="group inline-flex items-center text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest hover:text-indigo-500 transition-colors">
                    <svg class="w-3 h-3 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Console
                </a>
                <div class="mt-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                        {{ __('Account Settings') }}
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Manage your personal information, security credentials, and account status.
                    </p>
                </div>
            </div>

            <div class="space-y-8">
                <div
                    class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-6 sm:p-10 rounded-3xl shadow-sm transition-all">
                    <div class="max-w-xl">
                        <div class="mb-6">
                            <h3
                                class="text-lg font-bold text-gray-800 dark:text-gray-200 uppercase tracking-tight text-[12px]">
                                Basic Information</h3>
                            <p class="text-xs text-gray-500 mt-1">Update your account's profile information and email
                                address.</p>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 p-6 sm:p-10 rounded-3xl shadow-sm transition-all">
                    <div class="max-w-xl">
                        <div class="mb-6">
                            <h3
                                class="text-lg font-bold text-gray-800 dark:text-gray-200 uppercase tracking-tight text-[12px]">
                                Security & Authentication</h3>
                            <p class="text-xs text-gray-500 mt-1">Ensure your account is using a long, random password
                                to stay secure.</p>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div
                    class="relative overflow-hidden bg-white dark:bg-gray-900 border border-red-50 dark:border-red-900/20 p-6 sm:p-10 rounded-3xl shadow-sm transition-all">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 blur-3xl rounded-full -mr-16 -mt-16">
                    </div>

                    <div class="max-w-xl relative">
                        <div class="mb-6">
                            <h3
                                class="text-lg font-bold text-red-600 dark:text-red-400 uppercase tracking-tight text-[12px]">
                                Danger Zone</h3>
                            <p class="text-xs text-gray-500 mt-1">Once your account is deleted, all of its resources and
                                data will be permanently deleted.</p>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
