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
            'page_title' => 'My Tickets',
            'page_subtitle' => 'Track all your lottery tickets and winnings',
            'search_placeholder' => 'Search by ticket number or package name...',
            'ticket_no' => 'Ticket No',
            'package' => 'Package',
            'price' => 'Price',
            'status' => 'Status',
            'winnings' => 'Winnings',
            'draw_date' => 'Draw Date',
            'won' => 'Won',
            'lost' => 'Lost',
            'pending' => 'Pending',
            'total_tickets' => 'Total Tickets',
            'won_tickets' => 'Won Tickets',
            'pending_results' => 'Pending Results',
            'total_winnings' => 'Total Winnings',
            'no_tickets_title' => 'No Tickets Found',
            'no_tickets_desc' => 'You haven\'t purchased any lottery tickets yet. Start playing to see your tickets here!',
            'buy_first_ticket' => 'Buy Your First Ticket',
            'search_no_results' => 'No Tickets Found',
            'search_adjust' => 'Try adjusting your search criteria',
            'found_results' => 'Found',
            'tickets' => 'tickets',
            'ticket' => 'ticket',
            'currency' => 'Taka',
            'n_a' => 'N/A',
        ],
        'bn' => [
            'page_title' => 'আমার টিকিট',
            'page_subtitle' => 'আপনার সকল লটারি টিকিট এবং জয়ের পরিমাণ ট্র্যাক করুন',
            'search_placeholder' => 'টিকিট নম্বর বা প্যাকেজের নাম দিয়ে খুঁজুন...',
            'ticket_no' => 'টিকিট নং',
            'package' => 'প্যাকেজ',
            'price' => 'মূল্য',
            'status' => 'অবস্থা',
            'winnings' => 'জয়ের পরিমাণ',
            'draw_date' => 'ড্র তারিখ',
            'won' => 'জিতেছে',
            'lost' => 'হেরেছে',
            'pending' => 'অপেক্ষমাণ',
            'total_tickets' => 'মোট টিকিট',
            'won_tickets' => 'জিতেছে',
            'pending_results' => 'ফলাফল অপেক্ষমাণ',
            'total_winnings' => 'মোট জয়',
            'no_tickets_title' => 'কোন টিকিট পাওয়া যায়নি',
            'no_tickets_desc' => 'আপনি এখনও কোন লটারি টিকিট কিনেননি। এখানে আপনার টিকিট দেখতে খেলা শুরু করুন!',
            'buy_first_ticket' => 'আপনার প্রথম টিকিট কিনুন',
            'search_no_results' => 'কোন টিকিট পাওয়া যায়নি',
            'search_adjust' => 'আপনার অনুসন্ধান মানদণ্ড সামঞ্জস্য করার চেষ্টা করুন',
            'found_results' => 'পাওয়া গেছে',
            'tickets' => 'টিকিট',
            'ticket' => 'টিকিট',
            'currency' => 'টাকা',
            'n_a' => 'প্রযোজ্য নয়',
        ],
    ];

    $lang = $translations[$isBangla ? 'bn' : 'en'];

    // ============================================
    // TICKET STATISTICS
    // ============================================
    $totalTickets = $tickets->count();
    $wonTickets = $tickets->filter(fn($t) => optional($t->results->first())->win_status === 'won')->count();
    $lostTickets = $tickets->filter(fn($t) => optional($t->results->first())->win_status === 'lost')->count();
    $pendingTickets = $tickets->filter(fn($t) => !$t->results->first())->count();
    $totalWinnings = $tickets->sum(fn($t) => optional($t->results->first())->win_amount ?? 0);

    // ============================================
    // NUMBER FORMATTING FUNCTION
    // ============================================
    function formatNumber($number, $isBangla) {
        $number = is_numeric($number) ? (float)$number : 0;
        if ($isBangla) {
            $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
            return str_replace($englishDigits, $banglaDigits, number_format($number, 2));
        }
        return number_format($number, 2);
    }

    // ============================================
    // DATE FORMATTING FUNCTION
    // ============================================
    function formatDate($date, $isBangla) {
        if (!$date) return '-';

        try {
            $dateObj = is_string($date) ? new \DateTime($date) : $date;

            if ($isBangla) {
                $englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $banglaMonths = ['জানু', 'ফেব', 'মার্চ', 'এপ্রি', 'মে', 'জুন', 'জুলা', 'আগ', 'সেপ', 'অক্ট', 'নভে', 'ডিসে'];
                $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                $banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

                $formatted = $dateObj->format('d M Y');
                $formatted = str_replace($englishMonths, $banglaMonths, $formatted);
                $formatted = str_replace($englishDigits, $banglaDigits, $formatted);
                return $formatted;
            }

            return $dateObj->format('d M Y');
        } catch (\Exception $e) {
            return '-';
        }
    }

    // ============================================
    // SAFE STRING CONVERSION
    // ============================================
    function safeString($value, $default = '') {
        if (is_array($value) || is_object($value)) {
            return $default;
        }
        return (string)$value;
    }
