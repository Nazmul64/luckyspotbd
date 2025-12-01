@extends('admin.master')

@section('admin')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>About Us Create</h4>
            <a href="{{ route('aboutus.index') }}" class="btn btn-success">পেছনে যান</a>
        </div>
        <div class="card-body">
            <form action="{{ route('aboutus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">শিরোনাম (Title)</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="শিরোনাম লিখুন" value="{{ old('title') }}">
                    @error('title')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">বর্ণনা (Description)</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="বর্ণনা লিখুন">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="mb-3">
                    <label for="photo" class="form-label">ছবি (Photo)</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                    @error('photo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Preview -->
                <div class="mb-3">
                    <label class="form-label">Image Preview</label><br>
                    <img id="previewImg" src="{{ asset('uploads/aboutus/no-image.png') }}" alt="Preview Image" width="100">
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">স্ট্যাটাস (Status)</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">সেভ করুন</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Image Preview JavaScript -->
<script>
    const photoInput = document.getElementById('photo');
    const previewImg = document.getElementById('previewImg');

    photoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(file);
        } else {
            previewImg.setAttribute('src', "{{ asset('uploads/aboutus/no-image.png') }}");
        }
    });
</script>
@endsection
