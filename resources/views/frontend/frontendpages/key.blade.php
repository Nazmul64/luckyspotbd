@extends('frontend.master')

@section('content')

@php
    // ============================================
    // THEME CONFIGURATION
    // ============================================
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#F5CE0D';
    $secondaryColor = $activeTheme->secondary_color ?? '#000000';

    // ============================================
    // LANGUAGE DETECTION
    // ============================================
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

    // ============================================
    // KYC DATA
    // ============================================
    $kyc = Auth::user()->kyc ?? null;

    // ============================================
    // TRANSLATIONS
    // ============================================
    $translations = [
        'en' => [
            'page_title' => 'KYC Verification',
            'page_subtitle' => 'Verify your identity to access all features',
            'kyc_status' => 'Your KYC Status',
            'status_pending' => 'Pending',
            'status_approved' => 'Verified',
            'status_rejected' => 'Rejected',
            'document_type' => 'Document Type',
            'select_document' => '-- Select Document Type --',
            'passport' => 'Passport',
            'nid' => 'National ID (NID)',
            'driving_license' => 'Driving License',
            'first_photo' => 'First Photo',
            'second_photo' => 'Second Photo',
            'front_side' => 'Front Side of Document',
            'back_side' => 'Back Side of Document',
            'submit_kyc' => 'Submit KYC',
            'upload_again_msg' => 'You cannot upload again until admin reviews your KYC.',
            'pending_msg' => 'Your KYC is under review. Please wait for admin approval.',
            'approved_msg' => 'Your KYC has been verified successfully!',
            'rejected_msg' => 'Your KYC was rejected. You can resubmit with correct documents.',
            'upload_instruction' => 'Upload Instructions',
            'instruction_1' => 'File format: JPG, PNG, or PDF',
            'instruction_2' => 'Maximum file size: 5MB',
            'instruction_3' => 'Clear and readable image',
            'instruction_4' => 'No edited or cropped documents',
            'why_kyc' => 'Why KYC Required?',
            'kyc_reason_1' => 'Enhanced account security',
            'kyc_reason_2' => 'Access to all features',
            'kyc_reason_3' => 'Comply with regulations',
            'kyc_reason_4' => 'Secure transactions',
        ],
        'bn' => [
            'page_title' => 'KYC যাচাইকরণ',
            'page_subtitle' => 'সকল ফিচার ব্যবহার করতে আপনার পরিচয় যাচাই করুন',
            'kyc_status' => 'আপনার KYC স্ট্যাটাস',
            'status_pending' => 'অপেক্ষমাণ',
            'status_approved' => 'যাচাইকৃত',
            'status_rejected' => 'প্রত্যাখ্যাত',
            'document_type' => 'ডকুমেন্ট ধরন',
            'select_document' => '-- ডকুমেন্ট ধরন নির্বাচন করুন --',
            'passport' => 'পাসপোর্ট',
            'nid' => 'জাতীয় পরিচয়পত্র (NID)',
            'driving_license' => 'ড্রাইভিং লাইসেন্স',
            'first_photo' => 'প্রথম ছবি',
            'second_photo' => 'দ্বিতীয় ছবি',
            'front_side' => 'ডকুমেন্টের সামনের পাশ',
            'back_side' => 'ডকুমেন্টের পিছনের পাশ',
            'submit_kyc' => 'KYC জমা দিন',
            'upload_again_msg' => 'অ্যাডমিন আপনার KYC পর্যালোচনা না করা পর্যন্ত আপনি আবার আপলোড করতে পারবেন না।',
            'pending_msg' => 'আপনার KYC পর্যালোচনাধীন। দয়া করে অ্যাডমিন অনুমোদনের জন্য অপেক্ষা করুন।',
            'approved_msg' => 'আপনার KYC সফলভাবে যাচাই করা হয়েছে!',
            'rejected_msg' => 'আপনার KYC প্রত্যাখ্যান করা হয়েছে। সঠিক ডকুমেন্ট দিয়ে আবার জমা দিতে পারেন।',
            'upload_instruction' => 'আপলোড নির্দেশনা',
            'instruction_1' => 'ফাইল ফরম্যাট: JPG, PNG, অথবা PDF',
            'instruction_2' => 'সর্বোচ্চ ফাইল সাইজ: ৫MB',
            'instruction_3' => 'পরিষ্কার এবং পাঠযোগ্য ছবি',
            'instruction_4' => 'এডিট বা ক্রপ করা ডকুমেন্ট নয়',
            'why_kyc' => 'কেন KYC প্রয়োজন?',
            'kyc_reason_1' => 'উন্নত অ্যাকাউন্ট নিরাপত্তা',
            'kyc_reason_2' => 'সকল ফিচারে অ্যাক্সেস',
            'kyc_reason_3' => 'নিয়ম মেনে চলা',
            'kyc_reason_4' => 'নিরাপদ লেনদেন',
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
                <div class="kyc-wrapper">

                    {{-- HERO HEADER --}}
                    <div class="kyc-hero">
                        <div class="hero-pattern"></div>
                        <div class="hero-content">
                            <div class="hero-icon">
                                <i class="fas fa-shield-check"></i>
                            </div>
                            <h4>{{ $lang['page_title'] }}</h4>
                            <p>{{ $lang['page_subtitle'] }}</p>
                        </div>
                    </div>

                    <div class="row gy-4">

                        {{-- KYC FORM SECTION --}}
                        <div class="col-lg-8">
                            <div class="kyc-card">

                                {{-- KYC STATUS DISPLAY --}}
                                @if($kyc)
                                    <div class="status-display">
                                        <div class="status-label">{{ $lang['kyc_status'] }}</div>

                                        @if($kyc->status == 'pending')
                                            <div class="status-badge status-pending">
                                                <i class="fas fa-clock"></i>
                                                <span>{{ $lang['status_pending'] }}</span>
                                            </div>
                                            <p class="status-message">{{ $lang['pending_msg'] }}</p>
                                        @elseif($kyc->status == 'approved')
                                            <div class="status-badge status-approved">
                                                <i class="fas fa-check-circle"></i>
                                                <span>{{ $lang['status_approved'] }}</span>
                                            </div>
                                            <p class="status-message">{{ $lang['approved_msg'] }}</p>
                                        @else
                                            <div class="status-badge status-rejected">
                                                <i class="fas fa-times-circle"></i>
                                                <span>{{ $lang['status_rejected'] }}</span>
                                            </div>
                                            <p class="status-message">{{ $lang['rejected_msg'] }}</p>
                                        @endif
                                    </div>
                                @endif

                                {{-- KYC FORM --}}
                                @if(!$kyc || $kyc->status == 'rejected')
                                    <form id="kycForm" action="{{ route('frontend.key.submit') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        {{-- Document Type --}}
                                        <div class="form-group">
                                            <label for="documentType">
                                                <i class="fas fa-id-card"></i>
                                                {{ $lang['document_type'] }}
                                            </label>
                                            <select name="document_type" id="documentType" class="form-control" required>
                                                <option value="">{{ $lang['select_document'] }}</option>
                                                <option value="passport" {{ old('document_type') == 'passport' ? 'selected' : '' }}>
                                                    {{ $lang['passport'] }}
                                                </option>
                                                <option value="nid" {{ old('document_type') == 'nid' ? 'selected' : '' }}>
                                                    {{ $lang['nid'] }}
                                                </option>
                                                <option value="driving_license" {{ old('document_type') == 'driving_license' ? 'selected' : '' }}>
                                                    {{ $lang['driving_license'] }}
                                                </option>
                                            </select>
                                            @error('document_type')
                                                <span class="error-text">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- First Photo --}}
                                        <div class="form-group">
                                            <label>
                                                <i class="fas fa-image"></i>
                                                {{ $lang['first_photo'] }} <small>({{ $lang['front_side'] }})</small>
                                            </label>
                                            <div class="photo-upload-box">
                                                <div class="photo-preview">
                                                    <img src="{{ asset('uploads/avator.jpg') }}"
                                                         id="firstPhotoPreview"
                                                         alt="First Photo">
                                                    <div class="preview-overlay">
                                                        <i class="fas fa-camera"></i>
                                                    </div>
                                                </div>
                                                <input type="file"
                                                       name="document_first_part_photo"
                                                       id="firstPhoto"
                                                       accept="image/*"
                                                       class="file-input"
                                                       onchange="previewImage(event, 'firstPhotoPreview')"
                                                       required>
                                                <label for="firstPhoto" class="upload-btn">
                                                    <i class="fas fa-upload"></i>
                                                    {{ $isBangla ? 'আপলোড করুন' : 'Upload Photo' }}
                                                </label>
                                            </div>
                                            @error('document_first_part_photo')
                                                <span class="error-text">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Second Photo --}}
                                        <div class="form-group">
                                            <label>
                                                <i class="fas fa-image"></i>
                                                {{ $lang['second_photo'] }} <small>({{ $lang['back_side'] }})</small>
                                            </label>
                                            <div class="photo-upload-box">
                                                <div class="photo-preview">
                                                    <img src="{{ asset('uploads/avator.jpg') }}"
                                                         id="secondPhotoPreview"
                                                         alt="Second Photo">
                                                    <div class="preview-overlay">
                                                        <i class="fas fa-camera"></i>
                                                    </div>
                                                </div>
                                                <input type="file"
                                                       name="document_secound_part_photo"
                                                       id="secondPhoto"
                                                       accept="image/*"
                                                       class="file-input"
                                                       onchange="previewImage(event, 'secondPhotoPreview')"
                                                       required>
                                                <label for="secondPhoto" class="upload-btn">
                                                    <i class="fas fa-upload"></i>
                                                    {{ $isBangla ? 'আপলোড করুন' : 'Upload Photo' }}
                                                </label>
                                            </div>
                                            @error('document_secound_part_photo')
                                                <span class="error-text">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Submit Button --}}
                                        <button type="submit" class="btn-submit">
                                            <i class="fas fa-paper-plane"></i>
                                            {{ $lang['submit_kyc'] }}
                                        </button>
                                    </form>
                                @else
                                    <div class="pending-notice">
                                        <i class="fas fa-info-circle"></i>
                                        <span>{{ $lang['upload_again_msg'] }}</span>
                                    </div>
                                @endif

                            </div>
                        </div>

                        {{-- SIDEBAR INFO --}}
                        <div class="col-lg-4">
                            {{-- Upload Instructions --}}
                            <div class="info-card">
                                <h6>
                                    <i class="fas fa-clipboard-list"></i>
                                    {{ $lang['upload_instruction'] }}
                                </h6>
                                <ul class="info-list">
                                    <li><i class="fas fa-check"></i> {{ $lang['instruction_1'] }}</li>
                                    <li><i class="fas fa-check"></i> {{ $lang['instruction_2'] }}</li>
                                    <li><i class="fas fa-check"></i> {{ $lang['instruction_3'] }}</li>
                                    <li><i class="fas fa-check"></i> {{ $lang['instruction_4'] }}</li>
                                </ul>
                            </div>

                            {{-- Why KYC --}}
                            <div class="info-card">
                                <h6>
                                    <i class="fas fa-question-circle"></i>
                                    {{ $lang['why_kyc'] }}
                                </h6>
                                <ul class="info-list">
                                    <li><i class="fas fa-shield-alt"></i> {{ $lang['kyc_reason_1'] }}</li>
                                    <li><i class="fas fa-unlock-alt"></i> {{ $lang['kyc_reason_2'] }}</li>
                                    <li><i class="fas fa-balance-scale"></i> {{ $lang['kyc_reason_3'] }}</li>
                                    <li><i class="fas fa-lock"></i> {{ $lang['kyc_reason_4'] }}</li>
                                </ul>
                            </div>
                        </div>

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
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --info: #17a2b8;
    --white: #ffffff;
    --light: #f8f9fa;
    --dark: #212529;
    --text-muted: #6c757d;
    --border: #dee2e6;
    --shadow-sm: 0 2px 4px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 12px rgba(0,0,0,0.12);
    --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
    --radius-sm: 8px;
    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.kyc-wrapper {
    {{ $isBangla ? 'font-family: "Kalpurush", "SolaimanLipi", sans-serif;' : '' }}
}

