@extends('frontend.master')

@section('content')

@php
    // ============================================
    // CONFIGURATION & SETUP
    // ============================================
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#667eea';
    $secondaryColor = $activeTheme->secondary_color ?? '#764ba2';
    $currentLang = app()->getLocale();

    // ============================================
    // MULTILINGUAL HELPER
    // ============================================
    if (!function_exists('getTranslated')) {
        function getTranslated($data, $lang = 'en') {
            if (is_array($data)) {
                return $data[$lang] ?? $data['en'] ?? '';
            }
            if (is_string($data)) {
                $decoded = json_decode($data, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded[$lang] ?? $decoded['en'] ?? '';
                }
                return $data;
            }
            return '';
        }
    }

    // ============================================
    // TRANSLATIONS
    // ============================================
    $translations = [
        'en' => [
            'winners_title' => '🏆 Today\'s Winners',
            'withdrawals_title' => '💸 Recent Withdrawals',
            'deposits_title' => '💵 Recent Deposits',
            'ticket_price' => 'Ticket Price',
            'no_winners' => 'No winners yet!',
            'be_first' => 'Be the first to win',
            'no_withdrawals' => 'No withdrawals today',
            'no_deposits' => 'No deposits today',
            'place_1st' => '1st Place',
            'place_2nd' => '2nd Place',
            'place_3rd' => '3rd Place',
            'place_nth' => 'th Place',
        ],
        'bn' => [
            'winners_title' => '🏆 আজকের বিজয়ীরা',
            'withdrawals_title' => '💸 সাম্প্রতিক উত্তোলন',
            'deposits_title' => '💵 সাম্প্রতিক জমা',
            'ticket_price' => 'টিকেট মূল্য',
            'no_winners' => 'এখনো কোন বিজয়ী নেই!',
            'be_first' => 'প্রথম বিজয়ী হন',
            'no_withdrawals' => 'আজ কোন উত্তোলন নেই',
            'no_deposits' => 'আজ কোন জমা নেই',
            'place_1st' => '১ম স্থান',
            'place_2nd' => '২য় স্থান',
            'place_3rd' => '৩য় স্থান',
            'place_nth' => 'তম স্থান',
        ]
    ];

    $t = $translations[$currentLang] ?? $translations['en'];
    $chunkedPackages = $packages->chunk(4);
@endphp

@include('frontend.dashboard.usersection')

