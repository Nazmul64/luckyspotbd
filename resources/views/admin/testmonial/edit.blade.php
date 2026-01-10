@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Edit Testimonial</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('testimonial.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name (EN) <span class="text-danger">*</span></label>
            <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $testimonial->name['en']) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Name (BN)</label>
            <input type="text" name="name_bn" class="form-control" value="{{ old('name_bn', $testimonial->name['bn'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Designation (EN)</label>
            <input type="text" name="designation_en" class="form-control" value="{{ old('designation_en', $testimonial->designation['en'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Designation (BN)</label>
            <input type="text" name="designation_bn" class="form-control" value="{{ old('designation_bn', $testimonial->designation['bn'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Message (EN) <span class="text-danger">*</span></label>
            <textarea name="message_en" rows="4" class="form-control">{{ old('message_en', $testimonial->message['en']) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Message (BN)</label>
            <textarea name="message_bn" rows="4" class="form-control">{{ old('message_bn', $testimonial->message['bn'] ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Title (EN)</label>
            <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $testimonial->title['en'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Title (BN)</label>
            <input type="text" name="title_bn" class="form-control" value="{{ old('title_bn', $testimonial->title['bn'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description (EN)</label>
            <input type="text" name="description_en" class="form-control" value="{{ old('description_en', $testimonial->description['en'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description (BN)</label>
            <input type="text" name="description_bn" class="form-control" value="{{ old('description_bn', $testimonial->description['bn'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
            @if($testimonial->photo)
                <div class="mt-2">
                    <small>Current Photo:</small><br>
                    <img src="{{ asset($testimonial->photo) }}" width="100" class="rounded">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('testimonial.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
