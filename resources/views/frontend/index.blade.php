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
                            {{-- ✅ Use getTranslatedTitle() method instead --}}
                            {{ $item->getTranslatedTitle() }}
                        </h1>
                        <p class="banner-content__subtitle">
                            {{-- ✅ Use getTranslatedDescription() method instead --}}
                            {{ $item->getTranslatedDescription() }}
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
    <section class="about-section padding-top padding-bottom overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <div class="section-header mb-4">
                            <h2 class="section-header__title">{{ $item->title ?? '' }}</h2>
                            <p>{{ $item->description ?? '' }}</p>
                        </div>
                    </div>
                    <a href="sign-in.html" class="cmn--btn active mt-sm-5 mt-4">Get Started</a>
                </div>
                <div class="col-lg-6">
                    <div class="aobut-thumb section-thumb">
                        <img src="{{ asset($item->photo ?? '') }}" alt="about" class="ms-lg-5">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endforeach


<section class="lottery-section py-5" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
    <div class="container">
        {{-- Section Header --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="section-title text-white mb-3" style="font-size: 2.5rem; font-weight: 700;">
                    🎫 {{ app()->getLocale() === 'bn' ? 'লটারি টিকেট' : 'Available Lottery Tickets' }}
                </h2>
                <p class="text-white-50">
                    {{ app()->getLocale() === 'bn' ? 'আপনার ভাগ্যবান টিকেট বেছে নিন এবং আশ্চর্যজনক পুরস্কার জিতুন!' : 'Choose your lucky ticket and win amazing prizes!' }}
                </p>
            </div>
        </div>

        {{-- Lottery Cards Grid --}}
        <div class="row g-4">
            @forelse ($lottery_show as $lottery)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="lottery-card">
                        {{-- Image Section --}}
                        <div class="lottery-card-image">
                            <img src="{{ asset('uploads/lottery/' . ($lottery->photo ?? 'default.png')) }}"
                                 alt="{{ $lottery->getTranslatedName() }}"
                                 onerror="this.src='{{ asset('uploads/lottery/' . ($lottery->photo ?? 'default.png')) }}'">

                            {{-- Status Badge --}}
                            <span class="status-badge status-{{ $lottery->status }}">
                                @if($lottery->status === 'active')
                                    <i class="fas fa-circle-notch fa-spin"></i> {{ app()->getLocale() === 'bn' ? 'সক্রিয়' : 'LIVE' }}
                                @elseif($lottery->status === 'completed')
                                    <i class="fas fa-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'সম্পন্ন' : 'COMPLETED' }}
                                @else
                                    <i class="fas fa-pause-circle"></i> {{ app()->getLocale() === 'bn' ? 'নিষ্ক্রিয়' : 'INACTIVE' }}
                                @endif
                            </span>

                            {{-- Win Type Badge --}}
                            <span class="win-type-badge">
                                <i class="fas fa-trophy"></i> {{ strtoupper($lottery->win_type ?? 'N/A') }}
                            </span>
                        </div>

                        {{-- Card Body --}}
                        <div class="lottery-card-body">
                            {{-- ✅ SINGLE LANGUAGE NAME DISPLAY --}}
                            <h5 class="lottery-title">
                                {{ $lottery->getTranslatedName() }}
                            </h5>

                            {{-- ✅ SINGLE LANGUAGE DESCRIPTION DISPLAY --}}
                            @php
                                $description = $lottery->getTranslatedDescription();
                            @endphp
                            @if($description)
                                <p class="lottery-description">
                                    {{ Str::limit($description, 80) }}
                                </p>
                            @endif

                            {{-- Price Box --}}
                            <div class="price-box">
                                <div class="price-label">
                                    <i class="fas fa-ticket-alt"></i>
                                    {{ app()->getLocale() === 'bn' ? 'টিকেট মূল্য' : 'Ticket Price' }}
                                </div>
                                <div class="price-value">
                                    {{ $lottery->price ? number_format($lottery->price, 0) : '0' }} {{ app()->getLocale() === 'bn' ? 'টাকা' : 'Taka' }}
                                </div>
                            </div>

                            {{-- Draw Date & Time --}}
                            <div class="draw-info">
                                <div class="draw-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ app()->getLocale() === 'bn' ? 'ড্র তারিখ' : 'Draw Date' }}
                                </div>
                                <div class="draw-value">
                                    {{ $lottery->draw_date ? $lottery->draw_date->format('d M Y') : (app()->getLocale() === 'bn' ? 'ঘোষণা করা হয়নি' : 'TBA') }}
                                </div>
                                <div class="draw-time">
                                    {{ $lottery->draw_date ? $lottery->draw_date->format('h:i A') : '' }}
                                </div>
                            </div>

                            {{-- Countdown Timer --}}
                            @if($lottery->draw_date)
                                <div class="countdown-box"
                                     data-draw="{{ $lottery->draw_date->format('Y-m-d H:i:s') }}"
                                     data-lang="{{ app()->getLocale() }}">
                                    <i class="fas fa-hourglass-half"></i>
                                    {{ app()->getLocale() === 'bn' ? 'গণনা করা হচ্ছে...' : 'Calculating...' }}
                                </div>
                            @endif

                            {{-- Prizes --}}
                            <div class="prizes-grid">
                                <div class="prize-item prize-1st">
                                    <i class="fas fa-trophy"></i>
                                    <span class="prize-label">
                                        {{ app()->getLocale() === 'bn' ? '১ম' : '1st' }}
                                    </span>
                                    <span class="prize-amount">{{ number_format($lottery->first_prize ?? 0) }}</span>
                                </div>
                                <div class="prize-item prize-2nd">
                                    <i class="fas fa-award"></i>
                                    <span class="prize-label">
                                        {{ app()->getLocale() === 'bn' ? '২য়' : '2nd' }}
                                    </span>
                                    <span class="prize-amount">{{ number_format($lottery->second_prize ?? 0) }}</span>
                                </div>
                                <div class="prize-item prize-3rd">
                                    <i class="fas fa-star"></i>
                                    <span class="prize-label">
                                        {{ app()->getLocale() === 'bn' ? '৩য়' : '3rd' }}
                                    </span>
                                    <span class="prize-amount">{{ number_format($lottery->third_prize ?? 0) }}</span>
                                </div>
                            </div>

                            {{-- Packages Info --}}
                            @if(is_array($lottery->multiple_title) && count(array_filter($lottery->multiple_title)) > 0)
                                <div class="packages-info">
                                    <i class="fas fa-gift"></i>
                                    {{ count(array_filter($lottery->multiple_title)) }}
                                    {{ app()->getLocale() === 'bn' ? 'বিশেষ প্যাকেজ' : 'Special Packages' }}
                                </div>
                            @endif

                            {{-- Buy Button --}}
                            <button class="btn-buy-ticket"
                                    data-lottery-id="{{ $lottery->id }}"
                                    data-lottery-name="{{ $lottery->getTranslatedName() }}"
                                    data-url-dashboard="{{ route('frontend.dashboard') }}"
                                    data-url-login="{{ route('frontend.login') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span>{{ app()->getLocale() === 'bn' ? 'টিকেট কিনুন' : 'Buy Ticket Now' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-ticket-alt"></i>
                        <h4>{{ app()->getLocale() === 'bn' ? 'কোন লটারি টিকেট নেই' : 'No Lottery Tickets Available' }}</h4>
                        <p>{{ app()->getLocale() === 'bn' ? 'নতুন লটারি টিকেটের জন্য পরে চেক করুন।' : 'Please check back later for new lottery tickets.' }}</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================
     STYLES
============================================ --}}
<style>
.lottery-card {
    background: linear-gradient(145deg, #2d1b3d 0%, #1a0f2e 100%);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid rgba(255,255,255,0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.lottery-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 60px rgba(102,126,234,0.6);
    border-color: rgba(102,126,234,0.5);
}

.lottery-card-image {
    position: relative;
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.lottery-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.lottery-card:hover .lottery-card-image img {
    transform: scale(1.15) rotate(2deg);
}

.status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.status-active {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: #fff;
    animation: pulse 2s infinite;
}

.status-inactive {
    background: linear-gradient(135deg, #f85032 0%, #e73827 100%);
    color: #fff;
}

.status-completed {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
}

.win-type-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(0,0,0,0.8);
    backdrop-filter: blur(10px);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    color: #ffd700;
    letter-spacing: 0.5px;
}

.lottery-card-body {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* ✅ SINGLE LANGUAGE TITLE */
.lottery-title {
    font-size: 18px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 15px;
    line-height: 1.4;
    min-height: 50px;
    display: flex;
    align-items: center;
}

/* ✅ SINGLE LANGUAGE DESCRIPTION */
.lottery-description {
    font-size: 13px;
    color: rgba(255,255,255,0.7);
    line-height: 1.6;
    margin-bottom: 15px;
    min-height: 40px;
}

.price-box {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    padding: 15px;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 15px;
    box-shadow: 0 4px 15px rgba(255,215,0,0.4);
}

.price-label {
    font-size: 11px;
    color: #000;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}

.price-value {
    font-size: 24px;
    font-weight: 800;
    color: #000;
}

.draw-info {
    background: rgba(255,255,255,0.05);
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 15px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.1);
}

.draw-label {
    font-size: 10px;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}

.draw-value {
    font-size: 15px;
    font-weight: 700;
    color: #fff;
}

.draw-time {
    font-size: 12px;
    color: #ffd700;
    font-weight: 600;
}

.countdown-box {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    padding: 12px;
    border-radius: 10px;
    text-align: center;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 15px;
    box-shadow: 0 4px 12px rgba(245,87,108,0.5);
}

.prizes-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 15px;
}

.prize-item {
    background: rgba(255,255,255,0.05);
    padding: 12px 8px;
    border-radius: 10px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.1);
}

.prize-item i {
    font-size: 18px;
    display: block;
    margin-bottom: 5px;
}

.prize-1st i { color: #ffd700; }
.prize-2nd i { color: #c0c0c0; }
.prize-3rd i { color: #cd7f32; }

.prize-label {
    display: block;
    font-size: 10px;
    color: rgba(255,255,255,0.6);
    margin-bottom: 3px;
    text-transform: uppercase;
}

.prize-amount {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
}

.packages-info {
    background: rgba(99,102,241,0.2);
    border: 1px solid rgba(99,102,241,0.4);
    padding: 10px;
    border-radius: 8px;
    font-size: 12px;
    color: #a5b4fc;
    text-align: center;
    margin-bottom: 15px;
}

.btn-buy-ticket {
    width: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 15px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 6px 20px rgba(102,126,234,0.5);
    margin-top: auto;
}

.btn-buy-ticket:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102,126,234,0.7);
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: rgba(255,255,255,0.5);
}

.empty-state i {
    font-size: 80px;
    margin-bottom: 20px;
    opacity: 0.3;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

@media (max-width: 576px) {
    .lottery-card-image {
        height: 180px;
    }

    .lottery-title {
        font-size: 16px;
        min-height: 40px;
    }

    .price-value {
        font-size: 20px;
    }
}
</style>

{{-- ============================================
     JAVASCRIPT
============================================ --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ====================================
    // Countdown Timer with Language Support
    // ====================================
    function updateCountdowns() {
        const timers = document.querySelectorAll('.countdown-box');

        timers.forEach(timer => {
            const drawTime = timer.getAttribute('data-draw');
            const lang = timer.getAttribute('data-lang');
            if (!drawTime) return;

            const drawDate = new Date(drawTime);
            const now = new Date();
            const diff = drawDate - now;

            if (diff <= 0) {
                const completedText = lang === 'bn' ? 'ড্র সম্পন্ন হয়েছে!' : 'Draw Completed!';
                timer.innerHTML = `<i class="fas fa-check-circle"></i> ${completedText}`;
                timer.style.background = 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)';
                return;
            }

            const days = Math.floor(diff / (1000*60*60*24));
            const hours = Math.floor((diff % (1000*60*60*24)) / (1000*60*60));
            const minutes = Math.floor((diff % (1000*60*60)) / (1000*60));
            const seconds = Math.floor((diff % (1000*60)) / 1000);

            let timeString = '';
            if (lang === 'bn') {
                if (days > 0) timeString += `${convertToBengaliNumber(days)} দিন `;
                timeString += `${convertToBengaliNumber(hours)} ঘন্টা ${convertToBengaliNumber(minutes)} মিনিট ${convertToBengaliNumber(seconds)} সেকেন্ড`;
            } else {
                if (days > 0) timeString += `${days}d `;
                timeString += `${hours}h ${minutes}m ${seconds}s`;
            }

            timer.innerHTML = `<i class="fas fa-hourglass-half"></i> ${timeString}`;
        });
    }

    function convertToBengaliNumber(num) {
        const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return num.toString().split('').map(digit => bengaliDigits[digit] || digit).join('');
    }

    updateCountdowns();
    setInterval(updateCountdowns, 1000);

    // ====================================
    // Buy Ticket Handler
    // ====================================
    const buyButtons = document.querySelectorAll('.btn-buy-ticket');

    buyButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const lotteryId = this.dataset.lotteryId;
            const lotteryName = this.dataset.lotteryName;
            const lang = '{{ app()->getLocale() }}';

            @if(Auth::check())
                console.log('Buying ticket:', lotteryId, lotteryName);
                window.location.href = this.dataset.urlDashboard;
            @else
                const alertMessage = lang === 'bn'
                    ? `⚠️ টিকেট কিনতে প্রথমে লগইন করুন!\n\nলটারি: ${lotteryName}`
                    : `⚠️ You need to login first to buy a ticket!\n\nLottery: ${lotteryName}`;
                alert(alertMessage);
                window.location.href = this.dataset.urlLogin;
            @endif
        });
    });
});
</script>

