@extends('admin.master')
@section('admin')

<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Edit Walate</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('waletesetting.update', $Waleta_setup->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Bank Name --}}
                    <div class="mb-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bankname" class="form-control"
                               value="{{ old('bankname', $Waleta_setup->bankname) }}" placeholder="Enter bank name">
                        @error('bankname') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Account Number --}}
                    <div class="mb-3">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="accountnumber" class="form-control"
                               value="{{ old('accountnumber', $Waleta_setup->accountnumber) }}" placeholder="Enter account number">
                        @error('accountnumber') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Photo --}}
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" id="photoInput" class="form-control" accept="image/*">
                        @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Image Preview --}}
                    <div class="mb-3">
                        <label class="form-label">Image Preview</label><br>
                        <img id="photoPreview"
                             src="{{ $Waleta_setup->photo ? asset('uploads/waletesetting/' . $Waleta_setup->photo) : '#' }}"
                             alt="Preview"
                             style="max-width: 150px; {{ $Waleta_setup->photo ? '' : 'display:none;' }} border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status', $Waleta_setup->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $Waleta_setup->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Update Walate</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for Live Preview --}}
<script>
document.getElementById('photoInput').addEventListener('change', function(event) {
    let file = event.target.files[0];
    let preview = document.getElementById('photoPreview');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});
</script>
@endsection
