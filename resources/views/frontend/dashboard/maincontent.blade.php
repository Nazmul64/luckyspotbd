@php
    use Carbon\Carbon;
    date_default_timezone_set('Asia/Dhaka');
    $currentLocale = app()->getLocale();
    $serverNow = Carbon::now('Asia/Dhaka');
    $serverTimestamp = $serverNow->timestamp * 1000;
@endphp

<style>
:root {
    --font: {{ $currentLocale === 'bn' ? '"Kalpurush", sans-serif' : '-apple-system, sans-serif' }};
    --primary: #667eea;
    --primary-dark: #764ba2;
    --card1-start: #f093fb;
    --card1-end: #f5576c;
    --card2-start: #4facfe;
    --card2-end: #00f2fe;
    --card3-start: #43e97b;
    --card3-end: #38f9d7;
    --card4-start: #fa709a;
    --card4-end: #fee140;
    --card5-start: #30cfd0;
    --card5-end: #330867;
    --card6-start: #a8edea;
    --card6-end: #fed6e3;

    --transition-speed: 0.3s;
    --border-radius-sm: 8px;
    --border-radius-md: 12px;
    --border-radius-lg: 16px;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.15);
    --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.2);
}

/* GLOBAL */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: var(--font);
    background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);
}

.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

/* ANIMATIONS */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.05); opacity: 0.8; }
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes float3D {
    0%, 100% { transform: translateY(0px) rotateX(0deg); }
    25% { transform: translateY(-8px) rotateX(2deg); }
    50% { transform: translateY(-10px) rotateX(3deg); }
    75% { transform: translateY(-8px) rotateX(2deg); }
}

.fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.pulse-icon {
    animation: pulse 2s ease-in-out infinite;
}

.blink-icon {
    animation: blink 1s ease-in-out infinite;
}

/* USER TOGGLER */
.user-toggler-wrapper {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}

.user-toggler {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    border: none;
    font-size: 1.2em;
}

.user-toggler:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

@media (min-width: 992px) {
    .d-lg-none { display: none !important; }
}

/* STAT CARDS */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    border-radius: 15px;
    padding: 25px;
    position: relative;
    overflow: hidden;
    transition: all 0.4s;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    background-size: 200% 200%;
    animation: gradient-shift 6s ease infinite;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.5s;
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-card:nth-child(1) {
    background: linear-gradient(135deg, var(--card1-start) 0%, var(--card1-end) 100%);
}

.stat-card:nth-child(2) {
    background: linear-gradient(135deg, var(--card2-start) 0%, var(--card2-end) 100%);
}

.stat-card:nth-child(3) {
    background: linear-gradient(135deg, var(--card3-start) 0%, var(--card3-end) 100%);
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
}

.stat-card-value {
    font-size: 2.2em;
    font-weight: bold;
    color: white;
    margin-bottom: 10px;
    font-family: var(--font);
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.stat-card-label {
    font-size: 1.1em;
    color: rgba(255, 255, 255, 0.95);
    font-family: var(--font);
    font-weight: 600;
}

.stat-card-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 4em;
    color: white;
    opacity: 0.2;
    transition: all 0.3s;
}

.stat-card:hover .stat-card-icon {
    opacity: 0.3;
    transform: translateY(-50%) rotate(10deg) scale(1.1);
}

/* LOTTERY GRID */
.lottery-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 30px;
    margin-bottom: 40px;
    perspective: 1000px;
}

@media (min-width: 768px) {
    .lottery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .lottery-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* COLORFUL LOTTERY CARDS */
.lottery-card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    background-size: 200% 200%;
    transform-style: preserve-3d;
}

