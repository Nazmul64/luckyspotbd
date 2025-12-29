@extends('admin.master')

@section('admin')
<div class="container">
    <h4 class="mb-3">Edit Why Choose Us</h4>

    <form action="{{ route('whychooseustickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Main Title</label>
            <input type="text" name="main_title"
                   value="{{ $ticket->main_title }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Main Description</label>
            <textarea name="main_description"
                class="form-control"
                rows="3">{{ $ticket->main_description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title"
                   value="{{ $ticket->title }}"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description"
                class="form-control"
                rows="3">{{ $ticket->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Icon</label>
            <input type="text" name="icon"
                   value="{{ $ticket->icon }}"
                   class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('whychooseustickets.index') }}"
           class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
