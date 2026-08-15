<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/config.php';
require_once 'includes/revenue_report.php';

$pageTitle = "Reports";

/*
|--------------------------------------------------------------------------
| Report Type
|--------------------------------------------------------------------------
*/

$reportType = $_GET['report'] ?? 'revenue';

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


/*
|--------------------------------------------------------------------------
| Date Range
|--------------------------------------------------------------------------
*/

$dateRange = $_GET['range'] ?? '30';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= $pageTitle ?> | <?= APP_NAME ?></title>


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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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


        <!-- ==========================================
             PAGE HEADER
        =========================================== -->

        <div class="report-page-header">

            <div>

                <h2>Reports & Analytics</h2>

                <p>
                    Analyze business performance and generate detailed reports.
                </p>

            </div>


            <div>

                <button
                    type="button"
                    class="report-refresh-btn"
                    onclick="window.location.reload();">

                    <i class="bi bi-arrow-clockwise"></i>

                    Refresh

                </button>

            </div>

        </div>



        <!-- ==========================================
             GENERAL REPORT CONTROLS
        =========================================== -->

        <div class="report-filter-card">


            <div class="report-filter-header">

                <div>

                    <h4>Generate Report</h4>

                    <p>
                        Select the report type and date range.
                    </p>

                </div>

            </div>



            <form
                method="GET"
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


                            <option
                                value="7"
                                <?= $dateRange === '7' ? 'selected' : '' ?>>

                                Last 7 Days

                            </option>


                            <option
                                value="30"
                                <?= $dateRange === '30' ? 'selected' : '' ?>>

                                Last 30 Days

                            </option>


                            <option
                                value="90"
                                <?= $dateRange === '90' ? 'selected' : '' ?>>

                                Last 3 Months

                            </option>


                            <option
                                value="365"
                                <?= $dateRange === '365' ? 'selected' : '' ?>>

                                Last 12 Months

                            </option>


                            <option
                                value="all"
                                <?= $dateRange === 'all' ? 'selected' : '' ?>>

                                All Time

                            </option>


                        </select>

                    </div>

                </div>



                <!-- Empty Space -->

                <div class="report-filter-empty"></div>



                <!-- Generate -->

                <div class="report-filter-group">

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



        <!-- ==========================================
             REPORT CONTENT
        =========================================== -->

        <div class="report-content">


            <?php if ($reportType === 'revenue'): ?>


                <!-- ==================================
                     REVENUE REPORT
                =================================== -->

                <div class="report-section">


                    <div class="report-section-header">

                        <div>

                            <h3>

                                <i class="bi bi-currency-rupee"></i>

                                Revenue Report

                            </h3>

                            <p>
                                Revenue performance for the selected period.
                            </p>

                        </div>


                        <div class="report-actions">

                            <a href="export_revenue_excel.php" class="report-export-btn">
        <i class="bi bi-file-earmark-spreadsheet"></i>
        Export Excel
    </a>

    <a href="export_revenue_csv.php" class="report-export-btn">
        <i class="bi bi-filetype-csv"></i>
        Export CSV
    </a>

                        </div>

                    </div>



                    <!-- Revenue Specific Filters -->

                    



                    <!-- Revenue Summary -->

                    <div class="report-summary-grid">


                        <div class="report-summary-card">

                            <div class="report-summary-icon purple">

                                <i class="bi bi-currency-rupee"></i>

                            </div>

                            <div>

                                <span>Total Revenue</span>

                                <strong>
    ₹<?= number_format($totalRevenue, 2) ?>
</strong>
                            </div>

                        </div>



                        <div class="report-summary-card">

                            <div class="report-summary-icon green">

                                <i class="bi bi-graph-up"></i>

                            </div>

                            <div>

                                <span>Average Fare</span>

                               <strong>
    ₹<?= number_format($averageFare, 2) ?>
</strong>

                            </div>

                        </div>



                        <div class="report-summary-card">

                            <div class="report-summary-icon blue">

                                <i class="bi bi-check-circle"></i>

                            </div>

                            <div>

                                <span>Completed Trips</span>

                               <strong>
    <?= number_format($completedTrips) ?>
</strong>

                            </div>

                        </div>



                        <div class="report-summary-card">

                            <div class="report-summary-icon orange">

                                <i class="bi bi-receipt"></i>

                            </div>

                            <div>

                                <span>Total Transactions</span>

                                <strong>
    <?= number_format($totalTransactions) ?>
</strong>

                            </div>

                        </div>


                    </div>



                    <!-- Charts -->

                    <div class="report-chart-grid">


                        <div class="report-chart-card">

    <div class="chart-card-header">

        <div>

            <h4>Revenue Trend</h4>

            <p>
                Revenue generated over time
            </p>

        </div>

    </div>


   <div class="chart-container">
    <canvas id="revenueTrendChart"></canvas>
