@extends('frontend.master')

@section('content')

@php
    // Fetch active theme colors from database
    $activeTheme = \App\Models\ThemeSetting::where('status', 1)->first();
    $primaryColor = $activeTheme->primary_color ?? '';
    $secondaryColor = $activeTheme->secondary_color ?? '';
@endphp

@include('frontend.dashboard.usersection')

<div class="container mt-4">
    <div class="row">

        {{-- Sidebar --}}
        @include('frontend.dashboard.sidebar')

        {{-- Content --}}
        <div class="col-lg-9 col-md-12">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="background: linear-gradient(135deg, {{ $primaryColor }}15 0%, {{ $secondaryColor }}15 100%); padding: 20px; border-radius: 12px; border: 2px solid {{ $primaryColor }}; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <h3 class="mb-2" style="margin-top: 20px; color: {{ $secondaryColor }}; font-weight: bold; font-size: 1.8em;">
                    <i class="fas fa-ticket-alt" style="color: {{ $primaryColor }};"></i> My  Tickets
                </h3>

                <div class="w-100 w-md-auto mb-2 mb-md-0" style="margin-top: 10px;">
                    <input
                        type="text"
                        id="ticketSearch"
                        class="form-control search-input"
                        placeholder="🔍 Search ticket number..."
                        style="border: 2px solid {{ $primaryColor }}; border-radius: 8px; padding: 12px 20px; font-size: 1em; background-color: white; color: {{ $secondaryColor }}; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                </div>
            </div>

            {{-- Table --}}
            <div style="overflow-x: auto; background: linear-gradient(135deg, {{ $primaryColor }}10 0%, {{ $secondaryColor }}10 100%); border-radius: 15px; padding: 25px; border: 2px solid {{ $primaryColor }}; box-shadow: 0 6px 20px rgba(0,0,0,0.1); margin-top: 20px;">
                <table id="ticketTable" style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
                    <thead>
                        <tr>
                            <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 18px 20px; text-align: left; font-weight: bold; font-size: 1em; border-radius: 8px 0 0 8px; white-space: nowrap;">
                                <i class="fas fa-hashtag"></i> Ticket No
                            </th>
                            <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 18px 20px; text-align: left; font-weight: bold; font-size: 1em; white-space: nowrap;">
                                <i class="fas fa-box"></i> Ticket Name
                            </th>
                            <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 18px 20px; text-align: left; font-weight: bold; font-size: 1em; white-space: nowrap;">
                                <i class="fas fa-money-bill-wave"></i> Price
                            </th>
                            <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 18px 20px; text-align: left; font-weight: bold; font-size: 1em; white-space: nowrap;">
                                <i class="fas fa-info-circle"></i> Status
                            </th>
                            <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 18px 20px; text-align: left; font-weight: bold; font-size: 1em; white-space: nowrap;">
                                <i class="fas fa-trophy"></i> Win Amount
                            </th>
                            <th style="background-color: {{ $primaryColor }}; color: {{ $secondaryColor }}; padding: 18px 20px; text-align: left; font-weight: bold; font-size: 1em; border-radius: 0 8px 8px 0; white-space: nowrap;">
                                <i class="fas fa-calendar-alt"></i> Draw Date
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tickets as $ticket)
                            @php
                                $result = $ticket->results->first();
                            @endphp

                            <tr class="table-row" style="background-color: {{ $secondaryColor }}05; transition: all 0.3s ease; cursor: pointer;">
                                <td style="padding: 18px 20px; color: {{ $primaryColor }}; font-weight: bold; font-size: 1.1em; border-left: 4px solid {{ $primaryColor }}; border-radius: 8px 0 0 8px; white-space: nowrap; vertical-align: middle;">
                                    <i class="fas fa-ticket-alt" style="margin-right: 8px;"></i>
                                    {{ $ticket->ticket_number }}
                                </td>

                                <td style="padding: 18px 20px; color: {{ $secondaryColor }}; font-weight: 600; white-space: nowrap; vertical-align: middle;">
                                    {{ $ticket->package->name ?? 'N/A' }}
                                </td>

                                <td style="padding: 18px 20px; color: {{ $primaryColor }}; font-weight: bold; font-size: 1.05em; white-space: nowrap; vertical-align: middle;">
                                    {{ number_format($ticket->price, 2) }} টাকা
                                </td>

                                <td style="padding: 18px 20px; white-space: nowrap; vertical-align: middle;">
                                    @if ($result)
                                        @if ($result->win_status === 'won')
                                            <span style="background-color: #28a745; color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.9em; font-weight: 600; display: inline-block;">
                                                <i class="fas fa-check-circle"></i> Won
                                            </span>
                                        @else
                                            <span style="background-color: #dc3545; color: white; padding: 8px 16px; border-radius: 20px; font-size: 0.9em; font-weight: 600; display: inline-block;">
                                                <i class="fas fa-times-circle"></i> Lost
                                            </span>
                                        @endif
                                    @else
                                        <span style="background-color: #ffc107; color: {{ $secondaryColor }}; padding: 8px 16px; border-radius: 20px; font-size: 0.9em; font-weight: 600; display: inline-block;">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @endif
                                </td>

                                <td style="padding: 18px 20px; color: {{ $result && $result->win_status === 'won' ? '#28a745' : $secondaryColor }}; font-weight: bold; font-size: 1.1em; white-space: nowrap; vertical-align: middle;">
                                    @if($result && $result->win_amount > 0)
                                        <i class="fas fa-trophy" style="color: #ffc107; margin-right: 5px;"></i>
                                    @endif
                                    {{ $result->win_amount ?? 0 }} টাকা
                                </td>

                                <td style="padding: 18px 20px; color: {{ $secondaryColor }}; font-weight: 500; border-radius: 0 8px 8px 0; white-space: nowrap; vertical-align: middle;">
                                    <i class="fas fa-calendar-day" style="color: {{ $primaryColor }}; margin-right: 5px;"></i>
                                    {{ $result && $result->draw_date ? $result->draw_date->format('d M Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 50px; color: {{ $secondaryColor }}; font-size: 1.2em; background-color: {{ $primaryColor }}10; border-radius: 12px;">
                                    <i class="fas fa-inbox" style="font-size: 3em; color: {{ $primaryColor }}; opacity: 0.3; display: block; margin-bottom: 20px;"></i>
                                    <strong>No tickets purchased yet.</strong>
                                    <p style="margin-top: 10px; font-size: 0.9em; color: {{ $secondaryColor }}; opacity: 0.7;">
                                        Start buying lottery tickets to see them here!
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Statistics Section --}}
            @if($tickets->count() > 0)
                <div class="row mt-4 g-3">
                    <div class="col-md-4">
                        <div class="stat-card" style="background: linear-gradient(135deg, {{ $primaryColor }}20 0%, {{ $primaryColor }}40 100%); border: 2px solid {{ $primaryColor }}; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                            <i class="fas fa-ticket-alt" style="font-size: 2.5em; color: {{ $primaryColor }}; margin-bottom: 10px;"></i>
                            <h4 style="color: {{ $secondaryColor }}; font-weight: bold; margin-bottom: 5px;">
                                {{ $tickets->count() }}
                            </h4>
                            <p style="color: {{ $secondaryColor }}; opacity: 0.8; margin: 0;">Total Tickets</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="stat-card" style="background: linear-gradient(135deg, #28a74520 0%, #28a74540 100%); border: 2px solid #28a745; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                            <i class="fas fa-trophy" style="font-size: 2.5em; color: #28a745; margin-bottom: 10px;"></i>
                            <h4 style="color: {{ $secondaryColor }}; font-weight: bold; margin-bottom: 5px;">
                                {{ $tickets->filter(function($t) { return $t->results->first() && $t->results->first()->win_status === 'won'; })->count() }}
                            </h4>
                            <p style="color: {{ $secondaryColor }}; opacity: 0.8; margin: 0;">Won Tickets</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="stat-card" style="background: linear-gradient(135deg, #ffc10720 0%, #ffc10740 100%); border: 2px solid #ffc107; border-radius: 12px; padding: 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                            <i class="fas fa-clock" style="font-size: 2.5em; color: #ffc107; margin-bottom: 10px;"></i>
                            <h4 style="color: {{ $secondaryColor }}; font-weight: bold; margin-bottom: 5px;">
                                {{ $tickets->filter(function($t) { return !$t->results->first(); })->count() }}
                            </h4>
                            <p style="color: {{ $secondaryColor }}; opacity: 0.8; margin: 0;">Pending Results</p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    const primaryColor = '{{ $primaryColor }}';
    const secondaryColor = '{{ $secondaryColor }}';

    // ============================================
    // SEARCH FUNCTIONALITY
    // ============================================
    const searchInput = document.getElementById('ticketSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#ticketTable tbody tr');

            rows.forEach(row => {
                const ticketNo = row.cells[0]?.textContent.toLowerCase() || '';
                const packageName = row.cells[1]?.textContent.toLowerCase() || '';

                if (ticketNo.includes(filter) || packageName.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Search input focus effects
        searchInput.addEventListener('focus', function() {
            this.style.borderColor = primaryColor;
            this.style.boxShadow = `0 0 0 3px ${primaryColor}30`;
            this.style.transform = 'scale(1.02)';
        });

        searchInput.addEventListener('blur', function() {
            this.style.borderColor = primaryColor;
            this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
            this.style.transform = 'scale(1)';
        });
    }

    // ============================================
    // TABLE ROW HOVER EFFECTS
    // ============================================
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = primaryColor + '20';
            this.style.transform = 'scale(1.01)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        });

        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = secondaryColor + '05';
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });

    // ============================================
    // STAT CARDS HOVER EFFECTS
    // ============================================
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.2)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        });
    });

    // ============================================
    // RESPONSIVE TABLE
    // ============================================
    function makeTableResponsive() {
        const table = document.getElementById('ticketTable');
        if (!table) return;

        if (window.innerWidth < 768) {
            // Mobile view adjustments
            const headers = table.querySelectorAll('th');
            const cells = table.querySelectorAll('td');

            headers.forEach(header => {
                header.style.fontSize = '0.85em';
                header.style.padding = '12px 10px';
            });

            cells.forEach(cell => {
                cell.style.fontSize = '0.85em';
                cell.style.padding = '12px 10px';
            });
        }
    }

    // Run on load and resize
    makeTableResponsive();
    window.addEventListener('resize', makeTableResponsive);

    // ============================================
    // INITIALIZE
    // ============================================
    console.log('🎟️ Lottery Tickets Page Initialized');
    console.log('Theme Colors:', { primary: primaryColor, secondary: secondaryColor });
})();
</script>

@endsection
