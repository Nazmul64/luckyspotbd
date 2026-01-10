@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Edit Terms & Conditions</h4>

    <form action="{{ route('Termscondition.update', $termscondition->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Title (EN)</label>
            <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $termscondition->title['en']) }}">
        </div>
        <div class="mb-3">
            <label>Title (BN)</label>
            <input type="text" name="title_bn" class="form-control" value="{{ old('title_bn', $termscondition->title['bn']) }}">
        </div>
        <div class="mb-3">
            <label>Description (EN)</label>
            <textarea name="description_en" rows="5" class="form-control">{{ old('description_en', $termscondition->description['en']) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Description (BN)</label>
            <textarea name="description_bn" rows="5" class="form-control">{{ old('description_bn', $termscondition->description['bn']) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
