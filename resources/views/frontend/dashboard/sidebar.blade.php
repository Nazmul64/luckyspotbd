@php
    $user = auth()->user();
@endphp

<style>
    .dashboard-sidebar-wrapper {
        position: relative;
    }

    .dashboard-sidebar-wrapper::before {
        content: '';
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        background: linear-gradient(135deg, #30cfd0 0%, #086755 100%);
        border-radius: 18px;
        z-index: 0;
        box-shadow:
            0 10px 40px rgba(8, 103, 85, 0.4),
            0 6px 20px rgba(48, 207, 208, 0.3),
            0 3px 10px rgba(0, 0, 0, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .dashboard-sidebar {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        z-index: 1;
    }

    .dashboard-user-wrapper {
        position: relative;
    }

    .dashboard-user-wrapper::before {
        content: '';
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        background: linear-gradient(135deg, rgba(48, 207, 208, 0.15) 0%, rgba(8, 103, 85, 0.15) 100%);
        border-radius: 12px;
        z-index: -1;
        box-shadow:
            0 8px 25px rgba(0, 0, 0, 0.12),
            0 4px 12px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.15);
    }

    .user-thumb-shadow {
        position: relative;
        display: inline-block;
        border-radius: 50%;
    }

    .user-thumb-shadow::before {
        content: '';
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        background: radial-gradient(circle, rgba(48, 207, 208, 0.3) 0%, rgba(8, 103, 85, 0.2) 70%, transparent 100%);
        border-radius: 50%;
        z-index: -1;
        box-shadow:
            0 6px 20px rgba(8, 103, 85, 0.3),
            0 3px 10px rgba(48, 207, 208, 0.2);
    }

    .referral-input-shadow {
        position: relative;
    }

    .referral-input-shadow::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(180deg, rgba(48, 207, 208, 0.05) 0%, rgba(8, 103, 85, 0.08) 100%);
        border-radius: 6px;
        z-index: -1;
        box-shadow:
            0 4px 12px rgba(8, 103, 85, 0.15),
            inset 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .copy-btn-wrapper {
        position: relative;
    }

    .copy-btn-wrapper::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(135deg, rgba(48, 207, 208, 0.2) 0%, rgba(8, 103, 85, 0.3) 100%);
        border-radius: 7px;
        z-index: -1;
        box-shadow:
            0 6px 18px rgba(8, 103, 85, 0.3),
            0 3px 8px rgba(48, 207, 208, 0.2),
            inset 0 -2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .copy-btn-wrapper:hover::before {
        box-shadow:
            0 8px 25px rgba(8, 103, 85, 0.4),
            0 5px 12px rgba(48, 207, 208, 0.3),
            inset 0 -2px 4px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .dashboard-link-wrapper {
        position: relative;
        margin-bottom: 8px;
    }

    .dashboard-link-wrapper::before {
        content: '';
        position: absolute;
        top: -1px;
        left: -1px;
        right: -1px;
        bottom: -1px;
        background: linear-gradient(135deg, rgba(48, 207, 208, 0.08) 0%, rgba(8, 103, 85, 0.12) 100%);
        border-radius: 9px;
        z-index: -1;
        box-shadow:
            0 3px 10px rgba(8, 103, 85, 0.15),
            0 1px 4px rgba(48, 207, 208, 0.1);
        transition: all 0.3s ease;
    }

    .dashboard-link-wrapper:hover::before {
        box-shadow:
            0 6px 20px rgba(8, 103, 85, 0.25),
            0 3px 8px rgba(48, 207, 208, 0.2);
        transform: translateY(-2px);
    }

    .dashboard-link-wrapper.active::before {
        background: linear-gradient(135deg, rgba(48, 207, 208, 0.15) 0%, rgba(8, 103, 85, 0.2) 100%);
        box-shadow:
            0 4px 15px rgba(8, 103, 85, 0.25),
            0 2px 6px rgba(48, 207, 208, 0.15),
            inset 0 -1px 3px rgba(0, 0, 0, 0.1);
    }

    .admin-back-wrapper {
        position: relative;
        margin-bottom: 15px;
    }

    .admin-back-wrapper::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(135deg, rgba(48, 207, 208, 0.2) 0%, rgba(8, 103, 85, 0.3) 100%);
        border-radius: 52px;
        z-index: -1;
        box-shadow:
            0 8px 30px rgba(8, 103, 85, 0.3),
            0 4px 15px rgba(48, 207, 208, 0.2),
            inset 0 -2px 5px rgba(0, 0, 0, 0.15);
    }

    .activity-section.deposits {
        background: linear-gradient(135deg, #30cfd0 0%, #086755 100%);
    }

    /* Sidebar Toggle for Mobile - FIXED VERSION */
    @media (max-width: 991.98px) {
        .dashboard-sidebar-wrapper {
            position: fixed;
            top: 0;
            left: -100%;
            width: 300px;
            max-width: 85vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            transition: left 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 20px 15px 30px 15px;
            /* Enable smooth scrolling */
            -webkit-overflow-scrolling: touch;
        }

        .dashboard-sidebar-wrapper.active {
            left: 0;
        }

        .dashboard-sidebar {
            background-color: transparent !important;
            min-height: 100%;
            padding-bottom: 50px !important;
        }

        /* Ensure all content is visible */
        .user-dashboard-tab {
            padding-bottom: 30px !important;
        }

        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Close button visible on mobile */
        .close-dashboard {
            display: block !important;
            position: sticky;
            top: 0;
            right: 0;
            font-size: 28px;
            cursor: pointer;
            z-index: 10000;
            color: #fff !important;
            background: rgba(8, 103, 85, 0.3);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex !important;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            margin-bottom: 15px;
            backdrop-filter: blur(10px);
        }

        /* Adjust user section for mobile */
        .dashboard-user {
            padding: 15px !important;
        }

        .user-thumb img {
            width: 70px !important;
            height: 70px !important;
        }

        /* Adjust links for mobile */
        .dashboard-link {
            padding: 10px 15px !important;
            font-size: 14px !important;
        }

        /* Make referral input responsive */
        #referral-url {
            font-size: 12px !important;
            padding: 8px 10px !important;
        }

        .copy-btn {
            padding: 10px 15px !important;
            font-size: 14px !important;
        }
    }

    @media (min-width: 992px) {
        .close-dashboard {
            display: none !important;
        }
    }

    /* Additional mobile optimizations */
    @media (max-width: 575.98px) {
        .dashboard-sidebar-wrapper {
            width: 280px;
        }

        .user-content h5 {
            font-size: 16px !important;
        }

        .dashboard-link {
            padding: 9px 12px !important;
            font-size: 13px !important;
        }
    }
</style>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="col-lg-3">
    <div class="dashboard-sidebar-wrapper" id="dashboardSidebar">
        <div class="dashboard-sidebar" style="background-color: rgba(48, 207, 208, 0.1); padding: 20px;">
            <div class="close-dashboard" id="closeSidebar" style="color: #086755;">
                <i class="las la-times"></i>
            </div>

            {{-- User Info --}}
            <div class="dashboard-user-wrapper">
                <div class="dashboard-user" style="background-color: rgba(48, 207, 208, 0.2); border: 1px solid #30cfd0; border-radius: 10px; padding: 20px;">
                    <div class="user-thumb-shadow">
                        <div class="user-thumb">
                            <img src="{{ $user && $user->profile_photo ? asset('uploads/profile/' . $user->profile_photo) : asset('assets/images/account/user.png') }}"
                                 alt="profile"
                                 style="border: 3px solid #30cfd0; border-radius: 50%; width: 80px; height: 80px; object-fit: cover;">
                        </div>
                    </div>
                    <div class="user-content" style="margin-top: 15px;">
                        <span class="fs-sm" style="color: #ffffff;">{{ trans_db('Welcome', 'Welcome') }}</span>
                        <h5 class="name" style="color: #ffffff; margin: 5px 0 15px 0;">{{ $user->name ?? trans_db('User', 'User') }}</h5>

                        {{-- Referral URL --}}
                        <label for="referral-url" style="color: #ffffff; display: block; margin-bottom: 8px; font-weight: 500;">{{ trans_db('Referral URL', 'Referral URL') }}</label>
                        <div class="referral-input-shadow">
                            <input id="referral-url" type="text" readonly
                                   value="{{ $user && $user->ref_code ? url('/register?ref=' . $user->ref_code) : trans_db('Referral code not available', 'Referral code not available') }}"
                                   style="border: 1px solid #30cfd0; background-color: #fff; padding: 10px 12px; border-radius: 5px; width: 100%; {{ !$user || !$user->ref_code ? 'color:red;' : 'color:#086755;' }} font-size: 14px;" />
                        </div>

                        <div class="copy-btn-wrapper">
                            <button type="button"
                                    class="copy-btn"
                                    id="copyReferralBtn"
                                    style="background: linear-gradient(135deg, #30cfd0 0%, #086755 100%); color: white; border: none; padding: 12px 20px; border-radius: 5px; margin-top: 12px; cursor: pointer; width: 100%; font-weight: 600; transition: all 0.3s ease;">
                                {{ trans_db('Copy', 'Copy') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dashboard Links --}}
            <ul class="user-dashboard-tab" style="list-style: none; padding: 0; margin-top: 20px;">
                {{-- Impersonate / Admin Back Button --}}
                @if(session()->has('impersonate'))
                    <div class="admin-back-wrapper">
                        <a href="{{ route('admin.stopImpersonate') }}"
                           style="background: linear-gradient(135deg, #30cfd0 0%, #086755 100%); color: white; padding: 14px; border-radius: 50px; display: block; text-align: center; text-decoration: none; font-weight: 600;">
                            {{ trans_db('Back to Admin', 'Back to Admin') }}
                        </a>
                    </div>
                @endif

                <div class="dashboard-link-wrapper active">
                    <a href="{{ route('frontend.dashboard') }}"
                       class="dashboard-link active"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; background: linear-gradient(135deg, #30cfd0 0%, #086755 100%); color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Dashboard', 'Dashboard') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{ route('deposte.index') }}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Deposit Now', 'Deposit Now') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{route('Withdraw.index')}}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Withdraw', 'Withdraw') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{route('all.ticket')}}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Ticket History', 'Ticket History') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{ route('profile.index') }}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Profile Settings', 'Profile Settings') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{ route('winnerlist.index') }}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Winner List', 'Winner List') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{ route('password.index') }}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Password Change', 'Password Change') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{ route('frontend.key') }}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('KYC Verification', 'KYC Verification') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{ route('supportcontact') }}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Support Contact', 'Support Contact') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{ route('my.referrals') }}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('My Referrals', 'My Referrals') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{ route('withdraw.history') }}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Withdraw History', 'Withdraw History') }}
                    </a>
                </div>

                <div class="dashboard-link-wrapper">
                    <a href="{{ route('deposite.history') }}"
                       class="dashboard-link"
                       style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                        {{ trans_db('Deposite History', 'Deposite History') }}
                    </a>
                </div>

                {{-- Logout --}}
                @auth
                    <div class="dashboard-link-wrapper">
                        <a href="{{ route('frontend.logout') }}"
                           class="dashboard-link"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           style="display: block; padding: 12px 20px; border-radius: 8px; text-decoration: none; color: white; font-weight: 500; transition: all 0.3s ease;">
                            {{ trans_db('Sign Out', 'Sign Out') }}
                        </a>
                    </div>
                    <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Copy button functionality
        const copyBtn = document.getElementById('copyReferralBtn');
        const referralInput = document.getElementById('referral-url');

        if (copyBtn && referralInput) {
            copyBtn.addEventListener('click', function () {
                const unavailableText = '{{ trans_db("Referral code not available", "Referral code not available") }}';

                if (!referralInput.value || referralInput.value === unavailableText) {
                    alert(unavailableText + '!');
                    return;
                }

                referralInput.select();
                referralInput.setSelectionRange(0, 99999);
                document.execCommand('copy');

                alert('{{ trans_db("Referral link copied to clipboard", "Referral link copied to clipboard!") }}');
            });
        }

        // Dynamic hover effects for dashboard links
        const dashboardLinks = document.querySelectorAll('.dashboard-link');

        dashboardLinks.forEach((link) => {
            // Skip active link
            if (!link.classList.contains('active')) {
                link.addEventListener('mouseenter', function() {
                    this.style.background = 'linear-gradient(135deg, rgba(48, 207, 208, 0.2) 0%, rgba(8, 103, 85, 0.2) 100%)';
                    this.style.color = 'white';
                    this.style.transform = 'translateX(5px)';
                });

                link.addEventListener('mouseleave', function() {
                    this.style.background = 'transparent';
                    this.style.color = 'white';
                    this.style.transform = 'translateX(0)';
                });
            }
        });

        // Copy button hover effect
        if (copyBtn) {
            copyBtn.addEventListener('mouseenter', function() {
                this.style.opacity = '0.9';
                this.style.transform = 'scale(1.02)';
            });

            copyBtn.addEventListener('mouseleave', function() {
                this.style.opacity = '1';
                this.style.transform = 'scale(1)';
            });
        }

        // Mobile Sidebar Toggle
        const userToggler = document.querySelector('.user-toggler');
        const dashboardSidebar = document.getElementById('dashboardSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (userToggler) {
            userToggler.addEventListener('click', function() {
                dashboardSidebar.classList.add('active');
                sidebarOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        }

        if (closeSidebar) {
            closeSidebar.addEventListener('click', function() {
                dashboardSidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                dashboardSidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            });
        }

        // Close sidebar when clicking on a link (mobile)
        if (window.innerWidth < 992) {
            dashboardLinks.forEach(link => {
                link.addEventListener('click', function() {
                    dashboardSidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            });
        }

        // Prevent body scroll when sidebar is open on mobile
        const preventBodyScroll = () => {
            if (window.innerWidth < 992 && dashboardSidebar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            }
        };

        window.addEventListener('resize', preventBodyScroll);
    });
</script>
