@extends('admin.master')

@section('admin')

<div class="container-fluid my-4">
    <a href="{{ route('settings.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Setting
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
                            <th>Photo</th>
                            <th>Favicon</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Facebook</th>
                            <th>Twitter</th>
                            <th>LinkedIn</th>
                            <th>Instagram</th>
                            <th>Telegram</th>
                            <th>YouTube</th>
                            <th>Footer About</th>
                            <th>Footer Text</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($settings as $item)
                            <tr>
                                {{-- Photo --}}
                                <td>
                                    @if(!empty($item->photo))
                                        <img src="{{ asset('uploads/settings/' . $item->photo) }}"
                                             alt="Photo" class="img-thumbnail" width="60">
                                    @else
                                        <span class="text-muted">No Photo</span>
                                    @endif
                                </td>

                                {{-- Favicon --}}
                                <td>
                                    @if(!empty($item->favicon))
                                        <img src="{{ asset('uploads/settings/' . $item->favicon) }}"
                                             alt="Favicon" class="img-thumbnail" width="30">
                                    @else
                                        <span class="text-muted">No Favicon</span>
                                    @endif
                                </td>

                                {{-- Other Fields --}}
                                <td>{{ $item->phone ?? 'N/A' }}</td>
                                <td>{{ $item->email ?? 'N/A' }}</td>
                                <td>{{ $item->address ?? 'N/A' }}</td>
                                <td>{{ $item->facebook ?? 'N/A' }}</td>
                                <td>{{ $item->twitter ?? 'N/A' }}</td>
                                <td>{{ $item->linkedin ?? 'N/A' }}</td>
                                <td>{{ $item->instagram ?? 'N/A' }}</td>
                                <td>{{ $item->tilegram ?? 'N/A' }}</td>
                                <td>{{ $item->youtube ?? 'N/A' }}</td>
                                <td>{{ $item->footer_about ?? 'N/A' }}</td>
                                <td>{{ $item->footer_text ?? 'N/A' }}</td>

                                {{-- Action Buttons --}}
                                <td>
                                    <a href="{{ route('settings.edit', $item->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('settings.destroy', $item->id) }}"
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
                                <td colspan="14" class="text-muted">No settings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
