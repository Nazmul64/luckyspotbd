@extends('frontend.master')

@section('content')
<!-- Inner Hero Section Start -->
<section class="inner-banner bg_img" style="background: url('{{ asset("frontend/assets/images/inner-banner/bg2.jpg") }}') top;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6 text-center">
                <h2 class="title text-white">
                    {{ app()->getLocale() == 'bn' ? 'প্রশ্ন ও শর্তাবলী' : 'Terms & Conditions' }}
                </h2>
                <ul class="breadcrumbs d-flex flex-wrap align-items-center justify-content-center">
                    <li>
                        <a href="{{ route('frontend') }}">
                            {{ app()->getLocale() == 'bn' ? 'হোম' : 'Home' }}
                        </a>
                    </li>
                    <li>
                        {{ app()->getLocale() == 'bn' ? 'শর্তাবলী' : 'Terms & Conditions' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Inner Hero Section End -->

<!-- Terms & Conditions Section Start -->
<section class="privacy-policy padding-top padding-bottom">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-9">
                <div class="privacy-policy-content">
                    <div class="content-item">
                        <h4 class="title" id="overview">
                            {{-- Null-safe call using helper method --}}
                            {{ $trmsandcondation?->getTitleByLocale() ?? '' }}
                        </h4>
                        <p>
                            {!! nl2br(e($trmsandcondation?->getDescriptionByLocale() ?? '')) !!}
                        </p>
                        @if(!$trmsandcondation)
                            <p class="text-muted">No Terms & Conditions available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Terms & Conditions Section End -->
@endsection
