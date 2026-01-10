@extends('frontend.master')

@section('content')

@php
    // Fetch active theme colors
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#F5CE0D';
    $secondaryColor = $activeTheme->secondary_color ?? '#000000';

    // Helper function for multi-language fields
    if (!function_exists('lang_field')) {
        function lang_field($field) {
            if (is_array($field)) {
                return $field[app()->getLocale()] ?? $field['en'] ?? '';
            }
            return $field ?? '';
        }
    }

    // Get current language and set translations
    $currentLang = app()->getLocale();
    $isBangla = $currentLang === 'bn';

    // Currency based on language
    $currency = $isBangla ? 'টাকা' : 'Taka';

    // All text translations
    $text = [
        'page_title' => $isBangla ? 'ডিপোজিট যোগ করুন' : 'Add Deposit',
        'deposit_limits' => $isBangla ? 'ডিপোজিট সীমা' : 'Deposit Limits',
        'minimum_deposit' => $isBangla ? 'সর্বনিম্ন ডিপোজিট' : 'Minimum Deposit',
        'maximum_deposit' => $isBangla ? 'সর্বোচ্চ ডিপোজিট' : 'Maximum Deposit',
        'amount' => $isBangla ? 'পরিমাণ' : 'Amount',
        'payment_method' => $isBangla ? 'পেমেন্ট পদ্ধতি' : 'Payment Method',
        'select_payment' => $isBangla ? 'পেমেন্ট পদ্ধতি নির্বাচন করুন' : 'Select Payment Method',
        'transaction_id' => $isBangla ? 'ট্রানজেকশন আইডি' : 'Transaction ID',
        'payment_screenshot' => $isBangla ? 'পেমেন্ট স্ক্রিনশট' : 'Payment Screenshot',
        'optional' => $isBangla ? 'ঐচ্ছিক' : 'optional',
        'copy' => $isBangla ? 'কপি করুন' : 'Copy',
        'submit_deposit' => $isBangla ? 'ডিপোজিট জমা দিন' : 'Submit Deposit',
        'need_help' => $isBangla ? 'সাহায্য প্রয়োজন?' : 'Need Help?',
        'enter_amount_between' => $isBangla ? 'পরিমাণ লিখুন' : 'Enter amount between',
        'and' => $isBangla ? 'থেকে' : 'and',
        'select_payment_placeholder' => $isBangla ? 'অ্যাকাউন্ট নম্বর দেখতে পেমেন্ট পদ্ধতি নির্বাচন করুন' : 'Select payment method to see account number',
        'enter_transaction_id' => $isBangla ? 'আপনার ট্রানজেকশন আইডি লিখুন' : 'Enter your transaction ID',
        'upload_screenshot_info' => $isBangla ? 'আপনার পেমেন্ট নিশ্চিতকরণের একটি স্পষ্ট স্ক্রিনশট আপলোড করুন' : 'Upload a clear screenshot of your payment confirmation',
        'help_1' => $isBangla ? 'আপনার পেমেন্ট পদ্ধতি নির্বাচন করুন এবং অ্যাকাউন্ট নম্বর কপি করুন' : 'Select your payment method and copy the account number',
        'help_2' => $isBangla ? 'আপনার পছন্দের পদ্ধতি ব্যবহার করে পেমেন্ট করুন' : 'Make the payment using your preferred method',
        'help_3' => $isBangla ? 'ট্রানজেকশন আইডি লিখুন এবং স্ক্রিনশট আপলোড করুন (ঐচ্ছিক কিন্তু সুপারিশকৃত)' : 'Enter the transaction ID and upload screenshot (optional but recommended)',
        'help_4' => $isBangla ? 'ফর্ম জমা দিন এবং অ্যাডমিন অনুমোদনের জন্য অপেক্ষা করুন' : 'Submit the form and wait for admin approval',
    ];
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
                            {{ $text['page_title'] }}
                        </h4>
                    </div>

                    {{-- Deposit Limit Info --}}
                    @if(isset($deposite_limit))
                        <div style="background: linear-gradient(135deg, {{ $primaryColor }}20 0%, {{ $primaryColor }}30 100%); border-left: 5px solid {{ $primaryColor }}; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <i class="fas fa-info-circle" style="color: {{ $primaryColor }}; font-size: 1.5em; margin-right: 12px;"></i>
                                <h5 style="color: {{ $secondaryColor }}; font-weight: bold; margin: 0;">
                                    {{ $text['deposit_limits'] }}
                                </h5>
                            </div>
                            <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-top: 15px;">
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: {{ $secondaryColor }}; margin: 0; font-size: 0.9em; opacity: 0.8;">
                                        {{ $text['minimum_deposit'] }}:
                                    </p>
                                    <p style="color: {{ $primaryColor }}; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        {{ is_array($deposite_limit->minimum_deposite) ? ($deposite_limit->minimum_deposite[$currentLang] ?? 0) : $deposite_limit->minimum_deposite }} {{ $currency }}
                                    </p>
                                </div>
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: {{ $secondaryColor }}; margin: 0; font-size: 0.9em; opacity: 0.8;">
                                        {{ $text['maximum_deposit'] }}:
                                    </p>
                                    <p style="color: {{ $primaryColor }}; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        {{ is_array($deposite_limit->maximum_deposite) ? ($deposite_limit->maximum_deposite[$currentLang] ?? 0) : $deposite_limit->maximum_deposite }} {{ $currency }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Deposit Form --}}
                    <form action="{{ route('frontend.deposit.store') }}" method="POST" enctype="multipart/form-data" id="deposit-form">
                        @csrf

                        {{-- Amount --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-money-bill-wave" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                {{ $text['amount'] }} *
                            </label>
                            <input type="number"
                                   name="amount"
                                   class="form-input"
                                   step="0.01"
                                   min="{{ $deposite_limit->minimum_deposite ?? 0 }}"
                                   max="{{ $deposite_limit->maximum_deposite ?? 0 }}"
                                   placeholder="{{ $text['enter_amount_between'] }} {{ $deposite_limit->minimum_deposite ?? 0 }} {{ $text['and'] }} {{ $deposite_limit->maximum_deposite ?? 0 }} {{ $currency }}"
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
                                {{ $text['payment_method'] }} *
                            </label>
                            <select id="payment_method_select"
                                    name="payment_method"
                                    class="form-select"
                                    style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05); cursor: pointer;">
                                <option value="">-- {{ $text['select_payment'] }} --</option>
                                @foreach ($payment_method_name as $item)
                                    @php
                                        $accountNumber = lang_field($item->accountnumber);
                                        $bankName = lang_field($item->bankname);
                                    @endphp
                                    <option value="{{ $item->id }}" data-number="{{ $accountNumber }}">
                                        {{ $accountNumber }} -- {{ $bankName }}
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
                                       placeholder="{{ $text['select_payment_placeholder'] }}"
                                       style="flex: 1; min-width: 250px; padding: 12px 18px; border: 2px solid {{ $primaryColor }}30; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: {{ $primaryColor }}05; font-weight: 600;">
                                <button type="button"
                                        id="copy_button"
                                        class="copy-btn"
                                        style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.15); white-space: nowrap;">
                                    <i class="fas fa-copy"></i> {{ $text['copy'] }}
                                </button>
                            </div>
                        </div>

                        {{-- Transaction ID --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-hashtag" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                {{ $text['transaction_id'] }} <span style="opacity: 0.6; font-size: 0.9em;">({{ $text['optional'] }})</span>
                            </label>
                            <input type="text"
                                   name="transaction_id"
                                   class="form-input"
                                   placeholder="{{ $text['enter_transaction_id'] }}"
                                   style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        </div>

                        {{-- Screenshot --}}
                        <div style="margin-bottom: 30px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-image" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                {{ $text['payment_screenshot'] }} <span style="opacity: 0.6; font-size: 0.9em;">({{ $text['optional'] }})</span>
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
                                <i class="fas fa-info-circle"></i> {{ $text['upload_screenshot_info'] }}
                            </p>
                        </div>

                        {{-- Submit Button --}}
                        <div style="margin-top: 30px;">
                            <button type="submit"
                                    class="submit-btn"
                                    style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $primaryColor }}dd 100%); color: {{ $secondaryColor }}; border: none; padding: 18px 40px; border-radius: 10px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(0,0,0,0.2); width: 100%; max-width: 300px;">
                                <i class="fas fa-paper-plane"></i> {{ $text['submit_deposit'] }}
                            </button>
                        </div>
                    </form>

                    {{-- Help Section --}}
                    <div style="margin-top: 40px; padding: 20px; background-color: {{ $secondaryColor }}05; border-radius: 10px; border: 1px solid {{ $primaryColor }}30;">
                        <h6 style="color: {{ $secondaryColor }}; font-weight: bold; margin-bottom: 12px;">
                            <i class="fas fa-question-circle" style="color: {{ $primaryColor }};"></i> {{ $text['need_help'] }}
                        </h6>
                        <ul style="margin: 0; padding-left: 20px; color: {{ $secondaryColor }}; opacity: 0.8; line-height: 1.8;">
                            <li>{{ $text['help_1'] }}</li>
                            <li>{{ $text['help_2'] }}</li>
                            <li>{{ $text['help_3'] }}</li>
                            <li>{{ $text['help_4'] }}</li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- JS Scripts --}}
