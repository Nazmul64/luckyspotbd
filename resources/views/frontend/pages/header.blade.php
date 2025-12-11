<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuckySpotBD</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/assets/images/favicon.png') }}" sizes="16x16">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/lib/bootstrap.min.css') }}">

    <!-- Icon Libraries -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/line-awesome.min.css') }}">

    <!-- Animation -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/lib/animate.css') }}">

    <!-- Slider Plugin -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/lib/slick.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">


<!-- jQuery first, then Bootstrap JS, then Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('frontend/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
<!-- jQuery first, then Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Toastr & Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Toastr Notifications -->
<script>
    $(document).ready(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };

        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    });
</script>

</head>

<body data-bs-spy="scroll" data-bs-offset="170" data-bs-target=".privacy-policy-sidebar-menu">

    <div class="overlay"></div>
    <div class="preloader">
        <div class="scene" id="scene">
            <input type="checkbox" id="andicator" />
            <div class="cube">
                <div class="cube__face cube__face--front"><i></i></div>
                <div class="cube__face cube__face--back"><i></i><i></i></div>
                <div class="cube__face cube__face--right"><i></i><i></i><i></i><i></i><i></i></div>
                <div class="cube__face cube__face--left"><i></i><i></i><i></i><i></i><i></i><i></i></div>
                <div class="cube__face cube__face--top"><i></i><i></i><i></i></div>
                <div class="cube__face cube__face--bottom"><i></i><i></i><i></i><i></i></div>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <div class="header">
        <div class="container">
            <div class="header-bottom">
                <div class="header-bottom-area align-items-center">

                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{ route('frontend') }}">
                            <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="logo">
                        </a>
                    </div>

                    <!-- Menu -->
                    <ul class="menu">
                        <li><a href="{{ route('frontend') }}">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Ticket <span class="badge badge--sm badge--base text-dark"></span></a></li>
                        <li><a href="#">Faq</a></li>
                        <li>
                            <a href="#0">Pages</a>
                            <ul class="sub-menu">
                                <li><a href="#">User Dashboard</a></li>
                                <li><a href="#">Ticket Details</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Contact</a></li>

                        @guest
                            <li><a href="{{ route('frontend.login') }}">Login</a></li>
                        @endguest

                        @auth
                            <li>
                                <a href="{{ route('frontend.dashboard') }}"
                                   style="
                                        background: rgba(53, 11, 45, 0.9);
                                        padding: 8px 14px;
                                        border-radius: 8px;
                                        color: #fff;
                                        display: inline-block;
                                        font-weight: 600;
                                        letter-spacing: 0.3px;
                                        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                                        transition: all 0.3s ease;
                                   "
                                   onmouseover="this.style.background='rgba(53, 11, 45, 1)'; this.style.transform='translateY(-2px)';"
                                   onmouseout="this.style.background='rgba(53, 11, 45, 0.9)'; this.style.transform='translateY(0)';"
                                >
                                    Dashboard
                                </a>
                            </li>
                        @endauth

                        <button class="btn-close btn-close-white d-lg-none"></button>
                    </ul>

                    <!-- Mobile Trigger -->
                    <div class="header-trigger-wrapper d-flex d-lg-none align-items-center">
                        <div class="header-trigger me-4"><span></span></div>
                        <a href="sign-in.html" class="cmn--btn active btn--md d-none d-sm-block">Sign In</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
