@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Edit Testimonial</h4>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('testimonial.update', $testimonial->id) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name"
                   class="form-control"
                   value="{{ old('name', $testimonial->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Designation</label>
            <input type="text" name="designation"
                   class="form-control"
                   value="{{ old('designation', $testimonial->designation) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Message <span class="text-danger">*</span></label>
            <textarea name="message" rows="4"
                      class="form-control">{{ old('message', $testimonial->message) }}</textarea>
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