<div class="container px-3 mt-4">
    <div class="row">
        {{-- SIDEBAR --}}

            @include('frontend.dashboard.sidebar')


        {{-- MAIN CONTENT --}}
        <div class="col-lg-9 col-md-8">

            {{-- ==================== WINNERS SECTION ==================== --}}
            <section class="winner-section" aria-label="Today's Winners">
                <h2 class="section-title">{{ $t['winners_title'] }}</h2>

                <div class="main-slider-container">
                    <div class="winners-main-slider" id="main-slider" role="region" aria-live="polite">
                        @foreach($chunkedPackages as $slideIndex => $slidePackages)
                            <div class="main-slide {{ $slideIndex === 0 ? 'active' : '' }}"
                                 role="tabpanel"
                                 aria-hidden="{{ $slideIndex === 0 ? 'false' : 'true' }}">
                                <div class="winners-grid">
                                    @foreach($slidePackages as $package)
                                        @php
                                            $winners = $packageWinners[$package->id] ?? [];
                                            $packagePrice = round($package->price);
                                        @endphp

                                        <article class="winner-card">
                                            {{-- Package Header --}}
                                            <header class="package-header">
                                                <span class="package-icon" aria-hidden="true">💎</span>
                                                <h3 class="package-title">{{ $t['ticket_price'] }} ${{ $packagePrice }}</h3>
                                            </header>

                                            {{-- Winners Slider or Empty State --}}
                                            @if(count($winners) > 0)
                                                <div class="winners-slider-wrapper">
                                                    <div class="winners-slider"
                                                         id="slider-{{ $package->id }}"
                                                         data-package-id="{{ $package->id }}"
                                                         role="region"
                                                         aria-label="Winners for ${{ $packagePrice }} package">
                                                        @foreach($winners as $winnerIndex => $winner)
                                                            <div class="winner-slide {{ $winnerIndex === 0 ? 'active' : '' }}">
                                                                <div class="winner-content">
                                                                    {{-- Medal Icon --}}
                                                                    <div class="medal-icon" aria-hidden="true">
                                                                        @if($winnerIndex === 0) 🏆
                                                                        @elseif($winnerIndex === 1) 🥈
                                                                        @elseif($winnerIndex === 2) 🥉
                                                                        @else 🎖️
                                                                        @endif
                                                                    </div>

                                                                    {{-- Winner Image --}}
                                                                    <img src="{{ asset('uploads/profile/' . $winner->user->profile_photo) }}"
                                                                         alt="{{ $winner->user->name }}"
                                                                         class="winner-image"
                                                                         loading="lazy"
                                                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($winner->user->name) }}&background={{ str_replace('#', '', $primaryColor) }}&color=fff&size=120'">

                                                                    {{-- Winner Details --}}
                                                                    <h4 class="winner-name">{{ $winner->user->name }}</h4>
                                                                    <p class="winner-amount">💰 ${{ round($winner->win_amount) }}</p>

                                                                    {{-- Position Badge --}}
                                                                    <span class="winner-badge">
                                                                        @if($winnerIndex === 0) {{ $t['place_1st'] }}
                                                                        @elseif($winnerIndex === 1) {{ $t['place_2nd'] }}
                                                                        @elseif($winnerIndex === 2) {{ $t['place_3rd'] }}
                                                                        @else {{ $winnerIndex + 1 }}{{ $t['place_nth'] }}
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- Slide Counter --}}
                                                    <div class="slide-counter" aria-live="polite">
                                                        <span class="counter-current" data-package-id="{{ $package->id }}">1</span> / {{ count($winners) }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="no-winners-state">
                                                    <div class="empty-icon" aria-hidden="true">🎯</div>
                                                    <p class="empty-text">{{ $t['no_winners'] }}</p>
                                                    <small class="empty-subtext">{{ $t['be_first'] }}</small>
                                                </div>
                                            @endif
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Main Slider Navigation --}}
                    @if($chunkedPackages->count() > 1)
                        <nav class="main-slider-dots" role="navigation" aria-label="Package slides">
                            @foreach($chunkedPackages as $index => $slide)
                                <button class="dot {{ $index === 0 ? 'active' : '' }}"
                                        onclick="goToMainSlide({{ $index }})"
                                        aria-label="Go to slide {{ $index + 1 }}"
                                        aria-current="{{ $index === 0 ? 'true' : 'false' }}">
                                </button>
                            @endforeach
                        </nav>
                    @endif
                </div>
            </section>

            {{-- ==================== WITHDRAWALS SECTION ==================== --}}
            <section class="activity-section withdrawals" aria-label="Recent Withdrawals">
                <h2 class="section-title">{{ $t['withdrawals_title'] }}</h2>
                <div class="activity-slider-wrapper">
                    <div class="activity-slider" id="withdraw-slider" role="region" aria-live="polite">
                        @forelse($users_widthraw as $user)
                            @foreach($user->userWidthdraws as $withdrawal)
                                <div class="activity-item">
                                    <span class="activity-name">{{ $user->name }}</span>
                                    <span class="activity-separator" aria-hidden="true">-</span>
                                    <span class="activity-amount">${{ number_format($withdrawal->amount, 2) }}</span>
                                </div>
                            @endforeach
                        @empty
                            <div class="activity-item active">{{ $t['no_withdrawals'] }}</div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- ==================== DEPOSITS SECTION ==================== --}}
            <section class="activity-section deposits" aria-label="Recent Deposits">
                <h2 class="section-title">{{ $t['deposits_title'] }}</h2>
                <div class="activity-slider-wrapper">
                    <div class="activity-slider" id="deposit-slider" role="region" aria-live="polite">
                        @forelse($users_deposite as $user)
                            @if(isset($user->userDeposits) && count($user->userDeposits) > 0)
                                @foreach($user->userDeposits as $deposit)
                                    <div class="activity-item">
                                        <span class="activity-name">{{ $user->name }}</span>
                                        <span class="activity-separator" aria-hidden="true">-</span>
                                        <span class="activity-amount">${{ number_format($deposit->amount, 2) }}</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="activity-item">
                                    <span class="activity-name">{{ $user->name }}</span>
                                    <span class="activity-separator" aria-hidden="true">-</span>
                                    <span class="activity-amount">${{ number_format($user->total_deposite_balance ?? 0, 2) }}</span>
                                </div>
                            @endif
                        @empty
                            <div class="activity-item active">{{ $t['no_deposits'] }}</div>
                        @endforelse
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

