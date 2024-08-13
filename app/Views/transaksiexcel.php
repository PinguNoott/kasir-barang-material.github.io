<?php
require_once(ROOTPATH . 'Vendor/autoload.php'); // Adjust the path as necessary

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Create a new Spreadsheet instance
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Your Name')
    ->setTitle('Nota')
    ->setSubject('Nota');

// Set headers for the Excel file
$sheet->setCellValue('A1', 'Laporan Transaksi');
$sheet->mergeCells('A1:E1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

// Set website name and date range
$sheet->setCellValue('A2', isset($setting->judul_website) ? $setting->judul_website : 'Default Website');
$sheet->setCellValue('A3', 'Tanggal Transaksi: ' . (isset($startDate) ? $startDate : '0000-00-00') . ' - ' . (isset($endDate) ? $endDate : '9999-12-31'));

// Set table headers
$headers = ['No Transaksi', 'Kode', 'Jumlah Bayar', 'Pembeli', 'Tanggal'];
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '5', $header);
    $sheet->getStyle($col . '5')->getFont()->setBold(true);
    $sheet->getStyle($col . '5')->getAlignment()->setHorizontal('center');
    $col++;
}

// Add items and calculate total
$row = 6;
$totalAmount = 0;
foreach ($satu as $item) {
    $sheet->setCellValue('A' . $row, htmlspecialchars($item->no_transaksi, ENT_QUOTES, 'UTF-8'));
    $sheet->setCellValue('B' . $row, htmlspecialchars($item->kode_keranjang, ENT_QUOTES, 'UTF-8'));
    $sheet->setCellValue('C' . $row, 'Rp ' . number_format((float)$item->total_transaksi, 2, ',', '.'));
    $sheet->setCellValue('D' . $row, htmlspecialchars($item->username, ENT_QUOTES, 'UTF-8'));
    $sheet->setCellValue('E' . $row, htmlspecialchars($item->tanggal, ENT_QUOTES, 'UTF-8'));
    $totalAmount += (float)$item->total_transaksi; // Calculate total amount
    $row++;
}

// Add total row
$sheet->setCellValue('D' . $row, 'Total');
$sheet->setCellValue('E' . $row, 'Rp ' . number_format($totalAmount, 2, ',', '.'));
$sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
$sheet->getStyle('D' . $row . ':E' . $row)->getAlignment()->setHorizontal('right');

// Set table borders
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => 'FF000000'],
        ],
    ],
];

// Apply borders to the table only
$sheet->getStyle('A5:E' . ($row - 1))->applyFromArray($styleArray);

// Header styling
$sheet->getStyle('A5:E5')->applyFromArray([
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => 'FFFF00'], // Yellow background for header
    ],
]);

// Set column widths
foreach (range('A', 'E') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Create a new Writer instance
$writer = new Xlsx($spreadsheet);

// Format startDate and endDate for filename
$startDateFormatted = date('Y-m-d', strtotime($startDate));
$endDateFormatted = date('Y-m-d', strtotime($endDate));
$filename = 'nota_' . $startDateFormatted . 'to' . $endDateFormatted . '.xlsx';

// Output the Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Save the file to output
$writer->save('php://output');

// Exit the script
exit;
?>