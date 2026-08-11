<?php
/**
 * Ride List Management Page
 * Module: Ride & Booking Management
 * Location: admin/rides/ride_list.php
 */

require_once '../../config/database.php';
$page_title = "Ride List - Ride Management";
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
// 2. DYNAMIC SQL WHERE CLAUSE PREPARATION
// ---------------------------------------------------------
$where_clauses = ["1=1"];
$params = [];
$types = "";

// Search filter
if (!empty($search)) {
    $where_clauses[] = "(r.ride_code LIKE ? OR u.full_name LIKE ? OR r.pickup_address LIKE ? OR r.destination_address LIKE ?)";
    $search_param = "%" . $search . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ssss";
}

// Status filter
$allowed_statuses = ['active', 'full', 'driver_reached', 'started', 'completed', 'cancelled'];
if (!empty($status_filter) && in_array(strtolower($status_filter), $allowed_statuses)) {
    $where_clauses[] = "r.status = ?";
    $params[] = strtolower($status_filter);
    $types .= "s";
}

$where_sql = implode(" AND ", $where_clauses);

// ---------------------------------------------------------
// 3. FETCH TOTAL COUNT FOR PAGINATION
// ---------------------------------------------------------
$count_sql = "SELECT COUNT(*) AS total 
              FROM rides r 
              LEFT JOIN users u ON r.driver_id = u.id 
              LEFT JOIN vehicles v ON r.vehicle_id = v.id 
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
// 4. FETCH RIDE RECORDS WITH LEFT JOIN & PAGINATION
// ---------------------------------------------------------
$sql = "SELECT r.*, 
               u.full_name AS driver_name, 
               v.brand AS vehicle_brand, 
               v.model AS vehicle_model, 
               v.vehicle_number, 
               v.vehicle_type AS vehicle_type
        FROM rides r
        LEFT JOIN users u ON r.driver_id = u.id
        LEFT JOIN vehicles v ON r.vehicle_id = v.id
        WHERE {$where_sql}
        ORDER BY r.id DESC
        LIMIT ?, ?";

$stmt_types = $types . "ii";
$stmt_params = array_merge($params, [$offset, $limit]);