@endphp

@include('frontend.dashboard.usersection')

<div class="container px-3 mt-4">
    <div class="row">
        @include('frontend.dashboard.sidebar')

        {{-- MAIN CONTENT --}}
        <div class="col-lg-9 col-md-8">

            {{-- ==================== HEADER SECTION ==================== --}}
            <header class="page-header">
                <div class="header-content">
                    <h1 class="page-title">
                        <i class="fas fa-ticket-alt"></i>
                        <span>{{ $lang['page_title'] }}</span>
                    </h1>
                    <p class="page-subtitle">{{ $lang['page_subtitle'] }}</p>
                </div>

                <div class="search-container">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input
                            type="text"
                            id="ticketSearch"
                            class="search-input"
                            placeholder="{{ $lang['search_placeholder'] }}"
                            autocomplete="off"
                            aria-label="{{ $lang['search_placeholder'] }}">
                        <button class="search-clear" id="clearSearch" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="search-results-count" id="searchCount" style="display: none;"></div>
                </div>
            </header>

            {{-- ==================== STATISTICS CARDS ==================== --}}
            @if($totalTickets > 0)
                <section class="stats-section" aria-label="{{ $lang['page_title'] }}">
                    <div class="stats-grid">
                        {{-- Total Tickets --}}
                        <article class="stat-card stat-card-primary">
                            <div class="stat-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-value" data-count="{{ $totalTickets }}" data-bangla="{{ $isBangla ? 'true' : 'false' }}">{{ $isBangla ? '০' : '0' }}</h3>
                                <p class="stat-label">{{ $lang['total_tickets'] }}</p>
                            </div>
                            <div class="stat-decoration"></div>
                        </article>

                        {{-- Won Tickets --}}
                        <article class="stat-card stat-card-success">
                            <div class="stat-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-value" data-count="{{ $wonTickets }}" data-bangla="{{ $isBangla ? 'true' : 'false' }}">{{ $isBangla ? '০' : '0' }}</h3>
                                <p class="stat-label">{{ $lang['won_tickets'] }}</p>
                            </div>
                            <div class="stat-decoration"></div>
                        </article>

                        {{-- Pending Tickets --}}
                        <article class="stat-card stat-card-warning">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-value" data-count="{{ $pendingTickets }}" data-bangla="{{ $isBangla ? 'true' : 'false' }}">{{ $isBangla ? '০' : '0' }}</h3>
                                <p class="stat-label">{{ $lang['pending_results'] }}</p>
                            </div>
                            <div class="stat-decoration"></div>
                        </article>

                        {{-- Total Winnings --}}
                        <article class="stat-card stat-card-gold">
                            <div class="stat-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-value" data-count="{{ $totalWinnings }}" data-bangla="{{ $isBangla ? 'true' : 'false' }}">{{ $isBangla ? '০' : '0' }}</h3>
                                <p class="stat-label">{{ $lang['total_winnings'] }}</p>
                            </div>
                            <div class="stat-decoration"></div>
                        </article>
                    </div>
                </section>
            @endif

            {{-- ==================== TICKETS TABLE ==================== --}}
            <section class="tickets-section" aria-label="{{ $lang['page_title'] }}">
                <div class="table-container">
                    <div class="table-wrapper">
                        <table class="tickets-table" id="ticketsTable">
                            <thead>
                                <tr>
                                    <th class="sortable" data-sort="ticket">
                                        <span class="th-content">
                                            <i class="fas fa-hashtag"></i>
                                            {{ $lang['ticket_no'] }}
                                            <i class="fas fa-sort sort-icon"></i>
                                        </span>
                                    </th>
                                    <th class="sortable" data-sort="package">
                                        <span class="th-content">
                                            <i class="fas fa-box"></i>
                                            {{ $lang['package'] }}
                                            <i class="fas fa-sort sort-icon"></i>
                                        </span>
                                    </th>
                                    <th class="sortable" data-sort="price">
                                        <span class="th-content">
                                            <i class="fas fa-money-bill-wave"></i>
                                            {{ $lang['price'] }}
                                            <i class="fas fa-sort sort-icon"></i>
                                        </span>
                                    </th>
                                    <th class="sortable" data-sort="status">
                                        <span class="th-content">
                                            <i class="fas fa-info-circle"></i>
                                            {{ $lang['status'] }}
                                            <i class="fas fa-sort sort-icon"></i>
                                        </span>
                                    </th>
                                    <th class="sortable" data-sort="winnings">
                                        <span class="th-content">
                                            <i class="fas fa-trophy"></i>
                                            {{ $lang['winnings'] }}
                                            <i class="fas fa-sort sort-icon"></i>
                                        </span>
                                    </th>
                                    <th class="sortable" data-sort="date">
                                        <span class="th-content">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $lang['draw_date'] }}
                                            <i class="fas fa-sort sort-icon"></i>
                                        </span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($tickets as $ticket)
                                    @php
                                        $result = $ticket->results->first();
                                        $status = $result ? safeString($result->win_status, 'pending') : 'pending';
                                        $statusClass = match($status) {
                                            'won' => 'status-won',
                                            'lost' => 'status-lost',
                                            default => 'status-pending'
                                        };

                                        $ticketNumber = safeString($ticket->ticket_number, 'N/A');
                                        $packageName = isset($ticket->package->name) ? safeString($ticket->package->name) : $lang['n_a'];
                                        $ticketPrice = is_numeric($ticket->price) ? (float)$ticket->price : 0;
                                        $winAmount = $result && is_numeric($result->win_amount) ? (float)$result->win_amount : 0;
                                        $drawDate = $result && isset($result->draw_date) ? $result->draw_date : null;
                                        $drawTimestamp = $drawDate ? (is_object($drawDate) && method_exists($drawDate, 'getTimestamp') ? $drawDate->getTimestamp() : 0) : 0;
                                    @endphp

                                    <tr class="ticket-row {{ $statusClass }}"
                                        data-ticket="{{ $ticketNumber }}"
                                        data-package="{{ $packageName }}"
                                        data-price="{{ $ticketPrice }}"
                                        data-status="{{ $status }}"
                                        data-winnings="{{ $winAmount }}"
                                        data-date="{{ $drawTimestamp }}">

                                        {{-- Ticket Number --}}
                                        <td class="td-ticket">
                                            <div class="ticket-number">
                                                <i class="fas fa-ticket-alt"></i>
                                                <span>{{ $ticketNumber }}</span>
                                            </div>
                                        </td>

                                        {{-- Package Name --}}
                                        <td class="td-package">
                                            <span class="package-name">{{ $packageName }}</span>
                                        </td>

                                        {{-- Price --}}
                                        <td class="td-price">
                                            <span class="price-value">{{ formatNumber($ticketPrice, $isBangla) }} {{ $lang['currency'] }}</span>
                                        </td>

                                        {{-- Status --}}
                                        <td class="td-status">
                                            @if ($result)
                                                @if ($status === 'won')
                                                    <span class="status-badge badge-won">
                                                        <i class="fas fa-check-circle"></i>
                                                        {{ $lang['won'] }}
                                                    </span>
                                                @else
                                                    <span class="status-badge badge-lost">
                                                        <i class="fas fa-times-circle"></i>
                                                        {{ $lang['lost'] }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="status-badge badge-pending">
                                                    <i class="fas fa-clock"></i>
                                                    {{ $lang['pending'] }}
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Win Amount --}}
                                        <td class="td-winnings">
                                            <div class="winnings-amount {{ $winAmount > 0 ? 'has-winnings' : '' }}">
                                                @if($winAmount > 0)
                                                    <i class="fas fa-trophy"></i>
                                                @endif
                                                <span>{{ formatNumber($winAmount, $isBangla) }} {{ $lang['currency'] }}</span>
                                            </div>
                                        </td>

                                        {{-- Draw Date --}}
                                        <td class="td-date">
                                            <div class="draw-date">
                                                <i class="fas fa-calendar-day"></i>
                                                <span>{{ formatDate($drawDate, $isBangla) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-row">
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="fas fa-inbox"></i>
                                                </div>
                                                <h3 class="empty-title">{{ $lang['no_tickets_title'] }}</h3>
                                                <p class="empty-description">{{ $lang['no_tickets_desc'] }}</p>
                                                <a href="#" class="empty-action">
                                                    <i class="fas fa-plus-circle"></i>
                                                    {{ $lang['buy_first_ticket'] }}
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- No Results Message --}}
                    <div class="no-results" id="noResults" style="display: none;">
                        <div class="no-results-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="no-results-title">{{ $lang['search_no_results'] }}</h3>
                        <p class="no-results-text">{{ $lang['search_adjust'] }}</p>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

