@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Create Theme Setting</h4>

    <form action="{{ route('theme.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Primary Color</label>
            <input type="color" name="primary_color"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Secondary Color</label>
            <input type="color" name="secondary_color"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button class="btn btn-success">Save Theme</button>
    </form>
</div>
@endsection