{{-- ============================================
     OPTIMIZED STYLES
============================================ --}}
<style>
/* ==================== CSS VARIABLES ==================== */
:root {
    --primary: {{ $primaryColor }};
    --secondary: {{ $secondaryColor }};
    --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --radius: 16px;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 6px 20px rgba(0, 0, 0, 0.12);
    --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.2);
    --white: #ffffff;
    --text-dark: #2c3e50;
    --text-muted: #7f8c8d;
    --success: #27ae60;
    --gold: #ffd700;
}

/* ==================== WINNER SECTION ==================== */
.winner-section {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: var(--radius);
    padding: 24px 16px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.winner-section::before {
    content: '';
    position: absolute;
    inset: -50%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: rotate 30s linear infinite;
    pointer-events: none;
}

@keyframes rotate {
    to { transform: rotate(360deg); }
}

.section-title {
    color: var(--white);
    font-size: clamp(16px, 4vw, 22px);
    font-weight: 700;
    text-align: center;
    margin: 0 0 20px;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    letter-spacing: 0.5px;
    position: relative;
    z-index: 1;
}

/* ==================== SLIDER CONTAINER ==================== */
.main-slider-container {
    position: relative;
    width: 100%;
}

.winners-main-slider {
    position: relative;
    min-height: 300px;
}

.main-slide {
    display: none;
    opacity: 0;
    transition: opacity 0.6s ease-in-out;
}

.main-slide.active {
    display: block;
    opacity: 1;
}

/* ==================== WINNERS GRID ==================== */
.winners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    position: relative;
    z-index: 1;
}

/* ==================== WINNER CARD ==================== */
.winner-card {
    background: var(--white);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: transform var(--transition), box-shadow var(--transition);
}

.winner-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-lg);
}

/* ==================== PACKAGE HEADER ==================== */
.package-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.package-icon {
    font-size: 20px;
    animation: sparkle 2.5s ease-in-out infinite;
}

@keyframes sparkle {
    0%, 100% { transform: scale(1) rotate(0deg); }
    25% { transform: scale(1.2) rotate(90deg); }
    50% { transform: scale(1.3) rotate(180deg); }
    75% { transform: scale(1.2) rotate(270deg); }
}

.package-title {
    color: var(--white);
    font-size: 16px;
    font-weight: 700;
    margin: 0;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
}

/* ==================== WINNER SLIDER ==================== */
.winners-slider-wrapper {
    position: relative;
    min-height: 200px;
    padding: 16px 12px;
}

.winners-slider {
    position: relative;
    width: 100%;
}

.winner-slide {
    display: none;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
}

.winner-slide.active {
    display: block;
    opacity: 1;
    animation: fadeInScale 0.6s ease-out;
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.winner-content {
    text-align: center;
    padding: 8px;
}

/* ==================== WINNER ELEMENTS ==================== */
.medal-icon {
    font-size: 32px;
    margin-bottom: 12px;
    animation: bounce 2s ease-in-out infinite;
    filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.2));
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}

.winner-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid var(--primary);
    object-fit: cover;
    margin: 0 auto 12px;
    display: block;
    box-shadow: var(--shadow-md);
    transition: transform var(--transition);
}

.winner-image:hover {
    transform: scale(1.15) rotate(5deg);
}

.winner-name {
    font-size: 15px;
    font-weight: 700;
    color: var(--text-dark);
    margin: 8px 0;
    line-height: 1.3;
    word-wrap: break-word;
}

.winner-amount {
    font-size: 20px;
    font-weight: 800;
    color: var(--success);
    margin: 8px 0;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.winner-badge {
    display: inline-block;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: var(--white);
    padding: 6px 16px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 11px;
    margin-top: 8px;
    box-shadow: 0 3px 10px rgba(245, 87, 108, 0.4);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all var(--transition);
}

.winner-badge:hover {
    transform: scale(1.1);
}

/* ==================== SLIDE COUNTER ==================== */
.slide-counter {
    text-align: center;
    margin-top: 12px;
    font-size: 12px;
    font-weight: 600;
    color: var(--primary);
}

.counter-current {
    font-size: 15px;
    font-weight: 700;
    color: var(--secondary);
}

/* ==================== EMPTY STATE ==================== */
.no-winners-state {
    text-align: center;
    padding: 40px 16px;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 12px;
    opacity: 0.6;
    animation: pulseIcon 2s ease-in-out infinite;
}

@keyframes pulseIcon {
    0%, 100% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(1.15); opacity: 0.8; }
}

.empty-text {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-muted);
    margin: 8px 0;
}

