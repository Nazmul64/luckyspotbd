@extends('frontend.master')

@section('content')

{{-- =======================
    HOME PAGE SLIDER
======================= --}}
@if($slider_show && count($slider_show) > 0)
    @foreach ($slider_show as $item)
        <section class="banner-section bg_img overflow-hidden">
            <div class="container">
                <div class="banner-wrapper d-flex flex-wrap align-items-center">
                    <div class="banner-content">
                        <h1 class="banner-content__title">
                            {{ trans_db($item->title ?? 'Win Big With LuckySpotBD') }}
                        </h1>
                        <p class="banner-content__subtitle">
                            {{ trans_db($item->description ?? 'Buy tickets and get a chance to win amazing prizes') }}
                        </p>
                        <div class="button-wrapper">
                            <a href="{{ route('frontend') }}" class="cmn--btn active btn--lg">
                                <i class="las la-ticket-alt"></i>
                                {{ trans_db('ticket_now', 'Ticket Now') }}
                            </a>
                            @guest
                                <a href="{{ route('frontend.login') }}" class="cmn--btn btn--lg">
                                    {{ trans_db('sign_up', 'Sign Up') }}
                                </a>
                            @endguest
                        </div>
                    </div>

                    @if($item->photo)
                    <div class="banner-thumb">
                        <img src="{{ asset($item->photo) }}" alt="Banner Thumbnail">
                    </div>
                    @endif
                </div>
            </div>
        </section>
    @endforeach
@endif

{{-- =======================
    ABOUT SECTION
======================= --}}
@foreach ($about as $item)
<section class="about-section padding-top padding-bottom overflow-hidden"id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-header">
                        <h2 class="section-header__title">{{ $item->title ?? '' }}</h2>
                        <p>{{ $item->description ?? '' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="aobut-thumb section-thumb">
                    <img src="{{ asset($item->photo) }}" alt="about" class="ms-lg-5">
                </div>
            </div>
        </div>
    </div>
</section>
@endforeach

{{-- =======================
    GAME SECTION
======================= --}}
<section class="game-section padding-top padding-bottom bg_img" style="background: url(assets/images/game/bg3.jpg);"id="ticket">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="section-header text-center">
                    <h2 class="section-header__title">Top Awesome Ticket</h2>
                    <p>A casino is a facility for certain types of gambling. Casinos are often built combined with hotels, resorts.</p>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">
            @foreach ($lottery_show as $itm)
                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                    <div class="game-item">
                        <div class="game-inner">
                            <div class="game-item__thumb">
                                <img src="{{ asset('uploads/Lottery/' . ($itm->photo ?? 'default.png')) }}" alt="{{ $itm->name }}">
                            </div>

                            <div class="game-item__content">
                                <h4 class="title">{{ $itm->name ?? 'N/A' }}</h4>
                                <p class="invest-info">{{ $itm->win_type ?? 'N/A' }}</p>
                                <p class="invest-amount">
                                    {{ $itm->price ? round($itm->price) . ' টাকা' : '0 টাকা' }}
                                </p>
                                <p class="text-white">
                                    Draw Date: {{ $itm->draw_date ? $itm->draw_date->format('d M, Y h:i A') : 'N/A' }}
                                </p>

                                @if($itm->draw_date)
                                    <p class="text-warning countdown-timer" data-draw="{{ $itm->draw_date->format('Y-m-d H:i:s') }}"></p>
                                @endif

                                <p class="text-success">1st Prize: {{ round($itm->first_prize ?? 0) }} টাকা</p>
                                <p class="text-warning">2nd Prize: {{ round($itm->second_prize ?? 0) }} টাকা</p>
                                <p class="text-info">3rd Prize: {{ round($itm->third_prize ?? 0) }} টাকা</p>

                                <a href="javascript:void(0);"
                                   class="cmn--btn active btn--md radius-0 ticket-buy-btn"
                                   data-url-dashboard="{{ route('frontend.dashboard') }}"
                                   data-url-login="{{ route('frontend.login') }}">
                                   Ticket Buy
                                </a>
                            </div>
                        </div>
                        <div class="ball"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Countdown Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateCountdowns() {
        const timers = document.querySelectorAll('.countdown-timer');
        timers.forEach(function(timer) {
            const drawTime = timer.getAttribute('data-draw');
            const drawDate = new Date(drawTime);
            const now = new Date();
            const diff = drawDate - now;

            if(diff <= 0) {
                timer.textContent = '🎉 Draw time has arrived!';
                return;
            }

            const days = Math.floor(diff / (1000*60*60*24));
            const hours = Math.floor((diff % (1000*60*60*24)) / (1000*60*60));
            const minutes = Math.floor((diff % (1000*60*60)) / (1000*60));
            const seconds = Math.floor((diff % (1000*60)) / 1000);

            timer.textContent = `⏳ ${days}d ${hours}h ${minutes}m ${seconds}s remaining`;
        });
    }

    setInterval(updateCountdowns, 1000);

    // Ticket Buy button logic
    const ticketButtons = document.querySelectorAll('.ticket-buy-btn');
    ticketButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            @if(Auth::check())
                window.location.href = btn.dataset.urlDashboard;
            @else
                alert('You need to login first!');
                window.location.href = btn.dataset.urlLogin;
            @endif
        });
    });
});
</script>

