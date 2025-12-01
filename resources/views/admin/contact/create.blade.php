@extends('admin.master')

@section('admin')

<div class="container-fluid my-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4>Create Contact</h4>
            <a href="{{ route('contact.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <!-- Icon -->
                <div class="mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="text" name="icon" id="icon" class="form-control"
                           placeholder='e.g. bi bi-envelope-fill' value="{{ old('icon') }}">
                    @error('icon')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control"
                           placeholder="Enter title" value="{{ old('title') }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Email / Phone -->
                <div class="mb-3">
                    <label for="email_phone" class="form-label">Email / Phone</label>
                    <input type="text" name="email_phone" id="email_phone" class="form-control"
                           placeholder="Enter email or phone" value="{{ old('email_phone') }}">
                    @error('email_phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Map Code -->
                <div class="mb-3">
                    <label for="map_code" class="form-label">Map Code</label>
                    <textarea name="map_code" id="map_code" class="form-control" rows="3" placeholder="Enter map embed code">{{ old('map_code') }}</textarea>
                    @error('map_code')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Create Contact
                </button>
            </form>

        </div>
    </div>
</div>

@endsection