{{-- =======================
    WHY CHOOSE US SECTION
======================= --}}
{{-- resources/views/frontend/partials/whychooseus.blade.php --}}

{{-- =======================
    WHY CHOOSE US SECTION
======================= --}}
<section class="why-section py-5 overflow-hidden">
    <div class="container">
        <div class="row justify-content-between align-items-center gy-5">

            <!-- Left Content -->
            <div class="col-lg-5 col-xl-4">
                @php
                    $firstItem = $whychooseustickets->first();
                    $mainTitle = $firstItem ? $firstItem->getTranslatedMainTitle() : '';
                    $mainDescription = $firstItem ? $firstItem->getTranslatedMainDescription() : '';
                @endphp

                <div class="section-header mb-4">
                    <h2 class="section-header__title">
                        {{ $mainTitle ?: trans_db('Why Choose Us', 'Why Choose Us') }}
                    </h2>
                </div>
                <p>{{ $mainDescription ?: trans_db('Discover why thousands trust us for their lottery needs.', 'Discover why thousands trust us for their lottery needs.') }}</p>
            </div>

            <!-- Right Boxes -->
            <div class="col-lg-7 col-xl-7">
                <div class="row gy-4">
                    @forelse ($whychooseustickets as $item)
                        @php
                            $itemTitle = $item->getTranslatedTitle();
                            $itemDescription = $item->getTranslatedDescription();
                        @endphp

                        <div class="col-md-6">
                            <div class="why-item d-flex align-items-start gap-3">
                                <div class="why-item__thumb fs-2 text-primary">
                                    @if($item->icon)
                                        <i class="{{ $item->icon }}"></i>
                                    @else
                                        <i class="las la-shield-alt"></i>
                                    @endif
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">
                                        {{ $itemTitle ?: trans_db('Feature', 'Feature') }}
                                    </h4>
                                    <p>
                                        {{ $itemDescription ?: trans_db('Amazing feature description.', 'Amazing feature description.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Default Content if no items --}}
                        <div class="col-md-6">
                            <div class="why-item d-flex align-items-start gap-3">
                                <div class="why-item__thumb fs-2 text-primary">
                                    <i class="las la-shield-alt"></i>
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">{{ trans_db('Secure & Safe', 'Secure & Safe') }}</h4>
                                    <p>{{ trans_db('Your transactions and data are completely secure with us.', 'Your transactions and data are completely secure with us.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="why-item d-flex align-items-start gap-3">
                                <div class="why-item__thumb fs-2 text-primary">
                                    <i class="las la-trophy"></i>
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">{{ trans_db('Big Prizes', 'Big Prizes') }}</h4>
                                    <p>{{ trans_db('Win amazing prizes and jackpots every day.', 'Win amazing prizes and jackpots every day.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="why-item d-flex align-items-start gap-3">
                                <div class="why-item__thumb fs-2 text-primary">
                                    <i class="las la-clock"></i>
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">{{ trans_db('24/7 Support', '24/7 Support') }}</h4>
                                    <p>{{ trans_db('Get help anytime, anywhere. We are always here for you.', 'Get help anytime, anywhere. We are always here for you.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="why-item d-flex align-items-start gap-3">
                                <div class="why-item__thumb fs-2 text-primary">
                                    <i class="las la-bolt"></i>
                                </div>
                                <div class="why-item__content">
                                    <h4 class="title">{{ trans_db('Fast Payouts', 'Fast Payouts') }}</h4>
                                    <p>{{ trans_db('Quick and easy withdrawals with multiple payment options.', 'Quick and easy withdrawals with multiple payment options.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
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


@php
    $how = $howtoticket ?? null;
@endphp

<section class="how-section padding-top padding-bottom bg_img"
         style="background: url({{ asset('assets/images/how/bg2.jpg') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section-header__title">
                        {{ optional($how)->getTitle() ?? 'How It Works' }}
                    </h2>
                    <p>
                        {{ optional($how)->getDescription() ?? '' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">

            <!-- Step 1 -->
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="how-item">
                    <div class="how-item__thumb">
                        <i class="{{ optional($how)->sign_up_first_login_icon ?? 'fas fa-user-plus' }}"></i>
                    </div>
                    <div class="how-item__content">
                        <h4 class="title">
                            {{ optional($how)->getSignUpFirstLogin() ?? 'Sign Up / First Login' }}
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="how-item">
                    <div class="how-item__thumb">
                        <i class="{{ optional($how)->complete_your_profile_icon ?? 'fas fa-user-check' }}"></i>
                    </div>
                    <div class="how-item__content">
                        <h4 class="title">
                            {{ optional($how)->getCompleteYourProfile() ?? 'Complete Your Profile' }}
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="how-item">
                    <div class="how-item__thumb">
                        <i class="{{ optional($how)->choose_a_ticket_icon ?? 'fas fa-ticket-alt' }}"></i>
                    </div>
                    <div class="how-item__content">
                        <h4 class="title">
                            {{ optional($how)->getChooseATicket() ?? 'Choose a Ticket' }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =======================
    FAQ SECTION
======================= --}}
<section class="faq-section padding-top padding-bottom overflow-hidden" id="faq">
    <div class="container">

        @if($faq->count())
            @php
                $firstItem = $faq->first(); // for header
                $faqChunks = $faq->chunk(ceil($faq->count() / 2)); // split into two columns
            @endphp

            <!-- Section Header -->
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6">
                    <div class="section-header text-center">
                        <h2 class="section-header__title">
                            {{ $firstItem->title[app()->getLocale()] ?? $firstItem->title['en'] ?? '' }}
                        </h2>
                        <p>
                            {{ $firstItem->description[app()->getLocale()] ?? $firstItem->description['en'] ?? '' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ Items -->
            <div class="faq-wrapper row justify-content-between mt-5">
                @foreach($faqChunks as $colIndex => $faqColumn)
                    <div class="col-lg-6">
                        @foreach($faqColumn as $index => $item)
                            @php
                                $serial = ($colIndex * $faqColumn->count()) + $index + 1;
                            @endphp
                            <div class="faq-item mb-4">
                                <div class="faq-item__title">
                                    <h5 class="title">
                                        {{ str_pad($serial, 2, '0', STR_PAD_LEFT) }}.
                                        {{ $item->question[app()->getLocale()] ?? $item->question['en'] ?? '' }}
                                    </h5>
                                </div>
                                <div class="faq-item__content">
                                    <p>{{ $item->answer[app()->getLocale()] ?? $item->answer['en'] ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <!-- Shapes -->
    <div class="shapes">
        <img src="{{ asset('frontend/assets/images/faq/shape.png') }}" alt="faq" class="shape shape1">
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
             @php
                $lang = session('locale', 'en'); // বা config('app.locale')
            @endphp

            @foreach($testmonail as $item)
        <!-- Section Header -->
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6">
                <div class="section-header text-center">
                    <h2 class="section-header__title">
                        {{ __($item->title[$lang] ?? 'What Ticket Players Say') }}
                    </h2>
                    <p>{{ __($item->description[$lang] ?? 'A Ticket is a facility for certain types of gambling. Tickets are often combined with hotels, resorts.') }}</p>
                </div>
            </div>
        </div>

        <!-- Testimonial Slider -->
        <div class="testimonial-slider">


                <div class="single-slide">
                    <div class="testimonial-item bg_img" style="background: url({{ asset('frontend/assets/images/testimonial/bg.png') }}) center / cover no-repeat;">
                        <div class="testimonial-inner">

                            <!-- Message -->
                            <div class="testimonial-item__content">
                                <div class="quote-icon"><i class="las la-quote-left"></i></div>
                                <p>{{ $item->message[$lang] ?? '' }}</p>
                            </div>

                            <!-- User Info -->
                            <div class="thumb-wrapper d-flex align-items-center mt-3">
                                <div class="thumb me-3">
                                    @if($item->photo && file_exists(public_path($item->photo)))
                                        <img src="{{ asset($item->photo) }}"
                                             alt="{{ $item->name[$lang] ?? '' }}"
                                             class="rounded-circle" width="60" height="60">
                                    @else
                                        <img src="{{ asset('frontend/assets/images/testimonial/default.png') }}"
                                             alt="No Photo"
                                             class="rounded-circle" width="60" height="60">
                                    @endif
                                </div>
                                <div class="content">
                                    <h6 class="name mb-0">{{ $item->name[$lang] ?? '' }}</h6>
                                    <span class="designation">{{ $item->designation[$lang] ?? '' }}</span>
                                </div>
                            </div>

                            <!-- Optional Title & Description -->
                            @if(!empty($item->title[$lang]) || !empty($item->description[$lang]))
                                <div class="testimonial-extra mt-2">
                                    @if(!empty($item->title[$lang]))
                                        <h5 class="testimonial-title">{{ $item->title[$lang] }}</h5>
                                    @endif
                                    @if(!empty($item->description[$lang]))
                                        <p class="testimonial-description">{{ $item->description[$lang] }}</p>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>



@endsection
