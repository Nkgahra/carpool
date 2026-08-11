<?php
/**
 * Update Ride Status Controller Script
 * Module: Ride & Booking Management
 * Location: admin/rides/update_ride_status.php
 */

require_once '../../config/database.php';
require_once '../includes/session.php';

// ---------------------------------------------------------
// 1. ADMIN SESSION VALIDATION
// ---------------------------------------------------------
check_admin_login();

// ---------------------------------------------------------
// 2. INPUT RETRIEVAL & VALIDATION
// ---------------------------------------------------------
$ride_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$status_input = trim($_GET['status'] ?? '');
$status_lower = strtolower($status_input);

// Allowed status whitelist matching database column enum
$allowed_statuses = ['active', 'full', 'driver_reached', 'started', 'completed', 'cancelled'];

if ($ride_id <= 0 || empty($status_input) || !in_array($status_lower, $allowed_statuses)) {
    set_flash_message('danger', 'Unable to update ride status. Invalid parameters provided.');
    $redirect_url = ($ride_id > 0) ? "view_ride.php?id={$ride_id}" : "ride_list.php";
    header("Location: {$redirect_url}");
    exit();
}

// ---------------------------------------------------------
// 3. PREPARED UPDATE STATEMENT
// ---------------------------------------------------------
$stmt = $conn->prepare("UPDATE rides SET status = ? WHERE id = ? LIMIT 1");

if ($stmt) {
    $stmt->bind_param("si", $status_lower, $ride_id);

    if ($stmt->execute() && $stmt->affected_rows >= 0) {
        set_flash_message('success', 'Ride status updated successfully.');
    } else {
        set_flash_message('danger', 'Unable to update ride status.');
    }
    $stmt->close();
} else {
    set_flash_message('danger', 'Unable to update ride status.');
}

// ---------------------------------------------------------
// 4. REDIRECT
// ---------------------------------------------------------
$referer = $_SERVER['HTTP_REFERER'] ?? "view_ride.php?id={$ride_id}";
header("Location: view_ride.php?id={$ride_id}");
exit();
?>
