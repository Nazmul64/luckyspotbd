@extends('frontend.master')

@section('content')

@php
    // ============================================
    // THEME CONFIGURATION
    // ============================================
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#667eea';
    $secondaryColor = $activeTheme->secondary_color ?? '#764ba2';

    // ============================================
    // LANGUAGE DETECTION
    // ============================================
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

    // ============================================
    // TRANSLATIONS
    // ============================================
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
            'response_time' => 'Average Response Time',
            'minutes' => 'minutes',
            'satisfied_customers' => 'Satisfied Customers',
            'support_tickets' => 'Support Tickets Resolved',
            'online_now' => 'Online Now',
            'away' => 'Away',
            'offline' => 'Offline',
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
            'response_time' => 'গড় প্রতিক্রিয়া সময়',
            'minutes' => 'মিনিট',
            'satisfied_customers' => 'সন্তুষ্ট গ্রাহক',
            'support_tickets' => 'সমাধান করা সহায়তা টিকিট',
            'online_now' => 'এখন অনলাইন',
            'away' => 'দূরে',
            'offline' => 'অফলাইন',
        ],
    ];

    $lang = $translations[$isBangla ? 'bn' : 'en'];

    // ============================================
    // SUPPORT STATISTICS
    // ============================================
    $supportStats = [
        'response_time' => '< 5',
        'satisfied_rate' => '98%',
        'tickets_resolved' => '10,000+',
    ];
@endphp

{{-- User Top Section --}}
@include('frontend.dashboard.usersection')

<div class="container px-3 mt-4">
    <div class="row">
            @include('frontend.dashboard.sidebar')
        {{-- MAIN CONTENT --}}
        <div class="col-lg-9 col-md-8">

            {{-- ==================== HERO SECTION ==================== --}}
            <section class="help-hero">
                <div class="hero-content">
                    <div class="hero-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h1 class="hero-title">{{ $lang['page_title'] }}</h1>
                    <p class="hero-subtitle">{{ $lang['page_subtitle'] }}</p>

                    {{-- Status Badge --}}
                    <div class="status-badge">
                        <span class="status-dot"></span>
                        <span class="status-text">{{ $lang['available_24_7'] }}</span>
                    </div>
                </div>

                {{-- Floating Elements --}}
                <div class="hero-decoration">
                    <div class="float-element float-1"></div>
                    <div class="float-element float-2"></div>
                    <div class="float-element float-3"></div>
                </div>
            </section>

            {{-- ==================== SUPPORT STATISTICS ==================== --}}
            <section class="support-stats">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">{{ $supportStats['response_time'] }}</h3>
                            <p class="stat-label">{{ $lang['minutes'] }}</p>
                            <span class="stat-description">{{ $lang['response_time'] }}</span>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-smile"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">{{ $supportStats['satisfied_rate'] }}</h3>
                            <p class="stat-label">{{ $lang['satisfied_customers'] }}</p>
                            <span class="stat-description">{{ $lang['support_team'] }}</span>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">{{ $supportStats['tickets_resolved'] }}</h3>
                            <p class="stat-label">{{ $lang['support_tickets'] }}</p>
                            <span class="stat-description">{{ $lang['quick_support'] }}</span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ==================== SUPPORT CHANNELS ==================== --}}
            <section class="support-channels">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-comments"></i>
                        {{ $lang['support_channels'] }}
                    </h2>
                </div>

                <div class="channels-grid">
                    @forelse ($supportcontact as $index => $contact)
                        <article class="support-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="card-inner">
                                {{-- Front Side --}}
                                <div class="card-front">
                                    <div class="card-header-section">
                                        <div class="card-badge">
                                            <span class="badge-text">{{ $lang['quick_support'] }}</span>
                                        </div>
                                    </div>

                                    <div class="card-image-wrapper">
                                        <div class="image-container">
                                            <img
                                                src="{{ asset('uploads/supports/' . $contact->photo) }}"
                                                alt="{{ $contact->title }}"
                                                class="support-image"
                                                loading="lazy"
                                                onerror="this.src='{{ asset('assets/images/placeholder.png') }}'">
                                            <div class="image-overlay"></div>
                                        </div>
                                    </div>

                                    <div class="card-body-section">
                                        <h3 class="card-title">{{ $contact->title }}</h3>

                                        @if(!empty($contact->description))
                                            <p class="card-description">{{ Str::limit($contact->description, 60) }}</p>
                                        @endif

                                        <div class="card-action">
                                            <a href="{{ $contact->support_link }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="support-link">
                                                <span>{{ $lang['reach_out'] }}</span>
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Status Indicator --}}
                                    <div class="status-indicator status-online">
                                        <span class="status-dot-small"></span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h3 class="empty-title">{{ $lang['contact_us'] }}</h3>
                            <p class="empty-text">{{ $lang['page_subtitle'] }}</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- ==================== QUICK HELP CTA ==================== --}}
            @if($supportcontact->isNotEmpty())
                <section class="quick-help-cta">
                    <div class="cta-content">
                        <div class="cta-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div class="cta-text">
                            <h3 class="cta-title">{{ $lang['get_help'] }}</h3>
                            <p class="cta-subtitle">{{ $lang['page_subtitle'] }}</p>
                        </div>
                        <div class="cta-action">
                            <a href="{{ $supportcontact->first()->support_link }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="cta-button">
                                <span>{{ $lang['contact_us'] }}</span>
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </section>
            @endif

        </div>
    </div>
