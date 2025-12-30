@php
    $user = auth()->user();
    // Fetch active theme colors from database
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '';
    $secondaryColor = $activeTheme->secondary_color ?? '';
@endphp

<div class="col-lg-3">
    <div class="dashboard-sidebar" style="background-color: {{ $primaryColor }}10;">
        <div class="close-dashboard d-lg-none" style="color: {{ $secondaryColor }};">
            <i class="las la-times"></i>
        </div>

        {{-- User Info --}}
        <div class="dashboard-user" style="background-color: {{ $primaryColor }}20; border: 1px solid {{ $primaryColor }};">
            <div class="user-thumb">
                <img src="{{ $user && $user->profile_photo ? asset('uploads/profile/' . $user->profile_photo) : asset('assets/images/account/user.png') }}"
                     alt="profile"
                     style="border: 3px solid {{ $primaryColor }};">
            </div>
            <div class="user-content">
                <span class="fs-sm" style="color: {{ $secondaryColor }};">Welcome</span>
                <h5 class="name" style="color: {{ $secondaryColor }};">{{ $user->name ?? 'User' }}</h5>

                {{-- Referral URL --}}
                <label for="referral-url" style="color: {{ $secondaryColor }};">Referral URL</label>
                <input id="referral-url" type="text" readonly
                       value="{{ $user && $user->ref_code ? url('/register?ref=' . $user->ref_code) : 'Referral code not available' }}"
                       style="border: 1px solid {{ $primaryColor }}; background-color: #fff; padding: 8px; border-radius: 5px; width: 100%; {{ !$user || !$user->ref_code ? 'color:red;' : 'color:' . $secondaryColor . ';' }}" />

                <button type="button"
                        class="copy-btn"
                        id="copyReferralBtn"
                        style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; border: none; padding: 10px 20px; border-radius: 5px; margin-top: 10px; cursor: pointer; width: 100%; font-weight: 600;">
                    Copy
                </button>
            </div>
        </div>

        {{-- Dashboard Links --}}
        <ul class="user-dashboard-tab" style="list-style: none; padding: 0;">
            {{-- Impersonate / Admin Back Button --}}
            @if(session()->has('impersonate'))
                <div class="header-controls mb-3">
                    <a href="{{ route('admin.stopImpersonate') }}"
                       style="background: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 14px; border-radius: 50px; display: block; text-align: center; text-decoration: none; font-weight: 600;">
                        Back to Admin
                    </a>
                </div>
            @endif

            <li style="margin-bottom: 5px;">
                <a href="{{ route('frontend.dashboard') }}"
                   class="dashboard-link active"
                   style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                    Dashboard
                </a>
            </li>
            <li style="margin-bottom: 5px;">
                <a href="{{ route('deposte.index') }}"
                   class="dashboard-link"
                   style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                    Deposit Now
                </a>
            </li>
            <li style="margin-bottom: 5px;">
                <a href="{{route('Withdraw.index')}}"
                   class="dashboard-link"
                   style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                    Withdraw
                </a>
            </li>
            <li style="margin-bottom: 5px;">
                <a href="{{route('all.ticket')}}"
                   class="dashboard-link"
                   style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                    Ticket History
                </a>
            </li>
            <li style="margin-bottom: 5px;">
                <a href="{{ route('profile.index') }}"
                   class="dashboard-link"
                   style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                    Profile Settings
                </a>
            </li>
             <li style="margin-bottom: 5px;">
                <a href="{{ route('winnerlist.index') }}"
                   class="dashboard-link"
                   style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                    Winner List
                </a>
            </li>

            <li style="margin-bottom: 5px;">
                <a href="{{ route('password.index') }}"
                   class="dashboard-link"
                   style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                    Password Change
                </a>
            </li>
             <li style="margin-bottom: 5px;">
                <a href="{{ route('frontend.key') }}"
                   class="dashboard-link"
                   style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                    KYC Verification
                </a>
            </li>
               <li style="margin-bottom: 5px;">
                <a href="{{ route('supportcontact') }}"
                   class="dashboard-link"
                   style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                    Support Contact
                </a>
            </li>




            {{-- Logout --}}
            @auth
                <li style="margin-bottom: 5px;">
                    <a href="{{ route('frontend.logout') }}"
                       class="dashboard-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: {{ $secondaryColor }}; font-weight: 500; transition: all 0.3s ease;">
                        Sign Out
                    </a>
                </li>
                <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endauth
        </ul>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const primaryColor = '{{ $primaryColor }}';
        const secondaryColor = '{{ $secondaryColor }}';

        // Copy button functionality
        const copyBtn = document.getElementById('copyReferralBtn');
        const referralInput = document.getElementById('referral-url');

        copyBtn.addEventListener('click', function () {
            if (!referralInput.value || referralInput.value === 'Referral code not available') {
                alert('Referral code not available!');
                return;
            }

            referralInput.select();
            referralInput.setSelectionRange(0, 99999);
            document.execCommand('copy');
            alert('Referral link copied to clipboard!');
        });

        // Dynamic hover effects for dashboard links
        const dashboardLinks = document.querySelectorAll('.dashboard-link');

        dashboardLinks.forEach(link => {
            // Skip active link
            if (!link.classList.contains('active')) {
                link.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = primaryColor + '20';
                    this.style.color = secondaryColor;
                });

                link.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = 'transparent';
                    this.style.color = secondaryColor;
                });
            }
        });

        // Copy button hover effect
        copyBtn.addEventListener('mouseenter', function() {
            this.style.opacity = '0.8';
        });

        copyBtn.addEventListener('mouseleave', function() {
            this.style.opacity = '1';
        });
    });
</script>
