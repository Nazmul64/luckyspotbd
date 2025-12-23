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
                            <i class="fas fa-wallet" style="color: {{ $primaryColor }}; margin-right: 10px;"></i>
                            Add Deposit
                        </h4>
                    </div>

                    {{-- Deposit Limit Info --}}
                    @if(isset($deposite_limit))
                        <div style="background: linear-gradient(135deg, {{ $primaryColor }}20 0%, {{ $primaryColor }}30 100%); border-left: 5px solid {{ $primaryColor }}; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <i class="fas fa-info-circle" style="color: {{ $primaryColor }}; font-size: 1.5em; margin-right: 12px;"></i>
                                <h5 style="color: {{ $secondaryColor }}; font-weight: bold; margin: 0;">Deposit Limits</h5>
                            </div>
                            <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-top: 15px;">
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: {{ $secondaryColor }}; margin: 0; font-size: 0.9em; opacity: 0.8;">Minimum Deposit:</p>
                                    <p style="color: {{ $primaryColor }}; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        {{ $deposite_limit->minimum_deposite ?? 0 }} টাকা
                                    </p>
                                </div>
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: {{ $secondaryColor }}; margin: 0; font-size: 0.9em; opacity: 0.8;">Maximum Deposit:</p>
                                    <p style="color: {{ $primaryColor }}; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        {{ $deposite_limit->maximum_deposite ?? 0 }} টাকা
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('frontend.deposit.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Amount --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-money-bill-wave" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                Amount *
                            </label>
                            <input type="number"
                                   name="amount"
                                   class="form-input"
                                   step="0.01"
                                   min="{{ $deposite_limit->minimum_deposite ?? 0 }}"
                                   max="{{ $deposite_limit->maximum_deposite ?? 0 }}"
                                   placeholder="Enter amount between {{ $deposite_limit->minimum_deposite ?? 0 }} and {{ $deposite_limit->maximum_deposite ?? 0 }}"
                                   style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            @error('amount')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Payment Method --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-credit-card" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                Payment Method *
                            </label>
                            <select id="payment_method_select"
                                    name="payment_method"
                                    class="form-select"
                                    style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05); cursor: pointer;">
                                <option value="">-- Select Payment Method --</option>
                                @foreach ($payment_method_name as $item)
                                    <option
                                        value="{{ $item->id }}"
                                        data-number="{{ $item->accountnumber ?? '' }}">
                                        {{ $item->accountnumber ?? '' }} -- {{ $item->bankname ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror

                            {{-- Copy Account Number --}}
                            <div style="margin-top: 15px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                <input type="text"
                                       id="copy_account_number"
                                       readonly
                                       placeholder="Select payment method to see account number"
                                       style="flex: 1; min-width: 250px; padding: 12px 18px; border: 2px solid {{ $primaryColor }}30; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: {{ $primaryColor }}05; font-weight: 600;">
                                <button type="button"
                                        id="copy_button"
                                        class="copy-btn"
                                        style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.15); white-space: nowrap;">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>

                        {{-- Transaction ID --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-hashtag" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                Transaction ID <span style="opacity: 0.6; font-size: 0.9em;">(optional)</span>
                            </label>
                            <input type="text"
                                   name="transaction_id"
                                   class="form-input"
                                   placeholder="Enter your transaction ID"
                                   style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        </div>

                        {{-- Screenshot --}}
                        <div style="margin-bottom: 30px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-image" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                Payment Screenshot <span style="opacity: 0.6; font-size: 0.9em;">(optional)</span>
                            </label>
                            <div style="position: relative;">
                                <input type="file"
                                       name="screenshot"
                                       class="form-file"
                                       accept="image/*"
                                       style="width: 100%; padding: 15px 20px; border: 2px dashed {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: {{ $primaryColor }}05; transition: all 0.3s ease; cursor: pointer;">
                            </div>
                            @error('screenshot')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                            <p style="color: {{ $secondaryColor }}; opacity: 0.6; font-size: 0.85em; margin-top: 8px; margin-bottom: 0;">
                                <i class="fas fa-info-circle"></i> Upload a clear screenshot of your payment confirmation
                            </p>
                        </div>

                        {{-- Submit Button --}}
                        <div style="margin-top: 30px;">
                            <button type="submit"
                                    class="submit-btn"
                                    style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $primaryColor }}dd 100%); color: {{ $secondaryColor }}; border: none; padding: 18px 40px; border-radius: 10px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(0,0,0,0.2); width: 100%; max-width: 300px;">
                                <i class="fas fa-paper-plane"></i> Submit Deposit
                            </button>
                        </div>
                    </form>

                    {{-- Help Section --}}
                    <div style="margin-top: 40px; padding: 20px; background-color: {{ $secondaryColor }}05; border-radius: 10px; border: 1px solid {{ $primaryColor }}30;">
                        <h6 style="color: {{ $secondaryColor }}; font-weight: bold; margin-bottom: 12px;">
                            <i class="fas fa-question-circle" style="color: {{ $primaryColor }};"></i> Need Help?
                        </h6>
                        <ul style="margin: 0; padding-left: 20px; color: {{ $secondaryColor }}; opacity: 0.8; line-height: 1.8;">
                            <li>Select your payment method and copy the account number</li>
                            <li>Make the payment using your preferred method</li>
                            <li>Enter the transaction ID and upload screenshot (optional but recommended)</li>
                            <li>Submit the form and wait for admin approval</li>
                        </ul>
                    </div>

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
        const paymentSelect = document.getElementById('payment_method_select');
        const copyInput = document.getElementById('copy_account_number');
        const copyButton = document.getElementById('copy_button');

        // ============================================
        // PAYMENT METHOD SELECTION
        // ============================================
        if (paymentSelect && copyInput) {
            paymentSelect.addEventListener('change', function () {
                const selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
                const accountNumber = selectedOption.dataset.number || '';

                copyInput.value = accountNumber;

                if (accountNumber) {
                    copyInput.style.backgroundColor = primaryColor + '15';
                    copyInput.style.borderColor = primaryColor;
                    copyButton.style.opacity = '1';
                    copyButton.disabled = false;
                } else {
                    copyInput.style.backgroundColor = primaryColor + '05';
                    copyInput.style.borderColor = primaryColor + '30';
                    copyButton.style.opacity = '0.5';
                    copyButton.disabled = true;
                }
            });
        }

        // ============================================
        // COPY ACCOUNT NUMBER
        // ============================================
        if (copyButton && copyInput) {
            copyButton.addEventListener('click', function () {
                if (!copyInput.value) {
                    alert('Please select a payment method first!');
                    return;
                }

                copyInput.select();
                copyInput.setSelectionRange(0, 99999); // For mobile

                try {
                    document.execCommand('copy');

                    // Success feedback
                    const originalText = copyButton.innerHTML;
                    copyButton.innerHTML = '<i class="fas fa-check"></i> Copied!';
                    copyButton.style.backgroundColor = '#28a745';

                    setTimeout(() => {
                        copyButton.innerHTML = originalText;
                        copyButton.style.backgroundColor = primaryColor;
                    }, 2000);

                } catch (err) {
                    alert('Failed to copy. Please copy manually: ' + copyInput.value);
                }
            });
        }

        // ============================================
        // INPUT FOCUS EFFECTS
        // ============================================
        const formInputs = document.querySelectorAll('.form-input, .form-select, .form-file');
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

        const copyBtn = document.querySelector('.copy-btn');
        if (copyBtn) {
            copyBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
                this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.25)';
            });

            copyBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            });
        }

        // ============================================
        // FORM VALIDATION
        // ============================================
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const amount = document.querySelector('input[name="amount"]');
                const paymentMethod = document.querySelector('select[name="payment_method"]');

                let isValid = true;
                let errorMessage = '';

                if (!amount || !amount.value || parseFloat(amount.value) <= 0) {
                    isValid = false;
                    errorMessage = 'Please enter a valid amount!';
                    if (amount) {
                        amount.style.borderColor = '#dc3545';
                        amount.focus();
                    }
                }

                if (!paymentMethod || !paymentMethod.value) {
                    isValid = false;
                    errorMessage = 'Please select a payment method!';
                    if (paymentMethod) {
                        paymentMethod.style.borderColor = '#dc3545';
                        if (isValid) paymentMethod.focus();
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                    return false;
                }

                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                submitBtn.disabled = true;
            });
        }

        console.log('💳 Deposit Form Initialized');
        console.log('Theme Colors:', { primary: primaryColor, secondary: secondaryColor });
    });
})();
</script>

@endsection
