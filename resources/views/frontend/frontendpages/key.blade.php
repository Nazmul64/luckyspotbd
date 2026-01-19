@extends('frontend.master')

@section('content')

@php
    $user = auth()->user();
    $kyc = $user->kyc ?? null;
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

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
            'front_side' => 'Front Side',
            'back_side' => 'Back Side',
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
            'page_subtitle' => 'সকল ফিচার ব্যবহার করতে পরিচয় যাচাই করুন',
            'kyc_status' => 'আপনার KYC স্ট্যাটাস',
            'status_pending' => 'অপেক্ষমাণ',
            'status_approved' => 'যাচাইকৃত',
            'status_rejected' => 'প্রত্যাখ্যাত',
            'document_type' => 'ডকুমেন্ট ধরন',
            'select_document' => '-- ডকুমেন্ট নির্বাচন করুন --',
            'passport' => 'পাসপোর্ট',
            'nid' => 'জাতীয় পরিচয়পত্র',
            'driving_license' => 'ড্রাইভিং লাইসেন্স',
            'first_photo' => 'প্রথম ছবি',
            'second_photo' => 'দ্বিতীয় ছবি',
            'front_side' => 'সামনের পাশ',
            'back_side' => 'পিছনের পাশ',
            'submit_kyc' => 'KYC জমা দিন',
            'upload_again_msg' => 'অ্যাডমিন পর্যালোচনা না করা পর্যন্ত আপনি আবার আপলোড করতে পারবেন না।',
            'pending_msg' => 'আপনার KYC পর্যালোচনাধীন। অনুমোদনের জন্য অপেক্ষা করুন।',
            'approved_msg' => 'আপনার KYC সফলভাবে যাচাই করা হয়েছে!',
            'rejected_msg' => 'আপনার KYC প্রত্যাখ্যান করা হয়েছে। সঠিক ডকুমেন্ট দিয়ে আবার জমা দিন।',
            'upload_instruction' => 'আপলোড নির্দেশনা',
            'instruction_1' => 'ফাইল ফরম্যাট: JPG, PNG, বা PDF',
            'instruction_2' => 'সর্বোচ্চ ফাইল সাইজ: ৫MB',
            'instruction_3' => 'পরিষ্কার এবং পাঠযোগ্য ছবি',
            'instruction_4' => 'এডিট করা ডকুমেন্ট নয়',
            'why_kyc' => 'কেন KYC প্রয়োজন?',
            'kyc_reason_1' => 'উন্নত নিরাপত্তা',
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

            @include('frontend.dashboard.sidebar')

            <div class="col-lg-9">

                {{-- HEADER --}}
                <div class="kyc-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-shield-check"></i>
                        </div>
                        <div>
                            <h4>{{ $lang['page_title'] }}</h4>
                            <p>{{ $lang['page_subtitle'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">

                    {{-- KYC FORM SECTION --}}
                    <div class="col-lg-8">
                        <div class="kyc-card">

                            {{-- KYC STATUS --}}
                            @if($kyc)
                                <div class="status-display">
                                    <div class="status-label">{{ $lang['kyc_status'] }}</div>

                                    @if($kyc->status == 'pending')
                                        <div class="status-badge pending">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ $lang['status_pending'] }}</span>
                                        </div>
                                        <p class="status-message">{{ $lang['pending_msg'] }}</p>
                                    @elseif($kyc->status == 'approved')
                                        <div class="status-badge approved">
                                            <i class="fas fa-check-circle"></i>
                                            <span>{{ $lang['status_approved'] }}</span>
                                        </div>
                                        <p class="status-message">{{ $lang['approved_msg'] }}</p>
                                    @else
                                        <div class="status-badge rejected">
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
                                            <i class="fas fa-id-card"></i> {{ $lang['document_type'] }}
                                        </label>
                                        <select name="document_type" id="documentType" class="form-input" required>
                                            <option value="">{{ $lang['select_document'] }}</option>
                                            <option value="passport">{{ $lang['passport'] }}</option>
                                            <option value="nid">{{ $lang['nid'] }}</option>
                                            <option value="driving_license">{{ $lang['driving_license'] }}</option>
                                        </select>
                                        @error('document_type')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- First Photo --}}
                                    <div class="form-group">
                                        <label>
                                            <i class="fas fa-image"></i> {{ $lang['first_photo'] }} <small>({{ $lang['front_side'] }})</small>
                                        </label>
                                        <div class="photo-upload-box">
                                            <div class="photo-preview">
                                                <img src="{{ asset('uploads/avator.jpg') }}" id="firstPhotoPreview" alt="First Photo">
                                                <div class="preview-overlay">
                                                    <i class="fas fa-camera"></i>
                                                </div>
                                            </div>
                                            <div class="upload-area">
                                                <input type="file" name="document_first_part_photo" id="firstPhoto" accept="image/*" class="file-input" onchange="previewImage(event, 'firstPhotoPreview')" required>
                                                <label for="firstPhoto" class="upload-btn">
                                                    <i class="fas fa-upload"></i> {{ $isBangla ? 'আপলোড করুন' : 'Upload Photo' }}
                                                </label>
                                            </div>
                                        </div>
                                        @error('document_first_part_photo')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Second Photo --}}
                                    <div class="form-group">
                                        <label>
                                            <i class="fas fa-image"></i> {{ $lang['second_photo'] }} <small>({{ $lang['back_side'] }})</small>
                                        </label>
                                        <div class="photo-upload-box">
                                            <div class="photo-preview">
                                                <img src="{{ asset('uploads/avator.jpg') }}" id="secondPhotoPreview" alt="Second Photo">
                                                <div class="preview-overlay">
                                                    <i class="fas fa-camera"></i>
                                                </div>
                                            </div>
                                            <div class="upload-area">
                                                <input type="file" name="document_secound_part_photo" id="secondPhoto" accept="image/*" class="file-input" onchange="previewImage(event, 'secondPhotoPreview')" required>
                                                <label for="secondPhoto" class="upload-btn">
                                                    <i class="fas fa-upload"></i> {{ $isBangla ? 'আপলোড করুন' : 'Upload Photo' }}
                                                </label>
                                            </div>
                                        </div>
                                        @error('document_secound_part_photo')
                                            <span class="error-text">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Submit Button --}}
                                    <button type="submit" class="btn-submit">
                                        <i class="fas fa-paper-plane"></i> {{ $lang['submit_kyc'] }}
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
                        <div class="info-card instructions-card">
                            <h6><i class="fas fa-clipboard-list"></i> {{ $lang['upload_instruction'] }}</h6>
                            <ul class="info-list">
                                <li><i class="fas fa-check"></i> {{ $lang['instruction_1'] }}</li>
                                <li><i class="fas fa-check"></i> {{ $lang['instruction_2'] }}</li>
                                <li><i class="fas fa-check"></i> {{ $lang['instruction_3'] }}</li>
                                <li><i class="fas fa-check"></i> {{ $lang['instruction_4'] }}</li>
                            </ul>
                        </div>

                        {{-- Why KYC --}}
                        <div class="info-card why-kyc-card">
                            <h6><i class="fas fa-question-circle"></i> {{ $lang['why_kyc'] }}</h6>
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