{{-- ============================================
     Part 2: Complete Styles & JavaScript
     Part 1 এর পরে এই কোডটি যোগ করুন
============================================ --}}

<style>
:root {
    --primary: {{ $primaryColor }};
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --gold: #ffd700;
    --white: #ffffff;
    --light-bg: #f8f9fa;
    --text-dark: #2c3e50;
    --text-muted: #6c757d;
    --border-color: #dee2e6;
    --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.08);
    --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.12);
    --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
    --radius: 12px;
    --radius-sm: 8px;
    --radius-lg: 16px;
    --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ==================== PAGE HEADER ==================== */
.page-header {
    background: linear-gradient(135deg, #30cfd0 0%, #086755 100%);
    border: 2px solid #30cfd0;
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-md);
}

.header-content {
    margin-bottom: 20px;
}

.page-title {
    color: var(--white);
    font-size: clamp(1.5rem, 4vw, 2rem);
    font-weight: 700;
    margin: 0 0 8px;
    display: flex;
    align-items: center;
    gap: 12px;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

.page-title i {
    color: var(--white);
    font-size: 0.9em;
}

.page-subtitle {
    color: var(--white);
    font-size: 0.95rem;
    margin: 0;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

/* ==================== SEARCH ==================== */
.search-container {
    margin-top: 16px;
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 16px;
    color: var(--primary);
    font-size: 1rem;
    pointer-events: none;
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: 14px 48px 14px 48px;
    border: 2px solid var(--white);
    border-radius: var(--radius);
    font-size: 1rem;
    color: var(--text-dark);
    background: var(--white);
    transition: all var(--transition);
    outline: none;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

.search-input:focus {
    border-color: var(--white);
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
}

.search-input::placeholder {
    color: var(--text-muted);
}

.search-clear {
    position: absolute;
    right: 12px;
    background: var(--danger);
    color: var(--white);
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition);
    z-index: 2;
}

.search-clear:hover {
    background: #c82333;
    transform: scale(1.1);
}

.search-results-count {
    margin-top: 8px;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-sm);
    color: var(--white);
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

/* ==================== STATISTICS CARDS ==================== */
.stats-section {
    margin-bottom: 24px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
}

.stat-card {
    position: relative;
    padding: 24px;
    border-radius: var(--radius);
    background: var(--white);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    transition: all var(--transition);
    display: flex;
    align-items: center;
    gap: 16px;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary);
    transition: height var(--transition);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-card:hover::before {
    height: 100%;
    opacity: 0.05;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}

.stat-card-primary .stat-icon {
    background: var(--primary);
    color: var(--white);
}

.stat-card-success .stat-icon {
    background: var(--success);
    color: var(--white);
}

.stat-card-warning .stat-icon {
    background: var(--warning);
    color: var(--white);
}

.stat-card-gold .stat-icon {
    background: var(--gold);
    color: var(--white);
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0 0 4px;
    line-height: 1;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin: 0;
    font-weight: 500;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

.stat-decoration {
    position: absolute;
    top: -20px;
    right: -20px;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0, 0, 0, 0.05), transparent 70%);
    pointer-events: none;
}

/* ==================== TICKETS TABLE ==================== */
.tickets-section {
    margin-bottom: 24px;
}

.table-container {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}

.table-wrapper {
    overflow-x: auto;
    max-height: 600px;
    overflow-y: auto;
}

.tickets-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.tickets-table thead {
    position: sticky;
    top: 0;
    z-index: 10;
    background: var(--primary);
}

.tickets-table th {
    padding: 16px 20px;
    text-align: left;
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--white);
    white-space: nowrap;
    user-select: none;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

.th-content {
    display: flex;
    align-items: center;
    gap: 8px;
}

.sortable {
    cursor: pointer;
    transition: background var(--transition);
}

.sortable:hover {
    background: rgba(255, 255, 255, 0.1);
}

.sort-icon {
    opacity: 0.5;
    font-size: 0.8rem;
    transition: all var(--transition);
}

.sortable:hover .sort-icon {
    opacity: 1;
}

.sortable.asc .sort-icon::before {
    content: '\f0de';
    opacity: 1;
}

.sortable.desc .sort-icon::before {
    content: '\f0dd';
    opacity: 1;
}

.tickets-table tbody tr {
    background: var(--white);
    border-bottom: 1px solid var(--border-color);
    transition: all var(--transition);
}

.ticket-row {
    cursor: pointer;
}

.ticket-row:hover {
    background: rgba(102, 126, 234, 0.05);
    transform: scale(1.01);
    box-shadow: var(--shadow-sm);
}

.tickets-table td {
    padding: 16px 20px;
    font-size: 0.95rem;
    color: var(--text-dark);
    vertical-align: middle;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

/* ==================== TABLE CELLS ==================== */
.ticket-number {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: var(--primary);
}

.ticket-number i {
    color: var(--primary);
}

.package-name {
    font-weight: 500;
}

.price-value {
    font-weight: 600;
    color: var(--success);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    font-weight: 600;
    white-space: nowrap;
}

.badge-won {
    background: rgba(40, 167, 69, 0.15);
    color: var(--success);
}

.badge-lost {
    background: rgba(220, 53, 69, 0.15);
    color: var(--danger);
}

.badge-pending {
    background: rgba(255, 193, 7, 0.15);
    color: #856404;
}

.winnings-amount {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--text-muted);
}

.winnings-amount.has-winnings {
    color: var(--gold);
    font-weight: 600;
}

.winnings-amount.has-winnings i {
    color: var(--gold);
}

.draw-date {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-muted);
}

