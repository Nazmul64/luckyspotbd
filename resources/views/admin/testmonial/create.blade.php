@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Add Testimonial</h4>

    <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name (EN) <span class="text-danger">*</span></label>
            <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}">
            @error('name_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Name (BN)</label>
            <input type="text" name="name_bn" class="form-control" value="{{ old('name_bn') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Designation (EN)</label>
            <input type="text" name="designation_en" class="form-control" value="{{ old('designation_en') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Designation (BN)</label>
            <input type="text" name="designation_bn" class="form-control" value="{{ old('designation_bn') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Message (EN) <span class="text-danger">*</span></label>
            <textarea name="message_en" rows="4" class="form-control">{{ old('message_en') }}</textarea>
            @error('message_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Message (BN)</label>
            <textarea name="message_bn" rows="4" class="form-control">{{ old('message_bn') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Title (EN)</label>
            <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Title (BN)</label>
            <input type="text" name="title_bn" class="form-control" value="{{ old('title_bn') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description (EN)</label>
            <input type="text" name="description_en" class="form-control" value="{{ old('description_en') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description (BN)</label>
            <input type="text" name="description_bn" class="form-control" value="{{ old('description_bn') }}">
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
