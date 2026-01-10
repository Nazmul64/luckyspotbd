@extends('admin.master')
@section('admin')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">Create Wallet Setting</div>
            <div class="card-body">
                <form action="{{ route('waletesetting.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label>Bank Name (EN)</label>
                        <input type="text" name="bankname_en" class="form-control" value="{{ old('bankname_en') }}">
                        @error('bankname_en') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Bank Name (BN)</label>
                        <input type="text" name="bankname_bn" class="form-control" value="{{ old('bankname_bn') }}">
                        @error('bankname_bn') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Account Number (EN)</label>
                        <input type="text" name="accountnumber_en" class="form-control" value="{{ old('accountnumber_en') }}">
                        @error('accountnumber_en') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Account Number (BN)</label>
                        <input type="text" name="accountnumber_bn" class="form-control" value="{{ old('accountnumber_bn') }}">
                        @error('accountnumber_bn') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Photo</label>
                        <input type="file" name="photo" id="photoInput" class="form-control">
                        <img id="photoPreview" style="max-width:150px; display:none;" />
                        @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('photoInput').addEventListener('change', function(e){
    let file = e.target.files[0];
    let preview = document.getElementById('photoPreview');
    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    } else { preview.style.display='none'; }
});
</script>
@endsection
