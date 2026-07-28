<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | CarPool Admin</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
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

    <!-- Main Content -->
    <main class="main-content">

    <div class="container-fluid">

        <!-- Page Header -->

        <div class="page-header">

            <div>

                <h2>Dashboard</h2>

                <p>Welcome back, Admin 👋</p>

            </div>

        </div>

        <!-- Statistics Cards -->

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
                    <h3>₹<?= number_format($totalRevenue, 2) ?></h3>
                    <span>Total Revenue</span>
                </div>

            </div>

        </div>

        <!-- Analytics Section -->

        <div class="dashboard-grid">

            <!-- Chart -->

            <div class="dashboard-card chart-card">

                <div class="card-header">

                    <h4>Monthly Ride Analytics</h4>

                    <button class="btn btn-sm btn-outline-primary">

                        This Year

                    </button>

                </div>

                <canvas id="ridesChart"></canvas>

            </div>

            <!-- Recent Activity -->

            <div class="dashboard-card">

                <div class="card-header">

                    <h4>Recent Activity</h4>

                </div>

                <div class="activity-list">

<?php foreach($recentActivities as $activity): ?>

<div class="activity-item">

    <i class="bi <?= $activity['icon']; ?> text-<?= $activity['color']; ?>"></i>

    <div>

        <strong><?= htmlspecialchars($activity['title']); ?></strong>

        <p><?= htmlspecialchars($activity['description']); ?></p>

    </div>

    <small>

        <?= date('d M H:i', $activity['time']); ?>

    </small>

</div>

<?php endforeach; ?>

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