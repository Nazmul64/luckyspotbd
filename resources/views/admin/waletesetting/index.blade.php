@extends('admin.master')
@section('admin')
<div class="container-fluid my-4">

    <a href="{{ route('waletesetting.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Wallet Setting
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Bank Name (EN)</th>
                            <th>Bank Name (BN)</th>
                            <th>Account Number (EN)</th>
                            <th>Account Number (BN)</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($walates as $walate)
                        <tr>
                            <td>{{ $walate->bankname['en'] ?? '' }}</td>
                            <td>{{ $walate->bankname['bn'] ?? '' }}</td>
                            <td>{{ $walate->accountnumber['en'] ?? '' }}</td>
                            <td>{{ $walate->accountnumber['bn'] ?? '' }}</td>
                            <td>
                                @if($walate->photo)
                                    <img src="{{ asset('uploads/waletesetting/'.$walate->photo) }}"
                                         width="60" class="img-thumbnail">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $walate->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($walate->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('waletesetting.edit', $walate->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('waletesetting.destroy', $walate->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">No wallet settings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
