@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4>Edit Theme Setting</h4>

    <form action="{{ route('theme.update',$theme->id) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Primary Color</label>
            <input type="color" name="primary_color"
                   value="{{ $theme->primary_color }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Secondary Color</label>
            <input type="color" name="secondary_color"
                   value="{{ $theme->secondary_color }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $theme->status==1?'selected':'' }}>
                    Active
                </option>
                <option value="0" {{ $theme->status==0?'selected':'' }}>
                    Inactive
                </option>
            </select>
        </div>

        <button class="btn btn-primary">Update Theme</button>
    </form>
</div>
@endsection
