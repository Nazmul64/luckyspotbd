@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Add Testimonial</h4>

    <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Designation</label>
            <input type="text" name="designation" class="form-control" value="{{ old('designation') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" rows="4" class="form-control">{{ old('message') }}</textarea>
            @error('message')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('testimonial.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
