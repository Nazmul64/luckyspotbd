@extends('admin.master')

@section('admin')
<div class="container">
    <h4>Edit Privacy Policy</h4>

    <form action="{{ route('privacypolicy.update', $privacypolicy->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title (EN)</label>
            <input type="text" name="title[en]" class="form-control" value="{{ old('title.en', $privacypolicy->title['en'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Title (BN)</label>
            <input type="text" name="title[bn]" class="form-control" value="{{ old('title.bn', $privacypolicy->title['bn'] ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Description (EN)</label>
            <textarea name="description[en]" class="form-control" rows="4">{{ old('description.en', $privacypolicy->description['en'] ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Description (BN)</label>
            <textarea name="description[bn]" class="form-control" rows="4">{{ old('description.bn', $privacypolicy->description['bn'] ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
