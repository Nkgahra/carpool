<?php
/**
 * Admin Reusable Header & HTML Head Component
 * Folder Location: admin/includes/header.php
 */

require_once __DIR__ . '/session.php';

// Enforce authentication guard on all admin pages incorporating header
check_admin_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - Admin Panel' : 'Car & Bike Pool - Admin Panel'; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Theme style (AdminLTE) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <!-- Custom styling tweaks for a modern, state-of-the-art admin experience -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #047857 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --danger-gradient:  linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            --card-radius: 10px;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* =========================================================
           SIDEBAR TOGGLE & EXPAND / COLLAPSE LAYOUT SYSTEM
           ========================================================= */

        /* 1. EXPANDED STATE (DEFAULT DESKTOP >= 992px) */
        @media (min-width: 992px) {
            body.sidebar-mini .main-sidebar,
            .main-sidebar {
                width: 250px !important;
                transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                overflow-x: hidden !important;
            }

            body.sidebar-mini .main-header,
            body.sidebar-mini .content-wrapper,
            body.sidebar-mini .main-footer {
                margin-left: 250px !important;
                width: calc(100% - 250px) !important;
                max-width: calc(100% - 250px) !important;
                transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1), width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                box-sizing: border-box !important;
            }

            /* 2. STRICT COLLAPSED STATE (when hamburger pushmenu is clicked) */
            body.sidebar-mini.sidebar-collapse .main-sidebar,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover,
            body.sidebar-mini.sidebar-collapse .main-sidebar .sidebar,
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar {
                width: 73px !important;
                min-width: 73px !important;
                max-width: 73px !important;
                overflow: visible !important;
                overflow-x: visible !important;
                overflow-y: visible !important;
            }

            body.sidebar-mini.sidebar-collapse .main-header,
            body.sidebar-mini.sidebar-collapse.sidebar-hover .main-header,
            body.sidebar-mini.sidebar-collapse .content-wrapper,
            body.sidebar-mini.sidebar-collapse.sidebar-hover .content-wrapper,
            body.sidebar-mini.sidebar-collapse .main-footer,
            body.sidebar-mini.sidebar-collapse.sidebar-hover .main-footer {
                margin-left: 73px !important;
                width: calc(100% - 73px) !important;
                max-width: calc(100% - 73px) !important;
            }

            /* Hide all text labels, info text, and headers in collapsed state strictly (hover & non-hover) */
            body.sidebar-mini.sidebar-collapse .main-sidebar .brand-text,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .brand-text,
            body.sidebar-mini.sidebar-collapse .main-sidebar .user-panel .info,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .user-panel .info,
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-header,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .nav-header,
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-link p,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-link p {
                display: none !important;
                opacity: 0 !important;
                visibility: hidden !important;
                width: 0 !important;
                height: 0 !important;
            }

            /* --- ELEMENT 1: TOP BRAND CAR LOGO HEADER --- */
            body.sidebar-mini.sidebar-collapse .main-sidebar .brand-link,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .brand-link,
            body.sidebar-mini.sidebar-collapse .main-sidebar .brand-link:hover {
                width: 73px !important;
                min-width: 73px !important;
                max-width: 73px !important;
                height: 57px !important;
                padding: 0 !important;
                margin: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                box-sizing: border-box !important;
                transform: none !important;
                transition: none !important;
            }

            body.sidebar-mini.sidebar-collapse .main-sidebar .brand-link i,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .brand-link i,
            body.sidebar-mini.sidebar-collapse .main-sidebar .brand-link:hover i,
            body.sidebar-mini.sidebar-collapse .main-sidebar .brand-link .fa-car-side,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .brand-link .fa-car-side {
                width: 24px !important;
                min-width: 24px !important;
                height: 24px !important;
                margin: 0 !important;
                padding: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                font-size: 1.35rem !important;
                opacity: 1 !important;
                visibility: visible !important;
                transform: none !important;
                transition: none !important;
                position: static !important;
            }

            /* --- ELEMENT 2: USER PROFILE PANEL --- */
            body.sidebar-mini.sidebar-collapse .main-sidebar .user-panel,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .user-panel {
                width: 73px !important;
                min-width: 73px !important;
                max-width: 73px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0.75rem 0 !important;
                margin: 0 !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            }

            body.sidebar-mini.sidebar-collapse .main-sidebar .user-panel .image,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .user-panel .image {
                width: 44px !important;
                min-width: 44px !important;
                height: 44px !important;
                padding: 0 !important;
                margin: 0 auto !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                transform: none !important;
                transition: none !important;
            }

            /* --- ELEMENT 3: NAV LIST ITEMS & BUTTONS (IN 1 VERTICAL AXIS) --- */
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-item,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-item {
                width: 73px !important;
                min-width: 73px !important;
                max-width: 73px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                position: relative !important;
                overflow: visible !important;
                margin: 0 !important;
                padding: 0 !important;
                transform: none !important;
                transition: none !important;
            }

            /* 44px x 44px Square Hover/Active Button (Stays 100% inside 73px sidebar) */
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-link,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-link,
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-link:hover,
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-link:focus {
                width: 44px !important;
                min-width: 44px !important;
                max-width: 44px !important;
                height: 44px !important;
                padding: 0 !important;
                margin: 4px auto !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 8px !important;
                overflow: hidden !important;
                box-sizing: border-box !important;
                float: none !important;
                transform: none !important;
                transition: background-color 0.15s ease, color 0.15s ease !important;
                position: relative !important;
            }

            /* Icon fixed 24px width container for perfect vertical center alignment */
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-link .nav-icon,
            body.sidebar-mini.sidebar-collapse .main-sidebar:hover .nav-sidebar .nav-link .nav-icon,
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-link:hover .nav-icon {
                width: 24px !important;
                min-width: 24px !important;
                height: 24px !important;
                margin: 0 !important;
                padding: 0 !important;
                font-size: 1.2rem !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                float: none !important;
                transform: none !important;
                transition: none !important;
                position: static !important;
            }

            /* --- ELEMENT 4: FLOATING TOOLTIP LABEL TO THE RIGHT --- */
            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-item[data-title]:hover::after {
                content: attr(data-title);
                position: absolute;
                left: calc(100% + 10px);
                top: 50%;
                transform: translateY(-50%);
                background: #0f172a;
                color: #ffffff;
                padding: 6px 14px;
                border-radius: 6px;
                font-size: 0.82rem;
                font-weight: 600;
                white-space: nowrap;
                box-shadow: 0 4px 18px rgba(0, 0, 0, 0.35);
                z-index: 999999 !important;
                pointer-events: none;
                animation: fadeInSidebarTooltip 0.18s ease-out forwards;
            }

            body.sidebar-mini.sidebar-collapse .main-sidebar .nav-sidebar .nav-item[data-title]:hover::before {
                content: '';
                position: absolute;
                left: calc(100% + 3px);
                top: 50%;
                transform: translateY(-50%);
                border-width: 6px 7px 6px 0;
                border-style: solid;
                border-color: transparent #0f172a transparent transparent;
                z-index: 999999 !important;
                pointer-events: none;
            }

            @keyframes fadeInSidebarTooltip {
                from { opacity: 0; transform: translateY(-50%) translateX(-6px); }
                to   { opacity: 1; transform: translateY(-50%) translateX(0); }
            }
        }

        html, body {
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden !important;
            background-color: #f4f6f9;
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .wrapper {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: hidden !important;
        }

        .content-wrapper {
            padding: 0.75rem 1.25rem !important;
            background-color: #f4f6f9;
            min-height: calc(100vh - 57px) !important;
            box-sizing: border-box !important;
            overflow-x: hidden !important;
        }

        .container-fluid {
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin: 0 !important;
            box-sizing: border-box !important;
        }

        /* Stat Cards Grid */
        .stat-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        @media (max-width: 1199px) {
            .stat-cards-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575px) {
            .stat-cards-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card-compact {
            background: #ffffff;
            border-radius: 10px;
            padding: 0.9rem 1.1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card-compact:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }

        .stat-card-compact .stat-num {
            font-size: 1.65rem;
            font-weight: 800;
            line-height: 1.1;
            color: #0f172a;
        }

        .stat-card-compact .stat-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0.2rem;
        }

        .stat-card-compact .stat-link {
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-top: 0.35rem;
        }

        .stat-card-compact .stat-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        /* Stat Card Colors */
        .stat-card-info .stat-icon-box { background: #e0f2fe; color: #0284c7; }
        .stat-card-info .stat-link { color: #0284c7; }

        .stat-card-success .stat-icon-box { background: #dcfce7; color: #16a34a; }
        .stat-card-success .stat-link { color: #16a34a; }

        .stat-card-warning .stat-icon-box { background: #fef3c7; color: #d97706; }
        .stat-card-warning .stat-link { color: #d97706; }

        .stat-card-danger .stat-icon-box { background: #fee2e2; color: #dc2626; }
        .stat-card-danger .stat-link { color: #dc2626; }

        /* Recent Cards Grid */
        .dash-grid-2col {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        @media (max-width: 1199px) {
            .dash-grid-2col {
                grid-template-columns: 1fr;
            }
        }

        .dash-panel {
            background: #ffffff;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .dash-panel .panel-header {
            padding: 0.8rem 1.1rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
        }

        .dash-panel .panel-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .dash-panel .panel-body {
            padding: 0;
            flex: 1 1 auto;
            overflow-x: hidden;
        }

        /* Table Styling */
        .table-compact {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table-compact th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.73rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.65rem 0.5rem;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .table-compact td {
            padding: 0.65rem 0.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.84rem;
            color: #334155;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table-compact td.text-center {
            overflow: visible !important;
        }

        .table-compact tr:last-child td {
            border-bottom: none;
        }

        .table-compact tr:hover td {
            background: #f8fafc;
        }

        /* Badges & Truncations */
        .badge-pill-sm {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.25em 0.6em;
            border-radius: 50rem;
            display: inline-block;
            text-transform: capitalize;
            white-space: nowrap;
            max-width: 100%;
        }

        .badge-active    { background-color: #e0f2fe; color: #0369a1; }
        .badge-completed { background-color: #dcfce7; color: #15803d; }
        .badge-cancelled { background-color: #fee2e2; color: #b91c1c; }
        .badge-pending   { background-color: #fef3c7; color: #b45309; }

        .code-pill {
            font-family: SFMono-Regular, Consolas, monospace;
            font-size: 0.78rem;
            background: #f1f5f9;
            color: #475569;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            display: inline-block;
            max-width: 110px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: middle;
        }

        .text-truncate-custom {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
