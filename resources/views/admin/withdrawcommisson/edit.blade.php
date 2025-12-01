@extends('admin.master')
@section('admin')

<div class="container-fluid my-4">

    {{-- Back Button --}}
    <a href="{{ route('withdrawcommisson.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h4 class="mb-4">Edit Withdraw Commission</h4>

            <form action="{{ route('withdrawcommisson.update', $withdrawCommission->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Withdraw Commission --}}
                <div class="mb-3">
                    <label for="withdraw_commission" class="form-label">Withdraw Commission</label>
                    <input type="number" step="0.01" name="withdraw_commission" id="withdraw_commission"
                           class="form-control @error('withdraw_commission') is-invalid @enderror"
                           value="{{ old('withdraw_commission', $withdrawCommission->withdraw_commission) }}"
                           placeholder="Enter withdraw commission">
                    @error('withdraw_commission')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Minimum Withdraw --}}
                <div class="mb-3">
                    <label for="minimum_withdraw" class="form-label">Minimum Withdraw</label>
                    <input type="number" step="0.01" name="minimum_withdraw" id="minimum_withdraw"
                           class="form-control @error('minimum_withdraw') is-invalid @enderror"
                           value="{{ old('minimum_withdraw', $withdrawCommission->minimum_withdraw) }}"
                           placeholder="Enter minimum withdraw">
                    @error('minimum_withdraw')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Maximum Withdraw --}}
                <div class="mb-3">
                    <label for="maximum_withdraw" class="form-label">Maximum Withdraw</label>
                    <input type="number" step="0.01" name="maximum_withdraw" id="maximum_withdraw"
                           class="form-control @error('maximum_withdraw') is-invalid @enderror"
                           value="{{ old('maximum_withdraw', $withdrawCommission->maximum_withdraw) }}"
                           placeholder="Enter maximum withdraw">
                    @error('maximum_withdraw')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Minimum Deposite --}}
                <div class="mb-3">
                    <label for="minimum_deposite" class="form-label">Minimum Deposite</label>
                    <input type="number" step="0.01" name="minimum_deposite" id="minimum_deposite"
                           class="form-control @error('minimum_deposite') is-invalid @enderror"
                           value="{{ old('minimum_deposite', $withdrawCommission->minimum_deposite) }}"
                           placeholder="Enter minimum deposite">
                    @error('minimum_deposite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Maximum Deposite --}}
                <div class="mb-3">
                    <label for="maximum_deposite" class="form-label">Maximum Deposite</label>
                    <input type="number" step="0.01" name="maximum_deposite" id="maximum_deposite"
                           class="form-control @error('maximum_deposite') is-invalid @enderror"
                           value="{{ old('maximum_deposite', $withdrawCommission->maximum_deposite) }}"
                           placeholder="Enter maximum deposite">
                    @error('maximum_deposite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                           {{ $withdrawCommission->status ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Active</label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i> Update
                </button>

            </form>
        </div>
    </div>
</div>

@endsection
