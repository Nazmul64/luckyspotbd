@extends('admin.master')

@section('admin')
<div class="container">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">About Us List</h4>
        <a href="{{ route('aboutus.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Create New
        </a>
    </div>

    <!-- Table Card -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($aboutus as $item)
                            <tr>
                                <!-- Title -->
                                <td>{{ $item->title }}</td>

                                <!-- Description -->
                                <td>{{ Str::limit($item->description, 50) }}</td>

                                <!-- Photo -->
                                <td>
                                    @if($item->photo)
                                        <img src="{{ asset($item->photo) }}" alt="About Us Photo" width="80">
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <!-- Status -->
                                <td>
                                    <span class="badge {{ $item->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td>
                                    <a href="{{ route('aboutus.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('aboutus.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this item?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
