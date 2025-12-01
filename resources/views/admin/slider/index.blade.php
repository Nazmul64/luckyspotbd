@extends('admin.master')

@section('admin')

<div class="container-fluid my-4">
    <!-- Create Button -->
    <a href="{{ route('slider.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Slider
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">

            {{-- Custom Search --}}
            <div class="mb-3 position-relative">
                <input type="text" id="customSearchBox" class="form-control" placeholder="🔍 Search Sliders...">
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
                            <th>Description</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($slider as $item)
                            <tr>
                                <!-- Title -->
                                <td>{{ $item->title ?? 'N/A' }}</td>

                                <!-- Description -->
                                <td>{{ Str::limit($item->description, 50) ?? 'N/A' }}</td>

                                <!-- Photo -->
                                <td>
                                    @if(!empty($item->photo))
                                        <img src="{{ asset($item->photo) }}"
                                             alt="Photo"
                                             class="img-thumbnail rounded"
                                             width="80">
                                    @else
                                        <span class="text-muted">No Photo</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td>
                                    @if($item->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                <!-- Action Buttons -->
                                <td>
                                    <a href="{{ route('slider.edit', $item->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('slider.destroy', $item->id) }}"
                                          method="POST"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this slider?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">No Sliders Found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
