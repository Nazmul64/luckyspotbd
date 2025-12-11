  <header class="top-header">
        <nav class="navbar navbar-expand gap-3 align-items-center">
          <div class="mobile-toggle-icon fs-3">
              <i class="bi bi-list"></i>
            </div>
                   @php
                       use App\Models\User;
                       $user_photo = Auth::user();
                   @endphp
            <div class="top-navbar-right ms-auto">
              <ul class="navbar-nav align-items-center">
              <li class="nav-item dropdown dropdown-user-setting">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                  <div class="user-setting d-flex align-items-center">
                    <img src="{{ asset('uploads/admin/' . ($user_photo->profile_photo ?? 'default.png')) }}"class="rounded-circle" width="54"height="54"alt="Admin Photo">
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>

                     <a class="dropdown-item" href="#">
                       <div class="d-flex align-items-center">

                        <img src="{{ asset('uploads/admin/' . ($user_photo->profile_photo ?? 'default.png')) }}"class="rounded-circle" width="54"height="54"alt="Admin Photo">
                          <div class="ms-3">
                            <h6 class="mb-0 dropdown-user-name">{{Auth::User()->name ?? ''}}</h6>
                          </div>
                       </div>
                     </a>
                   </li>
                   <li><hr class="dropdown-divider"></li>
                   <li>
                      <a class="dropdown-item" href="{{route('profile.change')}}">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-person-fill"></i></div>
                           <div class="ms-3"><span>Profile</span></div>
                         </div>
                       </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('adminpassword.change')}}">
                         <div class="d-flex align-items-center">
                           <div class=""><i class="bi bi-gear-fill"></i></div>
                           <div class="ms-3"><span>Password Change</span></div>
                         </div>
                       </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>
                   <li>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center" style="border:none; background:none; padding:0;">
                                <div><i class="bi bi-lock-fill"></i></div>
                                <div class="ms-3"><span>Logout</span></div>
                            </button>
                        </form>
                    </li>

                </ul>
              </li>
              </ul>
              </div>
        </nav>
      </header>
