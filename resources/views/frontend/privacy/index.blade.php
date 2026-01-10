@extends('frontend.master')

@section('content')
<!-- Inner Hero Section Start -->
<section class="inner-banner bg_img" style="background: url('{{ asset("frontend/assets/images/inner-banner/bg2.jpg") }}') top;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6 text-center">
                <h2 class="title text-white">
                    {{ app()->getLocale() == 'bn' ? 'প্রাইভেসি পলিসি' : 'Privacy Policy' }}
                </h2>
                <ul class="breadcrumbs d-flex flex-wrap align-items-center justify-content-center">
                    <li>
                        <a href="{{ route('frontend') }}">
                            {{ app()->getLocale() == 'bn' ? 'হোম' : 'Home' }}
                        </a>
                    </li>
                    <li>
                        {{ app()->getLocale() == 'bn' ? 'প্রাইভেসি পলিসি' : 'Privacy Policy' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Inner Hero Section End -->

<!-- Privacy Policy Section Start -->
<section class="privacy-policy padding-top padding-bottom">
    <div class="container">
        <div class="row gy-5">
            <div class="col-lg-9">
                <div class="privacy-policy-content">
                    <div class="content-item">
                        <h4 class="title" id="overview">
                            {{-- Null-safe call --}}
                            {{ $privacy?->getTitleByLocale(app()->getLocale()) ?? 'No Privacy Policy available' }}
                        </h4>
                        <p>
                            {!! nl2br(e($privacy?->getDescriptionByLocale(app()->getLocale()) ?? 'No description available')) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Privacy Policy Section End -->
@endsection
