@php
    $user = auth()->user();
@endphp

<div class="col-lg-3">
    <div class="dashboard-sidebar">
        <div class="close-dashboard d-lg-none">
            <i class="las la-times"></i>
        </div>

        {{-- User Info --}}
        <div class="dashboard-user">
            <div class="user-thumb">
                <img src="{{ $user && $user->profile_photo ? asset('uploads/profile/' . $user->profile_photo) : asset('assets/images/account/user.png') }}" alt="profile">
            </div>
            <div class="user-content">
                <span class="fs-sm">Welcome</span>
                <h5 class="name">{{ $user->name ?? 'User' }}</h5>

                {{-- Referral URL --}}
                <label for="referral-url">Referral URL</label>
                <input id="referral-url" type="text" readonly
                       value="{{ $user && $user->ref_code ? url('/register?ref=' . $user->ref_code) : 'Referral code not available' }}"
                       style="{{ !$user || !$user->ref_code ? 'color:red;' : '' }}" />

                <button type="button" class="copy-btn" id="copyReferralBtn">Copy</button>
            </div>
        </div>

        {{-- Dashboard Links --}}
        <ul class="user-dashboard-tab">
            {{-- Impersonate / Admin Back Button --}}
            @if(session()->has('impersonate'))
                <div class="header-controls mb-3">
                    <a href="{{ route('admin.stopImpersonate') }}"
                       class="text-black"
                       style="background:#F5CE0D; padding:14px; border-radius:50px; display:block; text-align:center;">
                        Back to Admin
                    </a>
                </div>
            @endif

            <li><a href="#" class="active">Dashboard</a></li>
            <li><a href="{{ route('deposte.index') }}">Deposit Now</a></li>
            <li><a href="{{route('Withdraw.index')}}">Withdraw </a></li>
            <li><a href="#">Transaction History</a></li>
            <li><a href="{{ route('profile.index') }}">Profile Settings</a></li>
            <li><a href="{{ route('password.index') }}">Password Change</a></li>

            {{-- Logout --}}
            @auth
                <li>
                    <a href="{{ route('frontend.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
        const copyBtn = document.getElementById('copyReferralBtn');
        const referralInput = document.getElementById('referral-url');

        copyBtn.addEventListener('click', function () {
            if (!referralInput.value || referralInput.value === 'Referral code not available') {
                alert('Referral code not available!');
                return;
            }

            referralInput.select();
            referralInput.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand('copy');

            // Optional: show success feedback
            alert('Referral link copied to clipboard!');
        });
    });
</script>

