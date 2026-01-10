@extends('admin.master')
@section('admin')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Edit How To Ticket</h4>
        <a href="{{ route('howtoticket.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('howtoticket.update', $howtoticket->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Language Tabs -->
                <ul class="nav nav-tabs mb-3" id="languageTabs" role="tablist">
                    @foreach($languages as $code => $name)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="{{ $code }}-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#{{ $code }}"
                                    type="button"
                                    role="tab">
                                {{ $name }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="languageTabContent">
                    @foreach($languages as $code => $name)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                             id="{{ $code }}"
                             role="tabpanel">

                            <div class="mb-3">
                                <label class="form-label">Title ({{ $name }}) <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="title[{{ $code }}]"
                                       class="form-control @error("title.$code") is-invalid @enderror"
                                       value="{{ old("title.$code", $howtoticket->title[$code] ?? '') }}"
                                       required>
                                @error("title.$code")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description ({{ $name }})</label>
                                <textarea name="description[{{ $code }}]"
                                          class="form-control @error("description.$code") is-invalid @enderror"
                                          rows="3">{{ old("description.$code", $howtoticket->description[$code] ?? '') }}</textarea>
                                @error("description.$code")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <h6 class="mb-3">Steps ({{ $name }})</h6>

                            <div class="mb-3">
                                <label class="form-label">Step 1: Sign Up / First Login</label>
                                <textarea name="sign_up_first_login[{{ $code }}]"
                                          class="form-control"
                                          rows="2">{{ old("sign_up_first_login.$code", $howtoticket->sign_up_first_login[$code] ?? '') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Step 2: Complete Your Profile</label>
                                <textarea name="complete_your_profile[{{ $code }}]"
                                          class="form-control"
                                          rows="2">{{ old("complete_your_profile.$code", $howtoticket->complete_your_profile[$code] ?? '') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Step 3: Choose A Ticket</label>
                                <textarea name="choose_a_ticket[{{ $code }}]"
                                          class="form-control"
                                          rows="2">{{ old("choose_a_ticket.$code", $howtoticket->choose_a_ticket[$code] ?? '') }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr>

                <!-- Icon Fields (Language Independent) -->
                <h6 class="mb-3">Step Icons</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Step 1 Icon</label>
                        <input type="text"
                               name="sign_up_first_login_icon"
                               class="form-control"
                               placeholder="fas fa-user-plus"
                               value="{{ old('sign_up_first_login_icon', $howtoticket->sign_up_first_login_icon) }}">
                        <small class="text-muted">FontAwesome class</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Step 2 Icon</label>
                        <input type="text"
                               name="complete_your_profile_icon"
                               class="form-control"
                               placeholder="fas fa-user-check"
                               value="{{ old('complete_your_profile_icon', $howtoticket->complete_your_profile_icon) }}">
                        <small class="text-muted">FontAwesome class</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Step 3 Icon</label>
                        <input type="text"
                               name="choose_a_ticket_icon"
                               class="form-control"
                               placeholder="fas fa-ticket-alt"
                               value="{{ old('choose_a_ticket_icon', $howtoticket->choose_a_ticket_icon) }}">
                        <small class="text-muted">FontAwesome class</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('howtoticket.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
