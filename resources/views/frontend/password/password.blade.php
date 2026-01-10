@extends('frontend.master')

@section('content')

@php
    // ============================================
    // THEME CONFIGURATION
    // ============================================
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#F5CE0D';
    $secondaryColor = $activeTheme->secondary_color ?? '#000000';

    // ============================================
    // LANGUAGE DETECTION
    // ============================================
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

    // ============================================
    // TRANSLATIONS
    // ============================================
    $translations = [
        'en' => [
            'page_title' => 'Change Password',
            'page_subtitle' => 'Update your account password',
            'old_password' => 'Old Password',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm Password',
            'old_password_placeholder' => 'Enter your old password',
            'new_password_placeholder' => 'Enter your new password',
            'confirm_password_placeholder' => 'Confirm your new password',
            'update_password' => 'Update Password',
            'password_requirements' => 'Password Requirements',
            'req_1' => 'At least 8 characters',
            'req_2' => 'Contains uppercase & lowercase',
            'req_3' => 'Contains numbers',
            'req_4' => 'Contains special characters',
            'security_tips' => 'Security Tips',
            'tip_1' => 'Use a strong, unique password',
            'tip_2' => 'Don\'t share your password',
            'tip_3' => 'Change password regularly',
            'tip_4' => 'Avoid common words',
            // Validation messages
            'old_password_required' => 'Old password is required',
            'new_password_required' => 'New password is required',
            'confirm_password_required' => 'Please confirm your password',
            'password_mismatch' => 'Passwords do not match',
            'password_too_short' => 'Password must be at least 8 characters',
            'updating' => 'Updating...',
        ],
        'bn' => [
            'page_title' => 'পাসওয়ার্ড পরিবর্তন',
            'page_subtitle' => 'আপনার অ্যাকাউন্ট পাসওয়ার্ড আপডেট করুন',
            'old_password' => 'পুরাতন পাসওয়ার্ড',
            'new_password' => 'নতুন পাসওয়ার্ড',
            'confirm_password' => 'পাসওয়ার্ড নিশ্চিত করুন',
            'old_password_placeholder' => 'আপনার পুরাতন পাসওয়ার্ড লিখুন',
            'new_password_placeholder' => 'আপনার নতুন পাসওয়ার্ড লিখুন',
            'confirm_password_placeholder' => 'নতুন পাসওয়ার্ড নিশ্চিত করুন',
            'update_password' => 'পাসওয়ার্ড আপডেট করুন',
            'password_requirements' => 'পাসওয়ার্ডের প্রয়োজনীয়তা',
            'req_1' => 'কমপক্ষে ৮টি অক্ষর',
            'req_2' => 'বড় ও ছোট হাতের অক্ষর থাকতে হবে',
            'req_3' => 'সংখ্যা থাকতে হবে',
            'req_4' => 'বিশেষ চিহ্ন থাকতে হবে',
            'security_tips' => 'নিরাপত্তা টিপস',
            'tip_1' => 'শক্তিশালী, অনন্য পাসওয়ার্ড ব্যবহার করুন',
            'tip_2' => 'আপনার পাসওয়ার্ড শেয়ার করবেন না',
            'tip_3' => 'নিয়মিত পাসওয়ার্ড পরিবর্তন করুন',
            'tip_4' => 'সাধারণ শব্দ এড়িয়ে চলুন',
            // Validation messages
            'old_password_required' => 'পুরাতন পাসওয়ার্ড প্রয়োজন',
            'new_password_required' => 'নতুন পাসওয়ার্ড প্রয়োজন',
            'confirm_password_required' => 'পাসওয়ার্ড নিশ্চিত করুন',
            'password_mismatch' => 'পাসওয়ার্ড মিলছে না',
            'password_too_short' => 'পাসওয়ার্ড কমপক্ষে ৮টি অক্ষর হতে হবে',
            'updating' => 'আপডেট হচ্ছে...',
        ],
    ];

    $lang = $translations[$isBangla ? 'bn' : 'en'];
