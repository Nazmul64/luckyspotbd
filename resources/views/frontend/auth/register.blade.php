@extends('frontend.master')
@section('content')

<!-- inner hero section -->
<section class="inner-banner bg_img" style="background: url('assets/images/inner-banner/bg2.jpg') top;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-xl-6 text-center">
        <h2 class="title text-white">Sign Up</h2>
        <ul class="breadcrumbs d-flex flex-wrap align-items-center justify-content-center">
          <li><a href="{{route('frontend')}}">Home</a></li>
          <li>Sign Up</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Account Section -->
<section class="account-section overflow-hidden bg_img" style="background:url(assets/images/account/bg.jpg)">
    <div class="container">
        <div class="account__main__wrapper">

            <!-- FORM -->
            <div class="account__form__wrapper sign-up">
                <div class="logo">
                    <a href="{{route('frontend')}}">
                        <img src="assets/images/logo.png" alt="logo">
                    </a>
                </div>

                <form class="account__form form row g-4" method="POST" action="{{ route('frontend.register.submit') }}">
                    @csrf

                    <!-- First Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-user"></i></div>
                            <input name="first_name" type="text" class="form--control form-control style--two"
                                   placeholder="First Name" value="{{ old('first_name') }}" required>
                            @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-user"></i></div>
                            <input name="last_name" type="text" class="form--control form-control style--two"
                                   placeholder="Last Name" value="{{ old('last_name') }}" required>
                            @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Country List (Static) -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-globe"></i></div>
                            <select name="country" class="form-select form--control style--two" required>
                                <option value="">Select Country</option>
                                <option {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                <option {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                <option {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                <option {{ old('country') == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                                <option {{ old('country') == 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
                                <option {{ old('country') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                <option {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                                <option {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                <option {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                <option {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                <option {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                <option {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                                <option {{ old('country') == 'Italy' ? 'selected' : '' }}>Italy</option>
                                <option {{ old('country') == 'China' ? 'selected' : '' }}>China</option>
                                <option {{ old('country') == 'Japan' ? 'selected' : '' }}>Japan</option>
                                <option {{ old('country') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                <option {{ old('country') == 'UAE' ? 'selected' : '' }}>UAE</option>
                            </select>
                            @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Phone (Static Code + Number) -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <select name="phone_code" class="form-select text--base style--two" style="max-width:120px;" required>
                                <option value="+880" {{ old('phone_code') == '+880' ? 'selected' : '' }}>+880 BD</option>
                                <option value="+91" {{ old('phone_code') == '+91' ? 'selected' : '' }}>+91 IN</option>
                                <option value="+92" {{ old('phone_code') == '+92' ? 'selected' : '' }}>+92 PK</option>
                                <option value="+977" {{ old('phone_code') == '+977' ? 'selected' : '' }}>+977 NP</option>
                                <option value="+975" {{ old('phone_code') == '+975' ? 'selected' : '' }}>+975 BT</option>
                                <option value="+94" {{ old('phone_code') == '+94' ? 'selected' : '' }}>+94 SL</option>
                                <option value="+1" {{ old('phone_code') == '+1' ? 'selected' : '' }}>+1 USA</option>
                                <option value="+44" {{ old('phone_code') == '+44' ? 'selected' : '' }}>+44 UK</option>
                                <option value="+61" {{ old('phone_code') == '+61' ? 'selected' : '' }}>+61 AUS</option>
                                <option value="+81" {{ old('phone_code') == '+81' ? 'selected' : '' }}>+81 JP</option>
                                <option value="+86" {{ old('phone_code') == '+86' ? 'selected' : '' }}>+86 CN</option>
                                <option value="+971" {{ old('phone_code') == '+971' ? 'selected' : '' }}>+971 UAE</option>
                                <option value="+966" {{ old('phone_code') == '+966' ? 'selected' : '' }}>+966 SA</option>
                            </select>
                            <input type="text" name="number" class="form--control form-control style--two"
                                   placeholder="Phone Number" value="{{ old('number') }}" required>
                        </div>
                        @error('number') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-envelope"></i></div>
                            <input name="email" type="email" class="form--control form-control style--two"
                                   placeholder="Email" value="{{ old('email') }}" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-user-circle"></i></div>
                            <input name="username" type="text" class="form--control form-control style--two"
                                   placeholder="Username" value="{{ old('username') }}" required>
                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Referral Code -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-gift"></i></div>
                            <input name="ref_code"
                                   type="text"
                                   class="form--control form-control style--two"
                                   placeholder="Referral Code (Optional)"
                                   value="{{ old('ref_code', $refCode ?? '') }}"
                                   {{ isset($refCode) && $refCode ? 'readonly' : '' }}
                                   style="{{ isset($refCode) && $refCode ? 'background-color: #f0f0f0; cursor: not-allowed;' : '' }}">
                            @error('ref_code') <span class="text-danger">{{ $message }}</span> @enderror
                            @if(isset($refCode) && $refCode)
                                <small class="text-success d-block mt-1">
                                    <i class="las la-check-circle"></i> Referral code applied
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <div class="input-pre-icon"><i class="las la-lock"></i></div>
                            <input id="password" name="password" type="password"
                                   class="form--control form-control style--two" placeholder="Password" required>

                            <span class="toggle-password" data-target="#password"
                                  style="position:absolute;right:15px;top:50%;transform:translateY(-50%);cursor:pointer;">
                                <i class="las la-eye"></i>
                            </span>

                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <div class="input-pre-icon"><i class="las la-lock"></i></div>
                            <input id="confirm_password" name="password_confirmation" type="password"
                                   class="form--control form-control style--two" placeholder="Confirm Password" required>

                            <span class="toggle-password" data-target="#confirm_password"
                                  style="position:absolute;right:15px;top:50%;transform:translateY(-50%);cursor:pointer;">
                                <i class="las la-eye"></i>
                            </span>

                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="col-lg-12">
                        <button class="cmn--btn active w-100 btn--round" type="submit">Sign Up</button>
                    </div>

                </form>
            </div>

            <!-- RIGHT SIDE -->
            <div class="account__content__wrapper">
                <div class="content text-center text-white">
                    <h3 class="title text--base mb-4">Welcome to Luckyspotbd</h3>
                    <p>Sign in your Account.</p>
                    <p class="account-switch mt-4">Already have an Account?
                        <a class="text--base ms-2" href="{{route('frontend.login')}}">Sign In</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Password Show/Hide -->
<script>
    document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function () {
            let input = document.querySelector(this.dataset.target);
            if (input.type === "password") {
                input.type = "text";
                this.innerHTML = '<i class="las la-eye-slash"></i>';
            } else {
                input.type = "password";
                this.innerHTML = '<i class="las la-eye"></i>';
            }
        });
    });
</script>

@endsection
