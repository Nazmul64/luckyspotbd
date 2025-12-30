@extends('frontend.master')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6"style="margin-top:80px;">
            <div class="card border-0 shadow-lg p-4">

                @php
                    $kyc = Auth::user()->kyc ?? null;
                @endphp

                {{-- Show KYC Status --}}
                @if($kyc)
                    <div class="mb-4 text-center">
                        <h5>Your KYC Status:</h5>
                        @if($kyc->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($kyc->status == 'approved')
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                @endif

                {{-- Show form only if KYC is rejected or not submitted --}}
                @if(!$kyc || $kyc->status == 'rejected')
                    <form action="{{ route('frontend.key.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Document Type -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Document Type</label>
                            <select name="document_type" class="form-control" required>
                                <option value="">-- Select Document Type --</option>
                                <option value="passport" {{ old('document_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                <option value="nid" {{ old('document_type') == 'nid' ? 'selected' : '' }}>NID</option>
                                <option value="driving_license" {{ old('document_type') == 'driving_license' ? 'selected' : '' }}>Driving License</option>
                            </select>
                            @error('document_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- First Photo -->
                        <div class="mb-3 text-center">
                            <label class="form-label fw-semibold">First Photo</label>
                            <div>
                                <img src="{{ asset('uploads/avator.jpg') }}" id="firstPhotoPreview"
                                     class="rounded-circle border border-3 border-primary mb-2"
                                     style="width:6rem; height:6rem; object-fit:cover;">
                            </div>
                            <input type="file" name="document_first_part_photo" accept="image/*"
                                   class="form-control" onchange="previewImage(event, 'firstPhotoPreview')" required>
                            @error('document_first_part_photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Second Photo -->
                        <div class="mb-3 text-center">
                            <label class="form-label fw-semibold">Second Photo</label>
                            <div>
                                <img src="{{ asset('uploads/avator.jpg') }}" id="secondPhotoPreview"
                                     class="rounded-circle border border-3 border-primary mb-2"
                                     style="width:6rem; height:6rem; object-fit:cover;">
                            </div>
                            <input type="file" name="document_secound_part_photo" accept="image/*"
                                   class="form-control" onchange="previewImage(event, 'secondPhotoPreview')" required>
                            @error('document_secound_part_photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Submit KYC</button>
                    </form>
                @else
                    <div class="text-center mt-3">
                        <span class="text-muted">You cannot upload again until admin reviews your KYC.</span>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- JS Preview --}}
<script>
function previewImage(event, previewId) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById(previewId).src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