@endphp

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            {{-- SIDEBAR --}}
            @include('frontend.dashboard.sidebar')

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9">
                <div class="password-wrapper">

                    {{-- HEADER --}}
                    <div class="password-header">
                        <div class="header-content">
                            <h4>
                                <i class="fas fa-lock"></i> {{ $lang['page_title'] }}
                            </h4>
                            <p class="header-subtitle">{{ $lang['page_subtitle'] }}</p>
                        </div>
                        <div class="header-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                        <div class="alert-box alert-success">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- ERROR MESSAGES --}}
                    @if($errors->any())
                        <div class="alert-box alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="row gy-4">

                        {{-- PASSWORD FORM --}}
                        <div class="col-lg-8">
                            <div class="password-form-card">
                                <form id="passwordForm" method="POST" action="{{ route('password.change') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="oldPassword">
                                            <i class="fas fa-key"></i> {{ $lang['old_password'] }}
                                        </label>
                                        <div class="password-input-wrapper">
                                            <input
                                                type="password"
                                                class="form-control password-input"
                                                id="oldPassword"
                                                name="old_password"
                                                placeholder="{{ $lang['old_password_placeholder'] }}"
                                                autocomplete="current-password">
                                            <button type="button" class="password-toggle-btn" data-target="oldPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPassword">
                                            <i class="fas fa-lock"></i> {{ $lang['new_password'] }}
                                        </label>
                                        <div class="password-input-wrapper">
                                            <input
                                                type="password"
                                                class="form-control password-input"
                                                id="newPassword"
                                                name="new_password"
                                                placeholder="{{ $lang['new_password_placeholder'] }}"
                                                autocomplete="new-password">
                                            <button type="button" class="password-toggle-btn" data-target="newPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength-bar">
                                            <div class="strength-bar-fill" id="strengthBar"></div>
                                        </div>
                                        <small class="strength-text" id="strengthText"></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirmPassword">
                                            <i class="fas fa-check-circle"></i> {{ $lang['confirm_password'] }}
                                        </label>
                                        <div class="password-input-wrapper">
                                            <input
                                                type="password"
                                                class="form-control password-input"
                                                id="confirmPassword"
                                                name="new_password_confirmation"
                                                placeholder="{{ $lang['confirm_password_placeholder'] }}"
                                                autocomplete="new-password">
                                            <button type="button" class="password-toggle-btn" data-target="confirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-submit">
                                        <i class="fas fa-save"></i> {{ $lang['update_password'] }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- SIDEBAR INFO --}}
                        <div class="col-lg-4">
                            {{-- PASSWORD REQUIREMENTS --}}
                            <div class="info-card">
                                <h6>
                                    <i class="fas fa-clipboard-list"></i> {{ $lang['password_requirements'] }}
                                </h6>
                                <ul class="requirements-list">
                                    <li id="req1"><i class="fas fa-circle"></i> {{ $lang['req_1'] }}</li>
                                    <li id="req2"><i class="fas fa-circle"></i> {{ $lang['req_2'] }}</li>
                                    <li id="req3"><i class="fas fa-circle"></i> {{ $lang['req_3'] }}</li>
                                    <li id="req4"><i class="fas fa-circle"></i> {{ $lang['req_4'] }}</li>
                                </ul>
                            </div>

                            {{-- SECURITY TIPS --}}
                            <div class="info-card">
                                <h6>
                                    <i class="fas fa-shield-alt"></i> {{ $lang['security_tips'] }}
                                </h6>
                                <ul class="tips-list">
                                    <li><i class="fas fa-check"></i> {{ $lang['tip_1'] }}</li>
                                    <li><i class="fas fa-check"></i> {{ $lang['tip_2'] }}</li>
                                    <li><i class="fas fa-check"></i> {{ $lang['tip_3'] }}</li>
                                    <li><i class="fas fa-check"></i> {{ $lang['tip_4'] }}</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ===================== STYLES ===================== --}}
<style>
:root {
    --primary: {{ $primaryColor }};
    --secondary: {{ $secondaryColor }};
    --success: #28a745;
    --danger: #dc3545;
    --warning: #ffc107;
    --info: #17a2b8;
    --white: #ffffff;
    --light: #f8f9fa;
    --dark: #212529;
    --text-muted: #6c757d;
    --border: #dee2e6;
}

