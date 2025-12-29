@extends('admin.master')
@section('admin')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Contact Messages</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($supportemails as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $item->first_name }}
                                            {{ $item->last_name }}
                                        </td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>
                                            {{ Str::limit($item->messages, 50) }}
                                        </td>
                                        <td>
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>


                                        <td>
                                            <a href="{{ route('contactmessagesdelete', $item->id) }}" class="btn btn-danger btn-sm" title="Delete Message">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">
                                            No messages found!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
