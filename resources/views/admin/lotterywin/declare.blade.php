@extends('admin.master')

@section('admin')
<div class="container mt-4">

    <h3 class="mb-3">
        🎟 Declare Winners for:
        <span class="text-primary">{{ $lottery->name }}</span>
    </h3>

    @if($buyers->isEmpty())
        <div class="alert alert-warning">
            No eligible buyers for this lottery.
        </div>
    @else
        <form action="{{ route('admin.lottery.declare', $lottery->id) }}" method="POST">
            @csrf

            <!-- RANDOM SELECTION TOGGLE -->
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="randomCheckbox" name="random" value="1">
                <label class="form-check-label fw-bold" for="randomCheckbox">
                    Select Random Winners Automatically
                </label>
            </div>

            <div id="manualSection">
                <h5 class="mb-3">👤 Manual Winner Selection</h5>
                <input type="text" id="searchBox" class="form-control mb-3" placeholder="Search user by name...">

                @foreach(['first','second','third'] as $position)
                    <div class="card mb-3 winner-section">
                        <div class="card-header fw-bold">{{ ucfirst($position) }} Winner</div>
                        <div class="card-body">

                            <!-- USER LIST -->
                            <div class="border rounded p-2 user-list" data-position="{{ $position }}" style="max-height:200px; overflow-y:auto;">
                                @foreach($buyers as $buyer)
                                    <div class="form-check user-item" data-name="{{ strtolower($buyer->user->name) }}">
                                        <input class="form-check-input" type="radio"
                                               name="{{ $position }}_winner"
                                               value="{{ $buyer->user->id }}"
                                               id="{{ $position }}_{{ $buyer->user->id }}">
                                        <label class="form-check-label" for="{{ $position }}_{{ $buyer->user->id }}">
                                            {{ $buyer->user->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- GIFT AMOUNT -->
                            <input type="number"
                                   name="{{ $position }}_prize"
                                   class="form-control mt-3 prize-input"
                                   placeholder="Enter gift amount"
                                   min="0" value="0" style="display:none;">
                        </div>
                    </div>
                @endforeach

                <!-- MULTIPLE PRIZES / TITLES -->
                <div class="card mb-3">
                    <div class="card-header fw-bold">Multiple Prizes / Titles</div>
                    <div class="card-body">
                        <div id="multipleFieldsContainer">
                            @php
                                $titles = is_array($lottery->multiple_title) ? $lottery->multiple_title : json_decode($lottery->multiple_title ?? '[]', true);
                                $prices = is_array($lottery->multiple_price) ? $lottery->multiple_price : json_decode($lottery->multiple_price ?? '[]', true);
                                $count = max(count($titles), count($prices), 1);
                            @endphp

                            @for($i=0; $i<$count; $i++)
                                <div class="row mb-2 multiple-field">
                                    <div class="col-md-6">
                                        <input type="text" name="multiple_title[]" class="form-control" placeholder="Enter title" value="{{ $titles[$i] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="multiple_price[]" class="form-control" placeholder="Enter price" min="0" value="{{ $prices[$i] ?? 0 }}">
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addMultipleField">+ Add More</button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">✅ Declare Winners</button>
        </form>
    @endif
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const randomCheckbox = document.getElementById("randomCheckbox");
    const manualSection = document.getElementById("manualSection");

    randomCheckbox.addEventListener("change", function(){
        manualSection.style.display = this.checked ? "none" : "block";
    });

    document.querySelectorAll(".user-list").forEach(list=>{
        list.addEventListener("change", function(e){
            if(e.target.type === "radio"){
                const prizeInput = this.closest(".winner-section").querySelector(".prize-input");
                prizeInput.style.display = "block";
            }
        });
    });

    document.getElementById("searchBox").addEventListener("keyup", function(){
        const query = this.value.toLowerCase();
        document.querySelectorAll(".user-item").forEach(item=>{
            item.style.display = item.dataset.name.includes(query) ? "block" : "none";
        });
    });

    const addBtn = document.getElementById("addMultipleField");
    const container = document.getElementById("multipleFieldsContainer");
    addBtn.addEventListener("click", function(){
        const div = document.createElement("div");
        div.classList.add("row", "mb-2", "multiple-field");
        div.innerHTML = `
            <div class="col-md-6">
                <input type="text" name="multiple_title[]" class="form-control" placeholder="Enter title">
            </div>
            <div class="col-md-6">
                <input type="number" name="multiple_price[]" class="form-control" placeholder="Enter price" min="0">
            </div>
        `;
        container.appendChild(div);
    });
});
</script>

<style>
.user-list { max-height:200px; overflow-y:auto; }
.prize-input { display:none; }
</style>
@endsection
