@extends('frontend.master')

@section('content')

@php
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

    $translations = [
        'en' => [
            'page_title' => 'Commissions Log',
            'page_subtitle' => 'Track your commission earnings',
            'date' => 'Date',
            'from' => 'From',
            'amount' => 'Amount',
            'total_commission' => 'Total Commission',
            'this_month' => 'This Month',
            'no_records' => 'No commission records found.',
            'unknown' => 'Unknown',
            'stats_title' => 'Commission Stats',
            'total_earned' => 'Total Earned',
            'recent_activity' => 'Recent Activity',
        ],
        'bn' => [
            'page_title' => 'কমিশন লগ',
            'page_subtitle' => 'আপনার কমিশন আয় ট্র্যাক করুন',
            'date' => 'তারিখ',
            'from' => 'থেকে',
            'amount' => 'পরিমাণ',
            'total_commission' => 'মোট কমিশন',
            'this_month' => 'এই মাসে',
            'no_records' => 'কোন কমিশন রেকর্ড পাওয়া যায়নি।',
            'unknown' => 'অজানা',
            'stats_title' => 'কমিশন পরিসংখ্যান',
            'total_earned' => 'মোট আয়',
            'recent_activity' => 'সাম্প্রতিক কার্যকলাপ',
        ],
    ];

    $lang = $translations[$isBangla ? 'bn' : 'en'];

    // Calculate statistics
    $totalCommission = $commissions->sum('amount');
    $thisMonthCommission = $commissions->where('created_at', '>=', now()->startOfMonth())->sum('amount');
@endphp

@include('frontend.dashboard.usersection')

<div class="dashboard-section padding-top padding-bottom">
    <div class="container">
        <div class="row">

            @include('frontend.dashboard.sidebar')

            <div class="col-lg-9">

                {{-- HEADER --}}
                <div class="commission-header">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div>
                            <h4>{{ $lang['page_title'] }}</h4>
                            <p>{{ $lang['page_subtitle'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    {{-- TOTAL COMMISSION --}}
                    <div class="col-md-6">
                        <div class="stat-card total-card">
                            <div class="stat-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="stat-info">
                                <h6>{{ $lang['total_commission'] }}</h6>
                                <h3>${{ number_format($totalCommission, 2) }}</h3>
                            </div>
                        </div>
                    </div>

                    {{-- THIS MONTH --}}
                    <div class="col-md-6">
                        <div class="stat-card month-card">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-info">
                                <h6>{{ $lang['this_month'] }}</h6>
                                <h3>${{ number_format($thisMonthCommission, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABLE CARD --}}
                <div class="table-card">
                    <div class="table-header">
                        <h5><i class="fas fa-list"></i> {{ $lang['recent_activity'] }}</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-calendar"></i> {{ $lang['date'] }}</th>
                                    <th><i class="fas fa-user"></i> {{ $lang['from'] }}</th>
                                    <th><i class="fas fa-dollar-sign"></i> {{ $lang['amount'] }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commissions as $commission)
                                    <tr>
                                        <td>
                                            <span class="date-badge">
                                                {{ $commission->created_at->format('Y-m-d') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    {{ strtoupper(substr($commission->fromUser->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <span>{{ $commission->fromUser->name ?? $lang['unknown'] }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="amount-badge">
                                                ${{ number_format($commission->amount, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox"></i>
                                                <p>{{ $lang['no_records'] }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

{{-- ===================== STYLES ===================== --}}
<style>
:root {
    {{ $isBangla ? '--font: "Kalpurush", sans-serif;' : '--font: -apple-system, sans-serif;' }}
}

/* HEADER */
.commission-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px 30px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 20px;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 35px;
    color: #fff;
    flex-shrink: 0;
}

.header-content h4 {
    color: #fff;
    font-size: 26px;
    font-weight: 700;
    margin: 0 0 5px 0;
    font-family: var(--font);
}

.header-content p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 14px;
}

/* STAT CARDS */
.stat-card {
    border-radius: 15px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.total-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.month-card {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #fff;
    flex-shrink: 0;
}

.stat-info h6 {
    color: rgba(255, 255, 255, 0.9);
    font-size: 14px;
    margin: 0 0 8px 0;
    font-weight: 600;
    font-family: var(--font);
}

.stat-info h3 {
    color: #fff;
    font-size: 32px;
    margin: 0;
    font-weight: 700;
    font-family: var(--font);
}

/* TABLE CARD */
.table-card {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3);
    overflow: hidden;
}

.table-header {
    background: rgba(255, 255, 255, 0.2);
    padding: 20px 25px;
    border-bottom: 2px solid rgba(255, 255, 255, 0.3);
}

.table-header h5 {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--font);
}

.table-responsive {
    padding: 0;
}

/* CUSTOM TABLE */
.custom-table {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
}

.custom-table thead {
    background: rgba(255, 255, 255, 0.15);
}

.custom-table thead tr th {
    padding: 18px 25px;
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    text-align: left;
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    font-family: var(--font);
}

.custom-table thead tr th i {
    margin-right: 8px;
    opacity: 0.9;
}

.custom-table tbody tr {
    transition: all 0.3s;
}

.custom-table tbody tr:hover {
    background: rgba(255, 255, 255, 0.1);
}

.custom-table tbody tr td {
    padding: 18px 25px;
    color: #fff;
    font-size: 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    font-family: var(--font);
}

.custom-table tbody tr:last-child td {
    border-bottom: none;
}

/* DATE BADGE */
.date-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #fff;
}

/* USER INFO */
.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    color: #fff;
}

/* AMOUNT BADGE */
.amount-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.3);
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 700;
    color: #fff;
}

/* EMPTY STATE */
.empty-state {
    padding: 60px 20px;
    text-align: center;
}

.empty-state i {
    font-size: 60px;
    color: rgba(255, 255, 255, 0.4);
    margin-bottom: 20px;
}

.empty-state p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 16px;
    margin: 0;
    font-family: var(--font);
}

/* ANIMATIONS */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card, .table-card {
    animation: fadeIn 0.5s ease;
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .commission-header {
        padding: 20px;
    }
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    .header-icon {
        width: 60px;
        height: 60px;
        font-size: 30px;
    }
    .header-content h4 {
        font-size: 22px;
    }
}

@media (max-width: 767px) {
    .stat-card {
        padding: 20px;
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }
    .stat-info h3 {
        font-size: 26px;
    }
    .custom-table thead tr th,
    .custom-table tbody tr td {
        padding: 12px 15px;
        font-size: 13px;
    }
    .user-avatar {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .table-responsive {
        overflow-x: auto;
    }
    .custom-table {
        min-width: 600px;
    }
    .empty-state {
        padding: 40px 20px;
    }
    .empty-state i {
        font-size: 40px;
    }
}
</style>

@endsection
