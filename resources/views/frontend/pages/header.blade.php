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
    <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>

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
                    <li><a href="#">{{ trans_db('nav_about','About') }}</a></li>
                    <li><a href="#">{{ trans_db('nav_ticket','Ticket') }}</a></li>
                    <li><a href="#">{{ trans_db('nav_faq','FAQ') }}</a></li>

                    {{-- Pages --}}
                    <li>
                        <a href="#0">{{ trans_db('nav_pages','Pages') }}</a>
                        <ul class="sub-menu">
                            <li><a href="#">{{ trans_db('nav_user_dashboard','User Dashboard') }}</a></li>
                            <li><a href="#">{{ trans_db('nav_ticket_details','Ticket Details') }}</a></li>
                            <li><a href="#">{{ trans_db('nav_privacy_policy','Privacy Policy') }}</a></li>
                            <li><a href="#">{{ trans_db('nav_terms_conditions','Terms & Conditions') }}</a></li>
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

{{-- ================= FOOTER ================= --}}
<footer>
    {{-- footer content --}}
</footer>

{{-- ================= JS ================= --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('frontend/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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

    // Loading indicator
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

                // ✅ Page reload করুন নতুন language load করতে
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            } else {
                toastr.error(res.message || 'Failed to change language');
            }
        },
        error: function (xhr) {
            console.error('Language change error:', xhr);

            if (xhr.status === 419) {
                toastr.error('Session expired. Reloading page...');
                setTimeout(() => window.location.reload(), 1000);
            } else if (xhr.status === 500) {
                toastr.error('Server error. Please try again.');
            } else {
                toastr.error('Failed to change language');
            }
        }
    });
}

// ✅ Page load এ current language log করুন (debugging)
console.log('Current Locale:', "{{ app()->getLocale() }}");
</script>
</body>
</html>
