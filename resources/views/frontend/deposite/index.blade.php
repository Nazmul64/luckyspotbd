@extends('frontend.master')

@section('content')

@php
    use Carbon\Carbon;

    // Helper function for multi-language fields
    if (!function_exists('lang_field')) {
        function lang_field($field) {
            if (is_array($field)) {
                return $field[app()->getLocale()] ?? $field['en'] ?? '';
            }
            return $field ?? '';
        }
    }

    // Get current language
    $currentLang = app()->getLocale();
    $isBangla = $currentLang === 'bn';
    $currency = $isBangla ? 'টাকা' : 'Taka';

    // All translations
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
        'click_to_upload' => $isBangla ? 'আপলোড করতে ক্লিক করুন' : 'Click to upload',
        'or_drag' => $isBangla ? 'অথবা এখানে টেনে আনুন' : 'or drag and drop here',
        'remove_image' => $isBangla ? 'ছবি মুছুন' : 'Remove Image',
        'change_image' => $isBangla ? 'ছবি পরিবর্তন করুন' : 'Change Image',
        'image_preview' => $isBangla ? 'ছবি প্রিভিউ' : 'Image Preview',
    ];
@endphp

<style>
:root {
    --primary-color: #30cfd0;
    --secondary-color: #086755;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --white: #ffffff;
    --transition: all 0.3s ease;
}

/* MAIN CONTAINER */
.deposit-container {
    padding: 40px 30px;
    background: linear-gradient(135deg, rgba(48, 207, 208, 0.06) 0%, rgba(8, 103, 85, 0.06) 100%);
    border-radius: 15px;
    border: 2px solid var(--primary-color);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

/* HEADER */
.deposit-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 3px solid var(--primary-color);
}

.deposit-header h4 {
    color: var(--white);
    font-weight: bold;
    font-size: 1.8em;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.deposit-header i {
    color: var(--primary-color);
}

/* DEPOSIT LIMIT BOX */
.limit-info-box {
    background: linear-gradient(135deg, rgba(48, 207, 208, 0.12) 0%, rgba(48, 207, 208, 0.18) 100%);
    border-left: 5px solid var(--primary-color);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.limit-info-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    gap: 12px;
}

.limit-info-header i {
    color: var(--primary-color);
    font-size: 1.5em;
}

.limit-info-header h5 {
    color: var(--white);
    font-weight: bold;
    margin: 0;
}

.limit-values {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    margin-top: 15px;
}

.limit-item {
    flex: 1;
    min-width: 200px;
}

.limit-label {
    color: var(--white);
    margin: 0;
    font-size: 0.9em;
    opacity: 0.8;
}

.limit-value {
    color: var(--primary-color);
    font-weight: bold;
    font-size: 1.3em;
    margin: 5px 0 0 0;
}

/* FORM ELEMENTS */
.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    color: var(--white);
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 1.05em;
}

.form-label i {
    color: var(--primary-color);
    margin-right: 8px;
}

.form-label .optional {
    opacity: 0.6;
    font-size: 0.9em;
}

.form-input,
.form-select {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid var(--primary-color);
    border-radius: 10px;
    font-size: 1em;
    color: var(--white);
    background-color: rgba(255, 255, 255, 0.1);
    transition: var(--transition);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(48, 207, 208, 0.12);
    transform: scale(1.01);
}

.form-select {
    cursor: pointer;
}

.form-select option {
    color: #000;
    background-color: #fff;
}

.error-message {
    color: var(--danger-color);
    font-size: 0.9em;
    margin-top: 5px;
    display: block;
}

.error-message i {
    margin-right: 5px;
}

/* COPY ACCOUNT NUMBER */
.copy-section {
    margin-top: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.copy-input {
    flex: 1;
    min-width: 250px;
    padding: 12px 18px;
    border: 2px solid rgba(48, 207, 208, 0.18);
    border-radius: 8px;
    font-size: 0.95em;
    color: var(--white);
    background-color: rgba(48, 207, 208, 0.03);
    font-weight: 600;
}

.copy-btn {
    background-color: var(--primary-color);
    color: var(--white);
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    white-space: nowrap;
}

.copy-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
}

