<?php
/**
 * Admin Dashboard Page
 * Folder Location: admin/dashboard.php
 */

require_once '../config/database.php';
$page_title = "Dashboard";
require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once 'includes/sidebar.php';

// 1. Fetch Count Statistics
$total_rides = 0;
$total_bookings = 0;
$total_users = 0;
$total_vehicles = 0;

$res1 = $conn->query("SELECT COUNT(*) AS total FROM rides");
if ($res1) { $total_rides = $res1->fetch_assoc()['total']; }

$res2 = $conn->query("SELECT COUNT(*) AS total FROM ride_bookings");
if ($res2) { $total_bookings = $res2->fetch_assoc()['total']; }

$res3 = $conn->query("SELECT COUNT(*) AS total FROM users");
if ($res3) { $total_users = $res3->fetch_assoc()['total']; }

$res4 = $conn->query("SELECT COUNT(*) AS total FROM vehicles");
if ($res4) { $total_vehicles = $res4->fetch_assoc()['total']; }

// 2. Fetch Recent Rides (Top 5)
$recent_rides = [];
$rides_sql = "SELECT r.*, u.full_name AS driver_name 
              FROM rides r 
              LEFT JOIN users u ON r.driver_id = u.id 
              ORDER BY r.id DESC LIMIT 5";
$rides_res = $conn->query($rides_sql);
if ($rides_res) {
    while ($row = $rides_res->fetch_assoc()) {
        $recent_rides[] = $row;
    }
}

// 3. Fetch Recent Bookings (Top 5)
$recent_bookings = [];
$bookings_sql = "SELECT b.*, u.full_name AS passenger_name, r.ride_code 
                 FROM ride_bookings b 
                 LEFT JOIN users u ON b.passenger_id = u.id 
                 LEFT JOIN rides r ON b.ride_id = r.id 
                 ORDER BY b.id DESC LIMIT 5";
