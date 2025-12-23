@extends('frontend.master')

@section('content')
 <!-- Banner Section Starts Here -->

 @foreach ($slider_show as $item)
   @if($item->status === 'active')
    <section class="banner-section bg_img overflow-hidden" style="background:url(assets/images/banner/bg.png) center">
        <div class="container">
            <div class="banner-wrapper d-flex flex-wrap align-items-center">
                <div class="banner-content">

                    <h1 class="banner-content__title">{{ $item->title ?? ''}}</h1>

                    <p class="banner-content__subtitle">{{ $item->description ?? ''}}</p>
                    <div class="button-wrapper">
                        <a href="#" class="cmn--btn active btn--lg"><i class="las la-play"></i> Ticket Now</a>
                        <a href="{{ route('frontend.login') }}" class="cmn--btn btn--lg">Sign Up</a>
                    </div>
                    <img src="{{asset('uplods/slider/'.$item->photo ?? '')}}" alt="" class="shape1">
                </div>
                <div class="banner-thumb">
                    <img src="{{asset('frontend')}}/assets/images/banner/thumb.png" alt="banner">
                </div>
            </div>
        </div>
    </section>
    @endif
@endforeach
    <!-- Banner Section Ends Here -->

 @foreach ($slider_show as $item)
    <!-- About Section Starts Here -->
    <section class="about-section padding-top padding-bottom overflow-hidden">
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
        {{-- <div class="shapes">
            <img src="{{asset('frontend')}}/assets/images/about/shape.png" alt="about" class="shape shape1">
        </div> --}}
    </section>

@endforeach
    <!-- About Section Ends Here -->




    <!-- Game Section Starts Here -->
