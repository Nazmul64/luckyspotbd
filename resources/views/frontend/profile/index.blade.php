@extends('frontend.master')

@section('content')

@php
    $user = auth()->user();
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

    $translations = [
        'en' => [
            'page_title' => 'Edit Profile',
            'personal_info' => 'Personal Information',
            'contact_info' => 'Contact Information',
            'upload_photo' => 'Change Photo',
            'remove_photo' => 'Remove',
            'photo_note' => 'JPG, PNG or GIF (MAX. 5MB)',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email Address',
            'phone' => 'Phone Number',
            'address' => 'Street Address',
            'city' => 'City',
            'state' => 'State/Province',
            'zip_code' => 'ZIP/Postal Code',
            'country' => 'Country',
            'bio' => 'Bio',
            'update_profile' => 'Save Changes',
            'cancel' => 'Cancel',
            'security_tips' => 'Security & Privacy',
            'tip_1' => '✓ Keep email updated',
            'tip_2' => '✓ Use strong password',
            'tip_3' => '✓ Enable 2FA',
            'tip_4' => '✓ Never share credentials',
            'tip_5' => '✓ Review profile regularly',
            'countries' => [
                'Bangladesh' => 'Bangladesh',
                'India' => 'India',
                'Pakistan' => 'Pakistan',
                'USA' => 'United States',
                'UK' => 'United Kingdom',
                'Canada' => 'Canada',
                'Australia' => 'Australia',
                'Other' => 'Other',
            ],
        ],
        'bn' => [
            'page_title' => 'প্রোফাইল সম্পাদনা',
            'personal_info' => 'ব্যক্তিগত তথ্য',
            'contact_info' => 'যোগাযোগের তথ্য',
            'upload_photo' => 'ছবি পরিবর্তন',
            'remove_photo' => 'মুছুন',
            'photo_note' => 'JPG, PNG বা GIF (সর্বোচ্চ ৫MB)',
            'first_name' => 'প্রথম নাম',
            'last_name' => 'শেষ নাম',
            'username' => 'ইউজারনেম',
            'email' => 'ইমেইল ঠিকানা',
            'phone' => 'ফোন নম্বর',
            'address' => 'রাস্তার ঠিকানা',
            'city' => 'শহর',
            'state' => 'রাজ্য/প্রদেশ',
            'zip_code' => 'পোস্টাল কোড',
            'country' => 'দেশ',
            'bio' => 'পরিচিতি',
            'update_profile' => 'সংরক্ষণ করুন',
            'cancel' => 'বাতিল',
            'security_tips' => 'নিরাপত্তা ও গোপনীয়তা',
            'tip_1' => '✓ ইমেইল আপডেট রাখুন',
            'tip_2' => '✓ শক্তিশালী পাসওয়ার্ড',
            'tip_3' => '✓ ২FA চালু করুন',
            'tip_4' => '✓ তথ্য শেয়ার করবেন না',
            'tip_5' => '✓ প্রোফাইল পর্যালোচনা করুন',
            'countries' => [
                'Bangladesh' => 'বাংলাদেশ',
                'India' => 'ভারত',
                'Pakistan' => 'পাকিস্তান',
                'USA' => 'যুক্তরাষ্ট্র',
                'UK' => 'যুক্তরাজ্য',
                'Canada' => 'কানাডা',
                'Australia' => 'অস্ট্রেলিয়া',
                'Other' => 'অন্যান্য',
            ],
        ],
    ];

    $lang = $translations[$isBangla ? 'bn' : 'en'];
