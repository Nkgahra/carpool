<?php
/**
 * Admin Reusable Navbar Component
 * Folder Location: admin/includes/navbar.php
 */

// Determine base path for relative linking across root admin and subfolders (rides/ & bookings/)
$base_url = file_exists('dashboard.php') ? '' : '../';
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0 shadow-sm px-3">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button" title="Toggle Sidebar"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo $base_url; ?>dashboard.php" class="nav-link font-weight-bold">Dashboard</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto align-items-center">
    <!-- User Info Dropdown -->
    <li class="nav-item dropdown mr-2">
      <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" role="button">
        <i class="fas fa-user-circle fa-lg mr-2 text-primary"></i>
        <span class="font-weight-bold"><?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?></span>
        <i class="fas fa-angle-down ml-1 text-xs"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow border-0">
        <span class="dropdown-header text-bold"><?php echo htmlspecialchars($_SESSION['admin_email'] ?? ''); ?></span>
        <div class="dropdown-divider"></div>
        <a href="<?php echo $base_url; ?>logout.php" class="dropdown-item text-danger">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
      </div>
    </li>

    <!-- Direct Logout Button -->
    <li class="nav-item">
      <a href="<?php echo $base_url; ?>logout.php" class="btn btn-outline-danger btn-sm font-weight-bold px-3" style="border-radius: 6px;" title="Logout">
        <i class="fas fa-sign-out-alt mr-1"></i> Logout
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
