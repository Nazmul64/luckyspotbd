@extends('admin.master')

@section('admin')

<div class="container-fluid my-4">

    <a href="{{ route('lottery.index') }}" class="btn btn-success mb-3">
        <i class="bi bi-list"></i> Ticket List
    </a>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3 text-uppercase fw-bold">Edit Ticket</h5>

            <form action="{{ route('lottery.update', $lottery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Lottery Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ticket Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $lottery->name) }}" placeholder="Enter lottery name">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Ticket Price --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ticket Price (USD)</label>
                    <input type="number" step="0.01" name="price" class="form-control"
                           value="{{ old('price', $lottery->price) }}" placeholder="Enter ticket price">
                    @error('price') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Write lottery description...">{{ old('description', $lottery->description) }}</textarea>
                    @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Photo --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ticket Image</label>
                    <input type="file" name="new_photo" class="form-control">
                    @if($lottery->photo)
                        <img src="{{ asset('uploads/Lottery/'.$lottery->photo) }}" width="80"
                             class="img-thumbnail mt-2" alt="Lottery Image">
                    @endif
                    @error('new_photo') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Draw Date --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Draw Date & Time</label>
                    <input type="datetime-local" name="draw_date" id="draw_date" class="form-control"
                           value="{{ old('draw_date', $lottery->draw_date ? $lottery->draw_date->format('Y-m-d\TH:i') : '') }}">
                    <small id="countdown" class="text-success mt-2 d-block"></small>
                    @error('draw_date') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Win Type (1–30 Days) --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Win Type (1–30 Days)</label>
                    <select name="win_type" class="form-select">
                        @for ($i = 1; $i <= 30; $i++)
                            <option value="{{ $i }}days"
                                {{ old('win_type', $lottery->win_type) == $i.'days' ? 'selected' : '' }}>
                                {{ $i }} Days
                            </option>
                        @endfor
                    </select>
                    @error('win_type') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Prizes --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">1st Prize</label>
                        <input type="text" name="first_prize" class="form-control"
                               value="{{ old('first_prize', $lottery->first_prize) }}" placeholder="Ex: $1000 or Car">
                        @error('first_prize') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">2nd Prize</label>
                        <input type="text" name="second_prize" class="form-control"
                               value="{{ old('second_prize', $lottery->second_prize) }}" placeholder="Ex: $500">
                        @error('second_prize') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">3rd Prize</label>
                        <input type="text" name="third_prize" class="form-control"
                               value="{{ old('third_prize', $lottery->third_prize) }}" placeholder="Ex: $250">
                        @error('third_prize') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $lottery->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $lottery->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-save"></i> Update Ticket
                </button>

            </form>

        </div>
    </div>

</div>

{{-- Countdown Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    const drawInput = document.getElementById('draw_date');
    const countdownEl = document.getElementById('countdown');

    function format12Hour(date) {
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let seconds = date.getSeconds();

        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12 || 12;

        return `${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')} ${ampm}`;
    }

    function updateCountdown() {
        const drawTime = drawInput.value;
        if (!drawTime) {
            countdownEl.textContent = '';
            return;
        }

        const drawDate = new Date(drawTime);
        const now = new Date();
        const diff = drawDate - now;

        if (diff <= 0) {
            countdownEl.textContent = '🎉 Draw time has arrived!';
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);

        countdownEl.textContent =
            `⏳ ${days}d ${hours}h ${minutes}m ${seconds}s remaining | Draw Time: ${format12Hour(drawDate)}`;
    }

    drawInput.addEventListener('input', updateCountdown);
    setInterval(updateCountdown, 1000);

});
</script>

@endsection
