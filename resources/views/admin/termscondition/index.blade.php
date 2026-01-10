@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">
    <a href="{{ route('Termscondition.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Terms & Conditions
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Title (EN)</th>
                            <th>Title (BN)</th>
                            <th>Description (EN)</th>
                            <th>Description (BN)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($termsconditions as $item)
                        <tr>
                            <td>{{ $item->title['en'] ?? 'N/A' }}</td>
                            <td>{{ $item->title['bn'] ?? 'N/A' }}</td>
                            <td>{{ Str::limit($item->description['en'] ?? '', 50) }}</td>
                            <td>{{ Str::limit($item->description['bn'] ?? '', 50) }}</td>
                            <td>
                                <a href="{{ route('Termscondition.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('Termscondition.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No Terms & Conditions found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
