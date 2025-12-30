@extends('frontend.master')

@section('content')

    {{-- User Top Section --}}
    @include('frontend.dashboard.usersection')

    <div class="container mt-4">
        <div class="row">
                @include('frontend.dashboard.sidebar')
            {{-- Main Content --}}
            <div class="col-lg-9">
                <div class="row gy-4">

                    <!-- Help Box -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm text-center p-4 rounded-4">
                            <h3 class="fw-bold text-danger mb-1">Need Help?</h3>
                            <p class="text-muted mb-0">
                                We're here to assist you 24/7
                            </p>
                        </div>
                    </div>

                    <!-- Support Contact Cards -->
                   @foreach ($supportcontact as $contact)
                        <div class="col-6 col-md-4 col-lg-4">
                            <div class="card border-0 shadow-sm text-center p-4 rounded-4 h-100">

                                <div class="mb-2">
                                    <a href="{{ $contact->support_link }}" target="_blank">
                                        <img
                                            src="{{ asset('uploads/supports/' . $contact->photo) }}"
                                            alt="{{ $contact->title }}"
                                            class="img-fluid">
                                    </a>
                                </div>

                                <h6 class="fw-semibold mb-1 text-black"
                                    style="height: 40px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $contact->title }}
                                </h6>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

@endsection
