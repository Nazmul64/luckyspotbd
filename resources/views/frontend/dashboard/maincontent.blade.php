{{-- resources/views/frontend/dashboard/maincontent.blade.php --}}

@php
    use Carbon\Carbon;

    // Fetch active theme colors from database
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#F5CE0D';
    $secondaryColor = $activeTheme->secondary_color ?? '#000000';

    // Set timezone to Bangladesh
    date_default_timezone_set('Asia/Dhaka');
@endphp

<div class="user-toggler-wrapper d-flex align-items-center d-lg-none" style="background-color: {{ $primaryColor }}20; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
    <h4 class="title m-0" style="color: {{ $secondaryColor }}; flex: 1;">User Dashboard</h4>
    <div class="user-toggler" style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 10px; border-radius: 5px; cursor: pointer;">
        <i class="las la-sliders-h"></i>
    </div>
</div>

<div class="row justify-content-center g-4">

    <!-- Total Deposit -->
    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
        <div class="dashboard-card" style="background: linear-gradient(135deg, {{ $primaryColor }}20 0%, {{ $primaryColor }}40 100%); border: 2px solid {{ $primaryColor }}; border-radius: 12px; padding: 25px; position: relative; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
            <div style="position: relative; z-index: 2;">
                <h2 style="color: {{ $secondaryColor }}; font-size: 2em; font-weight: bold; margin-bottom: 10px;">
                    {{ round($total_deposite ?? 0) }} টাকা
                </h2>
                <p style="color: {{ $secondaryColor }}; opacity: 0.8; font-size: 1.1em; margin: 0;">
                    Total Deposit
                </p>
            </div>
            <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); font-size: 3em; color: {{ $primaryColor }}; opacity: 0.3;">
                <i class="las la-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Total Balance -->
    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
        <div class="dashboard-card" style="background: linear-gradient(135deg, {{ $primaryColor }}20 0%, {{ $primaryColor }}40 100%); border: 2px solid {{ $primaryColor }}; border-radius: 12px; padding: 25px; position: relative; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
            <div style="position: relative; z-index: 2;">
                <h2 style="color: {{ $secondaryColor }}; font-size: 2em; font-weight: bold; margin-bottom: 10px;">
                    {{ round($total_balance ?? 0) }} টাকা
                </h2>
                <p style="color: {{ $secondaryColor }}; opacity: 0.8; font-size: 1.1em; margin: 0;">
                    Total Balance
                </p>
            </div>
            <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); font-size: 3em; color: {{ $primaryColor }}; opacity: 0.3;">
                <i class="las la-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Total Withdraw -->
    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
        <div class="dashboard-card" style="background: linear-gradient(135deg, {{ $primaryColor }}20 0%, {{ $primaryColor }}40 100%); border: 2px solid {{ $primaryColor }}; border-radius: 12px; padding: 25px; position: relative; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
            <div style="position: relative; z-index: 2;">
                <h2 style="color: {{ $secondaryColor }}; font-size: 2em; font-weight: bold; margin-bottom: 10px;">
                    {{ round($total_withdraw ?? 0) }} টাকা
                </h2>
                <p style="color: {{ $secondaryColor }}; opacity: 0.8; font-size: 1.1em; margin: 0;">
                    Total Withdraw
                </p>
            </div>
            <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); font-size: 3em; color: {{ $primaryColor }}; opacity: 0.3;">
                <i class="las la-wallet"></i>
            </div>
        </div>
    </div>

</div>