/* ==================== HERO HEADER ==================== */
.kyc-hero {
    position: relative;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: var(--radius-xl);
    padding: 48px 32px;
    margin-bottom: 32px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    text-align: center;
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image:
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 1;
}

.hero-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--white);
    backdrop-filter: blur(10px);
}

.kyc-hero h4 {
    color: var(--white);
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 12px 0;
}

.kyc-hero p {
    color: rgba(255,255,255,0.9);
    font-size: 1.1rem;
    margin: 0;
}

/* ==================== KYC CARD ==================== */
.kyc-card {
    background: var(--white);
    border: 2px solid color-mix(in srgb, var(--primary) 20%, transparent);
    border-radius: var(--radius-lg);
    padding: 35px;
    box-shadow: var(--shadow-md);
}

/* ==================== STATUS DISPLAY ==================== */
.status-display {
    text-align: center;
    padding: 25px;
    background: linear-gradient(135deg,
        color-mix(in srgb, var(--primary) 5%, transparent),
        color-mix(in srgb, var(--secondary) 5%, transparent));
    border-radius: var(--radius);
    margin-bottom: 30px;
}

.status-label {
    font-size: 1rem;
    color: var(--text-muted);
    margin-bottom: 12px;
    font-weight: 600;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    border-radius: var(--radius);
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.status-pending {
    background: color-mix(in srgb, var(--warning) 20%, transparent);
    color: #856404;
}

.status-approved {
    background: color-mix(in srgb, var(--success) 20%, transparent);
    color: var(--success);
}

.status-rejected {
    background: color-mix(in srgb, var(--danger) 20%, transparent);
    color: var(--danger);
}

.status-badge i {
    font-size: 1.3rem;
}

.status-message {
    color: var(--text-muted);
    font-size: 0.95rem;
    margin: 0;
}

/* ==================== FORM STYLES ==================== */
.form-group {
    margin-bottom: 30px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--dark);
    font-size: 1rem;
}

