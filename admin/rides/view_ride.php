<?php
/**
 * View Single Ride Details Page
 * Module: Ride & Booking Management
 * Location: admin/rides/view_ride.php
 */

require_once '../../config/database.php';
$page_title = "View Ride Details - Admin Panel";

require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/sidebar.php';

// ---------------------------------------------------------
// 1. RIDE ID VALIDATION
// ---------------------------------------------------------
$ride_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

// Default state variables
$ride = null;
$bookings = [];

if ($ride_id > 0) {
    // ---------------------------------------------------------
    // 2. FETCH RIDE, DRIVER & VEHICLE DETAILS (PREPARED QUERY)
    // ---------------------------------------------------------
    $ride_sql = "SELECT r.*, 
                        u.full_name AS driver_name, 
                        u.email AS driver_email, 
                        u.mobile AS driver_phone, 
                        u.rating AS driver_rating,
                        v.brand AS vehicle_brand, 
                        v.model AS vehicle_model, 
                        v.vehicle_number, 
                        v.color AS vehicle_color,
                        v.total_seats AS vehicle_total_seats,
                        v.vehicle_type AS vehicle_type
                 FROM rides r
                 LEFT JOIN users u ON r.driver_id = u.id
                 LEFT JOIN vehicles v ON r.vehicle_id = v.id
                 WHERE r.id = ? LIMIT 1";

    $stmt = $conn->prepare($ride_sql);
    if ($stmt) {
        $stmt->bind_param("i", $ride_id);
        $stmt->execute();
        $ride_res = $stmt->get_result();

        if ($ride_res && $ride_res->num_rows === 1) {
            $ride = $ride_res->fetch_assoc();
        }
        $stmt->close();
    }

    // ---------------------------------------------------------
    // 3. FETCH BOOKED PASSENGERS (SEPARATE PREPARED QUERY)
    // ---------------------------------------------------------
    if ($ride) {
        $booking_sql = "SELECT b.*, 
                               u.full_name AS passenger_name, 
                               u.mobile AS passenger_phone, 
                               u.email AS passenger_email
                        FROM ride_bookings b
                        LEFT JOIN users u ON b.passenger_id = u.id
                        WHERE b.ride_id = ?
                        ORDER BY b.id DESC";

        $b_stmt = $conn->prepare($booking_sql);
        if ($b_stmt) {
            $b_stmt->bind_param("i", $ride_id);
            $b_stmt->execute();
            $b_res = $b_stmt->get_result();
            if ($b_res) {
                while ($b_row = $b_res->fetch_assoc()) {
                    $bookings[] = $b_row;
                }
            }
            $b_stmt->close();
        }
    }
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header (Page header & Breadcrumb) -->
  <div class="content-header">
    <div class="container-fluid">
      <?php display_flash_message(); ?>
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold">
            <i class="fas fa-eye mr-2 text-primary"></i>Ride Details <?php echo $ride ? ('#' . $ride['id']) : ''; ?>
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="ride_list.php">Rides</a></li>
            <li class="breadcrumb-item active">View Ride</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <?php if (!$ride): ?>
        <!-- Friendly Error Notice if Ride Not Found -->
        <div class="card card-warning card-outline shadow my-4 text-center p-5">
          <div class="card-body">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h3 class="font-weight-bold">Ride not found.</h3>
            <p class="text-muted mb-4">The requested ride record does not exist or invalid ID was provided.</p>
            <a href="ride_list.php" class="btn btn-primary font-weight-bold">
              <i class="fas fa-arrow-left mr-1"></i> Back to Ride List
            </a>
          </div>
        </div>
      <?php else: ?>

        <!-- Navigation & Action Buttons Bar -->
        <div class="mb-3 d-flex justify-content-between align-items-center">
          <a href="ride_list.php" class="btn btn-secondary font-weight-bold">
            <i class="fas fa-arrow-left mr-1"></i> Back to Ride List
          </a>
          <div>
            <a href="edit_ride.php?id=<?php echo $ride['id']; ?>" class="btn btn-warning font-weight-bold text-dark mr-2">
              <i class="fas fa-edit mr-1"></i> Edit Ride
            </a>
            
            <!-- Ride Status Change Action Dropdown -->
            <div class="btn-group">
              <button type="button" class="btn btn-primary font-weight-bold dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-cog mr-1"></i> Update Status
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item text-info" href="update_ride_status.php?id=<?php echo $ride['id']; ?>&status=active">Set Active</a>
                <a class="dropdown-item text-warning" href="update_ride_status.php?id=<?php echo $ride['id']; ?>&status=full">Set Full</a>
                <a class="dropdown-item text-primary" href="update_ride_status.php?id=<?php echo $ride['id']; ?>&status=driver_reached">Set Driver Reached</a>
                <a class="dropdown-item text-primary" href="update_ride_status.php?id=<?php echo $ride['id']; ?>&status=started">Set Started</a>
                <a class="dropdown-item text-success" href="update_ride_status.php?id=<?php echo $ride['id']; ?>&status=completed">Set Completed</a>
                <a class="dropdown-item text-danger" href="update_ride_status.php?id=<?php echo $ride['id']; ?>&status=cancelled">Set Cancelled</a>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <!-- CARD 1: RIDE INFORMATION -->
          <div class="col-md-7">
            <div class="card card-primary card-outline shadow mb-4">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-route mr-2 text-primary"></i>Ride Information</h3>
                <div class="card-tools">
                  <?php 
                    $st = strtolower($ride['status']);
                    $badge = 'badge-secondary';
                    if ($st === 'active') $badge = 'badge-info';
                    elseif ($st === 'full') $badge = 'badge-warning';
                    elseif ($st === 'driver_reached' || $st === 'started') $badge = 'badge-primary';
                    elseif ($st === 'completed') $badge = 'badge-success';
                    elseif ($st === 'cancelled') $badge = 'badge-danger';
                  ?>
                  <span class="badge <?php echo $badge; ?> p-2"><?php echo ucfirst(str_replace('_', ' ', $ride['status'])); ?></span>
                </div>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <tr>
                    <th style="width: 35%;">Ride Code</th>
                    <td><code><?php echo htmlspecialchars($ride['ride_code'] ?? ('RD#' . $ride['id'])); ?></code></td>
                  </tr>
                  <tr>
                    <th>Ride Type</th>
                    <td>
                      <span class="badge badge-light border px-2 py-1">
                        <i class="fas <?php echo (strtolower($ride['ride_type'] ?? $ride['vehicle_type']) === 'bike') ? 'fa-motorcycle' : 'fa-car'; ?> mr-1"></i>
                        <?php echo ucfirst(htmlspecialchars($ride['ride_type'] ?? $ride['vehicle_type'] ?? 'Car')); ?>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th>Pickup Address</th>
                    <td class="text-success font-weight-bold">
                      <i class="fas fa-map-marker-alt mr-1"></i><?php echo htmlspecialchars($ride['pickup_address']); ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Destination Address</th>
                    <td class="text-danger font-weight-bold">
                      <i class="fas fa-flag-checkered mr-1"></i><?php echo htmlspecialchars($ride['destination_address']); ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Ride Date</th>
                    <td><i class="far fa-calendar-alt text-info mr-1"></i><?php echo date('l, d F Y', strtotime($ride['ride_date'])); ?></td>
                  </tr>
                  <tr>
                    <th>Ride Time</th>
                    <td><i class="far fa-clock text-info mr-1"></i><?php echo date('h:i A', strtotime($ride['ride_time'])); ?></td>
                  </tr>
                  <tr>
                    <th>Available Seats</th>
                    <td><span class="badge badge-primary px-3 py-1"><?php echo htmlspecialchars($ride['available_seats']); ?> Seat(s)</span></td>
                  </tr>
                  <tr>
                    <th>Fare per Seat</th>
                    <td class="font-weight-bold text-success text-lg">₹<?php echo number_format($ride['fare'], 2); ?></td>
                  </tr>
                  <tr>
                    <th>Distance</th>
                    <td><?php echo htmlspecialchars($ride['distance'] ?? '0.00'); ?> km</td>
                  </tr>
                  <tr>
                    <th>Duration</th>
                    <td><?php echo htmlspecialchars($ride['duration'] ?? '0'); ?> mins</td>
                  </tr>
                  <tr>
                    <th>Fuel Cost</th>
                    <td>₹<?php echo number_format($ride['fuel_cost'] ?? 0, 2); ?></td>
                  </tr>
                  <tr>
                    <th>Notes</th>
                    <td><?php echo !empty($ride['notes']) ? htmlspecialchars($ride['notes']) : '<span class="text-muted">No additional notes provided.</span>'; ?></td>
                  </tr>
                  <tr>
                    <th>Created Date</th>
                    <td><small class="text-muted"><?php echo date('d M Y, h:i A', strtotime($ride['created_at'])); ?></small></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <!-- CARD 2: DRIVER & VEHICLE INFORMATION -->
          <div class="col-md-5">
            <!-- Driver Info Card -->
            <div class="card card-info card-outline shadow mb-4">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-user-tie mr-2 text-info"></i>Driver Information</h3>
              </div>
              <div class="card-body">
                <p class="mb-2"><strong>Driver Name:</strong> <?php echo htmlspecialchars($ride['driver_name'] ?? 'N/A'); ?></p>
                <p class="mb-2"><strong>Mobile:</strong> <i class="fas fa-phone-alt text-muted mr-1"></i><?php echo htmlspecialchars($ride['driver_phone'] ?? 'N/A'); ?></p>
                <p class="mb-2"><strong>Email:</strong> <i class="fas fa-envelope text-muted mr-1"></i><?php echo htmlspecialchars($ride['driver_email'] ?? 'N/A'); ?></p>
                <p class="mb-0"><strong>Rating:</strong> <span class="badge badge-warning"><i class="fas fa-star mr-1"></i><?php echo number_format($ride['driver_rating'] ?? 5, 1); ?> / 5.0</span></p>
              </div>
            </div>

            <!-- Vehicle Info Card -->
            <div class="card card-dark card-outline shadow">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-car-alt mr-2"></i>Vehicle Information</h3>
              </div>
              <div class="card-body">
                <p class="mb-2"><strong>Vehicle Type:</strong> <?php echo ucfirst(htmlspecialchars($ride['vehicle_type'] ?? $ride['ride_type'] ?? 'N/A')); ?></p>
                <p class="mb-2"><strong>Brand:</strong> <?php echo htmlspecialchars($ride['vehicle_brand'] ?? 'N/A'); ?></p>
                <p class="mb-2"><strong>Model:</strong> <?php echo htmlspecialchars($ride['vehicle_model'] ?? 'N/A'); ?></p>
                <p class="mb-2"><strong>Vehicle Number:</strong> <code class="font-weight-bold text-dark"><?php echo htmlspecialchars($ride['vehicle_number'] ?? 'N/A'); ?></code></p>
                <p class="mb-2"><strong>Color:</strong> <?php echo htmlspecialchars($ride['vehicle_color'] ?? 'N/A'); ?></p>
                <p class="mb-0"><strong>Total Seats:</strong> <?php echo htmlspecialchars($ride['vehicle_total_seats'] ?? 'N/A'); ?></p>
              </div>
            </div>
          </div>
        </div>

        <!-- CARD 3: BOOKED PASSENGERS -->
        <div class="row">
          <div class="col-12">
            <div class="card card-success card-outline shadow mb-4">
              <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-users mr-2 text-success"></i>Booked Passengers (<?php echo count($bookings); ?>)</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped">
                  <thead class="thead-light">
                    <tr>
                      <th>Booking Code</th>
                      <th>Passenger Name</th>
                      <th>Mobile</th>
                      <th class="text-center">Seats</th>
                      <th>Total Fare</th>
                      <th>Booking Status</th>
                      <th>Payment Status</th>
                      <th>Booking Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($bookings)): ?>
                      <?php foreach ($bookings as $b): ?>
                        <tr>
                          <td><code><?php echo htmlspecialchars($b['booking_code'] ?? ('BK#' . $b['id'])); ?></code></td>
                          <td class="font-weight-bold"><?php echo htmlspecialchars($b['passenger_name'] ?? 'N/A'); ?></td>
                          <td><i class="fas fa-phone-alt text-muted mr-1"></i><?php echo htmlspecialchars($b['passenger_phone'] ?? 'N/A'); ?></td>
                          <td class="text-center font-weight-bold"><?php echo htmlspecialchars($b['seats']); ?></td>
                          <td class="font-weight-bold text-success">₹<?php echo number_format($b['total_fare'] ?? 0, 2); ?></td>
                          <td>
                            <?php 
                              $bst = strtolower($b['booking_status']);
                              $badge = 'badge-secondary';
                              if (in_array($bst, ['accepted', 'confirmed'])) $badge = 'badge-info';
                              elseif ($bst === 'completed') $badge = 'badge-success';
                              elseif (in_array($bst, ['rejected', 'cancelled'])) $badge = 'badge-danger';
                              elseif (in_array($bst, ['pending', ''])) $badge = 'badge-warning';
                            ?>
                            <span class="badge <?php echo $badge; ?> px-2 py-1"><?php echo ucfirst($b['booking_status'] ?: 'Pending'); ?></span>
                          </td>
                          <td>
                            <span class="badge badge-light border px-2 py-1">
                              <?php echo htmlspecialchars($b['payment_status'] ?? 'Pending'); ?>
                            </span>
                          </td>
                          <td><small><?php echo date('d M Y, h:i A', strtotime($b['created_at'])); ?></small></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                          No passengers have booked seats on this ride yet.
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      <?php endif; ?>

    </div>
  </section>
</div>

<?php require_once '../includes/footer.php'; ?>
