@extends('frontend.master')

@section('content')

@php
    // Fetch active theme colors from database
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#F5CE0D';
    $secondaryColor = $activeTheme->secondary_color ?? '#000000';
@endphp

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            {{-- SIDEBAR --}}
            @include('frontend.dashboard.sidebar')

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9">
                <div style="padding: 40px 30px; background: linear-gradient(135deg, {{ $primaryColor }}10 0%, {{ $secondaryColor }}10 100%); border-radius: 15px; border: 2px solid {{ $primaryColor }}; box-shadow: 0 6px 25px rgba(0,0,0,0.1); margin-top: 20px;">

                    {{-- Header --}}
                    <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid {{ $primaryColor }};">
                        <h4 style="color: {{ $secondaryColor }}; font-weight: bold; font-size: 1.8em; margin: 0;">
                            <i class="fas fa-money-check-alt" style="color: {{ $primaryColor }}; margin-right: 10px;"></i>
                            Withdraw Now!
                        </h4>
                    </div>

                    {{-- Withdraw Limits --}}
                    @if(isset($Withdraw_limit))
                        <div style="background: linear-gradient(135deg, {{ $primaryColor }}20 0%, {{ $primaryColor }}30 100%); border-left: 5px solid {{ $primaryColor }}; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <i class="fas fa-info-circle" style="color: {{ $primaryColor }}; font-size: 1.5em; margin-right: 12px;"></i>
                                <h5 style="color: {{ $secondaryColor }}; font-weight: bold; margin: 0;">Withdraw Limits</h5>
                            </div>
                            <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-top: 15px;">
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: {{ $secondaryColor }}; margin: 0; font-size: 0.9em; opacity: 0.8;">Minimum Withdraw:</p>
                                    <p style="color: {{ $primaryColor }}; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        {{ round($Withdraw_limit->minimum_withdraw ?? 0) }} টাকা
                                    </p>
                                </div>
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: {{ $secondaryColor }}; margin: 0; font-size: 0.9em; opacity: 0.8;">Maximum Withdraw:</p>
                                    <p style="color: {{ $primaryColor }}; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        {{ round($Withdraw_limit->maximum_withdraw ?? 0) }} টাকা
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div style="background: linear-gradient(135deg, #28a74520 0%, #28a74530 100%); border-left: 5px solid #28a745; padding: 18px 20px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-check-circle" style="color: #28a745; font-size: 1.5em; margin-right: 12px;"></i>
                                <span style="color: #28a745; font-weight: 600; font-size: 1.05em;">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    {{-- Withdraw Form --}}
                    <form action="{{ route('Withdraw.submit') }}" method="POST" id="withdrawForm">
                        @csrf

                        {{-- Amount --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-money-bill-wave" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                Withdraw Amount *
                            </label>
                            <input type="number"
                                   name="amount"
                                   class="form-input"
                                   step="0.01"
                                   min="{{ $Withdraw_limit->minimum_withdraw ?? 0 }}"
                                   max="{{ $Withdraw_limit->maximum_withdraw ?? 0 }}"
                                   placeholder="Enter amount between {{ $Withdraw_limit->minimum_withdraw ?? 0 }} and {{ $Withdraw_limit->maximum_withdraw ?? 0 }}"
                                   style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            @error('amount')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Account Number --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-credit-card" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                Your Account Number *
                            </label>
                            <input type="text"
                                   name="account_number"
                                   class="form-input"
                                   placeholder="Enter your account number (e.g., 01XXXXXXXXX)"
                                   style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            @error('account_number')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Payment Method --}}
                        <div style="margin-bottom: 30px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-university" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                Payment Method *
                            </label>
                            <select name="payment_method"
                                    class="form-select"
                                    style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05); cursor: pointer;">
                                <option value="">-- Select Payment Method --</option>
                                @foreach($payment_method_name as $method)
                                    <option value="{{ $method->id }}" data-number="{{ $method->accountnumber ?? '' }}">
                                        {{ $method->bankname ?? '' }} - {{ $method->accountnumber ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div style="margin-top: 30px;">
                            <button type="submit"
                                    class="submit-btn"
                                    style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $primaryColor }}dd 100%); color: {{ $secondaryColor }}; border: none; padding: 18px 40px; border-radius: 10px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(0,0,0,0.2); width: 100%; max-width: 300px;">
                                <i class="fas fa-paper-plane"></i> Submit Withdraw
                            </button>
                        </div>
                    </form>

                    {{-- Important Notes --}}
                    <div style="margin-top: 40px; padding: 20px; background-color: {{ $secondaryColor }}05; border-radius: 10px; border: 1px solid {{ $primaryColor }}30;">
                        <h6 style="color: {{ $secondaryColor }}; font-weight: bold; margin-bottom: 15px;">
                            <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i> Important Notes
                        </h6>
                        <ul style="margin: 0; padding-left: 20px; color: {{ $secondaryColor }}; opacity: 0.8; line-height: 1.8;">
                            <li>Ensure your account number is correct before submitting</li>
                            <li>Withdraw amount must be within the specified limits</li>
                            <li>Processing time: 24-48 hours (business days)</li>
                            <li>Withdraw fees may apply depending on payment method</li>
                            <li>Contact support if you face any issues</li>
                        </ul>
                    </div>

                    {{-- Available Balance Display --}}
                    @if(isset($total_balance))
                        <div style="margin-top: 30px; padding: 25px; background: linear-gradient(135deg, {{ $primaryColor }}15 0%, {{ $secondaryColor }}15 100%); border-radius: 12px; border: 2px solid {{ $primaryColor }}; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <p style="color: {{ $secondaryColor }}; margin: 0 0 8px 0; font-size: 0.95em; opacity: 0.8;">
                                <i class="fas fa-wallet" style="color: {{ $primaryColor }};"></i> Your Available Balance
                            </p>
                            <h3 style="color: {{ $primaryColor }}; font-weight: bold; font-size: 2.2em; margin: 0;">
                                {{ round($total_balance ?? 0) }} টাকা
                            </h3>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    const primaryColor = '{{ $primaryColor }}';
    const secondaryColor = '{{ $secondaryColor }}';

    document.addEventListener('DOMContentLoaded', function () {

        // ============================================
        // INPUT FOCUS EFFECTS
        // ============================================
        const formInputs = document.querySelectorAll('.form-input, .form-select');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = primaryColor;
                this.style.boxShadow = `0 0 0 4px ${primaryColor}20`;
                this.style.transform = 'scale(1.01)';
            });

            input.addEventListener('blur', function() {
                this.style.borderColor = primaryColor;
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
                this.style.transform = 'scale(1)';
            });
        });

        // ============================================
        // BUTTON HOVER EFFECTS
        // ============================================
        const submitBtn = document.querySelector('.submit-btn');
        if (submitBtn) {
            submitBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 8px 30px rgba(0,0,0,0.3)';
                this.style.opacity = '0.95';
            });

            submitBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.2)';
                this.style.opacity = '1';
            });
        }

        // ============================================
        // FORM VALIDATION
        // ============================================
        const form = document.getElementById('withdrawForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const amount = document.querySelector('input[name="amount"]');
                const accountNumber = document.querySelector('input[name="account_number"]');
                const paymentMethod = document.querySelector('select[name="payment_method"]');

                let isValid = true;
                let errorMessage = '';

                // Validate amount
                if (!amount || !amount.value || parseFloat(amount.value) <= 0) {
                    isValid = false;
                    errorMessage = 'Please enter a valid withdraw amount!';
                    if (amount) {
                        amount.style.borderColor = '#dc3545';
                        amount.focus();
                    }
                }

                // Validate account number
                if (isValid && (!accountNumber || !accountNumber.value.trim())) {
                    isValid = false;
                    errorMessage = 'Please enter your account number!';
                    if (accountNumber) {
                        accountNumber.style.borderColor = '#dc3545';
                        accountNumber.focus();
                    }
                }

                // Validate payment method
                if (isValid && (!paymentMethod || !paymentMethod.value)) {
                    isValid = false;
                    errorMessage = 'Please select a payment method!';
                    if (paymentMethod) {
                        paymentMethod.style.borderColor = '#dc3545';
                        paymentMethod.focus();
                    }
                }

                // Check minimum and maximum limits
                if (isValid && amount) {
                    const minWithdraw = parseFloat(amount.min);
                    const maxWithdraw = parseFloat(amount.max);
                    const withdrawAmount = parseFloat(amount.value);

                    if (withdrawAmount < minWithdraw) {
                        isValid = false;
                        errorMessage = `Minimum withdraw amount is ${minWithdraw} টাকা!`;
                        amount.style.borderColor = '#dc3545';
                        amount.focus();
                    } else if (withdrawAmount > maxWithdraw) {
                        isValid = false;
                        errorMessage = `Maximum withdraw amount is ${maxWithdraw} টাকা!`;
                        amount.style.borderColor = '#dc3545';
                        amount.focus();
                    }
                }

                if (!isValid) {
                    e.preventDefault();

                    // Show error alert
                    const errorDiv = document.createElement('div');
                    errorDiv.style.cssText = `
                        background: linear-gradient(135deg, #dc354520 0%, #dc354530 100%);
                        border-left: 5px solid #dc3545;
                        padding: 18px 20px;
                        border-radius: 10px;
                        margin-bottom: 20px;
                        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
                        display: flex;
                        align-items: center;
                    `;
                    errorDiv.innerHTML = `
                        <i class="fas fa-exclamation-circle" style="color: #dc3545; font-size: 1.5em; margin-right: 12px;"></i>
                        <span style="color: #dc3545; font-weight: 600; font-size: 1.05em;">${errorMessage}</span>
                    `;

                    const formContainer = form.parentElement;
                    const existingError = formContainer.querySelector('.error-alert');
                    if (existingError) {
                        existingError.remove();
                    }

                    errorDiv.className = 'error-alert';
                    form.insertBefore(errorDiv, form.firstChild);

                    // Remove error after 5 seconds
                    setTimeout(() => {
                        errorDiv.remove();
                    }, 5000);

                    return false;
                }

                // Show loading state
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.7';
                }
            });
        }

        // ============================================
        // RESET BORDER COLOR ON INPUT
        // ============================================
        const allInputs = document.querySelectorAll('input, select');
        allInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.style.borderColor = primaryColor;
            });
        });

        // ============================================
        // AUTO-DISMISS SUCCESS MESSAGE
        // ============================================
        setTimeout(() => {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }
        }, 5000);

        console.log('💳 Withdraw Form Initialized');
        console.log('Theme Colors:', { primary: primaryColor, secondary: secondaryColor });
    });
})();
</script>

@endsection
