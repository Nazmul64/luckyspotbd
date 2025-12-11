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
                    <h4 class="mb-4">💳 Add Deposit</h4>

                    @if(isset($deposite_limit))
                        <div class="alert alert-info">
                            Minimum Deposit: <strong>{{ $deposite_limit->minimum_deposite ?? 0 }} টাকা</strong> |
                            Maximum Deposit: <strong>{{ $deposite_limit->maximum_deposite ?? 0 }} টাকা</strong>
                        </div>
                    @endif

                    <form action="{{ route('frontend.deposit.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Amount --}}
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number"
                                   name="amount"
                                   class="form-control"
                                   step="0.01"
                                   min="{{ $deposite_limit->minimum_deposite ?? 0 }}"
                                   max="{{ $deposite_limit->maximum_deposite ?? 0 }}"
                                   placeholder="Enter amount between {{ $deposite_limit->minimum_deposite ?? 0 }} and {{ $deposite_limit->maximum_deposite ?? 0 }}">
                            @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select id="payment_method_select" name="payment_method" class="form-control">
                                <option value="">-- Select Payment Method --</option>
                                @foreach ($payment_method_name as $item)
                                    <option
                                        value="{{ $item->id }}"
                                        data-number="{{ $item->accountnumber ?? '' }}">
                                        {{ $item->accountnumber ?? '' }} -- {{ $item->bankname ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method') <span class="text-danger">{{ $message }}</span> @enderror

                            {{-- Copy Button --}}
                            <div class="mt-2 d-flex align-items-center gap-2">
                                <input type="text" id="copy_account_number" readonly class="form-control w-auto">
                                <button type="button" id="copy_button" class="btn btn-sm btn-secondary">Copy</button>
                            </div>
                        </div>

                        {{-- Transaction ID --}}
                        <div class="mb-3">
                            <label class="form-label">Transaction ID (optional)</label>
                            <input type="text" name="transaction_id" class="form-control">
                        </div>

                        {{-- Screenshot --}}
                        <div class="mb-3">
                            <label class="form-label">Screenshot (optional)</label>
                            <input type="file" name="screenshot" class="form-control">
                            @error('screenshot') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="btn btn-primary">💾 Submit Deposit</button>
                    </form>
                </div>

                {{-- JavaScript: Copy Account Number --}}
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const paymentSelect = document.getElementById('payment_method_select');
                        const copyInput = document.getElementById('copy_account_number');
                        const copyButton = document.getElementById('copy_button');

                        // Update input when a payment method is selected
                        paymentSelect.addEventListener('change', function () {
                            const selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
                            copyInput.value = selectedOption.dataset.number || '';
                        });

                        // Copy account number to clipboard
                        copyButton.addEventListener('click', function () {
                            if (!copyInput.value) return;
                            copyInput.select();
                            copyInput.setSelectionRange(0, 99999); // For mobile
                            document.execCommand('copy');
                            alert('Account number copied: ' + copyInput.value);
                        });
                    });
                </script>
            </div>

        </div>
    </div>
</div>

@endsection
