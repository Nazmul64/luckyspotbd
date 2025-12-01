@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">

    {{-- Create Notice Button --}}
    <a href="{{ route('notices.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Notice
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">

            {{-- Search Box --}}
            <div class="mb-3 position-relative">
                <input type="text" id="customSearchBox" class="form-control" placeholder="🔍 Search Notices...">
                <small id="typingIndicator" class="text-muted position-absolute"
                       style="right:10px; top:50%; transform:translateY(-50%); display:none;">
                    ⌨️ Typing...
                </small>
            </div>

            {{-- Notices Table --}}
            <div class="table-responsive">
                <table id="lotteryTable" class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Notice Text</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($notices as $item)
                            <tr>
                                {{-- Notice Text --}}
                                <td>{{ $item->notices_text }}</td>

                                {{-- Actions --}}
                                <td>
                                    {{-- Edit Button --}}
                                    <a href="{{ route('notices.edit', $item->id) }}"
                                       class="btn btn-sm btn-primary me-1"
                                       title="Edit Notice">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Delete Form --}}
                                    <form action="{{ route('notices.destroy', $item->id) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this notice?')"
                                                title="Delete Notice">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    No notices found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
