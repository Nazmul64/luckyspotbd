@extends('admin.master')

@section('admin')
<div class="container">
    <h4 class="mb-3">Add Why Choose Us</h4>

    <form action="{{ route('whychooseustickets.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Main Title</label>
            <input type="text" name="main_title" class="form-control">
        </div>

        <div class="mb-3">
            <label>Main Description</label>
            <textarea name="main_description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Icon (FontAwesome)</label>
            <input type="text" name="icon" class="form-control"
                   placeholder="fa-solid fa-star">
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('whychooseustickets.index') }}"
           class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
