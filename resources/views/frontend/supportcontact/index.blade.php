@extends('frontend.master')

@section('content')

@php
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

    $translations = [
        'en' => [
            'page_title' => 'Need Help?',
            'page_subtitle' => 'We\'re here to assist you 24/7',
            'support_channels' => 'Support Channels',
            'contact_us' => 'Contact Us',
            'quick_support' => 'Quick Support',
            'available_24_7' => 'Available 24/7',
            'reach_out' => 'Reach Out',
            'get_help' => 'Get Help Now',
            'support_team' => 'Our Support Team',
            'response_time' => 'Response Time',
            'minutes' => 'minutes',
            'satisfied_customers' => 'Satisfied Customers',
            'support_tickets' => 'Support Tickets',
            'online_now' => 'Online Now',
            'no_records' => 'No support channels available',
        ],
        'bn' => [
            'page_title' => 'সাহায্য প্রয়োজন?',
            'page_subtitle' => 'আমরা ২৪/৭ আপনাকে সহায়তা করতে এখানে আছি',
            'support_channels' => 'সহায়তা চ্যানেল',
            'contact_us' => 'আমাদের সাথে যোগাযোগ করুন',
            'quick_support' => 'দ্রুত সহায়তা',
            'available_24_7' => '২৪/৭ উপলব্ধ',
            'reach_out' => 'যোগাযোগ করুন',
            'get_help' => 'এখনই সাহায্য পান',
            'support_team' => 'আমাদের সহায়তা টিম',
            'response_time' => 'প্রতিক্রিয়া সময়',
            'minutes' => 'মিনিট',
            'satisfied_customers' => 'সন্তুষ্ট গ্রাহক',
            'support_tickets' => 'সহায়তা টিকিট',
            'online_now' => 'এখন অনলাইন',
            'no_records' => 'কোন সহায়তা চ্যানেল উপলব্ধ নেই',
        ],
    ];

    $lang = $translations[$isBangla ? 'bn' : 'en'];
@endphp

@include('frontend.dashboard.usersection')

<div class="container px-3 mt-4">
    <div class="row">
        @include('frontend.dashboard.sidebar')

        <div class="col-lg-9 col-md-8">

            {{-- HEADER --}}
            <div class="support-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h4>{{ $lang['page_title'] }}</h4>
                        <p>{{ $lang['page_subtitle'] }}</p>
                        <div class="status-badge">
                            <span class="status-dot"></span>
                            <span>{{ $lang['available_24_7'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STATISTICS --}}
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stat-card stat-card-1">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h6>{{ $lang['response_time'] }}</h6>
                            <h3>< 5</h3>
                            <span>{{ $lang['minutes'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card stat-card-2">
                        <div class="stat-icon">
                            <i class="fas fa-smile"></i>
                        </div>
                        <div class="stat-info">
                            <h6>{{ $lang['satisfied_customers'] }}</h6>
                            <h3>98%</h3>
                            <span>{{ $lang['support_team'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card stat-card-3">
                        <div class="stat-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="stat-info">
                            <h6>{{ $lang['support_tickets'] }}</h6>
                            <h3>10K+</h3>
                            <span>{{ $lang['quick_support'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SUPPORT CHANNELS --}}
            <div class="support-channels">
                <div class="section-header">
                    <h5><i class="fas fa-comments"></i> {{ $lang['support_channels'] }}</h5>
                </div>

                <div class="channels-grid">
                    @forelse ($supportcontact as $contact)
                        <div class="support-card">
                            <div class="card-badge">{{ $lang['quick_support'] }}</div>

                            <div class="card-image">
                                <img src="{{ asset('uploads/supports/' . $contact->photo) }}" alt="{{ $contact->title }}" onerror="this.src='{{ asset('assets/images/placeholder.png') }}'">
                                <div class="status-indicator">
                                    <span class="status-dot-small"></span>
                                </div>
                            </div>

                            <div class="card-body">
                                <h6>{{ $contact->title }}</h6>
                                @if(!empty($contact->description))
                                    <p>{{ Str::limit($contact->description, 60) }}</p>
                                @endif
                                <a href="{{ $contact->support_link }}" target="_blank" class="support-btn">
                                    <span>{{ $lang['reach_out'] }}</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h6>{{ $lang['contact_us'] }}</h6>
                            <p>{{ $lang['no_records'] }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- QUICK HELP CTA --}}
            @if($supportcontact->isNotEmpty())
                <div class="quick-help-cta">
                    <div class="cta-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="cta-text">
                        <h6>{{ $lang['get_help'] }}</h6>
                        <p>{{ $lang['page_subtitle'] }}</p>
                    </div>
                    <a href="{{ $supportcontact->first()->support_link }}" target="_blank" class="cta-button">
                        <span>{{ $lang['contact_us'] }}</span>
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>
{{-- ===================== STYLES ===================== --}}
<style>
:root {
    {{ $isBangla ? '--font: "Kalpurush", sans-serif;' : '--font: -apple-system, sans-serif;' }}
}

/* HEADER */
.support-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.support-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
    z-index: 1;
}

.header-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    color: #fff;
    flex-shrink: 0;
    animation: float 3s ease-in-out infinite;
}

.header-content h4 {
    color: #fff;
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 5px 0;
    font-family: var(--font);
}

.header-content p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0 0 10px 0;
    font-size: 14px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    font-family: var(--font);
}

.status-dot {
    width: 10px;
    height: 10px;
    background: #4ade80;
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
    box-shadow: 0 0 10px #4ade80;
}

/* STAT CARDS */
.stat-card {
    border-radius: 15px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.stat-card-1 {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-card-2 {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-card-3 {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #fff;
    flex-shrink: 0;
}

.stat-info h6 {
    color: rgba(255, 255, 255, 0.9);
    font-size: 13px;
    margin: 0 0 8px 0;
    font-weight: 600;
    font-family: var(--font);
}

.stat-info h3 {
    color: #fff;
    font-size: 32px;
    margin: 0 0 4px 0;
    font-weight: 700;
    font-family: var(--font);
}

.stat-info span {
    color: rgba(255, 255, 255, 0.8);
    font-size: 12px;
    font-family: var(--font);
}

/* SUPPORT CHANNELS */
.support-channels {
    margin-bottom: 25px;
}

.section-header h5 {
    color: #2c3e50;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font);
}

.section-header i {
    color: #667eea;
}

.channels-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

/* SUPPORT CARD */
.support-card {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    position: relative;
}

.support-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.card-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    z-index: 2;
    font-family: var(--font);
}

.card-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.support-card:hover .card-image img {
    transform: scale(1.1);
}

.status-indicator {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}

.status-dot-small {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #4ade80;
    animation: pulse 2s ease-in-out infinite;
    box-shadow: 0 0 10px #4ade80;
}

.card-body {
    padding: 20px;
}

.card-body h6 {
    color: #2c3e50;
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 10px 0;
    font-family: var(--font);
}

.card-body p {
    color: #6c757d;
    font-size: 14px;
    margin: 0 0 15px 0;
    line-height: 1.5;
    font-family: var(--font);
}

.support-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s;
    font-family: var(--font);
}

.support-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: #fff;
}

.support-btn i {
    transition: transform 0.3s;
}

.support-btn:hover i {
    transform: translateX(4px);
}

/* QUICK HELP CTA */
.quick-help-cta {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: 2px solid #667eea;
    border-radius: 15px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
}

.cta-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #fff;
    flex-shrink: 0;
    animation: float 3s ease-in-out infinite;
}

.cta-text {
    flex: 1;
}

.cta-text h6 {
    color: #2c3e50;
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 5px 0;
    font-family: var(--font);
}

.cta-text p {
    color: #6c757d;
    margin: 0;
    font-size: 14px;
    font-family: var(--font);
}

.cta-button {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 15px;
    transition: all 0.3s;
    flex-shrink: 0;
    font-family: var(--font);
}

.cta-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
    color: #fff;
}

.cta-button i {
    transition: transform 0.3s;
}

.cta-button:hover i {
    transform: translateX(4px);
}

/* EMPTY STATE */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 24px;
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3);
}

