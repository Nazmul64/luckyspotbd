@extends('admin.master')

@section('admin')
<div class="container mt-4">
    <h4 class="mb-3">FAQ List</h4>

    <a href="{{ route('faq.create') }}" class="btn btn-primary mb-3">
        + Add FAQ
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title (EN)</th>
                <th>Title (BN)</th>
                <th>Question (EN)</th>
                <th>Question (BN)</th>
                <th>Answer (EN)</th>
                <th>Answer (BN)</th>
                <th width="20%">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $key => $faq)
            <tr>
                <td>{{ $faqs->firstItem() + $key }}</td>
                <td>{{ $faq->title['en'] ?? '' }}</td>
                <td>{{ $faq->title['bn'] ?? '' }}</td>
                <td>{{ $faq->question['en'] ?? '' }}</td>
                <td>{{ $faq->question['bn'] ?? '' }}</td>
                <td>{{ Str::limit($faq->answer['en'] ?? '', 50) }}</td>
                <td>{{ Str::limit($faq->answer['bn'] ?? '', 50) }}</td>
                <td>
                    <a href="{{ route('faq.edit',$faq->id) }}" class="btn btn-sm btn-warning">Edit</a>

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
                <td colspan="8" class="text-center">No FAQ Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $faqs->links() }}
</div>
@endsection
