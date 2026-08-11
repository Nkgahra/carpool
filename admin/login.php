<?php
/**
 * Admin Login Page
 * Folder Location: admin/login.php
 */

require_once '../config/database.php';
require_once 'includes/session.php';

// If already logged in, redirect to dashboard
if (is_admin_logged_in()) {
    header("Location: dashboard.php");
    exit();
}

$error_message = '';

// Handle Login Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error_message = "Please fill in both email and password fields.";
    } else {
        // Prepared statement to fetch admin user securely
        $stmt = $conn->prepare("SELECT id, name, email, password, role, status FROM admins WHERE email = ? LIMIT 1");
        
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $admin = $result->fetch_assoc();

                // Check if account is active
                if ($admin['status'] != 1) {
                    $error_message = "Your admin account is inactive. Contact Super Admin.";
                } 
                // Verify hashed password
                elseif (password_verify($password, $admin['password'])) {
                    // Set session parameters
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['name'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $_SESSION['admin_role'] = $admin['role'];

                    set_flash_message('success', 'Welcome back, ' . $admin['name'] . '!');
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error_message = "Invalid email or password.";
                }
            } else {
                $error_message = "Invalid email or password.";
            }

            $stmt->close();
        } else {
            $error_message = "Database query error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Car & Bike Pool</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE & Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page bg-light">
<div class="login-box">
    <!-- Login Logo -->
    <div class="login-logo text-center mb-3">
        <a href="#"><b>Car & Bike Pool</b> Admin</a>
    </div>

    <!-- Login Card -->
    <div class="card card-outline card-primary shadow">
        <div class="card-header text-center">
            <h3 class="card-title text-bold float-none mb-0">Sign In to Admin Panel</h3>
        </div>
        <div class="card-body login-card-body">

            <?php display_flash_message(); ?>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i> <?php echo htmlspecialchars($error_message); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <!-- Email Input -->
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block text-bold">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </button>
                    </div>
                </div>
            </form>

            <div class="text-center mt-3 text-muted text-sm">
                <small>Default Email: <code>admin@gmail.com</code> | Password: <code>admin123</code></small>
            </div>
        </div>
    </div>
</div>

<!-- jQuery & Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
