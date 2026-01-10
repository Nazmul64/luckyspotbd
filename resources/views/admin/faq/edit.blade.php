@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Edit FAQ</h4>

    <form action="{{ route('faq.update', $faq->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Title (English)</label>
            <input type="text"
                   name="title_en"
                   class="form-control"
                   value="{{ $faq->title['en'] ?? '' }}">
            @error('title_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Title (Bangla)</label>
            <input type="text"
                   name="title_bn"
                   class="form-control"
                   value="{{ $faq->title['bn'] ?? '' }}">
            @error('title_bn')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">Description (English)</label>
            <input type="text"
                   name="description_en"
                   class="form-control"
                   value="{{ $faq->description['en'] ?? '' }}">
            @error('description_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description (Bangla)</label>
            <input type="text"
                   name="description_bn"
                   class="form-control"
                   value="{{ $faq->description['bn'] ?? '' }}">
            @error('description_bn')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Question --}}
        <div class="mb-3">
            <label>Question (English)</label>
            <input class="form-control" name="question_en"
                   value="{{ $faq->question['en'] ?? '' }}">
            @error('question_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Question (Bangla)</label>
            <input class="form-control" name="question_bn"
                   value="{{ $faq->question['bn'] ?? '' }}">
            @error('question_bn')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Answer --}}
        <div class="mb-3">
            <label>Answer (English)</label>
            <textarea class="form-control" name="answer_en" rows="4">{{ $faq->answer['en'] ?? '' }}</textarea>
            @error('answer_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Answer (Bangla)</label>
            <textarea class="form-control" name="answer_bn" rows="4">{{ $faq->answer['bn'] ?? '' }}</textarea>
            @error('answer_bn')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('faq.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
