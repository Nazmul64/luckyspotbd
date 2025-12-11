@extends('admin.master')

@section('admin')
<div class="container py-5">
    <h4 class="mb-4">Admin Profile</h4>

    <form action="{{ route('admin.profile.update', auth()->user()->id) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', auth()->user()->name) }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', auth()->user()->email) }}">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- Profile Image Upload --}}
        <div class="mb-3">
            <label class="form-label">Profile Image</label>
            <input type="file"
                   name="profile_photo"
                   class="form-control"
                   id="profilePhotoInput"
                   accept="image/*">

            @error('profile_photo')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            {{-- Preview --}}
            <div class="mt-3">
                <img id="previewImage"
                     src="{{ auth()->user()->image ? asset('uploads/admin/' . auth()->user()->image) : asset('default.png') }}"
                     alt="Preview"
                     width="120"
                     style="border-radius: 8px; border: 2px solid #ddd;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Update Profile</button>
    </form>
</div>


{{-- ============================ --}}
{{--   LIVE IMAGE PREVIEW SCRIPT  --}}
{{-- ============================ --}}
<script>
    document.getElementById('profilePhotoInput').addEventListener('change', function (event) {
        let reader = new FileReader();

        reader.onload = function () {
            document.getElementById('previewImage').src = reader.result;
        };

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    });
</script>

@endsection
