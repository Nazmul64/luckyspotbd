@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow rounded-4">

                <!-- Card Header -->
                <div class="card-header bg-primary text-white text-center rounded-top">
                    <h4 class="mb-0">Add New Notice</h4>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{ route('notices.store') }}" method="POST">
                        @csrf

                        <!-- Notice Text -->
                        <div class="mb-3">
                            <label for="notices_text" class="form-label fw-bold">Notice Text</label>
                            <textarea
                                class="form-control @error('notices_text') is-invalid @enderror"
                                id="notices_text"
                                name="notices_text"
                                rows="4"
                                placeholder="Enter your notice text here..."
                                required
                            >{{ old('notices_text') }}</textarea>
                            @error('notices_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success rounded-pill">
                                <i class="bi bi-save"></i> Save Notice
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
