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
                        <i class="bi bi-circle"></i> Commission Setting List
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
                <div class="parent-icon"><i class="bi bi-wallet-fill"></i></div>
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

        <!-- About Us -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-info-circle-fill"></i></div>
                <div class="menu-title">About Us</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('aboutus.index') }}">
                        <i class="bi bi-circle"></i> About Us List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Privacy Policy -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-shield-lock-fill"></i></div>
                <div class="menu-title">Privacy Policy</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('privacypolicy.index') }}">
                        <i class="bi bi-circle"></i> Privacy Policy List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Settings Setup -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-gear-fill"></i></div>
                <div class="menu-title">Settings Setup</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('settings.index') }}">
                        <i class="bi bi-circle"></i> Settings List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Contact Setup -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-person-lines-fill"></i></div>
                <div class="menu-title">Contact Setup</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('contact.index') }}">
                        <i class="bi bi-circle"></i> Contact List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Terms & Conditions Setup -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-file-text-fill"></i></div>
                <div class="menu-title">Terms & Conditions Setup</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('Termscondition.index') }}">
                        <i class="bi bi-circle"></i> Terms & Conditions List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Slider Setup -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-images"></i></div>
                <div class="menu-title">Slider Setup</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('slider.index') }}">
                        <i class="bi bi-circle"></i> Slider List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Support Link Setup -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-link-45deg"></i></div>
                <div class="menu-title">Support Link Setup</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('supportlink.index') }}">
                        <i class="bi bi-circle"></i> Support Link List
                    </a>
                </li>
            </ul>
        </li>

        <!-- Notices Setup -->
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-file-earmark-text"></i></div>
                <div class="menu-title">Notices Setup</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('notices.index') }}">
                        <i class="bi bi-circle"></i> Notices List
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-wallet2"></i></div>
                <div class="menu-title">Deposit Balance Add</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('admin.depositeblanceadd') }}">
                        <i class="bi bi-circle"></i> Deposit Balance Add
                    </a>
                </li>
            </ul>
        </li>
         <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-wallet2"></i></div>
                <div class="menu-title">Admin Balance Add</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('admin.balance.index') }}">
                        <i class="bi bi-circle"></i> Admin Balance Add
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-clock-history"></i></div>
                <div class="menu-title">Pending Deposite</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('approve.index') }}">
                        <i class="bi bi-circle"></i> Pending Deposite
                    </a>
                </li>
            </ul>
        </li>
       <li>
        <a href="javascript:void(0);" class="has-arrow">
            <div class="parent-icon"><i class="bi bi-ticket-perforated"></i></div>
            <div class="menu-title">Ticket Create</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('lottery.index') }}">
                    <i class="bi bi-circle"></i> Ticket List
                </a>
            </li>
        </ul>
    </li>
    <li>
    <a href="javascript:void(0);" class="has-arrow">
        <div class="parent-icon"><i class="bi bi-cash-stack"></i></div>
        <div class="menu-title">Withdraw</div>
    </a>
    <ul>
        <li>
            <a href="{{ route('admin.withdraw.show') }}">
                <i class="bi bi-circle"></i> Withdraw List
            </a>
        </li>
    </ul>
    </li>
   <li>
    <a class="has-arrow" href="javascript:;" aria-expanded="false">
        <div class="parent-icon"><i class="bi bi-cash-stack"></i></div>
        <div class="menu-title">Ticket Show Declare</div>
    </a>

    <ul>
        <li>
            <a href="{{ route('admin.lottery.purchases') }}">
                <i class="bi bi-circle"></i> Ticket Declare List
            </a>
        </li>
    </ul>
</li>

<li>
    <a class="has-arrow" href="javascript:;" aria-expanded="false">
        <div class="parent-icon">
            <i class="bi bi-palette"></i>
        </div>
        <div class="menu-title">Theme Setting</div>
    </a>

    <ul>
        <li>
            <a href="{{ route('theme.index') }}">
                <i class="bi bi-circle"></i> Theme Setting List
            </a>
        </li>
    </ul>
</li>





    </ul>
    <!-- End Navigation Menu -->

</aside>