@endphp

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            @include('frontend.dashboard.sidebar')

            <div class="col-lg-9">

                {{-- PAGE HEADER --}}
                <div class="profile-page-header">
                    <div class="header-content">
                        <h2><i class="fas fa-user-circle"></i> {{ $lang['page_title'] }}</h2>
                        <p>Update your personal information</p>
                    </div>
                    <div class="header-badge">
                        <i class="far fa-clock"></i>
                        <span>{{ $user->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>

                {{-- ALERTS --}}
                @if(session('success'))
                    <div class="alert-box success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                        <button class="close-btn" onclick="this.parentElement.remove()">×</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-box danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                        <button class="close-btn" onclick="this.parentElement.remove()">×</button>
                    </div>
                @endif

                <form id="profileForm" action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        {{-- PHOTO SECTION --}}
                        <div class="col-lg-4">

                            <div class="photo-card">
                                <div class="card-header">
                                    <i class="fas fa-image"></i> Profile Photo
                                </div>
                                <div class="card-body">
                                    <div class="photo-wrapper">
                                        <div class="photo-container">
                                            <img id="preview-image" src="{{ $user->profile_photo ? asset('uploads/profile/'.$user->profile_photo) : asset('assets/images/account/user.png') }}" alt="Profile">
                                            <div class="photo-overlay">
                                                <i class="fas fa-camera"></i>
                                            </div>
                                        </div>

                                        <div class="user-info">
                                            <h6>{{ $user->first_name }} {{ $user->last_name }}</h6>

                                            <span class="badge"><i class="fas fa-star"></i> Member</span>
                                        </div>

                                        <input type="file" name="profile_photo" id="photo-input" hidden accept="image/*">

                                        <div class="photo-buttons">
                                            <label for="photo-input" class="btn-upload">
                                                <i class="fas fa-upload"></i> {{ $lang['upload_photo'] }}
                                            </label>
                                            <button type="button" class="btn-remove" id="remove-btn">
                                                <i class="fas fa-trash-alt"></i> {{ $lang['remove_photo'] }}
                                            </button>
                                        </div>

                                        <small class="note">
                                            <i class="fas fa-info-circle"></i> {{ $lang['photo_note'] }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="security-card">
                                <div class="security-header">
                                    <i class="fas fa-shield-alt"></i>
                                    <h5>{{ $lang['security_tips'] }}</h5>
                                </div>
                                <ul class="security-list">
                                    <li>{{ $lang['tip_1'] }}</li>
                                    <li>{{ $lang['tip_2'] }}</li>
                                    <li>{{ $lang['tip_3'] }}</li>
                                    <li>{{ $lang['tip_4'] }}</li>
                                    <li>{{ $lang['tip_5'] }}</li>
                                </ul>
                            </div>

                        </div>

                        {{-- FORM SECTION --}}
                        <div class="col-lg-8">

                            {{-- PERSONAL INFO --}}
                            <div class="info-card">
                                <div class="card-header">
                                    <i class="fas fa-user"></i> {{ $lang['personal_info'] }}
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-user"></i> {{ $lang['first_name'] }} <span class="req">*</span></label>
                                                <input type="text" name="first_name" value="{{ $user->first_name }}" class="form-input" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-user"></i> {{ $lang['last_name'] }} <span class="req">*</span></label>
                                                <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-input" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-at"></i> {{ $lang['username'] }} <span class="req">*</span></label>
                                                <input type="text" name="username" value="{{ $user->username }}" class="form-input" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-envelope"></i> {{ $lang['email'] }} <span class="req">*</span></label>
                                                <input type="email" name="email" value="{{ $user->email }}" class="form-input" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><i class="fas fa-pen"></i> {{ $lang['bio'] }}</label>
                                                <textarea name="bio" class="form-input" rows="3">{{ $user->bio ?? '' }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- CONTACT INFO --}}
                            <div class="info-card">
                                <div class="card-header">
                                    <i class="fas fa-address-book"></i> {{ $lang['contact_info'] }}
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-phone"></i> {{ $lang['phone'] }}</label>
                                                <input type="tel" name="number" value="{{ $user->number }}" class="form-input">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-globe"></i> {{ $lang['country'] }}</label>
                                                <select name="country" class="form-input">
                                                    @foreach(['Bangladesh','India','Pakistan','USA','UK','Canada','Australia','Other'] as $country)
                                                        <option value="{{ $country }}" {{ $user->country == $country ? 'selected' : '' }}>
                                                            {{ $lang['countries'][$country] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label><i class="fas fa-map-marker-alt"></i> {{ $lang['address'] }}</label>
                                                <input type="text" name="address" value="{{ $user->address }}" class="form-input">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-city"></i> {{ $lang['city'] }}</label>
                                                <input type="text" name="city" value="{{ $user->city ?? '' }}" class="form-input">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-map"></i> {{ $lang['state'] }}</label>
                                                <input type="text" name="state" value="{{ $user->state ?? '' }}" class="form-input">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-mail-bulk"></i> {{ $lang['zip_code'] }}</label>
                                                <input type="text" name="zip_code" value="{{ $user->zip_code }}" class="form-input">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- BUTTONS --}}
                            <div class="form-actions">
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save"></i> {{ $lang['update_profile'] }}
                                </button>
                                <button type="button" class="btn-cancel" onclick="window.location.reload()">
                                    <i class="fas fa-times"></i> {{ $lang['cancel'] }}
                                </button>
                            </div>

                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
{{-- ===================== STYLES ===================== --}}
<style>
:root {
    --primary: #0dcaf0;
    --primary-dark: #0bb3d9;
    --secondary: #6c757d;
    --success: #28a745;
    --danger: #dc3545;
    --warning: #ffc107;
    --purple: #9b59b6;
    --pink: #e91e63;
    --orange: #ff6b35;
    --teal: #20c997;
    {{ $isBangla ? '--font: "Kalpurush", sans-serif;' : '--font: -apple-system, sans-serif;' }}
}

/* PAGE HEADER */
.profile-page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px 30px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.header-content h2 {
    color: #fff;
    font-size: 26px;
    font-weight: 700;
    margin: 0 0 5px 0;
    font-family: var(--font);
    display: flex;
    align-items: center;
    gap: 10px;
}

.header-content p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 14px;
}

.header-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 16px;
    border-radius: 20px;
    color: #fff;
    font-size: 13px;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ALERTS */
.alert-box {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
    animation: slideIn 0.4s ease;
    font-family: var(--font);
}

.alert-box.success {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.2));
    border-left: 4px solid var(--success);
    color: var(--success);
}

