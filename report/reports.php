    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once 'config/config.php';

    $pageTitle = "Reports";
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= $pageTitle ?> | <?= APP_NAME ?></title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Common CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/sidebar.css">
        <link rel="stylesheet" href="assets/css/navbar.css">
        <link rel="stylesheet" href="assets/css/responsive.css">

        <!-- Reports CSS -->
        <link rel="stylesheet" href="assets/css/reports.css">

    </head>

    <body>

    <div class="wrapper">

        <?php include 'components/sidebar.php'; ?>

        <div class="main-content">

            <?php include 'components/navbar.php'; ?>

            <div class="container-fluid py-4">

                <!-- Page Header -->
               <div class="page-header d-flex justify-content-between align-items-center">

    <div>

        <h2>Reports & Analytics</h2>

        <p>
            Generate reports, visualize business performance and export insights.
        </p>

    </div>

    <button class="btn btn-primary refresh-btn">

        <i class="bi bi-arrow-clockwise"></i>

        Refresh

    </button>

</div>
<div class="row g-4 mt-1">

    <div class="col-lg-3 col-md-6">

        <div class="kpi-card">

            <div class="kpi-icon">

                <i class="bi bi-currency-rupee"></i>

            </div>

            <div class="kpi-title">Total Revenue</div>

            <div class="kpi-value">₹2.45L</div>

            <div class="kpi-growth">

                <i class="bi bi-arrow-up"></i>

                +18%

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="kpi-card">

            <div class="kpi-icon">

                <i class="bi bi-journal-check"></i>

            </div>

            <div class="kpi-title">Bookings</div>

            <div class="kpi-value">1,245</div>

            <div class="kpi-growth">

                <i class="bi bi-arrow-up"></i>

                +11%

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="kpi-card">

            <div class="kpi-icon">

                <i class="bi bi-people"></i>

            </div>

            <div class="kpi-title">Users</div>

            <div class="kpi-value">856</div>

            <div class="kpi-growth">

                <i class="bi bi-arrow-up"></i>

                +7%

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="kpi-card">

            <div class="kpi-icon">

                <i class="bi bi-car-front"></i>

            </div>

            <div class="kpi-title">Completed Rides</div>

            <div class="kpi-value">328</div>

            <div class="kpi-growth">

                <i class="bi bi-arrow-up"></i>

                +22%

            </div>

        </div>

    </div>

</div>

                <!-- Content Starts Here -->

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/reports.js"></script>

    </body>
    </html>