<script>
(function() {
    'use strict';

    // Configuration
    const config = {
        primaryColor: '{{ $primaryColor }}',
        secondaryColor: '{{ $secondaryColor }}',
        currency: '{{ $currency }}',
        isBangla: {{ $isBangla ? 'true' : 'false' }}
    };

    // Translation object for JavaScript
    const translations = {
        selectPaymentFirst: '{{ $isBangla ? "প্রথমে একটি পেমেন্ট পদ্ধতি নির্বাচন করুন!" : "Please select a payment method first!" }}',
        copied: '{{ $isBangla ? "কপি হয়েছে!" : "Copied!" }}',
        copy: '{{ $isBangla ? "কপি করুন" : "Copy" }}',
        failedToCopy: '{{ $isBangla ? "কপি করতে ব্যর্থ। অনুগ্রহ করে ম্যানুয়ালি কপি করুন:" : "Failed to copy. Please copy manually:" }}',
        validAmountRequired: '{{ $isBangla ? "অনুগ্রহ করে একটি বৈধ পরিমাণ লিখুন!" : "Please enter a valid amount!" }}',
        paymentMethodRequired: '{{ $isBangla ? "অনুগ্রহ করে একটি পেমেন্ট পদ্ধতি নির্বাচন করুন!" : "Please select a payment method!" }}',
        processing: '{{ $isBangla ? "প্রসেস করা হচ্ছে..." : "Processing..." }}'
    };

    document.addEventListener('DOMContentLoaded', function () {
        // Elements
        const paymentSelect = document.getElementById('payment_method_select');
        const copyInput = document.getElementById('copy_account_number');
        const copyButton = document.getElementById('copy_button');
        const submitBtn = document.querySelector('.submit-btn');
        const form = document.getElementById('deposit-form');

        // Payment Method Change Handler
        if (paymentSelect && copyInput && copyButton) {
            paymentSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const accountNumber = selectedOption.dataset.number || '';
                copyInput.value = accountNumber;

                if (accountNumber) {
                    copyInput.style.backgroundColor = config.primaryColor + '15';
                    copyInput.style.borderColor = config.primaryColor;
                    copyButton.style.opacity = '1';
                    copyButton.disabled = false;
                } else {
                    copyInput.style.backgroundColor = config.primaryColor + '05';
                    copyInput.style.borderColor = config.primaryColor + '30';
                    copyButton.style.opacity = '0.5';
                    copyButton.disabled = true;
                }
            });

            // Copy Button Handler
            copyButton.addEventListener('click', function () {
                if (!copyInput.value) {
                    alert(translations.selectPaymentFirst);
                    return;
                }

                copyInput.select();
                copyInput.setSelectionRange(0, 99999);

                try {
                    document.execCommand('copy');
                    const originalHTML = copyButton.innerHTML;
                    copyButton.innerHTML = '<i class="fas fa-check"></i> ' + translations.copied;
                    copyButton.style.backgroundColor = '#28a745';

                    setTimeout(() => {
                        copyButton.innerHTML = originalHTML;
                        copyButton.style.backgroundColor = config.primaryColor;
                    }, 2000);
                } catch (err) {
                    alert(translations.failedToCopy + ' ' + copyInput.value);
                }
            });
        }

        // Form Input Focus Effects
        const formInputs = document.querySelectorAll('.form-input, .form-select, .form-file');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = config.primaryColor;
                this.style.boxShadow = `0 0 0 4px ${config.primaryColor}20`;
                this.style.transform = 'scale(1.01)';
            });

            input.addEventListener('blur', function() {
                this.style.borderColor = config.primaryColor;
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
                this.style.transform = 'scale(1)';
            });
        });

        // Submit Button Hover Effects
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

        // Copy Button Hover Effects
        if (copyButton) {
            copyButton.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
                this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.25)';
            });

            copyButton.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            });
        }

        // Form Validation
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                const amountInput = document.querySelector('input[name="amount"]');
                const paymentMethodSelect = document.querySelector('select[name="payment_method"]');

                let isValid = true;
                let errorMessage = '';

                // Validate amount
                if (!amountInput || !amountInput.value || parseFloat(amountInput.value) <= 0) {
                    isValid = false;
                    errorMessage = translations.validAmountRequired;
                    if (amountInput) {
                        amountInput.style.borderColor = '#dc3545';
                        amountInput.focus();
                    }
                }

                // Validate payment method
                if (isValid && (!paymentMethodSelect || !paymentMethodSelect.value)) {
                    isValid = false;
                    errorMessage = translations.paymentMethodRequired;
                    if (paymentMethodSelect) {
                        paymentMethodSelect.style.borderColor = '#dc3545';
                        paymentMethodSelect.focus();
                    }
                }

                // If invalid, prevent submission
                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                    return false;
                }

                // Show processing state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + translations.processing;
                submitBtn.disabled = true;
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.style.opacity = '0.7';
            });
        }

        // Console log for debugging
        console.log('💳 Deposit Form Initialized Successfully');
        console.log('📝 Configuration:', config);
        console.log('🌐 Language:', config.isBangla ? 'Bangla (বাংলা)' : 'English');
    });
})();
</script>

@endsection
