@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Edit FAQ</h4>

    <form action="{{ route('faq.update',$faq->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" name="question"
                   class="form-control"
                   value="{{ old('question',$faq->question) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Answer</label>
            <textarea name="answer" rows="5"
                      class="form-control">{{ old('answer',$faq->answer) }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('faq.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
