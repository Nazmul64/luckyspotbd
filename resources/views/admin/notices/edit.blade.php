@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow rounded-4">

                <!-- Card Header -->
                <div class="card-header bg-warning text-white text-center rounded-top">
                    <h4 class="mb-0">Edit Notice</h4>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{ route('notices.update', $notice->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Notice Text -->
                        <div class="mb-3">
                            <label for="notices_text" class="form-label fw-bold">Notice Text</label>
                            <textarea
                                class="form-control @error('notices_text') is-invalid @enderror"
                                id="notices_text"
                                name="notices_text"
                                rows="4"
                                required
                            >{{ old('notices_text', $notice->notices_text) }}</textarea>
                            @error('notices_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill">
                                <i class="bi bi-save"></i> Update Notice
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
