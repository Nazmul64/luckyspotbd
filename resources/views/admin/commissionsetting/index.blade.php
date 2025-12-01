@extends('admin.master')
@section('admin')

<div class="container-fluid my-4">
    <a href="{{ route('commissionsetting.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Commission
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
                            <th>Refer Commission</th>
                            <th>Level 1</th>
                            <th>Level 2</th>
                            <th>Level 3</th>
                            <th>Level 4</th>
                            <th>Level 5</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($commissions as $commission)
                            <tr>
                                <td>{{ round($commission->refer_commission) }}%</td>
                                <td>{{ round($commission->generation_level_1) }}%</td>
                                <td>{{ round($commission->generation_level_2) }}%</td>
                                <td>{{ round($commission->generation_level_3) }}%</td>
                                <td>{{ round($commission->generation_level_4) }}%</td>
                                <td>{{ round($commission->generation_level_5) }}%</td>
                               <td>
                                <span class="badge {{ $commission->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $commission->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                             </td>
                            <td>
                                <a href="{{ route('commissionsetting.edit', $commission->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('commissionsetting.destroy', $commission->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No commission records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
