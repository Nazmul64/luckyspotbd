@extends('frontend.master')

@section('content')

@php
    // Fetch active theme colors from database
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '';
    $secondaryColor = $activeTheme->secondary_color ?? '';

    // Chunk packages for main slider (4 packages per slide)
    $chunkedPackages = $packages->chunk(4);
@endphp

@include('frontend.dashboard.usersection')

<div class="container px-3 mt-4">
    <div class="row ">
        {{-- Sidebar --}}
        <div class="col-8">
            @include('frontend.dashboard.sidebar')
        </div>

        {{-- Main Content --}}
        <div class="col-4">
            {{-- Winners Section --}}
            <div class="winner-section">
                <h2 class="section-title">🏆 Today's Winners 🏆</h2>

                <div class="main-slider-container">
                    <div class="winners-main-slider" id="main-slider">
                        @foreach($chunkedPackages as $slideIndex => $slidePackages)
                            <div class="main-slide {{ $slideIndex === 0 ? 'active' : '' }}">
                                <div class="winners-grid">
                                    @foreach($slidePackages as $package)
                                        @php
                                            $winners = $packageWinners[$package->id] ?? [];
                                            $packagePrice = round($package->price);
                                        @endphp

                                        <div class="winner-card">
                                            {{-- Package Header --}}
                                            <div class="package-header">
                                                <span class="package-icon">💎</span>
                                                <h3>Ticket Price ${{ $packagePrice }}</h3>
                                            </div>

                                            {{-- Winners Slider or Empty State --}}
                                            @if(count($winners) > 0)
                                                <div class="winners-slider-wrapper">
                                                    <div class="winners-slider"
                                                         id="slider-{{ $package->id }}"
                                                         data-package-id="{{ $package->id }}">
                                                        @foreach($winners as $winnerIndex => $winner)
                                                            <div class="winner-slide {{ $winnerIndex === 0 ? 'active' : '' }}">
                                                                <div class="winner-content">
                                                                    {{-- Medal Icon --}}
                                                                    <div class="medal-icon">
                                                                        @switch($winnerIndex)
                                                                            @case(0) 🏆 @break
                                                                            @case(1) 🥈 @break
                                                                            @case(2) 🥉 @break
                                                                            @default 🎖️
                                                                        @endswitch
                                                                    </div>

                                                                    {{-- Winner Image --}}
                                                                    <img src="{{ asset('uploads/profile/' . $winner->user->profile_photo) }}"
                                                                         alt="{{ $winner->user->name }}"
                                                                         class="winner-image"
                                                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($winner->user->name) }}&background=667eea&color=fff&size=120'">

                                                                    {{-- Winner Details --}}
                                                                    <h4 class="winner-name">{{ $winner->user->name }}</h4>
                                                                    <div class="winner-amount">💰 ${{ round($winner->win_amount) }}</div>

                                                                    {{-- Position Badge --}}
                                                                    <div class="winner-badge">
                                                                        {{ $winnerIndex === 0 ? '1st Place' : ($winnerIndex === 1 ? '2nd Place' : ($winnerIndex === 2 ? '3rd Place' : ($winnerIndex + 1) . 'th Place')) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- Slide Counter --}}
                                                    <div class="slide-counter">
                                                        <span class="counter-current" data-package-id="{{ $package->id }}">1</span> / {{ count($winners) }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="no-winners-state">
                                                    <div class="empty-icon">🎯</div>
                                                    <p class="empty-text">No winners yet!</p>
                                                    <small class="empty-subtext">Be the first to win</small>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Main Slider Navigation (if more than one slide) --}}
                    @if($chunkedPackages->count() > 1)
                        <div class="main-slider-dots">
                            @foreach($chunkedPackages as $index => $slide)
                                <span class="dot {{ $index === 0 ? 'active' : '' }}" onclick="goToMainSlide({{ $index }})"></span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Withdrawals Section --}}
            <div class="activity-section withdrawals">
                <h2 class="section-title">💸 Today's Recent Withdrawals 💸</h2>
                <div class="activity-slider-wrapper">
                    <div class="activity-slider" id="withdraw-slider">
                        @forelse($users_widthraw as $user)
                            @foreach($user->userWidthdraws as $withdrawal)
                                <div class="activity-item">
                                    <span class="activity-name">{{ $user->name }}</span>
                                    <span class="activity-separator">-</span>
                                    <span class="activity-amount">${{ number_format($withdrawal->amount, 2) }}</span>
                                </div>
                            @endforeach
                        @empty
                            <div class="activity-item active">No withdrawals today</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Deposits Section - FIXED VERSION --}}
            <div class="activity-section deposits">
                <h2 class="section-title">💵 Today's Recent Deposits 💵</h2>
                <div class="activity-slider-wrapper">
                    <div class="activity-slider" id="deposit-slider">
                        @forelse($users_deposite as $user)
                            {{-- Check if user has deposits relationship --}}
                            @if(isset($user->userDeposits) && count($user->userDeposits) > 0)
                                @foreach($user->userDeposits as $deposit)
                                    <div class="activity-item">
                                        <span class="activity-name">{{ $user->name }}</span>
                                        <span class="activity-separator">-</span>
                                        <span class="activity-amount">${{ number_format($deposit->amount, 2) }}</span>
                                    </div>
                                @endforeach
                            @else
                                {{-- Fallback to total_deposite_balance if deposits not available --}}
                                <div class="activity-item">
                                    <span class="activity-name">{{ $user->name }}</span>
                                    <span class="activity-separator">-</span>
                                    <span class="activity-amount">${{ number_format($user->total_deposite_balance ?? 0, 2) }}</span>
                                </div>
                            @endif
                        @empty
                            <div class="activity-item active">No deposits today</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ==================== WINNER SECTION ==================== */
    .winner-section {
        background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);
        border-radius: 16px;
        padding: 24px 16px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        position: relative;
        width: 287%;
        margin-left: -644px;
    }

    .section-title {
        color: #ffffff;
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
        letter-spacing: 0.5px;
    }

    /* ==================== MAIN SLIDER ==================== */
    .main-slider-container {
        position: relative;
        width: 100%;
        overflow: hidden;
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
        padding: 0;
    }

    /* ==================== WINNER CARD ==================== */
    .winner-card {
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .winner-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
    }

    /* ==================== PACKAGE HEADER ==================== */
    .package-header {
        background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);
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

    .package-header h3 {
        color: #ffffff;
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }

    /* ==================== WINNERS SLIDER ==================== */
    .winners-slider-wrapper {
        position: relative;
        min-height: 200px;
        padding: 16px 12px;
    }

    .winners-slider {
        position: relative;
        width: 100%;
        height: 100%;
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

    .winner-image {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid {{ $primaryColor }};
        object-fit: cover;
        margin: 0 auto 12px;
        display: block;
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
        transition: transform 0.3s ease;
    }

    .winner-image:hover {
        transform: scale(1.15);
    }

    .winner-name {
        font-size: 15px;
        font-weight: 700;
        color: #2c3e50;
        margin: 8px 0;
        line-height: 1.3;
        word-wrap: break-word;
    }

    .winner-amount {
        font-size: 20px;
        font-weight: 800;
        color: #27ae60;
        margin: 8px 0;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .winner-badge {
        display: inline-block;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: #ffffff;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 11px;
        margin-top: 8px;
        box-shadow: 0 3px 10px rgba(245, 87, 108, 0.4);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ==================== SLIDE COUNTER ==================== */
    .slide-counter {
        text-align: center;
        margin-top: 12px;
        font-size: 12px;
        font-weight: 600;
        color: {{ $primaryColor }};
    }

    .counter-current {
        font-size: 15px;
        font-weight: 700;
        color: {{ $secondaryColor }};
    }

    /* ==================== NO WINNERS STATE ==================== */
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
        animation: pulse 2s ease-in-out infinite;
    }

    .empty-text {
        font-size: 15px;
        font-weight: 600;
        color: #7f8c8d;
        margin: 8px 0;
    }

    .empty-subtext {
        font-size: 12px;
        color: #bdc3c7;
    }

    /* ==================== MAIN SLIDER DOTS ==================== */
    .main-slider-dots {
        text-align: center;
        margin-top: 20px;
    }

    .dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        margin: 0 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dot:hover {
        background: rgba(255, 255, 255, 0.7);
        transform: scale(1.2);
    }

    .dot.active {
        background: #ffffff;
        width: 12px;
        height: 12px;
    }

    /* ==================== ACTIVITY SECTION ==================== */
    .activity-section {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 16px;
        padding: 24px 16px;
        margin-bottom: 24px;
        box-shadow: 0 10px 40px rgba(245, 87, 108, 0.3);
        position: relative;
        width: 285%;
        margin-left: -642px;
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
    }

    .activity-slider {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .activity-item {
        display: none;
        opacity: 0;
        text-align: center;
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
        transition: all 0.6s ease-in-out;
        transform: translateY(-20px);
    }

    .activity-item.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
        animation: slideInFromBottom 0.6s ease-out;
    }

    .activity-item.exit {
        opacity: 0;
        transform: translateY(20px);
        animation: slideOutToTop 0.6s ease-out;
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
        color: #ffd700;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
    }

    /* ==================== ANIMATIONS ==================== */
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

    @keyframes slideInFromBottom {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideOutToTop {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-30px);
        }
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-12px);
        }
    }

    @keyframes sparkle {
        0%, 100% {
            transform: scale(1) rotate(0deg);
        }
        50% {
            transform: scale(1.3) rotate(180deg);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 0.6;
        }
        50% {
            transform: scale(1.15);
            opacity: 0.8;
        }
    }

    /* ==================== RESPONSIVE DESIGN ==================== */
    @media (min-width: 1400px) {
        .winners-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
    }

    @media (min-width: 1200px) and (max-width: 1399px) {
        .winners-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .winners-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .winner-image {
            width: 70px;
            height: 70px;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .winners-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .section-title {
            font-size: 20px;
        }

        .winner-image {
            width: 60px;
            height: 60px;
        }
    }

    @media (max-width: 767px) {
        .winners-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .section-title {
            font-size: 18px;
            margin-bottom: 16px;
        }

        .winner-section,
        .activity-section {
            padding: 20px 12px;
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .package-header {
            padding: 10px 12px;
        }

        .package-icon {
            font-size: 16px;
        }

        .package-header h3 {
            font-size: 14px;
        }

        .winners-slider-wrapper {
            min-height: 180px;
            padding: 12px 8px;
        }

        .medal-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .winner-image {
            width: 50px;
            height: 50px;
            border-width: 2px;
            margin-bottom: 8px;
        }

        .winner-name {
            font-size: 13px;
            margin: 6px 0;
        }

        .winner-amount {
            font-size: 16px;
            margin: 6px 0;
        }

        .winner-badge {
            font-size: 10px;
            padding: 5px 12px;
            margin-top: 6px;
        }

        .slide-counter {
            margin-top: 8px;
            font-size: 11px;
        }

        .counter-current {
            font-size: 13px;
        }

        .no-winners-state {
            padding: 30px 12px;
            min-height: 180px;
        }

        .empty-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .empty-text {
            font-size: 13px;
            margin: 6px 0;
        }

        .empty-subtext {
            font-size: 11px;
        }

        .activity-slider-wrapper {
            min-height: 50px;
            padding: 12px 10px;
        }

        .activity-item {
            font-size: 16px;
        }

        .activity-separator {
            margin: 0 6px;
        }
    }

    @media (max-width: 576px) {
        .winners-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .section-title {
            font-size: 16px;
        }

        .winner-card {
            max-width: 100%;
        }
    }

    @media (max-width: 400px) {
        .section-title {
            font-size: 15px;
        }

        .winners-slider-wrapper {
            min-height: 160px;
        }

        .medal-icon {
            font-size: 20px;
        }

        .winner-image {
            width: 45px;
            height: 45px;
        }

        .winner-name {
            font-size: 12px;
        }

        .winner-amount {
            font-size: 14px;
        }

        .winner-badge {
            font-size: 9px;
            padding: 4px 10px;
        }

        .activity-item {
            font-size: 14px;
        }
    }
</style>

<script>
    /**
     * ==================== DASHBOARD SLIDER SYSTEM ====================
     * Complete A-Z Implementation with proper activity slider handling
     * Author: Your Name
     * Version: 2.0
     */

    (function() {
        'use strict';

        /**
         * Configuration object for all sliders
         */
        const CONFIG = {
            withdrawalInterval: 3000,    // 3 seconds
            depositInterval: 3500,       // 3.5 seconds
            winnerSliderInterval: 3500,  // 3.5 seconds base
            mainSliderInterval: 8000,    // 8 seconds
            transitionDelay: 300         // Animation transition delay
        };

        /**
         * Main Slider Manager Class
         */
        class DashboardSliderManager {
            constructor() {
                this.mainSlideIndex = 0;
                this.packageSlideIndices = {};
                this.intervals = {};
                this.activitySliders = {};

                // Bind methods to maintain context
                this.handleMainSlideNavigation = this.handleMainSlideNavigation.bind(this);
            }

            /**
             * Initialize all slider components
             */
            initialize() {
                console.log('🚀 Initializing Dashboard Sliders...');

                try {
                    this.initializeActivitySliders();
                    this.initializeWinnerSliders();
                    this.initializeMainSlider();
                    this.initializeTouchSupport();
                    this.initializeVisibilityHandler();

                    console.log('✅ All sliders initialized successfully');
                } catch (error) {
                    console.error('❌ Error initializing sliders:', error);
                }
            }

            /**
             * Initialize activity sliders (withdrawals & deposits)
             */
            initializeActivitySliders() {
                console.log('📊 Initializing activity sliders...');

                this.activitySliders.withdrawals = new ActivitySlider(
                    'withdraw-slider',
                    CONFIG.withdrawalInterval,
                    'withdrawals'
                );

                this.activitySliders.deposits = new ActivitySlider(
                    'deposit-slider',
                    CONFIG.depositInterval,
                    'deposits'
                );

                // Start both activity sliders
                this.activitySliders.withdrawals.start();
                this.activitySliders.deposits.start();
            }

            /**
             * Initialize individual winner package sliders
             */
            initializeWinnerSliders() {
                console.log('🏆 Initializing winner sliders...');

                const sliders = document.querySelectorAll('.winners-slider');

                sliders.forEach((slider, index) => {
                    const packageId = slider.getAttribute('data-package-id');
                    const slides = slider.querySelectorAll('.winner-slide');

                    if (!packageId) {
                        console.warn('⚠️ Ticket ID not found for slider');
                        return;
                    }

                    // Initialize slide index
                    this.packageSlideIndices[packageId] = 0;

                    // Start auto-rotation if multiple slides exist
                    if (slides.length > 1) {
                        const intervalTime = CONFIG.winnerSliderInterval + (index * 300);

                        this.intervals[`winner-${packageId}`] = setInterval(() => {
                            this.changePackageSlide(packageId, 1);
                        }, intervalTime);

                        console.log(`✅ Winner slider for Ticket ${packageId} started`);
                    }

                    this.updatePackageCounter(packageId);
                });
            }

            /**
             * Change slide for specific package
             */
            changePackageSlide(packageId, direction) {
                const slider = document.getElementById(`slider-${packageId}`);
                if (!slider) return;

                const slides = slider.querySelectorAll('.winner-slide');
                if (slides.length <= 1) return;

                // Remove active class from current slide
                slides[this.packageSlideIndices[packageId]].classList.remove('active');

                // Calculate new index
                this.packageSlideIndices[packageId] += direction;

                // Handle wraparound
                if (this.packageSlideIndices[packageId] >= slides.length) {
                    this.packageSlideIndices[packageId] = 0;
                } else if (this.packageSlideIndices[packageId] < 0) {
                    this.packageSlideIndices[packageId] = slides.length - 1;
                }

                // Add active class to new slide
                slides[this.packageSlideIndices[packageId]].classList.add('active');

                // Update counter
                this.updatePackageCounter(packageId);
            }

            /**
             * Update counter display for package
             */
            updatePackageCounter(packageId) {
                const counter = document.querySelector(`.counter-current[data-package-id="${packageId}"]`);
                if (counter) {
                    counter.textContent = this.packageSlideIndices[packageId] + 1;
                }
            }

            /**
             * Initialize main slider (package groups)
             */
            initializeMainSlider() {
                console.log('🎯 Initializing main slider...');

                const mainSlider = document.getElementById('main-slider');
                const slides = mainSlider?.querySelectorAll('.main-slide');

                if (slides && slides.length > 1) {
                    this.intervals['main-slider'] = setInterval(() => {
                        this.changeMainSlide(1);
                    }, CONFIG.mainSliderInterval);

                    console.log('✅ Main slider started');
                }
            }

            /**
             * Change main slider slide
             */
            changeMainSlide(direction) {
                const mainSlider = document.getElementById('main-slider');
                const slides = mainSlider?.querySelectorAll('.main-slide');
                const dots = document.querySelectorAll('.main-slider-dots .dot');

                if (!slides || slides.length <= 1) return;

                // Remove active state
                slides[this.mainSlideIndex].classList.remove('active');
                if (dots[this.mainSlideIndex]) {
                    dots[this.mainSlideIndex].classList.remove('active');
                }

                // Calculate new index
                this.mainSlideIndex += direction;

                // Handle wraparound
                if (this.mainSlideIndex >= slides.length) {
                    this.mainSlideIndex = 0;
                } else if (this.mainSlideIndex < 0) {
                    this.mainSlideIndex = slides.length - 1;
                }

                // Add active state
                slides[this.mainSlideIndex].classList.add('active');
                if (dots[this.mainSlideIndex]) {
                    dots[this.mainSlideIndex].classList.add('active');
                }
            }

            /**
             * Navigate to specific main slide (called by dots)
             */
            handleMainSlideNavigation(index) {
                const mainSlider = document.getElementById('main-slider');
                const slides = mainSlider?.querySelectorAll('.main-slide');
                const dots = document.querySelectorAll('.main-slider-dots .dot');

                if (!slides || index < 0 || index >= slides.length) return;

                // Remove active state from current
                slides[this.mainSlideIndex].classList.remove('active');
                if (dots[this.mainSlideIndex]) {
                    dots[this.mainSlideIndex].classList.remove('active');
                }

                // Set new index
                this.mainSlideIndex = index;

                // Add active state to new
                slides[this.mainSlideIndex].classList.add('active');
                if (dots[this.mainSlideIndex]) {
                    dots[this.mainSlideIndex].classList.add('active');
                }
            }

            /**
             * Initialize touch/swipe support for mobile
             */
            initializeTouchSupport() {
                console.log('📱 Initializing touch support...');

                let touchStartX = 0;
                let touchEndX = 0;
                const swipeThreshold = 50;

                // Main slider touch support
                const mainContainer = document.querySelector('.main-slider-container');
                if (mainContainer) {
                    mainContainer.addEventListener('touchstart', (e) => {
                        touchStartX = e.touches[0].clientX;
                    }, { passive: true });

                    mainContainer.addEventListener('touchend', (e) => {
                        touchEndX = e.changedTouches[0].clientX;
                        const diff = touchStartX - touchEndX;

                        if (Math.abs(diff) > swipeThreshold) {
                            this.changeMainSlide(diff > 0 ? 1 : -1);
                        }
                    }, { passive: true });
                }

                // Individual winner sliders touch support
                document.querySelectorAll('.winners-slider').forEach((slider) => {
                    const packageId = slider.getAttribute('data-package-id');
                    let cardTouchStartX = 0;

                    slider.addEventListener('touchstart', (e) => {
                        e.stopPropagation();
                        cardTouchStartX = e.touches[0].clientX;
                    }, { passive: true });

                    slider.addEventListener('touchend', (e) => {
                        e.stopPropagation();
                        const cardTouchEndX = e.changedTouches[0].clientX;
                        const diff = cardTouchStartX - cardTouchEndX;

                        if (Math.abs(diff) > swipeThreshold) {
                            this.changePackageSlide(packageId, diff > 0 ? 1 : -1);
                        }
                    }, { passive: true });
                });

                console.log('✅ Touch support enabled');
            }

            /**
             * Initialize visibility change handler to pause/resume sliders
             */
            initializeVisibilityHandler() {
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        this.pauseAll();
                    } else {
                        this.resumeAll();
                    }
                });
            }

            /**
             * Pause all sliders
             */
            pauseAll() {
                console.log('⏸️ Pausing all sliders...');

                Object.values(this.intervals).forEach(interval => {
                    clearInterval(interval);
                });

                Object.values(this.activitySliders).forEach(slider => {
                    slider.pause();
                });
            }

            /**
             * Resume all sliders
             */
            resumeAll() {
                console.log('▶️ Resuming all sliders...');

                this.initialize();
            }

            /**
             * Cleanup all intervals and event listeners
             */
            destroy() {
                console.log('🧹 Cleaning up sliders...');

                // Clear all intervals
                Object.values(this.intervals).forEach(interval => {
                    clearInterval(interval);
                });

                // Stop activity sliders
                Object.values(this.activitySliders).forEach(slider => {
                    slider.stop();
                });

                this.intervals = {};
                this.activitySliders = {};

                console.log('✅ Cleanup complete');
            }
        }

        /**
         * Activity Slider Class (for withdrawals and deposits)
         */
        class ActivitySlider {
            constructor(sliderId, interval, type) {
                this.sliderId = sliderId;
                this.interval = interval;
                this.type = type;
                this.currentIndex = 0;
                this.intervalId = null;
                this.items = [];

                this.slider = document.getElementById(this.sliderId);

                if (!this.slider) {
                    console.warn(`⚠️ Slider not found: ${this.sliderId}`);
                    return;
                }

                this.items = Array.from(this.slider.querySelectorAll('.activity-item'));

                if (this.items.length === 0) {
                    console.warn(`⚠️ No items found in slider: ${this.sliderId}`);
                }
            }

            /**
             * Start the activity slider
             */
            start() {
                if (this.items.length === 0) return;

                // Show first item
                this.items[0].classList.add('active');

                // Only start interval if more than one item
                if (this.items.length > 1) {
                    this.intervalId = setInterval(() => {
                        this.next();
                    }, this.interval);

                    console.log(`✅ ${this.type} slider started with ${this.items.length} items`);
                }
            }

            /**
             * Move to next item with animation
             */
            next() {
                if (this.items.length <= 1) return;

                const currentItem = this.items[this.currentIndex];

                // Add exit animation
                currentItem.classList.remove('active');
                currentItem.classList.add('exit');

                // Calculate next index
                this.currentIndex = (this.currentIndex + 1) % this.items.length;

                // Show next item after transition
                setTimeout(() => {
                    // Remove exit class from all items
                    this.items.forEach(item => item.classList.remove('exit'));

                    // Show next item
                    this.items[this.currentIndex].classList.add('active');
                }, CONFIG.transitionDelay);
            }

            /**
             * Pause the slider
             */
            pause() {
                if (this.intervalId) {
                    clearInterval(this.intervalId);
                    this.intervalId = null;
                }
            }

            /**
             * Stop the slider completely
             */
            stop() {
                this.pause();

                // Remove all active states
                this.items.forEach(item => {
                    item.classList.remove('active', 'exit');
                });

                this.currentIndex = 0;
            }
        }

        /**
         * Global slider manager instance
         */
        let sliderManager = null;

        /**
         * Global function for main slide navigation (called by dots)
         */
        window.goToMainSlide = function(index) {
            if (sliderManager) {
                sliderManager.handleMainSlideNavigation(index);
            }
        };

        /**
         * Initialize on DOM ready
         */
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎬 DOM loaded, initializing slider system...');

            sliderManager = new DashboardSliderManager();
            sliderManager.initialize();
        });

        /**
         * Cleanup on page unload
         */
        window.addEventListener('beforeunload', function() {
            if (sliderManager) {
                sliderManager.destroy();
            }
        });

        /**
         * Expose slider manager to window for debugging (optional)
         */
        if (typeof window !== 'undefined') {
            window.dashboardSliderManager = sliderManager;
        }

    })();
</script>

@endsection
