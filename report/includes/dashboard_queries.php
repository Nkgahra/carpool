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
/*
|--------------------------------------------------------------------------
| Monthly Ride Analytics
|--------------------------------------------------------------------------
*/

$monthlyRideData = array_fill(0, 12, 0);

$sql = "
SELECT
    MONTH(created_at) AS month,
    COUNT(*) AS total
FROM rides
GROUP BY MONTH(created_at)
ORDER BY MONTH(created_at)
";

$result = $conn->query($sql);

if($result){

    while($row = $result->fetch_assoc()){

        $month = (int)$row['month'];

        $monthlyRideData[$month-1] = (int)$row['total'];

    }

}
/*
|--------------------------------------------------------------------------
| Analytics Summary
|--------------------------------------------------------------------------
*/

$analytics = [

    'rides' => 0,
    'bookings' => 0,
    'revenue' => 0

];

$sql = "SELECT COUNT(*) AS total
        FROM rides
        WHERE YEAR(ride_date)=YEAR(CURDATE())";

$result = $conn->query($sql);

if($result){
    $analytics['rides'] = $result->fetch_assoc()['total'];
}

$sql = "SELECT COUNT(*) AS total
        FROM ride_bookings
        WHERE YEAR(created_at)=YEAR(CURDATE())";

$result = $conn->query($sql);

if($result){
    $analytics['bookings'] = $result->fetch_assoc()['total'];
}

$sql = "SELECT SUM(total_fare) AS revenue
        FROM ride_bookings
        WHERE booking_status='Completed'
        AND YEAR(created_at)=YEAR(CURDATE())";

$result = $conn->query($sql);

if($result){
    $analytics['revenue'] = $result->fetch_assoc()['revenue'] ?? 0;
}
/*
|--------------------------------------------------------------------------
| Recent Bookings
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Recent Bookings
|--------------------------------------------------------------------------
*/

$recentBookings = [];

$sql = "
SELECT
    rb.booking_code,
    rb.total_fare,
    rb.created_at,

    u.full_name,

    r.pickup_address,
    r.destination_address,
    r.ride_date,
    r.ride_time,
    r.available_seats,
    r.status AS ride_status

FROM ride_bookings rb

INNER JOIN users u
    ON rb.passenger_id = u.id

INNER JOIN rides r
    ON rb.ride_id = r.id

ORDER BY rb.created_at DESC

LIMIT 5
";

$result = $conn->query($sql);

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $recentBookings[] = $row;

    }

}