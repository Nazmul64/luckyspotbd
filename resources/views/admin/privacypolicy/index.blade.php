@extends('admin.master')

@section('admin')

<div class="container-fluid my-4">
    <a href="{{ route('privacypolicy.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Privacypolicy
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">

            {{-- Custom Search --}}
            <div class="mb-3 position-relative">
                <input type="text" id="customSearchBox" class="form-control" placeholder="🔍 Search Settings...">
                <small id="typingIndicator" class="text-muted position-absolute"
                       style="right:10px; top:50%; transform:translateY(-50%); display:none;">
                    ⌨️ Typing...
                </small>
            </div>

            {{-- Data Table --}}
            <div class="table-responsive">
                <table id="settingsTable" class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Title</th>
                            <th>description </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($privacypolicies as $item)
                            <tr>
                                {{-- Photo --}}




                                {{-- Other Fields --}}
                                <td>{{ $item->title ?? 'N/A' }}</td>
                                <td>{{ $item->description ?? 'N/A' }}</td>

                                {{-- Action Buttons --}}
                                <td>
                                    <a href="{{ route('privacypolicy.edit', $item->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('privacypolicy.destroy', $item->id) }}"
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
                                <td colspan="14" class="text-muted">No Privacy Policy found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
