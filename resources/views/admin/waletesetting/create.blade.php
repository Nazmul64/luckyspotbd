@extends('admin.master')
@section('admin')
<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Create Walate</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('waletesetting.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bankname" class="form-control"
                               value="{{ old('bankname') }}" placeholder="Enter bank name">
                        @error('bankname') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="accountnumber" class="form-control"
                               value="{{ old('accountnumber') }}" placeholder="Enter account number">
                        @error('accountnumber') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" id="photoInput" class="form-control" accept="image/*">
                        @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image Preview</label><br>
                        <img id="photoPreview" src="#" alt="Preview"
                             style="max-width: 150px; display: none; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Save Walate</button>
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
