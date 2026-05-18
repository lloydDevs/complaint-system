<x-guest-layout>

    @php
        $activeComplaint = $complaint ?? session('complaint');
    @endphp

    @if (session('complaint_code'))
        <x-complaint-ticket :code="session('complaint_code')" />
    @endif

    <style>
        :root {
            --da-green: #1f6b3a;
            --da-green-dark: #154d29;
            --da-green-light: #2e8b50;
            --da-cream: #fdfaf3;
            --da-soft-green: #e8f3ec;
            --da-gold: #d4a437;
            --da-text: #1a2e1f;
            --da-muted: #5a6b5e;
            --da-border: #e3ebe5;
        }

        .da-complaint * {
            box-sizing: border-box;
        }

        .da-complaint {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--da-text);
            background: var(--da-cream);
            min-height: 100vh;
            padding: 48px 20px 80px;
            position: relative;
            overflow: hidden;
        }

        .da-complaint::before,
        .da-complaint::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }

        .da-complaint::before {
            top: -120px;
            right: -120px;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(31, 107, 58, 0.12), transparent 70%);
            animation: floatBlob 9s ease-in-out infinite;
        }

        .da-complaint::after {
            bottom: -140px;
            left: -100px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(212, 164, 55, 0.16), transparent 70%);
            animation: floatBlob 11s ease-in-out infinite reverse;
        }

        @keyframes floatBlob {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-30px) scale(1.05);
            }
        }

        .complaint-shell {
            max-width: 880px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        /* Header */
        .complaint-head {
            text-align: center;
            margin-bottom: 32px;
            animation: fadeUp 0.6s ease-out;
        }

        .complaint-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(31, 107, 58, 0.1);
            color: var(--da-green);
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .complaint-eyebrow .dot {
            width: 8px;
            height: 8px;
            background: var(--da-green);
            border-radius: 50%;
            animation: pulseDot 2s ease-in-out infinite;
        }

        @keyframes pulseDot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.3);
            }
        }

        .complaint-title {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 800;
            color: var(--da-green-dark);
            margin: 0 0 10px;
            line-height: 1.15;
        }

        .complaint-sub {
            color: var(--da-muted);
            font-size: 16px;
            max-width: 580px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Card */
        .complaint-card {
            background: white;
            border-radius: 24px;
            border: 1px solid var(--da-border);
            box-shadow: 0 20px 60px -20px rgba(31, 107, 58, 0.18);
            overflow: hidden;
            animation: fadeUp 0.7s ease-out 0.1s backwards;
        }

        .complaint-card-top {
            background: linear-gradient(135deg, var(--da-green-dark), var(--da-green));
            color: white;
            padding: 24px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: relative;
            overflow: hidden;
        }

        .complaint-card-top::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, rgba(212, 164, 55, 0.25), transparent 70%);
            border-radius: 50%;
        }

        .top-meta {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .top-icon {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .top-icon svg {
            width: 22px;
            height: 22px;
            color: var(--da-gold);
        }

        .top-meta h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
        }

        .top-meta p {
            margin: 2px 0 0;
            font-size: 13px;
            opacity: 0.85;
        }

        .top-badge {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--da-gold);
            color: var(--da-green-dark);
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        .complaint-form {
            padding: 36px 32px 40px;
        }

        /* Step indicator */
        .form-progress {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 32px;
            color: var(--da-muted);
            font-size: 13px;
            font-weight: 600;
            flex-wrap: wrap;
        }

        .form-progress .pill {
            padding: 4px 12px;
            border-radius: 999px;
            background: var(--da-soft-green);
            color: var(--da-green-dark);
        }

        .form-progress .sep {
            opacity: 0.4;
        }

        /* Sections */
        .form-section {
            border-top: 1px dashed var(--da-border);
            padding-top: 28px;
            margin-top: 28px;
        }

        .form-section:first-of-type {
            border-top: 0;
            padding-top: 0;
            margin-top: 0;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .section-heading .num {
            width: 28px;
            height: 28px;
            background: var(--da-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .section-heading h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--da-green-dark);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--da-text);
            margin-bottom: 6px;
        }

        .field label .req {
            color: #c0392b;
            margin-left: 2px;
        }

        .field label .opt {
            margin-left: 6px;
            font-size: 11px;
            font-weight: 500;
            color: var(--da-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .chev,
        .input-wrap .lock {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--da-muted);
            pointer-events: none;
        }

        .input-wrap .chev svg,
        .input-wrap .lock svg {
            width: 16px;
            height: 16px;
        }

        .form-control,
        select.form-control,
        textarea.form-control {
            width: 100%;
            background: var(--da-cream);
            border: 1.5px solid var(--da-border);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14.5px;
            font-family: inherit;
            color: var(--da-text);
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
            appearance: none;
            -webkit-appearance: none;
        }

        select.form-control {
            padding-right: 38px;
            cursor: pointer;
        }

        .form-control[readonly] {
            background: var(--da-soft-green);
            color: var(--da-green-dark);
            font-weight: 600;
            cursor: not-allowed;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--da-green);
            background: white;
            box-shadow: 0 0 0 4px rgba(31, 107, 58, 0.12);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 140px;
            line-height: 1.6;
        }

        .field-help {
            margin-top: 6px;
            font-size: 12px;
            color: var(--da-muted);
            line-height: 1.5;
        }

        .char-count {
            text-align: right;
            font-size: 11.5px;
            color: var(--da-muted);
            margin-top: 4px;
        }

        /* Submit row */
        .submit-row {
            margin-top: 32px;
            padding-top: 28px;
            border-top: 1px solid var(--da-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--da-green), var(--da-green-dark));
            color: white;
            padding: 14px 32px;
            border: 0;
            border-radius: 999px;
            font-weight: 700;
            font-size: 15px;
            font-family: inherit;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
            box-shadow: 0 8px 24px -6px rgba(31, 107, 58, 0.5);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px -6px rgba(31, 107, 58, 0.6);
            filter: brightness(1.05);
        }

        .btn-submit svg {
            width: 18px;
            height: 18px;
        }

        .shield-note {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--da-soft-green);
            color: var(--da-green-dark);
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .shield-note svg {
            width: 16px;
            height: 16px;
        }

        /* 72-hour ribbon */
        .pledge-ribbon {
            margin-top: 24px;
            background: linear-gradient(135deg, rgba(31, 107, 58, 0.06), rgba(212, 164, 55, 0.08));
            border: 1px dashed rgba(31, 107, 58, 0.25);
            border-radius: 16px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 13.5px;
            color: var(--da-text);
        }

        .pledge-ribbon .pledge-icon {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--da-green);
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(31, 107, 58, 0.1);
        }

        .pledge-ribbon strong {
            color: var(--da-green-dark);
        }

        /* Validation errors */
        .err-list {
            background: #fef3f2;
            border: 1px solid #fecdca;
            color: #b42318;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 13.5px;
        }

        .err-list ul {
            margin: 6px 0 0;
            padding-left: 18px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .da-complaint {
                padding: 32px 14px 60px;
            }

            .complaint-card-top {
                padding: 20px 22px;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .complaint-form {
                padding: 28px 20px 32px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .submit-row {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .btn-submit {
                justify-content: center;
                width: 100%;
            }

            .shield-note {
                justify-content: center;
            }
        }

        @media (hover: none) {
            .btn-submit:hover {
                transform: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .da-complaint::before,
            .da-complaint::after,
            .complaint-eyebrow .dot,
            .complaint-head,
            .complaint-card {
                animation: none !important;
            }
        }
    </style>

    <div class="da-complaint">
        <div class="complaint-shell">

            {{-- Header --}}
            <header class="complaint-head">
                <span class="complaint-eyebrow">
                    <span class="dot"></span>
                    Anonymous Submission Portal
                </span>
                <h1 class="complaint-title">Submit a Confidential Complaint</h1>
                <p class="complaint-sub">
                    Your concern is protected. Provide as much detail as possible — every report
                    receives an initial response within 72 hours.
                </p>
            </header>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="err-list">
                    <strong>Please fix the following:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Card --}}
            <div class="complaint-card">
                <div class="complaint-card-top">
                    <div class="top-meta">
                        <div class="top-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m0-9a3 3 0 013 3v1H9V11a3 3 0 013-3zm-7 4a7 7 0 1114 0v6H5v-6z" />
                            </svg>
                        </div>
                        <div>
                            <h2>Secure Complaint Form</h2>
                            <p>End-to-end confidential · No login required</p>
                        </div>
                    </div>
                    <span class="top-badge">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="12"
                            height="12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Identity Protected
                    </span>
                </div>

                <form action="{{ url('/complaints') }}" method="POST" class="complaint-form">
                    @csrf

                    <div class="form-progress">
                        <span class="pill">Step 1 of 1</span>
                        <span class="sep">·</span>
                        <span>Estimated time: 3 minutes</span>
                    </div>

                    {{-- SECTION 1: Routing --}}
                    <div class="form-section">
                        <div class="section-heading">
                            <span class="num">1</span>
                            <h3>Where should this go?</h3>
                        </div>

                        <div class="form-grid">
                            <div class="field">
                                <label>Government Agency</label>
                                <div class="input-wrap">
                                    <input type="text" name="agency" value="DA-MIMAROPA" readonly
                                        class="form-control">
                                    <span class="lock">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="field">
                                <label>Office / Department <span class="req">*</span></label>
                                <div class="input-wrap">
                                    <select name="department" id="officeSelect" class="form-control" required
                                        onchange="toggleOther(this)">
                                        <option value="">Select Department...</option>
                                        @php
                                            $offices = [
                                                'Accounting',
                                                'Agribusiness and Marketing Assistance Division',
                                                'Bids and Awards Committee',
                                                'Budget Section',
                                                'Cashier',
                                                'Corn Program',
                                                'Disaster Risk Reduction and Management Unit',
                                                'Farm and Fisheries Clustering and Consolidation Program',
                                                'Field Operations Division',
                                                'General Support Services',
                                                'Halal Program',
                                                'High Value Crops Development Program',
                                                'Human Resource Management Section',
                                                'Institutional Development Unit',
                                                'Integrated Laboratories Division',
                                                'Kabuhayan at Kaunlaran ng Kababayang Katutubo',
                                                'Livestock Program',
                                                'Management Information System Section',
                                                'National Urban and Peri-Urban Agriculture Program',
                                                'Office of the Regional Executive Director',
                                                'Organic Agriculture Program',
                                                'Palawan Research and Experiment Station',
                                                'Philippine Rural Development Program- RPCO (IPlan)',
                                                'Philippine Rural Development Program- RPCO (ISupport)',
                                                'Philippine Rural Development Project- PSO (IBuild)',
                                                'Philippine Rural Development Project- PSO (IPlan)',
                                                'Philippine Rural Development Project- PSO (IReap)',
                                                'Philippine Rural Development Project- PSO (ISupport)',
                                                'Philippine Rural Development Project- RPCO (IReap)',
                                                'Planning, Monitoring and Evaluation Division',
                                                'Property and Supply Unit',
                                                'Province-led Agriculture and Fisheries Extension System',
                                                'Records Section',
                                                'Regional Agricultural Engineering Division',
                                                'Regional Agricultural and Fishery Council',
                                                'Regional Agriculture and Fisheries Information Section',
                                                'Regional Integrated Agricultural Research Center',
                                                'Regional Technical Director for Operations',
                                                'Regional Technical Director for Research',
                                                'Registry System for Basic Sectors in Agriculture',
                                                'Regulatory Division',
                                                'Research Division',
                                                'Rice Program',
                                                'Special Area for Agricultural Development program',
                                            ];
                                        @endphp
                                        @foreach ($offices as $office)
                                            <option value="{{ $office }}" @selected(old('office') === $office)>
                                                {{ $office }}</option>
                                        @endforeach
                                        <option value="Others" @selected(old('office') === 'Others')>Others (Please specify...)
                                        </option>
                                    </select>
                                    <span class="chev">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="field field-full" id="otherWrap"
                                style="display: {{ old('office') === 'Others' ? 'block' : 'none' }};">
                                <label>Specify Other Office <span class="req">*</span></label>
                                <input type="text" name="office_other" value="{{ old('office_other') }}"
                                    class="form-control" placeholder="Type the office or unit name">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: Respondent --}}
                    <div class="form-section">
                        <div class="section-heading">
                            <span class="num">2</span>
                            <h3>Who is involved? <span
                                    style="font-weight:500;color:var(--da-muted);font-size:13px;">(Optional)</span></h3>
                        </div>

                        <div class="form-grid">
                            <div class="field field-full">
                                <label>Respondent name<span class="opt">Optional</span></label>
                                <input type="text" name="respondent_name" value="{{ old('respondent') }}"
                                    class="form-control" placeholder="Name or position of person/office involved">
                                <p class="field-help">Leave blank if you'd rather not disclose. Your complaint will
                                    still be processed.</p>
                            </div>
                            <div class="field field-full">
                                <label>Respondent position<span class="opt">Optional</span></label>
                                <input type="text" name="respondent_position"
                                    value="{{ old('respondent_position') }}" class="form-control"
                                    placeholder="Position of the respondent">
                                <p class="field-help">Leave blank if you'd rather not disclose. Your complaint will
                                    still be processed.</p>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 3: Complaint --}}
                    <div class="form-section">
                        <div class="section-heading">
                            <span class="num">3</span>
                            <h3>Tell us what happened</h3>
                        </div>

                        <div class="form-grid">
                            <div class="field field-full">
                                <label>Subject of Complaint <span class="req">*</span></label>
                                <input type="text" name="title" value="{{ old('subject') }}" maxlength="150"
                                    class="form-control" placeholder="A short title for your concern" required>
                            </div>

                            <div class="field field-full">
                                <label>Detailed Statement <span class="req">*</span></label>
                                <textarea name="description" id="descField" maxlength="2000" class="form-control"
                                    placeholder="Describe what happened — when, where, who was involved, and any other relevant details." required
                                    oninput="updateCount()">{{ old('description') }}</textarea>
                                <div class="char-count"><span id="charCount">0</span> / 2000</div>
                                <p class="field-help">The more specific you are, the faster we can act. All details
                                    remain confidential.</p>
                            </div>
                        </div>
                    </div>

                    {{-- 72-hour pledge --}}
                    <div class="pledge-ribbon">
                        <div class="pledge-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                width="20" height="20">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <strong>72-Hour Service Pledge.</strong>
                            You'll receive an initial response and case reference within 72 hours of submission.
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="submit-row">
                        <span class="shield-note">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Anonymity protected by Identity Shield
                        </span>
                        <button type="submit" class="btn-submit">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 15v2m0-9a3 3 0 013 3v1H9V11a3 3 0 013-3zm-7 4a7 7 0 1114 0v6H5v-6z" />
                            </svg>
                            Submit Secure Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleOther(sel) {
            const wrap = document.getElementById('otherWrap');
            const show = sel.value === 'Others';
            wrap.style.display = show ? 'block' : 'none';
            const input = wrap.querySelector('input');
            if (!show && input) input.value = '';
        }

        function updateCount() {
            const f = document.getElementById('descField');
            const c = document.getElementById('charCount');
            if (f && c) c.textContent = f.value.length;
        }
        updateCount();
    </script>
</x-guest-layout>
