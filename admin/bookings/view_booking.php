<?php
/**
 * View Single Booking Details Page
 * Module: Ride & Booking Management
 * Location: admin/bookings/view_booking.php
 */

require_once '../../config/database.php';
$page_title = "View Booking Details - Admin Panel";

require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/sidebar.php';

// ---------------------------------------------------------
// 1. INPUT VALIDATION & GET BOOKING ID
// ---------------------------------------------------------
$booking_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$booking = null;

if ($booking_id > 0) {
    // ---------------------------------------------------------
    // 2. FETCH BOOKING, PASSENGER & RIDE DETAILS USING PREPARED STATEMENT
    // ---------------------------------------------------------
    $sql = "SELECT 
                b.id AS booking_id,
                b.booking_code,
                b.seats AS seats_booked,
                b.total_fare,
                b.booking_status,
                b.payment_status,
                b.created_at AS booking_date,
                b.ride_id,
                b.passenger_id,
                
                u.full_name AS passenger_name,
                u.mobile AS passenger_mobile,
                u.email AS passenger_email,
                u.gender AS passenger_gender,
                u.rating AS passenger_rating,
                u.is_verified AS passenger_is_verified,
                
                r.ride_code,
                r.ride_type,
                r.pickup_address,
                r.destination_address,
                r.ride_date,
                r.ride_time,
                r.available_seats,
                r.fare AS ride_fare,
                r.status AS ride_status
            FROM ride_bookings b
            LEFT JOIN users u ON b.passenger_id = u.id
            LEFT JOIN rides r ON b.ride_id = r.id
            WHERE b.id = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) {
            $booking = $res->fetch_assoc();
        }
        $stmt->close();
    }
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header (Breadcrumb & Title) -->
  <div class="content-header">
    <div class="container-fluid">
      <?php display_flash_message(); ?>
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold">
            <i class="fas fa-ticket-alt mr-2 text-success"></i>Booking Details <?php echo $booking ? ('#' . htmlspecialchars($booking['booking_id'])) : ''; ?>
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="booking_list.php">Bookings</a></li>
            <li class="breadcrumb-item active">View Booking</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <?php if (!$booking): ?>
        <!-- Error Notice if Booking Not Found -->
        <div class="card card-warning card-outline shadow my-4 text-center p-5">
          <div class="card-body">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h3 class="font-weight-bold">Booking not found.</h3>
            <p class="text-muted mb-4">The requested booking record does not exist or an invalid ID was provided.</p>
            <a href="booking_list.php" class="btn btn-success font-weight-bold">
              <i class="fas fa-arrow-left mr-1"></i> Back to Booking List
            </a>
          </div>
        </div>
      <?php else: ?>

        <!-- Action Bar with Navigation Buttons -->
        <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
          <a href="booking_list.php" class="btn btn-secondary font-weight-bold mb-2">
            <i class="fas fa-arrow-left mr-1"></i> Back to Booking List
          </a>
          
          <div>
            <a href="../rides/view_ride.php?id=<?php echo urlencode($booking['ride_id']); ?>" class="btn btn-info font-weight-bold mb-2 mr-2">
              <i class="fas fa-eye mr-1"></i> View Ride
            </a>

            <a href="update_booking_status.php?id=<?php echo urlencode($booking['booking_id']); ?>" class="btn btn-warning font-weight-bold text-dark mb-2">
              <i class="fas fa-edit mr-1"></i> Update Booking Status
            </a>
          </div>
        </div>

        <div class="row">
          <!-- 1. BOOKING SUMMARY CARD -->
          <div class="col-md-6 mb-4">
            <div class="card card-success card-outline shadow h-100">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">
                  <i class="fas fa-receipt mr-2 text-success"></i>1. Booking Summary
                </h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                  <tr>
                    <th style="width: 40%;">Booking Code</th>
                    <td><code><?php echo htmlspecialchars($booking['booking_code'] ?? ('BK#' . $booking['booking_id'])); ?></code></td>
                  </tr>
                  <tr>
                    <th>Seats Booked</th>
                    <td>
                      <span class="badge badge-light border border-secondary px-3 py-1">
                        <i class="fas fa-chair mr-1 text-muted"></i><?php echo htmlspecialchars($booking['seats_booked']); ?> Seat(s)
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th>Total Fare</th>
                    <td class="font-weight-bold text-success text-lg">
                      ₹<?php echo number_format($booking['total_fare'] ?? 0, 2); ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Booking Status</th>
                    <td>
                      <?php 
                        $bst = strtolower($booking['booking_status'] ?? '');
                        $b_badge = 'badge-secondary';
                        if ($bst === 'accepted') $b_badge = 'badge-info';
                        elseif ($bst === 'completed') $b_badge = 'badge-success';
                        elseif ($bst === 'rejected' || $bst === 'cancelled') $b_badge = 'badge-danger';
                        elseif ($bst === 'pending' || $bst === '') $b_badge = 'badge-warning';
                      ?>
                      <span class="badge <?php echo $b_badge; ?> px-3 py-1">
                        <?php echo ucfirst(htmlspecialchars($booking['booking_status'] ?: 'Pending')); ?>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th>Payment Status</th>
                    <td>
                      <?php 
                        $pst = strtolower($booking['payment_status'] ?? '');
                        $p_badge = 'badge-secondary';
                        if ($pst === 'paid') $p_badge = 'badge-success';
                        elseif ($pst === 'pending' || $pst === '') $p_badge = 'badge-warning';
                        elseif ($pst === 'refunded') $p_badge = 'badge-secondary';
                      ?>
                      <span class="badge <?php echo $p_badge; ?> px-3 py-1">
                        <?php echo ucfirst(htmlspecialchars($booking['payment_status'] ?: 'Pending')); ?>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th>Booking Date</th>
                    <td>
                      <small class="text-muted font-weight-bold">
                        <i class="far fa-calendar-alt text-info mr-1"></i>
                        <?php echo date('d M Y, h:i A', strtotime($booking['booking_date'])); ?>
                      </small>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <!-- 2. PASSENGER DETAILS CARD -->
          <div class="col-md-6 mb-4">
            <div class="card card-info card-outline shadow h-100">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">
                  <i class="fas fa-user mr-2 text-info"></i>2. Passenger Details
                </h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                  <tr>
                    <th style="width: 40%;">Passenger Name</th>
                    <td class="font-weight-bold">
                      <i class="fas fa-user-circle text-info mr-1"></i>
                      <?php echo htmlspecialchars($booking['passenger_name'] ?? 'N/A'); ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Mobile</th>
                    <td>
                      <i class="fas fa-phone-alt text-muted mr-1"></i>
                      <?php echo htmlspecialchars($booking['passenger_mobile'] ?? 'N/A'); ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td>
                      <i class="fas fa-envelope text-muted mr-1"></i>
                      <?php echo htmlspecialchars($booking['passenger_email'] ?? 'N/A'); ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <td>
                      <?php echo htmlspecialchars($booking['passenger_gender'] ?? 'N/A'); ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Rating</th>
                    <td>
                      <span class="badge badge-warning">
                        <i class="fas fa-star mr-1"></i><?php echo number_format($booking['passenger_rating'] ?? 5, 1); ?> / 5.0
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <th>Verification Status</th>
                    <td>
                      <?php if (!empty($booking['passenger_is_verified'])): ?>
                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Verified</span>
                      <?php else: ?>
                        <span class="badge badge-secondary px-2 py-1"><i class="fas fa-times-circle mr-1"></i>Not Verified</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. RIDE DETAILS CARD -->
        <div class="row">
          <div class="col-12 mb-4">
            <div class="card card-primary card-outline shadow">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold">
                  <i class="fas fa-route mr-2 text-primary"></i>3. Ride Details
                </h3>
                <a href="../rides/view_ride.php?id=<?php echo urlencode($booking['ride_id']); ?>" class="btn btn-sm btn-outline-primary font-weight-bold">
                  <i class="fas fa-external-link-alt mr-1"></i> View Ride Details
                </a>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered mb-0">
                    <tr>
                      <th style="width: 25%;">Ride Code</th>
                      <td><code><?php echo htmlspecialchars($booking['ride_code'] ?? ('RD#' . $booking['ride_id'])); ?></code></td>
                      <th style="width: 25%;">Ride Type</th>
                      <td>
                        <span class="badge badge-light border px-2 py-1">
                          <i class="fas <?php echo (strtolower($booking['ride_type'] ?? '') === 'bike') ? 'fa-motorcycle' : 'fa-car'; ?> mr-1"></i>
                          <?php echo ucfirst(htmlspecialchars($booking['ride_type'] ?? 'Car')); ?>
                        </span>
                      </td>
                    </tr>
                    <tr>
                      <th>Pickup Address</th>
                      <td class="text-success font-weight-bold">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        <?php echo htmlspecialchars($booking['pickup_address'] ?? 'N/A'); ?>
                      </td>
                      <th>Destination Address</th>
                      <td class="text-danger font-weight-bold">
                        <i class="fas fa-flag-checkered mr-1"></i>
                        <?php echo htmlspecialchars($booking['destination_address'] ?? 'N/A'); ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Ride Date</th>
                      <td>
                        <i class="far fa-calendar-alt text-info mr-1"></i>
                        <?php echo !empty($booking['ride_date']) ? date('d M Y', strtotime($booking['ride_date'])) : 'N/A'; ?>
                      </td>
                      <th>Ride Time</th>
                      <td>
                        <i class="far fa-clock text-info mr-1"></i>
                        <?php echo !empty($booking['ride_time']) ? date('h:i A', strtotime($booking['ride_time'])) : 'N/A'; ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Available Seats</th>
                      <td>
                        <span class="badge badge-primary px-3 py-1">
                          <?php echo htmlspecialchars($booking['available_seats'] ?? 0); ?> Seat(s)
                        </span>
                      </td>
                      <th>Fare (per seat)</th>
                      <td class="font-weight-bold text-success">
                        ₹<?php echo number_format($booking['ride_fare'] ?? 0, 2); ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Ride Status</th>
                      <td colspan="3">
                        <?php 
                          $rst = strtolower($booking['ride_status'] ?? '');
                          $r_badge = 'badge-secondary';
                          if ($rst === 'active') $r_badge = 'badge-info';
                          elseif ($rst === 'full') $r_badge = 'badge-warning';
                          elseif ($rst === 'driver_reached' || $rst === 'started') $r_badge = 'badge-primary';
                          elseif ($rst === 'completed') $r_badge = 'badge-success';
                          elseif ($rst === 'cancelled') $r_badge = 'badge-danger';
                        ?>
                        <span class="badge <?php echo $r_badge; ?> px-3 py-1">
                          <?php echo ucfirst(htmlspecialchars(str_replace('_', ' ', $booking['ride_status'] ?? 'Unknown'))); ?>
                        </span>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php endif; ?>

    </div>
  </section>
</div>

<?php 
require_once '../includes/footer.php'; 
?>
