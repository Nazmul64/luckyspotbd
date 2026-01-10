@extends('frontend.master')

@section('content')

@php
    // ============================================
    // THEME CONFIGURATION
    // ============================================
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#F5CE0D';
    $secondaryColor = $activeTheme->secondary_color ?? '#000000';
    $user = auth()->user();

    // ============================================
    // LANGUAGE DETECTION
    // ============================================
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

    // ============================================
    // TRANSLATIONS
    // ============================================
    $translations = [
        'en' => [
            'page_title' => 'Edit Profile',
            'upload_photo' => 'Upload Photo',
            'photo_note' => 'Recommended size: 500×500px',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'zip_code' => 'Zip Code',
            'country' => 'Country',
            'update_profile' => 'Update Profile',
            'security_tips' => 'Security Tips',
            'tip_1' => 'Keep your email updated',
            'tip_2' => 'Use strong password',
            'tip_3' => 'Never share login details',
            'tip_4' => 'Review profile regularly',
            'countries' => [
                'Bangladesh' => 'Bangladesh',
                'India' => 'India',
                'Pakistan' => 'Pakistan',
                'Other' => 'Other',
            ],
            // Validation messages
            'first_name_required' => 'First name is required',
            'last_name_required' => 'Last name is required',
            'username_required' => 'Username is required',
            'email_invalid' => 'Please enter a valid email address',
            'phone_invalid' => 'Phone number is not valid',
            'image_invalid' => 'Please select a valid image file',
            'updating' => 'Updating...',
            'success' => 'Profile updated successfully!',
        ],
        'bn' => [
            'page_title' => 'প্রোফাইল সম্পাদনা',
            'upload_photo' => 'ছবি আপলোড করুন',
            'photo_note' => 'প্রস্তাবিত সাইজ: ৫০০×৫০০px',
            'first_name' => 'প্রথম নাম',
            'last_name' => 'শেষ নাম',
            'username' => 'ইউজারনেম',
            'email' => 'ইমেইল',
            'phone' => 'ফোন',
            'address' => 'ঠিকানা',
            'zip_code' => 'জিপ কোড',
            'country' => 'দেশ',
            'update_profile' => 'প্রোফাইল আপডেট করুন',
            'security_tips' => 'নিরাপত্তা টিপস',
            'tip_1' => 'আপনার ইমেইল আপডেট রাখুন',
            'tip_2' => 'শক্তিশালী পাসওয়ার্ড ব্যবহার করুন',
            'tip_3' => 'লগইন তথ্য কখনো শেয়ার করবেন না',
            'tip_4' => 'নিয়মিত প্রোফাইল পর্যালোচনা করুন',
            'countries' => [
                'Bangladesh' => 'বাংলাদেশ',
                'India' => 'ভারত',
                'Pakistan' => 'পাকিস্তান',
                'Other' => 'অন্যান্য',
            ],
            // Validation messages
            'first_name_required' => 'প্রথম নাম প্রয়োজন',
            'last_name_required' => 'শেষ নাম প্রয়োজন',
            'username_required' => 'ইউজারনেম প্রয়োজন',
            'email_invalid' => 'সঠিক ইমেইল ঠিকানা লিখুন',
            'phone_invalid' => 'ফোন নম্বর সঠিক নয়',
            'image_invalid' => 'সঠিক ছবি ফাইল নির্বাচন করুন',
            'updating' => 'আপডেট হচ্ছে...',
            'success' => 'প্রোফাইল সফলভাবে আপডেট হয়েছে!',
        ],
    ];

    $lang = $translations[$isBangla ? 'bn' : 'en'];
