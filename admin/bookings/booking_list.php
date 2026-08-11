<?php
/**
 * Booking List Management Page
 * Module: Ride & Booking Management
 * Location: admin/bookings/booking_list.php
 */

require_once '../../config/database.php';
$page_title = "Booking List - Booking Management";

require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/sidebar.php';

// ---------------------------------------------------------
// 1. INPUT SANITIZATION & PARAMETERS
// ---------------------------------------------------------
$search = trim($_GET['search'] ?? '');
$status_filter = trim($_GET['status'] ?? '');
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// ---------------------------------------------------------
// 2. DYNAMIC WHERE CLAUSE PREPARATION
// ---------------------------------------------------------
$where_clauses = ["1=1"];
$params = [];
$types = "";

// Multi-field search
if (!empty($search)) {
    $where_clauses[] = "(b.booking_code LIKE ? OR u.full_name LIKE ? OR r.ride_code LIKE ?)";
    $search_param = "%" . $search . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

// Booking Status Filter Whitelist Validation
$allowed_statuses = ['Pending', 'Accepted', 'Rejected', 'Cancelled', 'Completed'];
if (!empty($status_filter) && in_array($status_filter, $allowed_statuses)) {
    $where_clauses[] = "b.booking_status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$where_sql = implode(" AND ", $where_clauses);

// ---------------------------------------------------------
// 3. FETCH TOTAL COUNT FOR PAGINATION
// ---------------------------------------------------------
$count_sql = "SELECT COUNT(*) AS total 
              FROM ride_bookings b 
              LEFT JOIN users u ON b.passenger_id = u.id 
              LEFT JOIN rides r ON b.ride_id = r.id 
              WHERE {$where_sql}";

$count_stmt = $conn->prepare($count_sql);
if (!empty($params)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$count_res = $count_stmt->get_result();
$total_records = $count_res ? $count_res->fetch_assoc()['total'] : 0;
$total_pages = max(1, ceil($total_records / $limit));
$count_stmt->close();

// ---------------------------------------------------------
// 4. FETCH BOOKING RECORDS WITH JOINs & PAGINATION
// ---------------------------------------------------------
$sql = "SELECT b.*, 
               u.full_name AS passenger_name, 
               u.mobile AS passenger_phone, 
               r.ride_code, 
               r.pickup_address, 
               r.destination_address 
        FROM ride_bookings b 
        LEFT JOIN users u ON b.passenger_id = u.id 
        LEFT JOIN rides r ON b.ride_id = r.id 
        WHERE {$where_sql} 
        ORDER BY b.id DESC 
        LIMIT ?, ?";

$stmt_types = $types . "ii";
$stmt_params = array_merge($params, [$offset, $limit]);

$stmt = $conn->prepare($sql);
$stmt->bind_param($stmt_types, ...$stmt_params);
$stmt->execute();
$bookings_result = $stmt->get_result();
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header (Breadcrumb & Title) -->
  <div class="content-header">
    <div class="container-fluid">
      <?php display_flash_message(); ?>
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold"><i class="fas fa-ticket-alt mr-2 text-success"></i>Booking Management</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="booking_list.php">Bookings</a></li>
            <li class="breadcrumb-item active">Booking List</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Search & Filter Card -->
      <div class="card card-success card-outline shadow mb-4">
        <div class="card-header">
          <h3 class="card-title font-weight-bold"><i class="fas fa-filter mr-2 text-success"></i>Search & Filter Bookings</h3>
        </div>
        <div class="card-body">
          <form method="GET" action="booking_list.php" class="row">
            <!-- Search Box -->
            <div class="col-md-5 mb-2">
              <label class="font-weight-bold">Search</label>
              <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search Booking Code, Passenger Name, or Ride Code..." value="<?php echo htmlspecialchars($search); ?>">
                <div class="input-group-append">
                  <button class="btn btn-success" type="submit"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
            </div>

            <!-- Status Filter Dropdown -->
            <div class="col-md-4 mb-2">
              <label class="font-weight-bold">Status Filter</label>
              <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">-- All Booking Statuses --</option>
                <option value="Pending" <?php echo ($status_filter === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Accepted" <?php echo ($status_filter === 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                <option value="Rejected" <?php echo ($status_filter === 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                <option value="Cancelled" <?php echo ($status_filter === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                <option value="Completed" <?php echo ($status_filter === 'Completed') ? 'selected' : ''; ?>>Completed</option>
              </select>
            </div>

            <!-- Reset Button -->
            <div class="col-md-3 mb-2 d-flex align-items-end">
              <a href="booking_list.php" class="btn btn-secondary btn-block"><i class="fas fa-sync-alt mr-1"></i> Reset Filters</a>
            </div>
          </form>
        </div>
      </div>

      <!-- Booking Table Card -->
      <div class="card shadow">
        <div class="card-header border-0 d-flex justify-content-between align-items-center">
          <h3 class="card-title font-weight-bold"><i class="fas fa-list mr-2 text-success"></i>All Bookings (<?php echo $total_records; ?> Total)</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover table-striped text-nowrap">
            <thead class="thead-light">
              <tr>
                <th>Booking Code</th>
                <th>Passenger Name</th>
                <th>Ride Code</th>
                <th>Pickup</th>
                <th>Destination</th>
                <th class="text-center">Seats</th>
                <th>Total Fare</th>
                <th>Booking Status</th>
                <th>Payment Status</th>
                <th>Booking Date</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($bookings_result && $bookings_result->num_rows > 0): ?>
                <?php while ($booking = $bookings_result->fetch_assoc()): ?>
                  <tr>
                    <!-- Booking Code -->
                    <td class="font-weight-bold">
                      <code><?php echo htmlspecialchars($booking['booking_code'] ?? ('BK#' . $booking['id'])); ?></code>
                    </td>

                    <!-- Passenger Name -->
                    <td>
                      <i class="fas fa-user-circle text-success mr-1"></i>
                      <strong><?php echo htmlspecialchars($booking['passenger_name'] ?? 'N/A'); ?></strong><br>
                      <small class="text-muted"><i class="fas fa-phone-alt mr-1"></i><?php echo htmlspecialchars($booking['passenger_phone'] ?? 'N/A'); ?></small>
                    </td>

                    <!-- Ride Code -->
                    <td>
                      <code><?php echo htmlspecialchars($booking['ride_code'] ?? ('RD#' . $booking['ride_id'])); ?></code>
                    </td>

                    <!-- Pickup Address -->
                    <td>
                      <span class="d-inline-block text-truncate" style="max-width: 150px;" title="<?php echo htmlspecialchars($booking['pickup_address'] ?? ''); ?>">
                        <i class="fas fa-map-marker-alt text-success mr-1"></i><?php echo htmlspecialchars($booking['pickup_address'] ?? 'N/A'); ?>
                      </span>
                    </td>

                    <!-- Destination Address -->
                    <td>
                      <span class="d-inline-block text-truncate" style="max-width: 150px;" title="<?php echo htmlspecialchars($booking['destination_address'] ?? ''); ?>">
                        <i class="fas fa-flag-checkered text-danger mr-1"></i><?php echo htmlspecialchars($booking['destination_address'] ?? 'N/A'); ?>
                      </span>
                    </td>

                    <!-- Seats -->
                    <td class="text-center font-weight-bold">
                      <span class="badge badge-light border border-secondary px-2 py-1">
                        <?php echo htmlspecialchars($booking['seats']); ?> Seat(s)
                      </span>
                    </td>

                    <!-- Total Fare -->
                    <td class="font-weight-bold text-success">
                      ₹<?php echo number_format($booking['total_fare'] ?? 0, 2); ?>
                    </td>

                    <!-- Booking Status Badge -->
                    <td>
                      <?php 
                        $bst = strtolower($booking['booking_status']);
                        $badge = 'badge-secondary';
                        if (in_array($bst, ['accepted', 'confirmed'])) $badge = 'badge-info';
                        elseif ($bst === 'completed') $badge = 'badge-success';
                        elseif (in_array($bst, ['rejected', 'cancelled'])) $badge = 'badge-danger';
                        elseif (in_array($bst, ['pending', ''])) $badge = 'badge-warning';
                      ?>
                      <span class="badge <?php echo $badge; ?> p-2"><?php echo ucfirst($booking['booking_status'] ?: 'Pending'); ?></span>
                    </td>

                    <!-- Payment Status Badge -->
                    <td>
                      <?php 
                        $pst = strtolower($booking['payment_status'] ?? '');
                        $pbadge = 'badge-secondary';
                        if ($pst === 'paid') $pbadge = 'badge-success';
                        elseif ($pst === 'pending' || $pst === '') $pbadge = 'badge-warning';
                        elseif ($pst === 'refunded') $pbadge = 'badge-secondary';
                      ?>
                      <span class="badge <?php echo $pbadge; ?> px-2 py-1"><?php echo ucfirst($booking['payment_status'] ?: 'Pending'); ?></span>
                    </td>

                    <!-- Booking Date -->
                    <td>
                      <small><i class="far fa-calendar-alt text-info mr-1"></i><?php echo date('d M Y, h:i A', strtotime($booking['created_at'])); ?></small>
                    </td>

                    <!-- Action -->
                    <td class="text-center">
                      <a href="view_booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-info btn-sm font-weight-bold" title="View Booking Details">
                        <i class="fas fa-eye mr-1"></i> View
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="11" class="text-center py-4 text-muted">
                    <i class="fas fa-folder-open fa-2x d-block mb-2"></i> No bookings found matching criteria.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Server-side Pagination Footer -->
        <?php if ($total_pages > 1): ?>
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
              <!-- Previous Page -->
              <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>&page=<?php echo $page - 1; ?>">« Previous</a>
              </li>

              <!-- Page Numbers -->
              <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                  <a class="page-link" href="?search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>

              <!-- Next Page -->
              <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status_filter); ?>&page=<?php echo $page + 1; ?>">Next »</a>
              </li>
            </ul>
          </div>
        <?php endif; ?>

      </div>

    </div>
  </section>
</div>

<?php 
if (isset($stmt) && $stmt) { $stmt->close(); }
require_once '../includes/footer.php'; 
?>
