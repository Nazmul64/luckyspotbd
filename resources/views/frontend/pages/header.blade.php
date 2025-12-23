<!DOCTYPE html>
<html lang="en">

<head>
          @php
             use App\Models\Setting;
             $setting = Setting::first();
        @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->site_name ?? 'LuckySpotBD' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('uploads/settings/' . ($setting->favicon ?? '')) }}" sizes="16x16">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/lib/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">

    <!-- jQuery + Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('frontend/assets/js/lib/bootstrap.bundle.min.js') }}"></script>

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery first, then Bootstrap JS, then Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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



<!-- HEADER -->
<div class="header">
    <div class="container">
        <div class="header-bottom">
            <div class="header-bottom-area align-items-center">

                <!-- Logo -->
                <div class="logo">
                    <a href="{{ route('frontend') }}">
                        <img src="{{ asset('uploads/settings/' . ($setting->photo ?? '')) }}" alt="logo">
                    </a>
                </div>

                <!-- Menu -->
                <ul class="menu">
                    <li><a href="{{ route('frontend') }}" data-key="home">Home</a></li>
                    <li><a href="#" data-key="about">About</a></li>
                    <li><a href="#" data-key="ticket">Ticket</a></li>
                    <li><a href="#" data-key="faq">Faq</a></li>

                    <li>
                        <a href="#0" data-key="pages">Pages</a>
                        <ul class="sub-menu">
                            <li><a href="#" data-key="user_dashboard">User Dashboard</a></li>
                            <li><a href="#" data-key="ticket_details">Ticket Details</a></li>
                            <li><a href="#" data-key="privacy_policy">Privacy Policy</a></li>
                            <li><a href="#" data-key="terms_conditions">Terms & Conditions</a></li>
                        </ul>
                    </li>

                    <li><a href="#" data-key="contact">Contact</a></li>

                    @guest
                        <li><a href="{{ route('frontend.login') }}" data-key="login">Login</a></li>
                    @endguest

                    @auth
                        <li>
                            <a href="{{ route('frontend.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                    @endauth

                    <!-- Language Switch -->
                    <li>
                        <a href="#0" data-key="languages">Languages</a>
                        <ul class="sub-menu">
                            <a href="javascript:void(0)" id="lang-en">English</a>
                            <a href="javascript:void(0)" id="lang-bn">Bangla</a>
                        </ul>
                    </li>

                    <button class="btn-close btn-close-white d-lg-none"></button>
                </ul>

                <div class="header-trigger-wrapper d-flex d-lg-none align-items-center">
                    <div class="header-trigger me-4"><span></span></div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ================= AJAX LANGUAGE SCRIPT ================= -->
<script>
function loadTexts() {
    $.get("{{ route('language.get_texts') }}", function (res) {
        $('[data-key]').each(function () {
            let key = $(this).data('key');
            if (res[key]) {
                $(this).text(res[key]);
            }
        });
    });
}

function changeLanguage(lang) {
    $.post("{{ route('language.change') }}", {
        _token: $('meta[name="csrf-token"]').attr('content'),
        lang: lang
    }, function () {
        loadTexts();
    });
}

// Initial load
loadTexts();

$('#lang-en').click(function () {
    changeLanguage('en');
});

$('#lang-bn').click(function () {
    changeLanguage('bn');
});
</script>

</body>
</html>
