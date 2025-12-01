@extends('admin.master')

@section('admin')
<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Edit Privacy Policy</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('privacypolicy.update', $privacypolicy->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title', $privacypolicy->title) }}" placeholder="Enter Title">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', $privacypolicy->description) }}</textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Update Privacy Policy</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    CKEDITOR.replace('description');
</script>
@endsection
