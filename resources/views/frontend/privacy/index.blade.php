@extends('frontend.master')
@section('content')
    <!-- inner hero section start -->
<section class="inner-banner bg_img" style="background: url('assets/images/inner-banner/bg2.jpg') top;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-xl-6 text-center">
        <h2 class="title text-white">Privacy Policy</h2>
        <ul class="breadcrumbs d-flex flex-wrap align-items-center justify-content-center">
          <li><a href="{{ route('frontend') }}">Home</a></li>
          <li>Privacy Policy</li>
        </ul>
      </div>
    </div>
  </div>
</section>

    <section class="privacy-policy padding-top padding-bottom">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-9">
                    <div class="privacy-policy-content">
                        <div class="content-item">
                            <h4 class="title" id="overview">{{ $privacy->title ?? ''}}</h4>
                            <p>
                                {{ $privacy->description ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Privacy Policy Section Ends Here -->
@endsection