.form-group label i {
    color: var(--primary);
    margin-right: 8px;
}

.form-group label small {
    color: var(--text-muted);
    font-weight: 400;
    font-size: 0.85rem;
}

.form-control {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid var(--border);
    border-radius: var(--radius);
    font-size: 1rem;
    transition: all var(--transition);
    background: var(--white);
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px color-mix(in srgb, var(--primary) 15%, transparent);
}

.error-text {
    display: block;
    color: var(--danger);
    font-size: 0.85rem;
    margin-top: 6px;
}

/* ==================== PHOTO UPLOAD ==================== */
.photo-upload-box {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: var(--light);
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    transition: all var(--transition);
}

.photo-upload-box:hover {
    border-color: var(--primary);
    background: color-mix(in srgb, var(--primary) 5%, transparent);
}

.photo-preview {
    position: relative;
    width: 120px;
    height: 120px;
    flex-shrink: 0;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: var(--radius);
    border: 3px solid var(--primary);
}

.preview-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity var(--transition);
}

.photo-preview:hover .preview-overlay {
    opacity: 1;
}

.preview-overlay i {
    color: var(--white);
    font-size: 2rem;
}

.file-input {
    display: none;
}

.upload-btn {
    flex: 1;
    padding: 12px 24px;
    background: var(--primary);
    color: var(--secondary);
    border: none;
    border-radius: var(--radius);
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition);
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.upload-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* ==================== SUBMIT BUTTON ==================== */
.btn-submit {
    width: 100%;
    padding: 16px 24px;
    background: var(--primary);
    color: var(--secondary);
    border: none;
    border-radius: var(--radius);
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* ==================== PENDING NOTICE ==================== */
.pending-notice {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px;
    background: color-mix(in srgb, var(--info) 15%, transparent);
    border-left: 4px solid var(--info);
    border-radius: var(--radius);
    color: var(--info);
    font-weight: 500;
}

.pending-notice i {
    font-size: 1.5rem;
}

/* ==================== INFO CARDS ==================== */
.info-card {
    background: var(--white);
    border: 2px solid color-mix(in srgb, var(--primary) 15%, transparent);
    border-radius: var(--radius);
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
}

.info-card h6 {
    color: var(--primary);
    font-weight: 700;
    margin-bottom: 16px;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    padding: 10px 0;
    color: var(--text-muted);
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 0.9rem;
    line-height: 1.5;
}

.info-list li i {
    color: var(--success);
    font-size: 0.9rem;
    margin-top: 3px;
    flex-shrink: 0;
}

/* ==================== ANIMATIONS ==================== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.kyc-card,
.info-card {
    animation: fadeIn 0.5s ease-out;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 991px) {
    .kyc-hero {
        padding: 36px 24px;
    }

    .hero-icon {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }

    .kyc-hero h4 {
        font-size: 1.75rem;
    }
}

@media (max-width: 768px) {
    .kyc-card {
        padding: 25px 20px;
    }

    .kyc-hero {
        padding: 28px 20px;
    }

    .kyc-hero h4 {
        font-size: 1.5rem;
    }

    .photo-upload-box {
        flex-direction: column;
        text-align: center;
    }

    .upload-btn {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .kyc-hero p {
        font-size: 0.95rem;
    }

    .info-card {
        padding: 18px;
    }

    .status-badge {
        font-size: 1rem;
        padding: 10px 20px;
    }
}
</style>

{{-- ===================== JAVASCRIPT ===================== --}}
<script>
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {

        /* =============================
           CONFIGURATION
        ============================== */
        const isBangla = {{ $isBangla ? 'true' : 'false' }};
        const maxFileSize = 5 * 1024 * 1024; // 5MB

        /* =============================
           ELEMENTS
        ============================== */
        const form = document.getElementById('kycForm');
        const submitBtn = document.querySelector('.btn-submit');

        /* =============================
           FORM VALIDATION
        ============================== */
        if (form) {
            form.addEventListener('submit', function(e) {
                const documentType = document.getElementById('documentType');
                const firstPhoto = document.getElementById('firstPhoto');
                const secondPhoto = document.getElementById('secondPhoto');

                // Validate document type
                if (!documentType.value) {
                    e.preventDefault();
                    alert(isBangla ? 'ডকুমেন্ট ধরন নির্বাচন করুন' : 'Please select document type');
                    documentType.focus();
                    return;
                }

                // Validate first photo
                if (!firstPhoto.files || firstPhoto.files.length === 0) {
                    e.preventDefault();
                    alert(isBangla ? 'প্রথম ছবি আপলোড করুন' : 'Please upload first photo');
                    return;
                }

                // Validate second photo
                if (!secondPhoto.files || secondPhoto.files.length === 0) {
                    e.preventDefault();
                    alert(isBangla ? 'দ্বিতীয় ছবি আপলোড করুন' : 'Please upload second photo');
                    return;
                }

                // Check file sizes
                if (firstPhoto.files[0].size > maxFileSize) {
                    e.preventDefault();
                    alert(isBangla ? 'প্রথম ছবির সাইজ ৫MB এর কম হতে হবে' : 'First photo size must be less than 5MB');
                    return;
                }

                if (secondPhoto.files[0].size > maxFileSize) {
                    e.preventDefault();
                    alert(isBangla ? 'দ্বিতীয় ছবির সাইজ ৫MB এর কম হতে হবে' : 'Second photo size must be less than 5MB');
                    return;
                }

                // Loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' +
                    (isBangla ? 'জমা দেওয়া হচ্ছে...' : 'Submitting...');
                submitBtn.disabled = true;
            });
        }

        console.log('✅ KYC Verification JS Initialized');
    });
})();

/* =============================
   IMAGE PREVIEW FUNCTION
============================== */
function previewImage(event, previewId) {
    const file = event.target.files[0];

    if (!file) return;

    // Validate file type
    if (!file.type.startsWith('image/')) {
        alert({{ $isBangla ? '"শুধুমাত্র ছবি ফাইল আপলোড করুন"' : '"Please upload image files only"' }});
        event.target.value = '';
        return;
    }

    // Validate file size
    if (file.size > 5 * 1024 * 1024) {
        alert({{ $isBangla ? '"ফাইল সাইজ ৫MB এর কম হতে হবে"' : '"File size must be less than 5MB"' }});
        event.target.value = '';
        return;
    }

    // Preview image
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById(previewId).src = reader.result;
    };
    reader.readAsDataURL(file);
}
</script>

@endsection
