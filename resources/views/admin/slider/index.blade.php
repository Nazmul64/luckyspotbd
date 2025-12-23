@extends('admin.master')

@section('admin')

<div class="container-fluid my-4">

    <!-- Create Button -->
    <a href="{{ route('slider.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Slider
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">

            <!-- Search -->
            <div class="mb-3 position-relative">
                <input type="text" id="customSearchBox" class="form-control" placeholder="🔍 Search Sliders...">
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @forelse ($slider as $item)
                            <tr>
                                <td>{{ $item->title ?? 'N/A' }}</td>

                                <td>{{ \Illuminate\Support\Str::limit($item->description, 50) ?? 'N/A' }}</td>

                                <td>
                                    @if($item->photo)
                                        <img src="{{ asset($item->photo) }}" width="80" class="img-thumbnail rounded">
                                    @else
                                        <span class="text-muted">No Photo</span>
                                    @endif
                                </td>

                                <td>
                                    @if($item->status == 1)
                                        <span class="badge bg-success">Inactive</span>
                                    @else
                                        <span class="badge bg-secondary">Active</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('slider.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('slider.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Are you sure?')"
                                                class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">No Sliders Found</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

@endsection