.draw-date i {
    color: var(--primary);
}

/* ==================== EMPTY STATES ==================== */
.empty-state,
.no-results {
    text-align: center;
    padding: 60px 24px;
}

.empty-icon,
.no-results-icon {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-title,
.no-results-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0 0 12px;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

.empty-description,
.no-results-text {
    font-size: 1rem;
    color: var(--text-muted);
    margin: 0 0 24px;
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

.empty-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: var(--primary);
    color: var(--white);
    text-decoration: none;
    border-radius: var(--radius);
    font-weight: 600;
    transition: all var(--transition);
    @if($isBangla)
        font-family: "Kalpurush", "SolaimanLipi", sans-serif;
    @endif
}

.empty-action:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: var(--white);
}

/* ==================== STATUS ROW HIGHLIGHTS ==================== */
.status-won {
    border-left: 4px solid var(--success);
}

.status-lost {
    border-left: 4px solid var(--danger);
}

.status-pending {
    border-left: 4px solid var(--warning);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .page-header {
        padding: 20px;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 20px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
    }

    .table-wrapper {
        max-height: 500px;
    }

    .tickets-table th,
    .tickets-table td {
        padding: 12px 16px;
        font-size: 0.85rem;
    }

    .th-content {
        gap: 6px;
    }

    .empty-state,
    .no-results {
        padding: 40px 20px;
    }
}

