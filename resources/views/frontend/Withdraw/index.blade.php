@extends('frontend.master')

@section('content')

@php
    // ============================================
    // GET CURRENT LANGUAGE
    // ============================================
    $currentLang = app()->getLocale(); // 'en' or 'bn'

    // Hard-coded colors
    $primaryColor = '#30cfd0';
    $secondaryColor = '#086755';

    // ============================================
    // HELPER FUNCTION TO GET TRANSLATED TEXT
    // ============================================
    function getTranslated($data, $lang = 'en') {
        if (is_array($data)) {
            return $data[$lang] ?? $data['en'] ?? '';
        }
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded[$lang] ?? $decoded['en'] ?? '';
            }
            return $data;
        }
        return '';
    }

    // Get user balance
    $userBalance = Auth::user()->balance ?? 0;

    // Get withdraw limits from database
    $minWithdraw = $withdrawLimit->minimum_withdraw ?? 0;
    $maxWithdraw = $withdrawLimit->maximum_withdraw ?? 0;
@endphp

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            {{-- SIDEBAR --}}
            @include('frontend.dashboard.sidebar')

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9">
                <div style="padding: 40px 30px; background: linear-gradient(135deg, #30cfd010 0%, #08675510 100%); border-radius: 15px; border: 2px solid #30cfd0; box-shadow: 0 6px 25px rgba(0,0,0,0.1); margin-top: 20px;">

                    {{-- HEADER --}}
                    <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #30cfd0;">
                        <h4 style="color: #ffffff; font-weight: bold; font-size: 1.8em; margin: 0;">
                            <i class="fas fa-money-check-alt" style="color: #30cfd0; margin-right: 10px;"></i>
                            {{ $currentLang === 'bn' ? 'এখনই টাকা তুলুন!' : 'Withdraw Now!' }}
                        </h4>
                    </div>

                    {{-- AVAILABLE BALANCE CARD --}}
                    <div style="margin-bottom: 30px; padding: 25px; background: linear-gradient(135deg, #30cfd015 0%, #08675515 100%); border-radius: 12px; border: 2px solid #30cfd0; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <p style="color: #ffffff; margin: 0 0 8px 0; font-size: 0.95em; opacity: 0.8;">
                            <i class="fas fa-wallet" style="color: #30cfd0;"></i>
                            {{ $currentLang === 'bn' ? 'আপনার উপলব্ধ ব্যালেন্স' : 'Your Available Balance' }}
                        </p>
                        <h3 style="color: #30cfd0; font-weight: bold; font-size: 2.2em; margin: 0;">
                            ৳{{ number_format($userBalance, 2) }}
                        </h3>
                    </div>

                    {{-- WITHDRAW LIMITS --}}
                    @if(isset($withdrawLimit))
                        <div style="background: linear-gradient(135deg, #30cfd020 0%, #30cfd030 100%); border-left: 5px solid #30cfd0; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <i class="fas fa-info-circle" style="color: #30cfd0; font-size: 1.5em; margin-right: 12px;"></i>
                                <h5 style="color: #ffffff; font-weight: bold; margin: 0;">
                                    {{ $currentLang === 'bn' ? 'উত্তোলনের সীমা' : 'Withdraw Limits' }}
                                </h5>
                            </div>
                            <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-top: 15px;">
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: #ffffff; margin: 0; font-size: 0.9em; opacity: 0.8;">
                                        {{ $currentLang === 'bn' ? 'সর্বনিম্ন উত্তোলন:' : 'Minimum Withdraw:' }}
                                    </p>
                                    <p style="color: #30cfd0; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        ৳{{ number_format($minWithdraw, 2) }}
                                    </p>
                                </div>
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: #ffffff; margin: 0; font-size: 0.9em; opacity: 0.8;">
                                        {{ $currentLang === 'bn' ? 'সর্বোচ্চ উত্তোলন:' : 'Maximum Withdraw:' }}
                                    </p>
                                    <p style="color: #30cfd0; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        ৳{{ number_format($maxWithdraw, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                        <div class="success-alert" style="background: linear-gradient(135deg, #28a74520 0%, #28a74530 100%); border-left: 5px solid #28a745; padding: 18px 20px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15); display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: #28a745; font-size: 1.5em; margin-right: 12px;"></i>
                            <span style="color: #28a745; font-weight: 600; font-size: 1.05em;">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- ERROR MESSAGES --}}
                    @if($errors->any())
                        <div class="error-alert" style="background: linear-gradient(135deg, #dc354520 0%, #dc354530 100%); border-left: 5px solid #dc3545; padding: 18px 20px; border-radius: 10px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);">
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <i class="fas fa-exclamation-circle" style="color: #dc3545; font-size: 1.5em; margin-right: 12px;"></i>
                                <strong style="color: #dc3545; font-size: 1.05em;">
                                    {{ $currentLang === 'bn' ? 'দয়া করে নিম্নলিখিত ত্রুটিগুলি সংশোধন করুন:' : 'Please fix the following errors:' }}
                                </strong>
                            </div>
                            <ul style="margin: 0; padding-left: 20px; color: #dc3545;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- WITHDRAW FORM --}}
                    <form action="{{ route('Withdraw.submit') }}" method="POST" id="withdrawForm">
                        @csrf

                        {{-- AMOUNT --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: #ffffff; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-money-bill-wave" style="color: #30cfd0; margin-right: 8px;"></i>
                                {{ $currentLang === 'bn' ? 'উত্তোলনের পরিমাণ *' : 'Withdraw Amount *' }}
                            </label>
                            <input type="number"
                                   name="amount"
                                   id="withdrawAmount"
                                   class="form-input"
                                   step="0.01"
                                   min="{{ $minWithdraw }}"
                                   max="{{ $maxWithdraw }}"
                                   value="{{ old('amount') }}"
                                   placeholder="{{ $currentLang === 'bn' ? '৳' . number_format($minWithdraw, 0) . ' থেকে ৳' . number_format($maxWithdraw, 0) . ' এর মধ্যে পরিমাণ লিখুন' : 'Enter amount between ৳' . number_format($minWithdraw, 0) . ' and ৳' . number_format($maxWithdraw, 0) }}"
                                   style="width: 100%; padding: 15px 20px; border: 2px solid {{ $errors->has('amount') ? '#dc3545' : '#30cfd0' }}; border-radius: 10px; font-size: 1em; color: #ffffff; background-color: rgba(255,255,255,0.1); transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            @error('amount')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                            <small style="color: #ffffff; opacity: 0.7; display: block; margin-top: 5px;">
                                {{ $currentLang === 'bn' ? 'আপনার ব্যালেন্স: ৳' . number_format($userBalance, 2) : 'Your Balance: ৳' . number_format($userBalance, 2) }}
                            </small>
                        </div>

                        {{-- PAYMENT METHOD --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: #ffffff; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-university" style="color: #30cfd0; margin-right: 8px;"></i>
                                {{ $currentLang === 'bn' ? 'পেমেন্ট পদ্ধতি *' : 'Payment Method *' }}
                            </label>
                            <select name="payment_method"
                                    id="paymentMethod"
                                    class="form-select"
                                    style="width: 100%; padding: 15px 20px; border: 2px solid {{ $errors->has('payment_method') ? '#dc3545' : '#30cfd0' }}; border-radius: 10px; font-size: 1em; color: #ffffff; background-color: rgba(255,255,255,0.1); transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05); cursor: pointer;">
                                <option value="" style="color: #000;">{{ $currentLang === 'bn' ? '-- পেমেন্ট পদ্ধতি নির্বাচন করুন --' : '-- Select Payment Method --' }}</option>
                                @foreach($payment_method_name as $method)
                                    @php
                                        $bankName = getTranslated($method->bankname, $currentLang);
                                        $accountNumber = getTranslated($method->accountnumber, $currentLang);
                                    @endphp
                                    <option value="{{ $method->id }}"
                                            {{ old('payment_method') == $method->id ? 'selected' : '' }}
                                            style="color: #000;">
                                        {{ $bankName }} - {{ $accountNumber }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- ACCOUNT NUMBER --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: #ffffff; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-credit-card" style="color: #30cfd0; margin-right: 8px;"></i>
                                {{ $currentLang === 'bn' ? 'আপনার একাউন্ট নম্বর *' : 'Your Account Number *' }}
                            </label>
                            <input type="text"
                                   name="account_number"
                                   id="accountNumber"
                                   class="form-input"
                                   value="{{ old('account_number') }}"
                                   placeholder="{{ $currentLang === 'bn' ? 'আপনার একাউন্ট নম্বর লিখুন (যেমন: ০১XXXXXXXXX)' : 'Enter your account number (e.g., 01XXXXXXXXX)' }}"
                                   style="width: 100%; padding: 15px 20px; border: 2px solid {{ $errors->has('account_number') ? '#dc3545' : '#30cfd0' }}; border-radius: 10px; font-size: 1em; color: #ffffff; background-color: rgba(255,255,255,0.1); transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            @error('account_number')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <div style="margin-top: 30px;">
                            <button type="submit"
                                    class="submit-btn"
                                    style="background: linear-gradient(135deg, #30cfd0 0%, #30cfd0dd 100%); color: #ffffff; border: none; padding: 18px 40px; border-radius: 10px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(0,0,0,0.2); width: 100%; max-width: 300px;">
                                <i class="fas fa-paper-plane"></i> {{ $currentLang === 'bn' ? 'উত্তোলন জমা দিন' : 'Submit Withdraw' }}
                            </button>
                        </div>
                    </form>

                    {{-- IMPORTANT NOTES --}}
                    <div style="margin-top: 40px; padding: 20px; background-color: rgba(8, 103, 85, 0.05); border-radius: 10px; border: 1px solid #30cfd030;">
                        <h6 style="color: #ffffff; font-weight: bold; margin-bottom: 15px;">
                            <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i> {{ $currentLang === 'bn' ? 'গুরুত্বপূর্ণ তথ্য' : 'Important Notes' }}
                        </h6>
                        <ul style="margin: 0; padding-left: 20px; color: #ffffff; opacity: 0.8; line-height: 1.8;">
                            @if($currentLang === 'bn')
                                <li>জমা দেওয়ার আগে আপনার একাউন্ট নম্বর সঠিক কিনা নিশ্চিত করুন</li>
                                <li>উত্তোলনের পরিমাণ ৳{{ number_format($minWithdraw, 0) }} থেকে ৳{{ number_format($maxWithdraw, 0) }} এর মধ্যে হতে হবে</li>
                                <li>আপনার ব্যালেন্স যথেষ্ট আছে কিনা নিশ্চিত করুন</li>
                                <li>প্রসেসিং সময়: ২৪-৪৮ ঘণ্টা (কার্যদিবস)</li>
                                <li>পেমেন্ট পদ্ধতির উপর নির্ভর করে উত্তোলন ফি প্রযোজ্য হতে পারে</li>
                                <li>যেকোনো সমস্যার জন্য সাপোর্টের সাথে যোগাযোগ করুন</li>
                            @else
                                <li>Ensure your account number is correct before submitting</li>
                                <li>Withdraw amount must be between ৳{{ number_format($minWithdraw, 0) }} and ৳{{ number_format($maxWithdraw, 0) }}</li>
                                <li>Make sure you have sufficient balance</li>
                                <li>Processing time: 24-48 hours (business days)</li>
                                <li>Withdraw fees may apply depending on payment method</li>
                                <li>Contact support if you face any issues</li>
                            @endif
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- ============================================
     INLINE JS: FORM VALIDATION + EFFECTS
============================================ --}}
<script>
(function() {
    const currentLang = '{{ $currentLang }}';
    const minWithdraw = {{ $minWithdraw }};
    const maxWithdraw = {{ $maxWithdraw }};
    const userBalance = {{ $userBalance }};

    // Translation object
    const translations = {
        en: {
            validAmount: 'Please enter a valid withdraw amount!',
            accountRequired: 'Please enter your account number!',
            methodRequired: 'Please select a payment method!',
            minAmount: 'Minimum withdraw amount is ৳',
            maxAmount: 'Maximum withdraw amount is ৳',
            insufficientBalance: 'Insufficient balance! Your available balance is ৳',
            processing: 'Processing...'
        },
        bn: {
            validAmount: 'দয়া করে একটি বৈধ উত্তোলনের পরিমাণ লিখুন!',
            accountRequired: 'দয়া করে আপনার একাউন্ট নম্বর লিখুন!',
            methodRequired: 'দয়া করে একটি পেমেন্ট পদ্ধতি নির্বাচন করুন!',
            minAmount: 'সর্বনিম্ন উত্তোলনের পরিমাণ হল ৳',
            maxAmount: 'সর্বোচ্চ উত্তোলনের পরিমাণ হল ৳',
            insufficientBalance: 'অপর্যাপ্ত ব্যালেন্স! আপনার উপলব্ধ ব্যালেন্স হল ৳',
            processing: 'প্রসেস করা হচ্ছে...'
        }
    };

    const t = translations[currentLang] || translations.en;

    document.addEventListener('DOMContentLoaded', function () {
        // =====================
        // INPUT FOCUS EFFECTS
        // =====================
        const inputs = document.querySelectorAll('.form-input, .form-select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '#30cfd0';
                this.style.boxShadow = '0 0 0 4px #30cfd020';
                this.style.transform = 'scale(1.01)';
            });
            input.addEventListener('blur', function() {
                this.style.borderColor = '#30cfd0';
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
                this.style.transform = 'scale(1)';
            });
        });

        // =====================
        // BUTTON HOVER EFFECTS
        // =====================
        const submitBtn = document.querySelector('.submit-btn');
        if(submitBtn){
            submitBtn.addEventListener('mouseenter', function(){
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 8px 30px rgba(0,0,0,0.3)';
                this.style.opacity = '0.95';
            });
            submitBtn.addEventListener('mouseleave', function(){
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.2)';
                this.style.opacity = '1';
            });
        }

        // =====================
        // FORM VALIDATION
        // =====================
        const form = document.getElementById('withdrawForm');
        if(form){
            form.addEventListener('submit', function(e){
                let isValid = true;
                let errorMessage = '';

                const amount = form.querySelector('#withdrawAmount');
                const account = form.querySelector('#accountNumber');
                const method = form.querySelector('#paymentMethod');

                // Reset borders
                [amount, account, method].forEach(el => {
                    if(el) el.style.borderColor = '#30cfd0';
                });

                // Amount validation
                if(!amount || !amount.value || parseFloat(amount.value) <= 0){
                    isValid = false;
                    errorMessage = t.validAmount;
                    if(amount) {
                        amount.focus();
                        amount.style.borderColor = '#dc3545';
                    }
                }

                // Min validation
                if(isValid && amount && parseFloat(amount.value) < minWithdraw){
                    isValid = false;
                    errorMessage = `${t.minAmount}${minWithdraw.toFixed(2)}`;
                    amount.style.borderColor = '#dc3545';
                    amount.focus();
                }

                // Max validation
                if(isValid && amount && parseFloat(amount.value) > maxWithdraw){
                    isValid = false;
                    errorMessage = `${t.maxAmount}${maxWithdraw.toFixed(2)}`;
                    amount.style.borderColor = '#dc3545';
                    amount.focus();
                }

                // Balance validation
                if(isValid && amount && parseFloat(amount.value) > userBalance){
                    isValid = false;
                    errorMessage = `${t.insufficientBalance}${userBalance.toFixed(2)}`;
                    amount.style.borderColor = '#dc3545';
                    amount.focus();
                }

                // Payment method validation
                if(isValid && (!method || !method.value)){
                    isValid = false;
                    errorMessage = t.methodRequired;
                    if(method) {
                        method.focus();
                        method.style.borderColor = '#dc3545';
                    }
                }

                // Account validation
                if(isValid && (!account || !account.value.trim())){
                    isValid = false;
                    errorMessage = t.accountRequired;
                    if(account) {
                        account.focus();
                        account.style.borderColor = '#dc3545';
                    }
                }

                if(!isValid){
                    e.preventDefault();
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'validation-error';
                    errorDiv.style.cssText = 'background: linear-gradient(135deg, #dc354520 0%, #dc354530 100%); border-left: 5px solid #dc3545; padding: 18px 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(220,53,69,0.15); display:flex; align-items:center;';
                    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle" style="color:#dc3545; font-size:1.5em; margin-right:12px;"></i><span style="color:#dc3545; font-weight:600; font-size:1.05em;">${errorMessage}</span>`;

                    // Remove existing error
                    const existingError = form.querySelector('.validation-error');
                    if(existingError) existingError.remove();

                    form.insertBefore(errorDiv, form.firstChild);
                    setTimeout(()=>{ errorDiv.remove(); }, 5000);
                    return false;
                }

                // Show loading
                if(submitBtn){
                    submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${t.processing}`;
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.7';
                    submitBtn.style.cursor = 'not-allowed';
                }
            });
        }

        // =====================
        // AUTO DISMISS ALERTS
        // =====================
        setTimeout(()=>{
            const successAlert = document.querySelector('.success-alert');
            if(successAlert){
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(()=>{ successAlert.remove(); },500);
            }
        },5000);

        setTimeout(()=>{
            const errorAlert = document.querySelector('.error-alert');
            if(errorAlert){
                errorAlert.style.transition = 'opacity 0.5s ease';
                errorAlert.style.opacity = '0';
                setTimeout(()=>{ errorAlert.remove(); },500);
            }
        },7000);

        console.log('💳 Withdraw Form Initialized');
        console.log('Language:', currentLang);
        console.log('Min Withdraw: ৳' + minWithdraw);
        console.log('Max Withdraw: ৳' + maxWithdraw);
        console.log('User Balance: ৳' + userBalance);
    });
})();
</script>

@endsection
