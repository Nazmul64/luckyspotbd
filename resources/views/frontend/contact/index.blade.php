@extends('frontend.master')

@section('content')

<!-- inner hero section start -->
<section class="inner-banner bg_img" style="background: url('assets/images/inner-banner/bg2.jpg') top;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-xl-6 text-center">
        <h2 class="title text-white">Contact Page</h2>
        <ul class="breadcrumbs d-flex flex-wrap align-items-center justify-content-center">
          <li><a href="index.html">Home</a></li>
          <li>Contact</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- inner hero section end -->

    <!-- Contact Section Starts Here -->
    <div class="contact-section padding-top padding-bottom">
        <div class="container">
            <div class="contact-wrapper">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-5">
                        <div class="contact-info-wrapper">
                            <h3 class="title mb-3 mb-lg-4">Contact Information</h3>
                            <ul class="contact-info-list m-0">
                                <li><a href="#"></a> <i class="las la-map-marker-alt"></i> <span>{{ $cotact_setting->address ?? ''}}</span></li>
                                <li><a href="#"> <i class="las la-phone-volume"></i> <span>+{{ $cotact_setting->phone ?? ''}}</span></a></li>
                                <li><a href="#"> <i class="las la-envelope"></i> <span><span class="__cf_email__" data-cfemail="a9ddccdadddcdaccdbe9cec4c8c0c587cac6c4">{{ $cotact_setting->email ?? ''}}</span></span></a></li>
                            </ul>
                           <ul class="social-links mt-4">
                            @if(!empty($cotact_setting->facebook))
                                <li>
                                    <a href="{{ $cotact_setting->facebook }}" target="_blank" rel="noopener">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                </li>
                            @endif

                            @if(!empty($cotact_setting->twitter))
                                <li>
                                    <a href="{{ $cotact_setting->twitter }}" target="_blank" rel="noopener">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                </li>
                            @endif

                            @if(!empty($cotact_setting->instagram))
                                <li>
                                    <a href="{{ $cotact_setting->instagram }}" target="_blank" rel="noopener">
                                        <i class="lab la-instagram"></i>
                                    </a>
                                </li>
                            @endif

                            @if(!empty($cotact_setting->linkedin))
                                <li>
                                    <a href="{{ $cotact_setting->linkedin }}" target="_blank" rel="noopener">
                                        <i class="lab la-linkedin-in"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>

                        </div>
                    </div>
                   <div class="col-lg-7">
                    <form class="contact-form" action="{{ route('contact.message') }}" method="POST">
                        @csrf

                        <h3 class="title mb-3">Get In Touch</h3>
                        <div class="row gy-3">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">First Name <span class="text--danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control form--control" value="{{ old('first_name') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Last Name <span class="text--danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control form--control" value="{{ old('last_name') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email Address <span class="text--danger">*</span></label>
                                    <input type="email" name="email" class="form-control form--control" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number <span class="text--danger">*</span></label>
                                    <input type="text" name="phone" class="form-control form--control" value="{{ old('phone') }}" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Your Message <span class="text--danger">*</span></label>
                                    <textarea name="messages" rows="4" class="form-control form--control" required>{{ old('messages') }}</textarea>
                                </div>
                            </div>

                            <div class="col">
                                <button type="submit" class="cmn--btn active">Send Message</button>
                            </div>

                        </div>
                    </form>
                </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Contact Section Ends Here -->
@endsection
