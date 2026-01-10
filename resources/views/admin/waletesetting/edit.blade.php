@extends('admin.master')
@section('admin')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">Edit Wallet Setting</div>
            <div class="card-body">
                <form action="{{ route('waletesetting.update', $walate->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label>Bank Name (EN)</label>
                        <input type="text" name="bankname_en" class="form-control" value="{{ old('bankname_en', $walate->bankname['en'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label>Bank Name (BN)</label>
                        <input type="text" name="bankname_bn" class="form-control" value="{{ old('bankname_bn', $walate->bankname['bn'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label>Account Number (EN)</label>
                        <input type="text" name="accountnumber_en" class="form-control" value="{{ old('accountnumber_en', $walate->accountnumber['en'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label>Account Number (BN)</label>
                        <input type="text" name="accountnumber_bn" class="form-control" value="{{ old('accountnumber_bn', $walate->accountnumber['bn'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label>Photo</label>
                        <input type="file" name="photo" id="photoInput" class="form-control">
                        <img id="photoPreview" src="{{ $walate->photo ? asset('uploads/waletesetting/'.$walate->photo) : '#' }}"
                             style="max-width:150px; {{ $walate->photo ? '' : 'display:none;' }}" />
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $walate->status=='active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $walate->status=='inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button class="btn btn-success">Update</button>
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
