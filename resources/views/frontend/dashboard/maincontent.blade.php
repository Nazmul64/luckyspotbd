@php
    use Carbon\Carbon;

    // ============================================
    // CONFIGURATION & SETUP
    // ============================================

    // Fetch active theme colors from database
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#F5CE0D';
    $secondaryColor = $activeTheme->secondary_color ?? '#000000';

    // Set timezone to Bangladesh Standard Time (BST = UTC+6)
    date_default_timezone_set('Asia/Dhaka');

    // Get current locale for translations
    $currentLocale = app()->getLocale();

    // Get current server time in Bangladesh timezone
    $serverNow = Carbon::now('Asia/Dhaka');
    $serverTimestamp = $serverNow->timestamp * 1000; // JavaScript timestamp
@endphp

    <style>
        /* ====================================
           GLOBAL STYLES & VARIABLES
        ==================================== */
        :root {
            --primary-color: {{ $primaryColor }};
            --secondary-color: {{ $secondaryColor }};
            --primary-rgb: {{ hexToRgb($primaryColor) }};
            --secondary-rgb: {{ hexToRgb($secondaryColor) }};
            --transition-speed: 0.3s;
            --border-radius-sm: 8px;
            --border-radius-md: 12px;
            --border-radius-lg: 15px;
            --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.2);
            --shadow-lg: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        /* ====================================
           GRADIENT SHADOW EFFECTS
        ==================================== */
        .gradient-shadow {
            position: relative;
        }

        .gradient-shadow::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
            border-radius: inherit;
            z-index: -1;
            opacity: 0.8;
            transition: all var(--transition-speed) ease;
        }

        .gradient-shadow-sm::before {
            box-shadow: 0 6px 20px rgba(51, 8, 103, 0.25),
                        0 3px 10px rgba(48, 207, 208, 0.15);
        }

        .gradient-shadow-md::before {
            box-shadow: 0 8px 30px rgba(51, 8, 103, 0.3),
                        0 4px 15px rgba(48, 207, 208, 0.2),
                        inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .gradient-shadow-lg::before {
            box-shadow: 0 12px 40px rgba(51, 8, 103, 0.35),
                        0 6px 20px rgba(48, 207, 208, 0.25),
                        inset 0 2px 0 rgba(255, 255, 255, 0.15);
        }

        .gradient-shadow:hover::before {
            transform: translateY(-3px);
            box-shadow: 0 16px 50px rgba(51, 8, 103, 0.45),
                        0 8px 25px rgba(48, 207, 208, 0.35);
        }

        /* ====================================
           ANIMATIONS
        ==================================== */
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .blink-icon {
            animation: blink 1s ease-in-out infinite;
        }

        .pulse-icon {
            animation: pulse 2s ease-in-out infinite;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* ====================================
           COMPONENT STYLES
        ==================================== */

        /* User Toggler */
        .user-toggler-wrapper {
            background: linear-gradient(135deg,
                        rgba(var(--primary-rgb), 0.1) 0%,
                        rgba(var(--primary-rgb), 0.2) 100%);
            padding: 15px;
            border-radius: var(--border-radius-sm);
            margin-bottom: 20px;
            border: 2px solid var(--primary-color);
        }

        .user-toggler {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 10px 15px;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .user-toggler:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: linear-gradient(135deg,
                        rgba(var(--primary-rgb), 0.15) 0%,
                        rgba(var(--primary-rgb), 0.25) 100%);
            border: 2px solid var(--primary-color);
            border-radius: var(--border-radius-md);
            padding: 25px;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .dashboard-card-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3em;
            color: var(--primary-color);
            opacity: 0.3;
        }

        /* Game Cards */
        .game-card {
            background: linear-gradient(135deg,
                        rgba(var(--primary-rgb), 0.1) 0%,
                        rgba(var(--secondary-rgb), 0.1) 100%);
            border: 2px solid var(--primary-color);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            transition: all var(--transition-speed) ease;
            position: relative;
        }

        .game-card:hover {
            transform: translateY(-8px);
        }

        .game-card-image {
            width: 100%;
            height: auto;
            display: block;
            border-radius: var(--border-radius-md);
            border: 3px solid var(--primary-color);
            box-shadow: var(--shadow-sm);
        }

        /* Buttons */
        .btn-primary-custom {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            padding: 15px 30px;
            border-radius: var(--border-radius-sm);
            width: 100%;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary-custom:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }

        /* Prize Information Box */
        .prize-info-box {
            background-color: rgba(var(--secondary-rgb), 0.05);
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            border-radius: var(--border-radius-sm);
            margin: 15px 0;
        }

        /* Video Container */
        .video-container {
            border-radius: var(--border-radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 3px solid var(--primary-color);
            margin-bottom: 15px;
        }

        .video-responsive {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            background: #000;
        }

        .video-responsive iframe,
        .video-responsive video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Video Coming Soon Box */
        .video-coming-soon {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 30px;
            border-radius: var(--border-radius-md);
            text-align: center;
            box-shadow: var(--shadow-md);
        }

        /* Transaction Table */
        .transaction-table-container {
            background: linear-gradient(135deg,
                        rgba(var(--primary-rgb), 0.05) 0%,
                        rgba(var(--secondary-rgb), 0.05) 100%);
            border-radius: var(--border-radius-lg);
            padding: 25px;
            border: 2px solid var(--primary-color);
        }

        .transaction-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .transaction-table thead th {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 15px;
            text-align: left;
            font-weight: bold;
        }

        .transaction-table thead th:first-child {
            border-radius: var(--border-radius-sm) 0 0 var(--border-radius-sm);
        }

        .transaction-table thead th:last-child {
            border-radius: 0 var(--border-radius-sm) var(--border-radius-sm) 0;
        }

        .transaction-table tbody tr {
            background-color: rgba(var(--secondary-rgb), 0.03);
            transition: all var(--transition-speed) ease;
        }

        .transaction-table tbody tr:hover {
            background-color: rgba(var(--primary-rgb), 0.1);
            transform: scale(1.01);
        }

        .transaction-table tbody td {
            padding: 15px;
            color: var(--secondary-color);
        }

        .transaction-table tbody td:first-child {
            border-left: 3px solid var(--primary-color);
            font-weight: 600;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            display: inline-block;
        }

        .status-approved {
            background-color: #28a745;
            color: white;
        }

        .status-pending {
            background-color: #ffc107;
            color: var(--secondary-color);
        }

        .status-rejected {
            background-color: #dc3545;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-card {
                padding: 20px;
            }

            .game-card {
                margin-bottom: 20px;
            }

            .transaction-table-container {
                overflow-x: auto;
            }
        }

        /* Utility Classes */
        .text-primary { color: var(--primary-color) !important; }
        .text-secondary { color: var(--secondary-color) !important; }
        .bg-primary { background-color: var(--primary-color) !important; }
        .bg-secondary { background-color: var(--secondary-color) !important; }
    </style>
</head>
<body>

<!-- ====================================
     USER TOGGLER (Mobile Only)
==================================== -->
<div class="gradient-shadow gradient-shadow-sm" style="border-radius: var(--border-radius-sm);">
    <div class="user-toggler-wrapper d-flex align-items-center d-lg-none">
        <h4 class="title m-0 text-secondary" style="flex: 1;">
            {{ trans_db('User Dashboard', 'User Dashboard') }}
        </h4>
        <div class="user-toggler">
            <i class="las la-sliders-h"></i>
        </div>
    </div>
</div>

<!-- ====================================
     DASHBOARD STATISTICS CARDS
==================================== -->
<div class="row justify-content-center g-4">

    <!-- Total Deposit Card -->
    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
        <div class="gradient-shadow gradient-shadow-md fade-in" style="border-radius: var(--border-radius-md); margin-bottom: 20px;">
            <div class="dashboard-card">
                <div style="position: relative; z-index: 2;">
                    <h2 class="text-secondary" style="font-size: 2em; font-weight: bold; margin-bottom: 10px;">
                        {{ number_format(round($total_deposite ?? 0)) }} {{ trans_db('টাকা','টাকা') }}
                    </h2>
                    <p class="text-secondary" style="opacity: 0.8; font-size: 1.1em; margin: 0;">
                        {{ trans_db('Total Deposit','Total Deposit') }}
                    </p>
                </div>
                <div class="dashboard-card-icon">
                    <i class="las la-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Balance Card -->
    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
        <div class="gradient-shadow gradient-shadow-md fade-in" style="border-radius: var(--border-radius-md); margin-bottom: 20px; animation-delay: 0.1s;">
            <div class="dashboard-card">
                <div style="position: relative; z-index: 2;">
                    <h2 class="text-secondary" style="font-size: 2em; font-weight: bold; margin-bottom: 10px;">
                        {{ number_format(round($total_balance ?? 0)) }} {{ trans_db('টাকা','টাকা') }}
                    </h2>
                    <p class="text-secondary" style="opacity: 0.8; font-size: 1.1em; margin: 0;">
                        {{ trans_db('Total Balance','Total Balance') }}
                    </p>
                </div>
                <div class="dashboard-card-icon">
                    <i class="las la-coins"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Withdraw Card -->
    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
        <div class="gradient-shadow gradient-shadow-md fade-in" style="border-radius: var(--border-radius-md); margin-bottom: 20px; animation-delay: 0.2s;">
            <div class="dashboard-card">
                <div style="position: relative; z-index: 2;">
                    <h2 class="text-secondary" style="font-size: 2em; font-weight: bold; margin-bottom: 10px;">
                        {{ number_format(round($total_withdraw ?? 0)) }} {{ trans_db('টাকা','টাকা') }}
                    </h2>
                    <p class="text-secondary" style="opacity: 0.8; font-size: 1.1em; margin: 0;">
                        {{ trans_db('Total Withdraw','Total Withdraw') }}
                    </p>
                </div>
                <div class="dashboard-card-icon">
                    <i class="las la-hand-holding-usd"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ====================================
     LOTTERY PACKAGES SECTION
==================================== -->
<div class="row gy-4 justify-content-center pt-5">
    @forelse($package_show as $index => $package)
        @php
            // Calculate times in Bangladesh timezone
            $drawDate = $package->draw_date
                ? Carbon::parse($package->draw_date, 'UTC')->setTimezone('Asia/Dhaka')
                : null;
            $drawTimestamp = $drawDate ? $drawDate->timestamp * 1000 : 0;

            $videoScheduledAt = $package->video_scheduled_at
                ? Carbon::parse($package->video_scheduled_at, 'UTC')->setTimezone('Asia/Dhaka')
                : null;
            $videoTimestamp = $videoScheduledAt ? $videoScheduledAt->timestamp * 1000 : 0;

            // Determine if video should be shown
            $shouldShowVideo = false;
            if ($package->video_enabled && $package->video_url && $videoScheduledAt) {
                $shouldShowVideo = $serverNow->gte($videoScheduledAt);
            }

            // Prepare video embed URL
            $embedUrl = '';
            $isYouTube = false;
            if ($package->video_url) {
                $videoUrl = trim($package->video_url);
                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                    $videoId = $matches[1];
                    $embedUrl = "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=0&rel=0&modestbranding=1&controls=1";
                    $isYouTube = true;
                } else {
                    $embedUrl = $videoUrl;
                }
            }

            // Get translated content
            $lotteryName = $package->getTranslatedName();
            $lotteryDescription = $package->getTranslatedDescription();

            // Animation delay for staggered effect
            $animationDelay = $index * 0.1;
        @endphp

        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6">
            <div class="gradient-shadow gradient-shadow-lg fade-in" style="border-radius: var(--border-radius-lg); margin-bottom: 25px; animation-delay: {{ $animationDelay }}s;">
                <div class="game-card">
                    <div style="padding: 20px;">

                        @auth
                            {{-- AUTHENTICATED USER VIEW --}}
                            <form method="POST" action="{{ route('buy.package', $package->id) }}">
                                @csrf

                                <!-- Lottery Image -->
                                <div style="margin-bottom: 20px;">
                                    <img src="{{ asset('uploads/Lottery/' . ($package->photo ?? 'default.png')) }}"
                                         alt="{{ $lotteryName }}"
                                         class="game-card-image"
                                         onerror="this.src='{{ asset('uploads/lottery/default.png') }}'">
                                </div>

                                <!-- Lottery Title & Description -->
                                <h4 class="text-secondary" style="font-size: 1.5em; font-weight: bold; margin-bottom: 10px;">
                                    {{ $lotteryName ?: trans_db('N/A', 'N/A') }}
                                </h4>

                                @if($lotteryDescription)
                                    <p class="text-secondary" style="opacity: 0.8; margin-bottom: 15px; font-size: 0.95em;">
                                        {{ Str::limit($lotteryDescription, 100) }}
                                    </p>
                                @endif

                                <!-- Win Type Badge -->
                                <p style="background-color: var(--primary-color); color: var(--secondary-color); display: inline-block; padding: 5px 15px; border-radius: 20px; font-size: 0.9em; font-weight: 600; margin-bottom: 10px;">
                                    {{ ucfirst($package->win_type ?? trans_db('N/A', 'N/A')) }}
                                </p>

                                <!-- Price -->
                                <p class="text-primary" style="font-size: 1.8em; font-weight: bold; margin-bottom: 15px;">
                                    {{ number_format($package->price ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}
                                </p>

                                <!-- Draw Date -->
                                <p class="text-secondary" style="margin-bottom: 15px; font-size: 0.95em;">
                                    <i class="fas fa-calendar-alt text-primary"></i>
                                    <span style="font-weight: 600;">{{ trans_db('Draw Date', 'Draw Date') }}:</span>
                                    {{ $drawDate ? $drawDate->format('d M, Y h:i A') : trans_db('Not Set', 'Not Set') }}
                                </p>

                                <!-- Prize Information -->
                                <div class="prize-info-box">
                                    <p class="text-secondary" style="margin-bottom: 8px; font-size: 0.95em;">
                                        <i class="fas fa-trophy text-primary"></i>
                                        <span style="font-weight: 600;">{{ trans_db('1st Prize', '1st Prize') }}:</span>
                                        {{ number_format($package->first_prize ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}
                                    </p>
                                    <p class="text-secondary" style="margin-bottom: 8px; font-size: 0.95em;">
                                        <i class="fas fa-medal text-primary"></i>
                                        <span style="font-weight: 600;">{{ trans_db('2nd Prize', '2nd Prize') }}:</span>
                                        {{ number_format($package->second_prize ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}
                                    </p>
                                    <p class="text-secondary" style="margin-bottom: 0; font-size: 0.95em;">
                                        <i class="fas fa-award text-primary"></i>
                                        <span style="font-weight: 600;">{{ trans_db('3rd Prize', '3rd Prize') }}:</span>
                                        {{ number_format($package->third_prize ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}
                                    </p>
                                </div>

                                <!-- Total Participants -->
                                <div style="background-color: rgba(var(--primary-rgb), 0.1); padding: 12px; border-radius: var(--border-radius-sm); margin-bottom: 15px;">
                                    <p class="text-secondary" style="margin-bottom: 0; font-size: 0.95em;">
                                        <i class="fas fa-users text-primary"></i>
                                        <span style="font-weight: 600;">{{ trans_db('Total Participants', 'Total Participants') }}:</span>
                                        {{ $total_buyer }}
                                    </p>
                                </div>

                                <!-- Multiple Packages/Gifts -->
                                @if(is_array($package->multiple_title) && count($package->multiple_title) > 0)
                                    <div style="background: linear-gradient(135deg, rgba(var(--primary-rgb), 0.1) 0%, rgba(var(--secondary-rgb), 0.05) 100%); padding: 15px; border-radius: var(--border-radius-sm); margin-top: 15px; border: 1px solid var(--primary-color);">
                                        <h6 class="text-secondary" style="margin-bottom: 12px; font-weight: bold; font-size: 1.1em;">
                                            <i class="fas fa-box-open text-primary"></i>
                                            {{ trans_db('Best Gift', 'Best Gift') }}:
                                        </h6>
                                        <ul style="list-style: none; padding: 0; margin: 0;">
                                            @foreach($package->multiple_title as $idx => $title)
                                                @if($title)
                                                    <li class="text-secondary" style="margin-bottom: 8px; padding-left: 25px; position: relative; font-size: 0.9em;">
                                                        <i class="fas fa-check-circle text-primary" style="position: absolute; left: 0; top: 2px;"></i>
                                                        <strong>{{ $title }}</strong> - {{ number_format($package->multiple_price[$idx] ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Video Section -->
                                @if($package->video_enabled && $embedUrl)
                                    <div class="video-section" style="margin-top: 20px;"
                                         id="video-section-{{ $package->id }}"
                                         data-package-id="{{ $package->id }}"
                                         data-should-show="{{ $shouldShowVideo ? 'true' : 'false' }}"
                                         data-video-time="{{ $videoTimestamp }}"
                                         data-server-time="{{ $serverTimestamp }}"
                                         data-embed-url="{{ $embedUrl }}">

                                        @if($shouldShowVideo)
                                            <!-- LIVE Video Display -->
                                            <div class="video-container">
                                                @if($isYouTube)
                                                    <div class="video-responsive">
                                                        <iframe src="{{ $embedUrl }}"
                                                                title="Lottery Live Draw"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                                allowfullscreen>
                                                        </iframe>
                                                    </div>
                                                @else
                                                    <video controls autoplay playsinline
                                                           style="width: 100%; border-radius: var(--border-radius-md); background: #000;"
                                                           poster="{{ asset('uploads/Lottery/' . ($package->photo ?? 'default.png')) }}">
                                                        <source src="{{ $package->video_url }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                            </div>
                                            <p class="text-primary" style="margin-top: 10px; font-weight: bold; font-size: 1.1em; text-align: center;">
                                                <i class="fas fa-circle blink-icon" style="color: #ff0000;"></i>
                                                {{ trans_db('LIVE NOW', 'LIVE NOW') }}
                                            </p>
                                        @else
                                            <!-- Video Coming Soon -->
                                            <div class="video-coming-soon">
                                                <i class="fas fa-video pulse-icon" style="font-size: 3.5em; color: white; margin-bottom: 20px; display: block;"></i>
                                                <h5 style="color: white; margin-bottom: 15px; font-size: 1.3em; font-weight: bold;">
                                                    <i class="fas fa-broadcast-tower"></i>
                                                    {{ trans_db('Live Draw Coming Soon', 'Live Draw Coming Soon!') }}
                                                </h5>
                                                @if($videoTimestamp > 0)
                                                    <p class="video-countdown"
                                                       data-video-time="{{ $videoTimestamp }}"
                                                       data-server-time="{{ $serverTimestamp }}"
                                                       data-package-id="{{ $package->id }}"
                                                       style="color: white; font-size: 1.2em; font-weight: bold; margin-bottom: 15px;">
                                                       <i class="fas fa-clock"></i> {{ trans_db('Calculating', 'Calculating...') }}
                                                    </p>
                                                @endif
                                                <p style="color: white; font-size: 0.95em; opacity: 0.95; margin-bottom: 0;">
                                                    <i class="fas fa-calendar-check"></i>
                                                    {{ trans_db('Video Start', 'Video Start') }}:
                                                    {{ $videoScheduledAt ? $videoScheduledAt->format('d M, Y h:i A') : trans_db('Not Set', 'Not Set') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <!-- Buy Ticket Button -->
                                <div class="gradient-shadow gradient-shadow-sm" style="margin-top: 20px; border-radius: var(--border-radius-sm);">
                                    <button type="submit" class="btn-primary-custom">
                                        <i class="fas fa-ticket-alt"></i> {{ trans_db('Buy Ticket', 'Buy Ticket') }}
                                    </button>
                                </div>

                            </form>

                        @else
                            {{-- GUEST USER VIEW --}}
                            <div style="margin-bottom: 20px;">
                                <img src="{{ asset('uploads/Lottery/' . ($package->photo ?? 'default.png')) }}"
                                     alt="{{ $lotteryName }}"
                                     class="game-card-image">
                            </div>

                            <h4 class="text-secondary" style="font-size: 1.5em; font-weight: bold; margin-bottom: 15px;">
                                {{ $lotteryName ?: trans_db('N/A', 'N/A') }}
                            </h4>

                            @if($lotteryDescription)
                                <p class="text-secondary" style="opacity: 0.8; margin-bottom: 15px; font-size: 0.95em;">
                                    {{ Str::limit($lotteryDescription, 100) }}
                                </p>
                            @endif

                            <!-- Show Video if LIVE for Guest Users -->
                            @if($package->video_enabled && $embedUrl && $shouldShowVideo)
                                <div class="video-container" style="margin-top: 20px; margin-bottom: 20px;">
                                    @if($isYouTube)
                                        <div class="video-responsive">
                                            <iframe src="{{ $embedUrl }}"
                                                    allowfullscreen>
                                            </iframe>
                                        </div>
                                    @else
                                        <video controls autoplay src="{{ $package->video_url }}" style="width: 100%;"></video>
                                    @endif
                                </div>
                            @endif

                            <!-- Login to Play Button -->
                            <div class="gradient-shadow gradient-shadow-sm" style="margin-top: 20px; border-radius: var(--border-radius-sm);">
                                <a href="{{ route('frontend.login') }}" class="btn-primary-custom">
                                    <i class="fas fa-sign-in-alt"></i> {{ trans_db('Login to Play', 'Login to Play') }}
                                </a>
                            </div>
                        @endauth

                    </div>

                    <!-- Decorative Circle -->
                    <div style="position: absolute; width: 60px; height: 60px; background-color: var(--primary-color); opacity: 0.1; border-radius: 50%; bottom: -30px; right: -30px;"></div>
                </div>
            </div>
        </div>

    @empty
        <!-- No Packages Available -->
        <div class="col-12">
            <div class="fade-in" style="text-align: center; padding: 50px; background-color: {{ $primaryColor }}15; border-radius: var(--border-radius-lg); border: 2px dashed {{ $primaryColor }};">
                <i class="fas fa-inbox" style="font-size: 64px; color: {{ $primaryColor }}; opacity: 0.5; margin-bottom: 20px; display: block;"></i>
                <h4 style="color: {{ $secondaryColor }}; margin-top: 20px; font-size: 1.3em;">
                    {{ trans_db('No lottery packages available', 'No lottery packages available') }}
                </h4>
                <p style="color: {{ $secondaryColor }}; opacity: 0.7; margin-top: 10px;">
                    {{ trans_db('Please check back later for new lottery packages', 'Please check back later for new lottery packages') }}
                </p>
            </div>
        </div>
    @endforelse
</div>

<!-- ====================================
     TRANSACTION HISTORY
==================================== -->
<div class="mt-5">
    <div class="gradient-shadow gradient-shadow-md fade-in" style="border-radius: var(--border-radius-lg);">
        <div class="transaction-table-container">
            <h3 class="text-secondary" style="margin-bottom: 25px; font-weight: bold; padding-bottom: 15px; border-bottom: 3px solid var(--primary-color);">
                <i class="fas fa-history text-primary"></i>
                {{ trans_db('Transaction History', 'Transaction History') }}
            </h3>

            <div style="overflow-x: auto;">
                <table class="transaction-table">
                    <thead>
                        <tr>
                            <th>{{ trans_db('Transaction ID', 'Transaction ID') }}</th>
                            <th>{{ trans_db('Type', 'Type') }}</th>
                            <th>{{ trans_db('Date', 'Date') }}</th>
                            <th>{{ trans_db('Amount', 'Amount') }}</th>
                            <th>{{ trans_db('Status', 'Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deposite_history as $deposit)
                            <tr>
                                <td>{{ $deposit->transaction_id ?? '#' . $deposit->id }}</td>
                                <td>
                                    <span style="background-color: {{ $deposit->amount > 0 ? 'var(--primary-color)' : 'rgba(var(--secondary-rgb), 0.2)' }}; padding: 5px 12px; border-radius: 15px; font-size: 0.9em; font-weight: 600;">
                                        {{ $deposit->amount > 0 ? trans_db('Deposit', 'Deposit') : trans_db('Withdraw', 'Withdraw') }}
                                    </span>
                                </td>
                                <td>{{ $deposit->created_at ? $deposit->created_at->format('d M, Y h:i A') : trans_db('N/A', 'N/A') }}</td>
                                <td class="text-primary" style="font-weight: bold; font-size: 1.1em;">
                                    {{ number_format($deposit->amount, 2) }} {{ trans_db('টাকা','টাকা') }}
                                </td>
                                <td>
                                    @if($deposit->status == 'approved')
                                        <span class="status-badge status-approved">
                                            <i class="fas fa-check-circle"></i> {{ trans_db('Approved', 'Approved') }}
                                        </span>
                                    @elseif($deposit->status == 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock"></i> {{ trans_db('Pending', 'Pending') }}
                                        </span>
                                    @else
                                        <span class="status-badge status-rejected">
                                            <i class="fas fa-times-circle"></i> {{ trans_db('Rejected', 'Rejected') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: var(--secondary-color); font-size: 1.1em;">
                                    <i class="fas fa-inbox" style="font-size: 3em; color: var(--primary-color); opacity: 0.3; display: block; margin-bottom: 15px;"></i>
                                    {{ trans_db('No transaction history found', 'No transaction history found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ====================================
     JAVASCRIPT - TIMER & INTERACTIONS
==================================== -->
<script>
(function() {
    'use strict';

    // ============================================
    // CONFIGURATION
    // ============================================
    const CONFIG = {
        DEBUG: true,
        TIMEZONE: 'Asia/Dhaka',
        LOCALE: '{{ $currentLocale }}',
        COLORS: {
            primary: '{{ $primaryColor }}',
            secondary: '{{ $secondaryColor }}'
        },
        INTERVALS: {
            countdown: 1000,        // 1 second
            videoCheck: 1000        // 1 second
        },
        RELOAD_THRESHOLD: 3000,     // 3 seconds before video time
        RELOAD_COOLDOWN: 30000      // 30 seconds cooldown
    };

    // ============================================
    // UTILITIES
    // ============================================
    const Utils = {
        log: function(message, data = null) {
            if (CONFIG.DEBUG) {
                const timestamp = new Date().toLocaleTimeString('en-US', {
                    timeZone: CONFIG.TIMEZONE,
                    hour12: false
                });
                console.log(`[${timestamp}] 🎰 Lottery:`, message, data || '');
            }
        },

        formatTime: function(milliseconds) {
            if (milliseconds <= 0) return { days: 0, hours: 0, minutes: 0, seconds: 0 };

            const seconds = Math.floor(milliseconds / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            return {
                days: days,
                hours: hours % 24,
                minutes: minutes % 60,
                seconds: seconds % 60
            };
        },

        getTranslation: function(key) {
            const translations = {
                'en': {
                    'LIVE': 'LIVE NOW',
                    'Calculating': 'Calculating...',
                    'Video is LIVE': 'Video is LIVE!'
                },
                'bn': {
                    'LIVE': 'লাইভ চলছে',
                    'Calculating': 'গণনা করা হচ্ছে...',
                    'Video is LIVE': 'ভিডিও লাইভ!'
                }
            };
            return translations[CONFIG.LOCALE]?.[key] || key;
        }
    };

    // ============================================
    // TIME SYNCHRONIZATION
    // ============================================
    const TimeSync = {
        offset: 0,
        initialized: false,

        init: function() {
            const firstTimer = document.querySelector('[data-server-time]');
            if (!firstTimer) {
                Utils.log('⚠️ No server time found, using browser time');
                this.initialized = true;
                return;
            }

            const serverTime = parseInt(firstTimer.getAttribute('data-server-time'), 10);
            const browserTime = Date.now();
            this.offset = serverTime - browserTime;
            this.initialized = true;

            Utils.log('✅ Time Sync Initialized', {
                server_time: new Date(serverTime).toLocaleString('en-US', { timeZone: CONFIG.TIMEZONE }),
                browser_time: new Date(browserTime).toLocaleString('en-US', { timeZone: CONFIG.TIMEZONE }),
                offset_ms: this.offset,
                offset_seconds: Math.round(this.offset / 1000)
            });
        },

        getServerTime: function() {
            return Date.now() + this.offset;
        }
    };

    // ============================================
    // VIDEO COUNTDOWN MANAGER
    // ============================================
    const VideoCountdown = {
        countdowns: [],

        init: function() {
            this.countdowns = Array.from(document.querySelectorAll('.video-countdown'));
            Utils.log(`Found ${this.countdowns.length} video countdowns`);
        },

        update: function() {
            this.countdowns.forEach(countdown => {
                const videoTime = parseInt(countdown.getAttribute('data-video-time'), 10);
                const packageId = countdown.getAttribute('data-package-id');

                if (!videoTime || isNaN(videoTime) || videoTime <= 0) {
                    countdown.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Video time not set';
                    countdown.style.color = '#dc3545';
                    return;
                }

                const now = TimeSync.getServerTime();
                const diff = videoTime - now;

                if (diff <= 0) {
                    countdown.innerHTML = `<i class="fas fa-circle blink-icon" style="color: #ff0000;"></i> ${Utils.getTranslation('Video is LIVE')}`;
                    countdown.style.color = '#00ff00';
                    return;
                }

                const time = Utils.formatTime(diff);
                countdown.innerHTML = `<i class="fas fa-clock"></i> ${time.days}d ${time.hours}h ${time.minutes}m ${time.seconds}s`;
            });
        }
    };

    // ============================================
    // VIDEO AUTO-RELOAD MANAGER
    // ============================================
    const VideoAutoReload = {
        storageKey: 'lottery_video_reload_triggered',

        check: function() {
            const videoSections = document.querySelectorAll('.video-section');
            let needsReload = false;

            videoSections.forEach(section => {
                const shouldShow = section.getAttribute('data-should-show');
                const videoTime = parseInt(section.getAttribute('data-video-time'), 10);
                const packageId = section.getAttribute('data-package-id');

                if (shouldShow === 'false' && videoTime && !isNaN(videoTime) && videoTime > 0) {
                    const now = TimeSync.getServerTime();
                    const diff = videoTime - now;

                    // Check if we're within threshold
                    if (diff <= CONFIG.RELOAD_THRESHOLD && diff > -1000) {
                        Utils.log(`🎬 Package ${packageId}: Video time reached!`);
                        needsReload = true;
                    }
                }
            });

            if (needsReload) {
                this.performReload();
            }
        },

        performReload: function() {
            const lastReload = sessionStorage.getItem(this.storageKey);
            const now = Date.now();

            // Check cooldown
            if (lastReload && (now - parseInt(lastReload)) < CONFIG.RELOAD_COOLDOWN) {
                Utils.log('⏳ Reload on cooldown, skipping...');
                return;
            }

            sessionStorage.setItem(this.storageKey, now.toString());
            Utils.log('🔄 Reloading page to show video...');

            setTimeout(() => {
                window.location.reload(true);
            }, 1000);
        }
    };

    // ============================================
    // UI INTERACTIONS
    // ============================================
    const UIInteractions = {
        init: function() {
            // No need for manual hover effects as CSS handles them
            Utils.log('✅ UI Interactions ready (CSS-based)');
        }
    };

    // ============================================
    // MAIN APPLICATION
    // ============================================
    const App = {
        init: function() {
            Utils.log('=== 🚀 Lottery System Starting ===');
            Utils.log('Configuration:', CONFIG);

            // Initialize modules
            TimeSync.init();
            VideoCountdown.init();
            UIInteractions.init();

            // Initial updates
            VideoCountdown.update();
            VideoAutoReload.check();

            // Start intervals
            setInterval(() => {
                VideoCountdown.update();
                VideoAutoReload.check();
            }, CONFIG.INTERVALS.countdown);

            Utils.log('✅ All systems operational');
            Utils.log('============================');
        }
    };

    // ============================================
    // START APPLICATION
    // ============================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => App.init());
    } else {
        App.init();
    }

})();
</script>



@php
// Helper function to convert hex to RGB
function hexToRgb($hex) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) == 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "$r, $g, $b";
}
@endphp
