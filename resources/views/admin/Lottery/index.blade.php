@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-ticket-perforated"></i>  Tickets Management
        </h4>
        <a href="{{ route('lottery.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Create New Ticket
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Summary --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i>
                    <h6 class="mt-2">Active Lotteries</h6>
                    <h3 class="mb-0">{{ $lotteries->where('status', 'active')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-pause-circle-fill" style="font-size: 2rem;"></i>
                    <h6 class="mt-2">Inactive Lotteries</h6>
                    <h3 class="mb-0">{{ $lotteries->where('status', 'inactive')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-trophy-fill" style="font-size: 2rem;"></i>
                    <h6 class="mt-2">Completed Lotteries</h6>
                    <h3 class="mb-0">{{ $lotteries->where('status', 'completed')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-list-check" style="font-size: 2rem;"></i>
                    <h6 class="mt-2">Total Lotteries</h6>
                    <h3 class="mb-0">{{ $lotteries->count() }}</h3>
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
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Prizes</th>
                            <th>Best Gift</th>
                            <th>Video</th>
                            <th>Draw Date</th>
                            <th>Win Type</th>
                            <th>Status</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lotteries as $index => $lottery)
                            <tr>
                                {{-- ID --}}
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>

                                {{-- Photo --}}
                                <td class="text-center">
                                    @if($lottery->photo)
                                        <img src="{{ asset('uploads/lottery/'.$lottery->photo) }}"
                                             alt="{{ $lottery->name }}"
                                             class="img-thumbnail lottery-thumb"
                                             width="60" height="60"
                                             style="object-fit: cover; cursor: pointer;"
                                             onclick="showImageModal('{{ asset('uploads/lottery/'.$lottery->photo) }}')">
                                    @else
                                        <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 60px;">
                                            <i class="bi bi-image" style="font-size: 24px;"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Name & Description --}}
                                <td>
                                    <strong class="text-dark">{{ $lottery->name }}</strong>
                                    @if($lottery->description)
                                        <br><small class="text-muted">{{ Str::limit($lottery->description, 50) }}</small>
                                    @endif
                                </td>

                                {{-- Price --}}
                                <td class="text-center">
                                    <span class="badge bg-primary fs-6">{{ number_format($lottery->price, 2) }} টাকা</span>
                                </td>

                                {{-- Prizes --}}
                                <td>
                                    <small>
                                        <strong class="text-success"><i class="bi bi-trophy-fill"></i> 1st:</strong>
                                        {{ number_format($lottery->first_prize ?? 0, 0) }} টাকা<br>
                                        <strong class="text-warning"><i class="bi bi-award-fill"></i> 2nd:</strong>
                                        {{ number_format($lottery->second_prize ?? 0, 0) }} টাকা<br>
                                        <strong class="text-info"><i class="bi bi-star-fill"></i> 3rd:</strong>
                                        {{ number_format($lottery->third_prize ?? 0, 0) }} টাকা
                                    </small>
                                </td>

                                {{-- Multiple Packages --}}
                                <td class="text-center">
                                    @if(is_array($lottery->multiple_title) && count($lottery->multiple_title) > 0)
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#packagesModal{{ $lottery->id }}">
                                            <i class="bi bi-box-seam"></i> {{ count($lottery->multiple_title) }} Packages
                                        </button>

                                        {{-- Packages Modal --}}
                                        <div class="modal fade" id="packagesModal{{ $lottery->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-box-seam"></i> {{ $lottery->name }} - Packages
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-sm table-hover">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Package Name</th>
                                                                    <th class="text-end">Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($lottery->multiple_title as $i => $title)
                                                                    @if($title)
                                                                        <tr>
                                                                            <td>{{ $i + 1 }}</td>
                                                                            <td>{{ $title }}</td>
                                                                            <td class="text-end">
                                                                                <strong>{{ number_format($lottery->multiple_price[$i] ?? 0, 2) }} টাকা</strong>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- Video --}}
                                <td class="text-center">
                                    @if($lottery->video_enabled && $lottery->video_url)
                                        <span class="badge bg-success mb-1">
                                            <i class="bi bi-camera-video-fill"></i> Enabled
                                        </span>
                                        @if($lottery->video_scheduled_at)
                                            <br><small class="text-muted">
                                                <i class="bi bi-calendar-event"></i>
                                                {{ $lottery->video_scheduled_at->format('M d, Y') }}<br>
                                                <i class="bi bi-clock"></i>
                                                {{ $lottery->video_scheduled_at->format('h:i A') }}
                                            </small>
                                        @else
                                            <br><small class="text-muted">Not scheduled</small>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-camera-video-off"></i> Disabled
                                        </span>
                                    @endif
                                </td>

                                {{-- Draw Date --}}
                                <td class="text-center">
                                    @if($lottery->draw_date)
                                        <div class="draw-date-info">
                                            <strong class="d-block">{{ $lottery->draw_date->format('d M, Y') }}</strong>
                                            <small class="text-muted d-block">{{ $lottery->draw_date->format('h:i A') }}</small>
                                            @php
                                                $diff = now()->diffInDays($lottery->draw_date, false);
                                            @endphp
                                            @if($diff > 0)
                                                <small class="badge bg-info mt-1">
                                                    <i class="bi bi-hourglass-split"></i> {{ $lottery->draw_date->diffForHumans() }}
                                                </small>
                                            @elseif($diff === 0)
                                                <small class="badge bg-warning mt-1">
                                                    <i class="bi bi-exclamation-circle"></i> Today
                                                </small>
                                            @else
                                                <small class="badge bg-danger mt-1">
                                                    <i class="bi bi-clock-history"></i> Passed
                                                </small>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </td>

                                {{-- Win Type --}}
                                <td class="text-center">
                                    <span class="badge bg-dark">{{ ucfirst($lottery->win_type ?? 'N/A') }}</span>
                                </td>

                                {{-- Status --}}
                                <td class="text-center">
                                    @php
                                        $statusConfig = match($lottery->status) {
                                            'active' => ['class' => 'bg-success', 'icon' => 'check-circle-fill'],
                                            'inactive' => ['class' => 'bg-danger', 'icon' => 'x-circle-fill'],
                                            'completed' => ['class' => 'bg-secondary', 'icon' => 'flag-fill'],
                                            default => ['class' => 'bg-warning', 'icon' => 'question-circle-fill']
                                        };
                                    @endphp
                                    <span class="badge {{ $statusConfig['class'] }}">
                                        <i class="bi bi-{{ $statusConfig['icon'] }}"></i>
                                        {{ ucfirst($lottery->status) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('lottery.edit', $lottery->id) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Edit"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('lottery.destroy', $lottery->id) }}"
                                              method="POST"
                                              style="display:inline;"
                                              onsubmit="return confirm('⚠️ Are you sure you want to delete this lottery?\n\nThis action cannot be undone!')">
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
                                <td colspan="11" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox" style="font-size: 64px; opacity: 0.5;"></i>
                                        <h5 class="mt-3">No Tickets Found</h5>
                                        <p class="text-muted">You haven't created any lottery tickets yet.</p>
                                        <a href="{{ route('lottery.create') }}" class="btn btn-success mt-2">
                                            <i class="bi bi-plus-lg"></i> Create Your First Ticket
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

{{-- Image Preview Modal --}}
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-image"></i> Image Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" class="img-fluid" alt="Preview" style="max-height: 80vh;">
            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
// Image Modal Preview
function showImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
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
/* Card hover animations */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2) !important;
}

/* Table row hover effect */
.table-hover tbody tr {
    transition: all 0.2s ease;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
}

/* Image thumbnail hover effect */
.lottery-thumb {
    transition: all 0.3s ease;
    border: 2px solid #dee2e6;
}

.lottery-thumb:hover {
    transform: scale(1.15);
    border-color: #0d6efd;
    box-shadow: 0 4px 12px rgba(13,110,253,0.4);
    z-index: 10;
}

/* Status badges */
.badge {
    font-size: 0.85rem;
    padding: 0.35rem 0.65rem;
    font-weight: 500;
}

/* Action buttons */
.btn-group .btn {
    margin: 0;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Modal animations */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-dialog {
    animation: slideDown 0.3s ease;
}

/* Empty state styling */
.empty-state {
    padding: 3rem;
}

.empty-state i {
    color: #dee2e6;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }

    .btn-group {
        flex-direction: column;
    }

    .btn-group .btn {
        margin-bottom: 2px;
    }
}
</style>
@endsection
