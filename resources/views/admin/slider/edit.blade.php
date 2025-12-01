@extends('admin.master')

@section('admin')
<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Edit Slider</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title Field -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="form-control"
                            value="{{ old('title', $slider->title) }}"
                            placeholder="Enter Title">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            rows="6">{{ old('description', $slider->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Photo Field -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo</label>
                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            class="form-control">
                        @error('photo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <!-- Show Current Photo -->
                        @if($slider->photo)
                            <div class="mt-2">
                                <img src="{{ asset($slider->photo) }}" alt="Slider Image" width="150" class="rounded shadow">
                            </div>
                        @endif
                    </div>

                    <!-- Status Field -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Select Status</label>
                        <select
                            id="status"
                            name="status"
                            class="form-select">
                            <option value="1" {{ old('status', $slider->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $slider->status) == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
