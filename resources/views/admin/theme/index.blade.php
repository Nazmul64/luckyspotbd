@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4>Theme Settings</h4>
        <a href="{{ route('theme.create') }}" class="btn btn-primary">
            Add Theme
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Primary Color</th>
                <th>Secondary Color</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($themes as $key => $item)
            <tr>
                <td>{{ $key+1 }}</td>

                <td>
                    <span style="background:{{ $item->primary_color }};
                    padding:6px 20px; color:#fff;">
                        {{ $item->primary_color }}
                    </span>
                </td>

                <td>
                    <span style="background:{{ $item->secondary_color }};
                    padding:6px 20px; color:#fff;">
                        {{ $item->secondary_color }}
                    </span>
                </td>

                <td>
                    @if($item->status == 1)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('theme.edit',$item->id) }}"
                       class="btn btn-sm btn-info">
                        Edit
                    </a>
                    <form action="{{ route('theme.destroy',$item->id) }}"
                          method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
