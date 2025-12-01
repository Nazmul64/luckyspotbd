@extends('admin.master')
@section('admin')
<div class="container-fluid my-4">
   <a href="{{ route('waletesetting.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Wallet Setting
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">

            {{-- Custom Search --}}
            <div class="mb-3 position-relative">
                <input type="text" id="customSearchBox" class="form-control" placeholder="🔍 Search Commission Data...">
                <small id="typingIndicator" class="text-muted position-absolute"
                       style="right:10px; top:50%; transform:translateY(-50%); display:none;">
                    ⌨️ Typing...
                </small>
            </div>

            {{-- Data Table --}}
            <div class="table-responsive">
                <table id="commissionTable" class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Bank Name</th>
                            <th>Photo</th>
                            <th>Account Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($walate as $item)
                        <tr>
                            <td>{{ $item->bankname ?? 'N/A' }}</td>
                            <td>
                                @if(!empty($item->photo))
                                    <img src="{{ asset('uploads/waletesetting/' . $item->photo) }}"
                                         alt="Bank Photo" class="img-thumbnail" width="60">
                                @else
                                    <span class="text-muted">No Photo</span>
                                @endif
                            </td>
                            <td>{{ $item->accountnumber ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($item->status ?? 'Inactive') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('waletesetting.edit', $item->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('waletesetting.destroy', $item->id) }}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-muted">No wallet settings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

