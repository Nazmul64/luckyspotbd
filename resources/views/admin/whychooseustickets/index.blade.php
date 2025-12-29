@extends('admin.master')

@section('admin')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Why Choose Us List</h4>
        <a href="{{ route('whychooseustickets.create') }}" class="btn btn-primary">
            + Add New
        </a>
    </div>



    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Main Title</th>
                <th>Title</th>
                <th>Icon</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $key => $ticket)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $ticket->main_title }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td><i class="{{ $ticket->icon }}"></i> {{ $ticket->icon }}</td>
                    <td>
                        <a href="{{ route('whychooseustickets.edit', $ticket->id) }}"
                           class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('whychooseustickets.destroy', $ticket->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
