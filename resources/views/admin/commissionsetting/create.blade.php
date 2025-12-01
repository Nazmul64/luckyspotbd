@extends('admin.master')
@section('admin')
<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Create Commission</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('commissionsetting.store') }}" method="POST">
                    @csrf
                     <div class="mb-3">
                        <label class="form-label">Refer Commission (%)</label>
                        <input type="number" step="0.01" name="refer_commission" class="form-control" value="{{ old('refer_commission') }}" placeholder="Enter refer commission">
                        @error('refer_commission') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Generation Level 1 (%)</label>
                        <input type="number" step="0.01" name="generation_level_1" class="form-control" value="{{ old('generation_level_1') }}">
                        @error('generation_level_1') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Generation Level 2 (%)</label>
                        <input type="number" step="0.01" name="generation_level_2" class="form-control" value="{{ old('generation_level_2') }}">
                        @error('generation_level_2') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Generation Level 3 (%)</label>
                        <input type="number" step="0.01" name="generation_level_3" class="form-control" value="{{ old('generation_level_3') }}">
                        @error('generation_level_3') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Generation Level 4 (%)</label>
                        <input type="number" step="0.01" name="generation_level_4" class="form-control" value="{{ old('generation_level_4') }}">
                        @error('generation_level_4') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Generation Level 5 (%)</label>
                        <input type="number" step="0.01" name="generation_level_5" class="form-control" value="{{ old('generation_level_5') }}">
                        @error('generation_level_5') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>



                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Save Commission</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