</div>
</div>



                        <div class="report-chart-card">

                            <div class="chart-card-header">

                                <div>

                                    <h4>Revenue by Route</h4>

                                    <p>
                                        Revenue distribution by route
                                    </p>

                                </div>

                            </div>


                           <div class="chart-container">
    <canvas id="revenueRouteChart"></canvas>
</div>

                        </div>


                    </div>



                   <div class="report-table-card">
<div class="report-table-header">

    <div>

        <h4>Revenue Details</h4>

        <p>
            Latest revenue transactions.
        </p>

    </div>

    <a href="revenue_details.php" class="view-all-btn">

        <i class="bi bi-list-ul"></i>

        View All

    </a>

</div>


    <div class="table-responsive">

        <table class="table report-table">

            <thead>

                <tr>

                    <th>Booking ID</th>

                    <th>Passenger</th>

                    <th>Route</th>

                    <th>Fare</th>

                    <th>Status</th>

                    <th>Date</th>

                </tr>

            </thead>


            <tbody>

            <?php if (!empty($revenueData)): ?>

                <?php foreach ($revenueData as $revenue): ?>

                    <?php

                    $status = strtolower(
                        trim($revenue['ride_status'])
                    );

                    switch ($status) {

                        case 'completed':

                            $statusClass = 'status-completed';
                            $statusIcon = 'bi-patch-check-fill';
                            $statusText = 'Completed';

                            break;


                        case 'active':

                            $statusClass = 'status-active';
                            $statusIcon = 'bi-play-circle-fill';
                            $statusText = 'Active';

                            break;


                        case 'started':

                            $statusClass = 'status-accepted';
                            $statusIcon = 'bi-play-fill';
                            $statusText = 'Started';

                            break;


                        case 'cancelled':

                            $statusClass = 'status-cancelled';
                            $statusIcon = 'bi-x-circle-fill';
                            $statusText = 'Cancelled';

                            break;


                        case 'full':

                            $statusClass = 'status-pending';
                            $statusIcon = 'bi-people-fill';
                            $statusText = 'Full';

                            break;


                        default:

                            $statusClass = 'status-default';
                            $statusIcon = 'bi-dash-circle-fill';
                            $statusText = ucfirst($status);

                            break;

                    }

                    ?>

                    <tr>

                        <!-- Booking ID -->

                        <td>

                            <?= htmlspecialchars(
                                $revenue['booking_code']
                            ) ?>

                        </td>


                        <!-- Passenger -->

                        <td>

                            <?= htmlspecialchars(
                                $revenue['full_name']
                            ) ?>

                        </td>


                        <!-- Route -->

                        <td>

                            <?= htmlspecialchars(
                                $revenue['pickup_address']
                            ) ?>

                            <span class="route-arrow">
                                →
                            </span>

                            <?= htmlspecialchars(
                                $revenue['destination_address']
                            ) ?>

                        </td>


                        <!-- Fare -->

                        <td>

                            ₹<?= number_format(
                                (float)$revenue['total_fare'],
                                2
                            ) ?>

                        </td>


                        <!-- Status -->

                        <td>

                            <span
                                class="status-badge <?= $statusClass ?>"
                            >

                                <i
                                    class="bi <?= $statusIcon ?>"
                                ></i>

                                <?= $statusText ?>

                            </span>

                        </td>


                        <!-- Date -->

                        <td>

                            <?= date(
                                'd M Y',
                                strtotime(
                                    $revenue['created_at']
                                )
                            ) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>


            <?php else: ?>

                <tr>

                    <td
                        colspan="6"
                        class="text-center text-muted py-5"
                    >

                        <i class="bi bi-receipt fs-3 d-block mb-2"></i>

                        No revenue transactions found
                        for the selected period.

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>


            <?php else: ?>


                <!-- ==================================
                     OTHER REPORTS
                =================================== -->

                <div class="report-section report-coming-soon">


                    <div class="report-coming-icon">

                        <?php

                        $icons = [

                            'bookings' => 'bi-calendar-check',

                            'rides' => 'bi-car-front',

                            'users' => 'bi-people',

                            'drivers' => 'bi-person-badge',

                            'payments' => 'bi-credit-card'

                        ];

                        ?>


                        <i class="bi <?= $icons[$reportType] ?>"></i>

                    </div>


                    <h3>

                        <?= ucfirst($reportType) ?> Report

                    </h3>


                    <p>

                        This report will use the selected date range
                        and report-specific filters.

                    </p>


                </div>


            <?php endif; ?>


        </div>

    </div>

</main>



<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>


<!-- Existing JS -->

<script src="assets/js/main.js"></script>


<!-- Reports JS -->

<script src="assets/js/reports.js"></script>


</body>

</html>