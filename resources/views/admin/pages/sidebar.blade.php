 <aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
            <div>
              <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
            </div>
            <div>
              <h4 class="logo-text">Luckyspotbd</h4>
            </div>
            <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
            </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
            <li>
              <a href="{{route('admin.dashboard')}}">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">Dashboard</div>
              </a>

            </li>
           <li>
            <a href="{{ route('commissionsetting.index') }}" class="has-arrow">
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
          </ul>
          <!--end navigation-->
       </aside>
