@extends('frontend.master')

@section('content')

<!-- =======================
    INNER HERO SECTION
=========================== -->
@include('frontend.dashboard.usersection')

<!-- =======================
    DASHBOARD SECTION
=========================== -->
<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->
            @include('frontend.dashboard.sidebar')

            <!-- MAIN CONTENT -->
            <div class="col-lg-9">
                {{-- Pass all necessary data to maincontent --}}

                  <h5 class="mb-3">Commissions Log</h5>
                <div class="table-responsive">
                    <table class="table table-bordered custom-table">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>From</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commissions as $commission)
                                <tr>
                                    <td>{{ $commission->created_at->format('Y-m-d') }}</td>

                                    <td>{{ $commission->fromUser->name ?? 'Unknown' }}</td>
                                    <td><strong>{{ round($commission->amount, 2) }}</strong> $</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No commission records found.
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



@endsection
