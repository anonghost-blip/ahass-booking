<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AHASS - Sistem Booking Servis Honda</title>
    <meta name="description" content="Sistem Booking Servis AHASS Honda - Pendaftaran servis motor Honda secara online">

    <!-- Favicon -->
    <?php
    $favicon_src = '';
    foreach (['logo.png', 'logo.svg', 'logo.ico', 'logo.jpg'] as $fav) {
        $fav_path = FCPATH . 'assets/images/' . $fav;
        if (file_exists($fav_path)) {
            $favicon_src = base_url('assets/images/' . $fav) . '?v=' . filemtime($fav_path);
            break;
        }
    }
    ?>
    <?php if ($favicon_src): ?>
    <link rel="shortcut icon" href="<?= $favicon_src ?>" type="image/x-icon">
    <link rel="icon" href="<?= $favicon_src ?>" type="image/png">
    <?php endif; ?>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ========================================
           CSS VARIABLES & RESET
           ======================================== */
        :root {
            --primary: #E60012;
            --primary-dark: #CC0010;
            --primary-light: #FF1A2C;
            --secondary: #1A1A2E;
            --secondary-light: #16213E;
            --accent: #FF6B35;
            --success: #10B981;
            --success-light: #D1FAE5;
            --warning: #F59E0B;
            --warning-light: #FEF3C7;
            --danger: #EF4444;
            --danger-light: #FEE2E2;
            --info: #3B82F6;
            --info-light: #DBEAFE;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            --white: #FFFFFF;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            --radius: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* ========================================
           HEADER & NAVIGATION
           ======================================== */
        .header {
            background: var(--white);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--gray-200);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 32px;
            border-bottom: 1px solid var(--gray-100);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: var(--primary);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            font-weight: 800;
            letter-spacing: -1px;
            box-shadow: 0 4px 12px rgba(230, 0, 18, 0.25);
        }

        .logo-img {
            height: 54px;
            width: auto;
            max-width: 200px;
            object-fit: contain;
            border: none;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            padding: 0;
            display: block;
        }

        .logo-text h1 {
            color: var(--gray-900);
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .logo-text span {
            color: var(--gray-500);
            font-size: 12px;
            font-weight: 400;
        }

        /* Navigation Tabs */
        .nav-tabs {
            display: flex;
            gap: 4px;
            padding: 0 32px;
        }

        .nav-tab {
            padding: 13px 20px;
            color: var(--gray-600);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            background: none;
            border-bottom: 2px solid transparent;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
        }

        .nav-tab:hover {
            color: var(--primary);
            background: var(--gray-50);
        }

        .nav-tab.active {
            color: var(--primary);
            font-weight: 600;
            border-bottom-color: var(--primary);
        }

        .nav-tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary);
            box-shadow: 0 1px 4px rgba(230, 0, 18, 0.3);
        }

        .nav-tab i {
            font-size: 15px;
        }

        /* ========================================
           MAIN CONTENT
           ======================================== */
        .main-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 28px 32px 60px;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-12px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* ========================================
           CARDS
           ======================================== */
        .card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h2 {
            font-size: 17px;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header h2 i {
            color: var(--primary);
            font-size: 18px;
        }

        .card-body {
            padding: 24px;
        }

        /* ========================================
           FORM STYLES
           ======================================== */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-grid .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-group label .required {
            color: var(--danger);
            font-size: 11px;
        }

        .form-control {
            padding: 10px 14px;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            font-size: 14px;
            font-family: inherit;
            color: var(--gray-800);
            background: var(--white);
            transition: var(--transition);
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(230, 0, 18, 0.1);
        }

        .form-control::placeholder {
            color: var(--gray-400);
        }

        .form-control:disabled {
            background: var(--gray-100);
            cursor: not-allowed;
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236B7280' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* ========================================
           BUTTONS
           ======================================== */
        .btn {
            padding: 10px 20px;
            border-radius: var(--radius);
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: var(--transition);
            text-decoration: none;
            line-height: 1.4;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            box-shadow: 0 2px 8px rgba(230, 0, 18, 0.25);
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(230, 0, 18, 0.35);
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
            border: 1px solid var(--gray-200);
        }

        .btn-secondary:hover:not(:disabled) {
            background: var(--gray-200);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: var(--white);
        }

        .btn-success:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #D97706 100%);
            color: var(--white);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #DC2626 100%);
            color: var(--white);
        }

        .btn-danger:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-group {
            display: flex;
            gap: 8px;
            margin-top: 20px;
        }

        /* ========================================
           TABLE STYLES
           ======================================== */
        .table-wrapper {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
        }

        .data-table thead th {
            background: var(--gray-50);
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border-bottom: 2px solid var(--gray-200);
            text-align: left;
            white-space: nowrap;
        }

        .data-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--gray-100);
            vertical-align: middle;
        }

        .data-table tbody tr {
            transition: var(--transition);
        }

        .data-table tbody tr:hover {
            background: var(--gray-50);
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ========================================
           STATUS BADGES
           ======================================== */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-pending {
            background: var(--warning-light);
            color: #92400E;
        }

        .badge-confirmed {
            background: var(--info-light);
            color: #1E40AF;
        }

        .badge-completed {
            background: var(--success-light);
            color: #065F46;
        }

        .badge-cancelled {
            background: var(--danger-light);
            color: #991B1B;
        }

        /* ========================================
           SLOT GRID
           ======================================== */
        .slot-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 8px;
        }

        .slot-item {
            padding: 10px;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            background: var(--white);
        }

        .slot-item:hover:not(.slot-full):not(.slot-selected) {
            border-color: var(--primary);
            background: rgba(230, 0, 18, 0.02);
        }

        .slot-item.slot-selected {
            border-color: var(--primary);
            background: rgba(230, 0, 18, 0.06);
            box-shadow: 0 0 0 3px rgba(230, 0, 18, 0.1);
        }

        .slot-item.slot-full {
            background: var(--gray-100);
            border-color: var(--gray-200);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .slot-time {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-800);
        }

        .slot-full .slot-time {
            color: var(--gray-400);
            text-decoration: line-through;
        }

        .slot-info {
            font-size: 11px;
            color: var(--gray-500);
            margin-top: 2px;
        }

        .slot-full .slot-info {
            color: var(--danger);
            font-weight: 600;
        }

        /* ========================================
           FILTER BAR
           ======================================== */
        .filter-bar {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-bar .form-group {
            flex: 1;
            min-width: 160px;
        }

        .filter-bar .form-group label {
            font-size: 12px;
        }

        .filter-bar .form-control {
            padding: 8px 12px;
            font-size: 13px;
        }

        /* ========================================
           ALERTS / TOAST
           ======================================== */
        .alert-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 420px;
        }

        .alert {
            padding: 14px 20px;
            border-radius: var(--radius-lg);
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-lg);
            animation: slideIn 0.4s ease;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: var(--success);
            color: var(--white);
        }

        .alert-error {
            background: var(--danger);
            color: var(--white);
        }

        .alert-close {
            margin-left: auto;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
            background: none;
            border: none;
            color: inherit;
            font-size: 16px;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* ========================================
           MODAL
           ======================================== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            width: 90%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            animation: fadeIn 0.3s ease;
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 17px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: var(--radius);
            border: none;
            background: var(--gray-100);
            color: var(--gray-500);
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .modal-close:hover {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--gray-100);
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        /* ========================================
           EMPTY STATE
           ======================================== */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: var(--gray-400);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 15px;
            font-weight: 500;
        }

        .empty-state span {
            font-size: 13px;
            color: var(--gray-400);
            margin-top: 4px;
            display: block;
        }

        /* ========================================
           LOADING SPINNER
           ======================================== */
        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-overlay {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: var(--gray-400);
            gap: 10px;
            font-size: 14px;
        }

        .loading-overlay .spinner {
            border-color: var(--gray-200);
            border-top-color: var(--primary);
        }

        /* ========================================
           STATS ROW (for Booking page)
           ======================================== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 18px 20px;
            border: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: var(--transition);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .stat-icon.red {
            background: rgba(230, 0, 18, 0.1);
            color: var(--primary);
        }

        .stat-icon.green {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .stat-icon.blue {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
        }

        .stat-icon.yellow {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .stat-info h3 {
            font-size: 22px;
            font-weight: 800;
            color: var(--gray-900);
            line-height: 1;
        }

        .stat-info p {
            font-size: 12px;
            color: var(--gray-500);
            font-weight: 500;
            margin-top: 2px;
        }

        /* ========================================
           PRICE FORMAT
           ======================================== */
        .price {
            font-weight: 700;
            color: var(--primary);
        }

        /* ========================================
           ACTION DROPDOWN
           ======================================== */
        .action-dropdown {
            position: relative;
            display: inline-block;
        }

        .action-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-200);
            min-width: 160px;
            z-index: 50;
            overflow: hidden;
        }

        .action-dropdown-content.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        .action-dropdown-content button {
            width: 100%;
            padding: 9px 16px;
            text-align: left;
            border: none;
            background: none;
            font-size: 13px;
            font-family: inherit;
            color: var(--gray-700);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.15s;
        }

        .action-dropdown-content button:hover {
            background: var(--gray-50);
        }

        .action-dropdown-content button.text-danger {
            color: var(--danger);
        }

        /* ========================================
           RESPONSIVE
           ======================================== */
        @media (max-width: 768px) {
            .header-top {
                padding: 12px 16px;
            }

            .nav-tabs {
                padding: 0 16px;
                overflow-x: auto;
            }

            .nav-tab {
                padding: 12px 16px;
                font-size: 13px;
                white-space: nowrap;
            }

            .main-content {
                padding: 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .slot-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-bar {
                flex-direction: column;
            }

            .filter-bar .form-group {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Alert Container -->
    <div class="alert-container" id="alertContainer"></div>

    <!-- ========================================
         HEADER
         ======================================== -->
    <header class="header">
        <div class="header-top">
            <div class="logo">
                <?php 
                $logo_src = '';
                foreach (['logo.png', 'logo.svg', 'logo.jpg', 'logo.jpeg', 'logo.webp'] as $file) {
                    $file_path = FCPATH . 'assets/images/' . $file;
                    if (file_exists($file_path)) {
                        $logo_src = base_url('assets/images/' . $file) . '?v=' . filemtime($file_path);
                        break;
                    }
                }
                ?>
                <?php if ($logo_src): ?>
                    <img src="<?= $logo_src ?>" alt="AHASS Logo" class="logo-img">
                <?php else: ?>
                    <div class="logo-icon">H</div>
                <?php endif; ?>
                <div class="logo-text">
                    <h1>AHASS Booking</h1>
                    <span>Sistem Booking Servis Honda</span>
                </div>
            </div>
        </div>
        <nav class="nav-tabs">
            <button class="nav-tab active" data-tab="booking" id="navBooking">
                <i class="fas fa-calendar-plus"></i>
                Form Booking
            </button>
            <button class="nav-tab" data-tab="list" id="navList">
                <i class="fas fa-list-ul"></i>
                Daftar Booking
            </button>
            <button class="nav-tab" data-tab="paket" id="navPaket">
                <i class="fas fa-box-open"></i>
                Paket Servis
            </button>
        </nav>
    </header>

    <!-- ========================================
         MAIN CONTENT
         ======================================== -->
    <main class="main-content">

        <!-- ===================== TAB 1: FORM BOOKING ===================== -->
        <div class="tab-content active" id="tabBooking">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-motorcycle"></i> Form Booking Servis</h2>
                </div>
                <div class="card-body">
                    <form id="formBooking">
                        <div class="form-grid">
                            <!-- Plat Nomor -->
                            <div class="form-group">
                                <label><i class="fas fa-id-badge"></i> Plat Nomor <span class="required">*</span></label>
                                <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" placeholder="Contoh: DN 1234 ABC" required>
                            </div>

                            <!-- Nama Pelanggan -->
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Nama Pelanggan <span class="required">*</span></label>
                                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <!-- Tipe Motor -->
                            <div class="form-group">
                                <label><i class="fas fa-motorcycle"></i> Tipe Motor <span class="required">*</span></label>
                                <input type="text" class="form-control" id="tipe_motor" name="tipe_motor" placeholder="Contoh: Honda Beat, Vario 160" required>
                            </div>

                            <!-- Paket Servis -->
                            <div class="form-group">
                                <label><i class="fas fa-box-open"></i> Paket Servis <span class="required">*</span></label>
                                <select class="form-control" id="paket_id" name="paket_id" required>
                                    <option value="">-- Pilih Paket Servis --</option>
                                    <?php foreach ($paket_list as $paket): ?>
                                    <option value="<?= $paket->id ?>">
                                        <?= htmlspecialchars($paket->nama_paket) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Tanggal Servis -->
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt"></i> Tanggal Servis <span class="required">*</span></label>
                                <input type="date" class="form-control" id="tanggal_servis" name="tanggal_servis" min="<?= date('Y-m-d') ?>" required>
                            </div>

                            <!-- Jam Servis (Slot) -->
                            <div class="form-group">
                                <label><i class="fas fa-clock"></i> Jam Servis <span class="required">*</span></label>
                                <input type="hidden" id="jam_servis" name="jam_servis">
                                <div class="slot-grid" id="slotGrid">
                                    <div class="empty-state" style="grid-column: 1/-1; padding: 20px;">
                                        <i class="fas fa-calendar" style="font-size: 24px;"></i>
                                        <p style="font-size: 13px;">Pilih tanggal terlebih dahulu</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary" id="btnSubmitBooking">
                                <i class="fas fa-paper-plane"></i> Submit Booking
                            </button>
                            <button type="reset" class="btn btn-secondary" id="btnResetBooking">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===================== TAB 2: DAFTAR BOOKING ===================== -->
        <div class="tab-content" id="tabList">
            <!-- Filter -->
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-header">
                    <h2><i class="fas fa-filter"></i> Filter Booking</h2>
                </div>
                <div class="card-body">
                    <div class="filter-bar">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" class="form-control filter-input" id="filterTanggal">
                        </div>
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" class="form-control filter-input" id="filterNama" placeholder="Cari nama...">
                        </div>
                        <div class="form-group">
                            <label>Plat Nomor</label>
                            <input type="text" class="form-control filter-input" id="filterPlat" placeholder="Cari plat...">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control filter-input" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group" style="justify-content: flex-end;">
                            <label>&nbsp;</label>
                            <button class="btn btn-secondary btn-sm" id="btnResetFilter">
                                <i class="fas fa-times"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Booking -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-list-ul"></i> Daftar Booking</h2>
                    <span style="font-size: 13px; color: var(--gray-500);" id="bookingCount">0 booking</span>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-wrapper">
                        <table class="data-table" id="tableBooking">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Plat Nomor</th>
                                    <th>Nama</th>
                                    <th>Tipe Motor</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Paket</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyBooking">
                                <tr>
                                    <td colspan="9">
                                        <div class="loading-overlay">
                                            <div class="spinner"></div>
                                            Memuat data...
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================== TAB 3: PAKET SERVIS ===================== -->
        <div class="tab-content" id="tabPaket">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-box-open"></i> Master Paket Servis</h2>
                    <button class="btn btn-primary btn-sm" id="btnAddPaket">
                        <i class="fas fa-plus"></i> Tambah Paket
                    </button>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-wrapper">
                        <table class="data-table" id="tablePaket">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Paket</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyPaket">
                                <tr>
                                    <td colspan="4">
                                        <div class="loading-overlay">
                                            <div class="spinner"></div>
                                            Memuat data...
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- ========================================
         MODAL: FORM PAKET SERVIS
         ======================================== -->
    <div class="modal-overlay" id="modalPaket">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modalPaketTitle">Tambah Paket Servis</h3>
                <button class="modal-close" onclick="closeModal('modalPaket')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formPaket">
                    <input type="hidden" id="paket_edit_id" name="id">
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label>Nama Paket <span class="required">*</span></label>
                        <input type="text" class="form-control" id="paket_nama" name="nama_paket" placeholder="Nama paket servis" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea class="form-control" id="paket_deskripsi" name="deskripsi" placeholder="Deskripsi paket servis"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('modalPaket')">Batal</button>
                <button class="btn btn-primary" id="btnSavePaket">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // ========================================
        // GLOBAL CONFIG
        // ========================================
        const BASE_URL = '<?= base_url() ?>';

        // ========================================
        // TAB NAVIGATION
        // ========================================
        document.querySelectorAll('.nav-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active from all tabs
                document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                // Activate clicked tab
                this.classList.add('active');
                const tabName = this.dataset.tab;

                if (tabName === 'booking') {
                    document.getElementById('tabBooking').classList.add('active');
                } else if (tabName === 'list') {
                    document.getElementById('tabList').classList.add('active');
                    loadBookings();
                } else if (tabName === 'paket') {
                    document.getElementById('tabPaket').classList.add('active');
                    loadPaket();
                }
            });
        });

        // ========================================
        // ALERT / TOAST SYSTEM
        // ========================================
        function showAlert(type, message) {
            const container = document.getElementById('alertContainer');
            const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
            const alertEl = document.createElement('div');
            alertEl.className = `alert alert-${type}`;
            alertEl.innerHTML = `
                <i class="fas fa-${icon}"></i>
                <span>${message}</span>
                <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            `;
            container.appendChild(alertEl);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alertEl.parentElement) {
                    alertEl.style.transition = 'opacity 0.3s, transform 0.3s';
                    alertEl.style.opacity = '0';
                    alertEl.style.transform = 'translateX(20px)';
                    setTimeout(() => alertEl.remove(), 300);
                }
            }, 5000);
        }

        // ========================================
        // MODAL
        // ========================================
        function openModal(id) {
            document.getElementById(id).classList.add('show');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('show');
        }

        // Close modal on overlay click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                }
            });
        });

        // ========================================
        // FORMAT HELPERS & SANITIZATION
        // ========================================
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatRupiah(num) {
            return 'Rp ' + Number(num).toLocaleString('id-ID');
        }

        function formatTanggal(dateStr) {
            const d = new Date(dateStr);
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        function formatJam(timeStr) {
            return timeStr.substring(0, 5);
        }

        function getStatusBadge(status) {
            return `<span class="badge badge-${status}">${status}</span>`;
        }

        // ========================================
        // BOOKING: Load Slot Jam
        // ========================================
        $('#tanggal_servis').on('change', function() {
            const tanggal = $(this).val();
            if (!tanggal) return;

            const grid = $('#slotGrid');
            grid.html('<div class="loading-overlay" style="grid-column:1/-1;padding:20px;"><div class="spinner"></div> Memuat slot...</div>');

            $.ajax({
                url: BASE_URL + 'BookingController/get_slots',
                type: 'GET',
                data: { tanggal: tanggal },
                dataType: 'json',
                success: function(res) {
                    if (res.status && res.data) {
                        let html = '';
                        res.data.forEach(slot => {
                            const fullClass = !slot.available ? 'slot-full' : '';
                            let infoText = '';
                            if (slot.is_past) {
                                infoText = 'Waktu Lewat';
                            } else if (slot.available) {
                                infoText = `Sisa ${slot.sisa} slot`;
                            } else {
                                infoText = 'Slot Penuh';
                            }

                            html += `
                                <div class="slot-item ${fullClass}" 
                                     data-jam="${slot.jam}" 
                                     ${slot.available ? 'onclick="selectSlot(this)"' : ''}>
                                    <div class="slot-time">${slot.jam_display}</div>
                                    <div class="slot-info">${infoText}</div>
                                </div>
                            `;
                        });
                        grid.html(html);
                        // Clear selected jam
                        $('#jam_servis').val('');
                    }
                },
                error: function() {
                    grid.html('<div class="empty-state" style="grid-column:1/-1;padding:20px;"><i class="fas fa-exclamation-triangle" style="font-size:24px;color:var(--danger);"></i><p style="font-size:13px;">Gagal memuat slot</p></div>');
                }
            });
        });

        function selectSlot(el) {
            // Remove selected from all
            document.querySelectorAll('.slot-item').forEach(s => s.classList.remove('slot-selected'));
            // Select this one
            el.classList.add('slot-selected');
            // Set hidden input value
            $('#jam_servis').val(el.dataset.jam);
        }

        // ========================================
        // BOOKING: Submit Form
        // ========================================
        $('#formBooking').on('submit', function(e) {
            e.preventDefault();

            // Validasi jam servis sudah dipilih
            if (!$('#jam_servis').val()) {
                showAlert('error', 'Silakan pilih jam servis terlebih dahulu');
                return;
            }

            const btn = $('#btnSubmitBooking');
            btn.prop('disabled', true).html('<div class="spinner"></div> Memproses...');

            $.ajax({
                url: BASE_URL + 'BookingController/store',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        showAlert('success', res.message);
                        $('#formBooking')[0].reset();
                        $('#jam_servis').val('');
                        $('#slotGrid').html('<div class="empty-state" style="grid-column:1/-1;padding:20px;"><i class="fas fa-calendar" style="font-size:24px;"></i><p style="font-size:13px;">Pilih tanggal terlebih dahulu</p></div>');
                    } else {
                        showAlert('error', res.message);
                    }
                },
                error: function() {
                    showAlert('error', 'Terjadi kesalahan. Silakan coba lagi.');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Submit Booking');
                }
            });
        });

        // Reset form
        $('#btnResetBooking').on('click', function() {
            $('#jam_servis').val('');
            $('#slotGrid').html('<div class="empty-state" style="grid-column:1/-1;padding:20px;"><i class="fas fa-calendar" style="font-size:24px;"></i><p style="font-size:13px;">Pilih tanggal terlebih dahulu</p></div>');
        });

        // ========================================
        // BOOKING LIST: Load & Filter
        // ========================================
        let filterTimeout;

        function loadBookings() {
            const filters = {
                tanggal: $('#filterTanggal').val(),
                nama: $('#filterNama').val(),
                plat_nomor: $('#filterPlat').val(),
                status: $('#filterStatus').val()
            };

            $('#tbodyBooking').html('<tr><td colspan="10"><div class="loading-overlay"><div class="spinner"></div> Memuat data...</div></td></tr>');

            $.ajax({
                url: BASE_URL + 'BookingController/list',
                type: 'GET',
                data: filters,
                dataType: 'json',
                success: function(res) {
                    if (res.status && res.data.length > 0) {
                        let html = '';
                        res.data.forEach((b, i) => {
                            html += `
                                <tr>
                                    <td>${i + 1}</td>
                                    <td><strong>${escapeHtml(b.plat_nomor)}</strong></td>
                                    <td>${escapeHtml(b.nama_pelanggan)}</td>
                                    <td>${escapeHtml(b.tipe_motor)}</td>
                                    <td>${formatTanggal(b.tanggal_servis)}</td>
                                    <td>${formatJam(b.jam_servis)}</td>
                                    <td>${escapeHtml(b.nama_paket || '-')}</td>
                                    <td>${getStatusBadge(b.status)}</td>
                                    <td>
                                        <div class="action-dropdown">
                                            <button class="btn btn-secondary btn-sm" onclick="toggleDropdown(this)">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="action-dropdown-content">
                                                ${b.status === 'pending' ? `<button onclick="updateStatus(${b.id}, 'confirmed')"><i class="fas fa-check" style="color:var(--success);"></i> Konfirmasi</button>` : ''}
                                                ${b.status === 'confirmed' ? `<button onclick="updateStatus(${b.id}, 'completed')"><i class="fas fa-check-double" style="color:var(--success);"></i> Selesai</button>` : ''}
                                                ${b.status !== 'cancelled' && b.status !== 'completed' ? `<button class="text-danger" onclick="updateStatus(${b.id}, 'cancelled')"><i class="fas fa-ban"></i> Batalkan</button>` : ''}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#tbodyBooking').html(html);
                        $('#bookingCount').text(res.data.length + ' booking');
                    } else {
                        $('#tbodyBooking').html('<tr><td colspan="9"><div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada data booking</p><span>Booking akan muncul di sini setelah dibuat</span></div></td></tr>');
                        $('#bookingCount').text('0 booking');
                    }
                },
                error: function() {
                    $('#tbodyBooking').html('<tr><td colspan="9"><div class="empty-state"><i class="fas fa-exclamation-triangle" style="color:var(--danger);"></i><p>Gagal memuat data</p></div></td></tr>');
                }
            });
        }

        // Filter with debounce
        $('.filter-input').on('change keyup', function() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(loadBookings, 400);
        });

        // Reset filter
        $('#btnResetFilter').on('click', function() {
            $('#filterTanggal').val('');
            $('#filterNama').val('');
            $('#filterPlat').val('');
            $('#filterStatus').val('');
            loadBookings();
        });

        // ========================================
        // BOOKING: Update Status
        // ========================================
        function updateStatus(id, status) {
            // Close any open dropdown
            document.querySelectorAll('.action-dropdown-content').forEach(d => d.classList.remove('show'));

            const statusLabels = {
                'confirmed': 'mengkonfirmasi',
                'completed': 'menyelesaikan',
                'cancelled': 'membatalkan'
            };

            if (!confirm(`Apakah Anda yakin ingin ${statusLabels[status]} booking ini?`)) return;

            $.ajax({
                url: BASE_URL + 'BookingController/update_status',
                type: 'POST',
                data: { id: id, status: status },
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        showAlert('success', res.message);
                        loadBookings();
                    } else {
                        showAlert('error', res.message);
                    }
                },
                error: function() {
                    showAlert('error', 'Gagal mengupdate status');
                }
            });
        }

        // ========================================
        // DROPDOWN TOGGLE
        // ========================================
        function toggleDropdown(btn) {
            const dropdown = btn.nextElementSibling;
            const isShown = dropdown.classList.contains('show');

            // Close all dropdowns
            document.querySelectorAll('.action-dropdown-content').forEach(d => d.classList.remove('show'));

            if (!isShown) {
                dropdown.classList.add('show');
            }
        }

        // Close dropdown on outside click
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.action-dropdown')) {
                document.querySelectorAll('.action-dropdown-content').forEach(d => d.classList.remove('show'));
            }
        });

        // ========================================
        // PAKET SERVIS: Load Data & Sync Dropdown
        // ========================================
        function loadPaket() {
            $('#tbodyPaket').html('<tr><td colspan="4"><div class="loading-overlay"><div class="spinner"></div> Memuat data...</div></td></tr>');

            $.ajax({
                url: BASE_URL + 'PaketController/list',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status && res.data && res.data.length > 0) {
                        let html = '';
                        let optionsHtml = '<option value="">-- Pilih Paket Servis --</option>';
                        const currentSelected = $('#paket_id').val();

                        res.data.forEach((p, i) => {
                            html += `
                                <tr>
                                    <td>${i + 1}</td>
                                    <td><strong>${escapeHtml(p.nama_paket)}</strong></td>
                                    <td>${escapeHtml(p.deskripsi || '-')}</td>
                                    <td>
                                        <div style="display:flex;gap:6px;">
                                            <button class="btn btn-secondary btn-sm" onclick="editPaket(${p.id})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="deletePaket(${p.id}, this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            optionsHtml += `<option value="${p.id}">${escapeHtml(p.nama_paket)}</option>`;
                        });
                        $('#tbodyPaket').html(html);

                        // Sinkronisasi otomatis dropdown paket di Form Booking (SPA)
                        $('#paket_id').html(optionsHtml);
                        if (currentSelected) {
                            $('#paket_id').val(currentSelected);
                        }
                    } else {
                        $('#tbodyPaket').html('<tr><td colspan="4"><div class="empty-state"><i class="fas fa-box-open"></i><p>Belum ada paket servis</p></div></td></tr>');
                    }
                },
                error: function() {
                    $('#tbodyPaket').html('<tr><td colspan="4"><div class="empty-state"><i class="fas fa-exclamation-triangle" style="color:var(--danger);"></i><p>Gagal memuat data</p></div></td></tr>');
                }
            });
        }

        // ========================================
        // PAKET SERVIS: Create / Edit
        // ========================================
        $('#btnAddPaket').on('click', function() {
            $('#modalPaketTitle').text('Tambah Paket Servis');
            $('#formPaket')[0].reset();
            $('#paket_edit_id').val('');
            openModal('modalPaket');
        });

        function editPaket(id) {
            $.ajax({
                url: BASE_URL + 'PaketController/get/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status && res.data) {
                        $('#modalPaketTitle').text('Edit Paket Servis');
                        $('#paket_edit_id').val(res.data.id);
                        $('#paket_nama').val(res.data.nama_paket);
                        $('#paket_deskripsi').val(res.data.deskripsi);
                        openModal('modalPaket');
                    } else {
                        showAlert('error', 'Paket tidak ditemukan');
                    }
                }
            });
        }

        $('#btnSavePaket').on('click', function() {
            const id = $('#paket_edit_id').val();
            const url = id
                ? BASE_URL + 'PaketController/update'
                : BASE_URL + 'PaketController/store';

            const btn = $(this);
            btn.prop('disabled', true).html('<div class="spinner"></div> Menyimpan...');

            $.ajax({
                url: url,
                type: 'POST',
                data: $('#formPaket').serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        showAlert('success', res.message);
                        closeModal('modalPaket');
                        loadPaket();
                    } else {
                        showAlert('error', res.message);
                    }
                },
                error: function() {
                    showAlert('error', 'Gagal menyimpan paket servis');
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
                }
            });
        });

        // ========================================
        // PAKET SERVIS: Delete
        // ========================================
        function deletePaket(id, btn) {
            const tr = $(btn).closest('tr');
            const nama = tr.find('td:nth-child(2)').text().trim();
            if (!confirm(`Hapus paket "${nama}"? Tindakan ini tidak bisa dibatalkan.`)) return;

            $.ajax({
                url: BASE_URL + 'PaketController/delete',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        showAlert('success', res.message);
                        loadPaket();
                    } else {
                        showAlert('error', res.message);
                    }
                },
                error: function() {
                    showAlert('error', 'Gagal menghapus paket');
                }
            });
        }
    </script>

</body>
</html>
