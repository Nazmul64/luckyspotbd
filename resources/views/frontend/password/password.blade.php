@extends('frontend.master')

@section('content')

@php
    $user = auth()->user();
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

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
            'old_password_placeholder' => 'পুরাতন পাসওয়ার্ড লিখুন',
            'new_password_placeholder' => 'নতুন পাসওয়ার্ড লিখুন',
            'confirm_password_placeholder' => 'নিশ্চিত করুন',
            'update_password' => 'পাসওয়ার্ড আপডেট করুন',
            'password_requirements' => 'পাসওয়ার্ডের প্রয়োজনীয়তা',
            'req_1' => 'কমপক্ষে ৮টি অক্ষর',
            'req_2' => 'বড় ও ছোট হাতের অক্ষর',
            'req_3' => 'সংখ্যা থাকতে হবে',
            'req_4' => 'বিশেষ চিহ্ন থাকতে হবে',
            'security_tips' => 'নিরাপত্তা টিপস',
            'tip_1' => 'শক্তিশালী পাসওয়ার্ড ব্যবহার করুন',
            'tip_2' => 'পাসওয়ার্ড শেয়ার করবেন না',
            'tip_3' => 'নিয়মিত পরিবর্তন করুন',
            'tip_4' => 'সাধারণ শব্দ এড়িয়ে চলুন',
            'old_password_required' => 'পুরাতন পাসওয়ার্ড প্রয়োজন',
            'new_password_required' => 'নতুন পাসওয়ার্ড প্রয়োজন',
            'confirm_password_required' => 'পাসওয়ার্ড নিশ্চিত করুন',
            'password_mismatch' => 'পাসওয়ার্ড মিলছে না',
            'password_too_short' => 'কমপক্ষে ৮টি অক্ষর হতে হবে',
            'updating' => 'আপডেট হচ্ছে...',
        ],
    ];

    $lang = $translations[$isBangla ? 'bn' : 'en'];
@endphp

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            @include('frontend.dashboard.sidebar')

            <div class="col-lg-9">

                {{-- HEADER --}}
                <div class="password-header">
                    <div class="header-content">
                        <h4><i class="fas fa-lock"></i> {{ $lang['page_title'] }}</h4>
                        <p>{{ $lang['page_subtitle'] }}</p>
                    </div>
                    <div class="header-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>

                {{-- ALERTS --}}
                @if(session('success'))
                    <div class="alert-box success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                        <button class="close-btn" onclick="this.parentElement.remove()">×</button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-box danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        <button class="close-btn" onclick="this.parentElement.remove()">×</button>
                    </div>
                @endif

                <div class="row g-4">

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
                                        <input type="password" class="form-input" id="oldPassword" name="old_password" placeholder="{{ $lang['old_password_placeholder'] }}">
                                        <button type="button" class="toggle-btn" data-target="oldPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="newPassword">
                                        <i class="fas fa-lock"></i> {{ $lang['new_password'] }}
                                    </label>
                                    <div class="password-input-wrapper">
                                        <input type="password" class="form-input" id="newPassword" name="new_password" placeholder="{{ $lang['new_password_placeholder'] }}">
                                        <button type="button" class="toggle-btn" data-target="newPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="strength-bar">
                                        <div class="strength-fill" id="strengthBar"></div>
                                    </div>
                                    <small class="strength-text" id="strengthText"></small>
                                </div>

                                <div class="form-group">
                                    <label for="confirmPassword">
                                        <i class="fas fa-check-circle"></i> {{ $lang['confirm_password'] }}
                                    </label>
                                    <div class="password-input-wrapper">
                                        <input type="password" class="form-input" id="confirmPassword" name="new_password_confirmation" placeholder="{{ $lang['confirm_password_placeholder'] }}">
                                        <button type="button" class="toggle-btn" data-target="confirmPassword">
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
                        <div class="info-card requirements-card">
                            <h6><i class="fas fa-clipboard-list"></i> {{ $lang['password_requirements'] }}</h6>
                            <ul class="requirements-list">
                                <li id="req1"><i class="fas fa-circle"></i> {{ $lang['req_1'] }}</li>
                                <li id="req2"><i class="fas fa-circle"></i> {{ $lang['req_2'] }}</li>
                                <li id="req3"><i class="fas fa-circle"></i> {{ $lang['req_3'] }}</li>
                                <li id="req4"><i class="fas fa-circle"></i> {{ $lang['req_4'] }}</li>
                            </ul>
                        </div>

                        {{-- SECURITY TIPS --}}
                        <div class="info-card tips-card">
                            <h6><i class="fas fa-shield-alt"></i> {{ $lang['security_tips'] }}</h6>
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

{{-- ===================== STYLES ===================== --}}
<style>
:root {
    {{ $isBangla ? '--font: "Kalpurush", sans-serif;' : '--font: -apple-system, sans-serif;' }}
}

/* HEADER */
.password-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px 30px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.header-content h4 {
    color: #fff;
    font-size: 26px;
    font-weight: 700;
    margin: 0 0 5px 0;
    font-family: var(--font);
    display: flex;
    align-items: center;
    gap: 10px;
}

.header-content p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 14px;
}

.header-icon {
    font-size: 50px;
    color: rgba(255, 255, 255, 0.3);
}

/* ALERTS */
.alert-box {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    position: relative;
    animation: slideIn 0.4s ease;
    font-family: var(--font);
}