{{-- =======================
    WHY CHOOSE US SECTION
======================= --}}
<section class="why-section py-5 overflow-hidden">
    <div class="container">
        <div class="row justify-content-between align-items-center gy-5">

            <!-- Left Content -->
            <div class="col-lg-5 col-xl-4">
                <div class="section-header mb-4">
                    <h2 class="section-header__title">
                        {{ $whychooseustickets->first()->main_title }}
                    </h2>
                </div>
                <p>{{ $whychooseustickets->first()->main_description }}</p>
            </div>

            <!-- Right Boxes -->
            <div class="col-lg-7 col-xl-7">
                <div class="row gy-4">
                    @foreach ($whychooseustickets as $item)
                        <div class="col-md-6">
                            <div class="why-item d-flex align-items-start gap-3">
                                <div class="why-item__thumb fs-2 text-primary">
                                    <i class="las la-shield-alt"></i>
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">{{ $item->title }}</h4>
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <div class="shapes">
        <img src="{{ asset('frontend/assets/images/why/shape.png') }}"
             alt="why"
             class="shape shape1">
    </div>
</section>



{{-- =======================
    HOW TO PLAY SECTION
======================= --}}
<section class="how-section padding-top padding-bottom bg_img" style="background: url(assets/images/how/bg2.jpg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-header__title">How to Ticket</h2>
                    <p>A Ticket is a facility for certain types of gambling. Ticket are often built combined with hotels, resorts.</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="how-item">
                    <div class="how-item__thumb">
                        <i class="las la-user-plus"></i>
                        <div class="badge badge--lg badge--round radius-50">01</div>
                    </div>
                    <div class="how-item__content">
                        <h4 class="title">Sign Up First & Login</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="how-item">
                    <div class="how-item__thumb">
                        <i class="las la-id-card"></i>
                        <div class="badge badge--lg badge--round radius-50">02</div>
                    </div>
                    <div class="how-item__content">
                        <h4 class="title">Complete you Profile</h4>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="how-item">
                    <div class="how-item__thumb">
                        <i class="las la-dice"></i>
                        <div class="badge badge--lg badge--round radius-50">03</div>
                    </div>
                    <div class="how-item__content">
                        <h4 class="title">Choose a Game & Play</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =======================
    FAQ SECTION