.empty-subtext {
    font-size: 12px;
    color: #bdc3c7;
}

/* ==================== NAVIGATION DOTS ==================== */
.main-slider-dots {
    text-align: center;
    margin-top: 20px;
    position: relative;
    z-index: 1;
}

.dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    margin: 0 6px;
    cursor: pointer;
    transition: all var(--transition);
    border: 2px solid transparent;
}

.dot:hover {
    background: rgba(255, 255, 255, 0.7);
    transform: scale(1.2);
}

.dot.active {
    background: var(--white);
    width: 12px;
    height: 12px;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
}

/* ==================== ACTIVITY SECTIONS ==================== */
.activity-section {
    border-radius: var(--radius);
    padding: 24px 16px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.activity-section.withdrawals {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.activity-section.deposits {
    background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
}

.activity-section::before {
    content: '';
    position: absolute;
    inset: -50%;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
    animation: rotate 25s linear infinite reverse;
    pointer-events: none;
}

.activity-slider-wrapper {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 16px 12px;
    min-height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 1;
}

.activity-slider {
    position: relative;
    width: 100%;
}

.activity-item {
    display: none;
    opacity: 0;
    text-align: center;
    font-size: 20px;
    font-weight: 700;
    color: var(--white);
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
    transition: all 0.6s ease-in-out;
}

.activity-item.active {
    display: block;
    opacity: 1;
    animation: slideIn 0.6s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.activity-name {
    font-weight: 700;
}

.activity-separator {
    margin: 0 8px;
    opacity: 0.8;
}

.activity-amount {
    font-weight: 800;
    color: var(--gold);
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
}

/* ==================== RESPONSIVE DESIGN ==================== */
@media (min-width: 1400px) {
    .winners-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
}

@media (max-width: 991px) {
    .winners-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .winner-image {
        width: 60px;
        height: 60px;
    }
}

@media (max-width: 767px) {
    .winner-section,
    .activity-section {
        padding: 20px 12px;
        margin-bottom: 20px;
    }

    .winners-slider-wrapper {
        min-height: 180px;
        padding: 12px 8px;
    }

    .medal-icon {
        font-size: 24px;
    }

    .winner-image {
        width: 50px;
        height: 50px;
        border-width: 2px;
    }

    .winner-name {
        font-size: 13px;
    }

    .winner-amount {
        font-size: 16px;
    }

    .winner-badge {
        font-size: 10px;
        padding: 5px 12px;
    }

    .activity-item {
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    .winners-grid {
        grid-template-columns: 1fr;
    }
}
</style>

{{-- ============================================
     OPTIMIZED JAVASCRIPT
============================================ --}}
<script>
(function() {
    'use strict';

    // ============================================
    // CONFIGURATION
    // ============================================
    const CONFIG = {
        intervals: {
            withdrawal: 3000,
            deposit: 3500,
            winner: 3500,
            mainSlider: 8000
        },
        transition: 300,
        swipeThreshold: 50
    };

    // ============================================
    // UTILITIES
    // ============================================
    const $ = {
        qs: (sel, parent = document) => parent.querySelector(sel),
        qsa: (sel, parent = document) => Array.from(parent.querySelectorAll(sel)),
        on: (el, evt, handler, opts = {}) => {
            if (el) el.addEventListener(evt, handler, opts);
        },
        off: (el, evt, handler) => {
            if (el) el.removeEventListener(evt, handler);
        }
    };

    // ============================================
    // BASE SLIDER CLASS
    // ============================================
    class BaseSlider {
        constructor(selector, interval) {
            this.el = $.qs(selector);
            this.interval = interval;
            this.current = 0;
            this.timer = null;
            this.items = [];

            if (this.el) {
                this.init();
            }
        }

        init() {
            this.items = $.qsa(this.getItemSelector(), this.el);
            if (this.items.length > 1) {
                this.start();
            }
        }

        getItemSelector() {
            return '.slide';
        }

        start() {
            if (this.items.length <= 1) return;
            this.timer = setInterval(() => this.next(), this.interval);
        }

        next() {
            this.goTo((this.current + 1) % this.items.length);
        }

        prev() {
            this.goTo((this.current - 1 + this.items.length) % this.items.length);
        }

        goTo(index) {
            if (index < 0 || index >= this.items.length) return;

            this.items[this.current]?.classList.remove('active');
            this.current = index;
            this.items[this.current]?.classList.add('active');

            this.onSlideChange();
        }

        onSlideChange() {}

        pause() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        }

        destroy() {
            this.pause();
            this.el = null;
            this.items = [];
        }
    }

    // ============================================
    // ACTIVITY SLIDER
    // ============================================
    class ActivitySlider extends BaseSlider {
        getItemSelector() {
            return '.activity-item';
        }
    }

    // ============================================
    // WINNER SLIDER
    // ============================================
    class WinnerSlider extends BaseSlider {
        constructor(packageId, offset = 0) {
            super(`#slider-${packageId}`, CONFIG.intervals.winner + offset);
            this.packageId = packageId;
            this.counter = $.qs(`.counter-current[data-package-id="${packageId}"]`);
        }

        getItemSelector() {
            return '.winner-slide';
        }

        onSlideChange() {
            if (this.counter) {
                this.counter.textContent = this.current + 1;
            }
        }
    }

    // ============================================
    // MAIN SLIDER
    // ============================================
    class MainSlider extends BaseSlider {
        constructor() {
            super('#main-slider', CONFIG.intervals.mainSlider);
            this.dots = $.qsa('.main-slider-dots .dot');
            this.initTouch();
        }

        getItemSelector() {
            return '.main-slide';
        }

        onSlideChange() {
            this.dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === this.current);
                dot.setAttribute('aria-current', i === this.current ? 'true' : 'false');
            });

            this.items.forEach((item, i) => {
                item.setAttribute('aria-hidden', i !== this.current ? 'true' : 'false');
            });
        }

        initTouch() {
            let startX = 0;
            const container = $.qs('.main-slider-container');

            if (!container) return;

            $.on(container, 'touchstart', (e) => {
                startX = e.touches[0].clientX;
            }, { passive: true });

            $.on(container, 'touchend', (e) => {
                const endX = e.changedTouches[0].clientX;
                const diff = startX - endX;

                if (Math.abs(diff) > CONFIG.swipeThreshold) {
                    diff > 0 ? this.next() : this.prev();
                }
            }, { passive: true });
        }
    }

    // ============================================
    // SLIDER MANAGER
    // ============================================
    class SliderManager {
        constructor() {
            this.sliders = {
                main: null,
                winners: [],
                withdrawals: null,
                deposits: null
            };
            this.initialized = false;
        }

        init() {
            if (this.initialized) return;

            try {
                // Initialize activity sliders
                this.sliders.withdrawals = new ActivitySlider(
                    '#withdraw-slider',
                    CONFIG.intervals.withdrawal
                );

                this.sliders.deposits = new ActivitySlider(
                    '#deposit-slider',
                    CONFIG.intervals.deposit
                );

                // Initialize winner sliders
                $.qsa('.winners-slider').forEach((slider, index) => {
                    const packageId = slider.dataset.packageId;
                    if (packageId) {
                        this.sliders.winners.push(
                            new WinnerSlider(packageId, index * 300)
                        );
                    }
                });

                // Initialize main slider
                this.sliders.main = new MainSlider();

                // Handle visibility changes
                $.on(document, 'visibilitychange', () => {
                    document.hidden ? this.pauseAll() : this.resumeAll();
                });

                this.initialized = true;
                console.log('✅ Dashboard sliders initialized');
            } catch (error) {
                console.error('❌ Slider initialization failed:', error);
            }
        }

        pauseAll() {
            Object.values(this.sliders).flat().forEach(slider => {
                slider?.pause();
            });
        }

        resumeAll() {
            this.destroy();
            this.initialized = false;
            this.init();
        }

        destroy() {
            Object.values(this.sliders).flat().forEach(slider => {
                slider?.destroy();
            });
            this.sliders = {
                main: null,
                winners: [],
                withdrawals: null,
                deposits: null
            };
        }
    }

    // ============================================
    // GLOBAL FUNCTION FOR DOT NAVIGATION
    // ============================================
    window.goToMainSlide = function(index) {
        if (manager?.sliders?.main) {
            manager.sliders.main.goTo(index);
        }
    };

    // ============================================
    // INITIALIZATION
    // ============================================
    let manager = null;

    $.on(document, 'DOMContentLoaded', () => {
        manager = new SliderManager();
        manager.init();

        // Expose for debugging
        if (typeof window !== 'undefined') {
            window.dashboardSliderManager = manager;
        }
    });

    // ============================================
    // CLEANUP
    // ============================================
    $.on(window, 'beforeunload', () => {
        manager?.destroy();
    });

})();
</script>

@endsection
