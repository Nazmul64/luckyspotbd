@extends('admin.master')
@section('admin')
<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">
                 <div class="col">
                  <div class="card rounded-4">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <a class="mb-1"href="{{route('admin.userlist')}}">Total User</a>
                          <h4 class="mb-0">{{$user_count ?? ''}}</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-primary text-white">
                          <i class="bi bi-basket2"></i>
                        </div>
                      </div>

                    </div>
                  </div>
                 </div>
                 <div class="col">
                  <div class="card rounded-4">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total Deposite</p>
                          <h4 class="mb-0">$9,786</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-success text-white">
                          <i class="bi bi-currency-dollar"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                 </div>
                 <div class="col">
                  <div class="card rounded-4">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total Widthraw</p>
                          <h4 class="mb-0">875</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-orange text-white">
                          <i class="bi bi-emoji-heart-eyes"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                 </div>
                 <div class="col">
                  <div class="card rounded-4">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="">
                          <p class="mb-1">Total Lottery Buy</p>
                          <h4 class="mb-0">9853</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-info text-white">
                          <i class="bi bi-people-fill"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                 </div>

             </div><!--end row-->

@endsection
