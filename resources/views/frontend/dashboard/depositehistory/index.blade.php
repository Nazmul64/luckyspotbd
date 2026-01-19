@extends('frontend.master')

@section('content')

@php
    // ============================================
    // THEME CONFIGURATION
    // ============================================
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '#667eea';

    // ============================================
    // LANGUAGE DETECTION
    // ============================================
    $currentLang = app()->getLocale() ?? session('locale', 'en');
    $isBangla = ($currentLang === 'bn');

    // ============================================
    // TRANSLATIONS
    // ============================================
    $translations = [
        'en' => [
            'currency' => 'USD',
            'n_a' => 'N/A',
        ],
        'bn' => [
            'currency' => 'টাকা',
            'n_a' => 'প্রযোজ্য নয়',
        ],
    ];

    $lang = $translations[$isBangla ? 'bn' : 'en'];
@endphp

<style>
    /* ============================================
       VIBRANT GRADIENT CARDS
       ============================================ */
    .gradient-card-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        background-color: #f3f0ff;
    }
    .gradient-card-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        background-color: #fff0f6;
    }
    .gradient-card-3 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        background-color: #e6f7ff;
    }
    .gradient-card-4 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        background-color: #e6fff9;
    }
    .gradient-card-5 {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        background-color: #fffbea;
    }
    .gradient-card-6 {
        background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
        background-color: #f0e6ff;
    }

    .stats-card {
        border-radius: 16px;
        padding: 24px;
        color: white;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(45deg);
        transition: all 0.5s ease;
    }

    .stats-card:hover::before {
        top: -60%;
        right: -60%;
    }

    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }

    .stats-icon {
        width: 56px;
        height: 56px;
        background: rgba(255,255,255,0.25);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 16px;
        backdrop-filter: blur(10px);
    }

    .stats-value {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 4px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .stats-label {
        font-size: 14px;
        font-weight: 500;
        opacity: 0.95;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ============================================
       MAIN CARD STYLING
       ============================================ */
    .main-card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 24px;
        border: none;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        font-size: 14px;
        opacity: 0.9;
        margin-top: 4px;
    }

    /* ============================================
       SEARCH INPUT
       ============================================ */
    .search-input {
        border: 2px solid #e8e8e8;
        border-radius: 12px;
        padding: 12px 20px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .search-input::placeholder {
        color: #999;
    }

    /* ============================================
       TABLE STYLING
       ============================================ */
    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #495057;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        padding: 16px 12px;
    }

    .table-modern tbody td {
        padding: 16px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
        color: #333;
    }

    .table-modern tbody tr {
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background: #f8f9ff;
        transform: scale(1.01);
    }

    /* ============================================
       STATUS BADGES
       ============================================ */
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .status-approved {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(67, 233, 123, 0.3);
    }

    .status-rejected {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(245, 87, 108, 0.3);
    }

    .status-pending {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: #333;
        box-shadow: 0 4px 12px rgba(254, 225, 64, 0.3);
    }

    /* ============================================
       EMPTY STATE
       ============================================ */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: white;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }

    .empty-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
    }

    .empty-text {
        font-size: 16px;
        color: #666;
        margin-bottom: 0;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 768px) {
        .stats-card {
            margin-bottom: 16px;
        }

        .page-title {
            font-size: 22px;
        }

        .stats-value {
            font-size: 26px;
        }

        .search-input {
            width: 100% !important;
            margin-top: 16px;
        }

        .table-modern {
            font-size: 12px;
        }

        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 6px;
        }
    }
</style>

@include('frontend.dashboard.usersection')

