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


</head>
    <body data-bs-spy="scroll" data-bs-offset="170" data-bs-target=".privacy-policy-sidebar-menu">

        <div class="overlay"></div>
        <div class="preloader">
            <div class="scene" id="scene">
                <input type="checkbox" id="andicator" />
                <div class="cube">
                    <div class="cube__face cube__face--front"><i></i></div>
                    <div class="cube__face cube__face--back"><i></i><i></i></div>
                    <div class="cube__face cube__face--right">
                        <i></i> <i></i> <i></i> <i></i> <i></i>
                    </div>
                    <div class="cube__face cube__face--left">
                        <i></i> <i></i> <i></i> <i></i> <i></i> <i></i>
                    </div>
                    <div class="cube__face cube__face--top">
                        <i></i> <i></i> <i></i>
                    </div>
                    <div class="cube__face cube__face--bottom">
                        <i></i> <i></i> <i></i> <i></i>
                    </div>
                </div>
            </div>
        </div>

    <div class="header">
    <div class="container">
        <div class="header-bottom">
            <div class="header-bottom-area align-items-center">
                <div class="logo"><a href="index.html"><img src="assets/images/logo.png" alt="logo"></a></div>
                <ul class="menu">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="about.html">About</a>
                    </li>
                    <li>
                        <a href="games.html">Games <span class="badge badge--sm badge--base text-dark">NEW</span></a>
                    </li>
                    <li>
                        <a href="faq.html">Faq</a>
                    </li>
                    <li>
                        <a href="#0">Pages</a>
                        <ul class="sub-menu">
                            <li>
                                <a href="dashboard.html">User Dashboard</a>
                            </li>
                            <li>
                                <a href="game-details.html">Game Details</a>
                            </li>
                            <li>
                                <a href="policy.html">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="terms-conditions.html">Terms & Conditions</a>
                            </li>
                            <li>
                                <a href="sign-in.html">Sign In</a>
                            </li>
                            <li>
                                <a href="sign-up.html">Sign Up</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#0">Blog</a>
                        <ul class="sub-menu">
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="blog-details.html">Blog Details</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="contact.html">Contact</a>
                    </li>
                    <button class="btn-close btn-close-white d-lg-none"></button>
                </ul>
                <div class="header-trigger-wrapper d-flex d-lg-none align-items-center">
                    <div class="header-trigger me-4">
                        <span></span>
                    </div>
                    <a href="sign-in.html" class="cmn--btn active btn--md d-none d-sm-block">Sign In</a>
                </div>
            </div>
        </div>
    </div>
</div>
