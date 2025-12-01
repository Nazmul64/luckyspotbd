@extends('frontend.master')
@section('content')

<!-- inner hero section start -->
<section class="inner-banner bg_img" style="background: url('{{ asset('frontend/assets/images/inner-banner/bg2.jpg') }}') top;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-xl-6 text-center">
        <h2 class="title text-white">Sign In</h2>
        <ul class="breadcrumbs d-flex flex-wrap align-items-center justify-content-center">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li>Sign In</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- inner hero section end -->

<!-- Account Section Starts Here -->
<section class="account-section overflow-hidden bg_img" style="background:url('{{ asset('frontend/assets/images/account/bg.jpg') }}')">
    <div class="container">
        <div class="account__main__wrapper">

            <div class="account__form__wrapper">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="logo">
                    </a>
                </div>

                <form class="account__form form row g-4" method="POST" action="{{ route('frontend.login.submit') }}">
                    @csrf

                    <!-- email field -->
                    <div class="col-12">
                        <div class="form-group">
                            <div class="input-pre-icon">
                                <i class="las la-envelope"></i>
                            </div>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="form--control form-control style--two"
                                placeholder="Email Address"
                                value="{{ old('email') }}"
                            >

                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- password field with show/hide -->
                    <div class="col-12">
                        <div class="form-group position-relative">
                            <div class="input-pre-icon">
                                <i class="las la-lock"></i>
                            </div>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form--control form-control style--two"
                                placeholder="Password"
                            >

                            <!-- eye -->
                            <span class="toggle-password"
                                  style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                                <i class="las la-eye-slash" id="toggleIcon"></i>
                            </span>

                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="col-12">
                        <div class="form-group">
                            <button class="cmn--btn active w-100 btn--round" type="submit">Sign In</button>
                        </div>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between mt-5">
                        <div class="form--check d-flex align-items-center">
                            <input id="check1" type="checkbox" name="remember">
                            <label for="check1">Remember me</label>
                        </div>
                        <a href="#" class="forgot-pass d-block text--base">Forgot Password ?</a>
                    </div>
                </form>
            </div>

            <div class="account__content__wrapper">
                <div class="content text-center text-white">
                    <h3 class="title text--base mb-4">Welcome to Casino</h3>
                    <p>Sign in to access your account.</p>
                    <p class="account-switch mt-4">
                        Don't have an Account yet ?
                        <a class="text--base ms-2" href="{{route('frontend.register')}}">Sign Up</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Account Section Ends Here -->

<script>
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    document.querySelector('.toggle-password').addEventListener('click', function () {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        toggleIcon.classList.toggle('la-eye');
        toggleIcon.classList.toggle('la-eye-slash');
    });
</script>

@endsection
