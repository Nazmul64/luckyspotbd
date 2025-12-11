{{-- resources/views/frontend/dashboard/maincontent.blade.php --}}

<div class="user-toggler-wrapper d-flex align-items-center d-lg-none">
    <h4 class="title m-0">User Dashboard</h4>
    <div class="user-toggler">
        <i class="las la-sliders-h"></i>
    </div>
</div>

<div class="row justify-content-center g-4">

    <!-- Total Deposit -->
    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
        <div class="dashboard__card">
            <div class="dashboard__card-content">
                <h2 class="price">{{ round($total_deposite ?? 0) }} টাকা</h2>
                <p class="info">Total Deposit</p>
            </div>
            <div class="dashboard__card-icon">
                <i class="las la-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Total Balance -->
    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
        <div class="dashboard__card">
            <div class="dashboard__card-content">
                <h2 class="price">{{ round($total_balance ?? 0) }} টাকা</h2>
                <p class="info">Total Balance</p>
            </div>
            <div class="dashboard__card-icon">
                <i class="las la-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Total Withdraw -->
    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
        <div class="dashboard__card">
            <div class="dashboard__card-content">
                <h2 class="price">{{ round($total_withdraw ?? 0) }} টাকা</h2>
                <p class="info">Total Withdraw</p>
            </div>
            <div class="dashboard__card-icon">
                <i class="las la-wallet"></i>
            </div>
        </div>
    </div>

</div>

<!-- =======================
     PACKAGE / LOTTERY SECTION
=========================== -->
<div class="row gy-4 justify-content-center pt-5">
    @forelse($package_show as $package)
        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6">
            <div class="game-item">
                <div class="game-inner">

                    {{-- Check if user is logged in --}}
                    @auth
                        <form method="POST" action="{{ route('buy.package', $package->id) }}">
                            @csrf
                            <div class="game-item__thumb">
                                <img src="{{ asset('uploads/Lottery/' . ($package->photo ?? 'default.png')) }}" alt="{{ $package->name }}">
                            </div>

                            <div class="game-item__content">
                                <h4 class="title">{{ $package->name ?? 'N/A' }}</h4>
                                <p class="invest-info">{{ $package->win_type ?? 'N/A' }}</p>
                                <p class="invest-amount">{{ $package->price ? round($package->price) . ' টাকা' : '0 টাকা' }}</p>
                                <p class="text-white">
                                    Draw Date: {{ $package->draw_date ? $package->draw_date->format('d M, Y h:i A') : 'N/A' }}
                                </p>

                                @if($package->draw_date)
                                    <p class="text-warning countdown-timer"
                                       data-draw="{{ $package->draw_date->format('Y-m-d H:i:s') }}">
                                    </p>
                                @endif

                                <p class="text-success">1st Prize: {{ round($package->first_prize ?? 0) }} টাকা</p>
                                <p class="text-warning">2nd Prize: {{ round($package->second_prize ?? 0) }} টাকা</p>
                                <p class="text-info">3rd Prize: {{ round($package->third_prize ?? 0) }} টাকা</p>

                                <button type="submit" class="cmn--btn active btn--md radius-0">Play Now</button>
                            </div>
                        </form>
                    @else
                        {{-- If user not logged in, show alert and redirect --}}
                        <div class="game-item__thumb">
                            <img src="{{ asset('uploads/Lottery/' . ($package->photo ?? 'default.png')) }}" alt="{{ $package->name }}">
                        </div>
                        <div class="game-item__content">
                            <h4 class="title">{{ $package->name ?? 'N/A' }}</h4>
                            <p class="invest-info">{{ $package->win_type ?? 'N/A' }}</p>
                            <p class="invest-amount">{{ $package->price ? round($package->price) . ' টাকা' : '0 টাকা' }}</p>
                            <p class="text-white">
                                Draw Date: {{ $package->draw_date ? $package->draw_date->format('d M, Y h:i A') : 'N/A' }}
                            </p>
                            @if($package->draw_date)
                                <p class="text-warning countdown-timer"
                                   data-draw="{{ $package->draw_date->format('Y-m-d H:i:s') }}">
                                </p>
                            @endif
                            <p class="text-success">1st Prize: {{ round($package->first_prize ?? 0) }} টাকা</p>
                            <p class="text-warning">2nd Prize: {{ round($package->second_prize ?? 0) }} টাকা</p>
                            <p class="text-info">3rd Prize: {{ round($package->third_prize ?? 0) }} টাকা</p>

                            <a href="{{ route('frontend.login') }}"
                               onclick="event.preventDefault(); alert('Please login first!'); window.location='{{ route('frontend.login') }}';"
                               class="cmn--btn active btn--md radius-0">
                               Play Now
                            </a>
                        </div>
                    @endauth

                </div>
                <div class="ball"></div>
            </div>
        </div>
    @empty
        <p class="text-center w-100">No lottery packages found.</p>
    @endforelse
</div>

{{-- Countdown Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateCountdowns() {
        const timers = document.querySelectorAll('.countdown-timer');

        timers.forEach(function(timer) {
            const drawTime = timer.getAttribute('data-draw');
            const drawDate = new Date(drawTime);
            const now = new Date();
            const diff = drawDate - now;

            if(diff <= 0) {
                timer.textContent = '🎉 Draw time has arrived!';
                return;
            }

            const days = Math.floor(diff / (1000*60*60*24));
            const hours = Math.floor((diff % (1000*60*60*24)) / (1000*60*60));
            const minutes = Math.floor((diff % (1000*60*60)) / (1000*60));
            const seconds = Math.floor((diff % (1000*60)) / 1000);

            timer.textContent = `⏳ ${days}d ${hours}h ${minutes}m ${seconds}s remaining`;
        });
    }

    setInterval(updateCountdowns, 1000);
});
</script>


<!-- =======================
     TRANSACTION HISTORY
=========================== -->
<div class="table--responsive--md mt-5">
    <table class="table">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Type</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($deposite_history as $deposit)
                <tr>
                    <td>{{ $deposit->transaction_id ?? '#' . $deposit->id }}</td>
                    <td>{{ $deposit->amount > 0 ? 'Deposit' : 'Withdraw' }}</td>
                    <td>{{ $deposit->created_at ? $deposit->created_at->format('d M, Y h:i A') : 'N/A' }}</td>
                    <td>${{ number_format($deposit->amount, 2) }}</td>
                    <td>
                        @if($deposit->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($deposit->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No transaction history found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
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
