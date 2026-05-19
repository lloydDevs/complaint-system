<x-guest-layout>

    <div class="auth-container">
        <div style="position: relative; z-index: 1; width: 100%; max-width: 460px;">

            <div class="login-card">
                <div class="brand-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <h1 class="login-title">Secure Portal</h1>
                <p class="login-subtitle">Sign in to access your dashboard</p>

                <x-auth-session-status class="mb-4 text-sm font-medium text-emerald-600 text-center"
                    :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="custom-label">{{ __('Email Address') }}</label>
                        <input id="email" class="custom-input" type="email" name="email"
                            value="{{ old('email') }}" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500 list-none" />
                    </div>

                    <div class="form-group">
                        <label for="password" class="custom-label">{{ __('Password') }}</label>
                        <input id="password" class="custom-input" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500 list-none" />
                    </div>

                    <div class="flex-actions">
                        <label for="remember_me" class="remember-wrapper">
                            <input id="remember_me" type="checkbox"
                                class="remember-checkbox rounded border-gray-300 text-emerald-700 shadow-sm focus:ring-emerald-500"
                                name="remember">
                            <span class="remember-text">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Authenticate') }}
                    </button>
                </form>
            </div>

            <p class="auth-footer">Protected Console Layer &bull; Identity Shield</p>
        </div>
    </div>
</x-guest-layout>