</div>

{{-- ============================================
     STYLES
============================================ --}}
<style>
:root {
    --primary: {{ $primaryColor }};
    --secondary: {{ $secondaryColor }};
    --success: #28a745;
    --info: #17a2b8;
    --warning: #ffc107;
    --danger: #dc3545;
    --white: #ffffff;
    --light: #f8f9fa;
    --dark: #2c3e50;
    --muted: #6c757d;
    --border: #dee2e6;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
    --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
    --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.16);
    --shadow-xl: 0 12px 48px rgba(0, 0, 0, 0.2);
    --radius-sm: 8px;
    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-long: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ==================== HERO SECTION ==================== */
.help-hero {
    position: relative;
    background: linear-gradient(135deg,
        var(--primary) 0%,
        var(--secondary) 100%);
    border-radius: var(--radius-xl);
    padding: 48px 32px;
    margin-bottom: 32px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.hero-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 24px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--white);
    animation: float 3s ease-in-out infinite;
}

.hero-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    color: var(--white);
    margin: 0 0 12px;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.hero-subtitle {
    font-size: clamp(1rem, 2.5vw, 1.25rem);
    color: rgba(255, 255, 255, 0.95);
    margin: 0 0 24px;
    font-weight: 400;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    color: var(--white);
    font-weight: 600;
    font-size: 0.9rem;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.status-dot {
    width: 10px;
    height: 10px;
    background: #4ade80;
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
    box-shadow: 0 0 10px #4ade80;
}

.status-text {
    font-weight: 600;
}

/* Hero Decorations */
.hero-decoration {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.float-element {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.float-1 {
    width: 200px;
    height: 200px;
    top: -50px;
    right: -50px;
    animation: float 6s ease-in-out infinite;
}

.float-2 {
    width: 150px;
    height: 150px;
    bottom: -30px;
    left: -30px;
    animation: float 8s ease-in-out infinite reverse;
}

.float-3 {
    width: 100px;
    height: 100px;
    top: 50%;
    left: 10%;
    animation: float 10s ease-in-out infinite;
}

/* ==================== SUPPORT STATISTICS ==================== */
.support-stats {
    margin-bottom: 32px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.stat-item {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 24px;
    box-shadow: var(--shadow-sm);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all var(--transition);
    border: 2px solid transparent;
}

.stat-item:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: var(--white);
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--dark);
    margin: 0 0 4px;
    line-height: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: var(--muted);
    margin: 0 0 4px;
    font-weight: 500;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.stat-description {
    font-size: 0.75rem;
    color: var(--primary);
    font-weight: 600;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

/* ==================== SUPPORT CHANNELS ==================== */
.support-channels {
    margin-bottom: 32px;
}

.section-header {
    margin-bottom: 24px;
}

.section-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.section-title i {
    color: var(--primary);
}

.channels-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

/* ==================== SUPPORT CARD ==================== */
.support-card {
    position: relative;
    height: 100%;
    perspective: 1000px;
}

.card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform var(--transition-long);
    transform-style: preserve-3d;
}

.card-front {
    position: relative;
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    border: 2px solid var(--border);
    transition: all var(--transition);
    backface-visibility: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.support-card:hover .card-front {
    box-shadow: var(--shadow-lg);
    border-color: var(--primary);
    transform: translateY(-8px);
}

/* Card Header */
.card-header-section {
    padding: 16px 16px 0;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.card-badge {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: var(--white);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

/* Card Image */
.card-image-wrapper {
    padding: 16px;
    flex-shrink: 0;
}

.image-container {
    position: relative;
    width: 100%;
    height: 200px;
    border-radius: var(--radius);
    overflow: hidden;
    background: var(--light);
}

.support-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-long);
}

.support-card:hover .support-image {
    transform: scale(1.1);
}

.image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg,
        transparent 0%,
        rgba(0, 0, 0, 0.3) 100%);
    opacity: 0;
    transition: opacity var(--transition);
}

.support-card:hover .image-overlay {
    opacity: 1;
}

/* Card Body */
.card-body-section {
    padding: 0 20px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0 0 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: 56px;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.card-description {
    font-size: 0.9rem;
    color: var(--muted);
    margin: 0 0 16px;
    line-height: 1.5;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.card-action {
    margin-top: auto;
}

.support-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: var(--white);
    text-decoration: none;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 0.95rem;
    transition: all var(--transition);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    width: 100%;
    justify-content: center;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.support-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    color: var(--white);
}

.support-link i {
    transition: transform var(--transition);
}

.support-link:hover i {
    transform: translateX(4px);
}

/* Status Indicator */
.status-indicator {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-sm);
    z-index: 5;
}

.status-dot-small {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #4ade80;
    animation: pulse 2s ease-in-out infinite;
    box-shadow: 0 0 10px #4ade80;
}

.status-online .status-dot-small {
    background: #4ade80;
    box-shadow: 0 0 10px #4ade80;
}

.status-away .status-dot-small {
    background: var(--warning);
    box-shadow: 0 0 10px var(--warning);
}

.status-offline .status-dot-small {
    background: var(--muted);
    box-shadow: none;
}

/* ==================== QUICK HELP CTA ==================== */
.quick-help-cta {
    margin-top: 32px;
    margin-bottom: 24px;
}

.cta-content {
    background: linear-gradient(135deg,
        color-mix(in srgb, var(--primary) 10%, transparent) 0%,
        color-mix(in srgb, var(--secondary) 10%, transparent) 100%);
    border: 2px solid var(--primary);
    border-radius: var(--radius-xl);
    padding: 32px;
    display: flex;
    align-items: center;
    gap: 24px;
    box-shadow: var(--shadow-md);
}

.cta-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--white);
    flex-shrink: 0;
    animation: float 3s ease-in-out infinite;
}

