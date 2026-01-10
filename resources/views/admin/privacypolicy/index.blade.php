@extends('admin.master')

@section('admin')
<div class="container my-4">
    <a href="{{ route('privacypolicy.create') }}" class="btn btn-success mb-3">+ Create Privacy Policy</a>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Title (EN)</th>
                            <th>Title (BN)</th>
                            <th>Description (EN)</th>
                            <th>Description (BN)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($privacypolicies as $item)
                        <tr>
                            <td>{{ $item->title['en'] ?? 'N/A' }}</td>
                            <td>{{ $item->title['bn'] ?? 'N/A' }}</td>
                            <td>{{ Str::limit($item->description['en'] ?? 'N/A', 50) }}</td>
                            <td>{{ Str::limit($item->description['bn'] ?? 'N/A', 50) }}</td>
                            <td>
                                <a href="{{ route('privacypolicy.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('privacypolicy.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-muted">No Privacy Policy found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
