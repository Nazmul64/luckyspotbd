<aside class="sidebar-wrapper" data-simplebar="true">

    <!-- Sidebar Header -->
    <div class="sidebar-header d-flex align-items-center">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="logo-text">Luckyspotbd</a>
        </div>
        <div class="toggle-icon ms-auto">
            <i class="bi bi-list"></i>
        </div>
    </div>

    <!-- Navigation Menu -->
    <ul class="metismenu" id="menu">

        <!-- Dashboard -->
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class="bi bi-house-fill"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <!-- Commission Setup -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="menu-title">Commission Setup</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('commissionsetting.index') }}">
                        <i class="bi bi-circle"></i> Commissionsetting List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Withdraw Commission Setup -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="menu-title">Withdraw Commission Setup</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('withdrawcommisson.index') }}">
                        <i class="bi bi-circle"></i> Withdraw Commission List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Wallet Setting -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-cash-stack"></i></div>
                <div class="menu-title">Wallet Setting</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('waletesetting.index') }}">
                        <i class="bi bi-circle"></i> Wallet Setting List
                    </a>
                </li>
            </ul>
        </li>

    </ul>
    <!-- End Navigation -->

</aside>
