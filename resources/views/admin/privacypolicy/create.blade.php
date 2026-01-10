@extends('admin.master')

@section('admin')
<div class="container">
    <h4>Create Privacy Policy</h4>

    <form action="{{ route('privacypolicy.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Title (EN)</label>
            <input type="text" name="title[en]" class="form-control" value="{{ old('title.en') }}">
        </div>

        <div class="mb-3">
            <label>Title (BN)</label>
            <input type="text" name="title[bn]" class="form-control" value="{{ old('title.bn') }}">
        </div>

        <div class="mb-3">
            <label>Description (EN)</label>
            <textarea name="description[en]" class="form-control" rows="4">{{ old('description.en') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Description (BN)</label>
            <textarea name="description[bn]" class="form-control" rows="4">{{ old('description.bn') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