<!-- LOTTERY PACKAGES SECTION -->
<div class="row gy-4 justify-content-center pt-5">
    @forelse($package_show as $package)
        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6">
            <div class="game-card" style="background: linear-gradient(135deg, {{ $primaryColor }}15 0%, {{ $secondaryColor }}15 100%); border: 2px solid {{ $primaryColor }}; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease; position: relative;">
                <div style="padding: 20px;">

                    @php
                        // ========================================
                        // BANGLADESH TIME ZONE (BST = UTC+6)
                        // ========================================

                        // Current server time in Bangladesh timezone
                        $serverNow = Carbon::now('Asia/Dhaka');
                        $serverTimestamp = $serverNow->timestamp * 1000;

                        // Draw Date in Bangladesh timezone
                        $drawDate = $package->draw_date
                            ? Carbon::parse($package->draw_date, 'UTC')->setTimezone('Asia/Dhaka')
                            : null;
                        $drawTimestamp = $drawDate ? $drawDate->timestamp * 1000 : 0;

                        // Video Scheduled Time in Bangladesh timezone
                        $videoScheduledAt = $package->video_scheduled_at
                            ? Carbon::parse($package->video_scheduled_at, 'UTC')->setTimezone('Asia/Dhaka')
                            : null;
                        $videoTimestamp = $videoScheduledAt ? $videoScheduledAt->timestamp * 1000 : 0;

                        // Video Show Logic
                        $shouldShowVideo = false;
                        if ($package->video_enabled && $package->video_url && $videoScheduledAt) {
                            $shouldShowVideo = $serverNow->gte($videoScheduledAt);
                        }

                        // Video Embed URL
                        $embedUrl = '';
                        if ($package->video_url) {
                            $videoUrl = trim($package->video_url);
                            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                $videoId = $matches[1];
                                $embedUrl = "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=0&rel=0&modestbranding=1&controls=1";
                            } else {
                                $embedUrl = $videoUrl;
                            }
                        }

                        $isYouTube = $package->video_url && (str_contains($package->video_url, 'youtube.com') || str_contains($package->video_url, 'youtu.be'));

                        // Debug Log
                        \Log::info("Package {$package->id} - Bangladesh Time", [
                            'server_now_bst' => $serverNow->format('Y-m-d H:i:s'),
                            'video_scheduled_bst' => $videoScheduledAt ? $videoScheduledAt->format('Y-m-d H:i:s') : 'null',
                            'draw_date_bst' => $drawDate ? $drawDate->format('Y-m-d H:i:s') : 'null',
                            'should_show' => $shouldShowVideo ? 'YES' : 'NO',
                            'time_diff' => $videoScheduledAt ? $serverNow->diffInSeconds($videoScheduledAt, false) . ' seconds' : 'N/A',
                        ]);
                    @endphp

                    {{-- 🐛 DEBUG INFO (Admin Only) --}}
                    @if(auth()->check() && auth()->user()->email === 'admin@example.com')
                        <div style="font-size: 0.8em; margin: 10px; padding: 10px; background-color: {{ $primaryColor }}20; border: 1px solid {{ $primaryColor }}; border-radius: 5px; color: {{ $secondaryColor }};">
                            <strong style="color: {{ $secondaryColor }};">🐛 Debug Info (ID: {{ $package->id }})</strong><br>
                            <span style="color: {{ $secondaryColor }};">Server Time (BST): {{ $serverNow->format('Y-m-d H:i:s') }}</span><br>
                            <span style="color: {{ $secondaryColor }};">Video Time (BST): {{ $videoScheduledAt ? $videoScheduledAt->format('Y-m-d H:i:s') : 'null' }}</span><br>
                            <span style="color: {{ $secondaryColor }};">Draw Time (BST): {{ $drawDate ? $drawDate->format('Y-m-d H:i:s') : 'null' }}</span><br>
                            <span style="color: {{ $secondaryColor }};">Should Show: {{ $shouldShowVideo ? 'YES ✅' : 'NO ❌' }}</span><br>
                            <span style="color: {{ $secondaryColor }};">Server Timestamp: {{ $serverTimestamp }}</span><br>
                            <span style="color: {{ $secondaryColor }};">Video Timestamp: {{ $videoTimestamp }}</span><br>
                            <span style="color: {{ $secondaryColor }};">Draw Timestamp: {{ $drawTimestamp }}</span>
                        </div>
                    @endif

                    {{-- AUTHENTICATED USER --}}
                    @auth
                        <form method="POST" action="{{ route('buy.package', $package->id) }}">
                            @csrf

                            <div style="border-radius: 12px; overflow: hidden; margin-bottom: 20px; border: 3px solid {{ $primaryColor }}; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                                <img src="{{ asset('uploads/Lottery/' . ($package->photo ?? 'default.png')) }}"
                                     alt="{{ $package->name }}"
                                     style="width: 100%; height: auto; display: block;"
                                     onerror="this.src='{{ asset('assets/images/default-lottery.png') }}'">
                            </div>

                            <div>
                                <h4 style="color: {{ $secondaryColor }}; font-size: 1.5em; font-weight: bold; margin-bottom: 10px;">
                                    {{ $package->name ?? 'N/A' }}
                                </h4>

                                <p style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; display: inline-block; padding: 5px 15px; border-radius: 20px; font-size: 0.9em; font-weight: 600; margin-bottom: 10px;">
                                    {{ ucfirst($package->win_type ?? 'N/A') }}
                                </p>

                                <p style="color: {{ $primaryColor }}; font-size: 1.8em; font-weight: bold; margin-bottom: 15px;">
                                    {{ $package->price ? number_format($package->price, 0) . ' টাকা' : '0 টাকা' }}
                                </p>

                                <p style="color: {{ $secondaryColor }}; margin-bottom: 10px; font-size: 0.95em;">
                                    <i class="fas fa-calendar-alt" style="color: {{ $primaryColor }};"></i>
                                    <span style="font-weight: 600;">Draw Date:</span> {{ $drawDate ? $drawDate->format('d M, Y h:i A') : 'Not Set' }}
                                </p>

                                {{-- Prize Information --}}
                                <div style="background-color: {{ $secondaryColor }}10; border-left: 4px solid {{ $primaryColor }}; padding: 15px; border-radius: 8px; margin-top: 15px; margin-bottom: 15px;">
                                    <p style="color: {{ $secondaryColor }}; margin-bottom: 8px; font-size: 0.95em;">
                                        <i class="fas fa-trophy" style="color: {{ $primaryColor }};"></i>
                                        <span style="font-weight: 600;">1st Prize:</span> {{ number_format($package->first_prize ?? 0, 0) }} টাকা
                                    </p>
                                    <p style="color: {{ $secondaryColor }}; margin-bottom: 8px; font-size: 0.95em;">
                                        <i class="fas fa-medal" style="color: {{ $primaryColor }};"></i>
                                        <span style="font-weight: 600;">2nd Prize:</span> {{ number_format($package->second_prize ?? 0, 0) }} টাকা
                                    </p>
                                    <p style="color: {{ $secondaryColor }}; margin-bottom: 0; font-size: 0.95em;">
                                        <i class="fas fa-award" style="color: {{ $primaryColor }};"></i>
                                        <span style="font-weight: 600;">3rd Prize:</span> {{ number_format($package->third_prize ?? 0, 0) }} টাকা
                                    </p>
                                </div>

                                <div style="background-color: {{ $primaryColor }}15; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                                    <p style="color: {{ $secondaryColor }}; margin-bottom: 0; font-size: 0.95em;">
                                        <i class="fas fa-users" style="color: {{ $primaryColor }};"></i>
                                        <span style="font-weight: 600;">Total Participants:</span> {{ $total_buyer }}
                                    </p>
                                </div>

                                {{-- Multiple Packages --}}
                                @if(is_array($package->multiple_title) && count($package->multiple_title) > 0)
                                    <div style="background: linear-gradient(135deg, {{ $primaryColor }}15 0%, {{ $secondaryColor }}10 100%); padding: 15px; border-radius: 10px; margin-top: 15px; border: 1px solid {{ $primaryColor }};">
                                        <h6 style="color: {{ $secondaryColor }}; margin-bottom: 12px; font-weight: bold; font-size: 1.1em;">
                                            <i class="fas fa-box-open" style="color: {{ $primaryColor }};"></i> Best Gift:
                                        </h6>
                                        <ul style="list-style: none; padding: 0; margin: 0;">
                                            @foreach($package->multiple_title as $index => $title)
                                                @if($title)
                                                    <li style="color: {{ $secondaryColor }}; margin-bottom: 8px; padding-left: 25px; position: relative; font-size: 0.9em;">
                                                        <i class="fas fa-check-circle" style="color: {{ $primaryColor }}; position: absolute; left: 0; top: 2px;"></i>
                                                        <strong>{{ $title }}</strong> - {{ number_format($package->multiple_price[$index] ?? 0, 0) }} টাকা
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Video Section --}}
                                @if($package->video_enabled && $embedUrl)
                                    <div class="video-section" style="margin-top: 20px;"
                                         id="video-section-{{ $package->id }}"
                                         data-package-id="{{ $package->id }}"
                                         data-should-show="{{ $shouldShowVideo ? 'true' : 'false' }}"
                                         data-video-time="{{ $videoTimestamp }}"
                                         data-server-time="{{ $serverTimestamp }}"
                                         data-embed-url="{{ $embedUrl }}">

                                        @if($shouldShowVideo)
                                            {{-- Video is LIVE --}}
                                            <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.3); margin-bottom: 15px; border: 3px solid {{ $primaryColor }};">
                                                @if($isYouTube)
                                                    <div style="position: relative; padding-bottom: 56.25%; height: 0; background: #000;">
                                                        <iframe
                                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                                            src="{{ $embedUrl }}"
                                                            title="Lottery Live Draw"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            allowfullscreen>
                                                        </iframe>
                                                    </div>
                                                @else
                                                    <video controls autoplay playsinline
                                                        style="width: 100%; border-radius: 12px; background: #000;"
                                                        poster="{{ asset('uploads/Lottery/' . ($package->photo ?? 'default.png')) }}">
                                                        <source src="{{ $package->video_url }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @endif
                                            </div>
                                            <p style="color: {{ $primaryColor }}; margin-top: 10px; font-weight: bold; font-size: 1.1em; text-align: center;">
                                                <i class="fas fa-circle blink-icon" style="color: #ff0000;"></i> LIVE NOW
                                            </p>
                                        @else
                                            {{-- Video Coming Soon --}}
                                            <div style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%); padding: 30px; border-radius: 12px; text-align: center; box-shadow: 0 6px 20px rgba(0,0,0,0.2);">
                                                <i class="fas fa-video pulse-icon" style="font-size: 3.5em; color: white; margin-bottom: 20px; display: block;"></i>
                                                <h5 style="color: white; margin-bottom: 15px; font-size: 1.3em; font-weight: bold;">
                                                    <i class="fas fa-broadcast-tower"></i> Live Draw Coming Soon!
                                                </h5>
                                                @if($videoTimestamp > 0)
                                                    <p class="video-countdown"
                                                       data-video-time="{{ $videoTimestamp }}"
                                                       data-server-time="{{ $serverTimestamp }}"
                                                       data-package-id="{{ $package->id }}"
                                                       style="color: white; font-size: 1.2em; font-weight: bold; margin-bottom: 15px;">
                                                       <i class="fas fa-clock"></i> Calculating...
                                                    </p>
                                                @endif
                                                <p style="color: white; font-size: 0.95em; opacity: 0.95; margin-bottom: 0;">
                                                    <i class="fas fa-calendar-check"></i>
                                                    Video Start: {{ $videoScheduledAt ? $videoScheduledAt->format('d M, Y h:i A') : 'Not Set' }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <button type="submit"
                                        class="buy-btn"
                                        style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; border: none; padding: 15px 30px; border-radius: 8px; margin-top: 20px; width: 100%; font-size: 1.1em; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                                    <i class="fas fa-ticket-alt"></i> Buy Ticket
                                </button>
                            </div>
                        </form>
                    @else
                        {{-- GUEST USER --}}
                        <div style="border-radius: 12px; overflow: hidden; margin-bottom: 20px; border: 3px solid {{ $primaryColor }};">
                            <img src="{{ asset('uploads/Lottery/' . ($package->photo ?? 'default.png')) }}"
                                 alt="{{ $package->name }}"
                                 style="width: 100%; height: auto; display: block;">
                        </div>

                        <div>
                            <h4 style="color: {{ $secondaryColor }}; font-size: 1.5em; font-weight: bold; margin-bottom: 15px;">
                                {{ $package->name ?? 'N/A' }}
                            </h4>

                            @if($package->video_enabled && $embedUrl && $shouldShowVideo)
                                <div style="margin-top: 20px; margin-bottom: 20px;">
                                    <div style="border-radius: 12px; overflow: hidden; border: 3px solid {{ $primaryColor }};">
                                        @if($isYouTube)
                                            <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                                                <iframe
                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                                    src="{{ $embedUrl }}"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        @else
                                            <video controls autoplay src="{{ $package->video_url }}" style="width: 100%;"></video>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <a href="{{ route('frontend.login') }}"
                               class="login-btn"
                               style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; border: none; padding: 15px 30px; border-radius: 8px; margin-top: 20px; width: 100%; display: block; text-align: center; text-decoration: none; font-size: 1.1em; font-weight: bold; transition: all 0.3s ease;">
                                <i class="fas fa-sign-in-alt"></i> Login to Play
                            </a>
                        </div>
                    @endauth

                </div>
                <div style="position: absolute; width: 60px; height: 60px; background-color: {{ $primaryColor }}; opacity: 0.1; border-radius: 50%; bottom: -30px; right: -30px;"></div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5" style="background-color: {{ $primaryColor }}10; border-radius: 15px; padding: 50px; border: 2px dashed {{ $primaryColor }};">
                <i class="fas fa-inbox" style="font-size: 64px; color: {{ $primaryColor }}; opacity: 0.5; margin-bottom: 20px;"></i>
                <h4 style="color: {{ $secondaryColor }}; margin-top: 20px;">No lottery packages available</h4>
            </div>
        </div>
    @endforelse
</div>

<!-- =======================
     TRANSACTION HISTORY
=========================== -->
<div class="mt-5" style="background: linear-gradient(135deg, {{ $primaryColor }}10 0%, {{ $secondaryColor }}10 100%); border-radius: 15px; padding: 25px; border: 2px solid {{ $primaryColor }}; box-shadow: 0 6px 20px rgba(0,0,0,0.1);">
    <h3 style="color: {{ $secondaryColor }}; margin-bottom: 25px; font-weight: bold; padding-bottom: 15px; border-bottom: 3px solid {{ $primaryColor }};">
        <i class="fas fa-history" style="color: {{ $primaryColor }};"></i> Transaction History
    </h3>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
            <thead>
                <tr>
                    <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 15px; text-align: left; font-weight: bold; border-radius: 8px 0 0 8px;">Transaction ID</th>
                    <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 15px; text-align: left; font-weight: bold;">Type</th>
                    <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 15px; text-align: left; font-weight: bold;">Date</th>
                    <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 15px; text-align: left; font-weight: bold;">Amount</th>
                    <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 15px; text-align: left; font-weight: bold; border-radius: 0 8px 8px 0;">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($deposite_history as $deposit)
                    <tr class="table-row" style="background-color: {{ $secondaryColor }}05; transition: all 0.3s ease;">
                        <td style="padding: 15px; color: {{ $secondaryColor }}; border-left: 3px solid {{ $primaryColor }}; font-weight: 600;">
                            {{ $deposit->transaction_id ?? '#' . $deposit->id }}
                        </td>
                        <td style="padding: 15px; color: {{ $secondaryColor }};">
                            <span style="background-color: {{ $deposit->amount > 0 ? $primaryColor : $secondaryColor }}20; padding: 5px 12px; border-radius: 15px; font-size: 0.9em; font-weight: 600;">
                                {{ $deposit->amount > 0 ? 'Deposit' : 'Withdraw' }}
                            </span>
                        </td>
                        <td style="padding: 15px; color: {{ $secondaryColor }};">
                            {{ $deposit->created_at ? $deposit->created_at->format('d M, Y h:i A') : 'N/A' }}
                        </td>
                        <td style="padding: 15px; color: {{ $primaryColor }}; font-weight: bold; font-size: 1.1em;">
                            ${{ number_format($deposit->amount, 2) }}
                        </td>
                        <td style="padding: 15px;">
                            @if($deposit->status == 'approved')
                                <span style="background-color: #28a745; color: white; padding: 6px 15px; border-radius: 20px; font-size: 0.85em; font-weight: 600; display: inline-block;">
                                    <i class="fas fa-check-circle"></i> Approved
                                </span>
                            @elseif($deposit->status == 'pending')
                                <span style="background-color: #ffc107; color: {{ $secondaryColor }}; padding: 6px 15px; border-radius: 20px; font-size: 0.85em; font-weight: 600; display: inline-block;">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                            @else
                                <span style="background-color: #dc3545; color: white; padding: 6px 15px; border-radius: 20px; font-size: 0.85em; font-weight: 600; display: inline-block;">
                                    <i class="fas fa-times-circle"></i> Rejected
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: {{ $secondaryColor }}; font-size: 1.1em;">
                            <i class="fas fa-inbox" style="font-size: 3em; color: {{ $primaryColor }}; opacity: 0.3; display: block; margin-bottom: 15px;"></i>
                            No transaction history found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
(function() {
    'use strict';

    const DEBUG = true;
    const primaryColor = '{{ $primaryColor }}';
    const secondaryColor = '{{ $secondaryColor }}';

    function log(msg, data = null) {
        if (DEBUG) {
            console.log('[Lottery]', msg, data || '');
        }
    }

    // ============================================
    // ANIMATIONS - Blink & Pulse
    // ============================================
    function initAnimations() {
        // Blink Animation for LIVE indicator
        const blinkIcons = document.querySelectorAll('.blink-icon');
        blinkIcons.forEach(icon => {
            let opacity = 1;
            let decreasing = true;

            setInterval(() => {
                if (decreasing) {
                    opacity -= 0.1;
                    if (opacity <= 0.3) decreasing = false;
                } else {
                    opacity += 0.1;
                    if (opacity >= 1) decreasing = true;
                }
                icon.style.opacity = opacity;
            }, 100);
        });

        // Pulse Animation for video icon
        const pulseIcons = document.querySelectorAll('.pulse-icon');
        pulseIcons.forEach(icon => {
            let scale = 1;
            let increasing = true;

            setInterval(() => {
                if (increasing) {
                    scale += 0.01;
                    if (scale >= 1.1) increasing = false;
                } else {
                    scale -= 0.01;
                    if (scale <= 1) increasing = true;
                }
                icon.style.transform = `scale(${scale})`;
            }, 50);
        });
    }

    // ============================================
    // HOVER EFFECTS
    // ============================================
    function initHoverEffects() {
        // Dashboard Cards Hover
        const dashboardCards = document.querySelectorAll('.dashboard-card');
        dashboardCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.2)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
            });
        });

        // Game Cards Hover
        const gameCards = document.querySelectorAll('.game-card');
        gameCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 12px 35px rgba(0,0,0,0.25)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            });
        });

        // Buy/Login Buttons Hover
        const buyButtons = document.querySelectorAll('.buy-btn, .login-btn');
        buyButtons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.opacity = '0.9';
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.3)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.opacity = '1';
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
            });
        });

        // Table Rows Hover
        const tableRows = document.querySelectorAll('.table-row');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = primaryColor + '15';
                this.style.transform = 'scale(1.01)';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = secondaryColor + '05';
                this.style.transform = 'scale(1)';
            });
        });
    }

    // ============================================
    // BANGLADESH TIME SYNC
    // ============================================
    let serverTimeOffset = 0;

    function initializeServerTime() {
        const firstTimer = document.querySelector('[data-server]');
        if (firstTimer) {
            const serverTime = parseInt(firstTimer.getAttribute('data-server'), 10);
            const browserTime = Date.now();
            serverTimeOffset = serverTime - browserTime;

            log('✅ Time Sync Initialized', {
                server_time: new Date(serverTime).toLocaleString('en-US', { timeZone: 'Asia/Dhaka' }),
                browser_time: new Date(browserTime).toLocaleString('en-US', { timeZone: 'Asia/Dhaka' }),
                offset_seconds: Math.round(serverTimeOffset / 1000)
            });
        }
    }

    function getServerTime() {
        return Date.now() + serverTimeOffset;
    }

    // ============================================
    // DRAW COUNTDOWN
    // ============================================
    function updateCountdowns() {
        const timers = document.querySelectorAll('.countdown-timer');

        timers.forEach(function(timer) {
            const drawTime = parseInt(timer.getAttribute('data-draw'), 10);
            const packageId = timer.getAttribute('data-package-id');

            if (!drawTime || isNaN(drawTime) || drawTime <= 0) {
                timer.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Invalid draw date';
                timer.style.color = '#dc3545';
                log('❌ Invalid draw time for package ' + packageId);
                return;
            }

            const now = getServerTime();
            const diff = drawTime - now;

            if (diff <= 0) {
                timer.innerHTML = '<i class="fas fa-check-circle"></i> Draw completed!';
                timer.style.color = '#28a745';
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            timer.innerHTML = `<i class="fas fa-hourglass-half"></i> ${days}d ${hours}h ${minutes}m ${seconds}s`;
            timer.style.color = primaryColor;

            if (DEBUG && Math.random() < 0.01) {
                log('Draw Countdown (Package ' + packageId + ')', {
                    days, hours, minutes, seconds,
                    total_seconds: Math.floor(diff / 1000)
                });
            }
        });
    }

    // ============================================
    // VIDEO COUNTDOWN
    // ============================================
    function updateVideoCountdowns() {
        const videoCountdowns = document.querySelectorAll('.video-countdown');

        videoCountdowns.forEach(function(countdown) {
            const videoTime = parseInt(countdown.getAttribute('data-video-time'), 10);
            const packageId = countdown.getAttribute('data-package-id');

            if (!videoTime || isNaN(videoTime) || videoTime <= 0) {
                countdown.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Video time not set';
                countdown.style.color = '#dc3545';
                log('❌ Invalid video time for package ' + packageId);
                return;
            }

            const now = getServerTime();
            const diff = videoTime - now;

            if (diff <= 0) {
                countdown.innerHTML = '<i class="fas fa-circle" style="color: #ff0000;"></i> Video is LIVE!';
                countdown.style.color = '#00ff00';
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            countdown.innerHTML = `<i class="fas fa-clock"></i> ${days}d ${hours}h ${minutes}m ${seconds}s`;

            if (DEBUG && Math.random() < 0.01) {
                log('Video Countdown (Package ' + packageId + ')', {
                    days, hours, minutes, seconds,
                    total_seconds: Math.floor(diff / 1000)
                });
            }
        });
    }

    // ============================================
    // AUTO RELOAD WHEN VIDEO TIME COMES
    // ============================================
    function checkAndShowVideos() {
        const videoSections = document.querySelectorAll('.video-section');
        let needsReload = false;

        videoSections.forEach(function(section) {
            const shouldShow = section.getAttribute('data-should-show');
            const videoTime = parseInt(section.getAttribute('data-video-time'), 10);
            const packageId = section.getAttribute('data-package-id');

            if (shouldShow === 'false' && videoTime && !isNaN(videoTime) && videoTime > 0) {
                const now = getServerTime();
                const diff = videoTime - now;

                if (diff <= 3000 && diff > -1000) {
                    log(`🔄 Package ${packageId}: Video time reached! Reloading...`);
                    needsReload = true;
                }
            }
        });

        if (needsReload) {
            const reloadKey = 'video_reload_triggered';
            const lastReload = sessionStorage.getItem(reloadKey);

            if (!lastReload || (Date.now() - parseInt(lastReload)) > 30000) {
                sessionStorage.setItem(reloadKey, Date.now().toString());
                log('🔄 Reloading page to show video...');
                setTimeout(() => window.location.reload(true), 1000);
            }
        }
    }

    // ============================================
    // INITIALIZE EVERYTHING
    // ============================================
    function init() {
        log('=== 🚀 Lottery System Initialized ===');
        log('Timezone: Asia/Dhaka (BST = UTC+6)');
        log('Theme Colors:', { primary: primaryColor, secondary: secondaryColor });

        // Initialize animations and hover effects
        initAnimations();
        initHoverEffects();

        // Initialize time sync
        initializeServerTime();
        updateCountdowns();
        updateVideoCountdowns();
        checkAndShowVideos();

        // Update every second
        setInterval(function() {
            updateCountdowns();
            updateVideoCountdowns();
            checkAndShowVideos();
        }, 1000);

        log('✅ System running with Bangladesh time sync');
    }

    // Start when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
