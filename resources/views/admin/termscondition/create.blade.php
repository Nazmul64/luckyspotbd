@extends('admin.master')

@section('admin')
<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Create Termscondition</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('Termscondition.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title') }}" placeholder="Enter Title">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Save Termscondition</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
