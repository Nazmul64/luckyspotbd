{{-- resources/views/admin/slider/index.blade.php --}}

@extends('admin.master')

@section('admin')

<div class="container-fluid my-4">

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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
                            <th>#</th>
                            <th>Photo</th>
                            <th>Title (EN)</th>
                            <th>Title (BN)</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @forelse ($slider as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    @if($item->photo)
                                        <img src="{{ asset($item->photo) }}"
                                             width="80"
                                             class="img-thumbnail rounded">
                                    @else
                                        <span class="text-muted">No Photo</span>
                                    @endif
                                </td>

                                {{-- ✅ Show English Title --}}
                                <td>{{ $item->title_en ?? 'N/A' }}</td>

                                {{-- ✅ Show Bangla Title --}}
                                <td>{{ $item->title_bn ?? 'N/A' }}</td>

                                <td>
                                    @if($item->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('slider.edit', $item->id) }}"
                                           class="btn btn-sm btn-primary"
                                           title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('slider.destroy', $item->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this slider?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mb-0">No Sliders Found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

{{-- ✅ Search Functionality (Optional) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('customSearchBox');
    const tableRows = document.querySelectorAll('tbody tr');

    if (searchBox) {
        searchBox.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();

            tableRows.forEach(row => {
                const titleEn = row.cells[2]?.textContent.toLowerCase() || '';
                const titleBn = row.cells[3]?.textContent.toLowerCase() || '';

                if (titleEn.includes(searchTerm) || titleBn.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>

@endsection
