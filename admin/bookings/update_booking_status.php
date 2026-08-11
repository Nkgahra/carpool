<?php
/**
 * Update Booking Status Controller Script
 * Module: Ride & Booking Management
 * Location: admin/bookings/update_booking_status.php
 */

require_once '../../config/database.php';
require_once '../includes/session.php';

// ---------------------------------------------------------
// 1. ADMIN SESSION VALIDATION
// ---------------------------------------------------------
check_admin_login();

// ---------------------------------------------------------
// 2. INPUT RETRIEVAL & PARAMETER VALIDATION
// ---------------------------------------------------------
$booking_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$status = trim($_GET['status'] ?? '');

// Whitelist of allowed booking status values matching database enum
$allowed_statuses = ['Pending', 'Accepted', 'Rejected', 'Cancelled', 'Completed'];

// Validate ID and status parameter against whitelist
if ($booking_id <= 0 || !in_array($status, $allowed_statuses, true)) {
    set_flash_message('danger', 'Unable to update booking status.');
    $redirect_url = ($booking_id > 0) ? "view_booking.php?id={$booking_id}" : "booking_list.php";
    header("Location: {$redirect_url}");
    exit();
}

// ---------------------------------------------------------
// 3. VERIFY BOOKING EXISTS IN DATABASE
// ---------------------------------------------------------
$check_stmt = $conn->prepare("SELECT id FROM ride_bookings WHERE id = ? LIMIT 1");
$booking_exists = false;

if ($check_stmt) {
    $check_stmt->bind_param("i", $booking_id);
    $check_stmt->execute();
    $check_res = $check_stmt->get_result();
    if ($check_res && $check_res->num_rows === 1) {
        $booking_exists = true;
    }
    $check_stmt->close();
}

if (!$booking_exists) {
    set_flash_message('danger', 'Unable to update booking status.');
    header("Location: booking_list.php");
    exit();
}

// ---------------------------------------------------------
// 4. PREPARED SQL UPDATE STATEMENT
// ---------------------------------------------------------
$stmt = $conn->prepare("UPDATE ride_bookings SET booking_status = ? WHERE id = ? LIMIT 1");

if ($stmt) {
    $stmt->bind_param("si", $status, $booking_id);

    if ($stmt->execute()) {
        set_flash_message('success', 'Booking status updated successfully.');
    } else {
        set_flash_message('danger', 'Unable to update booking status.');
    }
    $stmt->close();
} else {
    set_flash_message('danger', 'Unable to update booking status.');
}

// ---------------------------------------------------------
// 5. REDIRECT BACK TO VIEW BOOKING PAGE
// ---------------------------------------------------------
header("Location: view_booking.php?id={$booking_id}");
exit();
?>
