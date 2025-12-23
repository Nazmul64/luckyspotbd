@extends('admin.master')

@section('admin')

<div class="container mt-4">
    <h3>🎟 Lottery Purchases</h3>

    {{-- Filter Tabs --}}
    <div class="mb-3">
        @php
            $types = ['daily','7days','15days','1month','3months','6months','1year'];
        @endphp

        @foreach($types as $type)
            <a href="{{ route('admin.lottery.purchases', ['type' => $type]) }}"
               class="btn btn-sm {{ ($winType ?? '') === $type ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ strtoupper($type) }}
            </a>
        @endforeach

        <a href="{{ route('admin.lottery.purchases') }}" class="btn btn-sm btn-outline-secondary">
            ALL
        </a>
    </div>

    {{-- Search --}}
    <input type="text" id="lotterySearch" class="form-control mb-3"
           placeholder="Search lottery by name...">

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="lotteryTable">
            <thead class="table-dark">
                <tr>
                    <th>Lottery Name</th>
                    <th>Type</th>
                    <th>Price / Ticket</th>
                    <th>Tickets Sold</th>
                    <th>Multiple Title</th>
                    <th>Multiple Price</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Declare</th>
                </tr>
            </thead>

            <tbody>
                @forelse($lotteries as $lottery)
                    <tr>
                        <td>{{ $lottery->name }}</td>

                        <td>{{ strtoupper($lottery->win_type) }}</td>

                        <td>{{ number_format($lottery->price, 2) }} $</td>

                        <td>{{ $lottery->tickets_sold }}</td>

                        {{-- Multiple Title --}}
                        <td>
                            @if(is_array($lottery->multiple_title))
                                <ul class="mb-0 ps-3">
                                    @foreach($lottery->multiple_title as $title)
                                        <li>{{ $title }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        {{-- Multiple Price --}}
                        <td>
                            @if(is_array($lottery->multiple_price))
                                <ul class="mb-0 ps-3">
                                    @foreach($lottery->multiple_price as $price)
                                        <li>{{ number_format($price, 2) }} $</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>

                        <td>{{ number_format($lottery->total_amount, 2) }} $</td>

                        <td>
                            <span class="badge {{ $lottery->status === 'completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($lottery->status) }}
                            </span>
                        </td>

                        <td>
                            @if($lottery->status !== 'completed')
                                <a href="{{ route('admin.lottery.showDeclare', $lottery->id) }}"
                                   class="btn btn-sm btn-primary">
                                    Declare Winners
                                </a>
                            @else
                                <span class="text-muted">Already Declared</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            No lotteries found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Search Script --}}
<script>
    document.getElementById('lotterySearch').addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('#lotteryTable tbody tr').forEach(row => {
            row.style.display = row.cells[0].textContent.toLowerCase().includes(filter)
                ? ''
                : 'none';
        });
    });
</script>

@endsection