.password-wrapper {
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

/* ==================== HEADER ==================== */
.password-header {
    background: linear-gradient(135deg,
        color-mix(in srgb, var(--primary) 15%, transparent),
        color-mix(in srgb, var(--secondary) 15%, transparent));
    border: 2px solid var(--primary);
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.header-content h4 {
    color: var(--primary);
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 8px 0;
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-subtitle {
    color: var(--text-muted);
    margin: 0;
    font-size: 0.95rem;
}

.header-icon {
    font-size: 3rem;
    color: var(--primary);
    opacity: 0.2;
}

/* ==================== ALERTS ==================== */
.alert-box {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    animation: slideDown 0.3s ease;
}

.alert-success {
    background: color-mix(in srgb, var(--success) 15%, transparent);
    border-left: 4px solid var(--success);
    color: var(--success);
}

.alert-danger {
    background: color-mix(in srgb, var(--danger) 15%, transparent);
    border-left: 4px solid var(--danger);
    color: var(--danger);
}

.alert-box i {
    font-size: 1.25rem;
    flex-shrink: 0;
    margin-top: 2px;
}

/* ==================== FORM CARD ==================== */
.password-form-card {
    background: var(--white);
    border: 2px solid color-mix(in srgb, var(--primary) 30%, transparent);
    border-radius: 15px;
    padding: 35px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--dark);
    font-size: 0.95rem;
}

.form-group label i {
    color: var(--primary);
    margin-right: 6px;
}

.password-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.form-control {
    width: 100%;
    padding: 14px 50px 14px 16px;
    border: 2px solid var(--border);
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--white);
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px color-mix(in srgb, var(--primary) 15%, transparent);
}

.password-toggle-btn {
    position: absolute;
    right: 12px;
    background: transparent;
    border: none;
    color: var(--text-muted);
    font-size: 1.1rem;
    cursor: pointer;
    padding: 8px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.password-toggle-btn:hover {
    color: var(--primary);
    background: color-mix(in srgb, var(--primary) 10%, transparent);
}

/* ==================== PASSWORD STRENGTH ==================== */
.password-strength-bar {
    height: 6px;
    background: var(--border);
    border-radius: 10px;
    margin-top: 8px;
    overflow: hidden;
}

.strength-bar-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 10px;
}

.strength-text {
    display: block;
    margin-top: 6px;
    font-size: 0.85rem;
    font-weight: 600;
}

/* ==================== SUBMIT BUTTON ==================== */
.btn-submit {
    width: 100%;
    padding: 14px 24px;
    background: var(--primary);
    color: var(--secondary);
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* ==================== INFO CARDS ==================== */
.info-card {
    background: var(--white);
    border: 2px solid color-mix(in srgb, var(--primary) 20%, transparent);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.info-card h6 {
    color: var(--primary);
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.requirements-list,
.tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirements-list li,
.tips-list li {
    padding: 8px 0;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.requirements-list li i {
    font-size: 0.5rem;
    color: var(--text-muted);
}

.requirements-list li.met {
    color: var(--success);
}

.requirements-list li.met i {
    color: var(--success);
}

.tips-list li i {
    color: var(--success);
    font-size: 0.8rem;
}

/* ==================== ANIMATIONS ==================== */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 991px) {
    .password-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .header-icon {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .password-form-card {
        padding: 25px 20px;
    }

    .header-content h4 {
        font-size: 1.5rem;
    }

    .form-control {
        padding: 12px 45px 12px 14px;
    }
}

@media (max-width: 576px) {
    .password-header {
        padding: 20px;
    }

    .info-card {
        padding: 16px;
    }
}
</style>

{{-- ===================== JAVASCRIPT ===================== --}}
<script>
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {

        /* =============================
           CONFIGURATION
        ============================== */
        const isBangla = {{ $isBangla ? 'true' : 'false' }};
        const messages = {
            oldPasswordRequired: '{{ $lang["old_password_required"] }}',
            newPasswordRequired: '{{ $lang["new_password_required"] }}',
            confirmPasswordRequired: '{{ $lang["confirm_password_required"] }}',
            passwordMismatch: '{{ $lang["password_mismatch"] }}',
            passwordTooShort: '{{ $lang["password_too_short"] }}',
            updating: '{{ $lang["updating"] }}',
            weak: isBangla ? 'দুর্বল' : 'Weak',
            fair: isBangla ? 'মাঝারি' : 'Fair',
            good: isBangla ? 'ভালো' : 'Good',
            strong: isBangla ? 'শক্তিশালী' : 'Strong'
        };

        /* =============================
           ELEMENTS
        ============================== */
        const form = document.getElementById('passwordForm');
        const oldPassword = document.getElementById('oldPassword');
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        const submitBtn = document.querySelector('.btn-submit');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        /* =============================
           PASSWORD TOGGLE
        ============================== */
        document.querySelectorAll('.password-toggle-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        /* =============================
           PASSWORD STRENGTH CHECK
        ============================== */
        if (newPassword && strengthBar && strengthText) {
            newPassword.addEventListener('input', function() {
                const password = this.value;
                const strength = calculatePasswordStrength(password);
                updateStrengthUI(strength);
                checkRequirements(password);
            });
        }

        function calculatePasswordStrength(password) {
            let strength = 0;

            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            return strength;
        }

        function updateStrengthUI(strength) {
            const colors = ['#dc3545', '#ffc107', '#17a2b8', '#28a745'];
            const labels = [messages.weak, messages.fair, messages.good, messages.strong];
            const widths = [25, 50, 75, 100];

            let index = Math.min(strength - 1, 3);

            if (strength === 0) {
                strengthBar.style.width = '0%';
                strengthText.textContent = '';
                return;
            }

            strengthBar.style.width = widths[index] + '%';
            strengthBar.style.backgroundColor = colors[index];
            strengthText.textContent = labels[index];
            strengthText.style.color = colors[index];
        }

        function checkRequirements(password) {
            // Requirement 1: Length
            const req1 = document.getElementById('req1');
            if (password.length >= 8) {
                req1.classList.add('met');
                req1.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                req1.classList.remove('met');
                req1.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }

            // Requirement 2: Upper & Lower case
            const req2 = document.getElementById('req2');
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
                req2.classList.add('met');
                req2.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                req2.classList.remove('met');
                req2.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }

            // Requirement 3: Numbers
            const req3 = document.getElementById('req3');
            if (/\d/.test(password)) {
                req3.classList.add('met');
                req3.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                req3.classList.remove('met');
                req3.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }

            // Requirement 4: Special characters
            const req4 = document.getElementById('req4');
            if (/[^a-zA-Z0-9]/.test(password)) {
                req4.classList.add('met');
                req4.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                req4.classList.remove('met');
                req4.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }
        }

        /* =============================
           FORM VALIDATION
        ============================== */
        if (form) {
            form.addEventListener('submit', function(e) {
                let isValid = true;
                let message = '';

                // Clear previous errors
                clearErrors();

                // Validate old password
                if (!oldPassword.value.trim()) {
                    isValid = false;
                    message = messages.oldPasswordRequired;
                    showError(oldPassword, message);
                }

                // Validate new password
                if (!newPassword.value.trim()) {
                    isValid = false;
                    message = messages.newPasswordRequired;
                    showError(newPassword, message);
                } else if (newPassword.value.length < 8) {
                    isValid = false;
                    message = messages.passwordTooShort;
                    showError(newPassword, message);
                }

                // Validate confirm password
                if (!confirmPassword.value.trim()) {
                    isValid = false;
                    message = messages.confirmPasswordRequired;
                    showError(confirmPassword, message);
                } else if (newPassword.value !== confirmPassword.value) {
                    isValid = false;
                    message = messages.passwordMismatch;
                    showError(confirmPassword, message);
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }

                // Loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + messages.updating;
                submitBtn.disabled = true;
            });
        }

        function showError(input, message) {
            input.style.borderColor = 'var(--danger)';

            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.style.color = 'var(--danger)';
            errorDiv.style.fontSize = '0.85rem';
            errorDiv.style.marginTop = '6px';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + message;

            input.parentElement.parentElement.appendChild(errorDiv);
        }

        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            document.querySelectorAll('.form-control').forEach(input => {
                input.style.borderColor = '';
            });
        }

        /* =============================
           AUTO HIDE SUCCESS MESSAGE
        ============================== */
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 300);
            }, 5000);
        }

        console.log('🔒 Password Change JS Initialized');
    });
})();
</script>

@endsection
