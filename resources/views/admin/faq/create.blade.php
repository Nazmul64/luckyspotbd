@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Create FAQ</h4>

    <form action="{{ route('faq.store') }}" method="POST">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label>Title (English)</label>
            <input type="text"
                   name="title_en"
                   class="form-control"
                   placeholder="FAQ Title in English"
                   value="{{ old('title_en') }}">
            @error('title_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Title (Bangla)</label>
            <input type="text"
                   name="title_bn"
                   class="form-control"
                   placeholder="FAQ Title in Bangla"
                   value="{{ old('title_bn') }}">
            @error('title_bn')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label>Description (English)</label>
            <input type="text"
                   name="description_en"
                   class="form-control"
                   placeholder="Short description in English"
                   value="{{ old('description_en') }}">
            @error('description_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Description (Bangla)</label>
            <input type="text"
                   name="description_bn"
                   class="form-control"
                   placeholder="Short description in Bangla"
                   value="{{ old('description_bn') }}">
            @error('description_bn')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Question --}}
        <div class="mb-3">
            <label>Question (English)</label>
            <input class="form-control" name="question_en" value="{{ old('question_en') }}">
            @error('question_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Question (Bangla)</label>
            <input class="form-control" name="question_bn" value="{{ old('question_bn') }}">
            @error('question_bn')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Answer --}}
        <div class="mb-3">
            <label>Answer (English)</label>
            <textarea class="form-control" name="answer_en" rows="4">{{ old('answer_en') }}</textarea>
            @error('answer_en')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label>Answer (Bangla)</label>
            <textarea class="form-control" name="answer_bn" rows="4">{{ old('answer_bn') }}</textarea>
            @error('answer_bn')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('faq.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