$stmt = $conn->prepare($sql);
$stmt->bind_param($stmt_types, ...$stmt_params);
$stmt->execute();
$rides_result = $stmt->get_result();
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header (Page header & Breadcrumb) -->
  <div class="content-header">
    <div class="container-fluid">
      <?php display_flash_message(); ?>
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold"><i class="fas fa-car mr-2 text-primary"></i>Ride List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="ride_list.php">Rides</a></li>
            <li class="breadcrumb-item active">Ride List</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Search and Filter Card -->
      <div class="card card-primary card-outline shadow mb-4">
        <div class="card-header">
          <h3 class="card-title font-weight-bold"><i class="fas fa-filter mr-2 text-primary"></i>Search & Filter Rides</h3>
        </div>
        <div class="card-body">
          <form method="GET" action="ride_list.php" class="row">
            <!-- Search Box -->
            <div class="col-md-5 mb-2">
              <label class="font-weight-bold">Search</label>
              <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search Ride Code, Driver Name, Pickup, or Destination..." value="<?php echo htmlspecialchars($search); ?>">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
            </div>

            <!-- Status Filter Dropdown -->
            <div class="col-md-4 mb-2">
              <label class="font-weight-bold">Status Filter</label>
              <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">-- All Statuses --</option>
                <option value="active" <?php echo ($status_filter === 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="full" <?php echo ($status_filter === 'full') ? 'selected' : ''; ?>>Full</option>
                <option value="driver_reached" <?php echo ($status_filter === 'driver_reached') ? 'selected' : ''; ?>>Driver Reached</option>
                <option value="started" <?php echo ($status_filter === 'started') ? 'selected' : ''; ?>>Started</option>
                <option value="completed" <?php echo ($status_filter === 'completed') ? 'selected' : ''; ?>>Completed</option>
                <option value="cancelled" <?php echo ($status_filter === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
              </select>
            </div>

            <!-- Reset Button -->
            <div class="col-md-3 mb-2 d-flex align-items-end">
              <a href="ride_list.php" class="btn btn-secondary btn-block"><i class="fas fa-sync-alt mr-1"></i> Reset Filters</a>
            </div>
          </form>
        </div>
      </div>

      <!-- Responsive Ride Table Card -->
      <div class="card shadow">
        <div class="card-header border-0 d-flex justify-content-between align-items-center">
          <h3 class="card-title font-weight-bold"><i class="fas fa-list mr-2 text-primary"></i>All Rides (<?php echo $total_records; ?> Total)</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover table-striped text-nowrap">
            <thead class="thead-light">
              <tr>
                <th>Ride Code</th>
                <th>Driver Name</th>
                <th>Vehicle Details</th>
                <th>Pickup Address</th>
                <th>Destination Address</th>
                <th>Date & Time</th>
                <th class="text-center">Available Seats</th>
                <th>Fare</th>
                <th>Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($rides_result && $rides_result->num_rows > 0): ?>
                <?php while ($ride = $rides_result->fetch_assoc()): ?>
                  <tr>
                    <!-- Ride Code -->
                    <td class="font-weight-bold">
                      <code><?php echo htmlspecialchars($ride['ride_code'] ?? ('RD#' . $ride['id'])); ?></code>
                    </td>

                    <!-- Driver Name -->
                    <td>
                      <i class="fas fa-user-circle text-primary mr-1"></i>
                      <strong><?php echo htmlspecialchars($ride['driver_name'] ?? 'N/A'); ?></strong>
                    </td>

                    <!-- Vehicle Details -->
                    <td>
                      <span class="badge badge-light border px-2 mb-1">
                        <i class="fas <?php echo (strtolower($ride['ride_type'] ?? $ride['vehicle_type']) === 'bike') ? 'fa-motorcycle' : 'fa-car'; ?> mr-1"></i>
                        <?php echo ucfirst(htmlspecialchars($ride['ride_type'] ?? $ride['vehicle_type'] ?? 'Car')); ?>
                      </span><br>
                      <small class="text-muted">
                        <?php echo htmlspecialchars(($ride['vehicle_brand'] ?? '') . ' ' . ($ride['vehicle_model'] ?? '')); ?>
                        (<code><?php echo htmlspecialchars($ride['vehicle_number'] ?? 'N/A'); ?></code>)
                      </small>
                    </td>

                    <!-- Pickup Address -->
                    <td>
                      <span class="d-inline-block text-truncate" style="max-width: 180px;" title="<?php echo htmlspecialchars($ride['pickup_address']); ?>">
                        <i class="fas fa-map-marker-alt text-success mr-1"></i><?php echo htmlspecialchars($ride['pickup_address']); ?>
                      </span>
                    </td>

                    <!-- Destination Address -->
                    <td>
                      <span class="d-inline-block text-truncate" style="max-width: 180px;" title="<?php echo htmlspecialchars($ride['destination_address']); ?>">
                        <i class="fas fa-flag-checkered text-danger mr-1"></i><?php echo htmlspecialchars($ride['destination_address']); ?>
                      </span>
                    </td>

                    <!-- Ride Date & Time -->
                    <td>
                      <i class="far fa-calendar-alt text-info mr-1"></i><?php echo date('d M Y', strtotime($ride['ride_date'])); ?><br>
                      <small class="text-muted"><i class="far fa-clock mr-1"></i><?php echo date('h:i A', strtotime($ride['ride_time'])); ?></small>
                    </td>

                    <!-- Available Seats -->
                    <td class="text-center">
                      <span class="badge badge-pill badge-light border border-secondary px-2 py-1">
                        <?php echo htmlspecialchars($ride['available_seats']); ?> Seat(s)
                      </span>
                    </td>

                    <!-- Fare -->
                    <td class="font-weight-bold text-success">
                      ₹<?php echo number_format($ride['fare'], 2); ?>
                    </td>

                    <!-- Status Badge -->
                    <td>
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
                    </td>

                    <!-- Action Button -->
                    <td class="text-center">
                      <a href="view_ride.php?id=<?php echo $ride['id']; ?>" class="btn btn-info btn-sm font-weight-bold" title="View Ride Details">
                        <i class="fas fa-eye mr-1"></i> View
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="10" class="text-center py-4 text-muted">
                    <i class="fas fa-folder-open fa-2x d-block mb-2"></i> No rides found matching your criteria.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination Footer -->
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
