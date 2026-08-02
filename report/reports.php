<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/config.php';

// Default report
$reportType = $_GET['report'] ?? 'revenue';

// Allowed reports
$allowedReports = [
    'revenue',
    'bookings',
    'rides',
    'users',
    'drivers',
    'payments'
];

if (!in_array($reportType, $allowedReports)) {
    $reportType = 'revenue';
}

$pageTitle = "Reports";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Reports | CarPool Admin</title>

    <!-- Google Font -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Existing CSS -->

    <link rel="stylesheet"
          href="assets/css/variables.css">

    <link rel="stylesheet"
          href="assets/css/style.css">

    <link rel="stylesheet"
          href="assets/css/navbar.css">

    <link rel="stylesheet"
          href="assets/css/sidebar.css">

    <!-- Reports CSS -->

    <link rel="stylesheet"
          href="assets/css/reports.css">

</head>

<body>

<!-- Sidebar -->

<?php include 'components/sidebar.php'; ?>


<!-- Navbar -->

<?php include 'components/navbar.php'; ?>


<!-- Main Content -->

<main class="main-content">

    <div class="container-fluid">

        <!-- =========================================
             REPORT PAGE HEADER
        ========================================== -->

        <div class="report-page-header">

            <div>

                <h2>Reports & Analytics</h2>

                <p>
                    Analyze business performance and generate detailed reports.
                </p>

            </div>

            <div class="report-header-actions">

                <button
                    type="button"
                    class="report-refresh-btn"
                    onclick="window.location.reload();">

                    <i class="bi bi-arrow-clockwise"></i>

                    Refresh

                </button>

            </div>

        </div>


        <!-- =========================================
             REPORT CONTROLS
        ========================================== -->

        <div class="report-filter-card">

            <div class="report-filter-header">

                <div>

                    <h4>Generate Report</h4>

                    <p>
                        Select the report and filters you want to analyze.
                    </p>

                </div>

            </div>


            <form method="GET"
                  action="reports.php"
                  class="report-filter-grid">


                <!-- Report Type -->

                <div class="report-filter-group">

                    <label for="report">

                        Report Type

                    </label>

                    <div class="report-select-wrapper">

                        <i class="bi bi-bar-chart-line"></i>

                        <select
                            name="report"
                            id="report"
                            class="report-select">

                            <option
                                value="revenue"
                                <?= $reportType === 'revenue' ? 'selected' : '' ?>>

                                Revenue Report

                            </option>

                            <option
                                value="bookings"
                                <?= $reportType === 'bookings' ? 'selected' : '' ?>>

                                Bookings Report

                            </option>

                            <option
                                value="rides"
                                <?= $reportType === 'rides' ? 'selected' : '' ?>>

                                Rides Report

                            </option>

                            <option
                                value="users"
                                <?= $reportType === 'users' ? 'selected' : '' ?>>

                                Users Report

                            </option>

                            <option
                                value="drivers"
                                <?= $reportType === 'drivers' ? 'selected' : '' ?>>

                                Drivers Report

                            </option>

                            <option
                                value="payments"
                                <?= $reportType === 'payments' ? 'selected' : '' ?>>

                                Payments Report

                            </option>

                        </select>

                    </div>

                </div>


                <!-- Date Range -->

                <div class="report-filter-group">

                    <label for="range">

                        Date Range

                    </label>

                    <div class="report-select-wrapper">

                        <i class="bi bi-calendar3"></i>

                        <select
                            name="range"
                            id="range"
                            class="report-select">

                            <option value="7">
                                Last 7 Days
                            </option>

                            <option value="30" selected>
                                Last 30 Days
                            </option>

                            <option value="90">
                                Last 3 Months
                            </option>

                            <option value="365">
                                Last 12 Months
                            </option>

                            <option value="all">
                                All Time
                            </option>

                        </select>

                    </div>

                </div>


                <!-- Status -->

                <div class="report-filter-group">

                    <label for="status">

                        Status

                    </label>

                    <div class="report-select-wrapper">

                        <i class="bi bi-funnel"></i>

                        <select
                            name="status"
                            id="status"
                            class="report-select">

                            <option value="all">
                                All Status
                            </option>

                            <option value="active">
                                Active
                            </option>

                            <option value="started">
                                Started
                            </option>

                            <option value="full">
                                Full
                            </option>

                            <option value="completed">
                                Completed
                            </option>

                            <option value="cancelled">
                                Cancelled
                            </option>

                        </select>

                    </div>

                </div>


                <!-- Generate -->

                <div class="report-filter-group report-generate-group">

                    <label>&nbsp;</label>

                    <button
                        type="submit"
                        class="generate-report-btn">

                        <i class="bi bi-graph-up-arrow"></i>

                        Generate Report

                    </button>

                </div>

            </form>

        </div>


        <!-- =========================================
             DYNAMIC REPORT CONTENT
        ========================================== -->

        <div class="report-content">

            <?php

            switch ($reportType) {

                case 'bookings':

                    ?>

                    <div class="report-placeholder">

                        <i class="bi bi-calendar-check"></i>

                        <h3>Bookings Report</h3>

                        <p>
                            Booking analytics will appear here.
                        </p>

                    </div>

                    <?php

                    break;


                case 'rides':

                    ?>

                    <div class="report-placeholder">

                        <i class="bi bi-car-front"></i>

                        <h3>Rides Report</h3>

                        <p>
                            Ride analytics will appear here.
                        </p>

                    </div>

                    <?php

                    break;


                case 'users':

                    ?>

                    <div class="report-placeholder">

                        <i class="bi bi-people"></i>

                        <h3>Users Report</h3>

                        <p>
                            User analytics will appear here.
                        </p>

                    </div>

                    <?php

                    break;


                case 'drivers':

                    ?>

                    <div class="report-placeholder">

                        <i class="bi bi-person-badge"></i>

                        <h3>Drivers Report</h3>

                        <p>
                            Driver analytics will appear here.
                        </p>

                    </div>

                    <?php

                    break;


                case 'payments':

                    ?>

                    <div class="report-placeholder">

                        <i class="bi bi-credit-card"></i>

                        <h3>Payments Report</h3>

                        <p>
                            Payment analytics will appear here.
                        </p>

                    </div>

                    <?php

                    break;


                case 'revenue':

                default:

                    ?>

                    <!-- Revenue is the DEFAULT report -->

                    <div class="report-placeholder revenue-placeholder">

                        <div class="placeholder-icon">

                            <i class="bi bi-currency-rupee"></i>

                        </div>

                        <h3>Revenue Report</h3>

                        <p>
                            Revenue analytics are ready to be generated.
                        </p>

                    </div>

                    <?php

                    break;

            }

            ?>

        </div>

    </div>

</main>


<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>


<!-- Chart.js -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- Existing JS -->

<script src="assets/js/main.js"></script>


<!-- Reports JS -->

<script src="assets/js/reports.js"></script>

</body>

</html>