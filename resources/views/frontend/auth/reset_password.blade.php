@extends('frontend.master')

@section('content')
<div class="auth-bg">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <div class="card auth-card">

                    <div class="card-header text-center bg-transparent border-0 pt-4">
                        <h4 class="fw-bold mb-0 text-white">Reset Password</h4>
                        <p class="text-white-50 small mt-2">Enter your new password</p>
                    </div>

                    <div class="card-body bg-white rounded p-4">

                        @if(session('message'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('password.reset.post') }}" method="POST" id="resetForm">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}" id="tokenField">

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    id="email"
                                    placeholder="Enter your email"
                                    value="{{ old('email', $email ?? '') }}"
                                    required
                                    readonly
                                    style="background-color: #f8f9fa;"
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">New Password</label>
                                <div class="input-group">
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        id="password"
                                        placeholder="Enter new password"
                                        required
                                    >
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-icon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                <div class="input-group">
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control form-control-lg"
                                        id="password_confirmation"
                                        placeholder="Confirm new password"
                                        required
                                    >
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 fw-bold py-2 mb-3">
                                <i class="fas fa-key me-2"></i>Reset Password
                            </button>

                            <div class="text-center">
                                <a href="{{ route('frontend.login') }}" class="text-decoration-none text-primary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Login
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .auth-bg {
        min-height: 100vh;
        background: linear-gradient(135deg, #2b0033, #4b0055, #1a001f);
    }

    .auth-card {
        border-radius: 16px;
        background: transparent;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        border: none;
    }

    .auth-card .form-control:focus {
        border-color: #ffb300;
        box-shadow: 0 0 0 0.2rem rgba(255, 179, 0, 0.25);
    }

    .btn-warning {
        background-color: #ffb300;
        border-color: #ffb300;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #ff9800;
        border-color: #ff9800;
    }

    .input-group .btn-outline-secondary {
        border-color: #ced4da;
    }

    .input-group .btn-outline-secondary:hover {
        background-color: #e9ecef;
    }
</style>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');

    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Debug: Log token value on page load
console.log('Token on page:', document.getElementById('tokenField').value);
</script>
@endsection