.copy-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* IMAGE UPLOAD ZONE */
.upload-zone {
    position: relative;
    border: 2px dashed var(--primary-color);
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    background-color: rgba(48, 207, 208, 0.03);
    transition: var(--transition);
    cursor: pointer;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-zone:hover {
    border-color: var(--primary-color);
    background-color: rgba(48, 207, 208, 0.08);
    transform: scale(1.01);
}

.upload-zone.dragover {
    border-color: var(--primary-color);
    background-color: rgba(48, 207, 208, 0.12);
    border-style: solid;
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

/* UPLOAD PLACEHOLDER */
.upload-placeholder {
    pointer-events: none;
}

.upload-icon {
    font-size: 3em;
    color: var(--primary-color);
    margin-bottom: 15px;
    display: block;
}

.upload-text {
    color: var(--white);
    font-size: 1em;
    margin: 0 0 8px 0;
    font-weight: 600;
}

.upload-hint {
    color: var(--white);
    opacity: 0.6;
    font-size: 0.85em;
    margin: 0;
}

/* IMAGE PREVIEW */
.preview-container {
    display: none;
    position: relative;
}

.preview-container.active {
    display: block;
}

.preview-wrapper {
    position: relative;
    display: inline-block;
    max-width: 100%;
}

.preview-image {
    max-width: 100%;
    max-height: 400px;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    display: block;
    margin: 0 auto;
}

.preview-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    border-radius: 10px;
    opacity: 0;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-wrapper:hover .preview-overlay {
    opacity: 1;
}

.preview-actions {
    margin-top: 15px;
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-action {
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    font-size: 0.95em;
}

.btn-change {
    background-color: var(--primary-color);
    color: var(--white);
}

.btn-change:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-remove {
    background-color: var(--danger-color);
    color: var(--white);
}

.btn-remove:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
}

/* SUBMIT BUTTON */
.submit-section {
    margin-top: 30px;
}

.submit-btn {
    background: linear-gradient(135deg, var(--primary-color) 0%, #2ab5b6 100%);
    color: var(--white);
    border: none;
    padding: 18px 40px;
    border-radius: 10px;
    font-size: 1.1em;
    font-weight: bold;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 300px;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    opacity: 0.95;
}

.submit-btn:active {
    transform: translateY(-1px);
}

.submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* HELP SECTION */
.help-section {
    margin-top: 40px;
    padding: 20px;
    background-color: rgba(8, 103, 85, 0.05);
    border-radius: 10px;
    border: 1px solid rgba(48, 207, 208, 0.18);
}

.help-title {
    color: var(--white);
    font-weight: bold;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.help-title i {
    color: var(--primary-color);
}

.help-list {
    margin: 0;
    padding-left: 20px;
    color: var(--white);
    opacity: 0.8;
    line-height: 1.8;
}

.help-list li {
    margin-bottom: 8px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .deposit-container {
        padding: 25px 20px;
    }

    .deposit-header h4 {
        font-size: 1.4em;
    }

    .limit-values {
        flex-direction: column;
        gap: 15px;
    }

    .copy-section {
        flex-direction: column;
        align-items: stretch;
    }

    .copy-btn {
        width: 100%;
    }

    .submit-btn {
        max-width: 100%;
    }

    .preview-image {
        max-height: 300px;
    }
}
</style>

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            {{-- SIDEBAR --}}
            @include('frontend.dashboard.sidebar')

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9">
                <div class="deposit-container">

                    {{-- Header --}}
                    <div class="deposit-header">
                        <h4>
                            <i class="fas fa-wallet"></i>
                            {{ $text['page_title'] }}
                        </h4>
                    </div>

                    {{-- Deposit Limit Info --}}
                    @if(isset($deposite_limit))
                        <div class="limit-info-box">
                            <div class="limit-info-header">
                                <i class="fas fa-info-circle"></i>
                                <h5>{{ $text['deposit_limits'] }}</h5>
                            </div>
                            <div class="limit-values">
                                <div class="limit-item">
                                    <p class="limit-label">{{ $text['minimum_deposit'] }}:</p>
                                    <p class="limit-value">
                                        {{ is_array($deposite_limit->minimum_deposite) ? ($deposite_limit->minimum_deposite[$currentLang] ?? 0) : $deposite_limit->minimum_deposite }} {{ $currency }}
                                    </p>
                                </div>
                                <div class="limit-item">
                                    <p class="limit-label">{{ $text['maximum_deposit'] }}:</p>
                                    <p class="limit-value">
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
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave"></i>
                                {{ $text['amount'] }} *
                            </label>
                            <input type="number"
                                   name="amount"
                                   class="form-input"
                                   step="0.01"
                                   min="{{ $deposite_limit->minimum_deposite ?? 0 }}"
                                   max="{{ $deposite_limit->maximum_deposite ?? 0 }}"
                                   placeholder="{{ $text['enter_amount_between'] }} {{ $deposite_limit->minimum_deposite ?? 0 }} {{ $text['and'] }} {{ $deposite_limit->maximum_deposite ?? 0 }} {{ $currency }}"
                                   required>
                            @error('amount')
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Payment Method --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-credit-card"></i>
                                {{ $text['payment_method'] }} *
                            </label>
                            <select id="payment_method_select"
                                    name="payment_method"
                                    class="form-select"
                                    required>
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
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror

                            {{-- Copy Account Number --}}
                            <div class="copy-section">
                                <input type="text"
                                       id="copy_account_number"
                                       class="copy-input"
                                       readonly
                                       placeholder="{{ $text['select_payment_placeholder'] }}">
                                <button type="button" id="copy_button" class="copy-btn" disabled>
                                    <i class="fas fa-copy"></i> {{ $text['copy'] }}
                                </button>
                            </div>
                        </div>

                        {{-- Transaction ID --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-hashtag"></i>
                                {{ $text['transaction_id'] }} <span class="optional">({{ $text['optional'] }})</span>
                            </label>
                            <input type="text"
                                   name="transaction_id"
                                   class="form-input"
                                   placeholder="{{ $text['enter_transaction_id'] }}">
                        </div>

                        {{-- Screenshot with Preview --}}
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-image"></i>
                                {{ $text['payment_screenshot'] }} <span class="optional">({{ $text['optional'] }})</span>
                            </label>

                            <div class="upload-zone" id="upload-zone">
                                <input type="file"
                                       name="screenshot"
                                       id="screenshot-input"
                                       class="file-input"
                                       accept="image/*">

                                {{-- Upload Placeholder --}}
                                <div id="upload-placeholder" class="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p class="upload-text">{{ $text['click_to_upload'] }}</p>
                                    <p class="upload-hint">
                                        <i class="fas fa-hand-pointer"></i> {{ $text['or_drag'] }}
                                    </p>
                                    <p class="upload-hint" style="margin-top: 10px;">
                                        <i class="fas fa-info-circle"></i> {{ $text['upload_screenshot_info'] }}
                                    </p>
                                </div>

                                {{-- Image Preview --}}
                                <div id="preview-container" class="preview-container">
                                    <div class="preview-wrapper">
                                        <img id="preview-image" src="" alt="{{ $text['image_preview'] }}" class="preview-image">
                                        <div class="preview-overlay">
                                            <i class="fas fa-search-plus" style="color: white; font-size: 2em;"></i>
                                        </div>
                                    </div>
                                    <div class="preview-actions">
                                        <button type="button" id="change-image-btn" class="btn-action btn-change">
                                            <i class="fas fa-sync-alt"></i> {{ $text['change_image'] }}
                                        </button>
                                        <button type="button" id="remove-image-btn" class="btn-action btn-remove">
                                            <i class="fas fa-trash-alt"></i> {{ $text['remove_image'] }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @error('screenshot')
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="submit-section">
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-paper-plane"></i> {{ $text['submit_deposit'] }}
                            </button>
                        </div>
                    </form>

                    {{-- Help Section --}}
                    <div class="help-section">
                        <h6 class="help-title">
                            <i class="fas fa-question-circle"></i>
                            {{ $text['need_help'] }}
                        </h6>
                        <ul class="help-list">
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

{{-- JavaScript --}}
<script>
(function() {
    'use strict';

    // Translations
    const T = {
        selectPaymentFirst: '{{ $isBangla ? "প্রথমে একটি পেমেন্ট পদ্ধতি নির্বাচন করুন!" : "Please select a payment method first!" }}',
        copied: '{{ $isBangla ? "কপি হয়েছে!" : "Copied!" }}',
        copy: '{{ $isBangla ? "কপি করুন" : "Copy" }}',
        failedToCopy: '{{ $isBangla ? "কপি করতে ব্যর্থ" : "Failed to copy" }}',
        invalidFileType: '{{ $isBangla ? "শুধুমাত্র ছবি ফাইল আপলোড করুন (JPG, PNG, GIF, WEBP)" : "Please upload only image files (JPG, PNG, GIF, WEBP)" }}',
        fileTooLarge: '{{ $isBangla ? "ফাইল সাইজ ৫MB এর কম হতে হবে" : "File size must be less than 5MB" }}',
        processing: '{{ $isBangla ? "প্রসেস করা হচ্ছে..." : "Processing..." }}'
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const form = document.getElementById('deposit-form');
        const paymentSelect = document.getElementById('payment_method_select');
        const copyInput = document.getElementById('copy_account_number');
        const copyBtn = document.getElementById('copy_button');
        const submitBtn = form.querySelector('.submit-btn');

        // Image Upload Elements
        const screenshotInput = document.getElementById('screenshot-input');
        const uploadZone = document.getElementById('upload-zone');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        const changeBtn = document.getElementById('change-image-btn');
        const removeBtn = document.getElementById('remove-image-btn');

        // ==========================================
        // PAYMENT METHOD SELECTION
        // ==========================================
        if (paymentSelect && copyInput && copyBtn) {
            paymentSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const accountNumber = selectedOption.dataset.number || '';

                copyInput.value = accountNumber;

                if (accountNumber) {
                    copyInput.style.backgroundColor = 'rgba(48, 207, 208, 0.08)';
                    copyInput.style.borderColor = 'var(--primary-color)';
                    copyBtn.disabled = false;
                } else {
                    copyInput.style.backgroundColor = 'rgba(48, 207, 208, 0.03)';
                    copyInput.style.borderColor = 'rgba(48, 207, 208, 0.18)';
                    copyBtn.disabled = true;
                }
            });

            // Copy Button
            copyBtn.addEventListener('click', function() {
                if (!copyInput.value) {
                    alert(T.selectPaymentFirst);
                    return;
                }

                copyInput.select();
                copyInput.setSelectionRange(0, 99999);

                try {
                    const successful = document.execCommand('copy');
                    if (successful) {
                        const originalHTML = copyBtn.innerHTML;
                        const originalBg = copyBtn.style.backgroundColor;

                        copyBtn.innerHTML = '<i class="fas fa-check"></i> ' + T.copied;
                        copyBtn.style.backgroundColor = '#28a745';

                        setTimeout(() => {
                            copyBtn.innerHTML = originalHTML;
                            copyBtn.style.backgroundColor = originalBg || 'var(--primary-color)';
                        }, 2000);
                    }
                } catch (err) {
                    console.error('Copy failed:', err);
                    alert(T.failedToCopy + ': ' + copyInput.value);
                }
            });
        }

        // ==========================================
        // IMAGE UPLOAD & PREVIEW
        // ==========================================
        if (screenshotInput && uploadZone && previewImage) {

            // File Input Change
            screenshotInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    handleFile(file);
                }
            });

            // Drag & Drop Events
            uploadZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('dragover');
            });

            uploadZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('dragover');
            });

            uploadZone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const file = files[0];
                    // Set the file to input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    screenshotInput.files = dataTransfer.files;
                    handleFile(file);
                }
            });

            // Change Image Button
            if (changeBtn) {
                changeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    screenshotInput.click();
                });
            }

            // Remove Image Button
            if (removeBtn) {
                removeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    clearPreview();
                });
            }

            // Handle File
            function handleFile(file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert(T.invalidFileType);
                    clearPreview();
                    return;
                }

                // Validate file size (5MB)
                const maxSize = 5 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert(T.fileTooLarge);
                    clearPreview();
                    return;
                }

                // Read and display image
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    showPreview();
                };
                reader.onerror = function() {
                    console.error('Failed to read file');
                    clearPreview();
                };
                reader.readAsDataURL(file);
            }

            // Show Preview
            function showPreview() {
                uploadPlaceholder.style.display = 'none';
                previewContainer.classList.add('active');
                uploadZone.style.padding = '20px';
                uploadZone.style.backgroundColor = 'rgba(48, 207, 208, 0.06)';
                uploadZone.style.minHeight = 'auto';
            }

            // Clear Preview
            function clearPreview() {
                screenshotInput.value = '';
                previewImage.src = '';
                uploadPlaceholder.style.display = 'block';
                previewContainer.classList.remove('active');
                uploadZone.style.padding = '30px';
                uploadZone.style.backgroundColor = 'rgba(48, 207, 208, 0.03)';
                uploadZone.style.minHeight = '200px';
            }
        }

        // ==========================================
        // FORM VALIDATION
        // ==========================================
        if (form) {
            form.addEventListener('submit', function(e) {
                const amount = form.querySelector('[name="amount"]').value;
                const paymentMethod = form.querySelector('[name="payment_method"]').value;

                if (!amount || parseFloat(amount) <= 0) {
                    e.preventDefault();
                    alert('{{ $isBangla ? "অনুগ্রহ করে একটি বৈধ পরিমাণ লিখুন!" : "Please enter a valid amount!" }}');
                    return false;
                }

                if (!paymentMethod) {
                    e.preventDefault();
                    alert('{{ $isBangla ? "অনুগ্রহ করে একটি পেমেন্ট পদ্ধতি নির্বাচন করুন!" : "Please select a payment method!" }}');
                    return false;
                }

                // Disable submit button
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + T.processing;
                }
            });
        }

        // ==========================================
        // INPUT FOCUS EFFECTS
        // ==========================================
        const inputs = document.querySelectorAll('.form-input, .form-select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = 'var(--primary-color)';
                this.style.boxShadow = '0 0 0 4px rgba(48, 207, 208, 0.12)';
            });

            input.addEventListener('blur', function() {
                this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.05)';
            });
        });

        console.log('✅ Deposit Form Initialized - Image Preview Ready!');
    });
})();
</script>

@endsection
