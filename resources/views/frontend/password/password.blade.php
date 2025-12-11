
@extends('frontend.master')

@section('content')

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            {{-- SIDEBAR --}}
            @include('frontend.dashboard.sidebar')

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9">
                <div class="container-fluid py-5">
    <h4 class="mb-4 text-white">Change Password</h4>

    <div class="row">
        <div class="col-12">
            <div class="card bg-dark text-white shadow-sm custom-card">
                <div class="card-body">
                    <form method="POST" action="{{ route('password.change') }}">
                        @csrf

                        <div class="row g-3">

                            {{-- Old Password --}}
                            <div class="col-12 position-relative password-wrapper">
                                <label for="oldPassword" class="form-label">Old Password</label>
                                <input type="password" class="form-control custom-input toggle-input" id="oldPassword" name="old_password" placeholder="Old Password">
                                <span class="password-toggle">
                                    <i class="bi bi-eye-fill"></i>
                                </span>
                                @error('old_password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="col-12 position-relative password-wrapper">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="password" class="form-control custom-input toggle-input" id="newPassword" name="new_password" placeholder="New Password">
                                <span class="password-toggle">
                                    <i class="bi bi-eye-fill"></i>
                                </span>
                                @error('new_password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-12 position-relative password-wrapper">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control custom-input toggle-input" id="confirmPassword" name="new_password_confirmation" placeholder="Confirm Password">
                                <span class="password-toggle">
                                    <i class="bi bi-eye-fill"></i>
                                </span>
                                @error('new_password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning w-100">Update Password</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

            </div>

        </div>
    </div>
</div>

<style>
.custom-card {
    width: 100%;
    padding: 1.5rem;
}

.custom-input {
    width: 100%;
    color: #fff;

    padding-right: 2.8rem;
    transition: border-color 0.3s, box-shadow 0.3s;
    cursor: pointer; /* pointer to indicate clickable */
}

.custom-input:focus {
    border-color: #ffc107;
    color:#b32c2c;
}

.password-toggle {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    font-size: 1.2rem;
    color: rgb(192, 26, 26);
    pointer-events: none; /* so clicks go to input */
    margin-top:16px;
}

.password-toggle i {
    pointer-events: none; /* ignore clicks on icon */
}

.form-label {
    font-weight: 500;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
}
</style>

<script>
document.querySelectorAll('.toggle-input').forEach(input => {
    input.addEventListener('click', function() {
        const icon = this.parentElement.querySelector('i');
        if(this.type === 'password'){
            this.type = 'text';
            icon.classList.replace('bi-eye-fill','bi-eye-slash-fill');
        } else {
            this.type = 'password';
            icon.classList.replace('bi-eye-slash-fill','bi-eye-fill');
        }
    });
});
</script>
@endsection