{{-- ===================== STYLES ===================== --}}
<style>
:root {
    {{ $isBangla ? '--font: "Kalpurush", sans-serif;' : '--font: -apple-system, sans-serif;' }}
}

/* HEADER */
.kyc-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px 30px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 20px;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 35px;
    color: #fff;
    flex-shrink: 0;
}

.header-content h4 {
    color: #fff;
    font-size: 26px;
    font-weight: 700;
    margin: 0 0 5px 0;
    font-family: var(--font);
}

.header-content p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 14px;
}

/* KYC CARD */
.kyc-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
    padding: 30px;
    margin-bottom: 20px;
}

/* STATUS DISPLAY */
.status-display {
    text-align: center;
    padding: 25px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    margin-bottom: 30px;
    backdrop-filter: blur(10px);
}

.status-label {
    font-size: 15px;
    color: #fff;
    margin-bottom: 12px;
    font-weight: 600;
    font-family: var(--font);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 15px;
    font-family: var(--font);
}

.status-badge.pending {
    background: rgba(255, 193, 7, 0.3);
    color: #fff;
    border: 2px solid #ffc107;
}

.status-badge.approved {
    background: rgba(40, 167, 69, 0.3);
    color: #fff;
    border: 2px solid #28a745;
}

.status-badge.rejected {
    background: rgba(220, 53, 69, 0.3);
    color: #fff;
    border: 2px solid #dc3545;
}

.status-badge i {
    font-size: 18px;
}

.status-message {
    color: #fff;
    font-size: 14px;
    margin: 0;
    font-family: var(--font);
}

/* FORM */
.form-group {
    margin-bottom: 25px;
}

label {
    display: block;
    font-weight: 600;
    color: #fff;
    margin-bottom: 8px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font);
}

label small {
    font-weight: 400;
    opacity: 0.9;
    font-size: 12px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s;
    background: rgba(255, 255, 255, 0.95);
    color: #2c3e50;
    font-family: var(--font);
}

.form-input:focus {
    outline: none;
    border-color: #fff;
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
    background: #fff;
}