.alert-box.success {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.2));
    border-left: 4px solid #28a745;
    color: #28a745;
}

.alert-box.danger {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.2));
    border-left: 4px solid #dc3545;
    color: #dc3545;
}

.close-btn {
    position: absolute;
    right: 15px;
    top: 15px;
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
    color: inherit;
    opacity: 0.6;
}

.close-btn:hover { opacity: 1; }

/* FORM CARD */
.password-form-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
    padding: 30px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 25px;
}

label {
    display: block;
    font-weight: 600;
    color: #fff;
    margin-bottom: 8px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font);
}

label i {
    font-size: 14px;
}

.password-input-wrapper {
    position: relative;
}

.form-input {
    width: 100%;
    padding: 12px 50px 12px 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s;
    background: rgba(255, 255, 255, 0.95);
    color: #2c3e50;
    font-family: var(--font);
}

.form-input:focus {
    outline: none;
    border-color: #fff;
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
    background: #fff;
}

.toggle-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: #666;
    font-size: 16px;
    cursor: pointer;
    padding: 8px;
    border-radius: 6px;
    transition: all 0.3s;
}

.toggle-btn:hover {
    color: #f5576c;
    background: rgba(245, 87, 108, 0.1);
}

/* STRENGTH BAR */
.strength-bar {
    height: 6px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    margin-top: 8px;
    overflow: hidden;
}

.strength-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s;
    border-radius: 10px;
}

.strength-text {
    display: block;
    margin-top: 6px;
    font-size: 12px;
    font-weight: 600;
    color: #fff;
}

/* SUBMIT BUTTON */
.btn-submit {
    width: 100%;
    padding: 14px 24px;
    background: #fff;
    color: #f5576c;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
    font-family: var(--font);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* INFO CARDS */
.info-card {
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.requirements-card {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.tips-card {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.info-card h6 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font);
}

.requirements-list,
.tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirements-list li,
.tips-list li {
    padding: 10px 0;
    color: #fff;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s;
    font-family: var(--font);
}

.requirements-list li:last-child,
.tips-list li:last-child {
    border-bottom: none;
}

.requirements-list li i {
    font-size: 8px;
}

.requirements-list li.met {
    color: #fff;
    font-weight: 600;
}

.requirements-list li.met i {
    font-size: 14px;
}

.tips-list li i {
    font-size: 12px;
}

/* ANIMATIONS */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .password-header {
        padding: 20px;
        flex-direction: column;
        text-align: center;
    }
    .header-content h4 {
        font-size: 22px;
    }
    .header-icon {
        font-size: 40px;
    }
}

@media (max-width: 767px) {
    .password-form-card {
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

        const form = document.getElementById('passwordForm');
        const oldPassword = document.getElementById('oldPassword');
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        const submitBtn = document.querySelector('.btn-submit');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        // PASSWORD TOGGLE
        document.querySelectorAll('.toggle-btn').forEach(btn => {
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

        // PASSWORD STRENGTH
        if (newPassword && strengthBar && strengthText) {
            newPassword.addEventListener('input', function() {
                const password = this.value;
                const strength = calculateStrength(password);
                updateStrengthUI(strength);
                checkRequirements(password);
            });
        }

        function calculateStrength(password) {
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
        }

        function checkRequirements(password) {
            const req1 = document.getElementById('req1');
            if (password.length >= 8) {
                req1.classList.add('met');
                req1.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                req1.classList.remove('met');
                req1.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }

            const req2 = document.getElementById('req2');
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
                req2.classList.add('met');
                req2.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                req2.classList.remove('met');
                req2.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }

            const req3 = document.getElementById('req3');
            if (/\d/.test(password)) {
                req3.classList.add('met');
                req3.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                req3.classList.remove('met');
                req3.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }

            const req4 = document.getElementById('req4');
            if (/[^a-zA-Z0-9]/.test(password)) {
                req4.classList.add('met');
                req4.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                req4.classList.remove('met');
                req4.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }
        }

        // FORM VALIDATION
        if (form) {
            form.addEventListener('submit', function(e) {
                let isValid = true;
                clearErrors();

                if (!oldPassword.value.trim()) {
                    isValid = false;
                    showError(oldPassword, messages.oldPasswordRequired);
                }

                if (!newPassword.value.trim()) {
                    isValid = false;
                    showError(newPassword, messages.newPasswordRequired);
                } else if (newPassword.value.length < 8) {
                    isValid = false;
                    showError(newPassword, messages.passwordTooShort);
                }

                if (!confirmPassword.value.trim()) {
                    isValid = false;
                    showError(confirmPassword, messages.confirmPasswordRequired);
                } else if (newPassword.value !== confirmPassword.value) {
                    isValid = false;
                    showError(confirmPassword, messages.passwordMismatch);
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + messages.updating;
                submitBtn.disabled = true;
            });
        }

        function showError(input, message) {
            input.style.borderColor = '#dc3545';
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.style.color = '#fff';
            errorDiv.style.fontSize = '12px';
            errorDiv.style.marginTop = '6px';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + message;
            input.parentElement.parentElement.appendChild(errorDiv);
        }

        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            document.querySelectorAll('.form-input').forEach(input => {
                input.style.borderColor = '';
            });
        }

        // AUTO HIDE ALERTS
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-box');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);

        console.log('🔒 Password Change Loaded');
    });
})();
</script>

@endsection