@endphp

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            {{-- SIDEBAR --}}
            @include('frontend.dashboard.sidebar')

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9">
                <div class="profile-wrapper">

                    {{-- HEADER --}}
                    <div class="profile-header">
                        <h4>
                            <i class="fas fa-user-edit"></i> {{ $lang['page_title'] }}
                        </h4>
                    </div>

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                        <div class="alert-success-box success-alert">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <form id="profileForm"
                          action="{{ route('profile.update', $user->id) }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row gy-4">

                            {{-- PROFILE PHOTO --}}
                            <div class="col-xl-4">
                                <div class="profile-photo-box">

                                    <div class="photo-preview">
                                        <img id="preview-image"
                                             src="{{ $user->profile_photo ? asset('uploads/profile/'.$user->profile_photo) : asset('assets/images/account/user.png') }}"
                                             alt="Profile">
                                        <span class="camera-icon">
                                            <i class="fas fa-camera"></i>
                                        </span>
                                    </div>

                                    <h5>{{ $user->first_name }} {{ $user->last_name }}</h5>
                                    <p>@{{ $user->username }}</p>

                                    <input type="file" name="profile_photo" id="update-photo" hidden accept="image/*">

                                    <label for="update-photo" class="btn-upload">
                                        <i class="fas fa-upload"></i> {{ $lang['upload_photo'] }}
                                    </label>

                                    <small class="photo-note">
                                        {{ $lang['photo_note'] }}
                                    </small>
                                </div>
                            </div>

                            {{-- PROFILE FORM --}}
                            <div class="col-xl-8">
                                <div class="profile-form-box">
                                    <div class="row gy-4">

                                        @php
                                            $fields = [
                                                ['first_name', $lang['first_name'], 'user', 'text'],
                                                ['last_name', $lang['last_name'], 'user', 'text'],
                                                ['username', $lang['username'], 'at', 'text'],
                                                ['email', $lang['email'], 'envelope', 'email'],
                                                ['number', $lang['phone'], 'phone', 'text'],
                                                ['address', $lang['address'], 'map-marker-alt', 'text'],
                                                ['zip_code', $lang['zip_code'], 'mail-bulk', 'text'],
                                            ];
                                        @endphp

                                        @foreach($fields as $field)
                                            <div class="col-md-6">
                                                <label>
                                                    <i class="fas fa-{{ $field[2] }}"></i>
                                                    {{ $field[1] }}
                                                </label>
                                                <input type="{{ $field[3] }}"
                                                       name="{{ $field[0] }}"
                                                       value="{{ $user->{$field[0]} }}"
                                                       class="form-input">
                                            </div>
                                        @endforeach

                                        {{-- COUNTRY --}}
                                        <div class="col-md-6">
                                            <label>
                                                <i class="fas fa-globe"></i> {{ $lang['country'] }}
                                            </label>
                                            <select name="country" class="form-select">
                                                @foreach(['Bangladesh','India','Pakistan','Other'] as $country)
                                                    <option value="{{ $country }}" {{ $user->country == $country ? 'selected' : '' }}>
                                                        {{ $lang['countries'][$country] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- SUBMIT --}}
                                        <div class="col-12">
                                            <button type="submit" class="btn-submit">
                                                <i class="fas fa-save"></i> {{ $lang['update_profile'] }}
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                    {{-- SECURITY INFO --}}
                    <div class="security-box">
                        <h6><i class="fas fa-shield-alt"></i> {{ $lang['security_tips'] }}</h6>
                        <ul>
                            <li>{{ $lang['tip_1'] }}</li>
                            <li>{{ $lang['tip_2'] }}</li>
                            <li>{{ $lang['tip_3'] }}</li>
                            <li>{{ $lang['tip_4'] }}</li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- ===================== STYLES ===================== --}}
<style>
:root {
    --primary: {{ $primaryColor }};
    --secondary: {{ $secondaryColor }};
}

