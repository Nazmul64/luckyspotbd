{{-- ============================================
     CREATE VIEW - Lottery Create Form
     Path: resources/views/admin/lottery/create.blade.php
     ============================================ --}}
@extends('admin.master')

@section('admin')
<div class="container-fluid py-4">
    <a href="{{ route('lottery.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Create New Lottery</h5>
        </div>

        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <h6 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Validation Errors:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('lottery.store') }}" method="POST" enctype="multipart/form-data" id="lotteryForm">
                @csrf

                {{-- Name Section --}}
                <div class="sec-header"><i class="bi bi-translate"></i> Lottery Name (Multilingual)</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">English Name <span class="text-danger">*</span></label>
                        <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                               value="{{ old('name_en') }}" placeholder="e.g., Super Lottery 2026" required>
                        @error('name_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">বাংলা নাম <span class="text-danger">*</span></label>
                        <input type="text" name="name_bn" class="form-control @error('name_bn') is-invalid @enderror"
                               value="{{ old('name_bn') }}" placeholder="যেমন: সুপার লটারি ২০২৬" required>
                        @error('name_bn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ticket Price (টাকা) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', 100) }}" placeholder="100" required>
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Description --}}
                <div class="sec-header"><i class="bi bi-card-text"></i> Description (Optional)</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">English Description</label>
                        <textarea name="description_en" class="form-control" rows="4"
                                  placeholder="Describe your lottery...">{{ old('description_en') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">বাংলা বর্ণনা</label>
                        <textarea name="description_bn" class="form-control" rows="4"
                                  placeholder="আপনার লটারির বর্ণনা লিখুন...">{{ old('description_bn') }}</textarea>
                    </div>
                </div>

                {{-- Photo Upload --}}
                <div class="sec-header"><i class="bi bi-image"></i> Lottery Image</div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Upload Image</label>
                    <input type="file" name="photo" id="photoInput" class="form-control" accept="image/*">
                    <small class="text-muted">Max: 2MB | Formats: JPEG, PNG, GIF, WEBP</small>

                    <div id="photoPreview" class="mt-3" style="display:none;">
                        <label class="text-success fw-semibold">Preview:</label>
                        <div class="position-relative d-inline-block">
                            <img id="photoImg" src="" class="img-thumbnail" style="max-width:250px; max-height:250px;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" id="removePhoto">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Prizes --}}
                <div class="sec-header"><i class="bi bi-trophy"></i> Prize Money</div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">🥇 1st Prize (টাকা)</label>
                        <input type="number" step="0.01" min="0" name="first_prize" class="form-control"
                               value="{{ old('first_prize', 100000) }}" placeholder="100000">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">🥈 2nd Prize (টাকা)</label>
                        <input type="number" step="0.01" min="0" name="second_prize" class="form-control"
                               value="{{ old('second_prize', 50000) }}" placeholder="50000">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">🥉 3rd Prize (টাকা)</label>
                        <input type="number" step="0.01" min="0" name="third_prize" class="form-control"
                               value="{{ old('third_prize', 25000) }}" placeholder="25000">
                    </div>
                </div>

                {{-- Gift Packages --}}
                <div class="sec-header"><i class="bi bi-box-seam"></i> Gift Packages (Optional)</div>
                <div class="mb-3">
                    <div id="packagesContainer">
                        <div class="row mb-2 package-row">
                            <div class="col-md-5">
                                <input type="text" name="multiple_title[]" class="form-control" placeholder="Package Name (e.g., Gold Pack)">
                            </div>
                            <div class="col-md-5">
                                <input type="number" step="0.01" min="0" name="multiple_price[]" class="form-control" placeholder="Price (e.g., 5000)">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success w-100 add-package">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Video Settings --}}
                <div class="sec-header"><i class="bi bi-camera-video-fill"></i> Live Draw Video Settings</div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input type="hidden" name="video_enabled" value="0">
                        <input type="checkbox" name="video_enabled" value="1" class="form-check-input"
                               style="width:3rem;height:1.5rem;" id="videoEnabled" {{ old('video_enabled') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold ms-2" for="videoEnabled">Enable Live Draw Video</label>
                    </div>
                </div>

                <div id="videoSettingsBox" style="display:{{ old('video_enabled') ? 'block' : 'none' }};">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Video Source Type <span class="text-danger">*</span></label>
                            <select name="video_type" class="form-select" id="videoType">
                                <option value="upload" {{ old('video_type') == 'upload' ? 'selected' : '' }}>📁 Upload Video File</option>
                                <option value="direct" {{ old('video_type', 'direct') == 'direct' ? 'selected' : '' }}>🔗 Direct URL</option>
                                <option value="youtube" {{ old('video_type') == 'youtube' ? 'selected' : '' }}>📺 YouTube Video</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Schedule Video Time (Optional)</label>
                            <input type="datetime-local" name="video_scheduled_at" class="form-control"
                                   id="videoSchedule" value="{{ old('video_scheduled_at') }}">
                            <small class="text-muted">When to show the video</small>
                        </div>
                    </div>

                    {{-- Upload Option --}}
                    <div id="uploadBox" class="video-option-box">
                        <label class="form-label fw-semibold">Upload Video File <span class="text-danger">*</span></label>
                        <input type="file" name="video_file" id="videoFileInput" class="form-control" accept="video/*">
                        <small class="text-muted">Max: 500MB | Formats: MP4, WEBM, OGG, MOV</small>

                        <div id="videoPreview" class="mt-3" style="display:none;">
                            <label class="text-success fw-semibold">Preview:</label>
                            <div class="position-relative">
                                <video id="videoPlayer" controls class="w-100" style="max-height:350px; border-radius:8px;"></video>
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" id="removeVideo">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Direct URL Option --}}
                    <div id="directBox" class="video-option-box" style="display:none;">
                        <label class="form-label fw-semibold">Direct Video URL <span class="text-danger">*</span></label>
                        <input type="url" name="video_url_direct" class="form-control"
                               value="{{ old('video_url_direct') }}"
                               placeholder="https://example.com/video.mp4">
                        <small class="text-muted">Full URL to your video file</small>
                    </div>

                    {{-- YouTube Option --}}
                    <div id="youtubeBox" class="video-option-box" style="display:none;">
                        <label class="form-label fw-semibold">YouTube URL or Video ID <span class="text-danger">*</span></label>
                        <input type="text" name="video_url_youtube" class="form-control"
                               value="{{ old('video_url_youtube') }}"
                               placeholder="https://youtube.com/watch?v=dQw4w9WgXcQ or dQw4w9WgXcQ">
                        <small class="text-muted">Paste full YouTube link or just the video ID</small>
                    </div>
                </div>

                {{-- Draw Settings --}}
                <div class="sec-header"><i class="bi bi-calendar-event"></i> Draw Date & Time</div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Draw Date & Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="draw_date" id="drawDateInput" class="form-control"
                           value="{{ old('draw_date') }}" required>

                    {{-- Live Countdown Preview --}}
                    <div id="countdownPreview" class="mt-3 p-3 border rounded" style="display:none; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <small class="text-muted d-block mb-1">Draw will happen in:</small>
                                <h5 class="mb-0 text-primary fw-bold" id="countdownText">
                                    <span class="spinner-border spinner-border-sm"></span> Calculating...
                                </h5>
                            </div>
                            <div class="text-end">
                                <i class="bi bi-alarm display-4 text-primary opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Win Frequency Type <span class="text-danger">*</span></label>
                        <select name="win_type" class="form-select" required>
                            <option value="">-- Select Win Type --</option>
                            <optgroup label="Standard Frequency">
                                <option value="daily" {{ old('win_type') == 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ old('win_type') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ old('win_type') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ old('win_type') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </optgroup>
                            <optgroup label="Custom Period (Days)">
                                @for($i = 1; $i <= 30; $i++)
                                <option value="{{ $i }}days" {{ old('win_type') == $i.'days' ? 'selected' : '' }}>Every {{ $i }} Day{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>✅ Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>⏸️ Inactive</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>🏁 Completed</option>
                        </select>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="bi bi-check-circle"></i> Create Lottery
                    </button>
                    <a href="{{ route('lottery.index') }}" class="btn btn-secondary btn-lg px-5 ms-2">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.sec-header {
    font-size: 1.15rem;
    font-weight: 600;
    color: #0d6efd;
    border-bottom: 2px solid #0d6efd;
    padding-bottom: 0.5rem;
    margin: 2.5rem 0 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sec-header:first-of-type {
    margin-top: 0;
}

.package-row {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.video-option-box {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Photo Preview
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');
    const photoImg = document.getElementById('photoImg');
    const removePhoto = document.getElementById('removePhoto');

    photoInput?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('⚠️ File too large! Maximum size is 2MB.');
                this.value = '';
                photoPreview.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                photoImg.src = e.target.result;
                photoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    removePhoto?.addEventListener('click', () => {
        photoInput.value = '';
        photoPreview.style.display = 'none';
        photoImg.src = '';
    });

    // Video Preview
    const videoFileInput = document.getElementById('videoFileInput');
    const videoPreview = document.getElementById('videoPreview');
    const videoPlayer = document.getElementById('videoPlayer');
    const removeVideo = document.getElementById('removeVideo');

    videoFileInput?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 500 * 1024 * 1024) {
                alert('⚠️ Video too large! Maximum size is 500MB.');
                this.value = '';
                videoPreview.style.display = 'none';
                return;
            }

            const url = URL.createObjectURL(file);
            videoPlayer.src = url;
            videoPreview.style.display = 'block';
        }
    });

    removeVideo?.addEventListener('click', () => {
        videoFileInput.value = '';
        videoPreview.style.display = 'none';
        videoPlayer.src = '';
    });

    // Package Management
    const packagesContainer = document.getElementById('packagesContainer');

    packagesContainer?.addEventListener('click', (e) => {
        if (e.target.closest('.add-package')) {
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2 package-row';
            newRow.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="multiple_title[]" class="form-control" placeholder="Package Name">
                </div>
                <div class="col-md-5">
                    <input type="number" step="0.01" min="0" name="multiple_price[]" class="form-control" placeholder="Price">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger w-100 remove-package">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </div>
            `;
            packagesContainer.appendChild(newRow);
        }

        if (e.target.closest('.remove-package')) {
            if (packagesContainer.querySelectorAll('.package-row').length > 1) {
                e.target.closest('.package-row').remove();
            } else {
                alert('⚠️ At least one package row is required!');
            }
        }
    });

    // Video Settings Toggle
    const videoEnabled = document.getElementById('videoEnabled');
    const videoSettingsBox = document.getElementById('videoSettingsBox');

    videoEnabled?.addEventListener('change', function() {
        videoSettingsBox.style.display = this.checked ? 'block' : 'none';
    });

    // Video Type Switching
    const videoType = document.getElementById('videoType');
    const uploadBox = document.getElementById('uploadBox');
    const directBox = document.getElementById('directBox');
    const youtubeBox = document.getElementById('youtubeBox');

    function switchVideoType(type) {
        uploadBox.style.display = type === 'upload' ? 'block' : 'none';
        directBox.style.display = type === 'direct' ? 'block' : 'none';
        youtubeBox.style.display = type === 'youtube' ? 'block' : 'none';
    }

    videoType?.addEventListener('change', function() {
        switchVideoType(this.value);
    });

    // Initialize video type
    if (videoType) switchVideoType(videoType.value);

    // Draw Date Countdown
    const drawDateInput = document.getElementById('drawDateInput');
    const countdownPreview = document.getElementById('countdownPreview');
    const countdownText = document.getElementById('countdownText');
    let countdownInterval;

    function updateCountdown() {
        if (!drawDateInput.value) {
            countdownPreview.style.display = 'none';
            return;
        }

        const target = new Date(drawDateInput.value);
        const now = new Date();
        const diff = target - now;

        if (diff <= 0) {
            countdownText.innerHTML = '<span class="text-danger">⚠️ Please select a future date!</span>';
            countdownPreview.style.display = 'block';
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        countdownText.innerHTML = `
            <i class="bi bi-hourglass-split"></i>
            ${days}d ${hours}h ${minutes}m ${seconds}s
        `;
        countdownPreview.style.display = 'block';
    }

    drawDateInput?.addEventListener('input', () => {
        clearInterval(countdownInterval);
        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);
    });

    // Set minimum date/time to now
    const now = new Date();
    const minDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
        .toISOString()
        .slice(0, 16);

    if (drawDateInput) drawDateInput.min = minDateTime;
    const videoSchedule = document.getElementById('videoSchedule');
    if (videoSchedule) videoSchedule.min = minDateTime;

    // Form Submit Handler
    const form = document.getElementById('lotteryForm');
    form?.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
    });

    // Auto-dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert-dismissible').forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endsection