@media (max-width: 576px) {
    .search-input {
        padding: 12px 40px 12px 40px;
        font-size: 0.9rem;
    }

    .stat-value {
        font-size: 1.25rem;
    }

    .stat-label {
        font-size: 0.8rem;
    }

    .tickets-table {
        font-size: 0.8rem;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }
}

/* ==================== ANIMATIONS ==================== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.stat-card {
    animation: fadeIn 0.5s ease-out;
}

.ticket-row {
    animation: slideIn 0.3s ease-out;
}

.stat-card:hover .stat-icon {
    animation: pulse 1s infinite;
}

/* ==================== SCROLLBAR ==================== */
.table-wrapper::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.table-wrapper::-webkit-scrollbar-track {
    background: var(--light-bg);
    border-radius: var(--radius-sm);
}

.table-wrapper::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: var(--radius-sm);
}

.table-wrapper::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}

/* ==================== TOOLTIPS ==================== */
.custom-tooltip {
    position: fixed;
    background: var(--text-dark);
    color: var(--white);
    padding: 6px 12px;
    border-radius: var(--radius-sm);
    font-size: 0.85rem;
    pointer-events: none;
    z-index: 1000;
    white-space: nowrap;
}

/* ==================== PRINT STYLES ==================== */
@media print {
    .page-header,
    .search-container,
    .stat-card:hover,
    .ticket-row:hover {
        box-shadow: none;
        transform: none;
    }

    .table-wrapper {
        max-height: none;
        overflow: visible;
    }

    .tickets-table thead {
        position: static;
    }
}
</style>