.alert-box.danger {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.2));
    border-left: 4px solid var(--danger);
    color: var(--danger);
}

.close-btn {
    position: absolute;
    right: 15px;
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
    color: inherit;
    opacity: 0.6;
}

.close-btn:hover { opacity: 1; }

/* PHOTO CARD */
.photo-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
    margin-bottom: 20px;
    overflow: hidden;
}

.photo-card .card-header {
    background: rgba(255, 255, 255, 0.2);
    padding: 18px 20px;
    border-bottom: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font);
}

.photo-card .card-body {
    padding: 25px 20px;
}

.photo-wrapper {
    text-align: center;
}

.photo-container {
    position: relative;
    display: inline-block;
    margin-bottom: 20px;
}

.photo-container img {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #fff;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    transition: all 0.3s;
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s;
    cursor: pointer;
}

.photo-container:hover .photo-overlay {
    opacity: 1;
}

.photo-overlay i {
    color: #f5576c;
    font-size: 30px;
}

.user-info {
    margin-bottom: 20px;
}

.user-info h6 {
    font-size: 18px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 5px 0;
    font-family: var(--font);
}

.user-info p {
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
    margin: 0 0 10px 0;
    font-size: 14px;
}

.badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.3);
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge i {
    color: #ffd700;
}

.photo-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 15px;
}

.btn-upload, .btn-remove {
    padding: 12px 18px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-family: var(--font);
}

.btn-upload {
    background: #fff;
    color: #f5576c;
}

.btn-upload:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
}

.btn-remove {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
}

.btn-remove:hover {
    background: rgba(220, 53, 69, 0.3);
}

.note {
    display: block;
    color: rgba(255, 255, 255, 0.8);
    font-size: 11px;
}

/* SECURITY CARD */
.security-card {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
}

.security-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.security-header i {
    font-size: 22px;
    color: #fff;
}

.security-header h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    font-family: var(--font);
}

.security-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.security-list li {
    padding: 10px 0;
    color: #fff;
    font-size: 13px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    font-family: var(--font);
}

