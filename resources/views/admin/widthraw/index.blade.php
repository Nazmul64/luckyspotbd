@extends('admin.master')

@section('admin')
<div class="container-fluid px-4 py-5">
    <h2 class="fw-bold mb-4">User Withdrawals</h2>

    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Amount</th>
                    {{-- <th>Wallet Name</th> --}}
                    <th>User Account Number</th>
                    <th>Charge</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $withdraw)
                <tr>
                    <td>
                        {{ $withdraw->user->name ?? 'N/A' }}<br>
                        <small>{{ $withdraw->user->email ?? '' }}</small>
                    </td>
                    <td>{{ number_format($withdraw->amount, 2) }}$</td>
                    {{-- <td>{{ $withdraw->wallet_name }}</td> --}}
                    <td>{{ $withdraw->account_number ?? 'N/A' }}</td>
                    <td>{{ number_format($withdraw->charge ?? 0, 2) }}$</td>
                    <td>
                        @if($withdraw->status == 'pending')
                            <span class="badge bg-warning"><i class="fas fa-clock me-1"></i> Pending</span>
                        @elseif($withdraw->status == 'approved')
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Approved</span>
                        @else
                            <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Rejected</span>
                        @endif
                    </td>
                    <td>{{ $withdraw->created_at->format('d M, Y') }}</td>
                    <td>
                        @if($withdraw->status == 'pending')
                            <a href="{{ route('admin.withdraw.approve', $withdraw->id) }}"
                               class="btn btn-success btn-sm mb-1"
                               onclick="return confirm('Are you sure you want to approve this withdrawal?')">
                                <i class="fas fa-check me-1"></i> Approve
                            </a>
                            <a href="{{ route('admin.withdraw.reject', $withdraw->id) }}"
                               class="btn btn-danger btn-sm mb-1"
                               onclick="return confirm('Are you sure you want to reject this withdrawal?')">
                                <i class="fas fa-times me-1"></i> Reject
                            </a>
                        @else
                            <span class="text-muted">No actions</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No withdrawals found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
