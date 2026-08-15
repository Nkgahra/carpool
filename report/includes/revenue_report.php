<?php

/*
|--------------------------------------------------------------------------
| Revenue Report
|--------------------------------------------------------------------------
| Uses:
| ride_bookings
| rides
| users
|--------------------------------------------------------------------------
*/

$revenueData = [];

$totalRevenue = 0;
$averageFare = 0;
$completedTrips = 0;
$totalTransactions = 0;

$revenueTrendLabels = [];
$revenueTrendData = [];

$routeLabels = [];
$routeRevenueData = [];


// --------------------------------------------------
// DATE RANGE
// --------------------------------------------------

$range = $_GET['range'] ?? '30';

$rangeCondition = "";

if ($range !== 'all') {

    $days = (int)$range;

    if ($days > 0) {

        $rangeCondition = "
            AND rb.created_at >= DATE_SUB(
                CURDATE(),
                INTERVAL $days DAY
            )
        ";

    }

}


// --------------------------------------------------
// REVENUE DETAILS
// --------------------------------------------------

$sql = "
SELECT

    rb.booking_code,
    rb.total_fare,
    rb.created_at,

    u.full_name,

    r.pickup_address,
    r.destination_address,
    r.status AS ride_status

FROM ride_bookings rb

INNER JOIN users u
    ON rb.passenger_id = u.id

INNER JOIN rides r
    ON rb.ride_id = r.id

WHERE 1=1

$rangeCondition

ORDER BY rb.created_at DESC

";


$result = $conn->query($sql);


if ($result) {

    while ($row = $result->fetch_assoc()) {

        $fare = (float)$row['total_fare'];

        $totalRevenue += $fare;

        $totalTransactions++;

        if (
            strtolower(trim($row['ride_status'])) === 'completed'
        ) {

            $completedTrips++;

        }


        $revenueData[] = $row;

    }

}


// --------------------------------------------------
// AVERAGE FARE
// --------------------------------------------------

if ($totalTransactions > 0) {

    $averageFare = $totalRevenue / $totalTransactions;

}


// --------------------------------------------------
// REVENUE TREND
// --------------------------------------------------

$trendSql = "
SELECT

    DATE(rb.created_at) AS report_date,

    SUM(rb.total_fare) AS daily_revenue

FROM ride_bookings rb

INNER JOIN rides r
    ON rb.ride_id = r.id

WHERE 1=1

$rangeCondition

GROUP BY DATE(rb.created_at)

ORDER BY report_date ASC
";


$trendResult = $conn->query($trendSql);


if ($trendResult) {

    while ($row = $trendResult->fetch_assoc()) {

        $revenueTrendLabels[] =
            date(
                'd M',
                strtotime($row['report_date'])
            );

        $revenueTrendData[] =
            (float)$row['daily_revenue'];

    }

}


// --------------------------------------------------
// REVENUE BY ROUTE
// --------------------------------------------------

$routeSql = "
SELECT

    CONCAT(
        r.pickup_address,
        ' → ',
        r.destination_address
    ) AS route,

    SUM(rb.total_fare) AS route_revenue

FROM ride_bookings rb

INNER JOIN rides r
    ON rb.ride_id = r.id

WHERE 1=1

$rangeCondition

GROUP BY
    r.id,
    r.pickup_address,
    r.destination_address

ORDER BY route_revenue DESC

LIMIT 10
";


$routeResult = $conn->query($routeSql);


if ($routeResult) {

    while ($row = $routeResult->fetch_assoc()) {

        $routeLabels[] =
            $row['route'];

        $routeRevenueData[] =
            (float)$row['route_revenue'];

    }

}

?>