/* Different gradient for each card */
.lottery-card:nth-child(6n+1) {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.lottery-card:nth-child(6n+2) {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.lottery-card:nth-child(6n+3) {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.lottery-card:nth-child(6n+4) {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.lottery-card:nth-child(6n+5) {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.lottery-card:nth-child(6n+6) {
    background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
}

.lottery-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 0%, rgba(255, 255, 255, 0.1) 50%, transparent 100%);
    opacity: 0;
    transition: opacity 0.5s;
    pointer-events: none;
}

.lottery-card:hover::after {
    opacity: 1;
}

.lottery-card:hover {
    transform: translateY(-15px) rotateX(5deg) scale(1.02);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
}

.lottery-card.fade-in {
    animation: fadeIn 0.6s ease-out forwards, float3D 4s ease-in-out infinite;
}

.lottery-card-inner {
    padding: 0;
}

.lottery-image {
    width: 100%;
    height: 220px;
    object-fit: cover;
    transition: transform 0.5s;
    border-bottom: 3px solid rgba(255, 255, 255, 0.3);
}

.lottery-card:hover .lottery-image {
    transform: scale(1.1);
}

/* COLORFUL CARD CONTENT */
.lottery-content {
    padding: 25px;
    position: relative;
}

.lottery-card:nth-child(6n+1) .lottery-content {
    background: linear-gradient(to bottom,
        rgba(102, 126, 234, 0.12) 0%,
        rgba(118, 75, 162, 0.18) 100%),
        linear-gradient(to right, #ffffff 0%, #f8f9fa 100%);
}

.lottery-card:nth-child(6n+2) .lottery-content {
    background: linear-gradient(to bottom,
        rgba(240, 147, 251, 0.12) 0%,
        rgba(245, 87, 108, 0.18) 100%),
        linear-gradient(to right, #ffffff 0%, #fff5f7 100%);
}

.lottery-card:nth-child(6n+3) .lottery-content {
    background: linear-gradient(to bottom,
        rgba(79, 172, 254, 0.12) 0%,
        rgba(0, 242, 254, 0.18) 100%),
        linear-gradient(to right, #ffffff 0%, #f0f9ff 100%);
}

.lottery-card:nth-child(6n+4) .lottery-content {
    background: linear-gradient(to bottom,
        rgba(67, 233, 123, 0.12) 0%,
        rgba(56, 249, 215, 0.18) 100%),
        linear-gradient(to right, #ffffff 0%, #f0fdf4 100%);
}

.lottery-card:nth-child(6n+5) .lottery-content {
    background: linear-gradient(to bottom,
        rgba(250, 112, 154, 0.12) 0%,
        rgba(254, 225, 64, 0.18) 100%),
        linear-gradient(to right, #ffffff 0%, #fffbeb 100%);
}

.lottery-card:nth-child(6n+6) .lottery-content {
    background: linear-gradient(to bottom,
        rgba(48, 207, 208, 0.12) 0%,
        rgba(51, 8, 103, 0.18) 100%),
        linear-gradient(to right, #ffffff 0%, #f5f3ff 100%);
}

.lottery-title {
    font-size: 1.5em;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 12px;
    font-family: var(--font);
    line-height: 1.3;
}

.lottery-description {
    font-size: 0.95em;
    color: #6c757d;
    margin-bottom: 15px;
    line-height: 1.6;
    font-family: var(--font);
}

.lottery-badge {
    background: linear-gradient(135deg, var(--card4-start) 0%, var(--card4-end) 100%);
    color: white;
    padding: 8px 18px;
    border-radius: 25px;
    font-size: 0.9em;
    font-weight: 700;
    display: inline-block;
    margin-bottom: 15px;
    font-family: var(--font);
    box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.lottery-price {
    font-size: 2em;
    font-weight: bold;
    background: linear-gradient(135deg, var(--card1-start) 0%, var(--card1-end) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 18px;
    font-family: var(--font);
}

.lottery-info-item {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    font-size: 0.95em;
    color: #2c3e50;
    font-family: var(--font);
    padding: 8px;
    background: rgba(102, 126, 234, 0.05);
    border-radius: 8px;
    transition: all 0.3s;
    font-weight: 600;
}

.lottery-info-item:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateX(5px);
}

.lottery-info-item i {
    color: var(--primary);
    margin-right: 10px;
    font-size: 1.2em;
}

/* PRIZE BOX */
.prize-box {
    background: linear-gradient(135deg, rgba(240, 147, 251, 0.15), rgba(245, 87, 108, 0.15));
    border-left: 5px solid var(--card1-start);
    border-right: 5px solid var(--card1-end);
    padding: 18px;
    border-radius: 12px;
    margin: 18px 0;
    box-shadow: 0 4px 15px rgba(240, 147, 251, 0.2);
}

.prize-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    font-size: 0.95em;
    color: #2c3e50;
    font-family: var(--font);
    padding: 6px;
    transition: all 0.3s;
    font-weight: 600;
}

.prize-item:hover {
    transform: translateX(8px);
}

.prize-item:last-child {
    margin-bottom: 0;
}

.prize-item i {
    background: linear-gradient(135deg, var(--card1-start) 0%, var(--card1-end) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-right: 12px;
    font-size: 1.3em;
}

.prize-label {
    font-weight: 700;
    margin-right: 5px;
    background: linear-gradient(135deg, var(--card1-start) 0%, var(--card1-end) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* PARTICIPANTS BOX */
.participants-box {
    background: linear-gradient(135deg, rgba(79, 172, 254, 0.15), rgba(0, 242, 254, 0.15));
    padding: 15px 18px;
    border-radius: 12px;
    margin: 18px 0;
    display: flex;
    align-items: center;
    font-size: 0.95em;
    font-weight: 700;
    color: #2c3e50;
    border: 3px solid var(--card2-start);
    font-family: var(--font);
    box-shadow: 0 4px 15px rgba(79, 172, 254, 0.2);
    transition: all 0.3s;
}

.participants-box:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 20px rgba(79, 172, 254, 0.3);
}

.participants-box i {
    background: linear-gradient(135deg, var(--card2-start) 0%, var(--card2-end) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-right: 12px;
    font-size: 1.3em;
}

/* GIFT BOX */
.gift-box {
    background: linear-gradient(135deg, rgba(67, 233, 123, 0.15), rgba(56, 249, 215, 0.15));
    border: 3px solid var(--card3-start);
    padding: 18px;
    border-radius: 12px;
    margin-top: 18px;
    box-shadow: 0 4px 15px rgba(67, 233, 123, 0.2);
    transition: all 0.3s;
}

.gift-box:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 20px rgba(67, 233, 123, 0.3);
}

.gift-title {
    font-size: 1.2em;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    font-family: var(--font);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.gift-title i {
    background: linear-gradient(135deg, var(--card3-start) 0%, var(--card3-end) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-right: 12px;
    font-size: 1.4em;
}

.gift-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.gift-item {
    padding-left: 30px;
    position: relative;
    margin-bottom: 10px;
    font-size: 0.95em;
    color: #2c3e50;
    font-family: var(--font);
    padding: 8px 8px 8px 35px;
    background: rgba(67, 233, 123, 0.08);
    border-radius: 8px;
    transition: all 0.3s;
    font-weight: 500;
}

.gift-item:hover {
    background: rgba(67, 233, 123, 0.15);
    transform: translateX(8px);
}

.gift-item i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(135deg, var(--card3-start) 0%, var(--card3-end) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* VIDEO SECTION */
.video-section {
    margin-top: 18px;
}

.video-container {
    border-radius: 15px;
    overflow: hidden;
    border: 4px solid var(--primary);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    background: #000;
    transition: all 0.3s;
}

.video-container:hover {
    transform: scale(1.02);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
}

.video-responsive {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
}

.video-responsive iframe,
.video-responsive video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

.video-live-badge {
    margin-top: 10px;
    text-align: center;
    font-size: 1.1em;
    font-weight: bold;
    color: #ff0000;
    font-family: var(--font);
    animation: blink 1.5s ease-in-out infinite;
}

.video-coming-soon {
    background: linear-gradient(135deg, var(--card5-start) 0%, var(--card5-end) 100%);
    padding: 40px 20px;
    border-radius: 15px;
    text-align: center;
    color: white;
    box-shadow: 0 8px 25px rgba(48, 207, 208, 0.4);
}

.video-coming-soon-icon {
    font-size: 4em;
    margin-bottom: 20px;
    display: block;
    animation: float 3s ease-in-out infinite;
}

.video-coming-soon-title {
    font-size: 1.4em;
    font-weight: bold;
    margin-bottom: 15px;
    font-family: var(--font);
}

.video-countdown-text {
    font-size: 1.2em;
    font-weight: bold;
    margin: 15px 0;
    font-family: var(--font);
}

.video-start-time {
    font-size: 0.9em;
    opacity: 0.95;
    margin-top: 15px;
    font-family: var(--font);
}

/* BUTTON */
.btn {
    display: block;
    padding: 16px 32px;
    border-radius: 12px;
    font-size: 1.05em;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: all 0.4s;
    width: 100%;
    font-family: var(--font);
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn:hover::before {
    width: 300px;
    height: 300px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
    color: white;
}

.btn i {
    margin-right: 10px;
    position: relative;
    z-index: 1;
}

/* EMPTY STATE */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 40px;
    background: linear-gradient(135deg, var(--card3-start) 0%, var(--card3-end) 100%);
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(67, 233, 123, 0.4);
}

.empty-state-icon {
    font-size: 5em;
    color: #fff;
    opacity: 0.9;
    margin-bottom: 25px;
    animation: float 3s ease-in-out infinite;
}

.empty-state-title {
    font-size: 1.6em;
    font-weight: bold;
    color: #fff;
    margin-bottom: 12px;
    font-family: var(--font);
}

.empty-state-text {
    font-size: 1.1em;
    color: rgba(255, 255, 255, 0.95);
    font-family: var(--font);
}

/* PAGINATION */
.pagination-wrapper {
    margin: 50px 0;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    list-style: none;
    gap: 10px;
    padding: 18px 25px;
    background: linear-gradient(to right, #ffffff 0%, #f8f9fa 100%);
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.pagination a,
.pagination span {
    display: inline-block;
    padding: 12px 18px;
    min-width: 50px;
    text-align: center;
    border-radius: 10px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid #e9ecef;
    color: #2c3e50;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s;
    font-family: var(--font);
}

.pagination a:hover {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    border-color: var(--primary);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}

.pagination .active span {
    background: linear-gradient(135deg, var(--card1-start) 0%, var(--card1-end) 100%);
    color: white;
    border-color: var(--card1-start);
    box-shadow: 0 5px 15px rgba(240, 147, 251, 0.3);
}

/* TRANSACTION TABLE */
.transaction-section {
    margin-top: 60px;
}

.transaction-container {
    background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    border: 3px solid var(--primary);
}

.transaction-header {
    font-size: 1.8em;
    font-weight: bold;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-family: var(--font);
}

.table-wrapper {
    overflow-x: auto;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.transaction-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.transaction-table thead {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
}

.transaction-table th {
    padding: 18px;
    text-align: left;
    font-weight: 700;
    font-size: 1em;
    color: white;
    font-family: var(--font);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.transaction-table td {
    padding: 15px 18px;
    border-bottom: 1px solid #e9ecef;
    font-size: 0.95em;
    color: #2c3e50;
    font-family: var(--font);
}

.transaction-table tbody tr {
    transition: all 0.3s;
}

.transaction-table tbody tr:hover {
    background: linear-gradient(to right, rgba(102, 126, 234, 0.08), rgba(118, 75, 162, 0.08));
    transform: scale(1.01);
}

.transaction-type {
    padding: 6px 15px;
    border-radius: 25px;
    font-size: 0.9em;
    font-weight: 700;
    display: inline-block;
    font-family: var(--font);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.type-deposit {
    background: linear-gradient(135deg, rgba(67, 233, 123, 0.2), rgba(56, 249, 215, 0.2));
    color: var(--card3-start);
    border: 2px solid var(--card3-start);
}

.type-withdraw {
    background: linear-gradient(135deg, rgba(245, 87, 108, 0.2), rgba(240, 147, 251, 0.2));
    color: var(--card1-end);
    border: 2px solid var(--card1-end);
}

.transaction-amount {
    font-weight: 700;
    font-size: 1.1em;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.status-badge {
    padding: 6px 15px;
    border-radius: 25px;
    font-size: 0.9em;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-approved {
    background: linear-gradient(135deg, rgba(67, 233, 123, 0.2), rgba(56, 249, 215, 0.2));
    color: var(--card3-start);
    border: 2px solid var(--card3-start);
}

.status-pending {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(254, 225, 64, 0.2));
    color: #ff8800;
    border: 2px solid #ffc107;
}

.status-rejected {
    background: linear-gradient(135deg, rgba(245, 87, 108, 0.2), rgba(240, 147, 251, 0.2));
    color: var(--card1-end);
    border: 2px solid var(--card1-end);
}

.transaction-empty {
    text-align: center;
    padding: 50px 25px;
    color: #6c757d;
    font-family: var(--font);
    font-size: 1.1em;
}

/* UTILITY CLASSES */
.d-flex { display: flex !important; }
.align-items-center { align-items: center; }
.justify-content-between { justify-content: space-between; }
.mb-0 { margin-bottom: 0 !important; }
.fw-bold { font-weight: 700; }
.mt-3 { margin-top: 15px !important; }
.mt-4 { margin-top: 20px !important; }
.mt-5 { margin-top: 30px !important; }

/* RESPONSIVE */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .stat-card {
        padding: 20px;
    }
    .lottery-image {
        height: 180px;
    }
    .lottery-content {
        padding: 20px;
    }
    .transaction-container {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 15px;
    }
    .lottery-content {
        padding: 15px;
    }
    .stat-card-value {
        font-size: 1.8em;
    }
    .transaction-header {
        font-size: 1.4em;
    }
}

@keyframes scroll {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    /* Pulse Animation for Icon Background */
    @keyframes pulse {
        0%, 100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.3;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 0;
        }
    }

    /* Shake Animation for Bullhorn */
    @keyframes shake {
        0%, 100% {
            transform: rotate(0deg);
        }
        10%, 30% {
            transform: rotate(-10deg);
        }
        20%, 40% {
            transform: rotate(10deg);
        }
        50% {
            transform: rotate(0deg);
        }
    }

    /* Ring Animation for Bell */
    @keyframes ring {
        0%, 100% {
            transform: rotate(0deg);
        }
        10%, 30% {
            transform: rotate(-15deg);
        }
        20%, 40% {
            transform: rotate(15deg);
        }
        50% {
            transform: rotate(0deg);
        }
    }

    /* Background Move Animation */
    @keyframes bgMove {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 100px 100px;
        }
    }

    /* Hover Effects */
    .notice-scroll:hover {
        animation-play-state: paused;
    }

    .notice-close:hover {
        background: rgba(255,255,255,0.3) !important;
        transform: scale(1.1);
    }

    .notice-close:active {
        transform: scale(0.95);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notice-label {
            display: none !important;
        }
        .notice-icon {
            margin-right: 10px !important;
        }
        .notice-icon div {
            width: 35px !important;
            height: 35px !important;
        }
        .notice-icon i {
            font-size: 1em !important;
        }
        .notice-scroll span {
            font-size: 0.9em !important;
        }
    }
</style>


@php
    use App\Models\Notice;

    $notice = Notice::latest()->first();
    $currentLang = app()->getLocale(); // 'en' or 'bn'
@endphp

{{-- Modern Notice Bar --}}
<div class="notice-bar-wrapper" style="background: linear-gradient(135deg, #30cfd0 0%, #086755 100%); padding: 0; overflow: hidden; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.2); border-bottom: 3px solid #30cfd0;">

    {{-- Animated Background Pattern --}}
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background-image: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.1) 35px, rgba(255,255,255,.1) 70px); animation: bgMove 20s linear infinite;"></div>

    <div class="container-fluid">
        <div class="notice-bar" style="display: flex; align-items: center; padding: 15px 0; position: relative; z-index: 1;">

            {{-- Notice Icon with Pulse Animation --}}
            <div class="notice-icon" style="flex-shrink: 0; margin-right: 20px; position: relative;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 50px; height: 50px; background: rgba(255,193,7,0.3); border-radius: 50%; animation: pulse 2s infinite;"></div>
                <div style="position: relative; background: #ffc107; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(255,193,7,0.4);">
                    <i class="fas fa-bullhorn" style="color: #ffffff; font-size: 1.3em; animation: shake 3s infinite;"></i>
                </div>
            </div>

            {{-- Notice Label --}}
            <div class="notice-label" style="flex-shrink: 0; margin-right: 15px; background: rgba(255,255,255,0.2); padding: 8px 20px; border-radius: 25px; backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.3);">
                <span style="color: #ffffff; font-weight: bold; font-size: 0.95em; letter-spacing: 1px; text-transform: uppercase;">
                    <i class="fas fa-bell" style="margin-right: 8px; animation: ring 2s infinite;"></i>
                    {{ $currentLang === 'bn' ? 'নোটিস' : 'Notice' }}
                </span>
            </div>

            {{-- Scrolling Notice Text --}}
            <div class="notice-content" style="flex: 1; overflow: hidden; position: relative; height: 30px;">
                <div class="notice-scroll" style="position: absolute; white-space: nowrap; animation: scroll 25s linear infinite; padding-right: 50px;">
                    <span style="color: #ffffff; font-size: 1.05em; font-weight: 500; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        {{ $notice->notices_text ?? ($currentLang === 'bn' ? 'কোন নোটিস উপলব্ধ নেই' : 'No notice available') }}
                    </span>
                </div>
            </div>

            {{-- Close Button (Optional) --}}
            <button class="notice-close" onclick="this.closest('.notice-bar-wrapper').style.display='none'" style="flex-shrink: 0; margin-left: 15px; background: rgba(255,255,255,0.2); border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
                <i class="fas fa-times" style="color: #ffffff; font-size: 1.1em;"></i>
            </button>

        </div>
    </div>
</div>



<div class="container">

    <!-- USER TOGGLER -->
    <div class="d-lg-none">
        <div class="user-toggler-wrapper d-flex align-items-center justify-content-between">
            <h4 class="fw-bold mb-0" style="color: white; font-family: var(--font);">
                {{ trans_db('User Dashboard', 'User Dashboard') }}
            </h4>
            <button class="user-toggler" type="button">
                <i class="las la-sliders-h"></i>
            </button>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="fade-in" style="animation-delay: 0s;">
            <div class="stat-card">
                <div class="stat-card-value">
                    {{ number_format(round($total_deposite ?? 0)) }} {{ trans_db('টাকা','টাকা') }}
                </div>
                <div class="stat-card-label">
                    {{ trans_db('Total Deposit','Total Deposit') }}
                </div>
                <div class="stat-card-icon">
                    <i class="las la-wallet"></i>
                </div>
            </div>
        </div>

        <div class="fade-in" style="animation-delay: 0.1s;">
            <div class="stat-card">
                <div class="stat-card-value">
                    {{ number_format(round($total_balance ?? 0)) }} {{ trans_db('টাকা','টাকা') }}
                </div>
                <div class="stat-card-label">
                    {{ trans_db('Total Balance','Total Balance') }}
                </div>
                <div class="stat-card-icon">
                    <i class="las la-coins"></i>
                </div>
            </div>
        </div>

        <div class="fade-in" style="animation-delay: 0.2s;">
            <div class="stat-card">
                <div class="stat-card-value">
                    {{ number_format(round($total_withdraw ?? 0)) }} {{ trans_db('টাকা','টাকা') }}
                </div>
                <div class="stat-card-label">
                    {{ trans_db('Total Withdraw','Total Withdraw') }}
                </div>
                <div class="stat-card-icon">
                    <i class="las la-hand-holding-usd"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- LOTTERY GRID -->
    <div class="lottery-grid mt-5">
        @forelse($package_show as $index => $package)
            @php
                $drawDate = $package->draw_date ? Carbon::parse($package->draw_date, 'UTC')->setTimezone('Asia/Dhaka') : null;
                $drawTimestamp = $drawDate ? $drawDate->timestamp * 1000 : 0;

                $videoScheduledAt = $package->video_scheduled_at ? Carbon::parse($package->video_scheduled_at, 'UTC')->setTimezone('Asia/Dhaka') : null;
                $videoTimestamp = $videoScheduledAt ? $videoScheduledAt->timestamp * 1000 : 0;

                $shouldShowVideo = false;
                if ($package->video_enabled && $videoScheduledAt) {
                    $shouldShowVideo = $serverNow->gte($videoScheduledAt);
                }

                $embedUrl = '';
                $isYouTube = false;
                $videoSource = '';

                if ($package->video_type === 'upload' && $package->video_file) {
                    $videoSource = asset('uploads/lottery/videos/' . $package->video_file);
                } elseif ($package->video_url) {
                    $videoUrl = trim($package->video_url);

                    if ($package->video_type === 'youtube') {
                        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $videoUrl)) {
                            $videoId = $videoUrl;
                        } elseif (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                            $videoId = $matches[1];
                        } else {
                            $videoId = null;
                        }

                        if ($videoId) {
                            $embedUrl = "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=0&rel=0&modestbranding=1&controls=1";
                            $isYouTube = true;
                        }
                    } else {
                        $videoSource = $videoUrl;
                    }
                }

                $lotteryName = is_array($package->name) ? ($currentLocale === 'bn' ? ($package->name['bn'] ?? $package->name['en']) : $package->name['en']) : $package->name;
                $lotteryDescription = is_array($package->description) ? ($currentLocale === 'bn' ? ($package->description['bn'] ?? $package->description['en'] ?? '') : ($package->description['en'] ?? '')) : ($package->description ?? '');
                $animationDelay = ($index % ($package_show->perPage() ?? 12)) * 0.1;
                $totalBuyers = $total_buyer ?? 0;
            @endphp

            <div class="fade-in" style="animation-delay: {{ $animationDelay }}s;">
                <div class="lottery-card">
                    <div class="lottery-card-inner">
                        @auth
                            <form method="POST" action="{{ route('buy.package', $package->id) }}">
                                @csrf
                                <img src="{{ asset('uploads/lottery/' . ($package->photo ?? 'default.png')) }}" alt="{{ $lotteryName }}" class="lottery-image" onerror="this.src='{{ asset('assets/images/default-lottery.png') }}'">

                                <div class="lottery-content">
                                    <h4 class="lottery-title">{{ $lotteryName ?: trans_db('N/A', 'N/A') }}</h4>
                                    @if($lotteryDescription)
                                        <p class="lottery-description">{{ Str::limit($lotteryDescription, 80) }}</p>
                                    @endif

                                    <div class="lottery-badge">{{ ucfirst($package->win_type ?? trans_db('N/A', 'N/A')) }}</div>
                                    <div class="lottery-price">{{ number_format($package->price ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}</div>

                                    <div class="lottery-info-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <strong>{{ trans_db('Draw Date', 'Draw Date') }}:</strong>
                                        <span style="margin-left: 5px;">{{ $drawDate ? $drawDate->format('d M, Y h:i A') : trans_db('Not Set', 'Not Set') }}</span>
                                    </div>

                                    <div class="prize-box">
                                        <div class="prize-item">
                                            <i class="fas fa-trophy"></i>
                                            <span class="prize-label">{{ trans_db('1st Prize', '1st Prize') }}:</span>
                                            {{ number_format($package->first_prize ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}
                                        </div>
                                        <div class="prize-item">
                                            <i class="fas fa-medal"></i>
                                            <span class="prize-label">{{ trans_db('2nd Prize', '2nd Prize') }}:</span>
                                            {{ number_format($package->second_prize ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}
                                        </div>
                                        <div class="prize-item">
                                            <i class="fas fa-award"></i>
                                            <span class="prize-label">{{ trans_db('3rd Prize', '3rd Prize') }}:</span>
                                            {{ number_format($package->third_prize ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}
                                        </div>
                                    </div>

                                    <div class="participants-box">
                                        <i class="fas fa-users"></i>
                                        <strong>{{ trans_db('Total Participants', 'Total Participants') }}:</strong>
                                        <span style="margin-left: 5px;">{{ $totalBuyers }}</span>
                                    </div>

                                    @if(is_array($package->multiple_title) && count(array_filter($package->multiple_title)) > 0)
                                        <div class="gift-box">
                                            <div class="gift-title">
                                                <i class="fas fa-box-open"></i>
                                                {{ trans_db('Best Gift', 'Best Gift') }}
                                            </div>
                                            <ul class="gift-list">
                                                @foreach($package->multiple_title as $idx => $title)
                                                    @if($title)
                                                        <li class="gift-item">
                                                            <i class="fas fa-check-circle"></i>
                                                            <strong>{{ $title }}</strong> - {{ number_format($package->multiple_price[$idx] ?? 0, 0) }} {{ trans_db('টাকা','টাকা') }}
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if($package->video_enabled && ($embedUrl || $videoSource))
                                        <div class="video-section" data-package-id="{{ $package->id }}" data-should-show="{{ $shouldShowVideo ? 'true' : 'false' }}" data-video-time="{{ $videoTimestamp }}" data-server-time="{{ $serverTimestamp }}" data-embed-url="{{ $embedUrl }}" data-video-source="{{ $videoSource }}">
                                            @if($shouldShowVideo)
                                                <div class="video-container">
                                                    @if($isYouTube && $embedUrl)
                                                        <div class="video-responsive">
                                                            <iframe src="{{ $embedUrl }}" title="Lottery Live Draw" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                        </div>
                                                    @elseif($videoSource)
                                                        <video controls autoplay muted playsinline style="width: 100%; display: block;">
                                                            <source src="{{ $videoSource }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    @endif
                                                </div>
                                                <div class="video-live-badge">
                                                    <i class="fas fa-circle blink-icon" style="color: #ff0000;"></i>
                                                    {{ trans_db('LIVE NOW', 'LIVE NOW') }}
                                                </div>
                                            @else
                                                <div class="video-coming-soon">
                                                    <i class="fas fa-video pulse-icon video-coming-soon-icon"></i>
                                                    <h5 class="video-coming-soon-title">
                                                        <i class="fas fa-broadcast-tower"></i>
                                                        {{ trans_db('Live Draw Coming Soon', 'Live Draw Coming Soon!') }}
                                                    </h5>
                                                    @if($videoTimestamp > 0)
                                                        <div class="video-countdown-text" data-video-time="{{ $videoTimestamp }}" data-server-time="{{ $serverTimestamp }}" data-package-id="{{ $package->id }}">
                                                            <i class="fas fa-clock"></i> {{ trans_db('Calculating', 'Calculating...') }}
                                                        </div>
                                                    @endif
                                                    <p class="video-start-time">
                                                        <i class="fas fa-calendar-check"></i>
                                                        {{ trans_db('Video Start', 'Video Start') }}: {{ $videoScheduledAt ? $videoScheduledAt->format('d M, Y h:i A') : trans_db('Not Set', 'Not Set') }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <button type="submit" class="btn btn-primary mt-4">
                                        <i class="fas fa-ticket-alt"></i>
                                        {{ trans_db('Buy Ticket', 'Buy Ticket') }}
                                    </button>
                                </div>
                            </form>
                        @else
                            <img src="{{ asset('uploads/lottery/' . ($package->photo ?? 'default.png')) }}" alt="{{ $lotteryName }}" class="lottery-image">
                            <div class="lottery-content">
                                <h4 class="lottery-title">{{ $lotteryName ?: trans_db('N/A', 'N/A') }}</h4>
                                @if($lotteryDescription)
                                    <p class="lottery-description">{{ Str::limit($lotteryDescription, 80) }}</p>
                                @endif

                                @if($package->video_enabled && $shouldShowVideo && ($embedUrl || $videoSource))
                                    <div class="video-container mt-3">
                                        @if($isYouTube && $embedUrl)
                                            <div class="video-responsive">
                                                <iframe src="{{ $embedUrl }}" allowfullscreen></iframe>
                                            </div>
                                        @elseif($videoSource)
                                            <video controls autoplay muted src="{{ $videoSource }}" style="width: 100%;"></video>
                                        @endif
                                    </div>
                                @endif

                                <a href="{{ route('frontend.login') }}" class="btn btn-primary mt-4">
                                    <i class="fas fa-sign-in-alt"></i>
                                    {{ trans_db('Login to Play', 'Login to Play') }}
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

        @empty
            <div style="grid-column: 1 / -1;">
                <div class="empty-state fade-in">
                    <i class="fas fa-inbox empty-state-icon"></i>
                    <h4 class="empty-state-title">{{ trans_db('No lottery packages available', 'No lottery packages available') }}</h4>
                    <p class="empty-state-text">{{ trans_db('Please check back later for new lottery packages', 'Please check back later for new lottery packages') }}</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($package_show->hasPages())
        <div class="pagination-wrapper">
            {{ $package_show->links('pagination::bootstrap-4') }}
        </div>
    @endif

</div>

<!-- JAVASCRIPT -->
<script>
(function() {
    'use strict';

    const CFG = {
        DEBUG: true,
        TZ: 'Asia/Dhaka',
        LOCALE: '{{ $currentLocale }}',
        UPDATE_MS: 1000,
        RELOAD_MS: 3000,
        COOLDOWN_MS: 30000
    };

    const U = {
        log(msg, data) {
            if (CFG.DEBUG) {
                const t = new Date().toLocaleTimeString('en-US', {
                    timeZone: CFG.TZ,
                    hour12: false
                });
                console.log(`[${t}] 🎰`, msg, data || '');
            }
        },
        fmt(ms) {
            if (ms <= 0) return { d: 0, h: 0, m: 0, s: 0 };
            const s = Math.floor(ms / 1000);
            const m = Math.floor(s / 60);
            const h = Math.floor(m / 60);
            const d = Math.floor(h / 24);
            return { d, h: h % 24, m: m % 60, s: s % 60 };
        },
        tr(k) {
            const t = {
                en: { LIVE: 'LIVE NOW', Calc: 'Calculating...' },
                bn: { LIVE: 'লাইভ চলছে', Calc: 'গণনা করা হচ্ছে...' }
            };
            return t[CFG.LOCALE]?.[k] || k;
        }
    };

    const TS = {
        off: 0,
        init() {
            const el = document.querySelector('[data-server-time]');
            if (!el) {
                U.log('⚠️ No server time');
                return;
            }
            const st = parseInt(el.getAttribute('data-server-time'), 10);
            const bt = Date.now();
            this.off = st - bt;
            U.log('✅ Time synced', { off: this.off });
        },
        now() {
            return Date.now() + this.off;
        }
    };

    const VC = {
        els: [],
        init() {
            this.els = Array.from(document.querySelectorAll('.video-countdown-text'));
            U.log(`Found ${this.els.length} countdowns`);
        },
        upd() {
            this.els.forEach(el => {
                const vt = parseInt(el.getAttribute('data-video-time'), 10);
                if (!vt || vt <= 0) {
                    el.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Not Set';
                    return;
                }
                const now = TS.now();
                const diff = vt - now;
                if (diff <= 0) {
                    el.innerHTML = '<i class="fas fa-circle blink-icon" style="color: #00ff00;"></i> ' + U.tr('LIVE');
                    return;
                }
                const t = U.fmt(diff);
                el.innerHTML = `<i class="fas fa-clock"></i> ${t.d}d ${t.h}h ${t.m}m ${t.s}s`;
            });
        }
    };

    const AR = {
        key: 'lot_reload',
        chk() {
            const secs = document.querySelectorAll('[data-should-show="false"]');
            let need = false;
            secs.forEach(s => {
                const vt = parseInt(s.getAttribute('data-video-time'), 10);
                if (vt && vt > 0) {
                    const now = TS.now();
                    const diff = vt - now;
                    if (diff <= CFG.RELOAD_MS && diff > -1000) {
                        U.log('🎬 Video time!');
                        need = true;
                    }
                }
            });
            if (need) this.rel();
        },
        rel() {
            const last = sessionStorage.getItem(this.key);
            const now = Date.now();
            if (last && (now - parseInt(last)) < CFG.COOLDOWN_MS) {
                U.log('⏳ Cooldown active');
                return;
            }
            sessionStorage.setItem(this.key, now.toString());
            U.log('🔄 Reloading...');
            setTimeout(() => window.location.reload(true), 1000);
        }
    };

    function init() {
        U.log('=== 🚀 Starting Colorful Lottery Dashboard ===');
        TS.init();
        VC.init();
        VC.upd();
        AR.chk();
        setInterval(() => {
            VC.upd();
            AR.chk();
        }, CFG.UPDATE_MS);
        U.log('✅ Ready - Colorful 3D Cards Loaded');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
