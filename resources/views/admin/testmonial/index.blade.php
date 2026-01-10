@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4 class="mb-3">Testimonial List</h4>

    <a href="{{ route('testimonial.create') }}" class="btn btn-primary mb-3">+ Add Testimonial</a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name (EN)</th>
                <th>Name (BN)</th>
                <th>Designation (EN)</th>
                <th>Designation (BN)</th>
                <th>Message (EN)</th>
                <th>Message (BN)</th>
                <th>Title (EN)</th>
                <th>Title (BN)</th>
                <th>Description (EN)</th>
                <th>Description (BN)</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($testimonials as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->name['en'] ?? '' }}</td>
                <td>{{ $item->name['bn'] ?? '' }}</td>
                <td>{{ $item->designation['en'] ?? '' }}</td>
                <td>{{ $item->designation['bn'] ?? '' }}</td>
                <td>{{ Str::limit($item->message['en'] ?? '', 50) }}</td>
                <td>{{ Str::limit($item->message['bn'] ?? '', 50) }}</td>
                <td>{{ $item->title['en'] ?? '' }}</td>
                <td>{{ $item->title['bn'] ?? '' }}</td>
                <td>{{ $item->description['en'] ?? '' }}</td>
                <td>{{ $item->description['bn'] ?? '' }}</td>
                <td>
                    @if($item->photo)
                        <img src="{{ asset($item->photo) }}" width="60" class="rounded">
                    @else
                        <span class="text-muted">No Photo</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('testimonial.edit', $item->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                    <form action="{{ route('testimonial.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="13" class="text-center text-muted">No Data Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $testimonials->links() }}
</div>
@endsection
