@extends('admin.master')

@section('admin')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Create Settings</h4>
            <a href="{{ route('settings.index') }}" class="btn btn-success">Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Photo --}}
                <div class="mb-3">
                    <label for="photo" class="form-label">Site Logo (Photo)</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                    @error('photo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Favicon --}}
                <div class="mb-3">
                    <label for="favicon" class="form-label">Site Favicon</label>
                    <input type="file" name="favicon" id="favicon" class="form-control">
                    @error('favicon')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter phone number">
                    @error('phone')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email">
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                     {{-- Email --}}
                <div class="mb-3">
                    <label for="site_name" class="form-label">Site Name</label>
                    <input type="text" name="site_name" id="site_name" class="form-control" placeholder="Enter site name">
                    @error('site_name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Address --}}
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter address">
                    @error('address')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Social Media Links --}}
                <div class="mb-3">
                    <label for="facebook" class="form-label">Facebook Link</label>
                    <input type="text" name="facebook" id="facebook" class="form-control" placeholder="Enter Facebook URL">
                </div>

                <div class="mb-3">
                    <label for="twitter" class="form-label">Twitter Link</label>
                    <input type="text" name="twitter" id="twitter" class="form-control" placeholder="Enter Twitter URL">
                </div>

                <div class="mb-3">
                    <label for="linkedin" class="form-label">LinkedIn Link</label>
                    <input type="text" name="linkedin" id="linkedin" class="form-control" placeholder="Enter LinkedIn URL">
                </div>

                <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram Link</label>
                    <input type="text" name="instagram" id="instagram" class="form-control" placeholder="Enter Instagram URL">
                </div>

                <div class="mb-3">
                    <label for="tilegram" class="form-label">Telegram Link</label>
                    <input type="text" name="tilegram" id="tilegram" class="form-control" placeholder="Enter Telegram URL">
                </div>

                <div class="mb-3">
                    <label for="youtube" class="form-label">YouTube Link</label>
                    <input type="text" name="youtube" id="youtube" class="form-control" placeholder="Enter YouTube URL">
                </div>

                {{-- Footer About --}}
                <div class="mb-3">
                    <label for="footer_about" class="form-label">Footer About</label>
                    <textarea name="footer_about" id="footer_about" class="form-control" rows="3" placeholder="Write about your site"></textarea>
                    @error('footer_about')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Footer Text --}}
                <div class="mb-3">
                    <label for="footer_text" class="form-label">Footer Text</label>
                    <textarea name="footer_text" id="footer_text" class="form-control" rows="2" placeholder="Enter footer text"></textarea>
                    @error('footer_text')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection
