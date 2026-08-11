<?php
/**
 * Admin Reusable Footer & Script Imports Component
 * Folder Location: admin/includes/footer.php
 */
?>
  <!-- Main Footer -->
  <footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-inline">
      <b>Version</b> 1.0.0
    </div>
    <strong>Car & Bike Pool Admin Panel &copy; <?php echo date('Y'); ?>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- Bootstrap 4.6 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
  $(document.body).ready(function() {
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
      $(".alert-dismissible").fadeOut('slow');
    }, 5000);
  });
</script>
</body>
</html>
