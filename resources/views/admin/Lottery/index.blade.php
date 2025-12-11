@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">
    <a href="{{ route('lottery.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Create Ticket
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
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Draw Date</th>
                            <th>Win Type</th>
                            <th>1st Prize</th>
                            <th>2nd Prize</th>
                            <th>3rd Prize</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($lotteries as $lottery)
                            <tr>
                                <td>{{ $lottery->name }}</td>
                                <td>${{ round($lottery->price) }}$</td>
                                <td>{{ Str::limit($lottery->description, 40) }}</td>

                                {{-- Photo --}}
                                <td>
                                    @if($lottery->photo)
                                        <img src="{{ asset('uploads/Lottery/'.$lottery->photo) }}"
                                             alt="Lottery Image" width="60" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>

                                {{-- Draw Date --}}
                                <td>
                                    @if($lottery->draw_date)
                                        {{ \Carbon\Carbon::parse($lottery->draw_date)->format('d M, Y h:i A') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Win Type --}}
                                <td>{{ ucfirst($lottery->win_type ?? '-') }}</td>

                                {{-- Prizes --}}
                                <td>{{round( $lottery->first_prize ?? '-') }}$</td>
                                <td>{{round( $lottery->second_prize ?? '-') }}$</td>
                                <td>{{ round($lottery->third_prize ?? '-') }}$</td>

                                {{-- Status --}}
                                <td>
                                    <span class="badge {{ $lottery->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($lottery->status) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <a href="{{ route('lottery.edit', $lottery->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('lottery.destroy', $lottery->id) }}" method="POST" style="display:inline;">
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
                                <td colspan="11" class="text-center text-muted">No Lottery records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
