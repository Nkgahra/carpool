<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | CarPool Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/variables.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">

</head>

<body>

<?php
require_once 'includes/dashboard_queries.php';
?>

<!-- Sidebar -->
<?php include 'components/sidebar.php'; ?>

<!-- Navbar -->
<?php include 'components/navbar.php'; ?>

<main class="main-content">

<div class="container-fluid">

    <!-- Page Header -->

    <div class="page-header">

        <div>

            <h2>Dashboard</h2>

            <p>Welcome back, Admin 👋</p>

        </div>

    </div>

    <!-- Statistics -->

    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-icon purple">
                <i class="bi bi-people-fill"></i>
            </div>

            <div class="stat-content">

                <h3><?= number_format($totalUsers) ?></h3>

                <span>Total Users</span>

            </div>

        </div>

        <div class="stat-card">

            <div class="stat-icon blue">
                <i class="bi bi-car-front-fill"></i>
            </div>

            <div class="stat-content">

                <h3><?= number_format($totalActiveRides) ?></h3>

                <span>Active Rides</span>

            </div>

        </div>

        <div class="stat-card">

            <div class="stat-icon green">
                <i class="bi bi-calendar-check-fill"></i>
            </div>

            <div class="stat-content">

                <h3><?= number_format($totalBookings) ?></h3>

                <span>Total Bookings</span>

            </div>

        </div>

        <div class="stat-card">

            <div class="stat-icon orange">
                <i class="bi bi-currency-rupee"></i>
            </div>

            <div class="stat-content">

                <h3>₹<?= number_format($totalRevenue,2) ?></h3>

                <span>Total Revenue</span>

            </div>

        </div>

    </div>

    <!-- Dashboard Grid -->

    <div class="dashboard-grid">

        <!-- Recent Bookings -->

        <div class="dashboard-card">

            <div class="card-header">

                <h4>Recent Bookings</h4>

                <a href="bookings.php" class="btn btn-primary btn-sm">

                    View All

                </a>

            </div>

            <div class="table-responsive">

                <table class="table booking-table align-middle">

                    <thead>

                        <tr>

                            <th>Booking ID</th>
<th>Passenger</th>
<th>Route</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Fare</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(!empty($recentBookings)): ?>

                        <?php foreach($recentBookings as $booking): ?>

                        <?php

                        $status = strtolower(trim($booking['ride_status']));

                        switch($status){

                            case 'active':
        $class = "status-active";
        $icon  = "bi-play-circle-fill";
        $text  = "Active";
    break;

    case 'started':
        $class = "status-started";
        $icon  = "bi-arrow-right-circle-fill";
        $text  = "Started";
    break;

    case 'completed':
        $class = "status-completed";
        $icon  = "bi-patch-check-fill";
        $text  = "Completed";
    break;

    case 'cancelled':
        $class = "status-cancelled";
        $icon  = "bi-x-circle-fill";
        $text  = "Cancelled";
    break;

    case 'full':
        $class = "status-full";
        $icon  = "bi-people-fill";
        $text  = "Full";
    break;

                            default:

                                $class="status-default";
                                $icon="bi-dash-circle-fill";
                                $text=ucfirst($booking['booking_status']);

                        }

                        ?>

                        <tr>

    <td>
        <?= htmlspecialchars($booking['booking_code']) ?>
    </td>

    <td>
        <strong><?= htmlspecialchars($booking['full_name']) ?></strong>
    </td>

    <td>
        <small class="text-muted">
            <i class="bi bi-geo-alt-fill text-danger"></i>
            <?= htmlspecialchars($booking['pickup_address']) ?>
        </small>

        <br>

        <small class="text-muted">
            <i class="bi bi-arrow-right"></i>

            <?= htmlspecialchars($booking['destination_address']) ?>
        </small>
    </td>

    <td>
        <?= date('d M Y', strtotime($booking['ride_date'])) ?>
    </td>

    <td>
        <?= date('h:i A', strtotime($booking['ride_time'])) ?>
    </td>

    <td>

        <span class="status-badge <?= $class ?>">

            <i class="bi <?= $icon ?>"></i>

            <?= $text ?>

        </span>

    </td>

    <td>
        <strong>₹<?= number_format($booking['total_fare'],2) ?></strong>
    </td>

</tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="4" class="text-center text-muted py-4">

                                No recent bookings found.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

               <div class="dashboard-card">

            <div class="card-header">

                <h4>Recent Activity</h4>

            </div>

            <div class="activity-list">

                <?php if(!empty($recentActivities)): ?>

                    <?php foreach($recentActivities as $activity): ?>

                        <div class="activity-item">

                            <i class="bi <?= htmlspecialchars($activity['icon']) ?> text-<?= htmlspecialchars($activity['color']) ?>"></i>

                            <div class="activity-content">

                                <strong><?= htmlspecialchars($activity['title']) ?></strong>

                                <p><?= htmlspecialchars($activity['description']) ?></p>

                            </div>

                            <small>

                                <?= date('d M H:i', $activity['time']) ?>

                            </small>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="text-center text-muted py-4">

                        No recent activity found.

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/main.js"></script>

</body>

</html>