.error-text {
    display: block;
    color: #fff;
    background: rgba(220, 53, 69, 0.3);
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    margin-top: 6px;
    font-family: var(--font);
}

/* PHOTO UPLOAD */
.photo-upload-box {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.15);
    border: 2px dashed rgba(255, 255, 255, 0.4);
    border-radius: 12px;
    transition: all 0.3s;
    backdrop-filter: blur(10px);
}

.photo-upload-box:hover {
    border-color: #fff;
    background: rgba(255, 255, 255, 0.2);
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
    border-radius: 10px;
    border: 3px solid #fff;
}

.preview-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(245, 87, 108, 0.8);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s;
}

.photo-preview:hover .preview-overlay {
    opacity: 1;
}

.preview-overlay i {
    color: #fff;
    font-size: 30px;
}

.upload-area {
    flex: 1;
}

.file-input {
    display: none;
}

.upload-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    background: #fff;
    color: #f5576c;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
    font-size: 14px;
    font-family: var(--font);
}

.upload-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
}

/* SUBMIT BUTTON */
.btn-submit {
    width: 100%;
    padding: 14px 24px;
    background: #fff;
    color: #f5576c;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
    font-family: var(--font);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* PENDING NOTICE */
.pending-notice {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.2);
    border-left: 4px solid #fff;
    border-radius: 10px;
    color: #fff;
    font-weight: 500;
    backdrop-filter: blur(10px);
    font-family: var(--font);
}

.pending-notice i {
    font-size: 24px;
}

/* INFO CARDS */
.info-card {
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.instructions-card {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.why-kyc-card {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.info-card h6 {
    color: #fff;
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: var(--font);
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    padding: 10px 0;
    color: #fff;
    font-size: 13px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    font-family: var(--font);
}

.info-list li:last-child {
    border-bottom: none;
}

.info-list li i {
    font-size: 12px;
    margin-top: 2px;
    flex-shrink: 0;
}

/* ANIMATIONS */
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

.kyc-card, .info-card {
    animation: fadeIn 0.5s ease;
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .kyc-header {
        padding: 20px;
    }
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    .header-icon {
        width: 60px;
        height: 60px;
        font-size: 30px;
    }
    .header-content h4 {
        font-size: 22px;
    }
}

@media (max-width: 767px) {
    .kyc-card {
        padding: 20px;
    }
    .photo-upload-box {
        flex-direction: column;
        text-align: center;
    }
    .upload-btn {
        width: 100%;
    }
    .info-card {
        padding: 16px;
    }
}
</style>

{{-- ===================== JAVASCRIPT ===================== --}}
<script>
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {

        const isBangla = {{ $isBangla ? 'true' : 'false' }};
        const maxFileSize = 5 * 1024 * 1024; // 5MB

        const form = document.getElementById('kycForm');
        const submitBtn = document.querySelector('.btn-submit');

        // FORM VALIDATION
        if (form) {
            form.addEventListener('submit', function(e) {
                const documentType = document.getElementById('documentType');
                const firstPhoto = document.getElementById('firstPhoto');
                const secondPhoto = document.getElementById('secondPhoto');

                if (!documentType.value) {
                    e.preventDefault();
                    alert(isBangla ? 'ডকুমেন্ট ধরন নির্বাচন করুন' : 'Please select document type');
                    documentType.focus();
                    return;
                }

                if (!firstPhoto.files || firstPhoto.files.length === 0) {
                    e.preventDefault();
                    alert(isBangla ? 'প্রথম ছবি আপলোড করুন' : 'Please upload first photo');
                    return;
                }

                if (!secondPhoto.files || secondPhoto.files.length === 0) {
                    e.preventDefault();
                    alert(isBangla ? 'দ্বিতীয় ছবি আপলোড করুন' : 'Please upload second photo');
                    return;
                }

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

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + (isBangla ? 'জমা দেওয়া হচ্ছে...' : 'Submitting...');
                submitBtn.disabled = true;
            });
        }

        console.log('✅ KYC Verification Loaded');
    });
})();

// IMAGE PREVIEW FUNCTION
function previewImage(event, previewId) {
    const file = event.target.files[0];
    if (!file) return;

    const isBangla = {{ $isBangla ? 'true' : 'false' }};

    if (!file.type.startsWith('image/')) {
        alert(isBangla ? 'শুধুমাত্র ছবি ফাইল আপলোড করুন' : 'Please upload image files only');
        event.target.value = '';
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        alert(isBangla ? 'ফাইল সাইজ ৫MB এর কম হতে হবে' : 'File size must be less than 5MB');
        event.target.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById(previewId).src = reader.result;
    };
    reader.readAsDataURL(file);
}
</script>

@endsection
