@extends('admin.master')
@section('admin')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>How To Ticket List</h4>
        <a href="{{ route('howtoticket.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Title (EN)</th>
                        <th width="25%">Title (BN)</th>
                        <th width="20%">Icons</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($howtotickets as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->getTitle('en') }}</td>
                            <td>{{ $item->getTitle('bn') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <i class="{{ $item->sign_up_first_login_icon }}" title="Sign Up"></i>
                                    <i class="{{ $item->complete_your_profile_icon }}" title="Profile"></i>
                                    <i class="{{ $item->choose_a_ticket_icon }}" title="Ticket"></i>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('howtoticket.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('howtoticket.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No Data Found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