<div class="container px-3 mt-4">
    <div class="row">
        @include('frontend.dashboard.sidebar')

        <div class="col-lg-9 col-md-8">
            {{-- STATISTICS CARDS --}}
            <div class="row mb-4">
                {{-- Total Withdraws --}}
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stats-card gradient-card-1">
                        <div class="stats-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stats-value">{{ $withdraws->count() }}</div>
                        <div class="stats-label">
                            {{ $isBangla ? 'মোট উইথড্র' : 'Total Withdraws' }}
                        </div>
                    </div>
                </div>

                {{-- Approved --}}
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stats-card gradient-card-4">
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stats-value">{{ $withdraws->where('status', 'approved')->count() }}</div>
                        <div class="stats-label">
                            {{ $isBangla ? 'অনুমোদিত' : 'Approved' }}
                        </div>
                    </div>
                </div>

                {{-- Pending --}}
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="stats-card gradient-card-5">
                        <div class="stats-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stats-value">{{ $withdraws->where('status', 'pending')->count() }}</div>
                        <div class="stats-label">
                            {{ $isBangla ? 'পেন্ডিং' : 'Pending' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT CARD --}}
            <div class="card main-card">
                {{-- Header --}}
                <div class="card-header-custom">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="page-title">
                                {{ $isBangla ? 'উইথড্র হিস্ট্রি' : 'Withdraw History' }}
                            </h4>
                            <p class="page-subtitle mb-0">
                                {{ $isBangla ? 'আপনার সকল উইথড্র রেকর্ড' : 'All your withdraw records' }}
                            </p>
                        </div>

                        <input type="text"
                               id="withdrawSearch"
                               class="search-input"
                               style="max-width: 320px;"
                               placeholder="{{ $isBangla ? 'ওয়ালেট বা অ্যাকাউন্ট নম্বর খুঁজুন...' : 'Search by wallet or account...' }}">
                    </div>
                </div>

                <div class="card-body p-0">
                    @if($withdraws->count())
                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table table-modern" id="withdrawTable">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>{{ $isBangla ? 'ওয়ালেট' : 'Wallet' }}</th>
                                        <th>{{ $isBangla ? 'অ্যাকাউন্ট' : 'Account' }}</th>
                                        <th>{{ $isBangla ? 'পরিমাণ' : 'Amount' }}</th>
                                        <th>{{ $isBangla ? 'চার্জ' : 'Charge' }}</th>
                                        <th>{{ $isBangla ? 'স্ট্যাটাস' : 'Status' }}</th>
                                        <th>{{ $isBangla ? 'তারিখ' : 'Date' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($withdraws as $key => $withdraw)
                                        <tr>
                                            <td class="text-center">
                                                <strong>{{ $key + 1 }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $withdraw->wallet_name }}</strong>
                                            </td>
                                            <td>
                                                <code style="background: #f5f5f5; padding: 4px 8px; border-radius: 4px; font-size: 13px;">
                                                    {{ $withdraw->account_number }}
                                                </code>
                                            </td>
                                            <td>
                                                <strong style="color: #667eea;">
                                                    {{ number_format($withdraw->amount, 2) }} {{ $lang['currency'] }}
                                                </strong>
                                            </td>
                                            <td>
                                                <span style="color: #f5576c;">
                                                    {{ number_format($withdraw->charge, 2) }} {{ $lang['currency'] }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($withdraw->status === 'approved')
                                                    <span class="status-badge status-approved">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        {{ $isBangla ? 'অনুমোদিত' : 'Approved' }}
                                                    </span>
                                                @elseif($withdraw->status === 'rejected')
                                                    <span class="status-badge status-rejected">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        {{ $isBangla ? 'বাতিল' : 'Rejected' }}
                                                    </span>
                                                @else
                                                    <span class="status-badge status-pending">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $isBangla ? 'পেন্ডিং' : 'Pending' }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar-alt me-1" style="color: #999;"></i>
                                                {{ $withdraw->created_at->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <h5 class="empty-title">
                                {{ $isBangla ? 'কোনো উইথড্র পাওয়া যায়নি' : 'No Withdraws Found' }}
                            </h5>
                            <p class="empty-text">
                                {{ $isBangla ? 'আপনি এখনও কোনো উইথড্র করেননি' : 'You haven\'t made any withdraws yet' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('withdrawSearch');
    const table = document.getElementById('withdrawTable');

    if (searchInput && table) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                const wallet = row.cells[1].textContent.toLowerCase();
                const account = row.cells[2].textContent.toLowerCase();

                if (wallet.includes(searchTerm) || account.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>

@endsection
