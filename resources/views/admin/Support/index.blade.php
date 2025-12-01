@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">
    <a href="{{ route('supportlink.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Support Link
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">

            {{-- Custom Search --}}
            <div class="mb-3 position-relative">
                <input type="text" id="customSearchBox" class="form-control" placeholder="🔍 Search Lottery...">
                <small id="typingIndicator" class="text-muted position-absolute"
                       style="right:10px; top:50%; transform:translateY(-50%); display:none;">
                    ⌨️ Typing...
                </small>
            </div>

            {{-- Data Table --}}
            <div class="table-responsive">
                <table id="lotteryTable" class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Support link</th>
                            <th>Title</th>
                             <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($supports_link as $item)
                            <tr>
                                <td>{{ $item->support_link }}</td>
                                <td>{{ $item->title }}</td>

                                {{-- Photo --}}
                                <td>
                                    @if($item->photo)
                                        <img src="{{ asset('uploads/supports/'.$item->photo) }}"
                                             alt="supports Image" width="60" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span class="badge {{ $item->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <a href="{{ route('supportlink.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('supportlink.destroy', $item->id) }}" method="POST" style="display:inline;">
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
                                <td colspan="11" class="text-center text-muted">No Supportlink records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