.empty-state i {
    font-size: 60px;
    color: #fff;
    margin-bottom: 20px;
    opacity: 0.9;
}

.empty-state h6 {
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 10px 0;
    font-family: var(--font);
}

.empty-state p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 14px;
    font-family: var(--font);
}

/* ANIMATIONS */
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.5;
        transform: scale(1.2);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.support-card {
    animation: fadeIn 0.5s ease;
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .support-header {
        padding: 25px;
    }
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    .header-icon {
        width: 70px;
        height: 70px;
        font-size: 35px;
    }
    .header-content h4 {
        font-size: 24px;
    }
}

@media (max-width: 767px) {
    .support-header {
        padding: 20px;
    }
    .header-icon {
        width: 60px;
        height: 60px;
        font-size: 30px;
    }
    .header-content h4 {
        font-size: 22px;
    }
    .stat-card {
        padding: 20px;
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }
    .stat-info h3 {
        font-size: 26px;
    }
    .channels-grid {
        grid-template-columns: 1fr;
    }
    .quick-help-cta {
        flex-direction: column;
        text-align: center;
        padding: 20px;
    }
    .cta-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }
}

@media (max-width: 576px) {
    .status-badge {
        padding: 6px 12px;
        font-size: 12px;
    }
    .card-image {
        height: 180px;
    }
    .empty-state {
        padding: 40px 20px;
    }
    .empty-state i {
        font-size: 40px;
    }
}
</style>

{{-- ===================== JAVASCRIPT ===================== --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // INTERSECTION OBSERVER
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.support-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // IMAGE ERROR HANDLING
    document.querySelectorAll('.card-image img').forEach(img => {
        img.addEventListener('error', function() {
            this.src = '{{ asset("assets/images/placeholder.png") }}';
        });
    });

    // TRACK CLICKS
    document.querySelectorAll('.support-btn, .cta-button').forEach(link => {
        link.addEventListener('click', function() {
            const channelName = this.closest('.support-card')?.querySelector('h6')?.textContent || 'Quick Help CTA';
            console.log('Support channel clicked:', channelName);
        });
    });

    console.log('✅ Support Page Loaded');
});
</script>

@endsection
