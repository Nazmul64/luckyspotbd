@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Create FAQ</h4>

    <form action="{{ route('faq.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" name="question"
                   class="form-control"
                   value="{{ old('question') }}">
            @error('question')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Answer</label>
            <textarea name="answer" rows="5"
                      class="form-control">{{ old('answer') }}</textarea>
            @error('answer')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('faq.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
