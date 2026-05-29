<x-guest-layout>

    <div class="da-error">
        <div style="position: relative; z-index: 1; width: 100%; max-width: 520px;">
            <div class="err-card">
                <div class="err-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 2v6h6" />
                        <circle cx="11.5" cy="14.5" r="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m13.5 16.5 2 2" />
                    </svg>
                </div>

                <h1 class="err-code">404</h1>
                <h2 class="err-title">Page Not Found</h2>
                <p class="err-msg">
                    The page you're looking for doesn't exist or has been moved.
                    Please check the URL or return to the previous page.
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
