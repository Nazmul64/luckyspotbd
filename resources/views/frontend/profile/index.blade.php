@extends('frontend.master')

@section('content')

@php
    // Fetch active theme colors from database
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#F5CE0D';
    $secondaryColor = $activeTheme->secondary_color ?? '#000000';
@endphp

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            {{-- SIDEBAR --}}
            @include('frontend.dashboard.sidebar')

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9">
                <div style="padding: 40px 30px; background: linear-gradient(135deg, {{ $primaryColor }}10 0%, {{ $secondaryColor }}10 100%); border-radius: 15px; border: 2px solid {{ $primaryColor }}; box-shadow: 0 6px 25px rgba(0,0,0,0.1); margin-top: 20px;">

                    {{-- Header --}}
                    <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid {{ $primaryColor }};">
                        <h4 style="color: {{ $secondaryColor }}; font-weight: bold; font-size: 1.8em; margin: 0;">
                            <i class="fas fa-user-edit" style="color: {{ $primaryColor }}; margin-right: 10px;"></i>
                            Edit Profile
                        </h4>
                    </div>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="success-alert" style="background: linear-gradient(135deg, #28a74520 0%, #28a74530 100%); border-left: 5px solid #28a745; padding: 18px 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);">
                            <div style="display: flex; align-items: center;">
                                <i class="fas fa-check-circle" style="color: #28a745; font-size: 1.5em; margin-right: 12px;"></i>
                                <span style="color: #28a745; font-weight: 600; font-size: 1.05em;">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update', auth()->user()->id) }}" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')

                        <div class="row gy-4">

                            {{-- LEFT AREA - Profile Photo --}}
                            <div class="col-xl-4">
                                <div style="background: linear-gradient(135deg, {{ $primaryColor }}15 0%, {{ $secondaryColor }}15 100%); border: 2px solid {{ $primaryColor }}; border-radius: 15px; padding: 30px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">

                                    {{-- Profile Photo Preview --}}
                                    <div style="margin-bottom: 25px;">
                                        <div style="position: relative; display: inline-block;">
                                            <img id="preview-image"
                                                src="{{ auth()->user()->profile_photo ? asset('uploads/profile/' . auth()->user()->profile_photo) : asset('assets/images/account/user.png') }}"
                                                alt="profile"
                                                style="width: 180px; height: 180px; border-radius: 50%; object-fit: cover; border: 5px solid {{ $primaryColor }}; box-shadow: 0 6px 20px rgba(0,0,0,0.2); transition: all 0.3s ease;">

                                            <div style="position: absolute; bottom: 10px; right: 10px; background-color: {{ $primaryColor }}; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3); cursor: pointer;">
                                                <i class="fas fa-camera" style="color: {{ $secondaryColor }}; font-size: 1.2em;"></i>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- User Info --}}
                                    <div style="margin-bottom: 20px;">
                                        <h4 style="color: {{ $secondaryColor }}; font-weight: bold; font-size: 1.4em; margin-bottom: 5px;">
                                            {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                                        </h4>
                                        <p style="color: {{ $primaryColor }}; font-size: 0.95em; margin: 0; font-weight: 600;">
                                            <i class="fas fa-at"></i> {{ auth()->user()->username }}
                                        </p>
                                    </div>

                                    {{-- Upload Button --}}
                                    <input type="file" name="profile_photo" class="d-none" id="update-photo" accept="image/*">
                                    <label class="upload-btn" for="update-photo"
                                           style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $primaryColor }}dd 100%); color: {{ $secondaryColor }}; padding: 12px 30px; border-radius: 25px; font-weight: 600; cursor: pointer; display: inline-block; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2); border: none;">
                                        <i class="fas fa-upload"></i> Upload Photo
                                    </label>

                                    {{-- Additional Info --}}
                                    <div style="margin-top: 25px; padding: 15px; background-color: {{ $primaryColor }}10; border-radius: 10px;">
                                        <p style="color: {{ $secondaryColor }}; opacity: 0.7; font-size: 0.85em; margin: 0; line-height: 1.6;">
                                            <i class="fas fa-info-circle" style="color: {{ $primaryColor }};"></i>
                                            Recommended: Square image (500x500px) for best results
                                        </p>
                                    </div>

                                </div>
                            </div>

                            {{-- RIGHT AREA - Profile Form --}}
                            <div class="col-xl-8">
                                <div style="background: linear-gradient(135deg, {{ $primaryColor }}08 0%, {{ $secondaryColor }}08 100%); border: 2px solid {{ $primaryColor }}; border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">

                                    <div class="row gy-4">

                                        {{-- First Name --}}
                                        <div class="col-md-6">
                                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 8px; font-size: 0.95em;">
                                                <i class="fas fa-user" style="color: {{ $primaryColor }}; margin-right: 5px;"></i>
                                                First Name
                                            </label>
                                            <input type="text"
                                                   name="first_name"
                                                   value="{{ auth()->user()->first_name }}"
                                                   class="form-input"
                                                   placeholder="Enter first name"
                                                   style="width: 100%; padding: 12px 18px; border: 2px solid {{ $primaryColor }}50; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease;">
                                        </div>

                                        {{-- Last Name --}}
                                        <div class="col-md-6">
                                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 8px; font-size: 0.95em;">
                                                <i class="fas fa-user" style="color: {{ $primaryColor }}; margin-right: 5px;"></i>
                                                Last Name
                                            </label>
                                            <input type="text"
                                                   name="last_name"
                                                   value="{{ auth()->user()->last_name }}"
                                                   class="form-input"
                                                   placeholder="Enter last name"
                                                   style="width: 100%; padding: 12px 18px; border: 2px solid {{ $primaryColor }}50; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease;">
                                        </div>

                                        {{-- Username --}}
                                        <div class="col-md-6">
                                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 8px; font-size: 0.95em;">
                                                <i class="fas fa-at" style="color: {{ $primaryColor }}; margin-right: 5px;"></i>
                                                Username
                                            </label>
                                            <input type="text"
                                                   name="username"
                                                   value="{{ auth()->user()->username }}"
                                                   class="form-input"
                                                   placeholder="Enter username"
                                                   style="width: 100%; padding: 12px 18px; border: 2px solid {{ $primaryColor }}50; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease;">
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-md-6">
                                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 8px; font-size: 0.95em;">
                                                <i class="fas fa-envelope" style="color: {{ $primaryColor }}; margin-right: 5px;"></i>
                                                Email
                                            </label>
                                            <input type="email"
                                                   name="email"
                                                   value="{{ auth()->user()->email }}"
                                                   class="form-input"
                                                   placeholder="Enter email"
                                                   style="width: 100%; padding: 12px 18px; border: 2px solid {{ $primaryColor }}50; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease;">
                                        </div>

                                        {{-- Country --}}
                                        <div class="col-md-6">
                                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 8px; font-size: 0.95em;">
                                                <i class="fas fa-globe" style="color: {{ $primaryColor }}; margin-right: 5px;"></i>
                                                Country
                                            </label>
                                            <select name="country"
                                                    class="form-select"
                                                    style="width: 100%; padding: 12px 18px; border: 2px solid {{ $primaryColor }}50; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease; cursor: pointer;">
                                                <option value="Bangladesh" {{ auth()->user()->country == 'Bangladesh' ? 'selected' : '' }}>🇧🇩 Bangladesh</option>
                                                <option value="India" {{ auth()->user()->country == 'India' ? 'selected' : '' }}>🇮🇳 India</option>
                                                <option value="Pakistan" {{ auth()->user()->country == 'Pakistan' ? 'selected' : '' }}>🇵🇰 Pakistan</option>
                                                <option value="Other" {{ auth()->user()->country == 'Other' ? 'selected' : '' }}>🌍 Other</option>
                                            </select>
                                        </div>

                                        {{-- Phone --}}
                                        <div class="col-md-6">
                                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 8px; font-size: 0.95em;">
                                                <i class="fas fa-phone" style="color: {{ $primaryColor }}; margin-right: 5px;"></i>
                                                Phone
                                            </label>
                                            <input type="text"
                                                   name="number"
                                                   value="{{ auth()->user()->number }}"
                                                   class="form-input"
                                                   placeholder="Enter phone number"
                                                   style="width: 100%; padding: 12px 18px; border: 2px solid {{ $primaryColor }}50; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease;">
                                        </div>

                                        {{-- Address --}}
                                        <div class="col-md-6">
                                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 8px; font-size: 0.95em;">
                                                <i class="fas fa-map-marker-alt" style="color: {{ $primaryColor }}; margin-right: 5px;"></i>
                                                Address
                                            </label>
                                            <input type="text"
                                                   name="address"
                                                   value="{{ auth()->user()->address }}"
                                                   class="form-input"
                                                   placeholder="Enter address"
                                                   style="width: 100%; padding: 12px 18px; border: 2px solid {{ $primaryColor }}50; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease;">
                                        </div>

                                        {{-- Zip Code --}}
                                        <div class="col-md-6">
                                            <label style="display: block; color: {{ $secondaryColor }}; font-weight: 600; margin-bottom: 8px; font-size: 0.95em;">
                                                <i class="fas fa-mail-bulk" style="color: {{ $primaryColor }}; margin-right: 5px;"></i>
                                                Zip Code
                                            </label>
                                            <input type="text"
                                                   name="zip_code"
                                                   value="{{ auth()->user()->zip_code }}"
                                                   class="form-input"
                                                   placeholder="Enter zip code"
                                                   style="width: 100%; padding: 12px 18px; border: 2px solid {{ $primaryColor }}50; border-radius: 8px; font-size: 0.95em; color: {{ $secondaryColor }}; background-color: white; transition: all 0.3s ease;">
                                        </div>

                                        {{-- Submit Button --}}
                                        <div class="col-md-12">
                                            <button type="submit"
                                                    class="submit-btn"
                                                    style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $primaryColor }}dd 100%); color: {{ $secondaryColor }}; border: none; padding: 15px 40px; border-radius: 10px; font-size: 1.05em; font-weight: bold; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(0,0,0,0.2); width: 100%; margin-top: 10px;">
                                                <i class="fas fa-save"></i> Update Profile
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </form>

                    {{-- Security Tips --}}
                    <div style="margin-top: 30px; padding: 20px; background-color: {{ $secondaryColor }}05; border-radius: 10px; border: 1px solid {{ $primaryColor }}30;">
                        <h6 style="color: {{ $secondaryColor }}; font-weight: bold; margin-bottom: 12px;">
                            <i class="fas fa-shield-alt" style="color: {{ $primaryColor }};"></i> Security Tips
                        </h6>
                        <ul style="margin: 0; padding-left: 20px; color: {{ $secondaryColor }}; opacity: 0.8; line-height: 1.8; font-size: 0.9em;">
                            <li>Keep your email address up to date for account recovery</li>
                            <li>Use a strong and unique password for your account</li>
                            <li>Never share your login credentials with anyone</li>
                            <li>Review your profile information regularly</li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    const primaryColor = '{{ $primaryColor }}';
    const secondaryColor = '{{ $secondaryColor }}';

    document.addEventListener('DOMContentLoaded', function () {

        // ============================================
        // LIVE IMAGE PREVIEW
        // ============================================
        const photoInput = document.getElementById('update-photo');
        const previewImage = document.getElementById('preview-image');

        if (photoInput && previewImage) {
            photoInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function(event) {
                        previewImage.src = event.target.result;

                        // Add animation
                        previewImage.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            previewImage.style.transform = 'scale(1)';
                        }, 100);
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // ============================================
        // IMAGE HOVER EFFECT
        // ============================================
        if (previewImage) {
            previewImage.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
                this.style.boxShadow = '0 8px 30px rgba(0,0,0,0.3)';
            });

            previewImage.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.2)';
            });
        }

        // ============================================
        // INPUT FOCUS EFFECTS
        // ============================================
        const formInputs = document.querySelectorAll('.form-input, .form-select');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = primaryColor;
                this.style.boxShadow = `0 0 0 4px ${primaryColor}20`;
                this.style.transform = 'scale(1.01)';
            });

            input.addEventListener('blur', function() {
                this.style.borderColor = primaryColor + '50';
                this.style.boxShadow = 'none';
                this.style.transform = 'scale(1)';
            });
        });

        // ============================================
        // BUTTON HOVER EFFECTS
        // ============================================
        const submitBtn = document.querySelector('.submit-btn');
        if (submitBtn) {
            submitBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 8px 30px rgba(0,0,0,0.3)';
                this.style.opacity = '0.95';
            });

            submitBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.2)';
                this.style.opacity = '1';
            });
        }

        const uploadBtn = document.querySelector('.upload-btn');
        if (uploadBtn) {
            uploadBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
                this.style.boxShadow = '0 6px 25px rgba(0,0,0,0.3)';
            });

            uploadBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
            });
        }

        // ============================================
        // FORM VALIDATION
        // ============================================
        const form = document.getElementById('profileForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const firstName = document.querySelector('input[name="first_name"]');
                const lastName = document.querySelector('input[name="last_name"]');
                const email = document.querySelector('input[name="email"]');

                let isValid = true;
                let errorMessage = '';

                // Validate first name
                if (!firstName || !firstName.value.trim()) {
                    isValid = false;
                    errorMessage = 'First name is required!';
                    if (firstName) {
                        firstName.style.borderColor = '#dc3545';
                        firstName.focus();
                    }
                }

                // Validate last name
                if (isValid && (!lastName || !lastName.value.trim())) {
                    isValid = false;
                    errorMessage = 'Last name is required!';
                    if (lastName) {
                        lastName.style.borderColor = '#dc3545';
                        lastName.focus();
                    }
                }

                // Validate email
                if (isValid && (!email || !email.value.trim())) {
                    isValid = false;
                    errorMessage = 'Email is required!';
                    if (email) {
                        email.style.borderColor = '#dc3545';
                        email.focus();
                    }
                } else if (isValid && email && !isValidEmail(email.value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address!';
                    email.style.borderColor = '#dc3545';
                    email.focus();
                }

                if (!isValid) {
                    e.preventDefault();
                    showError(errorMessage);
                    return false;
                }

                // Show loading state
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.7';
                }
            });
        }

        // ============================================
        // HELPER FUNCTIONS
        // ============================================
        function isValidEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function showError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.style.cssText = `
                background: linear-gradient(135deg, #dc354520 0%, #dc354530 100%);
                border-left: 5px solid #dc3545;
                padding: 18px 20px;
                border-radius: 10px;
                margin-bottom: 20px;
                box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
                display: flex;
                align-items: center;
            `;
            errorDiv.innerHTML = `
                <i class="fas fa-exclamation-circle" style="color: #dc3545; font-size: 1.5em; margin-right: 12px;"></i>
                <span style="color: #dc3545; font-weight: 600; font-size: 1.05em;">${message}</span>
            `;

            const form = document.getElementById('profileForm');
            const existingError = document.querySelector('.error-alert');
            if (existingError) {
                existingError.remove();
            }

            errorDiv.className = 'error-alert';
            form.insertBefore(errorDiv, form.firstChild);

            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }

        // ============================================
        // AUTO-DISMISS SUCCESS MESSAGE
        // ============================================
        setTimeout(() => {
            const successAlert = document.querySelector('.success-alert');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }
        }, 5000);

        // ============================================
        // RESET BORDER COLOR ON INPUT
        // ============================================
        const allInputs = document.querySelectorAll('input, select');
        allInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.style.borderColor = primaryColor + '50';
            });
        });

        console.log('👤 Profile Edit Page Initialized');
        console.log('Theme Colors:', { primary: primaryColor, secondary: secondaryColor });
    });
})();
</script>

@endsection
