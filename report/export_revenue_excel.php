<?php

require_once 'config/config.php';
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


/*
|--------------------------------------------------------------------------
| Create Spreadsheet
|--------------------------------------------------------------------------
*/

$spreadsheet = new Spreadsheet();

$sheet = $spreadsheet->getActiveSheet();

$sheet->setTitle('Revenue Report');


/*
|--------------------------------------------------------------------------
| Report Title
|--------------------------------------------------------------------------
*/

$sheet->mergeCells('A1:F1');

$sheet->setCellValue(
    'A1',
    'CarPool - Revenue Report'
);

$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

$sheet->getStyle('A1')->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);


/*
|--------------------------------------------------------------------------
| Column Headers
|--------------------------------------------------------------------------
*/

$headers = [
    'Booking ID',
    'Passenger',
    'Route',
    'Fare',
    'Status',
    'Date'
];

$column = 'A';

foreach ($headers as $header) {

    $sheet->setCellValue(
        $column . '3',
        $header
    );

    $column++;
}


/*
|--------------------------------------------------------------------------
| Header Styling
|--------------------------------------------------------------------------
*/

$headerStyle = $sheet->getStyle('A3:F3');

$headerStyle->getFont()->setBold(true);

$headerStyle->getFill()
    ->setFillType(Fill::FILL_SOLID)
    ->setStartColor(new \PhpOffice\PhpSpreadsheet\Style\Color('7C3AED'));

$headerStyle->getFont()
    ->getColor()
    ->setARGB('FFFFFF');

$headerStyle->getAlignment()
    ->setHorizontal(Alignment::HORIZONTAL_CENTER);


/*
|--------------------------------------------------------------------------
| Get ALL Revenue Records
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
    die('Export failed: ' . $conn->error);
}


/*
|--------------------------------------------------------------------------
| Add Data
|--------------------------------------------------------------------------
*/

$rowNumber = 4;

while ($row = $result->fetch_assoc()) {

    $route =
        $row['pickup_address']
        . ' → '
        . $row['destination_address'];

    $sheet->setCellValue(
        'A' . $rowNumber,
        $row['booking_code']
    );

    $sheet->setCellValue(
        'B' . $rowNumber,
        $row['full_name']
    );

    $sheet->setCellValue(
        'C' . $rowNumber,
        $route
    );

    $sheet->setCellValue(
        'D' . $rowNumber,
        (float) $row['total_fare']
    );

    $sheet->setCellValue(
        'E' . $rowNumber,
        ucfirst($row['booking_status'])
    );

    $sheet->setCellValue(
        'F' . $rowNumber,
        date(
            'd M Y',
            strtotime($row['created_at'])
        )
    );

    $rowNumber++;
}


/*
|--------------------------------------------------------------------------
| Currency Formatting
|--------------------------------------------------------------------------
*/

if ($rowNumber > 4) {

    $sheet->getStyle(
        'D4:D' . ($rowNumber - 1)
    )->getNumberFormat()
      ->setFormatCode('₹#,##0.00');
}


/*
|--------------------------------------------------------------------------
| Borders
|--------------------------------------------------------------------------
*/

if ($rowNumber > 4) {

    $sheet->getStyle(
        'A3:F' . ($rowNumber - 1)
    )->getBorders()
      ->getAllBorders()
      ->setBorderStyle(
          Border::BORDER_THIN
      );
}


/*
|--------------------------------------------------------------------------
| Column Widths
|--------------------------------------------------------------------------
*/

$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(25);
$sheet->getColumnDimension('C')->setWidth(55);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(18);
$sheet->getColumnDimension('F')->setWidth(18);


/*
|--------------------------------------------------------------------------
| Download Excel File
|--------------------------------------------------------------------------
*/

$filename = 'carpool_revenue_report.xlsx';

header(
    'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
);

header(
    'Content-Disposition: attachment; filename="' . $filename . '"'
);

header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);

$writer->save('php://output');

exit;