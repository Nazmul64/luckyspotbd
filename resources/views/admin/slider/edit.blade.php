@extends('admin.master')

@section('admin')

<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Edit Slider</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('slider.update', $slider->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $slider->title) }}">
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="5">{{ old('description', $slider->description) }}</textarea>
                    </div>

                    <!-- Photo -->
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control">

                        @if($slider->photo)
                            <div class="mt-2">
                                <img src="{{ asset($slider->photo) }}"
                                     width="120"
                                     class="img-thumbnail rounded">
                            </div>
                        @endif
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $slider->status == 1 ? 'selected' : '' }}>Inactive</option>
                            <option value="0" {{ $slider->status == 0 ? 'selected' : '' }}>Active</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Slider</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
