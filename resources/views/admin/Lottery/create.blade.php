@extends('admin.master')

@section('admin')
<div class="container-fluid my-4">

    {{-- Back to List --}}
    <a href="{{ route('lottery.index') }}" class="btn btn-success mb-3">
        <i class="bi bi-list"></i> Ticket  List
    </a>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3 text-uppercase fw-bold">Ticket  Lottery</h5>

            <form action="{{ route('lottery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Lottery Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ticket Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter lottery name"
                        value="{{ old('name') }}">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Ticket Price --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ticket Price (USD)</label>
                    <input type="number" step="0.01" name="price" class="form-control"
                        placeholder="Enter ticket price" value="{{ old('price') }}">
                    @error('price') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Write lottery description...">{{ old('description') }}</textarea>
                    @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Image Upload --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ticket Image</label>
                    <input type="file" name="photo" class="form-control">
                    @error('photo') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Draw Date --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Draw Date & Time</label>
                    <input type="datetime-local" name="draw_date" id="draw_date" class="form-control"
                        value="{{ old('draw_date') }}">
                    <small id="countdown" class="text-success d-block mt-2"></small>
                    @error('draw_date') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Win Type --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Win Type (1–30 Days)</label>
                    <select name="win_type" class="form-select">
                        @for ($i = 1; $i <= 30; $i++)
                            <option value="{{ $i }}days" {{ old('win_type') == $i.'days' ? 'selected' : '' }}>
                                {{ $i }} Days
                            </option>
                        @endfor
                    </select>
                    @error('win_type') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Prizes Section --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">1st Prize</label>
                        <input type="text" name="first_prize" class="form-control"
                            placeholder="Ex: $1000 or Car" value="{{ old('first_prize') }}">
                        @error('first_prize') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">2nd Prize</label>
                        <input type="text" name="second_prize" class="form-control"
                            placeholder="Ex: $500" value="{{ old('second_prize') }}">
                        @error('second_prize') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">3rd Prize</label>
                        <input type="text" name="third_prize" class="form-control"
                            placeholder="Ex: $250" value="{{ old('third_prize') }}">
                        @error('third_prize') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-save"></i> Save Ticket
                </button>

            </form>
        </div>
    </div>
</div>


{{-- Countdown Script --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const drawInput = document.getElementById('draw_date');
    const countdownEl = document.getElementById('countdown');

    // 12 Hour Format
    function format12Hour(date) {
        let h = date.getHours();
        let m = date.getMinutes();
        let s = date.getSeconds();

        const ampm = h >= 12 ? 'PM' : 'AM';

        h = h % 12 || 12;

        return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')} ${ampm}`;
    }

    // Countdown Function
    function updateCountdown() {
        const selected = drawInput.value;
        if (!selected) {
            countdownEl.textContent = '';
            return;
        }

        const drawDate = new Date(selected);
        const now = new Date();
        const diff = drawDate - now;

        if (diff <= 0) {
            countdownEl.textContent = '🎉 Draw time has arrived!';
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const mins = Math.floor((diff / (1000 * 60)) % 60);
        const secs = Math.floor((diff / 1000) % 60);

        countdownEl.textContent =
            `⏳ ${days}d ${hours}h ${mins}m ${secs}s remaining | Draw Time: ${format12Hour(drawDate)}`;
    }

    drawInput.addEventListener('input', updateCountdown);
    setInterval(updateCountdown, 1000);
});
</script>

@endsection