{{-- ============================================
     JAVASCRIPT
============================================ --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // ============================================
    // CONFIGURATION
    // ============================================
    const isBangla = {{ $isBangla ? 'true' : 'false' }};
    const lang = {
        foundResults: '{{ $lang["found_results"] }}',
        tickets: '{{ $lang["tickets"] }}',
        ticket: '{{ $lang["ticket"] }}'
    };

    // ============================================
    // NUMBER CONVERSION (BANGLA)
    // ============================================
    function toBanglaNumber(num) {
        if (!isBangla) return num.toString();
        const banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return num.toString().split('').map(digit => {
            return /\d/.test(digit) ? banglaDigits[parseInt(digit)] : digit;
        }).join('');
    }

    // ============================================
    // COUNTER ANIMATION
    // ============================================
    function animateCounter(element, target, duration = 1000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        const isBanglaNum = element.dataset.bangla === 'true';

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }

            const displayValue = Math.floor(current);
            element.textContent = isBanglaNum ? toBanglaNumber(displayValue) : displayValue.toLocaleString();
        }, 16);
    }

    // Initialize counters
    document.querySelectorAll('.stat-value[data-count]').forEach(el => {
        const target = parseFloat(el.dataset.count);
        animateCounter(el, target);
    });

    // ============================================
    // SEARCH FUNCTIONALITY
    // ============================================
    const searchInput = document.getElementById('ticketSearch');
    const clearBtn = document.getElementById('clearSearch');
    const searchCount = document.getElementById('searchCount');
    const tableBody = document.querySelector('#ticketsTable tbody');
    const noResults = document.getElementById('noResults');
    const tableWrapper = document.querySelector('.table-wrapper');

    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const rows = tableBody.querySelectorAll('.ticket-row');
            let visibleCount = 0;

            if (query === '') {
                rows.forEach(row => {
                    row.style.display = '';
                });
                clearBtn.style.display = 'none';
                searchCount.style.display = 'none';
                noResults.style.display = 'none';
                tableWrapper.style.display = '';
            } else {
                rows.forEach(row => {
                    const ticket = (row.dataset.ticket || '').toLowerCase();
                    const packageName = (row.dataset.package || '').toLowerCase();

                    if (ticket.includes(query) || packageName.includes(query)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                clearBtn.style.display = 'flex';

                if (visibleCount > 0) {
                    const countText = `${lang.foundResults} ${isBangla ? toBanglaNumber(visibleCount) : visibleCount} ${visibleCount === 1 ? lang.ticket : lang.tickets}`;
                    searchCount.textContent = countText;
                    searchCount.style.display = 'block';
                    noResults.style.display = 'none';
                    tableWrapper.style.display = '';
                } else {
                    searchCount.style.display = 'none';
                    noResults.style.display = 'block';
                    tableWrapper.style.display = 'none';
                }
            }
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
                searchInput.focus();
            });
        }
    }

    // ============================================
    // TABLE SORTING
    // ============================================
    const sortables = document.querySelectorAll('.sortable');
    let currentSort = { column: null, direction: 'asc' };

    sortables.forEach(th => {
        th.addEventListener('click', function() {
            const sortType = this.dataset.sort;
            const tbody = this.closest('table').querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('.ticket-row'));

            if (currentSort.column === sortType) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.direction = 'asc';
            }
            currentSort.column = sortType;

            sortables.forEach(s => {
                s.classList.remove('asc', 'desc');
            });

            this.classList.add(currentSort.direction);

            rows.sort((a, b) => {
                let aVal, bVal;

                switch(sortType) {
                    case 'ticket':
                        aVal = a.dataset.ticket || '';
                        bVal = b.dataset.ticket || '';
                        break;
                    case 'package':
                        aVal = a.dataset.package || '';
                        bVal = b.dataset.package || '';
                        break;
                    case 'price':
                    case 'winnings':
                        aVal = parseFloat(a.dataset[sortType]) || 0;
                        bVal = parseFloat(b.dataset[sortType]) || 0;
                        break;
                    case 'status':
                        const statusOrder = { won: 3, lost: 2, pending: 1 };
                        aVal = statusOrder[a.dataset.status] || 0;
                        bVal = statusOrder[b.dataset.status] || 0;
                        break;
                    case 'date':
                        aVal = parseInt(a.dataset.date) || 0;
                        bVal = parseInt(b.dataset.date) || 0;
                        break;
                    default:
                        return 0;
                }

                if (typeof aVal === 'string') {
                    return currentSort.direction === 'asc'
                        ? aVal.localeCompare(bVal)
                        : bVal.localeCompare(aVal);
                } else {
                    return currentSort.direction === 'asc'
                        ? aVal - bVal
                        : bVal - aVal;
                }
            });

            rows.forEach(row => tbody.appendChild(row));
        });
    });

    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }

        if (e.key === 'Escape' && searchInput === document.activeElement) {
            if (searchInput.value !== '') {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            } else {
                searchInput.blur();
            }
        }
    });

    // ============================================
    // ROW CLICK HANDLER
    // ============================================
    const ticketRows = document.querySelectorAll('.ticket-row');
    ticketRows.forEach(row => {
        row.addEventListener('click', function() {
            const ticketNumber = this.dataset.ticket;
            console.log('Clicked ticket:', ticketNumber);
        });
    });

    // ============================================
    // SMOOTH SCROLL FOR TABLE
    // ============================================
    const tableWrapperScroll = document.querySelector('.table-wrapper');
    if (tableWrapperScroll) {
        tableWrapperScroll.style.scrollBehavior = 'smooth';
    }

    // ============================================
    // TOOLTIPS
    // ============================================
    document.querySelectorAll('[data-tooltip]').forEach(el => {
        el.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = this.dataset.tooltip;
            document.body.appendChild(tooltip);

            const rect = this.getBoundingClientRect();
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
            tooltip.style.left = (rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)) + 'px';

            this._tooltip = tooltip;
        });

        el.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                this._tooltip.remove();
                this._tooltip = null;
            }
        });
    });

    // ============================================
    // INTERSECTION OBSERVER FOR ANIMATIONS
    // ============================================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.stat-card, .ticket-row').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(el);
    });

    // ============================================
    // CONSOLE MESSAGE
    // ============================================
    console.log('%c✨ Lottery Tickets System Ready!', 'color: #667eea; font-size: 16px; font-weight: bold;');
    console.log('%cTotal Tickets: ' + {{ $totalTickets }}, 'color: #28a745;');
    console.log('%cWon Tickets: ' + {{ $wonTickets }}, 'color: #ffc107;');
});
</script>

@endsection
