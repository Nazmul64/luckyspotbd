@extends('frontend.master')

@section('content')

    <!-- inner hero section start -->
<section class="inner-banner bg_img" style="background: url('assets/images/inner-banner/bg2.jpg') top;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-xl-6 text-center">
        <h2 class="title text-white">User Dashboard</h2>
        <ul class="breadcrumbs d-flex flex-wrap align-items-center justify-content-center">
          <li><a href="{{route('frontend')}}">Home</a></li>
          <li>Dashboard</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- inner hero section end -->

    <!-- Dashboard Section Starts Here -->
    <div class="dashboard-section padding-top padding-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="close-dashboard d-lg-none">
                            <i class="las la-times"></i>
                        </div>
                        <div class="dashboard-user">
                            <div class="user-thumb">
                                <img src="assets/images/top/item1.png" alt="dashboard">
                            </div>
                            <div class="user-content">
                                <span class="fs-sm">Welcome</span>
                                <h5 class="name">Munna Ahmed</h5>
                                <ul class="user-option">
                                    <li>
                                        <a href="#0">
                                            <i class="las la-pen"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <ul class="user-dashboard-tab">
                            <li>
                                <a href="#" class="active">Dashboard</a>
                            </li>
                            <li>
                                <a href="#">Deposit History</a>
                            </li>
                            <li>
                                <a href="#">Withdraw History</a>
                            </li>
                            <li>
                                <a href="#">Transection History</a>
                            </li>
                            <li>
                                <a href="#">Account Settings</a>
                            </li>
                            <li>
                                <a href="#">Security Settings</a>
                            </li>
                            @auth
                            <li>
                                <a href="{{ route('frontend.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign Out
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @endauth

                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="user-toggler-wrapper d-flex align-items-center d-lg-none">
                        <h4 class="title m-0">User Dashboard</h4>
                        <div class="user-toggler">
                            <i class="las la-sliders-h"></i>
                        </div>
                    </div>
                    <div class="row justify-content-center g-4">
                        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
                            <div class="dashboard__card">
                                <div class="dashboard__card-content">
                                    <h2 class="price">$3750</h2>
                                    <p class="info">TOTAL BALANCE</p>
                                    <a href="#0" class="view-btn">View All</a>
                                </div>
                                <div class="dashboard__card-icon">
                                    <i class="las la-wallet"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
                            <div class="dashboard__card">
                                <div class="dashboard__card-content">
                                    <h2 class="price">$4550</h2>
                                    <p class="info">TOTAL DEPOSIT</p>
                                    <a href="#0" class="view-btn">View All</a>
                                </div>
                                <div class="dashboard__card-icon">
                                    <i class="las la-wallet"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-10">
                            <div class="dashboard__card">
                                <div class="dashboard__card-content">
                                    <h2 class="price">$2500</h2>
                                    <p class="info">TOTAL WITHDRAW</p>
                                    <a href="#0" class="view-btn">View All</a>
                                </div>
                                <div class="dashboard__card-icon">
                                    <i class="las la-money-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-5 row gy-4 justify-content-center">
                        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6">
                            <div class="game-item">
                                <div class="game-inner">
                                    <div class="game-item__thumb">
                                        <img src="assets/images/game/item2.png" alt="game">
                                    </div>
                                    <div class="game-item__content">
                                        <h4 class="title">Roulette</h4>
                                        <p class="invest-info">Invest Limit</p>
                                        <p class="invest-amount">$10.49 - $1,000</p>
                                        <a href="#0" class="cmn--btn active btn--md radius-0">Play Now</a>
                                    </div>
                                </div>
                                <div class="ball"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6">
                            <div class="game-item">
                                <div class="game-inner">
                                    <div class="game-item__thumb">
                                        <img src="assets/images/game/item1.png" alt="game">
                                    </div>
                                    <div class="game-item__content">
                                        <h4 class="title">Zero To Ninty</h4>
                                        <p class="invest-info">Invest Limit</p>
                                        <p class="invest-amount">$10.49 - $1,000</p>
                                        <a href="#0" class="cmn--btn active btn--md radius-0">Play Now</a>
                                    </div>
                                </div>
                                <div class="ball"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6">
                            <div class="game-item">
                                <div class="game-inner">
                                    <div class="game-item__thumb">
                                        <img src="assets/images/game/item3.png" alt="game">
                                    </div>
                                    <div class="game-item__content">
                                        <h4 class="title">Number Buy</h4>
                                        <p class="invest-info">Invest Limit</p>
                                        <p class="invest-amount">$10.49 - $1,000</p>
                                        <a href="#0" class="cmn--btn active btn--md radius-0">Play Now</a>
                                    </div>
                                </div>
                                <div class="ball"></div>
                            </div>
                        </div>
                    </div>
                    <div class="table--responsive--md mt-5">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Transection ID</th>
                                    <th>Transection Type</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="trx-id" data-label="Transection ID">#481XV93NCKD0</td>
                                    <td class="trx-type" data-label="Transection Type">Withdraw</td>
                                    <td class="date" data-label="Date">12 Mar, 21 at 12:30 AM</td>
                                    <td class="amount" data-label="Amount">$150.50</td>
                                </tr>
                                <tr>
                                    <td class="trx-id" data-label="Transection ID">#V93N481XCKD0</td>
                                    <td class="trx-type" data-label="Transection Type">Deposit</td>
                                    <td class="date" data-label="Date">12 Mar, 21 at 12:30 AM</td>
                                    <td class="amount" data-label="Amount">$500.50</td>
                                </tr>
                                <tr>
                                    <td class="trx-id" data-label="Transection ID">#1XCKD0V93N48</td>
                                    <td class="trx-type" data-label="Transection Type">Deposit</td>
                                    <td class="date" data-label="Date">12 Mar, 21 at 12:30 AM</td>
                                    <td class="amount" data-label="Amount">$350.50</td>
                                </tr>
                                <tr>
                                    <td class="trx-id" data-label="Transection ID">#V981XCKD03N4</td>
                                    <td class="trx-type" data-label="Transection Type">Withdraw</td>
                                    <td class="date" data-label="Date">12 Mar, 21 at 12:30 AM</td>
                                    <td class="amount" data-label="Amount">$250.50</td>
                                </tr>
                                <tr>
                                    <td class="trx-id" data-label="Transection ID">#481XV93NCKD0</td>
                                    <td class="trx-type" data-label="Transection Type">Deposit</td>
                                    <td class="date" data-label="Date">12 Mar, 21 at 12:30 AM</td>
                                    <td class="amount" data-label="Amount">$150.50</td>
                                </tr>
                                <tr>
                                    <td class="trx-id" data-label="Transection ID">#V93N481XCKD0</td>
                                    <td class="trx-type" data-label="Transection Type">Withdraw</td>
                                    <td class="date" data-label="Date">12 Mar, 21 at 12:30 AM</td>
                                    <td class="amount" data-label="Amount">$500.50</td>
                                </tr>
                                <tr>
                                    <td class="trx-id" data-label="Transection ID">#1XCKD0V93N48</td>
                                    <td class="trx-type" data-label="Transection Type">Deposit</td>
                                    <td class="date" data-label="Date">12 Mar, 21 at 12:30 AM</td>
                                    <td class="amount" data-label="Amount">$350.50</td>
                                </tr>
                                <tr>
                                    <td class="trx-id" data-label="Transection ID">#V981XCKD03N4</td>
                                    <td class="trx-type" data-label="Transection Type">Withdraw</td>
                                    <td class="date" data-label="Date">12 Mar, 21 at 12:30 AM</td>
                                    <td class="amount" data-label="Amount">$250.50</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard Section Ends Here -->
@endsection
