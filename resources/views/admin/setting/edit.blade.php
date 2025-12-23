@extends('admin.master')

@section('admin')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Edit Settings</h4>
            <a href="{{ route('settings.index') }}" class="btn btn-success">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Photo --}}
                <div class="mb-3">
                    <label for="photo" class="form-label">Site Logo (Photo)</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                    @if(!empty($setting->photo))
                        <img src="{{ asset('uploads/settings/' . $setting->photo) }}"
                             alt="Current Photo" class="img-thumbnail mt-2" width="60">
                    @endif
                    @error('photo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Favicon --}}
                <div class="mb-3">
                    <label for="favicon" class="form-label">Site Favicon</label>
                    <input type="file" name="favicon" id="favicon" class="form-control">
                    @if(!empty($setting->favicon))
                        <img src="{{ asset('uploads/settings/' . $setting->favicon) }}"
                             alt="Current Favicon" class="img-thumbnail mt-2" width="30">
                    @endif
                    @error('favicon')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $setting->phone }}">
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $setting->email }}">
                </div>

                    {{-- Site Name --}}
                <div class="mb-3">
                    <label for="site_name" class="form-label">Site Name</label>
                    <input type="text" name="site_name" id="site_name" class="form-control" value="{{ $setting->site_name }}">
                </div>

                {{-- Address --}}
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ $setting->address }}">
                </div>

                {{-- Social Media Links --}}
                <div class="mb-3">
                    <label for="facebook" class="form-label">Facebook Link</label>
                    <input type="text" name="facebook" id="facebook" class="form-control" value="{{ $setting->facebook }}">
                </div>

                <div class="mb-3">
                    <label for="twitter" class="form-label">Twitter Link</label>
                    <input type="text" name="twitter" id="twitter" class="form-control" value="{{ $setting->twitter }}">
                </div>

                <div class="mb-3">
                    <label for="linkedin" class="form-label">LinkedIn Link</label>
                    <input type="text" name="linkedin" id="linkedin" class="form-control" value="{{ $setting->linkedin }}">
                </div>

                <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram Link</label>
                    <input type="text" name="instagram" id="instagram" class="form-control" value="{{ $setting->instagram }}">
                </div>

                <div class="mb-3">
                    <label for="tilegram" class="form-label">Telegram Link</label>
                    <input type="text" name="tilegram" id="tilegram" class="form-control" value="{{ $setting->tilegram }}">
                </div>

                <div class="mb-3">
                    <label for="youtube" class="form-label">YouTube Link</label>
                    <input type="text" name="youtube" id="youtube" class="form-control" value="{{ $setting->youtube }}">
                </div>

                {{-- Footer About --}}
                <div class="mb-3">
                    <label for="footer_about" class="form-label">Footer About</label>
                    <textarea name="footer_about" id="footer_about" class="form-control" rows="3">{{ $setting->footer_about }}</textarea>
                </div>

                {{-- Footer Text --}}
                <div class="mb-3">
                    <label for="footer_text" class="form-label">Footer Text</label>
                    <textarea name="footer_text" id="footer_text" class="form-control" rows="2">{{ $setting->footer_text }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection
