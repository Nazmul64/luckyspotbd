@extends('admin.master')
@section('admin')
<div class="container-fluid my-4">
    <a href="{{ route('withdrawcommisson.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Withdraw Commission
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Withdraw Commission</th>
                        <th>Minimum Withdraw</th>
                        <th>Maximum Withdraw</th>
                        <th>Minimum Deposite</th>
                        <th>Maximum Deposite</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawCommissions as $item)
                        <tr>
                            <td>{{ $item->withdraw_commission }}</td>
                            <td>{{ $item->minimum_withdraw }}</td>
                            <td>{{ $item->maximum_withdraw }}</td>
                            <td>{{ $item->minimum_deposite }}</td>
                            <td>{{ $item->maximum_deposite }}</td>
                            <td>
                                <span class="badge {{ $item->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $item->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('withdrawcommisson.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('withdrawcommisson.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">No Withdraw Commission found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
