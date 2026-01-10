@extends('frontend.master')

@section('content')

@php
    // ============================================
    // FETCH THEME COLORS
    // ============================================
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#F5CE0D';
    $secondaryColor = $activeTheme->secondary_color ?? '#000000';

    // ============================================
    // GET CURRENT LANGUAGE
    // ============================================
    $currentLang = app()->getLocale(); // 'en' or 'bn'

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

                    {{-- HEADER --}}
                    <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid {{ $primaryColor }};">
                        <h4 style="color: {{ $secondaryColor }}; font-weight: bold; font-size: 1.8em; margin: 0;">
                            <i class="fas fa-money-check-alt" style="color: {{ $primaryColor }}; margin-right: 10px;"></i>
                            {{ $currentLang === 'bn' ? 'এখনই টাকা তুলুন!' : 'Withdraw Now!' }}
                        </h4>
                    </div>

                    {{-- WITHDRAW LIMITS --}}
                    @if(isset($Withdraw_limit))
                        <div style="background: linear-gradient(135deg, {{ $primaryColor }}20 0%, {{ $primaryColor }}30 100%); border-left: 5px solid {{ $primaryColor }}; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                <i class="fas fa-info-circle" style="color: {{ $primaryColor }}; font-size: 1.5em; margin-right: 12px;"></i>
                                <h5 style="color: {{ $secondaryColor }}; font-weight: bold; margin: 0;">
                                    {{ $currentLang === 'bn' ? 'উত্তোলনের সীমা' : 'Withdraw Limits' }}
                                </h5>
                            </div>
                            <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-top: 15px;">
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: {{ $secondaryColor }}; margin: 0; font-size: 0.9em; opacity: 0.8;">
                                        {{ $currentLang === 'bn' ? 'সর্বনিম্ন উত্তোলন:' : 'Minimum Withdraw:' }}
                                    </p>
                                    <p style="color: {{ $primaryColor }}; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        {{ $currentLang === 'bn' ? '৳ ' : '৳ ' }}{{ round($Withdraw_limit->minimum_withdraw ?? 0) }}
                                    </p>
                                </div>
                                <div style="flex: 1; min-width: 200px;">
                                    <p style="color: {{ $secondaryColor }}; margin: 0; font-size: 0.9em; opacity: 0.8;">
                                        {{ $currentLang === 'bn' ? 'সর্বোচ্চ উত্তোলন:' : 'Maximum Withdraw:' }}
                                    </p>
                                    <p style="color: {{ $primaryColor }}; font-weight: bold; font-size: 1.3em; margin: 5px 0 0 0;">
                                        {{ $currentLang === 'bn' ? '৳ ' : '৳ ' }}{{ round($Withdraw_limit->maximum_withdraw ?? 0) }}
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

                    {{-- WITHDRAW FORM --}}
                    <form action="{{ route('Withdraw.submit') }}" method="POST" id="withdrawForm">
                        @csrf

                        {{-- AMOUNT --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-money-bill-wave" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                {{ $currentLang === 'bn' ? 'উত্তোলনের পরিমাণ *' : 'Withdraw Amount *' }}
                            </label>
                            <input type="number"
                                   name="amount"
                                   class="form-input"
                                   step="0.01"
                                   min="{{ $Withdraw_limit->minimum_withdraw ?? 0 }}"
                                   max="{{ $Withdraw_limit->maximum_withdraw ?? 0 }}"
                                   placeholder="{{ $currentLang === 'bn' ? ($Withdraw_limit->minimum_withdraw ?? 0) . ' থেকে ' . ($Withdraw_limit->maximum_withdraw ?? 0) . ' এর মধ্যে পরিমাণ লিখুন' : 'Enter amount between ' . ($Withdraw_limit->minimum_withdraw ?? 0) . ' and ' . ($Withdraw_limit->maximum_withdraw ?? 0) }}"
                                   style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            @error('amount')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- ACCOUNT NUMBER --}}
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-credit-card" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                {{ $currentLang === 'bn' ? 'আপনার একাউন্ট নম্বর *' : 'Your Account Number *' }}
                            </label>
                            <input type="text"
                                   name="account_number"
                                   class="form-input"
                                   placeholder="{{ $currentLang === 'bn' ? 'আপনার একাউন্ট নম্বর লিখুন (যেমন: ০১XXXXXXXXX)' : 'Enter your account number (e.g., 01XXXXXXXXX)' }}"
                                   style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            @error('account_number')
                                <span style="color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- PAYMENT METHOD --}}
                        <div style="margin-bottom: 30px;">
                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 10px; font-size: 1.05em;">
                                <i class="fas fa-university" style="color: {{ $primaryColor }}; margin-right: 8px;"></i>
                                {{ $currentLang === 'bn' ? 'পেমেন্ট পদ্ধতি *' : 'Payment Method *' }}
                            </label>
                            <select name="payment_method"
                                    class="form-select"
                                    style="width: 100%; padding: 15px 20px; border: 2px solid {{ $primaryColor }}; border-radius: 10px; font-size: 1em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.05); cursor: pointer;">
                                <option value="">{{ $currentLang === 'bn' ? '-- পেমেন্ট পদ্ধতি নির্বাচন করুন --' : '-- Select Payment Method --' }}</option>
                                @foreach($payment_method_name as $method)
                                    @php
                                        $bankName = getTranslated($method->bankname, $currentLang);
                                        $accountNumber = getTranslated($method->accountnumber, $currentLang);
                                    @endphp
                                    <option value="{{ $method->id }}" data-number="{{ $accountNumber }}">
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

                        {{-- SUBMIT BUTTON --}}
                        <div style="margin-top: 30px;">
                            <button type="submit"
                                    class="submit-btn"
                                    style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $primaryColor }}dd 100%); color: {{ $secondaryColor }}; border: none; padding: 18px 40px; border-radius: 10px; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(0,0,0,0.2); width: 100%; max-width: 300px;">
                                <i class="fas fa-paper-plane"></i> {{ $currentLang === 'bn' ? 'উত্তোলন জমা দিন' : 'Submit Withdraw' }}
                            </button>
                        </div>
                    </form>

                    {{-- IMPORTANT NOTES --}}
                    <div style="margin-top: 40px; padding: 20px; background-color: {{ $secondaryColor }}05; border-radius: 10px; border: 1px solid {{ $primaryColor }}30;">
                        <h6 style="color: {{ $secondaryColor }}; font-weight: bold; margin-bottom: 15px;">
                            <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i> {{ $currentLang === 'bn' ? 'গুরুত্বপূর্ণ তথ্য' : 'Important Notes' }}
                        </h6>
                        <ul style="margin: 0; padding-left: 20px; color: {{ $secondaryColor }}; opacity: 0.8; line-height: 1.8;">
                            @if($currentLang === 'bn')
                                <li>জমা দেওয়ার আগে আপনার একাউন্ট নম্বর সঠিক কিনা নিশ্চিত করুন</li>
                                <li>উত্তোলনের পরিমাণ নির্দিষ্ট সীমার মধ্যে হতে হবে</li>
                                <li>প্রসেসিং সময়: ২৪-৪৮ ঘণ্টা (কার্যদিবস)</li>
                                <li>পেমেন্ট পদ্ধতির উপর নির্ভর করে উত্তোলন ফি প্রযোজ্য হতে পারে</li>
                                <li>যেকোনো সমস্যার জন্য সাপোর্টের সাথে যোগাযোগ করুন</li>
                            @else
                                <li>Ensure your account number is correct before submitting</li>
                                <li>Withdraw amount must be within the specified limits</li>
                                <li>Processing time: 24-48 hours (business days)</li>
                                <li>Withdraw fees may apply depending on payment method</li>
                                <li>Contact support if you face any issues</li>
                            @endif
                        </ul>
                    </div>

                    {{-- AVAILABLE BALANCE --}}
                    @if(isset($total_balance))
                        <div style="margin-top: 30px; padding: 25px; background: linear-gradient(135deg, {{ $primaryColor }}15 0%, {{ $secondaryColor }}15 100%); border-radius: 12px; border: 2px solid {{ $primaryColor }}; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <p style="color: {{ $secondaryColor }}; margin: 0 0 8px 0; font-size: 0.95em; opacity: 0.8;">
                                <i class="fas fa-wallet" style="color: {{ $primaryColor }};"></i>
                                {{ $currentLang === 'bn' ? 'আপনার উপলব্ধ ব্যালেন্স' : 'Your Available Balance' }}
                            </p>
                            <h3 style="color: {{ $primaryColor }}; font-weight: bold; font-size: 2.2em; margin: 0;">
                                {{ $currentLang === 'bn' ? '৳ ' : '৳ ' }}{{ round($total_balance ?? 0) }}
                            </h3>
                        </div>
                    @endif

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
    const primaryColor = '{{ $primaryColor }}';
    const secondaryColor = '{{ $secondaryColor }}';
    const currentLang = '{{ $currentLang }}';

    // Translation object
    const translations = {
        en: {
            validAmount: 'Please enter a valid withdraw amount!',
            accountRequired: 'Please enter your account number!',
            methodRequired: 'Please select a payment method!',
            minAmount: 'Minimum withdraw amount is',
            maxAmount: 'Maximum withdraw amount is',
            processing: 'Processing...'
        },
        bn: {
            validAmount: 'দয়া করে একটি বৈধ উত্তোলনের পরিমাণ লিখুন!',
            accountRequired: 'দয়া করে আপনার একাউন্ট নম্বর লিখুন!',
            methodRequired: 'দয়া করে একটি পেমেন্ট পদ্ধতি নির্বাচন করুন!',
            minAmount: 'সর্বনিম্ন উত্তোলনের পরিমাণ হল',
            maxAmount: 'সর্বোচ্চ উত্তোলনের পরিমাণ হল',
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
                this.style.borderColor = primaryColor;
                this.style.boxShadow = `0 0 0 4px ${primaryColor}20`;
                this.style.transform = 'scale(1.01)';
            });
            input.addEventListener('blur', function() {
                this.style.borderColor = primaryColor;
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
                this.style.transform = 'scale(1)';
            });
            input.addEventListener('input', function() {
                this.style.borderColor = primaryColor;
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

                const amount = form.querySelector('input[name="amount"]');
                const account = form.querySelector('input[name="account_number"]');
                const method = form.querySelector('select[name="payment_method"]');

                // Amount validation
                if(!amount || !amount.value || parseFloat(amount.value) <= 0){
                    isValid = false;
                    errorMessage = t.validAmount;
                    amount.focus();
                    amount.style.borderColor = '#dc3545';
                }

                // Account validation
                if(isValid && (!account || !account.value.trim())){
                    isValid = false;
                    errorMessage = t.accountRequired;
                    account.focus();
                    account.style.borderColor = '#dc3545';
                }

                // Payment method validation
                if(isValid && (!method || !method.value)){
                    isValid = false;
                    errorMessage = t.methodRequired;
                    method.focus();
                    method.style.borderColor = '#dc3545';
                }

                // Min & Max validation
                if(isValid && amount){
                    const min = parseFloat(amount.min);
                    const max = parseFloat(amount.max);
                    const val = parseFloat(amount.value);
                    if(val < min){
                        isValid = false;
                        errorMessage = `${t.minAmount} ${min} ${currentLang === 'bn' ? '৳' : '৳'}!`;
                        amount.style.borderColor = '#dc3545';
                        amount.focus();
                    }
                    else if(val > max){
                        isValid = false;
                        errorMessage = `${t.maxAmount} ${max} ${currentLang === 'bn' ? '৳' : '৳'}!`;
                        amount.style.borderColor = '#dc3545';
                        amount.focus();
                    }
                }

                if(!isValid){
                    e.preventDefault();
                    const errorDiv = document.createElement('div');
                    errorDiv.style.cssText = 'background: linear-gradient(135deg, #dc354520 0%, #dc354530 100%); border-left: 5px solid #dc3545; padding: 18px 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(220,53,69,0.15); display:flex; align-items:center;';
                    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle" style="color:#dc3545; font-size:1.5em; margin-right:12px;"></i><span style="color:#dc3545; font-weight:600; font-size:1.05em;">${errorMessage}</span>`;
                    form.insertBefore(errorDiv, form.firstChild);
                    setTimeout(()=>{ errorDiv.remove(); }, 5000);
                    return false;
                }

                // Show loading
                if(submitBtn){
                    submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${t.processing}`;
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.7';
                }
            });
        }

        // =====================
        // AUTO DISMISS SUCCESS
        // =====================
        setTimeout(()=>{
            const successAlert = document.querySelector('.success-alert');
            if(successAlert){
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(()=>{ successAlert.remove(); },500);
            }
        },5000);

        console.log('💳 Withdraw Form Initialized');
        console.log('Language:', currentLang);
        console.log('Theme Colors:', { primary: primaryColor, secondary: secondaryColor });
    });
})();
</script>

@endsection
