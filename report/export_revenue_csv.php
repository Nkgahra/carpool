<?php

require_once 'config/config.php';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=revenue_report.csv');

$output = fopen('php://output', 'w');

/*
|--------------------------------------------------------------------------
| CSV Header
|--------------------------------------------------------------------------
*/

fputcsv($output, [
    'Booking ID',
    'Passenger',
    'Route',
    'Fare',
    'Status',
    'Date'
]);

/*
|--------------------------------------------------------------------------
| Get Revenue Data
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        rb.booking_code,
        u.full_name,
        r.pickup_address,
        r.destination_address,
        rb.total_fare,
        rb.booking_status,
        rb.created_at

    FROM ride_bookings rb

    INNER JOIN users u
        ON rb.passenger_id = u.id

    INNER JOIN rides r
        ON rb.ride_id = r.id

    ORDER BY rb.created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("Export failed: " . $conn->error);
}

/*
|--------------------------------------------------------------------------
| Add Data Rows
|--------------------------------------------------------------------------
*/

while ($row = $result->fetch_assoc()) {

    $route =
        $row['pickup_address']
        . ' → '
        . $row['destination_address'];

    fputcsv($output, [

        $row['booking_code'],

        $row['full_name'],

        $route,

        number_format(
            (float)$row['total_fare'],
            2,
            '.',
            ''
        ),

        ucfirst($row['booking_status']),

        date(
            'd M Y',
            strtotime($row['created_at'])
        )
    ]);
}

fclose($output);

exit;