$bookings_res = $conn->query($bookings_sql);
if ($bookings_res) {
    while ($row = $bookings_res->fetch_assoc()) {
        $recent_bookings[] = $row;
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header py-2 mb-2">
    <div class="container-fluid">
      <?php display_flash_message(); ?>
      <div class="row align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold text-dark" style="font-size: 1.45rem;">
            <i class="fas fa-chart-line text-primary mr-2"></i>Admin Dashboard
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right bg-transparent p-0 m-0 text-sm">
            <li class="breadcrumb-item"><a href="dashboard.php" class="text-primary font-weight-bold">Home</a></li>
            <li class="breadcrumb-item active text-muted">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <!-- 4 Metric Cards Grid -->
      <div class="stat-cards-grid">
        <!-- Card 1: Total Rides -->
        <div class="stat-card-compact stat-card-info">
          <div class="stat-info">
            <div class="stat-num"><?php echo number_format($total_rides); ?></div>
            <div class="stat-title">Total Rides</div>
            <a href="rides/ride_list.php" class="stat-link">View All <i class="fas fa-arrow-right ml-1"></i></a>
          </div>
          <div class="stat-icon-box">
            <i class="fas fa-car"></i>
          </div>
        </div>

        <!-- Card 2: Total Bookings -->
        <div class="stat-card-compact stat-card-success">
          <div class="stat-info">
            <div class="stat-num"><?php echo number_format($total_bookings); ?></div>
            <div class="stat-title">Total Bookings</div>
            <a href="bookings/booking_list.php" class="stat-link">View All <i class="fas fa-arrow-right ml-1"></i></a>
          </div>
          <div class="stat-icon-box">
            <i class="fas fa-ticket-alt"></i>
          </div>
        </div>

        <!-- Card 3: Total Users -->
        <div class="stat-card-compact stat-card-warning">
          <div class="stat-info">
            <div class="stat-num"><?php echo number_format($total_users); ?></div>
            <div class="stat-title">Registered Users</div>
            <a href="#" class="stat-link">Users List <i class="fas fa-users ml-1"></i></a>
          </div>
          <div class="stat-icon-box">
            <i class="fas fa-users"></i>
          </div>
        </div>

        <!-- Card 4: Total Vehicles -->
        <div class="stat-card-compact stat-card-danger">
          <div class="stat-info">
            <div class="stat-num"><?php echo number_format($total_vehicles); ?></div>
            <div class="stat-title">Registered Vehicles</div>
            <a href="#" class="stat-link">Vehicles List <i class="fas fa-car-alt ml-1"></i></a>
          </div>
          <div class="stat-icon-box">
            <i class="fas fa-motorcycle"></i>
          </div>
        </div>
      </div>

      <!-- 2 Column Tables Grid -->
      <div class="dash-grid-2col">
        
        <!-- Recent Rides Panel -->
        <div class="dash-panel">
          <div class="panel-header">
            <span class="panel-title">
              <i class="fas fa-route text-primary mr-2"></i>Recent Rides
            </span>
            <a href="rides/ride_list.php" class="btn btn-xs btn-outline-primary font-weight-bold px-2 py-1" style="border-radius: 6px;">
              View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
          <div class="panel-body">
            <table class="table-compact">
              <thead>
                <tr>
                  <th style="width: 7%;">ID</th>
                  <th style="width: 17%;">Driver</th>
                  <th style="width: 33%;">Route</th>
                  <th style="width: 20%;">Date & Time</th>
                  <th style="width: 9%;">Fare</th>
                  <th style="width: 14%; text-align: center;">Status</th>
                </tr>
              </thead>
              <tbody>
              <?php if (!empty($recent_rides)): ?>
                <?php foreach ($recent_rides as $ride): ?>
                  <tr>
                    <td><span class="font-weight-bold text-dark">#<?php echo $ride['id']; ?></span></td>
                    <td title="<?php echo htmlspecialchars($ride['driver_name'] ?? 'N/A'); ?>">
                      <span class="font-weight-bold text-dark text-truncate-custom"><?php echo htmlspecialchars($ride['driver_name'] ?? 'N/A'); ?></span>
                    </td>
                    <td>
                      <div class="text-truncate-custom" title="Pickup: <?php echo htmlspecialchars($ride['pickup_address']); ?>">
                        <i class="fas fa-map-marker-alt text-success mr-1"></i><?php echo htmlspecialchars($ride['pickup_address']); ?>
                      </div>
                      <div class="text-truncate-custom text-muted" title="Destination: <?php echo htmlspecialchars($ride['destination_address']); ?>">
                        <i class="fas fa-flag-checkered text-danger mr-1"></i><?php echo htmlspecialchars($ride['destination_address']); ?>
                      </div>
                    </td>
                    <td>
                      <div class="font-weight-bold text-dark" style="font-size: 0.82rem;"><?php echo date('d M Y', strtotime($ride['ride_date'])); ?></div>
                      <small class="text-muted"><?php echo date('h:i A', strtotime($ride['ride_time'])); ?></small>
                    </td>
                    <td><span class="font-weight-bold text-dark">₹<?php echo number_format($ride['fare'], 0); ?></span></td>
                    <td class="text-center">
                      <?php 
                        $st = strtolower($ride['status']);
                        $badge_class = 'badge-active';
                        if (in_array($st, ['completed'])) $badge_class = 'badge-completed';
                        elseif (in_array($st, ['cancelled'])) $badge_class = 'badge-cancelled';
                        elseif (in_array($st, ['full', 'started', 'driver_reached'])) $badge_class = 'badge-pending';
                      ?>
                      <span class="badge-pill-sm <?php echo $badge_class; ?>"><?php echo ucfirst($ride['status']); ?></span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No recent rides found.</td></tr>
              <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Recent Bookings Panel -->
        <div class="dash-panel">
          <div class="panel-header">
            <span class="panel-title">
              <i class="fas fa-ticket-alt text-success mr-2"></i>Recent Bookings
            </span>
            <a href="bookings/booking_list.php" class="btn btn-xs btn-outline-success font-weight-bold px-2 py-1" style="border-radius: 6px;">
              View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
          <div class="panel-body">
            <table class="table-compact">
              <thead>
                <tr>
                  <th style="width: 8%;">ID</th>
                  <th style="width: 19%;">Passenger</th>
                  <th style="width: 22%;">Ride Code</th>
                  <th style="width: 10%; text-align: center;">Seats</th>
                  <th style="width: 13%;">Fare</th>
                  <th style="width: 28%; text-align: center;">Status</th>
                </tr>
              </thead>
              <tbody>
              <?php if (!empty($recent_bookings)): ?>
                <?php foreach ($recent_bookings as $booking): ?>
                  <tr>
                    <td><span class="font-weight-bold text-dark">#<?php echo $booking['id']; ?></span></td>
                    <td title="<?php echo htmlspecialchars($booking['passenger_name'] ?? 'N/A'); ?>">
                      <span class="font-weight-bold text-dark text-truncate-custom"><?php echo htmlspecialchars($booking['passenger_name'] ?? 'N/A'); ?></span>
                    </td>
                    <td><span class="code-pill"><?php echo htmlspecialchars($booking['ride_code'] ?? ('RD#' . $booking['ride_id'])); ?></span></td>
                    <td class="text-center font-weight-bold text-dark"><?php echo $booking['seats']; ?></td>
                    <td><span class="font-weight-bold text-dark">₹<?php echo number_format($booking['total_fare'] ?? 0, 0); ?></span></td>
                    <td class="text-center">
                      <?php 
                        $bst = strtolower($booking['booking_status']);
                        $badge_class = 'badge-pending';
                        if (in_array($bst, ['accepted', 'confirmed'])) $badge_class = 'badge-active';
                        elseif (in_array($bst, ['completed'])) $badge_class = 'badge-completed';
                        elseif (in_array($bst, ['rejected', 'cancelled'])) $badge_class = 'badge-cancelled';
                      ?>
                      <span class="badge-pill-sm <?php echo $badge_class; ?>"><?php echo ucfirst($booking['booking_status'] ?: 'Pending'); ?></span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No recent bookings found.</td></tr>
              <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php require_once 'includes/footer.php'; ?>
