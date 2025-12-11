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
                <section class="profile-section padding-top padding-bottom">
                    <div class="container">
                        <div class="profile-edit-wrapper">

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form method="POST" action="{{ route('profile.update', auth()->user()->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row gy-5">

                                    {{-- LEFT AREA --}}
                                    <div class="col-xl-4">
                                        <div class="profile__thumb__edit text-center custom--card">
                                            <div class="card--body">

                                                <div class="thumb">
                                                    <img id="preview-image"
                                                        src="{{ auth()->user()->profile_photo ? asset('uploads/profile/' . auth()->user()->profile_photo) : asset('assets/images/account/user.png') }}"
                                                        alt="profile"
                                                        style="width:150px; height:150px; border-radius:50%; object-fit:cover;">
                                                </div>

                                                <div class="profile__info">
                                                    <h4>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h4>
                                                    <input type="file" name="image" class="d-none" id="update-photo">
                                                    <label class="cmn--btn active btn--md mt-3" for="update-photo">
                                                        Update Profile Picture
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- RIGHT FORM --}}
                                    <div class="col-xl-8">
                                        <div class="custom--card card--lg">
                                            <div class="card--body">

                                                <div class="row gy-3">

                                                    <div class="col-md-6">
                                                        <label class="form-label">First Name</label>
                                                        <input type="text" name="first_name" value="{{ auth()->user()->first_name }}"
                                                            class="form-control form--control style-two">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Last Name</label>
                                                        <input type="text" name="last_name" value="{{ auth()->user()->last_name }}"
                                                            class="form-control form--control style-two">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" name="username" value="{{ auth()->user()->username }}"
                                                            class="form-control form--control style-two">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" name="email" value="{{ auth()->user()->email }}"
                                                            class="form-control form--control style-two">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Country</label>
                                                        <select name="country" class="form-select form--control style-two">
                                                            <option value="Bangladesh" {{ auth()->user()->country == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                                            <option value="India" {{ auth()->user()->country == 'India' ? 'selected' : '' }}>India</option>
                                                            <option value="Other" {{ auth()->user()->country == 'Other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Phone</label>
                                                        <input type="text" name="number" value="{{ auth()->user()->number }}"
                                                            class="form-control form--control style-two">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Address</label>
                                                        <input type="text" name="address" value="{{ auth()->user()->address }}"
                                                            class="form-control form--control style-two">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">Zip Code</label>
                                                        <input type="text" name="zip_code" value="{{ auth()->user()->zip_code }}"
                                                            class="form-control form--control style-two">
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button class="cmn--btn active mt-3">Update Profile</button>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>
                </section>

                {{-- LIVE IMAGE PREVIEW --}}
                <script>
                    document.getElementById('update-photo').addEventListener('change', function(e) {
                        let reader = new FileReader();
                        reader.onload = function(event) {
                            document.getElementById('preview-image').src = event.target.result;
                        }
                        reader.readAsDataURL(this.files[0]);
                    });
                </script>

            </div>

        </div>
    </div>
</div>

@endsection
