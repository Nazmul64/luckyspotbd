
<!-- Footer Section Starts Here -->
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
                    <li><a href="{{ url('games') }}">Games</a></li>
                    <li><a href="{{ url('terms-conditions') }}">Terms & Conditions</a></li>
                    <li><a href="{{ url('policy') }}">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
        @php
             use App\Models\Setting;
             $setting = Setting::first();
        @endphp
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
<!-- Footer Section Ends Here -->

<!-- jQuery library -->
<script src="{{ asset('frontend/assets/js/lib/jquery-3.6.0.min.js') }}"></script>
<!-- Bootstrap 5 JS -->
<script src="{{ asset('frontend/assets/js/lib/bootstrap.min.js') }}"></script>
<!-- Plugin Scripts -->
<script src="{{ asset('frontend/assets/js/lib/slick.min.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>

<!-- Cloudflare Insights -->
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
    integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
    data-cf-beacon='{"version":"2024.11.0","token":"0542d18bc5a94bf6b5460f8530f5a523","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}'
    crossorigin="anonymous"></script>