.cta-text {
    flex: 1;
}

.cta-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0 0 8px;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.cta-subtitle {
    font-size: 1rem;
    color: var(--muted);
    margin: 0;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.cta-action {
    flex-shrink: 0;
}

.cta-button {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: var(--white);
    text-decoration: none;
    border-radius: var(--radius);
    font-weight: 700;
    font-size: 1rem;
    transition: all var(--transition);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.cta-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    color: var(--white);
}

.cta-button i {
    transition: transform var(--transition);
}

.cta-button:hover i {
    transform: translateX(4px);
}

/* ==================== EMPTY STATE ==================== */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 24px;
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.empty-icon {
    font-size: 4rem;
    color: var(--muted);
    margin-bottom: 24px;
    opacity: 0.5;
}

.empty-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0 0 12px;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.empty-text {
    font-size: 1.1rem;
    color: var(--muted);
    margin: 0;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

/* ==================== ANIMATIONS ==================== */
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
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

/* ==================== RESPONSIVE DESIGN ==================== */
@media (max-width: 992px) {
    .help-hero {
        padding: 40px 24px;
    }

    .hero-icon {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .channels-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }

    .cta-content {
        flex-direction: column;
        text-align: center;
        padding: 28px;
    }

    .cta-icon {
        width: 60px;
        height: 60px;
        font-size: 1.75rem;
    }
}

@media (max-width: 768px) {
    .help-hero {
        padding: 32px 20px;
        margin-bottom: 24px;
    }

    .hero-title {
        font-size: 1.75rem;
    }

    .hero-subtitle {
        font-size: 1rem;
    }

    .stat-item {
        padding: 20px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .stat-number {
        font-size: 1.5rem;
    }

    .section-title {
        font-size: 1.5rem;
    }

    .channels-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .card-title {
        font-size: 1.1rem;
        min-height: auto;
    }

    .image-container {
        height: 180px;
    }

    .cta-title {
        font-size: 1.25rem;
    }

    .cta-subtitle {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .help-hero {
        padding: 28px 16px;
    }

    .hero-icon {
        width: 60px;
        height: 60px;
        font-size: 1.75rem;
    }

    .status-badge {
        padding: 8px 16px;
        font-size: 0.85rem;
    }

    .stat-item {
        flex-direction: column;
        text-align: center;
        padding: 20px 16px;
    }

    .card-body-section {
        padding: 0 16px 16px;
    }

    .support-link {
        padding: 10px 20px;
        font-size: 0.9rem;
    }

    .cta-content {
        padding: 24px 20px;
        gap: 20px;
    }

    .cta-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .cta-button {
        padding: 12px 24px;
        font-size: 0.95rem;
    }
}

/* ==================== PRINT STYLES ==================== */
@media print {
    .help-hero,
    .support-card,
    .quick-help-cta {
        box-shadow: none;
        page-break-inside: avoid;
    }

    .hero-decoration,
    .float-element {
        display: none;
    }

    .support-link,
    .cta-button {
        color: var(--primary) !important;
        text-decoration: underline;
    }
}

/* ==================== ACCESSIBILITY ==================== */
.support-link:focus,
.cta-button:focus {
    outline: 3px solid var(--primary);
    outline-offset: 2px;
}

.support-card:focus-within {
    outline: 2px solid var(--primary);
    outline-offset: 4px;
}

/* ==================== LOADING SKELETON (Optional) ==================== */
@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.skeleton {
    background: linear-gradient(90deg,
        var(--light) 25%,
        #e0e0e0 50%,
        var(--light) 75%);
    background-size: 1000px 100%;
    animation: shimmer 2s infinite;
}
</style>

{{-- ============================================
     JAVASCRIPT
============================================ --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // ============================================
    // INTERSECTION OBSERVER FOR ANIMATIONS
    // ============================================
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

    // Observe all support cards
    document.querySelectorAll('.support-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // ============================================
    // STAT COUNTER ANIMATION
    // ============================================
    function animateValue(element, start, end, duration) {
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= end) {
                element.textContent = end;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 16);
    }

    // Animate stat numbers on scroll
    const statObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const number = entry.target.querySelector('.stat-number');
                if (number && !number.dataset.animated) {
                    const value = parseInt(number.textContent) || 0;
                    number.dataset.animated = 'true';
                    number.textContent = '0';
                    animateValue(number, 0, value, 1500);
                }
                statObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.stat-item').forEach(stat => {
        statObserver.observe(stat);
    });

    // ============================================
    // IMAGE ERROR HANDLING
    // ============================================
    document.querySelectorAll('.support-image').forEach(img => {
        img.addEventListener('error', function() {
            this.src = '{{ asset("assets/images/placeholder.png") }}';
            this.alt = 'Support Channel';
        });
    });

    // ============================================
    // CARD HOVER EFFECT ENHANCEMENT
    // ============================================
    document.querySelectorAll('.support-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // ============================================
    // SMOOTH SCROLL FOR INTERNAL LINKS
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // ============================================
    // DYNAMIC STATUS INDICATOR (Optional)
    // ============================================
    function updateStatusIndicators() {
        const now = new Date();
        const hour = now.getHours();

        document.querySelectorAll('.status-indicator').forEach(indicator => {
            // Example: Show online 8 AM - 10 PM
            if (hour >= 8 && hour < 22) {
                indicator.classList.remove('status-away', 'status-offline');
                indicator.classList.add('status-online');
            } else if (hour >= 22 || hour < 2) {
                indicator.classList.remove('status-online', 'status-away');
                indicator.classList.add('status-offline');
            } else {
                indicator.classList.remove('status-online', 'status-offline');
                indicator.classList.add('status-away');
            }
        });
    }

    // Update status on load
    updateStatusIndicators();

    // Optional: Update every minute
    setInterval(updateStatusIndicators, 60000);

    // ============================================
    // TRACK LINK CLICKS (Analytics)
    // ============================================
    document.querySelectorAll('.support-link, .cta-button').forEach(link => {
        link.addEventListener('click', function(e) {
            const channelName = this.closest('.support-card')?.querySelector('.card-title')?.textContent || 'Quick Help CTA';
            console.log('Support channel clicked:', channelName);

            // Send to analytics if available
            if (typeof gtag !== 'undefined') {
                gtag('event', 'support_channel_click', {
                    'channel_name': channelName,
                    'link_url': this.href
                });
            }
        });
    });

    // ============================================
    // LAZY LOADING IMAGES
    // ============================================
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // ============================================
    // KEYBOARD NAVIGATION
    // ============================================
    document.addEventListener('keydown', function(e) {
        // Tab through cards
        if (e.key === 'Tab') {
            const cards = Array.from(document.querySelectorAll('.support-card'));
            const activeElement = document.activeElement;
            const currentIndex = cards.findIndex(card =>
                card.contains(activeElement)
            );

            if (currentIndex !== -1) {
                e.preventDefault();
                const nextIndex = e.shiftKey
                    ? (currentIndex - 1 + cards.length) % cards.length
                    : (currentIndex + 1) % cards.length;

                const nextCard = cards[nextIndex];
                const nextLink = nextCard.querySelector('.support-link');
                if (nextLink) {
                    nextLink.focus();
                }
            }
        }
    });

    // ============================================
    // PERFORMANCE MONITORING
    // ============================================
    if ('PerformanceObserver' in window) {
        const perfObserver = new PerformanceObserver((list) => {
            for (const entry of list.getEntries()) {
                if (entry.entryType === 'largest-contentful-paint') {
                    console.log('LCP:', entry.renderTime || entry.loadTime);
                }
            }
        });

        try {
            perfObserver.observe({ entryTypes: ['largest-contentful-paint'] });
        } catch (e) {
            // LCP not supported
        }
    }

    // ============================================
    // CONSOLE MESSAGE
    // ============================================
    console.log('%c🎯 Support Page Ready!', 'color: {{ $primaryColor }}; font-size: 16px; font-weight: bold;');
    console.log('%cSupport Channels: {{ $supportcontact->count() }}', 'color: #28a745;');
});

// ============================================
// PAGE VISIBILITY API (Pause animations when tab not visible)
// ============================================
document.addEventListener('visibilitychange', function() {
    const cards = document.querySelectorAll('.support-card');
    const animations = document.querySelectorAll('.hero-icon, .float-element');

    if (document.hidden) {
        cards.forEach(card => card.style.animationPlayState = 'paused');
        animations.forEach(el => el.style.animationPlayState = 'paused');
    } else {
        cards.forEach(card => card.style.animationPlayState = 'running');
        animations.forEach(el => el.style.animationPlayState = 'running');
    }
});
</script>

@endsection
