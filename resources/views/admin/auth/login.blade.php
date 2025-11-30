<!doctype html>
<html lang="en" class="semi-dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LuckySpotBD Admin Login</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('admin/assets/images/favicon-32x32.png') }}" type="image/png" />

    <!-- Plugins CSS -->
    <link href="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Loader CSS -->
    <link href="{{ asset('admin/assets/css/pace.min.css') }}" rel="stylesheet" />

    <!-- Theme Styles -->
    <link href="{{ asset('admin/assets/css/dark-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/light-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/semi-dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/header-colors.css') }}" rel="stylesheet" />
</head>

<body>
<div class="wrapper">
    <main class="authentication-content">
        <div class="container">
            <div class="mt-4">
                <div class="card rounded-0 overflow-hidden shadow-none border mb-5 mb-lg-0">
                    <div class="row g-0">
                        <div class="col-12 col-xl-8 d-flex align-items-center justify-content-center border-end">
                            <img src="{{ asset('admin/assets/images/error/auth-img-7.png') }}" class="img-fluid" alt="Authentication Image">
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="card-body p-4 p-sm-5">
                                <h5 class="card-title mb-4">Sign In</h5>

                                <!-- Display Validation Errors -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('admin.login.submit') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="position-relative">
                                            <div class="position-absolute top-50 translate-middle-y ps-3"><i class="bi bi-envelope-fill"></i></div>
                                            <input type="email" class="form-control ps-5" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="position-relative">
                                            <div class="position-absolute top-50 translate-middle-y ps-3"><i class="bi bi-lock-fill"></i></div>
                                            <input type="password" class="form-control ps-5" id="password" name="password" placeholder="Password" required>
                                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword()">Show</button>
                                        </div>
                                    </div>

                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Remember Me</label>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Sign In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/app.js') }}"></script>

<script>
    function togglePassword() {
        var passwordField = document.getElementById('password');
        var btn = event.currentTarget;
        if (passwordField.type === "password") {
            passwordField.type = "text";
            btn.innerText = "Hide";
        } else {
            passwordField.type = "password";
            btn.innerText = "Show";
        }
    }
</script>

</body>
</html>
