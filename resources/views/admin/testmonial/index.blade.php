@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4 class="mb-3">Testimonial List</h4>

    <a href="{{ route('testimonial.create') }}" class="btn btn-primary mb-3">
        + Add Testimonial
    </a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th width="5%">#</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Message</th>
                <th width="15%">Photo</th>
                <th width="15%">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($testimonials as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->designation }}</td>
                <td>{{ Str::limit($item->message, 50) }}</td>

                {{-- Photo column --}}
                <td>
                    @if($item->photo)
                        <img src="{{ asset($item->photo) }}"
                             alt="photo"
                             width="60"
                             class="rounded">
                    @else
                        <span class="text-muted">No Photo</span>
                    @endif
                </td>

                {{-- Action column --}}
                <td>
                    <a href="{{ route('testimonial.edit', $item->id) }}"
                       class="btn btn-sm btn-warning mb-1">
                        Edit
                    </a>

                    <form action="{{ route('testimonial.destroy', $item->id) }}"
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')"
                                class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    No Data Found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $testimonials->links() }}
</div>
@endsection
