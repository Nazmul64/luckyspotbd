@extends('admin.master')

@section('admin')

<div class="container-fluid my-4">

    <!-- Create Contact Button -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('contact.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Create Contact
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow-lg border-0">
        <div class="card-body">

            <!-- Custom Search -->
            <div class="mb-3 position-relative">
                <input type="text" id="customSearchBox" class="form-control" placeholder="🔍 Search Contacts...">
                <small id="typingIndicator" class="text-muted position-absolute"
                       style="right:10px; top:50%; transform:translateY(-50%); display:none;">
                    ⌨️ Typing...
                </small>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table id="contactTable" class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Icon Preview</th>
                            <th>Icon Code</th>
                            <th>Title</th>
                            <th>Email / Phone</th>
                            <th>Map Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($contact as $item)
                            <tr>
                                <!-- Icon Preview -->
                                <td>
                                    @if($item->icon)
                                        <i class="{{ $item->icon }}" style="font-size: 30px;"></i>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>

                                <!-- Icon Code -->
                                <td>{{ $item->icon ?? 'N/A' }}</td>

                                <!-- Title -->
                                <td>{{ Str::limit($item->title, 50, '...') ?? 'N/A' }}</td>

                                <!-- Email / Phone -->
                                <td>{{ Str::limit($item->email_phone, 50, '...') ?? 'N/A' }}</td>

                                <!-- Map Code -->
                                <td>{{ Str::limit($item->map_code, 50, '...') ?? 'N/A' }}</td>

                                <!-- Status -->
                                <td>
                                    @if ($item->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                <!-- Action Buttons -->
                                <td>
                                    <a href="{{ route('contact.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('contact.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this contact?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">No contacts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection
