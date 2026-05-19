<x-guest-layout>

    <div class="da-error">
        <div style="position: relative; z-index: 1; width: 100%; max-width: 520px;">
            <div class="err-card">
                <div class="err-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4M12 16h.01" />
                    </svg>
                </div>

                <h1 class="err-code">403</h1>
                <h2 class="err-title">Access Forbidden</h2>
                <p class="err-msg">
                    You don't have permission to access this resource.
                    If you believe this is an error, please contact the system administrator.
                </p>

                <div class="err-actions">
                    <button type="button" class="btn-secondary" onclick="window.history.back()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7" />
                        </svg>
                        Go Back
                    </button>
                    <a href="{{ url('/') }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10" />
                        </svg>
                        Go Home
                    </a>
                </div>
            </div>

            <p class="err-footer">Anonymity Protected by Identity Shield</p>
        </div>
    </div>
</x-guest-layout>