.profile-wrapper {
    padding: 40px;
    background: linear-gradient(135deg, {{ $primaryColor }}10, {{ $secondaryColor }}10);
    border: 2px solid var(--primary);
    border-radius: 15px;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.profile-header h4 {
    font-weight: 700;
    border-bottom: 3px solid var(--primary);
    padding-bottom: 15px;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.profile-photo-box {
    text-align: center;
    border: 2px solid var(--primary);
    padding: 30px;
    border-radius: 15px;
    background: #fff;
}

.profile-photo-box h5,
.profile-photo-box p {
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.photo-preview {
    position: relative;
    display: inline-block;
    margin-bottom: 20px;
}

.photo-preview img {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid var(--primary);
    transition: transform 0.3s ease;
}

.photo-preview:hover img {
    transform: scale(1.05);
}

.camera-icon {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: var(--primary);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--secondary);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.btn-upload,
.btn-submit {
    background: var(--primary);
    color: var(--secondary);
    border: none;
    padding: 12px 30px;
    border-radius: 10px;
    font-weight: 600;
    width: 100%;
    cursor: pointer;
    transition: all 0.3s ease;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.btn-upload:hover,
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.photo-note {
    display: block;
    margin-top: 10px;
    color: #666;
    font-size: 0.85rem;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.profile-form-box {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    border: 2px solid {{ $primaryColor }}30;
}

.profile-form-box label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.profile-form-box label i {
    color: var(--primary);
    margin-right: 6px;
}

.form-input,
.form-select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid {{ $primaryColor }}50;
    border-radius: 8px;
    transition: all 0.3s ease;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px {{ $primaryColor }}20;
}

.alert-success-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #28a74520;
    border-left: 5px solid #28a745;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    transition: opacity 0.5s ease;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.security-box {
    margin-top: 30px;
    padding: 20px;
    border: 2px solid {{ $primaryColor }}40;
    border-radius: 10px;
    background: #fff;
}

.security-box h6 {
    margin-bottom: 15px;
    color: var(--primary);
    font-weight: 700;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.security-box ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.security-box ul li {
    padding: 8px 0;
    padding-left: 25px;
    position: relative;
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

.security-box ul li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: #28a745;
    font-weight: bold;
}

@media (max-width: 768px) {
    .profile-wrapper {
        padding: 20px;
    }

    .profile-form-box {
        padding: 20px;
    }
}
</style>

<script>
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {

        /* =============================
           CONFIGURATION
        ============================== */
        const isBangla = {{ $isBangla ? 'true' : 'false' }};
        const messages = {
            firstNameRequired: '{{ $lang["first_name_required"] }}',
            lastNameRequired: '{{ $lang["last_name_required"] }}',
            usernameRequired: '{{ $lang["username_required"] }}',
            emailInvalid: '{{ $lang["email_invalid"] }}',
            phoneInvalid: '{{ $lang["phone_invalid"] }}',
            imageInvalid: '{{ $lang["image_invalid"] }}',
            updating: '{{ $lang["updating"] }}'
        };

        /* =============================
           ELEMENTS
        ============================== */
        const form = document.getElementById('profileForm');
        const photoInput = document.getElementById('update-photo');
        const previewImg = document.getElementById('preview-image');
        const submitBtn = document.querySelector('.btn-submit');
        const successBox = document.querySelector('.success-alert');

        /* =============================
           PROFILE PHOTO PREVIEW
        ============================== */
        if (photoInput && previewImg) {
            photoInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const file = this.files[0];

                    if (!file.type.startsWith('image/')) {
                        alert(messages.imageInvalid);
                        this.value = '';
                        return;
                    }

                    // Check file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert(isBangla ? 'ফাইল সাইজ ৫MB এর কম হতে হবে' : 'File size must be less than 5MB');
                        this.value = '';
                        return;
                    }

                    previewImg.src = URL.createObjectURL(file);
                }
            });
        }

        /* =============================
           FORM VALIDATION
        ============================== */
        if (form) {
            form.addEventListener('submit', function (e) {

                let isValid = true;
                let message = '';

                const firstName = form.querySelector('[name="first_name"]');
                const lastName = form.querySelector('[name="last_name"]');
                const username = form.querySelector('[name="username"]');
                const email = form.querySelector('[name="email"]');
                const phone = form.querySelector('[name="number"]');

                /* Required fields */
                if (!firstName.value.trim()) {
                    isValid = false;
                    message = messages.firstNameRequired;
                    firstName.focus();
                }
                else if (!lastName.value.trim()) {
                    isValid = false;
                    message = messages.lastNameRequired;
                    lastName.focus();
                }
                else if (!username.value.trim()) {
                    isValid = false;
                    message = messages.usernameRequired;
                    username.focus();
                }
                /* Email validation */
                else if (!validateEmail(email.value)) {
                    isValid = false;
                    message = messages.emailInvalid;
                    email.focus();
                }
                /* Phone validation */
                else if (phone.value && phone.value.length < 8) {
                    isValid = false;
                    message = messages.phoneInvalid;
                    phone.focus();
                }

                if (!isValid) {
                    e.preventDefault();
                    showError(message);
                    return false;
                }

                /* =============================
                   LOADING STATE
                ============================== */
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + messages.updating;
                submitBtn.disabled = true;
            });
        }

        /* =============================
           SUCCESS AUTO HIDE
        ============================== */
        if (successBox) {
            setTimeout(() => {
                successBox.style.opacity = '0';
                setTimeout(() => successBox.remove(), 500);
            }, 5000);
        }

        /* =============================
           FUNCTIONS
        ============================== */
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function showError(text) {
            const old = document.querySelector('.js-error');
            if (old) old.remove();

            const div = document.createElement('div');
            div.className = 'alert-success-box js-error';
            div.style.background = '#dc354520';
            div.style.borderLeft = '5px solid #dc3545';

            div.innerHTML = `
                <i class="fas fa-exclamation-circle"></i>
                <span style="color:#dc3545;font-weight:600">${text}</span>
            `;

            form.prepend(div);

            setTimeout(() => div.remove(), 5000);
        }

        /* =============================
           BANGLA NUMBER CONVERSION
        ============================== */
        if (isBangla) {
            const photoNote = document.querySelector('.photo-note');
            if (photoNote) {
                photoNote.textContent = photoNote.textContent.replace(/\d/g, digit => {
                    const banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
                    return banglaDigits[digit];
                });
            }
        }

        console.log('👤 Profile JS Initialized');
    });
})();
</script>

@endsection
