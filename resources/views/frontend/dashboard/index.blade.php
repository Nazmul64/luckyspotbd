@extends('frontend.master')

@section('content')

<!-- =======================
    INNER HERO SECTION
=========================== -->
@include('frontend.dashboard.usersection')

<!-- =======================
    DASHBOARD SECTION
=========================== -->
<div class="dashboard-section padding-top padding-bottom" style="background: linear-gradient(135deg, #30cfd0 0%, #086755 100%);">
    <div class="container">
        <div class="row">

            <!-- SIDEBAR -->
            @include('frontend.dashboard.sidebar')

            <!-- MAIN CONTENT -->
            <div class="col-lg-9">
                {{-- Pass all necessary data to maincontent --}}
                @include('frontend.dashboard.maincontent', [
                    'package_show' => $package_show  ?? collect(),
                    'deposite_history' => $deposite_history ?? collect(),
                    'total_deposite' => $total_deposite ?? 0,
                    'total_balance' => $total_balance ?? 0,
                    'total_withdraw' => $total_withdraw ?? 0
                ])
            </div>

        </div>
    </div>
</div>

<!-- =======================
    COUNTDOWN SCRIPT
=========================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateCountdowns() {
        const timers = document.querySelectorAll('.countdown-timer');
        timers.forEach(timer => {
            const drawTime = timer.getAttribute('data-draw');
            if(!drawTime) return;

            const drawDate = new Date(drawTime);
            const now = new Date();
            const diff = drawDate - now;

            if(diff <= 0){
                timer.textContent = '🎉 Draw Time Has Arrived!';
                return;
            }

            const d = Math.floor(diff / (1000 * 60 * 60 * 24));
            const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((diff % (1000 * 60)) / 1000);

            timer.textContent = `⏳ ${d}d ${h}h ${m}m ${s}s remaining`;
        });
    }

    setInterval(updateCountdowns, 1000);
});
</script>

@endsection
