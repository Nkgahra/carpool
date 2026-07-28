<?php

require_once __DIR__ . '/../config/config.php';

/*
|--------------------------------------------------------------------------
| Dashboard Statistics
|--------------------------------------------------------------------------
*/

// Total Users
$totalUsers = 0;

$sql = "SELECT COUNT(*) AS total FROM users";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $totalUsers = $row['total'];
}


// Active Rides
$totalActiveRides = 0;

$sql = "SELECT COUNT(*) AS total FROM rides WHERE status='active'";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $totalActiveRides = $row['total'];
}


// Total Bookings
$totalBookings = 0;

$sql = "SELECT COUNT(*) AS total FROM ride_bookings";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $totalBookings = $row['total'];
}


// Total Revenue
$totalRevenue = 0;

$sql = "SELECT SUM(total_fare) AS revenue
        FROM ride_bookings
        WHERE booking_status='Completed'";

$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $totalRevenue = $row['revenue'] ?? 0;
}
/*
|--------------------------------------------------------------------------
| Recent Activity
|--------------------------------------------------------------------------
*/

$recentActivities = [];

/*
|-------------------------------------------------
| New Users
|-------------------------------------------------
*/
$sql = "SELECT
            full_name,
            created_at
        FROM users
        ORDER BY created_at DESC
        LIMIT 5";

$result = $conn->query($sql);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $recentActivities[] = [
            'icon' => 'bi-person-plus-fill',
            'color' => 'primary',
            'title' => 'New User Registered',
            'description' => $row['full_name'],
            'time' => strtotime($row['created_at'])
        ];
    }
}


/*
|-------------------------------------------------
| New Rides
|-------------------------------------------------
*/

$sql = "SELECT
            pickup_address,
            destination_address,
            created_at
        FROM rides
        ORDER BY created_at DESC
        LIMIT 5";

$result = $conn->query($sql);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $recentActivities[] = [
            'icon' => 'bi-car-front-fill',
            'color' => 'success',
            'title' => 'New Ride Created',
            'description' => $row['pickup_address'] . ' → ' . $row['destination_address'],
            'time' => strtotime($row['created_at'])
        ];
    }
}


/*
|-------------------------------------------------
| New Bookings
|-------------------------------------------------
*/

$sql = "SELECT
            booking_code,
            created_at
        FROM ride_bookings
        ORDER BY created_at DESC
        LIMIT 5";

$result = $conn->query($sql);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $recentActivities[] = [
            'icon' => 'bi-calendar-check-fill',
            'color' => 'warning',
            'title' => 'New Booking',
            'description' => $row['booking_code'],
            'time' => strtotime($row['created_at'])
        ];
    }
}


/*
|--------------------------------------------------------------------------
| Sort Latest First
|--------------------------------------------------------------------------
*/

usort($recentActivities, function ($a, $b) {

    return $b['time'] - $a['time'];

});

$recentActivities = array_slice($recentActivities, 0, 5);
