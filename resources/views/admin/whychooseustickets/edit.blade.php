{{-- resources/views/admin/whychooseustickets/edit.blade.php --}}

@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">

    <a href="{{ route('whychooseustickets.index') }}" class="btn btn-success mb-3">
        <i class="bi bi-list"></i> Back to List
    </a>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3 text-uppercase fw-bold">
                <i class="bi bi-pencil-square"></i> Edit Why Choose Us Item
            </h5>

            <form action="{{ route('whychooseustickets.update', $ticket->id) }}" method="POST" id="whyChooseEditForm">
                @csrf
                @method('PUT')

                {{-- Main Title (Multilingual) --}}
                <h5 class="mt-4 mb-3 text-primary section-header">
                    <i class="bi bi-translate"></i> Main Title (Multilingual)
                </h5>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Edit main title in both languages. Frontend will display based on user's language selection.
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Main Title (English)
                        </label>
                        <input type="text" name="main_title_en"
                            class="form-control @error('main_title_en') is-invalid @enderror"
                            placeholder="e.g., Why Choose Our Lottery?"
                            value="{{ old('main_title_en', $ticket->main_title_en) }}">
                        @error('main_title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            প্রধান শিরোনাম (বাংলা)
                        </label>
                        <input type="text" name="main_title_bn"
                            class="form-control @error('main_title_bn') is-invalid @enderror"
                            placeholder="যেমন: কেন আমাদের লটারি বেছে নিবেন?"
                            value="{{ old('main_title_bn', $ticket->main_title_bn) }}">
                        @error('main_title_bn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Main Description (Multilingual) --}}
                <h5 class="mt-4 mb-3 text-primary section-header">
                    <i class="bi bi-card-text"></i> Main Description (Multilingual)
                </h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Main Description (English)</label>
                        <textarea name="main_description_en"
                            class="form-control @error('main_description_en') is-invalid @enderror"
                            rows="4"
                            placeholder="Write main description in English...">{{ old('main_description_en', $ticket->main_description_en) }}</textarea>
                        @error('main_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">প্রধান বর্ণনা (বাংলা)</label>
                        <textarea name="main_description_bn"
                            class="form-control @error('main_description_bn') is-invalid @enderror"
                            rows="4"
                            placeholder="বাংলায় প্রধান বর্ণনা লিখুন...">{{ old('main_description_bn', $ticket->main_description_bn) }}</textarea>
                        @error('main_description_bn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Item Title (Multilingual) --}}
                <h5 class="mt-4 mb-3 text-primary section-header">
                    <i class="bi bi-bookmark"></i> Item Title (Multilingual)
                </h5>
                <div class="alert alert-warning">
                    <i class="bi bi-lightbulb"></i> This is the individual feature/benefit title.
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            Title (English)
                        </label>
                        <input type="text" name="title_en"
                            class="form-control @error('title_en') is-invalid @enderror"
                            placeholder="e.g., Secure & Safe"
                            value="{{ old('title_en', $ticket->title_en) }}">
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            শিরোনাম (বাংলা)
                        </label>
                        <input type="text" name="title_bn"
                            class="form-control @error('title_bn') is-invalid @enderror"
                            placeholder="যেমন: সুরক্ষিত এবং নিরাপদ"
                            value="{{ old('title_bn', $ticket->title_bn) }}">
                        @error('title_bn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Item Description (Multilingual) --}}
                <h5 class="mt-4 mb-3 text-primary section-header">
                    <i class="bi bi-file-text"></i> Item Description (Multilingual)
                </h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Description (English)</label>
                        <textarea name="description_en"
                            class="form-control @error('description_en') is-invalid @enderror"
                            rows="4"
                            placeholder="Write description in English...">{{ old('description_en', $ticket->description_en) }}</textarea>
                        @error('description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">বর্ণনা (বাংলা)</label>
                        <textarea name="description_bn"
                            class="form-control @error('description_bn') is-invalid @enderror"
                            rows="4"
                            placeholder="বাংলায় বর্ণনা লিখুন...">{{ old('description_bn', $ticket->description_bn) }}</textarea>
                        @error('description_bn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Icon --}}
                <h5 class="mt-4 mb-3 text-primary section-header">
                    <i class="bi bi-emoji-smile"></i> Icon
                </h5>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Icon (FontAwesome / Line Awesome)</label>
                    <input type="text" name="icon"
                        class="form-control @error('icon') is-invalid @enderror"
                        placeholder="e.g., las la-shield-alt or fa-solid fa-shield"
                        value="{{ old('icon', $ticket->icon) }}">
                    <small class="text-muted">
                        Use Font Awesome or Line Awesome classes.
                        Examples: <code>las la-shield-alt</code>, <code>fa-solid fa-trophy</code>
                    </small>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Current Icon --}}
                    @if($ticket->icon)
                        <div class="mt-3 p-3 border rounded bg-light">
                            <label class="form-label fw-semibold text-success">
                                <i class="bi bi-check-circle"></i> Current Icon:
                            </label>
                            <div class="text-center">
                                <i class="{{ $ticket->icon }}" style="font-size: 48px; color: #0d6efd;"></i>
                                <br>
                                <small class="text-muted">{{ $ticket->icon }}</small>
                            </div>
                        </div>
                    @endif

                    {{-- Icon Preview --}}
                    <div id="iconPreview" class="mt-3 p-3 border rounded" style="display: none;">
                        <label class="form-label fw-semibold text-info">
                            <i class="bi bi-eye"></i> New Icon Preview:
                        </label>
                        <div class="text-center">
                            <i id="previewIcon" style="font-size: 48px; color: #0d6efd;"></i>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        <i class="bi bi-save"></i> Update Item
                    </button>
                    <a href="{{ route('whychooseustickets.index') }}" class="btn btn-secondary px-4 py-2">
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
    // Icon Preview
    const iconInput = document.querySelector('input[name="icon"]');
    const iconPreview = document.getElementById('iconPreview');
    const previewIcon = document.getElementById('previewIcon');

    if (iconInput) {
        iconInput.addEventListener('input', function() {
            const iconClass = this.value.trim();

            if (iconClass && iconClass !== '{{ $ticket->icon }}') {
                previewIcon.className = iconClass;
                iconPreview.style.display = 'block';
            } else {
                iconPreview.style.display = 'none';
            }
        });

        // Trigger on page load if value exists and different from current
        if (iconInput.value && iconInput.value !== '{{ $ticket->icon }}') {
            iconInput.dispatchEvent(new Event('input'));
        }
    }
});
</script>

<style>
.section-header {
    border-bottom: 2px solid #0d6efd;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem !important;
}

#iconPreview {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border: 2px solid #2196f3 !important;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-info {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border: 1px solid #2196f3;
    color: #0d47a1;
    font-size: 13px;
    padding: 10px 15px;
    border-radius: 8px;
}
</style>
@endsection