<section class="game-section padding-top padding-bottom bg_img" style="background: url(assets/images/game/bg3.jpg);">
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

                            {{-- Image --}}
                            <div class="game-item__thumb">
                                <img src="{{ asset('uploads/Lottery/' . ($itm->photo ?? 'default.png')) }}" alt="{{ $itm->name }}">
                            </div>

                            <div class="game-item__content">
                                {{-- Name --}}
                                <h4 class="title">{{ $itm->name ?? 'N/A' }}</h4>

                                {{-- Win Type --}}
                                <p class="invest-info">{{ $itm->win_type ?? 'N/A' }}</p>

                                {{-- Price --}}
                                <p class="invest-amount">
                                    {{ $itm->price ? round($itm->price) . ' টাকা' : '0 টাকা' }}
                                </p>

                                {{-- Draw Date --}}
                                <p class="text-white">
                                    Draw Date: {{ $itm->draw_date ? $itm->draw_date->format('d M, Y h:i A') : 'N/A' }}
                                </p>

                                {{-- Countdown Timer --}}
                                @if($itm->draw_date)
                                    <p class="text-warning countdown-timer" data-draw="{{ $itm->draw_date->format('Y-m-d H:i:s') }}"></p>
                                @endif

                                {{-- Prizes --}}
                                <p class="text-success">1st Prize: {{ round($itm->first_prize ?? 0) }} টাকা</p>
                                <p class="text-warning">2nd Prize: {{ round($itm->second_prize ?? 0) }} টাকা</p>
                                <p class="text-info">3rd Prize: {{ round($itm->third_prize ?? 0) }} টাকা</p>

                                {{-- Ticket Buy Button --}}
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
                // User is logged in -> go to dashboard
                window.location.href = btn.dataset.urlDashboard;
            @else
                // User not logged in -> go to login page
                alert('You need to login first!');
                window.location.href = btn.dataset.urlLogin;
            @endif
        });
    });
});
</script>



    <!-- Game Section Ends Here -->


    <!-- Why Choose Us Section Starts Here -->
    <section class="why-section padding-top padding-bottom overflow-hidden">
        <div class="container">
            <div class="row justify-content-between gy-5">
                <div class="col-lg-5 col-xl-4">
                    <div class="section-header mb-4">
                        <h2 class="section-header__title">Why Play Our Ticket</h2>
                        <p>A casino is a facility for certain types of gambling. Ticket are often built combined with hotels, resorts,</p>
                    </div>
                    <p>Debitis ad dolor sint consequatur hic, facere est doloribustemp oribus in laborum similique saepe bland itiis odio nulla repellat dicta reprehenderit. Obcaecati, sed perferendis? Quam cum debitis odit recusandae dolor earum.</p>
                </div>
                <div class="col-lg-7 col-xl-7">
                    <div class="row gy-4 gy-md-5 gy-lg-4 gy-xl-5">
                        <div class="col-lg-6 col-sm-6">
                            <div class="why-item">
                                <div class="why-item__thumb">
                                    <i class="las la-shield-alt"></i>
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">Secure Ticket Games</h4>
                                    <p>Games available in most Ticket are commonly called Ticket games. In a casino game. you will found options.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="why-item">
                                <div class="why-item__thumb">
                                    <i class="las la-dice-six"></i>
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">Awesome Game State</h4>
                                    <p>Games available in most Ticket are commonly called Ticket games. In a Ticket game. you will found options.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="why-item">
                                <div class="why-item__thumb">
                                    <i class="las la-trophy"></i>
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">Higher Wining Chance</h4>
                                    <p>Games available in most Ticket are commonly called Ticket games. In a Ticket game. you will found options.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="why-item">
                                <div class="why-item__thumb">
                                    <i class="las la-coins"></i>
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">Invest Win And Earn</h4>
                                    <p>Games available in most Ticket are commonly called Ticket games. In a Ticket game. you will found options.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shapes">
            <img src="{{asset('frontend')}}/assets/images/why/shape.png" alt="why" class="shape shape1">
        </div>
    </section>
    <!-- Why Choose Us Section Ends Here -->


    <!-- How Section Starts Here -->
    <section class="how-section padding-top padding-bottom bg_img" style="background: url(assets/images/how/bg2.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-header text-center">
                        <h2 class="section-header__title">How to  Ticket</h2>
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
    <!-- How Section Ends Here -->


    <!-- Faq Section Starts Here -->
    <section class="faq-section padding-top padding-bottom overflow-hidden">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6">
                    <div class="section-header text-center">
                        <h2 class="section-header__title">Frequently Asked Questions</h2>
                        <p>A Ticket is a facility for certain types of gambling. Ticket are often built combined with hotels, resorts.</p>
                    </div>
                </div>
            </div>
            <div class="faq-wrapper row justify-content-between">
                <div class="col-lg-6">
                    <div class="faq-item">
                        <div class="faq-item__title">
                            <h5 class="title">01. How do I create Ticket Account ?</h5>
                        </div>
                        <div class="faq-item__content">
                            <p>Autem ut suscipit, quibusdam officia, perferendis odio neque eius similique quae ipsum dolor voluptas sequi recusandae dolorem assumenda asperiores deleniti numquam iste fugit eligendi voluptates aliquam voluptate. Quas, magni excepturi ab, dolore explicabo  .</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-item__title">
                            <h5 class="title">01. How do I create Ticket Account ?</h5>
                        </div>
                        <div class="faq-item__content">
                            <p>Autem ut suscipit, quibusdam officia, perferendis odio neque eius similique quae ipsum dolor voluptas sequi recusandae dolorem assumenda asperiores deleniti numquam iste fugit eligendi voluptates aliquam voluptate. Quas, magni excepturi ab, dolore explicabo  .</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-item__title">
                            <h5 class="title">01. How do I create Ticket Account ?</h5>
                        </div>
                        <div class="faq-item__content">
                            <p>Autem ut suscipit, quibusdam officia, perferendis odio neque eius similique quae ipsum dolor voluptas sequi recusandae dolorem assumenda asperiores deleniti numquam iste fugit eligendi voluptates aliquam voluptate. Quas, magni excepturi ab, dolore explicabo  .</p>
                        </div>
                    </div>
                    <div class="faq-item mb-2 mb-lg-0">
                        <div class="faq-item__title">
                            <h5 class="title">01. How do I create Ticket Account ?</h5>
                        </div>
                        <div class="faq-item__content">
                            <p>Autem ut suscipit, quibusdam officia, perferendis odio neque eius similique quae ipsum dolor voluptas sequi recusandae dolorem assumenda asperiores deleniti numquam iste fugit eligendi voluptates aliquam voluptate. Quas, magni excepturi ab, dolore explicabo  .</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-item">
                        <div class="faq-item__title">
                            <h5 class="title">01. How do I create Ticket Account ?</h5>
                        </div>
                        <div class="faq-item__content">
                            <p>Autem ut suscipit, quibusdam officia, perferendis odio neque eius similique quae ipsum dolor voluptas sequi recusandae dolorem assumenda asperiores deleniti numquam iste fugit eligendi voluptates aliquam voluptate. Quas, magni excepturi ab, dolore explicabo  .</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-item__title">
                            <h5 class="title">01. How do I create Ticket Account ?</h5>
                        </div>
                        <div class="faq-item__content">
                            <p>Autem ut suscipit, quibusdam officia, perferendis odio neque eius similique quae ipsum dolor voluptas sequi recusandae dolorem assumenda asperiores deleniti numquam iste fugit eligendi voluptates aliquam voluptate. Quas, magni excepturi ab, dolore explicabo  .</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-item__title">
                            <h5 class="title">01. How do I create Ticket Account ?</h5>
                        </div>
                        <div class="faq-item__content">
                            <p>Autem ut suscipit, quibusdam officia, perferendis odio neque eius similique quae ipsum dolor voluptas sequi recusandae dolorem assumenda asperiores deleniti numquam iste fugit eligendi voluptates aliquam voluptate. Quas, magni excepturi ab, dolore explicabo  .</p>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-item__title">
                            <h5 class="title">01. How do I create Ticket Account ?</h5>
                        </div>
                        <div class="faq-item__content">
                            <p>Autem ut suscipit, quibusdam officia, perferendis odio neque eius similique quae ipsum dolor voluptas sequi recusandae dolorem assumenda asperiores deleniti numquam iste fugit eligendi voluptates aliquam voluptate. Quas, magni excepturi ab, dolore explicabo  .</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shapes">
            <img src="{{asset('frontend')}}/assets/images/faq/shape.png" alt="faq" class="shape shape1">
        </div>
    </section>
    <!-- Faq Section Ends Here -->


    <!-- Top Investor & Winner Section Starts Here -->
    <section class="top-section padding-top padding-bottom bg_img" style="background:url(assets/images/top/bg.png) center">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-4">
                    <h3 class="part-title mb-4">Latest Winner</h3>
                    <div class="top-investor-slider">
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="{{asset('frontend')}}/assets/images/top/item1.png" alt="top">
                                <p class="amount">$150</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Munna Ahmed</h6>
                            </div>
                        </div>
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="assets/images/top/item2.png" alt="top">
                                <p class="amount">$270</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Fahad Bin</h6>
                            </div>
                        </div>
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="{{asset('frontend')}}/assets/images/top/item3.png" alt="top">
                                <p class="amount">$52000</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Rafuj Raiha</h6>
                            </div>
                        </div>
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="{{asset('frontend')}}/assets/images/top/item1.png" alt="top">
                                <p class="amount">$150</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Munna Ahmed</h6>
                            </div>
                        </div>
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="{{asset('frontend')}}/assets/images/top/item3.png" alt="top">
                                <p class="amount">$50</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Rafuj Raihan</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cla-wrapper text-center">
                        <h3 class="title mb-4">WIN !!! & <br> Get million dollars</h3>
                        <a href="#0" class="cmn--btn active btn--md radius-0">Play Now</a>
                        <div class="thumb">
                            <img src="{{asset('frontend')}}/assets/images/top/bg2.png" alt="top">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h3 class="part-title mb-4">Top Investor</h3>
                    <div class="top-investor-slider">
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="assets/images/top/item1.png" alt="top">
                                <p class="amount">$150</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Munna Ahmed</h6>
                            </div>
                        </div>
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="{{asset('frontend')}}/assets/images/top/item2.png" alt="top">
                                <p class="amount">$270</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Fahad Bin</h6>
                            </div>
                        </div>
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="assets/images/top/item3.png" alt="top">
                                <p class="amount">$52000</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Rafuj Raiha</h6>
                            </div>
                        </div>
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="{{asset('frontend')}}/assets/images/top/item1.png" alt="top">
                                <p class="amount">$150</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Munna Ahmed</h6>
                            </div>
                        </div>
                        <div class="investor-item">
                            <div class="investor-item__thumb">
                                <img src="{{asset('frontend')}}/assets/images/top/item3.png" alt="top">
                                <p class="amount">$50</p>
                            </div>
                            <div class="investor-item__content">
                                <h6 class="name">Rafuj Raihan</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Top Investor & Winner Section Ends Here -->


    <!-- Testimonial Section Starts Here -->
    <section class="testimonial-section padding-top padding-bottom overflow-hidden">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6">
                    <div class="section-header text-center">
                        <h2 class="section-header__title">What Ticket Players Say</h2>
                        <p>A Ticket is a facility for certain types of gambling. Ticket are often built combined with hotels, resorts.</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-slider">
                <div class="single-slide">
                    <div class="testimonial-item bg_img" style="background: url(assets/images/testimonial/bg.png) center">
                        <div class="testimonial-inner">
                            <div class="testimonial-item__content">
                                <div class="quote-icon"><i class="las la-quote-left"></i></div>
                                <p>Ducimus ullam omnis eius unde ipsa minus excepturi pariatur! Vel sint cumque expedita  eveniet commodi asp voluptas recusandae voluptatem, accusantium in.</p>
                            </div>
                            <div class="thumb-wrapper">
                                <div class="thumb">
                                    <img src="{{asset('frontend')}}/assets/images/top/item1.png" alt="top">
                                </div>
                                <div class="content">
                                    <h6 class="name">Suraiya Nesa</h6>
                                    <span class="designation">Top Pocker</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slide">
                    <div class="testimonial-item bg_img" style="background: url(assets/images/testimonial/bg.png) center">
                        <div class="testimonial-inner">
                            <div class="testimonial-item__content">
                                <div class="quote-icon"><i class="las la-quote-left"></i></div>
                                <p>Ducimus ullam omnis eius unde ipsa minus excepturi pariatur! Vel sint cumque expedita  eveniet commodi asp voluptas recusandae voluptatem, accusantium in.</p>
                            </div>
                            <div class="thumb-wrapper">
                                <div class="thumb">
                                    <img src="{{asset('frontend')}}/assets/images/top/item2.png" alt="top">
                                </div>
                                <div class="content">
                                    <h6 class="name">Munna Ahmed</h6>
                                    <span class="designation">Top Pocker</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slide">
                    <div class="testimonial-item bg_img" style="background: url(assets/images/testimonial/bg.png) center">
                        <div class="testimonial-inner">
                            <div class="testimonial-item__content">
                                <div class="quote-icon"><i class="las la-quote-left"></i></div>
                                <p>Ducimus ullam omnis eius unde ipsa minus excepturi pariatur! Vel sint cumque expedita  eveniet commodi asp voluptas recusandae voluptatem, accusantium in.</p>
                            </div>
                            <div class="thumb-wrapper">
                                <div class="thumb">
                                    <img src="{{asset('frontend')}}/assets/images/top/item3.png" alt="top">
                                </div>
                                <div class="content">
                                    <h6 class="name">Rafuj Raihan</h6>
                                    <span class="designation">Top Pocker</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slide">
                    <div class="testimonial-item bg_img" style="background: url(assets/images/testimonial/bg.png) center">
                        <div class="testimonial-inner">
                            <div class="testimonial-item__content">
                                <div class="quote-icon"><i class="las la-quote-left"></i></div>
                                <p>Ducimus ullam omnis eius unde ipsa minus excepturi pariatur! Vel sint cumque expedita  eveniet commodi asp voluptas recusandae voluptatem, accusantium in.</p>
                            </div>
                            <div class="thumb-wrapper">
                                <div class="thumb">
                                    <img src="{{asset('frontend')}}/assets/images/top/item2.png" alt="top">
                                </div>
                                <div class="content">
                                    <h6 class="name">Fahad Foiz</h6>
                                    <span class="designation">Top Pocker</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="shapes">
            <img src="{{asset('frontend')}}/assets/images/why/shape.png" alt="why" class="shape shape1">
        </div>
    </section>
    <!-- Testimonial Section Ends Here -->
@endsection
