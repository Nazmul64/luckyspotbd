{{-- resources/views/admin/slider/create.blade.php --}}

@extends('admin.master')

@section('admin')

<div class="row">
    <div class="col-12 mx-auto">
        <h6 class="mb-3 text-uppercase">Create Slider</h6>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ✅ Language Tabs --}}
                    <ul class="nav nav-tabs mb-4" id="languageTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active"
                                    id="english-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#english"
                                    type="button"
                                    role="tab">
                                🇬🇧 English
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link"
                                    id="bangla-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#bangla"
                                    type="button"
                                    role="tab">
                                🇧🇩 বাংলা
                            </button>
                        </li>
                    </ul>

                    {{-- ✅ Tab Content --}}
                    <div class="tab-content" id="languageTabContent">

                        {{-- English Content --}}
                        <div class="tab-pane fade show active" id="english" role="tabpanel">
                            <!-- Title (English) -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Title (English) <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="title_en"
                                       class="form-control @error('title_en') is-invalid @enderror"
                                       value="{{ old('title_en') }}"
                                       placeholder="Enter Title in English">
                                @error('title_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description (English) -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Description (English) <span class="text-danger">*</span>
                                </label>
                                <textarea name="description_en"
                                          class="form-control @error('description_en') is-invalid @enderror"
                                          rows="5"
                                          placeholder="Enter Description in English">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Bangla Content --}}
                        <div class="tab-pane fade" id="bangla" role="tabpanel">
                            <!-- Title (Bangla) -->
                            <div class="mb-3">
                                <label class="form-label">
                                    শিরোনাম (বাংলা) <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="title_bn"
                                       class="form-control @error('title_bn') is-invalid @enderror"
                                       value="{{ old('title_bn') }}"
                                       placeholder="বাংলায় শিরোনাম লিখুন">
                                @error('title_bn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description (Bangla) -->
                            <div class="mb-3">
                                <label class="form-label">
                                    বিবরণ (বাংলা) <span class="text-danger">*</span>
                                </label>
                                <textarea name="description_bn"
                                          class="form-control @error('description_bn') is-invalid @enderror"
                                          rows="5"
                                          placeholder="বাংলায় বিবরণ লিখুন">{{ old('description_bn') }}</textarea>
                                @error('description_bn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <!-- Photo -->
                    <div class="mb-3">
                        <label class="form-label">
                            Photo <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               name="photo"
                               class="form-control @error('photo') is-invalid @enderror"
                               accept="image/*">
                        <small class="text-muted">Max size: 2MB | Formats: JPG, JPEG, PNG, WEBP</small>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Save Slider
                    </button>
                    <a href="{{ route('slider.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
