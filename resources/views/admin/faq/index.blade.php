@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4 class="mb-3">FAQ List</h4>

    <a href="{{ route('faq.create') }}" class="btn btn-primary mb-3">
        + Add New FAQ
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>Question</th>
                <th>Answer</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $key => $faq)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $faq->question }}</td>
                <td>{{ $faq->answer }}</td>
                <td>
                    <a href="{{ route('faq.edit',$faq->id) }}"
                       class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('faq.destroy',$faq->id) }}"
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
                <td colspan="4" class="text-center">No FAQ Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $faqs->links() }}
</div>
@endsection
