<?php
/**
 * Edit Ride Page
 * Module: Ride & Booking Management
 * Location: admin/rides/edit_ride.php
 */

require_once '../../config/database.php';
require_once '../includes/session.php';

// Check admin authentication
check_admin_login();

// ---------------------------------------------------------
// 1. RIDE ID VALIDATION & RETRIEVAL
// ---------------------------------------------------------
$ride_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

if ($ride_id <= 0) {
    set_flash_message('danger', 'Invalid Ride ID provided.');
    header("Location: ride_list.php");
    exit();
}

$error_message = '';

// Fetch current ride details using a prepared statement
$stmt = $conn->prepare("SELECT r.*, u.full_name AS driver_name 
                        FROM rides r 
                        LEFT JOIN users u ON r.driver_id = u.id 
                        WHERE r.id = ? LIMIT 1");
$stmt->bind_param("i", $ride_id);
$stmt->execute();
$ride_res = $stmt->get_result();

if (!$ride_res || $ride_res->num_rows === 0) {
    $stmt->close();
    set_flash_message('danger', 'Ride record not found.');
    header("Location: ride_list.php");
    exit();
}

$ride = $ride_res->fetch_assoc();
$stmt->close();

// ---------------------------------------------------------
// 2. SERVER-SIDE FORM SUBMISSION & VALIDATION
// ---------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickup = trim($_POST['pickup_address'] ?? '');
    $destination = trim($_POST['destination_address'] ?? '');
    $ride_date = trim($_POST['ride_date'] ?? '');
    $ride_time = trim($_POST['ride_time'] ?? '');
    $available_seats_input = $_POST['available_seats'] ?? '';
    $fare_input = $_POST['fare'] ?? '';
    $status = trim($_POST['status'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    $allowed_statuses = ['active', 'full', 'driver_reached', 'started', 'completed', 'cancelled'];

    // Server-Side Validation Rules
    if (empty($pickup)) {
        $error_message = "Pickup Address is required.";
    } elseif (empty($destination)) {
        $error_message = "Destination Address is required.";
    } elseif (empty($ride_date)) {
        $error_message = "Ride Date is required.";
    } elseif (empty($ride_time)) {
        $error_message = "Ride Time is required.";
    } elseif ($available_seats_input === '' || !is_numeric($available_seats_input) || intval($available_seats_input) < 0) {
        $error_message = "Available seats must be a whole number greater than or equal to 0.";
    } elseif ($fare_input === '' || !is_numeric($fare_input) || floatval($fare_input) < 0) {
        $error_message = "Fare must be a numeric value greater than or equal to 0.";
    } elseif (empty($status) || !in_array(strtolower($status), $allowed_statuses)) {
        $error_message = "Please select a valid ride status from the list.";
    } else {
        // Validated data conversion
        $available_seats = intval($available_seats_input);
        $fare = floatval($fare_input);
        $status_lower = strtolower($status);

        // ---------------------------------------------------------
        // 3. PREPARED UPDATE QUERY
        // ---------------------------------------------------------
        $update_sql = "UPDATE rides 
                       SET pickup_address = ?, 
                           destination_address = ?, 
                           ride_date = ?, 
                           ride_time = ?, 
                           available_seats = ?, 
                           fare = ?, 
                           status = ?, 
                           notes = ? 
                       WHERE id = ? LIMIT 1";

        $update_stmt = $conn->prepare($update_sql);
        if ($update_stmt) {
            $update_stmt->bind_param("ssssidssi", $pickup, $destination, $ride_date, $ride_time, $available_seats, $fare, $status_lower, $notes, $ride_id);

            if ($update_stmt->execute()) {
                $update_stmt->close();
                set_flash_message('success', "Ride #{$ride_id} has been updated successfully.");
                header("Location: view_ride.php?id={$ride_id}");
                exit();
            } else {
                $error_message = "Unable to update ride. Please try again.";
                $update_stmt->close();
            }
        } else {
            $error_message = "Database connection error during update.";
        }
    }
}

// ---------------------------------------------------------
// 4. INCLUDE UI HEADERS AFTER POST PROCESSING
// ---------------------------------------------------------
$page_title = "Edit Ride - Admin Panel";

require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../includes/sidebar.php';
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header (Breadcrumb & Title) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 font-weight-bold"><i class="fas fa-edit mr-2 text-warning"></i>Edit Ride #<?php echo $ride['id']; ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="ride_list.php">Rides</a></li>
            <li class="breadcrumb-item active">Edit Ride #<?php echo $ride['id']; ?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <div class="row justify-content-center">
        <div class="col-md-9">
          
          <!-- Validation Error Alert -->
          <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
              <i class="fas fa-exclamation-triangle mr-2"></i> <?php echo htmlspecialchars($error_message); ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <!-- Edit Form Card -->
          <div class="card card-warning card-outline shadow mb-4">
            <div class="card-header">
              <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-pen mr-2"></i>Update Ride Information</h3>
            </div>
            
            <form action="edit_ride.php?id=<?php echo $ride['id']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to save changes to this ride?');">
              <div class="card-body">
                
                <!-- Uneditable Readonly Information Banner -->
                <div class="bg-light p-3 border rounded mb-4">
                  <div class="row">
                    <div class="col-md-4">
                      <small class="text-muted d-block font-weight-bold">RIDE CODE</small>
                      <code><?php echo htmlspecialchars($ride['ride_code'] ?? ('RD#' . $ride['id'])); ?></code>
                    </div>
                    <div class="col-md-4">
                      <small class="text-muted d-block font-weight-bold">DRIVER NAME</small>
                      <strong><?php echo htmlspecialchars($ride['driver_name'] ?? 'N/A'); ?></strong>
                    </div>
                    <div class="col-md-4">
                      <small class="text-muted d-block font-weight-bold">CREATED AT</small>
                      <small><?php echo date('d M Y, h:i A', strtotime($ride['created_at'])); ?></small>
                    </div>
                  </div>
                </div>

                <!-- Pickup & Destination Row -->
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold">Pickup Address <span class="text-danger">*</span></label>
                    <input type="text" name="pickup_address" class="form-control" placeholder="e.g. Andheri West, Mumbai" value="<?php echo htmlspecialchars($_POST['pickup_address'] ?? $ride['pickup_address']); ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold">Destination Address <span class="text-danger">*</span></label>
                    <input type="text" name="destination_address" class="form-control" placeholder="e.g. Cyber City, Gurugram" value="<?php echo htmlspecialchars($_POST['destination_address'] ?? $ride['destination_address']); ?>">
                  </div>
                </div>

                <!-- Date & Time Row -->
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold">Ride Date <span class="text-danger">*</span></label>
                    <input type="date" name="ride_date" class="form-control" value="<?php echo htmlspecialchars($_POST['ride_date'] ?? $ride['ride_date']); ?>">
                  </div>
                  <div class="col-md-6 form-group">
                    <label class="font-weight-bold">Departure Time <span class="text-danger">*</span></label>
                    <input type="time" name="ride_time" class="form-control" value="<?php echo htmlspecialchars($_POST['ride_time'] ?? $ride['ride_time']); ?>">
                  </div>
                </div>

                <!-- Seats, Fare & Status Row -->
                <div class="row">
                  <div class="col-md-4 form-group">
                    <label class="font-weight-bold">Available Seats <span class="text-danger">*</span></label>
                    <input type="number" name="available_seats" class="form-control" min="0" max="10" value="<?php echo htmlspecialchars($_POST['available_seats'] ?? $ride['available_seats']); ?>">
                  </div>
                  <div class="col-md-4 form-group">
                    <label class="font-weight-bold">Fare per Seat (₹) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="fare" class="form-control" min="0" value="<?php echo htmlspecialchars($_POST['fare'] ?? $ride['fare']); ?>">
                  </div>
                  <div class="col-md-4 form-group">
                    <label class="font-weight-bold">Ride Status <span class="text-danger">*</span></label>
                    <?php $current_st = strtolower($_POST['status'] ?? $ride['status']); ?>
                    <select name="status" class="form-control font-weight-bold">
                      <option value="active" <?php echo ($current_st === 'active') ? 'selected' : ''; ?>>Active</option>
                      <option value="full" <?php echo ($current_st === 'full') ? 'selected' : ''; ?>>Full</option>
                      <option value="driver_reached" <?php echo ($current_st === 'driver_reached') ? 'selected' : ''; ?>>Driver Reached</option>
                      <option value="started" <?php echo ($current_st === 'started') ? 'selected' : ''; ?>>Started</option>
                      <option value="completed" <?php echo ($current_st === 'completed') ? 'selected' : ''; ?>>Completed</option>
                      <option value="cancelled" <?php echo ($current_st === 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                  </div>
                </div>

                <!-- Notes Textarea -->
                <div class="form-group mb-0">
                  <label class="font-weight-bold">Additional Notes / Instructions</label>
                  <textarea name="notes" class="form-control" rows="3" placeholder="Optional notes for passengers..."><?php echo htmlspecialchars($_POST['notes'] ?? $ride['notes'] ?? ''); ?></textarea>
                </div>

              </div>
              
              <!-- Form Action Buttons -->
              <div class="card-footer d-flex justify-content-between">
                <a href="view_ride.php?id=<?php echo $ride['id']; ?>" class="btn btn-secondary font-weight-bold">
                  <i class="fas fa-times mr-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-warning font-weight-bold text-dark px-4">
                  <i class="fas fa-save mr-1"></i> Save Changes
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>

    </div>
  </section>
</div>

<?php require_once '../includes/footer.php'; ?>
