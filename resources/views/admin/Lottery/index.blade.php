{{-- ============================================
     INDEX VIEW - Lottery List with Live Countdown
     Path: resources/views/admin/lottery/index.blade.php
     ============================================ --}}
@extends('admin.master')

@section('admin')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-ticket-perforated text-primary"></i> Lottery Management
            </h2>
            <p class="text-muted mb-0">Manage tickets, prizes, and draws</p>
        </div>
        <a href="{{ route('lottery.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Lottery
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        @php
        $stats = [
            ['title' => 'Active', 'count' => $lotteries->where('status', 'active')->count(), 'color' => 'success', 'icon' => 'play-circle'],
            ['title' => 'Inactive', 'count' => $lotteries->where('status', 'inactive')->count(), 'color' => 'warning', 'icon' => 'pause-circle'],
            ['title' => 'Completed', 'count' => $lotteries->where('status', 'completed')->count(), 'color' => 'info', 'icon' => 'check-circle'],
            ['title' => 'Total', 'count' => $lotteries->total(), 'color' => 'primary', 'icon' => 'ticket'],
        ];
        @endphp

        @foreach($stats as $s)
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-{{ $s['color'] }} text-white stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase mb-2">{{ $s['title'] }}</h6>
                            <h2 class="mb-0 fw-bold">{{ $s['count'] }}</h2>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-{{ $s['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-list-ul text-primary"></i> All Lotteries
                <span class="badge bg-secondary ms-2">{{ $lotteries->total() }}</span>
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60" class="text-center">#</th>
                        <th width="100" class="text-center">Image</th>
                        <th width="250">Details</th>
                        <th width="120" class="text-center">Price</th>
                        <th width="200">Prizes</th>
                        <th width="120" class="text-center">Packages</th>
                        <th width="150" class="text-center">Video</th>
                        <th width="200" class="text-center">Draw Time</th>
                        <th width="100" class="text-center">Type</th>
                        <th width="110" class="text-center">Status</th>
                        <th width="120" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lotteries as $lottery)
                    <tr>
                        <td class="text-center fw-bold text-muted">
                            {{ $lotteries->firstItem() + $loop->index }}
                        </td>

                        <td class="text-center">
                            @if($lottery->photo)
                            <img src="{{ asset('uploads/lottery/' . $lottery->photo) }}"
                                 class="lottery-img"
                                 onclick="showImg('{{ asset('uploads/lottery/' . $lottery->photo) }}')">
                            @else
                            <div class="img-placeholder">
                                <i class="bi bi-image"></i>
                            </div>
                            @endif
                        </td>

                        <td>
                            <h6 class="mb-1 fw-bold">
                                {{ $lottery->name[app()->getLocale()] ?? $lottery->name['en'] }}
                            </h6>
                            @if($lottery->description[app()->getLocale()] ?? '')
                            <p class="text-muted small mb-1">
                                {{ Str::limit($lottery->description[app()->getLocale()], 80) }}
                            </p>
                            @endif
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> {{ $lottery->created_at->format('M d, Y') }}
                            </small>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                {{ number_format($lottery->price, 0) }} টাকা
                            </span>
                        </td>

                        <td>
                            <div class="prize-list">
                                <div><span class="badge bg-success">1st</span> <strong>{{ number_format($lottery->first_prize, 0) }}</strong> টাকা</div>
                                <div><span class="badge bg-warning">2nd</span> <strong>{{ number_format($lottery->second_prize, 0) }}</strong> টাকা</div>
                                <div><span class="badge bg-info">3rd</span> <strong>{{ number_format($lottery->third_prize, 0) }}</strong> টাকা</div>
                            </div>
                        </td>

                        <td class="text-center">
                            @php $pkgCount = count($lottery->multiple_title ?? []); @endphp
                            @if($pkgCount > 0)
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pkg{{ $lottery->id }}">
                                <i class="bi bi-box"></i> {{ $pkgCount }} Package{{ $pkgCount > 1 ? 's' : '' }}
                            </button>

                            <div class="modal fade" id="pkg{{ $lottery->id }}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Packages</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th class="text-end">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($lottery->multiple_title as $i => $title)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $title }}</td>
                                                        <td class="text-end"><strong>{{ number_format($lottery->multiple_price[$i] ?? 0, 0) }}</strong> টাকা</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">None</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($lottery->video_enabled)
                            <span class="badge bg-success mb-1">
                                <i class="bi bi-camera-video"></i> On
                            </span>
                            <small class="d-block text-muted">{{ ucfirst($lottery->video_type) }}</small>
                            @if($lottery->video_scheduled_at)
                            <small class="text-info fw-semibold d-block">📅 {{ $lottery->video_scheduled_at->format('M d, h:i A') }}</small>
                            @endif
                            @else
                            <span class="badge bg-secondary">Off</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($lottery->draw_date)
                            <div class="draw-time-box">
                                <strong class="d-block mb-1">{{ $lottery->draw_date->format('d M, Y') }}</strong>
                                <small class="text-muted d-block mb-2">{{ $lottery->draw_date->format('h:i A') }}</small>

                                {{-- Live Countdown --}}
                                <div class="countdown-timer"
                                     data-target="{{ $lottery->draw_date->toIso8601String() }}"
                                     data-id="{{ $lottery->id }}">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-muted">Not set</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <span class="badge bg-dark">{{ ucwords(str_replace('_', ' ', $lottery->win_type)) }}</span>
                        </td>

                        <td class="text-center">
                            @php
                            $sc = match($lottery->status) {
                                'active' => ['class' => 'success', 'icon' => 'check-circle', 'pulse' => true],
                                'inactive' => ['class' => 'danger', 'icon' => 'x-circle', 'pulse' => false],
                                'completed' => ['class' => 'secondary', 'icon' => 'flag', 'pulse' => false],
                                default => ['class' => 'warning', 'icon' => 'question', 'pulse' => false]
                            };
                            @endphp
                            <span class="badge bg-{{ $sc['class'] }} {{ $sc['pulse'] ? 'pulse' : '' }}">
                                <i class="bi bi-{{ $sc['icon'] }}"></i> {{ ucfirst($lottery->status) }}
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('lottery.edit', $lottery->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="del({{ $lottery->id }})" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="del-{{ $lottery->id }}" action="{{ route('lottery.destroy', $lottery->id) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted opacity-50"></i>
                            <h4 class="mt-3 text-muted">No Lotteries Found</h4>
                            <a href="{{ route('lottery.create') }}" class="btn btn-primary mt-3">Create First Lottery</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lotteries->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $lotteries->firstItem() }} - {{ $lotteries->lastItem() }} of {{ $lotteries->total() }}
                </small>
                {{ $lotteries->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Image Modal --}}
<div class="modal fade" id="imgModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 text-center">
                <img id="modalImg" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<style>
.stat-card { transition: transform 0.3s; }
.stat-card:hover { transform: translateY(-5px); }
.stat-icon i { font-size: 3rem; opacity: 0.3; }
.lottery-img { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; cursor: pointer; transition: transform 0.3s; }
.lottery-img:hover { transform: scale(1.2); }
.img-placeholder { width: 70px; height: 70px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
.img-placeholder i { font-size: 2rem; color: #ccc; }
.prize-list div { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
.prize-list .badge { min-width: 40px; }
.pulse { animation: pulse 2s infinite; }
@keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }

.draw-time-box {
    padding: 8px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.countdown-timer {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 6px 10px;
    border-radius: 6px;
    min-height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.countdown-active {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border: 1px solid #c3e6cb;
}

.countdown-soon {
    background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
    color: #856404;
    border: 1px solid #ffeaa7;
    animation: blink 1.5s infinite;
}

.countdown-passed {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
</style>

<script>
function showImg(src) {
    document.getElementById('modalImg').src = src;
    new bootstrap.Modal(document.getElementById('imgModal')).show();
}

function del(id) {
    if (confirm('⚠️ Delete this lottery? This cannot be undone.')) {
        document.getElementById('del-' + id).submit();
    }
}

// Live Countdown System
function updateCountdowns() {
    const timers = document.querySelectorAll('.countdown-timer');

    timers.forEach(timer => {
        const target = new Date(timer.getAttribute('data-target'));
        const now = new Date();
        const diff = target - now;

        timer.classList.remove('countdown-active', 'countdown-soon', 'countdown-passed');

        if (diff <= 0) {
            timer.innerHTML = '🎉 Draw Completed';
            timer.classList.add('countdown-passed');
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        // Check if less than 24 hours
        if (diff < 24 * 60 * 60 * 1000) {
            timer.innerHTML = `⏰ ${hours}h ${minutes}m ${seconds}s`;
            timer.classList.add('countdown-soon');
        } else {
            timer.innerHTML = `⏳ ${days}d ${hours}h ${minutes}m`;
            timer.classList.add('countdown-active');
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    // Initial countdown update
    updateCountdowns();

    // Update every second
    setInterval(updateCountdowns, 1000);

    // Auto-dismiss alerts
    document.querySelectorAll('.alert-dismissible').forEach(a => {
        setTimeout(() => new bootstrap.Alert(a).close(), 5000);
    });
});
</script>
@endsection
