@extends('admin.master')

@section('admin')
<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Create Terms & Conditions</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('Termscondition.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Title EN --}}
                    <div class="mb-3">
                        <label class="form-label">Title (EN)</label>
                        <input type="text" name="title[en]" class="form-control"
                               value="{{ old('title.en') }}" placeholder="Enter English Title">
                        @error('title.en') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Title BN --}}
                    <div class="mb-3">
                        <label class="form-label">Title (BN)</label>
                        <input type="text" name="title[bn]" class="form-control"
                               value="{{ old('title.bn') }}" placeholder="Enter Bangla Title">
                        @error('title.bn') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Description EN --}}
                    <div class="mb-3">
                        <label class="form-label">Description (EN)</label>
                        <textarea name="description[en]" class="form-control" rows="6" placeholder="Enter English Description">{{ old('description.en') }}</textarea>
                        @error('description.en') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Description BN --}}
                    <div class="mb-3">
                        <label class="form-label">Description (BN)</label>
                        <textarea name="description[bn]" class="form-control" rows="6" placeholder="Enter Bangla Description">{{ old('description.bn') }}</textarea>
                        @error('description.bn') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Save Terms & Conditions</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
