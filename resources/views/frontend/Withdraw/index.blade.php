@extends('frontend.master')

@section('content')

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            {{-- SIDEBAR --}}
            @include('frontend.dashboard.sidebar')

            {{-- MAIN CONTENT --}}
            <div class="col-lg-9">
                <div class="container py-5">
                    <h4 class="mb-4">💳 Withdraw Now!</h4>

                    {{-- Withdraw Limits --}}
                    @if(isset($Withdraw_limit))
                        <div class="alert alert-info">
                            Minimum Withdraw: <strong>{{ round($Withdraw_limit->minimum_withdraw ?? 0) }} টাকা</strong> |
                            Maximum Withdraw: <strong>{{ round($Withdraw_limit->maximum_withdraw ?? 0) }} টাকা</strong>
                        </div>
                    @endif

                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Withdraw Form --}}
                    <form action="{{ route('Withdraw.submit') }}" method="POST">
                        @csrf

                        {{-- Amount --}}
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number"
                                   name="amount"
                                   class="form-control"
                                   step="0.01"
                                   min="{{ $Withdraw_limit->minimum_withdraw ?? 0 }}"
                                   max="{{ $Withdraw_limit->maximum_withdraw ?? 0 }}"
                                   placeholder="Enter amount between {{ $Withdraw_limit->minimum_withdraw ?? 0 }} and {{ $Withdraw_limit->maximum_withdraw ?? 0 }}">
                            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Account Number --}}
                        <div class="mb-3">
                            <label class="form-label">Your Account Number</label>
                            <input type="text" name="account_number" class="form-control" placeholder="Enter Your Account Number">
                            @error('account_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-control">
                                <option value="">-- Select Payment Method --</option>
                                @foreach($payment_method_name as $method)
                                    <option value="{{ $method->id }}" data-number="{{ $method->accountnumber ?? '' }}">
                                        {{ $method->bankname ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary">💾 Submit Withdraw</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
