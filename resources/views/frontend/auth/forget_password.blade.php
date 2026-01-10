@extends('frontend.master')

@section('content')
<div class="auth-bg">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card auth-card">

                    <div class="card-header text-center bg-transparent border-0 pt-4">
                        <h4 class="fw-bold mb-0 text-white">Forgot Password</h4>
                        <p class="text-white-50 small mt-2">Enter your email to receive reset link</p>
                    </div>

                    <div class="card-body bg-white rounded p-4">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('password.forget.post') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Email Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    placeholder="Enter your email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-warning w-100 fw-bold py-2 mb-3">
                                <i class="fas fa-paper-plane me-2"></i>Send Reset Link
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
        color: #000;
    }
</style>
@endsection
