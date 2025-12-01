@extends('admin.master')

@section('admin')
<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Edit Termscondition</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('Termscondition.update', $termscondition->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title', $termscondition->title) }}" placeholder="Enter Title">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', $termscondition->description) }}</textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Update Termscondition</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