.security-list li:last-child {
    border-bottom: none;
}

/* INFO CARD */
.info-card {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3);
    margin-bottom: 20px;
    overflow: hidden;
}

.info-card .card-header {
    background: rgba(255, 255, 255, 0.2);
    padding: 18px 20px;
    border-bottom: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font);
}

.info-card .card-body {
    padding: 25px;
    background: #fff;
}

/* FORM */
.form-group {
    margin-bottom: 0;
}

label {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font);
}

label i {
    color: #43e97b;
    font-size: 14px;
}

.req {
    color: var(--danger);
    margin-left: 4px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s;
    background: #fff;
    color: #2c3e50;
    font-family: var(--font);
}

.form-input:focus {
    outline: none;
    border-color: #43e97b;
    box-shadow: 0 0 0 4px rgba(67, 233, 123, 0.1);
}

textarea.form-input {
    resize: vertical;
    min-height: 90px;
}

/* BUTTONS */
.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 25px;
}

.btn-save, .btn-cancel {
    flex: 1;
    padding: 14px 28px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-family: var(--font);
}

.btn-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-save:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
}

.btn-cancel {
    background: linear-gradient(135deg, #e0e0e0 0%, #bdbdbd 100%);
    color: #2c3e50;
}

.btn-cancel:hover {
    background: linear-gradient(135deg, #bdbdbd 0%, #9e9e9e 100%);
    color: #fff;
}

/* ANIMATIONS */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .profile-page-header {
        padding: 20px;
    }
    .header-content h2 {
        font-size: 22px;
    }
    .form-actions {
        flex-direction: column;
    }
}

@media (max-width: 767px) {
    .photo-container img {
        width: 140px;
        height: 140px;
    }
    .photo-buttons {
        grid-template-columns: 1fr;
    }
}
</style>

{{-- ===================== SCRIPTS ===================== --}}
<script>
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('profileForm');
        const photoInput = document.getElementById('photo-input');
        const previewImg = document.getElementById('preview-image');
        const removeBtn = document.getElementById('remove-btn');
        const submitBtn = document.querySelector('.btn-save');

        // PHOTO PREVIEW
        if (photoInput && previewImg) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image (JPG, PNG, GIF, WEBP)');
                    this.value = '';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        // REMOVE PHOTO
        if (removeBtn && previewImg) {
            removeBtn.addEventListener('click', function() {
                if (confirm('Remove profile photo?')) {
                    previewImg.src = '{{ asset("assets/images/account/user.png") }}';
                    if (photoInput) photoInput.value = '';
                }
            });
        }

        // FORM VALIDATION
        if (form) {
            form.addEventListener('submit', function(e) {
                const firstName = form.querySelector('[name="first_name"]');
                const lastName = form.querySelector('[name="last_name"]');
                const username = form.querySelector('[name="username"]');
                const email = form.querySelector('[name="email"]');

                if (!firstName.value.trim()) {
                    e.preventDefault();
                    alert('First name is required');
                    firstName.focus();
                    return false;
                }

                if (!lastName.value.trim()) {
                    e.preventDefault();
                    alert('Last name is required');
                    lastName.focus();
                    return false;
                }

                if (!username.value.trim()) {
                    e.preventDefault();
                    alert('Username is required');
                    username.focus();
                    return false;
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email.value)) {
                    e.preventDefault();
                    alert('Please enter a valid email');
                    email.focus();
                    return false;
                }

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                submitBtn.disabled = true;
            });
        }

        // AUTO HIDE ALERTS
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-box');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);

        // UNSAVED CHANGES WARNING
        let formChanged = false;
        const inputs = document.querySelectorAll('.form-input');

        inputs.forEach(input => {
            input.addEventListener('change', () => {
                formChanged = true;
            });
        });

        window.addEventListener('beforeunload', (e) => {
            if (formChanged && !form.submitted) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        form.addEventListener('submit', () => {
            form.submitted = true;
        });

        console.log('✅ Profile Edit Loaded');
    });
})();
</script>

@endsection