======================= --}}
<section class="faq-section padding-top padding-bottom overflow-hidden"id="faq">
    <div class="container">

        <!-- Section Header -->
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6">
                <div class="section-header text-center">
                    <h2 class="section-header__title">
                        Frequently Asked Questions
                    </h2>
                    <p>
                        A Ticket is a facility for certain types of gambling.
                        Ticket are often built combined with hotels, resorts.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ Items -->
        <div class="faq-wrapper row justify-content-between">

            <!-- Left Column (1–6) -->
            <div class="col-lg-6">
                @foreach($faq->take(6) as $index => $item)
                    <div class="faq-item">
                        <div class="faq-item__title">
                            <h5 class="title">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.
                                {{ $item->question }}
                            </h5>
                        </div>
                        <div class="faq-item__content">
                            <p>{{ $item->answer }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right Column (7–12) -->
            <div class="col-lg-6">
                @foreach($faq->skip(6)->take(6) as $index => $item)
                    <div class="faq-item">
                        <div class="faq-item__title">
                            <h5 class="title">
                                {{ str_pad($index + 7, 2, '0', STR_PAD_LEFT) }}.
                                {{ $item->question }}
                            </h5>
                        </div>
                        <div class="faq-item__content">
                            <p>{{ $item->answer }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <!-- Shapes -->
    <div class="shapes">
        <img src="{{ asset('frontend/assets/images/faq/shape.png') }}"
             alt="faq"
             class="shape shape1">
    </div>
</section>




{{-- =======================
    TOP INVESTOR & WINNER
======================= --}}
<section class="top-section padding-top padding-bottom bg_img"
    style="background:url({{ asset('assets/images/top/bg.png') }}) center">

    <div class="container">
        <div class="row align-items-center gy-5">

            <!-- Latest Winner -->
            <div class="col-lg-4">
                <h3 class="part-title mb-4">Latest Winner</h3>

                <div class="top-investor-slider">
                    @forelse($packageWinners as $winner)
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img
                                    src="{{ asset('uploads/profile/' . optional($winner->user)->profile_photo) }}"
                                    alt="winner">

                                <p class="amount">{{ $winner->amount }}</p>
                            </div>

                            <div class="investor-item__content">
                                <h6 class="name">
                                    {{ optional($winner->user)->name }}
                                </h6>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">No winners found</p>
                    @endforelse
                </div>
            </div>

            <!-- Center Banner -->
            <div class="col-lg-4">
                <div class="cla-wrapper text-center">
                    <h3 class="title mb-4">
                        WIN !!! <br> Get million dollars
                    </h3>

                    <a href=""
                        class="cmn--btn active btn--md radius-0">
                        Play Now
                    </a>

                    <div class="thumb mt-4">
                        <img src="{{ asset('frontend/assets/images/top/bg2.png') }}" alt="banner">
                    </div>
                </div>
            </div>

            <!-- Top Investor -->
            <div class="col-lg-4">
                <h3 class="part-title mb-4">Top Investor</h3>

                <div class="top-investor-slider">
                    @forelse($packageWinners as $winner)
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img
                                    src="{{ asset('uploads/profile/' . optional($winner->user)->profile_photo) }}"
                                    alt="investor">

                                <p class="amount">{{ $winner->amount }}</p>
                            </div>

                            <div class="investor-item__content">
                                <h6 class="name">
                                    {{ optional($winner->user)->name }}
                                </h6>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">No investors found</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>


{{-- =======================
    TESTIMONIAL SECTION
======================= --}}
<section class="testimonial-section padding-top padding-bottom overflow-hidden">
    <div class="container">

        <!-- Section Header -->
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6">
                <div class="section-header text-center">
                    <h2 class="section-header__title">What Ticket Players Say</h2>
                    <p>A Ticket is a facility for certain types of gambling. Tickets are often combined with hotels, resorts.</p>
                </div>
            </div>
        </div>

        <!-- Testimonial Slider -->
        <div class="testimonial-slider">

            @foreach($testmonail as $item)
                <div class="single-slide">
                    <div class="testimonial-item bg_img" style="background: url({{ asset('frontend/assets/images/testimonial/bg.png') }}) center / cover no-repeat;">
                        <div class="testimonial-inner">

                            <!-- Message -->
                            <div class="testimonial-item__content">
                                <div class="quote-icon"><i class="las la-quote-left"></i></div>
                                <p>{{ $item->message }}</p>
                            </div>

                            <!-- User Info -->
                            <div class="thumb-wrapper d-flex align-items-center mt-3">
                                <div class="thumb me-3">
                                    @if($item->photo && file_exists(public_path($item->photo)))
                                        <img src="{{ asset($item->photo) }}" alt="{{ $item->name }}" class="rounded-circle" width="60" height="60">
                                    @else
                                        <img src="{{ asset('frontend/assets/images/testimonial/default.png') }}" alt="No Photo" class="rounded-circle" width="60" height="60">
                                    @endif
                                </div>
                                <div class="content">
                                    <h6 class="name mb-0">{{ $item->name }}</h6>
                                    <span class="designation">{{ $item->designation }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>


@endsection
