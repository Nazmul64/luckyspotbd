<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @php
        use App\Models\Setting;
        $setting = Setting::first();
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $setting->site_name ?? 'LuckySpotBD' }}</title>

    {{-- Favicon --}}
    @if(!empty($setting->favicon))
        <link rel="icon" type="image/png"
              href="{{ asset('uploads/settings/' . $setting->favicon) }}">
    @endif

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/lib/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">

    {{-- Icons & Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.min.css') }}">
</head>

<body>

{{-- ================= HEADER ================= --}}
<header class="header">
    <div class="container">
        <div class="header-bottom">
            <div class="header-bottom-area align-items-center">

                {{-- Logo --}}
                <div class="logo">
                    <a href="{{ route('frontend') }}">
                        <img src="{{ asset('uploads/settings/' . ($setting->photo ?? '')) }}"
                             alt="{{ $setting->site_name ?? 'Logo' }}">
                    </a>
                </div>

                {{-- Navigation --}}
                <ul class="menu">
                    <li><a href="{{ route('frontend') }}">{{ trans_db('nav_home','Home') }}</a></li>
                    <li><a href="#about">{{ trans_db('nav_about','About') }}</a></li>
                    <li><a href="#ticket">{{ trans_db('nav_ticket','Ticket') }}</a></li>
                    <li><a href="#faq">{{ trans_db('nav_faq','FAQ') }}</a></li>

                    {{-- Pages --}}
                    <li>
                        <a href="#0">{{ trans_db('nav_pages','Pages') }}</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('privacy.pages') }}">{{ trans_db('nav_privacy_policy','Privacy Policy') }}</a></li>
                            <li><a href="{{ route('trmsandcondation') }}">{{ trans_db('trmsandcondation','Terms & Conditions') }}</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ route('contact.pages') }}">{{ trans_db('nav_contact','contact') }}</a></li>

                    @guest
                        <li><a href="{{ route('frontend.login') }}">{{ trans_db('nav_login','Login') }}</a></li>
                    @endguest

                    @auth
                        <li><a href="{{ route('frontend.dashboard') }}">{{ trans_db('nav_dashboard','Dashboard') }}</a></li>
                    @endauth

                    {{-- Language Switch --}}
                    <li>
                        <a href="#0">
                            {{ trans_db('nav_languages','Languages') }}
                            <i class="bi bi-translate ms-1"></i>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="javascript:void(0)"
                                   onclick="changeLanguage('en')"
                                   class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">
                                    🇬🇧 English
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                   onclick="changeLanguage('bn')"
                                   class="{{ app()->getLocale() === 'bn' ? 'active' : '' }}">
                                    🇧🇩 বাংলা
                                </a>
                            </li>
                        </ul>
                    </li>

                    <button class="btn-close btn-close-white d-lg-none"></button>
                </ul>

                {{-- Mobile Toggle --}}
                <div class="header-trigger-wrapper d-flex d-lg-none align-items-center">
                    <div class="header-trigger me-4"><span></span></div>
                </div>

            </div>
        </div>
    </div>
</header>

{{-- ================= CONTENT ================= --}}
<main>
    @yield('content')
</main>

{{-- ================= CHAT WIDGET ================= --}}
@include('frontend.pages.chat_widget')

{{-- ================= FOOTER ================= --}}
<footer class="footer-section bg_img" style="background: url({{ asset('frontend/assets/images/footer/bg.jpg') }}) center;">
    <div class="footer-top">
        <div class="container">
            <div class="footer-wrapper d-flex flex-wrap align-items-center justify-content-md-between justify-content-center">
                <div class="logo mb-3 mb-md-0">
                    <a href="{{ route('frontend') }}">
                        <img src="{{ asset('frontend/assets/images/logo.png') }}" alt="logo">
                    </a>
                </div>
                 <ul class="footer-links d-flex flex-wrap justify-content-center">
                    <li><a href="#ticket">Ticket</a></li>
                    <li><a href="{{route('trmsandcondation') }}">Terms & Conditions</a></li>
                    <li><a href="{{ route('privacy.pages') }}">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-wrapper d-flex flex-wrap justify-content-center align-items-center text-center">
                <p class="copyright text-white">
                    Copyrights &copy; {{ date('Y') }} All Rights Reserved by
                    <a href="#0" class="text--base ms-2">{{ $setting->site_name ?? 'LuckySpotBD' }}</a>
                </p>
            </div>
        </div>
    </div>

    <div class="shapes">
        <img src="{{ asset('uploads/settings/' . ($setting->photo ?? '')) }}" alt="footer" class="shape1">
    </div>
</footer>

{{-- ================= JS ================= --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('frontend/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/lib/slick.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>

<script>
/* ---------- Toastr Config ---------- */
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: 3000,
};

/* ---------- Session Alerts ---------- */
@foreach (['success','error','warning','info'] as $msg)
    @if(Session::has($msg))
        toastr["{{ $msg }}"]("{{ Session::get($msg) }}");
    @endif
@endforeach

/* ---------- Language Switch ---------- */
function changeLanguage(lang) {
    const currentLang = "{{ app()->getLocale() }}";

    if (lang === currentLang) {
        toastr.info(lang === 'en' ? 'Already in English' : 'ইতিমধ্যে বাংলায় আছে');
        return;
    }

    toastr.info(lang === 'en' ? 'Changing to English...' : 'বাংলায় পরিবর্তন হচ্ছে...');

    $.ajax({
        url: "{{ route('language.change') }}",
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            lang: lang
        },
        success: function (res) {
            if (res.status) {
                toastr.success(res.message);
                setTimeout(() => window.location.reload(), 800);
            } else {
                toastr.error(res.message || 'Failed to change language');
            }
        },
        error: function (xhr) {
            console.error('Language change error:', xhr);
            if (xhr.status === 419) {
                toastr.error('Session expired. Reloading page...');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                toastr.error('Failed to change language');
            }
        }
    });
}

console.log('Current Locale:', "{{ app()->getLocale() }}");
</script>

</body>
</html>
