@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">

    <a href="{{ route('lottery.index') }}" class="btn btn-success mb-3">
        <i class="bi bi-list"></i> Ticket List
    </a>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3 text-uppercase fw-bold">
                <i class="bi bi-plus-circle"></i> Create New Lottery Ticket
            </h5>

            <form action="{{ route('lottery.store') }}" method="POST" enctype="multipart/form-data" id="lotteryForm">
                @csrf

                {{-- Multilingual Name --}}
                <h5 class="mt-4 mb-3 text-primary">
                    <i class="bi bi-translate"></i> Ticket Name (Multilingual)
                </h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Name (English) <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                            placeholder="Enter lottery name in English"
                            value="{{ old('name_en') }}" required>
                        @error('name_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            নাম (বাংলা) <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name_bn" class="form-control @error('name_bn') is-invalid @enderror"
                            placeholder="বাংলায় লটারির নাম লিখুন"
                            value="{{ old('name_bn') }}" required>
                        @error('name_bn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Ticket Price (টাকা) <span class="text-danger">*</span>
                    </label>
                    <input type="number" step="0.01" min="0" name="price"
                        class="form-control @error('price') is-invalid @enderror"
                        placeholder="Enter ticket price"
                        value="{{ old('price', 0) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Multilingual Description --}}
                <h5 class="mt-4 mb-3 text-primary">
                    <i class="bi bi-card-text"></i> Description (Multilingual)
                </h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Description (English)</label>
                        <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror"
                            rows="4" placeholder="Write description in English...">{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">বর্ণনা (বাংলা)</label>
                        <textarea name="description_bn" class="form-control @error('description_bn') is-invalid @enderror"
                            rows="4" placeholder="বাংলায় বর্ণনা লিখুন...">{{ old('description_bn') }}</textarea>
                        @error('description_bn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Photo --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ticket Image</label>
                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror"
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" id="photoInput">
                    <small class="text-muted">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF, WEBP</small>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Image Preview --}}
                    <div id="imagePreview" class="mt-2" style="display: none;">
                        <label class="form-label fw-semibold">Preview:</label>
                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail d-block"
                            style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger mt-2" id="removePreview">
                            <i class="bi bi-x-circle"></i> Remove Image
                        </button>
                    </div>
                </div>

                {{-- Prizes --}}
                <h5 class="mt-4 mb-3 text-primary">
                    <i class="bi bi-trophy"></i> Prize Information
                </h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">1st Prize (টাকা)</label>
                        <input type="number" step="0.01" min="0" name="first_prize"
                            class="form-control @error('first_prize') is-invalid @enderror"
                            placeholder="e.g., 10000" value="{{ old('first_prize', 0) }}">
                        @error('first_prize')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">2nd Prize (টাকা)</label>
                        <input type="number" step="0.01" min="0" name="second_prize"
                            class="form-control @error('second_prize') is-invalid @enderror"
                            placeholder="e.g., 5000" value="{{ old('second_prize', 0) }}">
                        @error('second_prize')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">3rd Prize (টাকা)</label>
                        <input type="number" step="0.01" min="0" name="third_prize"
                            class="form-control @error('third_prize') is-invalid @enderror"
                            placeholder="e.g., 2500" value="{{ old('third_prize', 0) }}">
                        @error('third_prize')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Multiple Packages --}}
                <h5 class="mt-4 mb-3 text-primary">
                    <i class="bi bi-box-seam"></i> Best Gift
                </h5>
                <div class="mb-3">
                    <div id="package-container">
                        @php
                            $oldTitles = old('multiple_title', ['']);
                            $oldPrices = old('multiple_price', ['']);
                        @endphp
                        @foreach($oldTitles as $index => $title)
                            <div class="row mb-2 package-row">
                                <div class="col-md-5">
                                    <input type="text" name="multiple_title[]" class="form-control"
                                        placeholder="Package Title (e.g., Gold Package)" value="{{ $title }}">
                                </div>
                                <div class="col-md-5">
                                    <input type="number" step="0.01" min="0" name="multiple_price[]" class="form-control"
                                        placeholder="Package Price (টাকা)" value="{{ $oldPrices[$index] ?? '' }}">
                                </div>
                                <div class="col-md-2">
                                    @if($index === 0)
                                        <button type="button" class="btn btn-success btn-add-package w-100">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-remove-package w-100">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">Add multiple package options with different prices</small>
                </div>

                {{-- Video Settings --}}
                <h5 class="mt-4 mb-3 text-primary">
                    <i class="bi bi-camera-video"></i> Video Settings (Live Draw)
                </h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Video URL</label>
                    <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror"
                        placeholder="https://www.youtube.com/watch?v=..." value="{{ old('video_url') }}">
                    <small class="text-muted">YouTube URL or direct video link</small>
                    @error('video_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="video_enabled" value="1" class="form-check-input" id="video_enabled"
                        {{ old('video_enabled') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="video_enabled">
                        Enable Video Streaming
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Video Scheduled At</label>
                    <input type="datetime-local" name="video_scheduled_at"
                        class="form-control @error('video_scheduled_at') is-invalid @enderror"
                        value="{{ old('video_scheduled_at') }}" id="videoScheduledAt">
                    <small class="text-muted">When should the video start showing? (Must be future time)</small>
                    @error('video_scheduled_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Draw Settings --}}
                <h5 class="mt-4 mb-3 text-primary">
                    <i class="bi bi-calendar-check"></i> Draw Settings
                </h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Draw Date & Time <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" name="draw_date" id="draw_date"
                        class="form-control @error('draw_date') is-invalid @enderror"
                        value="{{ old('draw_date') }}" required>
                    <small id="countdown" class="text-success d-block mt-2 fw-bold"></small>
                    @error('draw_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Win Type <span class="text-danger">*</span>
                        </label>
                        <select name="win_type" class="form-select @error('win_type') is-invalid @enderror" required>
                            <option value="">Select Win Type</option>
                            <optgroup label="Frequency">
                                @foreach(['daily', 'weekly', 'biweekly', 'monthly', 'quarterly', 'halfyearly', 'yearly'] as $type)
                                    <option value="{{ $type }}" {{ old('win_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Custom Days">
                                @for($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}days" {{ old('win_type') == $i.'days' ? 'selected' : '' }}>
                                        {{ $i }} Days
                                    </option>
                                @endfor
                            </optgroup>
                        </select>
                        @error('win_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        <i class="bi bi-save"></i> Create Lottery
                    </button>
                    <a href="{{ route('lottery.index') }}" class="btn btn-secondary px-4 py-2">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Image Preview
    const photoInput = document.getElementById('photoInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removePreviewBtn = document.getElementById('removePreview');

    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('⚠️ File size must be less than 2MB!');
                photoInput.value = '';
                imagePreview.style.display = 'none';
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('⚠️ Please select a valid image file!');
                photoInput.value = '';
                imagePreview.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });

    removePreviewBtn.addEventListener('click', function() {
        photoInput.value = '';
        imagePreview.style.display = 'none';
        previewImg.src = '';
    });

    // Countdown Timer
    const drawInput = document.getElementById('draw_date');
    const countdownEl = document.getElementById('countdown');

    function format12Hour(date) {
        let h = date.getHours(), m = date.getMinutes(), s = date.getSeconds();
        const ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12 || 12;
        return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')} ${ampm}`;
    }

    function updateCountdown() {
        const selected = drawInput.value;
        if(!selected) {
            countdownEl.textContent = '';
            return;
        }

        const drawDate = new Date(selected);
        const now = new Date();
        const diff = drawDate - now;

        if(diff <= 0) {
            countdownEl.textContent = '⚠️ Please select a future date and time';
            countdownEl.classList.remove('text-success');
            countdownEl.classList.add('text-danger');
            return;
        }

        const days = Math.floor(diff / (1000*60*60*24));
        const hours = Math.floor((diff / (1000*60*60)) % 24);
        const mins = Math.floor((diff / (1000*60)) % 60);
        const secs = Math.floor((diff / 1000) % 60);

        countdownEl.textContent = `⏳ ${days}d ${hours}h ${mins}m ${secs}s remaining | Draw Time: ${format12Hour(drawDate)}`;
        countdownEl.classList.remove('text-danger');
        countdownEl.classList.add('text-success');
    }

    drawInput.addEventListener('input', updateCountdown);
    setInterval(updateCountdown, 1000);
    updateCountdown();

    const now = new Date();
    const minDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
    drawInput.min = minDateTime;
    document.getElementById('videoScheduledAt').min = minDateTime;

    // Dynamic Packages
    const packageContainer = document.getElementById('package-container');

    packageContainer.addEventListener('click', function(e) {
        if(e.target.closest('.btn-add-package')) {
            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'package-row');
            row.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="multiple_title[]" class="form-control"
                        placeholder="Package Title (e.g., Gold Package)">
                </div>
                <div class="col-md-5">
                    <input type="number" step="0.01" min="0" name="multiple_price[]" class="form-control"
                        placeholder="Package Price (টাকা)">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-remove-package w-100">
                        <i class="bi bi-dash-lg"></i>
                    </button>
                </div>
            `;
            packageContainer.appendChild(row);
        }

        if(e.target.closest('.btn-remove-package')) {
            const packageRows = packageContainer.querySelectorAll('.package-row');
            if(packageRows.length > 1) {
                e.target.closest('.package-row').remove();
            } else {
                alert('⚠️ At least one package field must remain!');
            }
        }
    });

    // Form Validation
    const form = document.getElementById('lotteryForm');
    form.addEventListener('submit', function(e) {
        const drawDate = new Date(drawInput.value);
        const now = new Date();

        if (drawDate <= now) {
            e.preventDefault();
            alert('⚠️ Draw date must be in the future!');
            drawInput.focus();
            return false;
        }
    });
});
</script>

<style>
.package-row {
    animation: slideIn 0.3s ease;
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

#imagePreview img {
    transition: all 0.3s ease;
    border: 2px solid #dee2e6;
}

#imagePreview img:hover {
    transform: scale(1.05);
    border-color: #0d6efd;
}

.text-primary {
    border-bottom: 2px solid #0d6efd;
    padding-bottom: 0.5rem;
}
</style>
@endsection
