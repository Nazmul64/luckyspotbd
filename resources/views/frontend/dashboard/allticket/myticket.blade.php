@extends('frontend.master')

@section('content')
<div class="container py-5" style="background-color:#ffffff; color:#000000; border-radius:12px;">
    <h4 class="text-center fw-bold mb-4">🎫 My  Tickets</h4>

    <!-- Search -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="ticket_number" class="form-control"
                placeholder="Search by Ticket Number" value="{{ request('ticket_number') }}">
            <button class="btn btn-dark" type="submit">Search</button>
        </div>
    </form>

    @if($tickets->count() > 0)
        <div class="row g-3">
            @foreach($tickets as $ticket)
                <div class="col-md-6 col-lg-4">
                    <div class="card p-3 shadow-sm" style="background-color:#f8f9fa; color:#000;">
                        <h5 class="card-title">{{ $ticket->package->name ?? 'Lottery' }}</h5>
                        <p class="mb-1"><strong>Ticket No:</strong>
                            <span id="ticket-{{ $ticket->id }}">{{ $ticket->ticket_number }}</span>
                            <button class="btn btn-sm btn-outline-dark ms-2"
                                onclick="copyTicket('{{ $ticket->ticket_number }}')">Copy</button>
                        </p>
                        <p class="mb-1"><strong>Price:</strong> ${{ $ticket->price }}</p>
                        <p class="mb-1"><strong>Purchased At:</strong> {{ $ticket->purchased_at->format('d M Y H:i') }}</p>
                        <p class="mb-0"><strong>Status:</strong>
                            @if($ticket->results->first())
                                {{ ucfirst($ticket->results->first()->win_status) }}
                            @else
                                Pending
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">❌ No tickets found.</p>
    @endif
</div>

<script>
function copyTicket(ticketNumber){
    navigator.clipboard.writeText(ticketNumber)
        .then(() => { alert('🎫 Ticket Number copied: ' + ticketNumber); })
        .catch(err => { alert('Failed to copy!'); });
}
</script>
@endsection
