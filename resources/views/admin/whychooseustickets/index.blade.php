{{-- resources/views/admin/whychooseustickets/index.blade.php --}}

@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-shield-check"></i> Why Choose Us Management
        </h4>
        <a href="{{ route('whychooseustickets.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Add New Item
        </a>
    </div>



    {{-- Stats Summary --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-list-check" style="font-size: 2rem;"></i>
                    <h6 class="mt-2">Total Items</h6>
                    <h3 class="mb-0">{{ $tickets->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th>Main Title</th>
                            <th>Title</th>
                            <th>Icon</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $index => $ticket)
                            <tr>
                                {{-- ID --}}
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>

                                {{-- Main Title (Current Locale) --}}
                                <td>
                                    <strong class="text-dark d-block mb-1" style="font-size: 14px;">
                                        {{ $ticket->getTranslatedMainTitle() ?: 'N/A' }}
                                    </strong>
                                    <small class="text-muted d-block">
                                        {{ Str::limit($ticket->getTranslatedMainDescription(), 50) }}
                                    </small>
                                </td>

                                {{-- Title (Current Locale) --}}
                                <td>
                                    <strong class="text-dark d-block mb-1">
                                        {{ $ticket->getTranslatedTitle() ?: 'N/A' }}
                                    </strong>
                                    <small class="text-muted">
                                        {{ Str::limit($ticket->getTranslatedDescription(), 50) }}
                                    </small>
                                </td>

                                {{-- Icon --}}
                                <td class="text-center">
                                    @if($ticket->icon)
                                        <i class="{{ $ticket->icon }}" style="font-size: 24px; color: #0d6efd;"></i>
                                        <br>
                                        <small class="text-muted">{{ $ticket->icon }}</small>
                                    @else
                                        <span class="text-muted">No icon</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('whychooseustickets.edit', $ticket->id) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Edit"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('whychooseustickets.destroy', $ticket->id) }}"
                                              method="POST"
                                              style="display:inline;"
                                              onsubmit="return confirm('⚠️ Are you sure you want to delete this item?\n\nThis action cannot be undone!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete"
                                                    data-bs-toggle="tooltip">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox" style="font-size: 64px; opacity: 0.5;"></i>
                                        <h5 class="mt-3">No Items Found</h5>
                                        <p class="text-muted">You haven't created any "Why Choose Us" items yet.</p>
                                        <a href="{{ route('whychooseustickets.create') }}" class="btn btn-success mt-2">
                                            <i class="bi bi-plus-lg"></i> Create Your First Item
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15) !important;
}
</style>
@endsection
