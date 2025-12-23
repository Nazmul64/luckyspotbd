@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">

    <a href="{{ route('lottery.index') }}" class="btn btn-success mb-3">
        <i class="bi bi-list"></i> Ticket List
    </a>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3 text-uppercase fw-bold">
                <i class="bi bi-pencil-square"></i> Edit Lottery Ticket
            </h5>

            <form action="{{ route('lottery.update', $lottery->id) }}" method="POST" enctype="multipart/form-data" id="lotteryEditForm">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Ticket Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $lottery->name) }}"
                           placeholder="Enter lottery name" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Ticket Price (টাকা) <span class="text-danger">*</span>
                    </label>
                    <input type="number" step="0.01" min="0" name="price"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $lottery->price) }}"
                           placeholder="Enter ticket price" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                              rows="3" placeholder="Write lottery description...">{{ old('description', $lottery->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Photo --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ticket Image</label>
                    <input type="file" name="new_photo" class="form-control @error('new_photo') is-invalid @enderror"
                           accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" id="photoInput">
                    <small class="text-muted">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF, WEBP</small>
                    @error('new_photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Current Image --}}
                    @if($lottery->photo)
                        <div class="mt-2" id="currentImage">
                            <label class="form-label fw-semibold">Current Image:</label>
                            <img src="{{ asset('uploads/lottery/'.$lottery->photo) }}"
                                 class="img-thumbnail d-block"
                                 style="max-width: 200px; max-height: 200px; object-fit: cover;"
                                 alt="Current lottery image">
                        </div>
                    @endif

                    {{-- New Image Preview --}}
                    <div id="imagePreview" class="mt-2" style="display: none;">
                        <label class="form-label fw-semibold">New Image Preview:</label>
                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail d-block"
                             style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger mt-2" id="removePreview">
                            <i class="bi bi-x-circle"></i> Remove New Image
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
                               value="{{ old('first_prize', $lottery->first_prize) }}"
                               placeholder="e.g., 10000">
                        @error('first_prize')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">2nd Prize (টাকা)</label>
                        <input type="number" step="0.01" min="0" name="second_prize"
                               class="form-control @error('second_prize') is-invalid @enderror"
                               value="{{ old('second_prize', $lottery->second_prize) }}"
                               placeholder="e.g., 5000">
                        @error('second_prize')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">3rd Prize (টাকা)</label>
                        <input type="number" step="0.01" min="0" name="third_prize"
                               class="form-control @error('third_prize') is-invalid @enderror"
                               value="{{ old('third_prize', $lottery->third_prize) }}"
                               placeholder="e.g., 2500">
                        @error('third_prize')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Multiple Packages --}}
                <h5 class="mt-4 mb-3 text-primary">
                    <i class="bi bi-box-seam"></i> Multiple Packages (Optional)
                </h5>
                <div class="mb-3">
                    <div id="packages-wrapper">
                        @php
                            $titles = old('multiple_title', $lottery->multiple_title ?? []);
                            $prices = old('multiple_price', $lottery->multiple_price ?? []);
                        @endphp
                        @if(is_array($titles) && count($titles) > 0)
                            @foreach($titles as $i => $title)
                                <div class="row mb-2 package-item">
                                    <div class="col-md-5">
                                        <input type="text" name="multiple_title[]" class="form-control"
                                               value="{{ $title }}"
                                               placeholder="Package Title (e.g., Gold Package)">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" step="0.01" min="0" name="multiple_price[]" class="form-control"
                                               value="{{ $prices[$i] ?? '' }}"
                                               placeholder="Package Price (টাকা)">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-package w-100">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row mb-2 package-item">
                                <div class="col-md-5">
                                    <input type="text" name="multiple_title[]" class="form-control"
                                           placeholder="Package Title (e.g., Gold Package)">
                                </div>
                                <div class="col-md-5">
                                    <input type="number" step="0.01" min="0" name="multiple_price[]" class="form-control"
                                           placeholder="Package Price (টাকা)">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success add-package w-100">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-primary mb-3" id="add-package">
                        <i class="bi bi-plus-circle"></i> Add Package
                    </button>
                    <small class="text-muted d-block">Add multiple package options with different prices</small>
                </div>

                {{-- Video Settings --}}
                <h5 class="mt-4 mb-3 text-primary">
                    <i class="bi bi-camera-video"></i> Video Settings (Live Draw)
                </h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Video URL</label>
                    <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror"
                           value="{{ old('video_url', $lottery->video_url) }}"
                           placeholder="https://www.youtube.com/watch?v=...">
                    <small class="text-muted">YouTube URL or direct video link</small>
                    @error('video_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="video_enabled" value="1" class="form-check-input" id="video_enabled"
                        {{ old('video_enabled', $lottery->video_enabled) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="video_enabled">
                        Enable Video Streaming
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Video Scheduled At</label>
                    <input type="datetime-local" name="video_scheduled_at" id="videoScheduledAt"
                           class="form-control @error('video_scheduled_at') is-invalid @enderror"
                           value="{{ old('video_scheduled_at', $lottery->video_scheduled_at ? $lottery->video_scheduled_at->format('Y-m-d\TH:i') : '') }}">
                    <small class="text-muted">যে সময় দিবেন ঠিক ওই সময়েই ভিডিও শো করবে</small>
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
                           value="{{ old('draw_date', $lottery->draw_date ? $lottery->draw_date->format('Y-m-d\TH:i') : '') }}"
                           required>
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
                                    <option value="{{ $type }}" {{ old('win_type', $lottery->win_type) == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Custom Days">
                                @for($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}days" {{ old('win_type', $lottery->win_type) == $i.'days' ? 'selected' : '' }}>
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
                            <option value="active" {{ old('status', $lottery->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $lottery->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="completed" {{ old('status', $lottery->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        <i class="bi bi-save"></i> Update Lottery
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
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // Image Preview
    // ============================================
    const photoInput = document.getElementById('photoInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const currentImage = document.getElementById('currentImage');
    const removePreviewBtn = document.getElementById('removePreview');

    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size
            if (file.size > 2 * 1024 * 1024) {
                alert('⚠️ File size must be less than 2MB!');
                photoInput.value = '';
                imagePreview.style.display = 'none';
                return;
            }

            // Validate file type
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
                if (currentImage) {
                    currentImage.style.opacity = '0.5';
                }
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
            if (currentImage) {
                currentImage.style.opacity = '1';
            }
        }
    });

    removePreviewBtn.addEventListener('click', function() {
        photoInput.value = '';
        imagePreview.style.display = 'none';
        previewImg.src = '';
        if (currentImage) {
            currentImage.style.opacity = '1';
        }
    });

    // ============================================
    // Countdown Timer
    // ============================================
    const drawInput = document.getElementById('draw_date');
    const countdownEl = document.getElementById('countdown');

    function format12Hour(date) {
        let hours = date.getHours(), minutes = date.getMinutes(), seconds = date.getSeconds();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;
        return `${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')} ${ampm}`;
    }

    function updateCountdown() {
        const drawTime = drawInput.value;
        if(!drawTime) {
            countdownEl.textContent = '';
            return;
        }

        const drawDate = new Date(drawTime);
        const now = new Date();
        const diff = drawDate - now;

        if(diff <= 0) {
            countdownEl.textContent = '🎉 Draw time has arrived or passed!';
            countdownEl.classList.remove('text-success');
            countdownEl.classList.add('text-danger');
            return;
        }

        const days = Math.floor(diff / (1000*60*60*24));
        const hours = Math.floor((diff / (1000*60*60)) % 24);
        const minutes = Math.floor((diff / (1000*60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);

        countdownEl.textContent = `⏳ ${days}d ${hours}h ${minutes}m ${seconds}s remaining | Draw Time: ${format12Hour(drawDate)}`;
        countdownEl.classList.remove('text-danger');
        countdownEl.classList.add('text-success');
    }

    drawInput.addEventListener('input', updateCountdown);
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // ============================================
    // Multiple Packages
    // ============================================
    const addPackageBtn = document.getElementById('add-package');
    const wrapper = document.getElementById('packages-wrapper');

    addPackageBtn.addEventListener('click', function() {
        const html = `<div class="row mb-2 package-item">
            <div class="col-md-5">
                <input type="text" name="multiple_title[]" class="form-control"
                    placeholder="Package Title (e.g., Gold Package)">
            </div>
            <div class="col-md-5">
                <input type="number" step="0.01" min="0" name="multiple_price[]" class="form-control"
                    placeholder="Package Price (টাকা)">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-package w-100">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
        </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
    });

    wrapper.addEventListener('click', function(e) {
        if(e.target && (e.target.classList.contains('remove-package') || e.target.closest('.remove-package'))){
            const packageItem = e.target.closest('.package-item');
            if(wrapper.querySelectorAll('.package-item').length > 1) {
                packageItem.remove();
            } else {
                alert('⚠️ At least one package field must remain!');
            }
        }
    });
});
</script>

<style>
.package-item {
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

#imagePreview img,
#currentImage img {
    transition: all 0.3s ease;
    border: 2px solid #dee2e6;
}

#imagePreview img:hover,
#currentImage img:hover {
    transform: scale(1.05);
    border-color: #0d6efd;
}
</style>
@endsection
