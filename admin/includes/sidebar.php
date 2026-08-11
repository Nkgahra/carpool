<?php
/**
 * Admin Reusable Sidebar Component
 * Folder Location: admin/includes/sidebar.php
 */

// Determine base path for relative linking across root admin and subfolders (rides/ & bookings/)
$base_url = file_exists('dashboard.php') ? '' : '../';

// Get current filename for active menu item highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo $base_url; ?>dashboard.php" class="brand-link text-center">
    <i class="fas fa-car-side text-primary mr-2"></i>
    <span class="brand-text font-weight-bold">Pool Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image">
        <i class="fas fa-user-circle fa-2x text-light"></i>
      </div>
      <div class="info">
        <a href="#" class="d-block font-weight-bold"><?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Administrator'); ?></a>
        <small class="text-success"><i class="fas fa-circle text-xs mr-1"></i> Online</small>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- Dashboard Link -->
        <li class="nav-item" data-title="Dashboard">
          <a href="<?php echo $base_url; ?>dashboard.php" class="nav-link <?php echo ($current_page === 'dashboard.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header">MANAGEMENT MODULES</li>

        <!-- Ride Management Link -->
        <li class="nav-item" data-title="Ride Management">
          <a href="<?php echo $base_url; ?>rides/ride_list.php" class="nav-link <?php echo in_array($current_page, ['ride_list.php', 'view_ride.php', 'edit_ride.php', 'update_ride_status.php']) ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-car"></i>
            <p>Ride Management</p>
          </a>
        </li>

        <!-- Booking Management Link -->
        <li class="nav-item" data-title="Booking Management">
          <a href="<?php echo $base_url; ?>bookings/booking_list.php" class="nav-link <?php echo in_array($current_page, ['booking_list.php', 'view_booking.php', 'update_booking_status.php']) ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-calendar-check"></i>
            <p>Booking Management</p>
          </a>
        </li>

        <li class="nav-header">ACCOUNT</li>

        <!-- Logout Link -->
        <li class="nav-item" data-title="Logout">
          <a href="<?php echo $base_url; ?>logout.php" class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
