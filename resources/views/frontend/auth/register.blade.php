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
                                   placeholder="First Name">
                            @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-user"></i></div>
                            <input name="last_name" type="text" class="form--control form-control style--two"
                                   placeholder="Last Name">
                            @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Country List (Static) -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-globe"></i></div>
                            <select name="country" class="form-select form--control style--two">
                                <option value="">Select Country</option>
                                <option>Bangladesh</option>
                                <option>India</option>
                                <option>Pakistan</option>
                                <option>Nepal</option>
                                <option>Bhutan</option>
                                <option>Sri Lanka</option>
                                <option>United States</option>
                                <option>United Kingdom</option>
                                <option>Canada</option>
                                <option>Australia</option>
                                <option>Germany</option>
                                <option>France</option>
                                <option>Italy</option>
                                <option>China</option>
                                <option>Japan</option>
                                <option>Saudi Arabia</option>
                                <option>UAE</option>
                            </select>
                            @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Phone (Static Code + Number) -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <select name="phone_code" class="form-select text--base style--two" style="max-width:120px;">
                                <option value="+880">+880 BD</option>
                                <option value="+91">+91 IN</option>
                                <option value="+92">+92 PK</option>
                                <option value="+977">+977 NP</option>
                                <option value="+975">+975 BT</option>
                                <option value="+94">+94 SL</option>
                                <option value="+1">+1 USA</option>
                                <option value="+44">+44 UK</option>
                                <option value="+61">+61 AUS</option>
                                <option value="+81">+81 JP</option>
                                <option value="+86">+86 CN</option>
                                <option value="+971">+971 UAE</option>
                                <option value="+966">+966 SA</option>
                            </select>
                            <input type="text" name="number" class="form--control form-control style--two"
                                   placeholder="Phone Number">
                            @error('number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-envelope"></i></div>
                            <input name="email" type="email" class="form--control form-control style--two"
                                   placeholder="Email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-user-circle"></i></div>
                            <input name="username" type="text" class="form--control form-control style--two"
                                   placeholder="Username">
                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                       <!-- ref_code -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-pre-icon"><i class="las la-user-circle"></i></div>
                            <input name="ref_code" type="number" class="form--control form-control style--two"
                                   placeholder="ref_code">
                            @error('ref_code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>


                    <!-- Password -->
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <div class="input-pre-icon"><i class="las la-lock"></i></div>
                            <input id="password" name="password" type="password"
                                   class="form--control form-control style--two" placeholder="Password">

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
                                   class="form--control form-control style--two" placeholder="Confirm Password">

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
